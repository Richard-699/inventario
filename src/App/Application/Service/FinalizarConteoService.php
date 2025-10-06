<?php

namespace App\Application\Service;

use App\Application\Interface\Service\IFinalizarConteoService;
use App\Domain\DTO\CronogramaDTO;
use App\Domain\DTO\ConteoDTO;
use App\Domain\DTO\GruposDTO;
use App\Domain\DTO\HistoricoMB52DTO;
use App\Domain\DTO\HistoricoWMDTO;
use App\Domain\Model\Cronograma;
use Exception;
use App\Shared\Mapper\Mapper;
use App\Infrastructure\Database\Connection;
use App\Infrastructure\Repository\AdministradoresRepository;
use App\Infrastructure\Repository\CronogramaRepository;
use App\Infrastructure\Repository\EstadosRepository;
use App\Infrastructure\Repository\GruposRepository;
use App\Infrastructure\Repository\InformacionSapWMRepository;
use App\Infrastructure\Repository\InformacionSapMB52Repository;
use App\Infrastructure\Repository\HistoricoWMRepository;
use App\Infrastructure\Repository\HistoricoMB52Repository;
use DateTime;

class FinalizarConteoService implements IFinalizarConteoService
{

    private $db;
    private $cronogramaRepository;
    private $gruposRepository;
    private $administradoresRepository;
    private $estadosRepository;
    private $historicoMB52Repository;
    private $historicoWMRepository;
    private $informacionSapMB52Repository;
    private $conteoService;
    private $cronogramaService;
    private $informacionSapWMRepository;

    private $grupoService;


    public function __construct()
    {
        $this->db = (new Connection())->dbInventarioHwi;
        $this->conteoService = new ConteoService($this->db);
        $this->cronogramaService = new cronogramaService($this->db);
        $this->grupoService = new GruposService($this->db);
        $this->informacionSapWMRepository = new InformacionSapWMRepository($this->db);
        $this->cronogramaRepository = new CronogramaRepository($this->db);
        $this->historicoWMRepository = new HistoricoWMRepository($this->db);
        $this->historicoMB52Repository = new HistoricoMB52Repository($this->db);
        $this->informacionSapMB52Repository = new InformacionSapMB52Repository($this->db);
        $this->gruposRepository = new GruposRepository($this->db);
        $this->administradoresRepository = new AdministradoresRepository($this->db);
        $this->estadosRepository = new EstadosRepository($this->db);
    }

