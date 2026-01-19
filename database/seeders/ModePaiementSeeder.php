<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModePaiementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('mode_paiement')->insert([
            ['libelle' => 'espece', 'actif' => true],
            ['libelle' => 'carte', 'actif' => true],
            ['libelle' => 'cheque', 'actif' => true],
            ['libelle' => 'Mvola', 'actif' => true],
            ['libelle' => 'Orange', 'actif' => true],
        ]);
    }
}
