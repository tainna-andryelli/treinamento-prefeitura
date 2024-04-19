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
        Schema::create('attached_files', function (Blueprint $table) {
            $table->id();
            
            //Protocols references
            $table->unsignedBigInteger('protocol_number');
            $table->foreign('protocol_number')->references('number')->on('protocols')->onDelete('cascade');

            $table->string('filename');
            $table->string('filepath');
            $table->string('mime_type'); //file type
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attached_files');
    }
};
