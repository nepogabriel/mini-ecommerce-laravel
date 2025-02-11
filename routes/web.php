<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class, 'index'])->name('product.index');

Route::controller(CartController::class)->group(function () {
    Route::get('/carrinho', 'index')->name('cart.index');
    Route::post('/carrinho/adicionar','addToCart')->name('cart.add');
    Route::get('/carrinho/total','getTotal')->name('cart.total');
    Route::delete('/carrinho/remover','removeProduct')->name('cart.remove');
});

route::get('/pagamento', [CheckoutController::class, 'index'])->name('checkout.index');
route::post('/pagamento/processar', [CheckoutController::class, 'processCheckout'])->name('checkout.process');