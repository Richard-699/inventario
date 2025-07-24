<?php

namespace App\Application\Interface\Service;

use App\Domain\DTO\GruposDTO;
use App\Domain\Model\Grupos;

interface IGruposService {
    public function onGetGrupos(): array;
    public function saveGrupo(gruposDTO $gruposDTO): bool;
    public function deleteGrupo($id): bool;
}
?>