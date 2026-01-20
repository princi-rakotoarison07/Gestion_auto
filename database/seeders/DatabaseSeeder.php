<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\MarqueSeeder;
use Database\Seeders\ModeleSeeder;
use Database\Seeders\ModePaiementSeeder;
use Database\Seeders\CouleurSeeder;
use Database\Seeders\RoleUtilisateurSeeder;
use Database\Seeders\StatutPaiementSeeder;
use Database\Seeders\StatutVehiculeSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            MarqueSeeder::class,
            ModeleSeeder::class,
            CouleurSeeder::class,
            StatutVehiculeSeeder::class,
            StatutPaiementSeeder::class,
            ModePaiementSeeder::class,
            RoleUtilisateurSeeder::class,
            EmployeSeeder::class,
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
