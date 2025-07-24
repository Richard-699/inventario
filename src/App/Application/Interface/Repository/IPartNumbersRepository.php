<?php

namespace App\Application\Interface\Repository;

use App\Domain\Model\PartNumbers;

interface IPartNumbersRepository {
    public function onGet(): array;
    public function onGet_By__Id($id): ?PartNumbers;
    public function onGet_By__Codigo($codigo): ?PartNumbers;
    public function save(PartNumbers $partnumbers): bool;
    public function update(PartNumbers $partnumbers): bool;
    public function delete($id): bool;
    public function update_By__id_grupo($id): bool;
}

?>