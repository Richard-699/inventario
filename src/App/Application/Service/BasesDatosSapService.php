<?php

namespace App\Application\Service;

use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Application\Interface\Service\IBasesDatosSapService;
use App\Domain\DTO\InformacionSapMB52DTO;
use App\Domain\DTO\InformacionSapWMDTO;
use App\Domain\Model\Almacenes;
use App\Domain\Model\InformacionSapMb52;
use App\Domain\Model\InformacionSapWM;
use Exception;
use App\Shared\Mapper\Mapper;
use App\Infrastructure\Database\Connection;
use App\Infrastructure\Repository\InformacionSapMb52Repository;
use App\Infrastructure\Repository\PartNumbersRepository;
use App\Infrastructure\Repository\AlmacenesRepository;
use App\Infrastructure\Repository\informacionSapWMRepository;
use App\Infrastructure\Repository\LocalizacionesRepository;
use App\Shared\Util\Utilidades;

class BasesDatosSapService implements IBasesDatosSapService
{

    private $db;
    private $partNumberRepository;
    private $almacenRepository;
    private $localizacionesRepository;
    private $informacionSapMB52Repository;
    private $informacionSapWMRepository;

    public function __construct()
    {
        $this->db = (new Connection())->dbInventarioHwi;
        $this->partNumberRepository = new PartNumbersRepository($this->db);
        $this->almacenRepository = new AlmacenesRepository($this->db);
        $this->informacionSapMB52Repository = new InformacionSapMB52Repository($this->db);
        $this->informacionSapWMRepository = new informacionSapWMRepository($this->db);
        $this->localizacionesRepository = new LocalizacionesRepository($this->db);
    }

    public function procesarArchivosExcel(array $mb52File, array $wmFile, array $cero016File): void
    {
        // 1. Iniciar la transacción.
        try {
            $this->db->beginTransaction();
            // 2. Procesar todos los archivos.
            $this->procesarArchivo($mb52File, $this->informacionSapMB52Repository, 'mb52');
            $this->procesarArchivo($wmFile, $this->informacionSapWMRepository, 'wm');
            $this->procesarArchivo($cero016File, $this->informacionSapWMRepository, 'cero016');

            // 3. Confirmar la transacción (commit).
            $this->db->commit();
        } catch (Exception $e) {
            // 4. Revertir la transacción (rollback).
            $this->db->rollBack();

            // 5. Relanzar la excepción.
            throw new Exception("Error al procesar los archivos. La transacción ha sido revertida. Detalles: " . $e->getMessage());
        }
    }

