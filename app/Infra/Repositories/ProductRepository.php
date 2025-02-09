<?php

namespace App\Infra\Repositories;

use App\Domain\Repositories\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository implements ProductRepositoryInterface
{
    public function getAll(): Collection
    {
        return Product::all();
    }

    public function findByIds(array $ids): Collection
    {
        return Product::whereIn('id', $ids)->get();
    }
}