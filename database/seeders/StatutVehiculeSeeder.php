<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatutVehiculeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('statut_vehicule')->insert([
            ['id_statut_vehicule' => 1, 'libelle' => 'en_stock'],
            ['id_statut_vehicule' => 2, 'libelle' => 'reserve'],
            ['id_statut_vehicule' => 3, 'libelle' => 'vendu'],
            ['id_statut_vehicule' => 4, 'libelle' => 'en_reparation'],
        ]);
    }
}
