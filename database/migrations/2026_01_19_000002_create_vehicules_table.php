<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vehicule', function (Blueprint $table) {
            $table->increments('id_vehicule');
            $table->string('immatriculation', 20)->unique()->nullable();
            $table->string('marque', 50);
            $table->string('modele', 50);
            $table->string('url_img', 50);
            $table->integer('annee');
            $table->decimal('prix_achat', 10, 2);
            $table->decimal('prix_vente', 10, 2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicule');
    }
};
