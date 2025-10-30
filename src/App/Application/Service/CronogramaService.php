<?php

namespace App\Application\Service;

use App\Application\Interface\Service\ICronogramaService;
use App\Domain\DTO\CronogramaDTO;
use App\Domain\Model\Cronograma;
use Exception;
use App\Shared\Mapper\Mapper;
use App\Infrastructure\Database\Connection;
use App\Infrastructure\Repository\AdministradoresRepository;
use App\Infrastructure\Repository\CronogramaRepository;
use App\Infrastructure\Repository\EstadosRepository;
use App\Infrastructure\Repository\GruposRepository;

class CronogramaService implements ICronogramaService
{

    private $db;
    private $cronogramaRepository;
    private $gruposRepository;
    private $administradoresRepository;
    private $estadosRepository;

    public function __construct()
    {
        $this->db = (new Connection())->dbInventarioHwi;
        $this->cronogramaRepository = new CronogramaRepository($this->db);
        $this->gruposRepository = new GruposRepository($this->db);
        $this->administradoresRepository = new AdministradoresRepository($this->db);
        $this->estadosRepository = new EstadosRepository($this->db);
    }

    public function onGetCronograma_By__Id_Grupo($id_grupo): CronogramaDTO
    {
        $cronograma = $this->cronogramaRepository->onGet_by_Id_grupo($id_grupo);
        $cronogramaDTO = Mapper::modelToCronogramaDTO($cronograma);
        return $cronogramaDTO;
    }

    public function onGetCronograma($mes_inicial, $mes_final): array
    {
        if ($mes_inicial != null && $mes_final != null) {
            $cronogramas = $this->cronogramaRepository->onGet_By__Fecha($mes_inicial, $mes_final);
        } else {
            $cronogramas = $this->cronogramaRepository->onGet();
        }

        $grupos = $this->gruposRepository->onGet();

        foreach ($cronogramas as $cronograma) {
            $id = $cronograma->id_grupo_cronograma ?? null;
            foreach ($grupos as $grupo) {
                if ($id == $grupo->id_grupo) {
                    $cronograma->grupo = $grupo->descripcion_grupo;
                }
            }
        }

        $administradores = $this->administradoresRepository->onGet();

        foreach ($cronogramas as $cronograma) {
            $id = $cronograma->id_administrador_cronograma ?? null;
            if ($id == null) {
                $cronograma->administrador = "-";
            } else {
                foreach ($administradores as $administrador) {
                    if ($id == $administrador->id_administrador) {
                        $cronograma->administrador = $administrador->nombre_administrador . " " . $administrador->apellidos_administrador;
                    }
                }
            }
        }

        $estados = $this->estadosRepository->onGet();

        foreach ($cronogramas as $cronograma) {
            $id = $cronograma->id_estado_cronograma ?? null;
            foreach ($estados as $estado) {
                if ($id == $estado->id_estado) {
                    $cronograma->estado = $estado->tipo_estado;
                }
            }
        }

        return $cronogramas;
    }

    public function updateCronograma(CronogramaDTO $cronogramaDTO): bool
    {
        $Cronograma = Mapper::CronogramaDTOToModel($cronogramaDTO);
        $guardarCronograma = $this->cronogramaRepository->update($Cronograma);

        if (!$guardarCronograma) {
            return false;
        } else {
            return true;
        }
    }
}
