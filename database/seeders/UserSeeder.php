<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Eliminar cualquier usuario existente con el mismo correo
        DB::table('users')->where('email', 'admin@villamotos.com')->delete();

        // Insertar usuario
        DB::table('users')->insert([
            'name' => 'Administrador',
            'email' => 'admin@villamotos.com',
            'password' => Hash::make('password123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
