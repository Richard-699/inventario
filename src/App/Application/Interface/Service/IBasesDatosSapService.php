<?php

namespace App\Application\Interface\Service;

interface IBasesDatosSapService {
    public function onGetInformacionSAP($id_partnumber, $id_almacen): ?array;
    public function procesarArchivosExcel(array $mb52File, array $wmFile, array $cero016File): void;
    public function procesarArchivo(array $archivo, object $repositorio, string $tipo): void;
}
