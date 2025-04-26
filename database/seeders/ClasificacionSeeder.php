<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClasificacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('clasificacion')->insert([
            [
                'nombre_clasificacion' => 'Frecuente',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_clasificacion' => 'Moroso',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_clasificacion' => 'Nuevo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