    public function procesarArchivo(array $archivo, object $repositorio, string $tipo): void
    {
        $spreadsheet = IOFactory::load($archivo['tmp_name']);

        // 1. Definir nombre de hoja por tipo
        $hojasPorTipo = [
            'mb52' => 'SAP MB52',
            'wm' => 'SAP WM',
            'cero016' => 'SAP 0016'
        ];

        // 2. Validar tipo
        if (!isset($hojasPorTipo[$tipo])) {
            throw new Exception("Tipo de archivo no reconocido: $tipo");
        }

        // 3. Obtener la hoja específica
        $sheetName = $hojasPorTipo[$tipo];
        $sheet = $spreadsheet->getSheetByName($sheetName);
        if (!$sheet) {
            throw new Exception("No se encontró la hoja '$sheetName' en el archivo Excel.");
        }
        $sheet->getStyle('A1:Z1000')->getNumberFormat()->setFormatCode('@'); // Forzar modo texto
        $filas = $sheet->toArray();
        date_default_timezone_set('America/Bogota');
        // 1. Filtrar filas vacías o donde la columna clave (PartNumber) está vacía
        $filasFiltradas = array_filter($filas, function ($fila, $index) {
            // Ignora encabezado
            if ($index === 0) return false;
            // Si la fila está completamente vacía
            if (empty(array_filter($fila))) return false;
            // Si la columna clave (PartNumber) está vacía
            if (empty(trim($fila[0] ?? ''))) return false;
            return true;
        }, ARRAY_FILTER_USE_BOTH);

        // 2. Iterar sobre las filas filtradas
        foreach ($filasFiltradas as $fila) {
            try {
                switch ($tipo) {
                    case 'mb52':
                        $codigoPartNumber = trim($fila[0] ?? '');
                        $nombreAlmacen = trim($fila[3] ?? '');
                        // Obtener ID del part number y su grupo
                        $partNumber = $this->partNumberRepository->onGet_By__Codigo($codigoPartNumber);
                        if (!$partNumber) {
                            $filaPreview = implode(' - ', array_slice($fila, 0, 2));
                            throw new Exception("No se encontró el Part Number '{$codigoPartNumber}' en la fila con datos: [{$filaPreview}]");
                        }
                        $idPartNumber = $partNumber->id_partnumber;
                        $idGrupo = $partNumber->id_grupo_partnumber;
                        // Obtener ID del almacén por nombre
                        $almacen = $this->almacenRepository->onGet_By__descripcion($nombreAlmacen);
                        if (!$almacen) {
                            $filaPreview = implode(' - ', array_slice($fila, 0, 2));
                            throw new Exception("No se encontró el Almacén '{$nombreAlmacen}' en la fila con datos: [{$filaPreview}]");
                        }
                        $idAlmacen = $almacen->id_almacen;

                        $raw = $fila[7] ?? '0';

                        // Si es numérico, conviértelo a string con strval para no perder decimales
                        if (is_numeric($raw)) {
                            $cantidadString = strval($raw);
                        } else {
                            $cantidadString = (string)$raw;
                        }
                        if (strpos($cantidadString, ',') !== false) {
                            $cantidadSinMiles = str_replace('.', '', $cantidadString);
                            $cantidadFinal = str_replace(',', '.', $cantidadSinMiles);
                        } else {
                            $cantidadFinal = $cantidadString;
                        }
                        $dto = new InformacionSapMb52DTO(
                            id_informacion_sap_mb52: Utilidades::generarGUID(),
                            fecha_registro_informacion_sap_mb52: date('Y-m-d'),
                            id_part_number_informacion_sap_mb52: $idPartNumber,
                            cantidad_informacion_sap_mb52: $cantidadFinal,
                            id_almacen_informacion_sap_mb52: $idAlmacen,
                            id_grupo_informacion_sap_mb52: $idGrupo
                        );
                        $mb52Model = Mapper::InformacionSapMB52DTOToModel($dto);
                        $repositorio->save($mb52Model);
                        break;

                    case 'wm':

                        $codigoPartNumberWM = trim($fila[0] ?? ''); //Consultar el id partnumber y el id grupo
                        // Obtener ID del part number y su grupo
                        $partNumberWM = $this->partNumberRepository->onGet_By__Codigo($codigoPartNumberWM);
                        if (!$partNumberWM) {
                            $filaPreview = implode(' - ', array_slice($fila, 0, 2));
                            throw new Exception("No se encontró el Part Number '{$codigoPartNumberWM}' en la fila con datos: [{$filaPreview}]");
                        }
                        $idPartNumberWM = $partNumberWM->id_partnumber;
                        $idGrupoWM = $partNumberWM->id_grupo_partnumber;

                        $nombreAlmacenWM = trim($fila[3] ?? ''); //Consultar el id en almacenes
                        // Obtener ID del almacén por nombre
                        $almacenWM = $this->almacenRepository->onGet_By__descripcion($nombreAlmacenWM);
                        if (!$almacenWM) {
                            $filaPreview = implode(' - ', array_slice($fila, 0, 2));
                            throw new Exception("No se encontró el Almacén '{$nombreAlmacenWM}' en la fila con datos: [{$filaPreview}]");
                        }
                        $idAlmacenWM = $almacenWM->id_almacen;
                        $nombreLocalizacionWM = trim($fila[8] ?? ''); //Consultar el id en Localizaciones
                        $localizacionWM = $this->localizacionesRepository->onGet_By__descripcion($nombreLocalizacionWM);
                        if (!$localizacionWM) {
                            $filaPreview = implode(' - ', array_slice($fila, 0, 2));
                            throw new Exception("No se encontró la Localización '{$nombreLocalizacionWM}' en la fila con datos: [{$filaPreview}]");
                        }
                        $idLocalizacionWM = $localizacionWM->id_localizacion;

                        $stock_disponible_sap_informacion_sap_wm = trim($fila[9] ?? '');
                        $stock_entrada_sap_informacion_sap_wm = trim($fila[10] ?? '');
                        $stock_salida_sap_informacion_sap_wm = trim($fila[11] ?? '');
                        // 1. Inicializar el ID de MB52 como null
                        $id_mb52_relacionado = null;

                        // 2. Definir el ID del almacén específico a comparar
                        $id_almacen_comparar = $idAlmacenWM;

                        // 3. Verificar si el almacén actual es el que nos interesa
                        if ($idAlmacenWM === $id_almacen_comparar) {
                            // 4. Buscar un registro de MB52 que coincida con el almacén y el part number
                            $mb52Record = $this->informacionSapMB52Repository->onGet_By__AlmacenAndPartNumber($id_almacen_comparar, $idPartNumberWM);

                            // 5. Si se encuentra un registro, guardar su ID
                            if ($mb52Record) {
                                $id_mb52_relacionado = $mb52Record->id_informacion_sap_mb52;
                            }
                        }
                        // 6. Crear el DTO de WM, incluyendo el ID de MB52 si se encontró
                        $dto = new InformacionSapWMDTO(
                            id_informacion_sap_wm: null,
                            id_part_number_informacion_sap_wm: $idPartNumberWM,
                            id_localizacion_informacion_sap_wm: $idLocalizacionWM,
                            id_grupo_informacion_sap_wm: $idGrupoWM,
                            id_informacion_sap_mb52_informacion_sap_wm: $id_mb52_relacionado,
                            stock_disponible_sap_informacion_sap_wm: $stock_disponible_sap_informacion_sap_wm,
                            stock_entrada_sap_informacion_sap_wm: $stock_entrada_sap_informacion_sap_wm,
                            stock_salida_sap_informacion_sap_wm: $stock_salida_sap_informacion_sap_wm
                        );

                        $wmModel = Mapper::InformacionSapWMDTOToModel($dto);
                        $repositorio->save($wmModel);
                        break;

                    case 'cero016':

                        $codigoPartNumber16 = trim($fila[9] ?? ''); //Consultar el id partnumber y el id grupo
                        // Obtener ID del part number y su grupo
                        $partNumber16 = $this->partNumberRepository->onGet_By__Codigo($codigoPartNumber16);
                        if (!$partNumber16) {
                            $filaPreview = implode(' - ', array_slice($fila, 0, 2));
                            throw new Exception("No se encontró el Part Number '{$codigoPartNumber16}' en la fila con datos: [{$filaPreview}]");
                        }
                        $idPartNumber16 = $partNumber16->id_partnumber;
                        $idGrupo16 = $partNumber16->id_grupo_partnumber;

                        $nombreAlmacen16 = "0016"; //Consultar el id en almacenes
                        // Obtener ID del almacén por nombre
                        $almacen16 = $this->almacenRepository->onGet_By__descripcion($nombreAlmacen16);
                        if (!$almacen16) {
                            $filaPreview = implode(' - ', array_slice($fila, 0, 2));
                            throw new Exception("No se encontró el Almacén '{$nombreAlmacen16}' en la fila con datos: [{$filaPreview}]");
                        }
                        $idAlmacen16 = $almacen16->id_almacen;

                        /* consultar id localizacion */
                        $SupEstante16 = trim($fila[6] ?? '');
                        $SupNivel16 = trim($fila[7] ?? '');
                        $SupPosicion16 = trim($fila[8] ?? '');
                        // Uniendo las tres variables con guiones para crear el nombre de la localización
                        $nombreLocalizacion16 = "{$SupEstante16}-{$SupNivel16}-{$SupPosicion16}";
                        $localizacion16 = $this->localizacionesRepository->onGet_By__descripcion($nombreLocalizacion16);
                        if (!$localizacion16) {
                            $filaPreview = implode(' - ', array_slice($fila, 0, 2));
                            throw new Exception("No se encontró la Localización '{$nombreLocalizacion16}' en la fila con datos: [{$filaPreview}]");
                        }
                        $idLocalizacion16 = $localizacion16->id_localizacion;

                        $stock_disponible_sap_informacion_sap_wm16 = trim($fila[12] ?? '');
                        $stock_entrada_sap_informacion_sap_wm16 = 0;
                        $stock_salida_sap_informacion_sap_wm16 = 0;
                        // 1. Inicializar el ID de MB52 como null
                        $id_mb52_relacionado16 = null;

                        // 2. Definir el ID del almacén específico a comparar
                        $id_almacen_comparar_16 = $idAlmacen16;

                        // 3. Verificar si el almacén actual es el que nos interesa
                        if ($idAlmacen16 === $id_almacen_comparar_16) {
                            // 4. Buscar un registro de MB52 que coincida con el almacén y el part number
                            $mb52Record = $this->informacionSapMB52Repository->onGet_By__AlmacenAndPartNumber($id_almacen_comparar_16, $idPartNumber16);

                            // 5. Si se encuentra un registro, guardar su ID
                            if ($mb52Record) {
                                $id_mb52_relacionado16 = $mb52Record->id_informacion_sap_mb52;
                            }
                        }
                        // 6. Crear el DTO de WM, incluyendo el ID de MB52 si se encontró
                        $dto = new InformacionSapWMDTO(
                            id_informacion_sap_wm: null,
                            id_part_number_informacion_sap_wm: $idPartNumber16,
                            id_localizacion_informacion_sap_wm: $idLocalizacion16,
                            id_grupo_informacion_sap_wm: $idGrupo16,
                            id_informacion_sap_mb52_informacion_sap_wm: $id_mb52_relacionado16,
                            stock_disponible_sap_informacion_sap_wm: $stock_disponible_sap_informacion_sap_wm16,
                            stock_entrada_sap_informacion_sap_wm: $stock_entrada_sap_informacion_sap_wm16,
                            stock_salida_sap_informacion_sap_wm: $stock_salida_sap_informacion_sap_wm16
                        );

                        $wmModel = Mapper::InformacionSapWMDTOToModel($dto);
                        $repositorio->save($wmModel);
                        break;

                    default:
                        throw new Exception("Tipo de archivo no reconocido.");
                }
            } catch (Exception $e) {
                throw new Exception("Error - " . $e->getMessage());
            }
        }
    }

    public function onGetMB52($id_partnumber): ?array
    {
        return null;
    }
}
