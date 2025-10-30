<?php

namespace App\Application\Service;

use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Application\Interface\Service\IBasesDatosSapService;
use App\Domain\DTO\InformacionSapMB52DTO;
use App\Domain\DTO\InformacionSapWMDTO;
use App\Domain\DTO\HistoricoStockDTO;
use App\Domain\DTO\HistoricoWMDTO;
use App\Domain\DTO\HistoricoMB52DTO;
use App\Domain\DTO\ConteoDTO;
use App\Domain\DTO\ExactitudDTO;
use App\Domain\DTO\GruposDTO;
use App\Domain\Model\Almacenes;
use App\Domain\Model\Exactitud;
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
use App\Infrastructure\Repository\ConteoRepository;
use App\Infrastructure\Repository\HistoricoStockRepository;
use App\Infrastructure\Repository\HistoricoWMRepository;
use App\Infrastructure\Repository\HistoricoMB52Repository;
use App\Infrastructure\Repository\StockRepository;
use App\Infrastructure\Repository\ExactitudRepository;
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
    private $conteoRepository;
    private $exactitudRepository;
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
        $this->conteoRepository = new ConteoRepository($this->db);
        $this->stockRepository = new StockRepository($this->db);
        $this->stockHistoricoRepository = new HistoricoStockRepository($this->db);
        $this->HistoricoWMRepository = new HistoricoWMRepository($this->db);
        $this->HistoricoMB52Repository = new HistoricoMB52Repository($this->db);
        $this->exactitudRepository = new ExactitudRepository($this->db);
    }

    public function procesarArchivosExcel(array $mb52File, array $wmFile, array $cero016File, string $idGrupo, string $id_administrador): void
    {
        try {
            // 1. Iniciar la transacción para asegurar la integridad de los datos
            $this->db->beginTransaction();

            // 1. Registrar el nuevo conteo:::

            date_default_timezone_set('America/Bogota');
            $conteoDTO = new ConteoDTO(
                id_conteo: null,
                id_grupo_conteo: $idGrupo,
                id_encargado_conteo: $id_administrador,
                fecha_hora_inicio_conteo: date('Y-m-d H:i:s'),
                fecha_hora_final_conteo: null,
                observaciones_conteo: null,
                estado_conteo: null
            );
            // Guardar DTO en la tabla stock_historico
            $ConteoStockModel = Mapper::ConteoDTOToModel($conteoDTO);
            $this->conteoRepository->save($ConteoStockModel);


            /*             // 2. onGet de tablas Stock
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
            } */


            /*             // 2. onGet WM
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
 */
            /*             // 3. onGet MB52
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
               
            } */

            // 2. Eliminar información de las tablas WM y MB52 por ID de grupo
            // Eliminar los registros de la tabla WM (Con esto ya se eliminan de las dos tablas por la relacion FK ON DELETE IN CASCADE)
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

    public function procesarArchivosExcelExactitud(array $lx03, string $id_administrador, array $gruposSeleccionados, string $vacias): void
    {
        try {
            // 1. Iniciar la transacción para asegurar la integridad de los datos
            $this->db->beginTransaction();

            date_default_timezone_set('America/Bogota');
            $fechaActual = date('Y-m-d');
            $eliminarRegistrosHOY = $this->exactitudRepository->onDelete_By__fecha($fechaActual);
            if (!$eliminarRegistrosHOY) {
                throw new Exception("Hubo un error al intentar eliminar los registros de hoy");
            }

            // 2. Cargar el único archivo de Excel
            $spreadsheet = IOFactory::load($lx03['tmp_name']);

            // 3. Obtener la hoja específica
            $sheetName = "SAP LX03";
            $sheet = $spreadsheet->getSheetByName($sheetName);
            if (!$sheet) {
                throw new Exception("No se encontró la hoja '$sheetName' en el archivo Excel.");
            }
            $sheet->getStyle('A1:Z1000')->getNumberFormat()->setFormatCode('@'); // Forzar modo texto
            $filas = $sheet->toArray();

            // 4. Filtrar filas: por grupos seleccionados Y aplicar la lógica de 'vacias' (Material)
            $filasFiltradas = array_filter($filas, function ($fila, $index) use ($gruposSeleccionados, $vacias) {
                // Ignorar el encabezado
                if ($index === 0) return false;

                // Columna 'Material' (índice 0)
                $material = trim($fila[0] ?? '');

                // Columna 'Tipo almacén' (índice 5)
                $tipoAlmacen = trim($fila[5] ?? '');

                // *** 4.1. Única regla de exclusión general: Filas con Material completamente vacío ***
                if (empty($material)) {
                    return false;
                }

                // 4.2. Filtrar por Grupos Seleccionados (Tipo almacén)
                if (!in_array($tipoAlmacen, $gruposSeleccionados)) {
                    return false; // Ignorar la fila si el grupo no fue seleccionado
                }

                // *** 4.3. Aplicar la lógica de 'vacias' (Columna Material) ***
                if ($vacias === "Si") {
                    // REGLA 1: Si $vacias es "Si", SOLO incluimos las que dicen "<< vacías >>".
                    if ($material !== "<< vacías >>") {
                        return false;
                    }
                } else {
                    // REGLA 2 (Ajustada): Si $vacias es "No", incluimos TODO lo que no esté vacío.
                    // Como ya se filtró empty($material) arriba, no es necesario hacer un filtro adicional aquí.
                    // Todo lo que llegue a este punto y no sea "Si" pasa.
                }

                return true;
            }, ARRAY_FILTER_USE_BOTH);

            // 5. Iterar sobre las filas filtradas para procesar cada una
            foreach ($filasFiltradas as $fila) {
                $codigoPartNumber = trim($fila[0] ?? '');
                $tipoAlmacen = trim($fila[5] ?? '');
                $areaAlmacenamiento = trim($fila[6] ?? '');
                $localizacion = trim($fila[7] ?? '');

                // Adaptar la lógica de búsqueda de Part Number
                if ($codigoPartNumber === "<< vacías >>") {
                    // Si la ubicación está vacía (según el archivo Excel), no buscar en la BD.
                    $descripcionPartnumber = "Vacía";
                } else {
                    // Obtener ID del part number y su grupo para Part Numbers reales
                    $partNumber = $this->partNumberRepository->onGet_By__Codigo($codigoPartNumber);
                    if (!$partNumber) {
                        $descripcionPartnumber = "Partnumber no registrado en el sistema";
                    } else {
                        $descripcionPartnumber = $partNumber->descripcion_breve;
                    }
                }

                // Crear DTO y guardar en el repositorio
                $dto = new ExactitudDTO(
                    partnumber_exactitud: $codigoPartNumber,
                    descripcion_partnumber_exactitud: $descripcionPartnumber,
                    tipo_almacen_exactitud: $tipoAlmacen,
                    area_almacenamiento_exactitud: $areaAlmacenamiento,
                    localizacion_exactitud: $localizacion,
                    coincide_exactitud: null,
                    novedad_exactitud: null,
                    descripcion_novedad_exactitud: null,
                    fecha_hora_migracion_exactitud: date('Y-m-d H:i:s'),
                    id_administrador: $id_administrador
                );
                $mb52Model = Mapper::ExactitudDTOToModel($dto);
                $this->exactitudRepository->save($mb52Model);
            }

            // 6. Confirmar la transacción (commit) después de procesar todas las filas
            $this->db->commit();
        } catch (Exception $e) {
            // 7. Revertir la transacción (rollback) en caso de cualquier error
            $this->db->rollBack();

            // 8. Relanzar la excepción para que el Handler la capture
            throw new Exception("Error al procesar el archivo. La transacción ha sido revertida. Detalles: " . $e->getMessage());
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

                        // Validar si el part number no tiene grupo asignado
                        if (empty($idGrupo)) {
                            throw new Exception("El Part Number '{$codigoPartNumber}' no ha sido asignado a ningún grupo.");
                        }

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

    public function onGetExactitud(): ?array
    {
        date_default_timezone_set('America/Bogota');
        $fechaActual = date('Y-m-d');
        $informacionesSapExactitud = $this->exactitudRepository->onGet__Fecha($fechaActual);
        if (!$informacionesSapExactitud) {
            throw new Exception("Error al intentar obtener los registros de exactitud");
        }
        return $informacionesSapExactitud;
    }

    public function onGetExactitud_By_Id($id_exactitud): ?Exactitud
    {
        $informacionesSapExactitud = $this->exactitudRepository->onGet__By_Id($id_exactitud);
        if (!$informacionesSapExactitud) {
            throw new Exception("Error al intentar obtener los registros de exactitud");
        }
        return $informacionesSapExactitud;
    }

    public function updateExactitud(ExactitudDTO $exactitudDTO): bool
    {
        $Exactitud = Mapper::ExactitudDTOToModel($exactitudDTO);
        $updateExactitud = $this->exactitudRepository->update($Exactitud);

        if (!$updateExactitud) {
            return false;
        } else {
            return true;
        }
    }
}
