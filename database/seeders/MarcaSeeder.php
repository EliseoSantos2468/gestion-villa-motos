<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MarcaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('marca')->insert([
            ['nombre_marca' => 'Yamaha'],
            ['nombre_marca' => 'Suzuki'],
        ]);
    }
}

