<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InteresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('interes')->insert([
            'interes_general' => 1.10, // 10%
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
