<?php

namespace App\Application\Interface\Repository;

use App\Domain\Model\PartNumbers;

interface IPartNumbersRepository {
    public function onGet(): array;
    public function update_By__id_grupo($id): bool;
}

?>