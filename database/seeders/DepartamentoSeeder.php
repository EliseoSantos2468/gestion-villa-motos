<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartamentoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('departamento')->insert([
            ['nombre_departamento' => 'San Salvador'],
            ['nombre_departamento' => 'La Libertad'],
        ]);
    }
}
