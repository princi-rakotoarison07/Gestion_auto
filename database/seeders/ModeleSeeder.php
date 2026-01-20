<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModeleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $marques = DB::table('marque')->pluck('id_marque', 'libelle');

        $data = [];

        if (isset($marques['Toyota'])) {
            $data[] = [
                'id_marque' => $marques['Toyota'],
                'libelle' => 'Corolla',
                'type_vehicule' => 'Berline',
                'url_img' => 'assets/img/car-default.png',
                'actif' => true,
            ];
        }

        if (isset($marques['Honda'])) {
            $data[] = [
                'id_marque' => $marques['Honda'],
                'libelle' => 'Civic',
                'type_vehicule' => 'Berline',
                'url_img' => 'assets/img/car-default.png',
                'actif' => true,
            ];
        }

        if (isset($marques['Mazda'])) {
            $data[] = [
                'id_marque' => $marques['Mazda'],
                'libelle' => 'CX-5',
                'type_vehicule' => 'SUV',
                'url_img' => 'assets/img/car-default.png',
                'actif' => true,
            ];
        }

        if (isset($marques['Renault'])) {
            $data[] = [
                'id_marque' => $marques['Renault'],
                'libelle' => 'Clio',
                'type_vehicule' => 'Citadine',
                'url_img' => 'assets/img/car-default.png',
                'actif' => true,
            ];
        }

        if (!empty($data)) {
            DB::table('modele')->insert($data);
        }
    }
}
