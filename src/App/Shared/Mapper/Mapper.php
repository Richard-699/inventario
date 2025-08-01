<?php

namespace App\Shared\Mapper;

use App\Domain\Model\Administradores;
use App\Domain\DTO\AdministradoresDTO;
use App\Domain\DTO\AlmacenesDTO;
use App\Domain\DTO\LocalizacionesDTO;
use App\Domain\Model\Permisos;
use App\Domain\DTO\PermisosDTO;
use App\Domain\Model\PermisosAdministradores;
use App\Domain\DTO\PermisosAdministradoresDTO;
use App\Domain\Model\Almacenes;
use App\Domain\Model\Localizaciones;
use App\Domain\Model\AlmacenesLocalizaciones;
use App\Domain\DTO\AlmacenesLocalizacionesDTO;
use App\Domain\DTO\CronogramaDTO;
use App\Domain\DTO\PartNumbersDTO;
use App\Domain\Model\PartNumbers;
use App\Domain\DTO\GruposDTO;
use App\Domain\Model\Cronograma;
use App\Domain\Model\Grupos;

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

    public static function modelToLocalizacionesDTO(Localizaciones $model): LocalizacionesDTO
    {
        return new LocalizacionesDTO(
            id_localizacion: $model->id_localizacion,
            id_tipo_localizacion_localizaciones: $model->id_tipo_localizacion_localizaciones,
            descripcion_localizacion: $model->descripcion_localizacion,
            id_tipo_almacenamientos_localizaciones: $model->id_tipo_almacenamientos_localizaciones
        );
    }

    public static function LocalizacionesDTOToModel(LocalizacionesDTO $dto): Localizaciones
    {
        return new Localizaciones(
            $dto->id_localizacion,
            $dto->id_tipo_localizacion_localizaciones,
            $dto->descripcion_localizacion,
            $dto->id_tipo_almacenamientos_localizaciones
        );
    }

    public static function modelToAlmacenesLocalizacionesDTO(AlmacenesLocalizaciones $model): AlmacenesLocalizacionesDTO
    {
        return new AlmacenesLocalizacionesDTO(
            id_localizaciones_almacenes: $model->id_localizaciones_almacenes,
            id_almacen: $model->id_almacen,
            id_localizacion_localizaciones: $model->id_localizacion_localizaciones
        );
    }

    public static function AlmacenesLocalizacionesDTOToModel(AlmacenesLocalizacionesDTO $dto): AlmacenesLocalizaciones
    {
        return new AlmacenesLocalizaciones(
            $dto->id_localizaciones_almacenes,
            $dto->id_almacen,
            $dto->id_localizacion_localizaciones
        );
    }

    public static function modelToPartNumbersDTO(PartNumbers $model): PartNumbersDTO
    {
        return new PartNumbersDTO(
            id_partnumber: $model->id_partnumber,
            partnumber: $model->partnumber,
            descripcion_breve: $model->descripcion_breve,
            id_umb_partnumber: $model->id_umb_partnumber,
            nombre_interno: $model->nombre_interno,
            id_grupo_partnumber: $model->id_grupo_partnumber,
            id_plataforma_partnumber: $model->id_plataforma_partnumber
        );
    }

    public static function partnumbersDTOToModel(PartNumbersDTO $dto): PartNumbers
    {
        return new PartNumbers(
            $dto->id_partnumber,
            $dto->partnumber,
            $dto->descripcion_breve,
            $dto->id_umb_partnumber,
            $dto->nombre_interno,
            $dto->id_grupo_partnumber,
            $dto->id_plataforma_partnumber
        );
    }

    public static function modelToGruposDTO(Grupos $model): GruposDTO
    {
        return new GruposDTO(
            id_grupo: $model->id_grupo,
            descripcion_grupo: $model->descripcion_grupo,
            fecha_programacion_grupo: $model->fecha_programacion_grupo
        );
    }

    public static function GruposDTOToModel(GruposDTO $dto): Grupos
    {
        return new Grupos(
            $dto->id_grupo,
            $dto->descripcion_grupo,
            $dto->fecha_programacion_grupo
        );
    }


    public static function modelToCronogramaDTO(Cronograma $model): CronogramaDTO
    {
        return new CronogramaDTO(
            id_cronograma: $model->id_cronograma,
            fecha_cronograma: $model->fecha_cronograma,
            id_grupo_cronograma: $model->id_grupo_cronograma,
            id_estado_cronograma: $model->id_estado_cronograma,
            id_administrador_cronograma: $model->id_administrador_cronograma
        );
    }

    public static function CronogramaDTOToModel(CronogramaDTO $dto): Cronograma
    {
        return new Cronograma(
            $dto->id_cronograma,
            $dto->fecha_cronograma,
            $dto->id_grupo_cronograma,
            $dto->id_estado_cronograma,
            $dto->id_administrador_cronograma
        );
    }
}
