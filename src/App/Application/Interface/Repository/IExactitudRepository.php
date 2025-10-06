<?php

namespace App\Application\Interface\Repository;

use App\Domain\Model\Exactitud;

interface IExactitudRepository
{
    public function save(Exactitud $exactitud): bool;
}
