<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReferenciasPersonalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('referencias_personales')->insert([
            [
                'telefono_ref' => '8888-1234',
                'nombre_ref' => 'Carlos Méndez',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'telefono_ref' => '7777-5678',
                'nombre_ref' => 'María López',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
