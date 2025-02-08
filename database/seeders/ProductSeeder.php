<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'name' => 'Teclado Mecânico RGB',
                'price' => 250.00,
                'stock_quantity' => 150,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mouse 7200 DPI',
                'price' => 150.00,
                'stock_quantity' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Monitor 24" Full HD',
                'price' => 899.90,
                'stock_quantity' => 130,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Cadeira Reclinável',
                'price' => 1299.99,
                'stock_quantity' => 120,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Headset Bluetooth',
                'price' => 199.99,
                'stock_quantity' => 75,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'SSD NVMe 1TB',
                'price' => 550.00,
                'stock_quantity' => 140,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Placa de Vídeo RTX 3060',
                'price' => 2499.90,
                'stock_quantity' => 115,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Gabinete ATX com RGB',
                'price' => 399.99,
                'stock_quantity' => 235,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
