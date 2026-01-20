<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleUtilisateurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('role_utilisateur')->insert([
            ['id_role_utilisateur' => 1, 'libelle' => 'admin'],
            ['id_role_utilisateur' => 2, 'libelle' => 'vendeur'],
            ['id_role_utilisateur' => 3, 'libelle' => 'dg'],
        ]);
    }
}
