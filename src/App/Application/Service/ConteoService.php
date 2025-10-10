<?php

namespace App\Application\Service;

use App\Application\Interface\Service\IConteoService;
use App\Domain\DTO\ConteoDTO;
use App\Domain\DTO\StockDTO;
use App\Domain\Model\Conteo;
use Exception;
use App\Shared\Mapper\Mapper;
use App\Infrastructure\Database\Connection;
use App\Infrastructure\Repository\AlmacenesLocalizacionesRepository;
use App\Infrastructure\Repository\ConteoRepository;
use App\Infrastructure\Repository\InformacionSapMB52Repository;
use App\Infrastructure\Repository\StockRepository;
use App\Infrastructure\Repository\InformacionSapWMRepository;
use App\Infrastructure\Repository\PartNumbersRepository;
use App\Infrastructure\Repository\AlmacenesRepository;
use App\Infrastructure\Repository\LocalizacionesRepository;
use App\Infrastructure\Repository\UMBRepository;

class ConteoService implements IConteoService
{

    private $db;
    private $conteoRepository;
    private $MB52Repository;
    private $WMRepository;
    private $stockRepository;
    private $PartNumberRepository;
    private $AlmacenRepository;
    private $LocalizacionRepository;
    private $UmbRepository;
    private $localizacionesAlmacenesRepository;

    public function __construct()
    {
        $this->db = (new Connection())->dbInventarioHwi;
        $this->conteoRepository = new ConteoRepository($this->db);
        $this->MB52Repository = new InformacionSapMB52Repository($this->db);
        $this->WMRepository = new InformacionSapWMRepository($this->db);
        $this->stockRepository = new StockRepository($this->db);
        $this->PartNumberRepository = new PartNumbersRepository($this->db);
        $this->AlmacenRepository = new AlmacenesRepository($this->db);
        $this->LocalizacionRepository = new LocalizacionesRepository($this->db);
        $this->UmbRepository = new UMBRepository($this->db);
        $this->localizacionesAlmacenesRepository = new AlmacenesLocalizacionesRepository($this->db);
    }

    public function onGetConteo_By__Fecha_Reciente_Grupo($id_grupo): ConteoDTO
    {
        $conteo = $this->conteoRepository->onGetConteo_By__Fecha_Reciente_Grupo($id_grupo);
        $conteoDTO = Mapper::modelTOConteoDTO($conteo);
        return $conteoDTO;
    }

