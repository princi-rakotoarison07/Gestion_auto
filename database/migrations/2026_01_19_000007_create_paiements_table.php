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
        Schema::create('paiement', function (Blueprint $table) {
            $table->increments('id_paiement');
            $table->unsignedInteger('id_vente');
            $table->unsignedInteger('id_mode_paiement');
            $table->date('date_paiement')->useCurrent();
            $table->decimal('montant', 10, 2);
            $table->string('reference', 100)->nullable();

            $table->foreign('id_vente')->references('id_vente')->on('vente');
            $table->foreign('id_mode_paiement')->references('id_mode_paiement')->on('mode_paiement');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiement');
    }
};
