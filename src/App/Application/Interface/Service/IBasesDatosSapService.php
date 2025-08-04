<?php

namespace App\Application\Interface\Service;


interface IBasesDatosSapService
{
    public function procesarArchivosExcel(array $mb52File, array $wmFile, array $cero016File): void;
    public function procesarArchivo(array $archivo, object $repositorio, string $tipo): void;
}
