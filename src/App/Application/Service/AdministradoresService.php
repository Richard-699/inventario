<?php

namespace App\Application\Service;

use App\Application\Interface\Service\IAdministradoresService;
use App\Domain\DTO\AdministradoresDTO;
use App\Infrastructure\Repository\PermisosAdministradoresRepository;
use App\Infrastructure\Repository\AdministradoresRepository;
use App\Infrastructure\Repository\PermisosRepository;
use Exception;
use App\Shared\Mapper\Mapper;

class AdministradoresService implements IAdministradoresService {

    public function __construct(
        private AdministradoresRepository $administradoresRepository,
        private PermisosAdministradoresRepository $permisosAdministradoresRepository,
        private PermisosRepository $permisosRepository
    ) {}


    public function onGetAdministradores(): array{
        $administradores = $this->administradoresRepository->onGet();
        return $administradores;
    }

    public function deleteAdministrador($id): bool{
        $delete_permisos_administrador = $this->permisosAdministradoresRepository->delete($id);

        if (!$delete_permisos_administrador) {
            throw new Exception("Error al eliminar los permisos del administrador con ID '$id'.");
        }

        $delete_administrador = $this->administradoresRepository->delete($id);

        if ($delete_administrador === 0) {
            throw new Exception("No se eliminó ningún administrador. El ID '$id' no existe o ya fue eliminado.");
        }

        return true;
    }

    public function onGetPermisos(): array{
        $permisos = $this->permisosRepository->onGet();
        return $permisos;
    }
}


?>