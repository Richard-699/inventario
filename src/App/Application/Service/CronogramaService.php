<?php

namespace App\Application\Service;

use App\Application\Interface\Service\ICronogramaService;
use App\Domain\DTO\GruposDTO;
use App\Domain\Model\Grupos;
use App\Infrastructure\Repository\PartNumbersRepository;
use Exception;
use App\Shared\Mapper\Mapper;
use App\Infrastructure\Database\Connection;
use App\Infrastructure\Repository\CronogramaRepository;

class CronogramaService implements ICronogramaService
{

    private $db;
    private $cronogramaRepository;
    private $partNumberRepository;

    public function __construct()
    {
        $this->db = (new Connection())->dbInventarioHwi;
        $this->cronogramaRepository = new CronogramaRepository($this->db);
        $this->partNumberRepository = new PartNumbersRepository($this->db);
    }

    public function onGetCronograma($mes_inicial, $mes_final): array
    {
        if($mes_inicial != null && $mes_final != null){
            $cronograma = $this->cronogramaRepository->onGet_By__Fecha($mes_inicial, $mes_final);
        }else{
            $cronograma = $this->cronogramaRepository->onGet();
        }
        
        return $cronograma;
    }
}
