<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('employe')->insert([
            ['nom' => 'Dupont', 'prenom' => 'Jean', 'telephone' => '0102030405'],
            ['nom' => 'Martin', 'prenom' => 'Alice', 'telephone' => '0607080910'],
        ]);
    }
}
