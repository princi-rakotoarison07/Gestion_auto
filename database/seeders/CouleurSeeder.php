<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CouleurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('couleur')->insert([
            ['id_couleur' => 1, 'libelle' => 'Noir'],
            ['id_couleur' => 2, 'libelle' => 'Blanc'],
            ['id_couleur' => 3, 'libelle' => 'Gris'],
            ['id_couleur' => 4, 'libelle' => 'Bleu'],
            ['id_couleur' => 5, 'libelle' => 'Rouge'],
            ['id_couleur' => 6, 'libelle' => 'Vert'],
            ['id_couleur' => 7, 'libelle' => 'Argent'],
            ['id_couleur' => 8, 'libelle' => 'Beige'],
        ]);
    }
}
