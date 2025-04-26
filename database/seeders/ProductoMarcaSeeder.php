<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductoMarcaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('producto_marca')->insert([
            [
                'producto_id' => 1,
                'marca_id' => 1,
                'cantidad' => 10,
                'precio_cliente' => 650.00,
                'precio_mayoreo' => 600.00,
                'venta_producto' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'producto_id' => 2,
                'marca_id' => 2,
                'cantidad' => 15,
                'precio_cliente' => 55.00,
                'precio_mayoreo' => 50.00,
                'venta_producto' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
