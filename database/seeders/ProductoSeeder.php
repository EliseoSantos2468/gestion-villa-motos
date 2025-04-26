<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insertar productos
        DB::table('producto')->insert([
            ['nombre_producto' => 'Llantas Traseras', 'descripcion_producto' => 'Llantas para vehículos', 'created_at' => now(), 'updated_at' => now()],
            ['nombre_producto' => 'Llantas Delanteras', 'descripcion_producto' => 'Llantas para vehículos', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
