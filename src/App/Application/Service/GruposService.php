<?php

namespace App\Application\Service;

use App\Application\Interface\Service\IGruposService;
use App\Domain\DTO\GruposDTO;
use App\Domain\Model\Grupos;
use App\Infrastructure\Repository\GruposRepository;
use Exception;
use App\Shared\Mapper\Mapper;
use App\Infrastructure\Database\Connection;

class GruposService implements IGruposService
{

    private $db;
    private $gruposRepository;

    public function __construct()
    {
        $this->db = (new Connection())->dbInventarioHwi;
        $this->gruposRepository = new GruposRepository($this->db);
    }

    public function onGetGrupos(): array
    {
        $grupos = $this->gruposRepository->onGet();
        return $grupos;
    }

    public function saveGrupo(gruposDTO $gruposDTO): bool
    {
        $grupos = Mapper::GruposDTOToModel($gruposDTO);
        $guardarGrupo = $this->gruposRepository->save($grupos);

        if (!$guardarGrupo) {
            return false;
        } else {
            return true;
        }
    }

    public function deleteGrupo($id): bool
    {
        $delete_grupo = $this->gruposRepository->delete($id);
        if ($delete_grupo === 0) {
            return false;
        } else {
            return true;
        }
    }
}
