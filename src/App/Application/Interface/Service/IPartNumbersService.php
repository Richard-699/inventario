<?php

namespace App\Application\Interface\Service;

use App\Domain\DTO\PartNumbersDTO;

interface IPartNumbersService {
    public function onGetPartNumbers(): array;
    public function onGetUMBS(): array;
    public function savePartNumbers(array $partnumbers): bool;
    public function deletePartNumbers($id): bool;
    public function updatePartNumber(PartNumbersDTO $partnumbersDTO): bool;
    public function onGetPartNumber_By__Id($id): PartNumbersDTO;
    public function onGetPartNumber_By__codigo($codigo): ?PartNumbersDTO;
}

?>