    public function finalizarConteo(array $form): void
    {
        // Usa un bloque try...catch para manejar transacciones
        try {
            // 1. Iniciar la transacción para asegurar que todas las operaciones se completen
            $this->db->beginTransaction();

            // Consultar el ID del conteo actual
            $conteoData = $this->conteoService->onGetConteo_By__Fecha_Reciente_Grupo($form['id_grupo']);
            if (empty($conteoData)) {
                throw new Exception("No se pudo consultar el id del conteo.");
            }
            $idConteo = $conteoData->id_conteo;

            // Obtener datos del formulario
            $id_estado_cronograma = $form['id_estado_cronograma'];
            $id_grupo = $form['id_grupo'];
            $otro_conteo_seleccionado = $form['otro_conteo'] ?? null;
            $id_nuevo_estado = $id_estado_cronograma;

            // Crear DTO para la actualización de conteo
            $conteoDTO = new ConteoDTO(
                id_conteo: $idConteo,
                fecha_hora_final_conteo: date('Y-m-d H:i:s'),
                observaciones_conteo: $form['observaciones'] ?? null
            );
            $this->conteoService->updateConteo($conteoDTO);

            // Lógica para determinar el nuevo estado
            if ($otro_conteo_seleccionado === 'si') {
                if ($id_estado_cronograma == 2) {
                    $id_nuevo_estado = 5; // "Pendiente conteo 2"
                } else if ($id_estado_cronograma == 8) {
                    $id_nuevo_estado = 6; // "Pendiente conteo 3"
                }
            } else if ($otro_conteo_seleccionado === 'no') {
                $id_nuevo_estado = 3; // Pasa directo a "Esperar aprobación"
            }

            /* ACTUALIZAR LA INFORMACION DEL CRONOGRAMA */
            $FechaActualCronograma = $this->cronogramaService->onGetCronograma_By__Id_Grupo($id_grupo);
            $fechaBD = $FechaActualCronograma->fecha_cronograma;
            $fechaCronograma = DateTime::createFromFormat('Y-m', $fechaBD);
            $fechaCronograma->modify('+3 months');
            $nuevaFechaCronograma = $fechaCronograma->format('Y-m');

            $cronogramaDTO = new CronogramaDTO(
                fecha_cronograma: $nuevaFechaCronograma,
                id_grupo_cronograma: $id_grupo,
                id_estado_cronograma: $id_nuevo_estado,
                id_administrador_cronograma: null
            );

            $actualizarCronograma = $this->cronogramaService->updateCronograma($cronogramaDTO);
            if (!$actualizarCronograma) {
                throw new Exception("No se pudo actualizar el cronograma.");
            }

            /* ACTUALIZAMOS LA INFORMACIÓN DEL GRUPO:: */

            $infoActualGrupo = $this->grupoService->onGetGrupo_By__Id($id_grupo);
            $descripcionActualGrupo = $infoActualGrupo->descripcion_grupo;

            $informacion_migrada_sap_grupo = 0;
            $gruposDTO = new GruposDTO(
                id_grupo: $id_grupo,
                descripcion_grupo: $descripcionActualGrupo,
                fecha_programacion_grupo: $nuevaFechaCronograma,
                informacion_migrada_sap_grupo: $informacion_migrada_sap_grupo
            );
            $actualizarGrupo = $this->grupoService->updateGrupo($gruposDTO);
            if (!$actualizarGrupo) {
                throw new Exception("No se pudo actualizar la información del grupo");
            }

            /* MIGRAR INFORMACION A HISTORICOS */
            // 1. Obtener datos de WM y migrar
            $OnGetWM = $this->informacionSapWMRepository->onGet_By__Id_grupo($id_grupo);
            if ($OnGetWM) {
                foreach ($OnGetWM as $WMModel) {
                    $HistoricoWMDTO = new HistoricoWMDTO(
                        id_historico_wm: null,
                        fecha_historico_wm: date('Y-m-d H:i:s'),
                        stock_disponible_historico_wm: $WMModel->stock_disponible_sap_informacion_sap_wm,
                        stock_entrada_historico_wm: $WMModel->stock_entrada_sap_informacion_sap_wm,
                        stock_salida_historico_wm: $WMModel->stock_salida_sap_informacion_sap_wm,
                        id_localizacion_historico_wm: $WMModel->id_localizacion_informacion_sap_wm,
                        id_partnumber_historico_wm: $WMModel->id_part_number_informacion_sap_wm,
                        id_grupo_historico_wm: $WMModel->id_grupo_informacion_sap_wm,
                        id_informacion_sap_mb52_historico_wm: $WMModel->id_informacion_sap_mb52_informacion_sap_wm
                    );
                    $historicoWMModel = Mapper::HistoricoWMDTOToModel($HistoricoWMDTO);
                    $this->historicoWMRepository->save($historicoWMModel);
                }
            }

            // 2. Obtener datos de MB52 y migrar
            $OnGetMB52 = $this->informacionSapMB52Repository->onGet_By__Id_grupo($id_grupo);
            if ($OnGetMB52) {
                foreach ($OnGetMB52 as $MB52Model) {
                    $HistoricoMB52DTO = new HistoricoMB52DTO(
                        id_historico_mb52: null,
                        id_informacion_sap_mb52_historico_mb52: $MB52Model->id_informacion_sap_mb52,
                        fecha_historico_mb52: date('Y-m-d H:i:s'),
                        cantidad_historico_mb52: $MB52Model->cantidad_informacion_sap_mb52,
                        fechaRegistro_historico_mb52: $MB52Model->fecha_registro_informacion_sap_mb52,
                        id_part_number_historico_mb52: $MB52Model->id_part_number_informacion_sap_mb52,
                        id_almacen_historico_mb52: $MB52Model->id_almacen_informacion_sap_mb52,
                        id_grupo_historico_mb52: $MB52Model->id_grupo_informacion_sap_mb52
                    );
                    $historicoMB52Model = Mapper::HistoricoMB52DTOToModel($HistoricoMB52DTO);
                    $this->historicoMB52Repository->save($historicoMB52Model);
                }
            }

            // Eliminar los registros de la tabla WM (Con esto ya se eliminan de las dos tablas por la relacion FK ON DELETE IN CASCADE)
            $this->informacionSapWMRepository->onDelete_By__IdGrupo($id_grupo);

            // 3. Confirmar la transacción
            $this->db->commit();
        } catch (Exception $e) {
            // Revertir la transacción si algo falla
            $this->db->rollBack();
            // Relanzar la excepción para que sea manejada por el controlador
            throw $e;
        }
    }
}
