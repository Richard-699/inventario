<?php

namespace App\Application\Service;

use App\Application\Interface\Service\IPartNumbersService;
use App\Domain\DTO\PartNumbersDTO;
use Exception;
use App\Shared\Mapper\Mapper;
use App\Infrastructure\Database\Connection;
use App\Infrastructure\Repository\UMBRepository;
use App\Infrastructure\Repository\PartNumbersRepository;
use App\Infrastructure\Repository\PlataformaRepository;

class PartNumbersService implements IPartNumbersService
{

    private $db;
    private $partnumbersRepository;
    private $umbRepository;
    private $plataformaRepository;

    public function __construct()
    {
        $this->db = (new Connection())->dbInventarioHwi;

        $this->partnumbersRepository = new PartNumbersRepository($this->db);
        $this->umbRepository = new UMBRepository($this->db);
        $this->plataformaRepository = new PlataformaRepository($this->db);
    }

    public function onGetPartNumbers(): array
    {
        $partnumbers = $this->partnumbersRepository->onGet();
        $umbs = $this->onGetUMBS();

        foreach ($partnumbers as $partnumber) {
            $id = $partnumber->id_umb_partnumber ?? null;
            foreach ($umbs as $umb) {
                if ($id == $umb->id_umb) {
                    $partnumber->umb = $umb->descripcion_umb;
                }
            }
        }

        $plataformas = $this->onGetPlataformas();

        foreach ($partnumbers as $partnumber) {
            $id = $partnumber->id_umb_partnumber ?? null;
            foreach ($plataformas as $plataforma) {
                if ($id == $plataforma->id_plataforma) {
                    $partnumber->plataforma = $plataforma->descripcion_plataforma;
                }
            }
        }

        return $partnumbers;
    }

    public function onGetUMBS(): array
    {
        $umbs = $this->umbRepository->onGet();
        return $umbs;
    }

    public function onGetPlataformas(): array
    {
        $plataformas = $this->plataformaRepository->onGet();
        return $plataformas;
    }
}
