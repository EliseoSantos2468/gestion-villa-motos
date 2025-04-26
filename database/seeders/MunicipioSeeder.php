<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MunicipioSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('municipio')->insert([
            ['nombre_municipio' => 'San Marcos', 'departamento_id' => 1],
            ['nombre_municipio' => 'Santa Tecla', 'departamento_id' => 2],
        ]);
    }
}

