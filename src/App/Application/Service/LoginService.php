<?php

namespace App\Application\Service;

use App\Application\Contract\Service\ILoginService;
use App\Domain\DTO\AdministradoresDTO;
use App\Infrastructure\Repository\AdministradoresRepository;
use Exception;
use App\Shared\Mapper\Mapper;

class LoginService implements ILoginService {

    public function __construct(private AdministradoresRepository $administradoresRepository) {}

    public function login(AdministradoresDTO $administradoresDTO): AdministradoresDTO {
        $administrador = $this->administradoresRepository->onGet_Login(
            $administradoresDTO->correo_hwi_administrador);

        if (!$administrador || !password_verify($administradoresDTO->password_administrador, $administrador->password_administrador)) {
            throw new Exception("Credenciales inválidas.");
        }

        return Mapper::modelToAdministradoresDTO($administrador);
    }
}


?>