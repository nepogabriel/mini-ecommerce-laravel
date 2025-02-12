<?php

namespace Tests\App\Application\UseCases\Cart;

use App\Application\UseCases\Cart\CalculateCartTotalUseCase;
use App\Application\UseCases\Payment\CalculateDiscountUseCase;
use App\Domain\Repositories\CartRepositoryInterface;
use App\Domain\Repositories\ProductRepositoryInterface;
use Tests\TestCase;

class CalculateCartTotalCaseUseTest extends TestCase
{
    public function testCalculateCartTotalWithEmptyCart()
    {
        $cartRepository = $this->createMock(CartRepositoryInterface::class);
        $productRepository = $this->createMock(ProductRepositoryInterface::class);
        $calculateDiscount = $this->createMock(CalculateDiscountUseCase::class);

        $cartRepository->method('getCartItems')->willReturn([]);

        $useCase = new CalculateCartTotalUseCase($cartRepository, $productRepository, $calculateDiscount);
        $result = $useCase->calculateCartToTotal('cart');

        $this->assertFalse($result['success']);
        $this->assertEquals(0, $result['total']);
    }
}