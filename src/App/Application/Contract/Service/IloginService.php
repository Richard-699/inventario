<?php

namespace App\Application\Contract\Service;

use App\Domain\DTO\AdministradoresDTO;

interface ILoginService {
    public function login(AdministradoresDTO $administradoresDTO): AdministradoresDTO;
}

?>