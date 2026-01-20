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
        Schema::create('marque', function (Blueprint $table) {
            $table->increments('id_marque');
            $table->string('libelle', 50)->unique();
            $table->string('pays_origine', 50)->nullable();
            $table->boolean('actif')->default(true);
        });

        Schema::create('couleur', function (Blueprint $table) {
            $table->increments('id_couleur');
            $table->string('libelle', 30)->unique();
        });

        Schema::create('statut_vehicule', function (Blueprint $table) {
            $table->increments('id_statut_vehicule');
            $table->string('libelle', 30)->unique();
        });

        Schema::create('modele', function (Blueprint $table) {
            $table->increments('id_modele');

            $table->unsignedInteger('id_marque');
            $table->string('libelle', 50);
            $table->string('type_vehicule', 30)->nullable();
            $table->string('url_img', 100)->nullable();
            $table->boolean('actif')->default(true);

            $table->unique(['id_marque', 'libelle']);
            $table->foreign('id_marque')->references('id_marque')->on('marque');
        });

        Schema::create('vehicule', function (Blueprint $table) {
            $table->increments('id_vehicule');

            $table->unsignedInteger('id_modele');
            $table->unsignedInteger('id_couleur');
            $table->unsignedInteger('id_statut_vehicule')->default(1);
            $table->integer('nombre_stock')->default(0);
            $table->string('immatriculation', 20)->unique()->nullable();

            $table->integer('annee');
            $table->integer('kilometrage')->nullable();
            $table->string('numero_chassis', 50)->nullable()->unique();
            $table->string('img_vehicule', 255)->nullable();

            $table->decimal('prix_achat', 10, 2);
            $table->decimal('prix_vente', 10, 2);

            $table->date('date_acquisition')->useCurrent();

            $table->foreign('id_modele')->references('id_modele')->on('modele');
            $table->foreign('id_couleur')->references('id_couleur')->on('couleur');
            $table->foreign('id_statut_vehicule')->references('id_statut_vehicule')->on('statut_vehicule');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicule');
        Schema::dropIfExists('modele');
        Schema::dropIfExists('statut_vehicule');
        Schema::dropIfExists('couleur');
        Schema::dropIfExists('marque');
    }
};