    public function onGetInfo_Conteo_By_Grupo($id_grupo): ConteoDTO
    {
        // Iniciar transacción para validar todo el flujo
        $this->db->beginTransaction();

        try {
            // 1. Consultar el id del conteo más reciente de este grupo:
            $conteoReciente = $this->conteoRepository->onGetConteo_By__Fecha_Reciente_Grupo($id_grupo);
            if ($conteoReciente === null) {
                throw new Exception("Error al obtener el conteo reciente para el grupo {$id_grupo}.");
            }
            $id_conteo = $conteoReciente->id_conteo ?? null;
            if (!$id_conteo) {
                throw new Exception("No se obtuvo id_conteo válido para el grupo {$id_grupo}.");
            }

            // 2. Consultar la información de la tabla stock relacionada a el id_grupo y el id_conteo
            $infoStock = $this->stockRepository->onGet__By_Id_Grupo_Id_Conteo($id_grupo, $id_conteo);

            // Si la consulta devolvió null consideramos que hubo un fallo y abortamos
            if ($infoStock === null) {
                throw new Exception("Error al consultar infoStock para id_grupo {$id_grupo}, id_conteo {$id_conteo}.");
            }

            // Normalizar infoStock a array (si es iterador/objeto)
            if ($infoStock instanceof \Traversable) {
                $infoStock = iterator_to_array($infoStock);
            } elseif (!is_array($infoStock)) {
                $infoStock = $infoStock ? (array) $infoStock : [];
            }
            $infoStock = array_values($infoStock);

            // --- Obtener IDs de MB52 desde el stock ---
            $idsMB52 = [];
            foreach ($infoStock as $item) {
                $id = null;
                if (is_array($item) && isset($item['id_informacion_sap_mb52_stock'])) {
                    $id = $item['id_informacion_sap_mb52_stock'];
                } elseif (is_object($item) && isset($item->id_informacion_sap_mb52_stock)) {
                    $id = $item->id_informacion_sap_mb52_stock;
                } elseif (is_array($item) && isset($item['id_informacion_sap_mb52'])) {
                    $id = $item['id_informacion_sap_mb52'];
                }
                if ($id !== null && $id !== '') $idsMB52[] = $id;
            }
            $idsMB52 = array_values(array_unique($idsMB52));

            // --- CONSULTAR MB52 ---
            $infoMB52 = [];
            /*  foreach ($idsMB52 as $singleId) { */
            $single = $this->MB52Repository->onGet(); // Asumo que existe este método para buscar por ID
            if ($single === null) {
                throw new Exception("Error al consultar MB52");
            }
            if ($single !== false) {
                if (is_array($single)) {
                    $infoMB52 = array_merge($infoMB52, $single);
                } else {
                    $infoMB52[] = $single;
                }
            }
            /*  } */
            $infoMB52 = array_values($infoMB52);

            // --- Obtener IDs de Part Numbers y Almacenes desde la información de MB52 ---
            $idsPartNumbers = [];
            $idsAlmacenes = [];
            foreach ($infoMB52 as $mbItem) {
                $idsPartNumbers[] = is_array($mbItem) ? $mbItem['id_part_number_informacion_sap_mb52'] : $mbItem->id_part_number_informacion_sap_mb52;
                $idsAlmacenes[] = is_array($mbItem) ? $mbItem['id_almacen_informacion_sap_mb52'] : $mbItem->id_almacen_informacion_sap_mb52;
            }
            $idsPartNumbers = array_values(array_unique(array_filter($idsPartNumbers, fn($v) => $v !== null && $v !== '')));
            $idsAlmacenes = array_values(array_unique(array_filter($idsAlmacenes, fn($v) => $v !== null && $v !== '')));

            // --- CONSULTAR TABLA DE PART NUMBERS ---
            $infoPartNumbers = [];
            foreach ($idsPartNumbers as $partNumberId) {
                $partNumberData = $this->PartNumberRepository->onGet_By__Id($partNumberId);
                if ($partNumberData !== false && $partNumberData !== null) {
                    $infoPartNumbers[] = $partNumberData;
                }
            }

            // --- CONSULTAR TABLA DE ALMACENES ---
            $infoAlmacenes = [];
            foreach ($idsAlmacenes as $almacenId) {
                $almacenData = $this->AlmacenRepository->onGet_By__Id($almacenId); // Asumo este método
                if ($almacenData !== false && $almacenData !== null) {
                    $infoAlmacenes[] = $almacenData;
                }
            }

            // --- CONSULTAR WM con ids de MB52 ---
            $infoWM = [];
            /* foreach ($idsMB52 as $singleId) { */
            $wmData = $this->WMRepository->onGet();
            if ($wmData === null) {
                throw new Exception("Error al consultar WM.");
            }
            if ($wmData !== false && $wmData !== null) {
                if (is_array($wmData)) {
                    $infoWM = array_merge($infoWM, $wmData);
                } else {
                    $infoWM[] = $wmData;
                }
            }
            /* } */
            $infoWM = array_values($infoWM);

            // --- Obtener IDs de Localizaciones desde la información de WM ---
            $idsLocalizaciones = [];
            foreach ($infoWM as $wmItem) {
                $idsLocalizaciones[] = is_array($wmItem) ? $wmItem['id_localizacion_informacion_sap_wm'] : $wmItem->id_localizacion_informacion_sap_wm;
            }
            $idsLocalizaciones = array_values(array_unique(array_filter($idsLocalizaciones, fn($v) => $v !== null && $v !== '')));

            // --- CONSULTAR TABLA DE LOCALIZACIONES ---
            $infoLocalizaciones = [];
            foreach ($idsLocalizaciones as $localizacionId) {
                $localizacionData = $this->LocalizacionRepository->onGet_By__Id($localizacionId); // Asumo este método
                if ($localizacionData !== false && $localizacionData !== null) {
                    $infoLocalizaciones[] = $localizacionData;
                }
            }

            // --- Consultar toda la información de la tabla localizaciones_almacenes ---
            $localizacionesAlmacenesData = $this->localizacionesAlmacenesRepository->onGet();

            if ($localizacionesAlmacenesData === null) {
                throw new Exception("Error al consultar la tabla de localizaciones_almacenes.");
            }

            // Asegurar que el resultado sea siempre un array para su manejo
            if ($localizacionesAlmacenesData !== false) {
                // Si el resultado no es ya un array, lo convertimos
                if (!is_array($localizacionesAlmacenesData)) {
                    $localizacionesAlmacenesData = [$localizacionesAlmacenesData];
                }
            } else {
                // Si la consulta devolvió false, asumimos un array vacío
                $localizacionesAlmacenesData = [];
            }

            // Asignamos el resultado final a una variable con un nombre claro
            $infoLocalizacionesAlmacenes = array_values($localizacionesAlmacenesData);

            // ---CONSULTAR TABLA inventario_hwi_umb ---
            $infoInventarioHwiUmb = [];
            $umbs = $this->UmbRepository->onGet();
            if ($umbs === null) {
                throw new Exception("Error al consultar las unidades de medida.");
            }
            if ($umbs !== false && $umbs !== null) {
                if ($umbs instanceof \Traversable) {
                    $umbs = iterator_to_array($umbs);
                } elseif (!is_array($umbs)) {
                    $umbs = $umbs ? (array) $umbs : [];
                }

                // Filtrar/normalizar: eliminar elementos booleanos falsos y reindexar
                foreach ($umbs as $itm) {
                    if ($itm === false || $itm === null) continue;
                    $infoInventarioHwiUmb[] = $itm;
                }
                $infoInventarioHwiUmb = array_values($infoInventarioHwiUmb);
            }

            // 3. Construir el ConteoDTO final
            $conteoDTO = new ConteoDTO();
            $conteoDTO->infoStock = $infoStock;
            $conteoDTO->infoMB52  = $infoMB52;
            $conteoDTO->infoWM    = $infoWM;
            $conteoDTO->infoPartNumbers = $infoPartNumbers;
            $conteoDTO->infoAlmacenes = $infoAlmacenes;
            $conteoDTO->infoLocalizaciones = $infoLocalizaciones;
            $conteoDTO->infoInventarioHwiUmb = $infoInventarioHwiUmb;
            $conteoDTO->infoLocalizacionesAlmacenes = $infoLocalizacionesAlmacenes;
            // Si todo salió bien, confirmamos la transacción
            $this->db->commit();

            return $conteoDTO;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function updateConteo(ConteoDTO $ConteoDTO): bool
    {
        $Conteo = Mapper::ConteoDTOToModel($ConteoDTO);
        $guardarConteo = $this->conteoRepository->update($Conteo);

        if (!$guardarConteo) {
            return false;
        } else {
            return true;
        }
    }
}
