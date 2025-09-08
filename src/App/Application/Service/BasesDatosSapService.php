<?php

namespace App\Application\Service;

use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Application\Interface\Service\IBasesDatosSapService;
use App\Domain\DTO\InformacionSapMB52DTO;
use App\Domain\DTO\InformacionSapWMDTO;
use App\Domain\DTO\HistoricoStockDTO;
use App\Domain\DTO\HistoricoWMDTO;
use App\Domain\DTO\HistoricoMB52DTO;
use App\Domain\DTO\GruposDTO;
use App\Domain\Model\Almacenes;
use App\Domain\Model\HistoricoStock;
use App\Domain\Model\InformacionSapMB52;
use Exception;
use App\Shared\Mapper\Mapper;
use App\Infrastructure\Database\Connection;
use App\Infrastructure\Repository\InformacionSapMB52Repository;
use App\Infrastructure\Repository\PartNumbersRepository;
use App\Infrastructure\Repository\AlmacenesRepository;
use App\Infrastructure\Repository\InformacionSapWMRepository;
use App\Infrastructure\Repository\LocalizacionesRepository;
use App\Infrastructure\Repository\UMBRepository;
use App\Infrastructure\Repository\CronogramaRepository;
use App\Infrastructure\Repository\GruposRepository;
use App\Infrastructure\Repository\HistoricoStockRepository;
use App\Infrastructure\Repository\HistoricoWMRepository;
use App\Infrastructure\Repository\HistoricoMB52Repository;
use App\Infrastructure\Repository\StockRepository;
use App\Shared\Util\Utilidades;

class BasesDatosSapService implements IBasesDatosSapService
{

    private $db;
    private $partNumberRepository;
    private $almacenRepository;
    private $localizacionesService;
    private $localizacionesRepository;
    private $informacionSapMB52Repository;
    private $umbRepository;
    private $informacionSapWMRepository;
    private $cronogramaRepository;
    private $gruposRepository;
    private $stockRepository;
    private $stockHistoricoRepository;
    private $HistoricoWMRepository;
    private $HistoricoMB52Repository;
    public function __construct()
    {
        $this->db = (new Connection())->dbInventarioHwi;
        $this->partNumberRepository = new PartNumbersRepository($this->db);
        $this->almacenRepository = new AlmacenesRepository($this->db);
        $this->umbRepository = new UMBRepository($this->db);
        $this->informacionSapMB52Repository = new InformacionSapMB52Repository($this->db);
        $this->informacionSapWMRepository = new InformacionSapWMRepository($this->db);
        $this->localizacionesService = new LocalizacionesService($this->db);
        $this->localizacionesRepository = new LocalizacionesRepository($this->db);
        $this->cronogramaRepository = new CronogramaRepository($this->db);
        $this->gruposRepository = new GruposRepository($this->db);
        $this->stockRepository = new StockRepository($this->db);
        $this->stockHistoricoRepository = new HistoricoStockRepository($this->db);
        $this->HistoricoWMRepository = new HistoricoWMRepository($this->db);
        $this->HistoricoMB52Repository = new HistoricoMB52Repository($this->db);
    }

