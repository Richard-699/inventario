<?php

namespace App\Application\Service;

use App\Application\Interface\Service\IAlmacenesService;
use App\Domain\DTO\AlmacenesDTO;
use App\Infrastructure\Repository\AlmacenesRepository;
use Exception;
use App\Shared\Mapper\Mapper;
use App\Infrastructure\Database\Connection;

class AlmacenesService implements IAlmacenesService
{

    private $db;
    private $almacenesRepository;

    public function __construct()
    {
        $this->db = (new Connection())->dbInventarioHwi;

        $this->almacenesRepository = new AlmacenesRepository($this->db);
    }

    public function onGetAlmacenes(): array
    {
        $almacenes = $this->almacenesRepository->onGet();
        return $almacenes;
    }

    public function saveAlmacen(AlmacenesDTO $almacenesDTO): bool
    {
        $almacenes = Mapper::AlmacenesDTOToModel($almacenesDTO);
        $guardarAlmacen = $this->almacenesRepository->save($almacenes);

        if (!$guardarAlmacen) {
            return false;
        } else {
            return true;
        }
    }

    public function deleteAlmacen($id): bool
    {
        $delete_almacen = $this->almacenesRepository->delete($id);
        if ($delete_almacen === 0) {
            return false;
        }else{
            return true;
        }

    }
}
