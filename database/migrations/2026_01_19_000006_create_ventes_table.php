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
        Schema::create('vente', function (Blueprint $table) {
            $table->increments('id_vente');
            $table->date('date_vente')->useCurrent();

            $table->unsignedInteger('id_vehicule');
            $table->unsignedInteger('id_client');
            $table->unsignedInteger('id_employe');

            $table->decimal('montant_total', 10, 2);

            $table->unsignedInteger('id_statut_paiement')->default(1);
            $table->date('date_paiement_complet')->nullable();

            $table->unique('id_vehicule');

            $table->foreign('id_vehicule')->references('id_vehicule')->on('vehicule');
            $table->foreign('id_client')->references('id_client')->on('client');
            $table->foreign('id_employe')->references('id_employe')->on('employe');
            $table->foreign('id_statut_paiement')->references('id_statut_paiement')->on('statut_paiement');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vente');
    }
};
