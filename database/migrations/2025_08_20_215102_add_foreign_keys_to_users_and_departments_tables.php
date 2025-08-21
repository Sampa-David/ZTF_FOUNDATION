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
            // Vérifie d'abord si la colonne existe
            if (!Schema::hasColumn('users', 'department_id')) {
                $table->foreignId('department_id')->nullable();
            }
            $table->foreign('department_id')
                  ->references('id')
                  ->on('departments')
                  ->onDelete('set null');
        });

        Schema::table('departments', function (Blueprint $table) {
            // Vérifie d'abord si la colonne existe
            if (!Schema::hasColumn('departments', 'head_id')) {
                $table->foreignId('head_id')->nullable();
            }
            $table->foreign('head_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['department_id']);
            $table->dropColumn('department_id');
        });

        Schema::table('departments', function (Blueprint $table) {
            $table->dropForeign(['head_id']);
            $table->dropColumn('head_id');
        });
    }
};
