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
        Schema::create('operation_caisse', function (Blueprint $table) {
            $table->increments('id_operation');
            $table->unsignedInteger('id_caisse');
            $table->string('type_operation', 10);
            $table->decimal('montant', 10, 2);
            $table->dateTime('date_operation')->useCurrent();
            $table->string('description', 255)->nullable();
            $table->unsignedInteger('id_paiement')->nullable();

            $table->foreign('id_caisse')->references('id_caisse')->on('caisse');
            $table->foreign('id_paiement')->references('id_paiement')->on('paiement');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operation_caisse');
    }
};
