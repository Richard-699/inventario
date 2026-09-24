<?php

namespace App\Application\Interface\Repository;

use App\Domain\Model\Conteo;

interface IConteoRepository {
   public function onGet(): array;
   public function save(Conteo $conteo): bool;
   public function onGetConteo_By__id($id_conteo): ?Conteo;
   public function onGetConteo_By__Fecha_Reciente_Grupo($idGrupo): ?Conteo;
   public function update(Conteo $conteo): bool;

}

?>