<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cliente')->insert([
            [
            'nombres_cliente' => 'Eliseo Antonio',
            'apellidos_cliente' => 'Santos Diaz',
            'dui_cliente' => '06448993-1',
            'telefono_cliente' => '7879-0673',
            'nit_cliente' => '002989398493',
            'email_cliente'=> 'Eliseo@gmail.com',
            'barrio'=> 'cuscatlan',
            'monto_max' => 1000.00,
            'id_clasificacion' => 3,
            'id_departamento' => 1,
            'id_municipio' => 1,
            'created_at' => now(),
            'updated_at' => now(),
            ],
            [
            'nombres_cliente' => 'Edras',
            'apellidos_cliente' => 'Lazo',
            'dui_cliente' => '06448993-2',
            'telefono_cliente' => '7879-0673',
            'nit_cliente' => '002989398493',
            'email_cliente'=> 'Edras@gmail.com',
            'barrio'=> 'cuscatlan',
            'monto_max' => 1000.00,
            'id_clasificacion' => 3,
            'id_departamento' => 1,
            'id_municipio' => 1,
            'created_at' => now(),
            'updated_at' => now(),
            ],
        ]);
    }
}
