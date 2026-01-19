<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatutPaiementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('statut_paiement')->insert([
            ['id_statut_paiement' => 1, 'libelle' => 'en_attente', 'actif' => true],
            ['id_statut_paiement' => 2, 'libelle' => 'partiel', 'actif' => true],
            ['id_statut_paiement' => 3, 'libelle' => 'complet', 'actif' => true],
            ['id_statut_paiement' => 4, 'libelle' => 'retard', 'actif' => true],
        ]);
    }
}
