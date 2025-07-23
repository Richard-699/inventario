<?php

namespace App\Application\Interface\Service;

use App\Domain\DTO\PartNumbersDTO;

interface IPartNumbersService {
    public function onGetPartNumbers(): array;
    public function onGetUMBS(): array;
}

?>