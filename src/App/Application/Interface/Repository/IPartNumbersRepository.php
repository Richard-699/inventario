<?php

namespace App\Application\Interface\Repository;

use App\Domain\Model\PartNumbers;

interface IPartNumbersRepository {
    public function onGet(): array;
}

?>