<?php

namespace App\Application\Interface\Service;

use App\Domain\DTO\GruposDTO;
use App\Domain\Model\Grupos;

interface IGruposService {
    public function onGetGrupos(): array;
    public function onGetGrupo_By__Id($id): ?GruposDTO;
    public function saveGrupo(gruposDTO $gruposDTO): bool;
    public function deleteGrupo(int $id): bool;
}
?>