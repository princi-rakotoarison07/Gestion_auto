<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MarqueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('marque')->insert([
            ['libelle' => 'Toyota', 'pays_origine' => 'Japon', 'actif' => true],
            ['libelle' => 'Honda', 'pays_origine' => 'Japon', 'actif' => true],
            ['libelle' => 'Mazda', 'pays_origine' => 'Japon', 'actif' => true],
            ['libelle' => 'Renault', 'pays_origine' => 'France', 'actif' => true],
        ]);
    }
}
