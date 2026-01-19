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
            $table->string('immatriculation', 20)->unique()->nullable();

            $table->integer('annee');
            $table->string('couleur', 30)->nullable();
            $table->integer('kilometrage')->nullable();
            $table->string('numero_chassis', 50)->nullable()->unique();

            $table->decimal('prix_achat', 10, 2);
            $table->decimal('prix_vente', 10, 2);

            $table->enum('statut', ['en_stock', 'vendu', 'en_reparation', 'reserve'])->default('en_stock');
            $table->date('date_acquisition')->useCurrent();

            $table->foreign('id_modele')->references('id_modele')->on('modele');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicule');
        Schema::dropIfExists('modele');
        Schema::dropIfExists('marque');
    }
};
