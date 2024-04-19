<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('profile', ['T', 'S', 'A'])->default('A');
            $table->string('cpf');
            $table->enum('active', ['S', 'N'])->default('S');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('profile');
            $table->dropColumn('cpf');
            $table->dropColumn('active');
        });
    }
};
