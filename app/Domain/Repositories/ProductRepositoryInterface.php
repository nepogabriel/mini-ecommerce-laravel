<?php

namespace App\Domain\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface ProductRepositoryInterface
{
    public function getAll(): Collection;

    public function findByIds(array $ids);
}