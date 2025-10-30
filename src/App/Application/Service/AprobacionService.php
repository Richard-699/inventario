<?php

namespace App\Application\Service;

use App\Application\Interface\Service\IAprobacionService;
use App\Infrastructure\Repository\GruposRepository;
use Exception;
use App\Shared\Mapper\Mapper;
use App\Infrastructure\Database\Connection;
use App\Infrastructure\Repository\AdministradoresRepository;
use App\Infrastructure\Repository\ConteoRepository;

class AprobacionService implements IAprobacionService
{

    private $db;
    private $conteoRepository;
    private $gruposRepository;
    private $administradoresRepository;

    public function __construct()
    {
        $this->db = (new Connection())->dbInventarioHwi;
        $this->conteoRepository = new ConteoRepository($this->db);
        $this->gruposRepository = new GruposRepository($this->db);
        $this->administradoresRepository = new AdministradoresRepository($this->db);
    }

    public function onGetConteo(): array
    {
        $conteos = $this->conteoRepository->onGet();

        // Validar si el array de conteos es nulo o vacío
        if ($conteos === null || empty($conteos)) {
            return [];
        }

        $resultadosFinales = [];

        // Recorrer cada registro de conteo
        foreach ($conteos as $conteo) {
            // Asegurarse de que el conteo sea un objeto o un array antes de acceder
            $conteoObject = (object) $conteo;

            $id_grupo_conteo = $conteoObject->id_grupo_conteo ?? null;
            $id_encargado_conteo = $conteoObject->id_encargado_conteo ?? null;

            $descripcion_grupo = 'N/A';
            $nombre_encargado = 'N/A';
            $apellidos_administrador = '';

            // Consultar la información del grupo solo si el ID existe
            if ($id_grupo_conteo) {
                $infoGrupo = $this->gruposRepository->onGet_By__Id($id_grupo_conteo);
                if ($infoGrupo) {
                    $descripcion_grupo = $infoGrupo->descripcion_grupo;
                }
            }

            // Consultar la información del encargado solo si el ID existe
            if ($id_encargado_conteo) {
                $infoEncargado = $this->administradoresRepository->onGet_By__Id($id_encargado_conteo);
                if ($infoEncargado) {
                    $nombre_encargado = $infoEncargado->nombre_administrador;
                    $apellidos_administrador = $infoEncargado->apellidos_administrador;
                }
            }

            // Crear un nuevo objeto o array para el resultado final
            $conteoCompleto = (array) $conteoObject;
            $conteoCompleto['descripcion_grupo'] = $descripcion_grupo;
            $conteoCompleto['nombre_encargado'] = $nombre_encargado . ' ' . $apellidos_administrador;

            $resultadosFinales[] = $conteoCompleto;
        }

        return $resultadosFinales;
    }
}
