<?php

namespace App\Shared\Validation;

use Exception;
use App\Domain\DTO\AdministradoresDTO;
use App\Domain\DTO\AlmacenesDTO;

class Validator
{
    public static function validateDTO(object $dto): void
    {
        switch (true) {
            case $dto instanceof AdministradoresDTO:
                self::validateAdministradoresDTO($dto);
                break;
            case $dto instanceof AlmacenesDTO:
                self::validateAlmacenesDTO($dto);
                break;
            default:
                throw new Exception('No hay reglas de validación definidas para este DTO.');
        }
    }

    private static function validateAdministradoresDTO(AdministradoresDTO $dto): void
    {
        if ($dto->type == 'register') {
            if (empty($dto->cedula_administrador)) {
                throw new Exception('La cédula es obligatoria.');
            }
            if (empty($dto->nombre_administrador)) {
                throw new Exception('El nombre es obligatorio.');
            }
            if (empty($dto->apellidos_administrador)) {
                throw new Exception('Los apellidos son obligatorios.');
            }
        }
        if ($dto->type == 'login' || $dto->type == 'register') {
            if (empty($dto->correo_hwi_administrador)) {
                throw new Exception('El correo es obligatorio.');
            }
            if (!filter_var($dto->correo_hwi_administrador, FILTER_VALIDATE_EMAIL)) {
                throw new Exception('El correo no es válido.');
            }
            if (empty($dto->password_administrador)) {
                throw new Exception('La contraseña es obligatoria.');
            }
        }
    }

    public static function validateListaPermisos(array $listaPermisosDTO): void
    {
        if (empty($listaPermisosDTO)) {
            throw new Exception('Debes seleccionar al menos un permiso.');
        }
    }

    public static function validateAlmacenesDTO(AlmacenesDTO $dto): void
    {
        if (empty($dto->codigo_sap)) {
            throw new Exception('El código SAP es obligatorio.');
        }
        if (empty($dto->descripcion_almacen)) {
            throw new Exception('La descripcion es obligatoria.');
        }
    }
}
