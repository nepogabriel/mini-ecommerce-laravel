<?php

namespace App\Application\UseCases\Product;

use App\Domain\Repositories\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class GetAllProductsUseCase
{
    public function __construct(
        private ProductRepositoryInterface $repository
    )
    {
        //
    }

    public function getAll(): Collection
    {
        return $this->repository->getAll();
    }
}