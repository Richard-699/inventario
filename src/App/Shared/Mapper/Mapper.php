<?php

namespace App\Shared\Mapper;

use App\Domain\Model\Administradores;
use App\Domain\DTO\AdministradoresDTO;
use App\Domain\DTO\AlmacenesDTO;
use App\Domain\Model\Permisos;
use App\Domain\DTO\PermisosDTO;
use App\Domain\Model\PermisosAdministradores;
use App\Domain\DTO\PermisosAdministradoresDTO;
use App\Domain\Model\Almacenes;

class Mapper
{
    public static function modelToAdministradoresDTO(Administradores $model): AdministradoresDTO
    {
        return new AdministradoresDTO(
            id_administrador: $model->id_administrador,
            cedula_administrador: $model->cedula_administrador,
            nombre_administrador: $model->nombre_administrador,
            apellidos_administrador: $model->apellidos_administrador,
            correo_hwi_administrador: $model->correo_hwi_administrador,
            password_administrador: $model->password_administrador,
            password_is_temporal: $model->password_is_temporal,
            estado_administrador: $model->estado_administrador
        );
    }

    public static function administradoresDTOToModel(AdministradoresDTO $dto): Administradores
    {
        return new Administradores(
            $dto->id_administrador,
            $dto->cedula_administrador,
            $dto->nombre_administrador,
            $dto->apellidos_administrador,
            $dto->correo_hwi_administrador,
            $dto->password_administrador,
            $dto->password_is_temporal,
            $dto->estado_administrador
        );
    }

    public static function modelToPermisosDTO(Permisos $model): PermisosDTO
    {
        return new PermisosDTO(
            id_permiso: $model->id_permiso,
            tipo_permiso: $model->tipo_permiso
        );
    }

    public static function permisosDTOToModel(PermisosDTO $dto): Permisos
    {
        return new Permisos(
            $dto->id_permiso,
            $dto->tipo_permiso
        );
    }

    public static function modelToPermisosAdministradoresDTO(PermisosAdministradores $model): PermisosAdministradoresDTO
    {
        return new PermisosAdministradoresDTO(
            id_permisos_administradores: $model->id_permisos_administradores,
            id_permiso_permisos: $model->id_permiso_permisos,
            id_administrador_permisos: $model->id_administrador_permisos
        );
    }

    public static function permisosAdministradoresDTOToModel(PermisosAdministradoresDTO $dto): PermisosAdministradores
    {
        return new PermisosAdministradores(
            $dto->id_permisos_administradores,
            $dto->id_permiso_permisos,
            $dto->id_administrador_permisos
        );
    }


    public static function modelToAlmacenesDTO(Almacenes $model): AlmacenesDTO
    {
        return new AlmacenesDTO(
            id_almacen: $model->id_almacen,
            codigo_sap: $model->codigo_sap,
            descripcion_almacen: $model->descripcion_almacen
        );
    }

    public static function AlmacenesDTOToModel(AlmacenesDTO $dto): Almacenes
    {
        return new Almacenes(
            $dto->id_almacen,
            $dto->codigo_sap,
            $dto->descripcion_almacen
        );
    }
}
