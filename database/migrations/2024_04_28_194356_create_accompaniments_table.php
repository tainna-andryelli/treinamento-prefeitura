<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('accompaniments', function (Blueprint $table) {
            $table->id();

            $table->text('description');
            $table->enum('status', ['A', 'E', 'S'])->default('A');

            $table->bigInteger('protocol_number')->unsigned();
            $table->foreign('protocol_number')->references('number')->on('protocols')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accompaniments');
    }
};
