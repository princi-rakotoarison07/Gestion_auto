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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger('id_role_utilisateur')->default(2)->after('password');

            $table->foreign('id_role_utilisateur')
                ->references('id_role_utilisateur')
                ->on('role_utilisateur');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['id_role_utilisateur']);
            $table->dropColumn('id_role_utilisateur');
        });
    }
};
