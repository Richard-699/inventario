<?php

namespace App\Application\Interface\Service;

/* use App\Domain\DTO\AlmacenesDTO; */

interface IBasesDatosSapService {
    public function onGetMB52($id_partnumber): ?array;
}

?>