    public function procesarArchivosExcel(array $mb52File, array $wmFile, array $cero016File, string $idGrupo, string $id_administrador): void
    {
        try {
            // 1. Iniciar la transacción para asegurar la integridad de los datos
            $this->db->beginTransaction();

            // 2. onGet de tablas Stock
            $OnGetStock = $this->stockRepository->onGet_by_Id_grupo($idGrupo);
            // 2.1 Si se encontraron registros en la tabla stock, se guardan en el historico y luego se eliminan.
            if ($OnGetStock) {
                foreach ($OnGetStock as $stockModel) {
                    $HistoricoStockDTO = new HistoricoStockDTO(
                        id_historico_stock: null,
                        fecha_historico_stock: date('Y-m-d H:i:s'),
                        cantidad_historico_stock: $stockModel->cantidad_stock,
                        id_almacen_historico_stock: $stockModel->id_almacen_stock,
                        id_localizacion_historico_stock: $stockModel->id_localizacion_stock,
                        id_informacion_sap_mb52_historico_stock: $stockModel->id_informacion_sap_mb52_stock,
                        id_partnumber_historico_stock: $stockModel->id_partnumber_stock,
                        id_novedad_historico_stock: $stockModel->id_novedad_stock,
                        observaciones_novedad_historico_stock: $stockModel->observaciones_novedad_stock,
                        id_grupo_historico_stock: $stockModel->id_grupo_stock
                    );

                    // Guardar DTO en la tabla stock_historico
                    $historicoStockModel = Mapper::HistoricoStockDTOToModel($HistoricoStockDTO);
                    $this->stockHistoricoRepository->save($historicoStockModel);
                }
                // Eliminar los registros de la tabla stock
                $this->stockRepository->delete($idGrupo);
            }


            // 2. onGet WM
            $OnGetWM = $this->informacionSapWMRepository->onGet_By__Id_grupo($idGrupo);
            // 2.1 Si se encontraron registros en la tabla wm, se guardan en el historico y luego se eliminan.
            if ($OnGetWM) {
                foreach ($OnGetWM as $WMModel) {
                    $HistoricoWMDTO = new HistoricoWMDTO(
                        id_historico_wm : null,
                        fecha_historico_wm: date('Y-m-d H:i:s'),
                        stock_disponible_historico_wm: $WMModel->stock_disponible_sap_informacion_sap_wm,
                        stock_entrada_historico_wm: $WMModel->stock_entrada_sap_informacion_sap_wm,
                        stock_salida_historico_wm: $WMModel->stock_salida_sap_informacion_sap_wm,
                        id_localizacion_historico_wm: $WMModel->id_localizacion_informacion_sap_wm,
                        id_partnumber_historico_wm: $WMModel->id_part_number_informacion_sap_wm,
                        id_grupo_historico_wm : $WMModel->id_grupo_informacion_sap_wm ,
                        id_informacion_sap_mb52_historico_wm : $WMModel->id_informacion_sap_mb52_informacion_sap_wm 
                    );

                    // Guardar DTO en la tabla historicowm
                    $historicoWMModel = Mapper::HistoricoWMDTOToModel($HistoricoWMDTO);
                    $this->HistoricoWMRepository->save($historicoWMModel);
                }
               
            }

             // 3. onGet MB52
            $OnGetMB52 = $this->informacionSapMB52Repository->onGet_By__Id_grupo($idGrupo);
            // 3.1 Si se encontraron registros en la tabla wm, se guardan en el historico y luego se eliminan.
            if ($OnGetMB52) {
                foreach ($OnGetMB52 as $MB52Model) {
                    $HistoricoMB52DTO = new HistoricoMB52DTO(
                        id_historico_mb52 : null,
                        id_informacion_sap_mb52_historico_mb52: $MB52Model->id_informacion_sap_mb52,
                        fecha_historico_mb52: date('Y-m-d H:i:s'),
                        cantidad_historico_mb52: $MB52Model->cantidad_informacion_sap_mb52,
                        fechaRegistro_historico_mb52: $MB52Model->fecha_registro_informacion_sap_mb52,
                        id_part_number_historico_mb52: $MB52Model->id_part_number_informacion_sap_mb52,
                        id_almacen_historico_mb52: $MB52Model->id_almacen_informacion_sap_mb52,
                        id_grupo_historico_mb52 : $MB52Model->id_grupo_informacion_sap_mb52
                    );

                    // Guardar DTO en la tabla historicowm
                    $historicoMB52Model = Mapper::HistoricoMB52DTOToModel($HistoricoMB52DTO);
                    $this->HistoricoMB52Repository->save($historicoMB52Model);
                }
               
            }

            // 2. Eliminar información de las tablas WM y MB52 por ID de grupo
             // Eliminar los registros de la tabla WM
            $this->informacionSapWMRepository->onDelete_By__IdGrupo($idGrupo);
            /* $this->informacionSapMB52Repository->onDelete_By__IdGrupo($idGrupo); */

            // 3.1 Obtener el cronograma para evaluar su estado
            $cronograma = $this->cronogramaRepository->onGet_by_Id_grupo($idGrupo);
            // 3.2 Asignacion de nuevo estado
            $nuevoEstado = 1;
            if ($cronograma) {
                $estadoActual = $cronograma->id_estado_cronograma;
                if ($estadoActual === 1) { //pendiente 
                    $nuevoEstado = 2; //En Proceso Conteo 1
                } else if ($estadoActual === 5) { //Pendiente conteo 2
                    $nuevoEstado = 8; //En Proceso Conteo 2
                } else if ($estadoActual === 6) { //Pendiente conteo 3
                    $nuevoEstado = 9; //En Proceso Conteo 3
                }
            }
            // 3.3 Actualizar el estado y el asignado en la tabla cronogramas
            $this->cronogramaRepository->UpdateEstado_Asignado_By_IdGrupo($idGrupo, $nuevoEstado, $id_administrador);

            // 4. Actualizar estado de la migración
            $id_estado_migracion = 1;
            $this->gruposRepository->update_estado_migration($idGrupo, $id_estado_migracion);

            // 5. Procesar los nuevos archivos Excel
            $this->procesarArchivo($mb52File, $this->informacionSapMB52Repository, 'mb52');
            $this->procesarArchivo($wmFile, $this->informacionSapWMRepository, 'wm');
            $this->procesarArchivo($cero016File, $this->informacionSapWMRepository, 'cero016');

            // 5. Confirmar la transacción (commit)
            $this->db->commit();
        } catch (Exception $e) {
            // 6. Revertir la transacción (rollback) en caso de cualquier error
            $this->db->rollBack();

            // 7. Relanzar la excepción para que el Handler la capture
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

    function formatearCantidad($valor)
    {
        $num = (float)$valor;

        if (fmod($num, 1) == 0) {
            return (string)(int)$num;
        }

        return number_format($num, 3, ',', '');
    }

    public function onGetInformacionSAP($id_partnumber, $id_almacen): ?array
    {
        $informacionesSap = $this->informacionSapMB52Repository->onGet_By__Id_Partnumber__Id_Almacen($id_partnumber, $id_almacen);

        $almacenes = $this->almacenRepository->onGet();
        $almacenesMap = [];
        foreach ($almacenes as $almacen) {
            $almacenesMap[$almacen->id_almacen] = $almacen->descripcion_almacen;
        }

        $umbs = $this->umbRepository->onGet();
        $umbsMap = [];
        foreach ($umbs as $umb) {
            $umbsMap[$umb->id_umb] = $umb->descripcion_umb;
        }

        $partnumbers = $this->partNumberRepository->onGet();
        $partnumbersMap = [];
        foreach ($partnumbers as $partnumber) {
            $partnumbersMap[$partnumber->id_partnumber] = [
                'partnumber' => $partnumber->partnumber,
                'descripcion_breve' => $partnumber->descripcion_breve,
                'id_umb' => $partnumber->id_umb_partnumber
            ];
        }

        foreach ($informacionesSap as $informacionSAP) {
            $cantidad = $informacionSAP->cantidad_informacion_sap_mb52;
            $informacionSAP->cantidad_formateada = $this->formatearCantidad($cantidad);

            $idAlmacen = $informacionSAP->id_almacen_informacion_sap_mb52 ?? null;
            $id_informacion_sap_mb52 = $informacionSAP->id_informacion_sap_mb52 ?? null;

            if ($idAlmacen && isset($almacenesMap[$idAlmacen])) {
                $informacionSAP->almacen = $almacenesMap[$idAlmacen];

                if ($informacionSAP->almacen == "WM01") {
                    $informacionSAPWM = $this->informacionSapWMRepository->onGet_By__Id_Mb52($id_informacion_sap_mb52);

                    $localizacionesDTO = [];

                    foreach ($informacionSAPWM as $wm) {
                        $id_localizacion = $wm->id_localizacion_informacion_sap_wm ?? null;

                        if ($id_localizacion) {
                            $localizacion = $this->localizacionesService->onGetLocalizacion_By__Id($id_localizacion);
                            if ($localizacion) {
                                $localizacionesDTO[] = $localizacion;
                            }
                        }
                    }

                    $informacionSAP->localizacionesWM = $localizacionesDTO;
                    $informacionSAP->informacionesSapWM = $informacionSAPWM;
                }
            }

            $idPartnumber = $informacionSAP->id_part_number_informacion_sap_mb52 ?? null;
            if ($idPartnumber && isset($partnumbersMap[$idPartnumber])) {
                $pn = $partnumbersMap[$idPartnumber];
                $informacionSAP->partnumber = $pn['partnumber'];
                $informacionSAP->descripcion_partnumber = $pn['descripcion_breve'];

                $idUmb = $pn['id_umb'] ?? null;
                if ($idUmb && isset($umbsMap[$idUmb])) {
                    $informacionSAP->umb = $umbsMap[$idUmb];
                }
            }
        }
        return $informacionesSap;
    }
}
