<?php

namespace App\Http\Controllers;

use App\Application\UseCases\Product\GetAllProductsUseCase;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        private GetAllProductsUseCase $getAllProductsUseCase
    )
    {
        //
    }

    public function index()
    {
        $products = $this->getAllProductsUseCase->getAll();

        return view('product.index')
            ->with('products', $products);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
