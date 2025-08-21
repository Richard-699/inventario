<?php

namespace App\Application\Interface\Service;

interface IBasesDatosSapService {
    public function onGetInformacionSAP($id_partnumber, $id_almacen): ?array;
    public function onGetMB52($id_partnumber): ?array;
    public function procesarArchivosExcel(array $mb52File, array $wmFile, array $cero016File , string $idGrupo, string $id_administrador): void;
    public function procesarArchivo(array $archivo, object $repositorio, string $tipo): void;
}
