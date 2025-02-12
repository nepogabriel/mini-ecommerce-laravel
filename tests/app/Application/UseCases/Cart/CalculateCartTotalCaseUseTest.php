<?php

namespace Tests\App\Application\UseCases\Cart;

use App\Application\UseCases\Cart\CalculateCartTotalUseCase;
use App\Application\UseCases\Payment\CalculateDiscountUseCase;
use App\Domain\Repositories\CartRepositoryInterface;
use App\Domain\Repositories\ProductRepositoryInterface;
use Tests\TestCase;

class CalculateCartTotalCaseUseTest extends TestCase
{
    private CartRepositoryInterface $cartRepository;
    private ProductRepositoryInterface $productRepository;
    private CalculateDiscountUseCase $calculateDiscountUseCase;
    private CalculateCartTotalUseCase $calculateCartTotalUseCase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->cartRepository = $this->createMock(CartRepositoryInterface::class);
        $this->productRepository = $this->createMock(ProductRepositoryInterface::class);
        $this->calculateDiscountUseCase = $this->createMock(CalculateDiscountUseCase::class);
    
        $this->calculateCartTotalUseCase = new CalculateCartTotalUseCase(
            $this->cartRepository,
            $this->productRepository,
            $this->calculateDiscountUseCase
        );
    }

    public function testCalculateCartTotalWithEmptyCart(): void
    {
        $this->cartRepository
            ->method('getCartItems')
            ->willReturn([]);

        $result = $this->calculateCartTotalUseCase->calculateCartToTotal('sessionId');

        $this->assertFalse($result['success']);
        $this->assertEquals(0, $result['total']);
    }

    public function testCalculateCartTotalWithProducts(): void
    {
        $cartItems = [
            1 => 2,
            2 => 4,
            3 => 1,
        ];

        $this->cartRepository
            ->method('getCartItems')
            ->willReturn($cartItems);

        $products = collect([
            (object) ['id' => 1, 'name' => 'Teclado Mecânico RGB', 'price' => 250.00, 'stock_quantity' => 150],
            (object) ['id' => 2, 'name' => 'Mouse 7200 DPI', 'price' => 150.00, 'stock_quantity' => 100],
            (object) ['id' => 3, 'name' => 'Monitor 24" Full HD', 'price' => 899.90, 'stock_quantity' => 130],
        ]);

        $this->productRepository
            ->method('findByIds')
            ->with(array_keys($cartItems))
            ->willReturn($products);

        $subtotal = 1999.90;

        $this->calculateDiscountUseCase
            ->method('calculateDiscount')
            ->with($subtotal)
            ->willReturn(1799.91);

        $result = $this->calculateCartTotalUseCase->calculateCartToTotal('sessionId');

        $this->assertTrue($result['success']);
        $this->assertEquals( $subtotal, $result['subtotal']);
        $this->assertEquals( 1999.90, $result['total']);
        $this->assertEquals(1799.91, $result['discountedTotal']);
    }
}