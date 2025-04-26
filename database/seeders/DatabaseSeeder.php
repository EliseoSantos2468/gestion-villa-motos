<?php

namespace Database\Seeders;

use App\Models\Clasificacion;
use App\Models\Departamento;
use App\Models\Interes;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ReferenciasPersonalesSeeder::class,
            ClasificacionSeeder::class,
            InteresSeeder::class,
            DepartamentoSeeder::class,
            MunicipioSeeder::class,
            MarcaSeeder::class,
            ProductoSeeder::class,
            ProductoMarcaSeeder::class,
            ClienteSeeder::class,
            ClienteReferenciaSeeder::class,
        ]);
    }
}
