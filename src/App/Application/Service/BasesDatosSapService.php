<?php

namespace App\Application\Service;

use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Application\Interface\Service\IBasesDatosSapService;
use App\Domain\DTO\InformacionSapMb52DTO;
use App\Domain\Model\Almacenes;
use App\Domain\Model\InformacionSapMb52;
use Exception;
use App\Shared\Mapper\Mapper;
use App\Infrastructure\Database\Connection;
use App\Infrastructure\Repository\InformacionSapMb52Repository;
use App\Infrastructure\Repository\PartNumbersRepository;
use App\Infrastructure\Repository\AlmacenesRepository;
use App\Shared\Util\Utilidades;

class BasesDatosSapService implements IBasesDatosSapService
{

    private $db;
    private $partNumberRepository;
    private $almacenRepository;
    public function __construct()
    {
        $this->db = (new Connection())->dbInventarioHwi;
        $this->partNumberRepository = new PartNumbersRepository($this->db);
        $this->almacenRepository = new AlmacenesRepository($this->db);
    }

    public function procesarArchivosExcel(array $mb52File, array $wmFile, array $cero016File): void
    {
        $this->procesarArchivo($mb52File, new InformacionSapMb52Repository($this->db), 'mb52');
        /*  $this->procesarArchivo($wmFile, new WMRepository(), 'wm');
        $this->procesarArchivo($cero016File, new Cero016Repository(), 'cero016'); */
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
                            $filaPreview = implode(' | ', array_slice($fila, 0, 2)); // máximo 5 columnas visibles
                            throw new Exception("No se encontró el Part Number '{$codigoPartNumber}' en la fila con datos: [{$filaPreview}]");
                        }
                        $idPartNumber = $partNumber->id_partnumber;
                        $idGrupo = $partNumber->id_grupo_partnumber ?? null;
                        // Obtener ID del almacén por nombre
                        $almacen = $this->almacenRepository->onGet_By__descripcion($nombreAlmacen);
                        if (!$almacen) {
                            throw new Exception("Almacén no encontrado: '{$nombreAlmacen}' en fila $fila.");
                        }
                        $idAlmacen = $almacen->id_almacen;


                        $dto = new InformacionSapMb52DTO(
                            id_informacion_sap_mb52: Utilidades::generarGUID(),
                            fecha_registro_informacion_sap_mb52: date('Y-m-d'),
                            id_part_number_informacion_sap_mb52: $idPartNumber,
                            cantidad_informacion_sap_mb52: (int)($fila[7] ?? 0),
                            id_almacen_informacion_sap_mb52: $idAlmacen,
                            id_grupo_informacion_sap_mb52: $idGrupo
                        );
                        $mb52Model = Mapper::Informacion_sap_mb52DTOToModel($dto);
                        $repositorio->save($mb52Model);
                        break;

                    /*  case 'wm':
                    $dto = new WMDTO(
                        codigo: $fila[0] ?? '',
                        ubicacion: $fila[1] ?? '',
                        stock: (int)($fila[2] ?? 0)
                    );
                    $repositorio->guardar($dto);
                    break;

                case 'cero016':
                    $dto = new Cero016DTO(
                        codigo: $fila[0] ?? '',
                        tipo: $fila[1] ?? '',
                        fecha: $fila[2] ?? ''
                    );
                    $repositorio->guardar($dto);
                    break; */

                    default:
                        throw new Exception("Tipo de archivo no reconocido.");
                }
            } catch (Exception $e) {
                throw new Exception("Error - " . $e->getMessage());
            }
        }
    }
}
