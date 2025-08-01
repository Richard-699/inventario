<?php

namespace App\Application\Interface\Service;

use App\Domain\DTO\GruposDTO;
use App\Domain\DTO\CronogramaDTO;
use App\Domain\Model\Grupos;

interface IGruposService {
    public function onGetGrupos(): array;
    public function onGetGrupo_By__Id($id): ?GruposDTO;
    public function onGetGrupo_By__Grupo($grupo): ?GruposDTO;
    public function saveGrupo(GruposDTO $gruposDTO , CronogramaDTO $cronogramaDTO): bool;
    public function deleteGrupo(string $id): bool;
    public function updateGrupoPartNumbersCronograma(GruposDTO $gruposDTO, CronogramaDTO $cronograma_dto): bool;
    public function onGet_By__GrupoAndExcludeId(string $grupoNombre, string $idGrupoAExcluir): ?Grupos;
}
?>