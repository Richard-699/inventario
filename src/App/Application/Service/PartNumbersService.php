<?php

namespace App\Application\Service;

use App\Application\Interface\Service\IPartNumbersService;
use App\Domain\DTO\PartNumbersDTO;
use Exception;
use App\Shared\Mapper\Mapper;
use App\Infrastructure\Database\Connection;
use App\Infrastructure\Repository\GruposRepository;
use App\Infrastructure\Repository\UMBRepository;
use App\Infrastructure\Repository\PartNumbersRepository;
use App\Infrastructure\Repository\PlataformaRepository;

class PartNumbersService implements IPartNumbersService
{

    private $db;
    private $partnumbersRepository;
    private $umbRepository;
    private $plataformaRepository;
    private $gruposRepository;

    public function __construct()
    {
        $this->db = (new Connection())->dbInventarioHwi;

        $this->partnumbersRepository = new PartNumbersRepository($this->db);
        $this->umbRepository = new UMBRepository($this->db);
        $this->plataformaRepository = new PlataformaRepository($this->db);
        $this->gruposRepository = new GruposRepository($this->db);
    }

    public function onGetPartNumbers($id): array
    {
        if($id == null){
            $partnumbers = $this->partnumbersRepository->onGet();
        }else{
            $partnumbers = $this->partnumbersRepository->onGet_By__Id_Grupo($id);
        }
        
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
            $id = $partnumber->id_plataforma_partnumber ?? null;
            foreach ($plataformas as $plataforma) {
                if ($id == $plataforma->id_plataforma) {
                    $partnumber->plataforma = $plataforma->descripcion_plataforma;
                }
            }
        }

        $grupos = $this->onGetGrupos();

        foreach ($partnumbers as $partnumber) {
            $id = $partnumber->id_grupo_partnumber ?? null;
            if($id == null){
                $partnumber->grupo = 'No asignado';
            }else{
                foreach ($grupos as $grupo) {
                    if ($id == $grupo->id_grupo) {
                        $partnumber->grupo = $grupo->descripcion_grupo;
                    }
                }
            }
        }

        return $partnumbers;
    }

    public function onGetPartNumber_By__Id($id): PartNumbersDTO
    {
        $partnumber = $this->partnumbersRepository->onGet_By__Id($id);
        $partnumberDTO = Mapper::modelToPartNumbersDTO($partnumber);
        return $partnumberDTO;
    }

    public function onGetPartNumber_By__Codigo($codigo): ?PartNumbersDTO
    {
        $partnumber = $this->partnumbersRepository->onGet_By__Codigo($codigo);
        if ($partnumber === null) {
            return null;
        }

        return Mapper::modelToPartNumbersDTO($partnumber);
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

    public function onGetGrupos(): array
    {
        $grupos = $this->gruposRepository->onGet();
        return $grupos;
    }

    public function savePartNumbers(array $partnumbersDTO): bool
    {
        try {
            $this->db->beginTransaction();

            foreach ($partnumbersDTO as $partnumberDTO) {                
                $codigo = $partnumberDTO->partnumber;
                $existe_partnumber = $this->onGetPartNumber_By__Codigo($codigo);
                if ($existe_partnumber !== null && !empty($existe_partnumber->id_partnumber)) {
                    throw new Exception("El partnumber '$codigo' ya se encuentra registrado");
                }

                $partnumbers = Mapper::partnumbersDTOToModel($partnumberDTO);
                $this->partnumbersRepository->save($partnumbers);
            }

            $this->db->commit();
            return true;
        } catch (\Throwable $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function deletePartNumbers($id): bool
    {
        $delete_partnumber = $this->partnumbersRepository->delete($id);
        if ($delete_partnumber === 0) {
            return false;
        } else {
            return true;
        }
        return true;
    }

    public function updatePartNumber(PartNumbersDTO $partnumbersDTO): bool
    {
        $partnumber = Mapper::partnumbersDTOToModel($partnumbersDTO);
        $guardarPartNumber = $this->partnumbersRepository->update($partnumber);

        if (!$guardarPartNumber) {
            return false;
        } else {
            return true;
        }
    }
}
