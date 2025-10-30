<?php

namespace App\Application\Interface\Service;

interface IBasesDatosSapService {
    public function onGetInformacionSAP($id_partnumber, $id_almacen): ?array;
    public function procesarArchivosExcel(array $mb52File, array $wmFile, array $cero016File , string $idGrupo, string $id_administrador): void;
    public function procesarArchivo(array $archivo, object $repositorio, string $tipo): void;
    public function procesarArchivosExcelExactitud(array $lx03, string $id_administrador, array $gruposSeleccionados, string $vacias): void;

}
