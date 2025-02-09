<?php

namespace App\Application\UseCases\Cart;

use App\Domain\Repositories\ProductRepositoryInterface;

class GetCartUseCase
{
    public function __construct(
        private ProductRepositoryInterface $productReposityory
    )
    {
        //
    }

    public function getCart(): array
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return [
                'success' => false,
                'message' => 'O carrinho está vazio!',
                'cart' => [],
            ];
        }

        $productIds = array_keys($cart);
        $products = $this->productReposityory->findByIds($productIds);

        $cartDetails = [];

        foreach ($products as $product) {
            $cartDetails[] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $cart[$product->id],
                'subtotal' => $product->price * $cart[$product->id],
            ];
        }

        return $cartDetails;
    }
}