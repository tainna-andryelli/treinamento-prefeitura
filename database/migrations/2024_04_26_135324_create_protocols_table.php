<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('protocols', function (Blueprint $table) {
            $table->bigIncrements('number');
            $table->string('description', 2000);
            $table->date('created_date');
            $table->integer('deadline_days');
            $table->foreignId('contributor_id')->constrained('people')->onDelete('cascade');
            $table->foreignId('department_id')->constrained('departments')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('protocols');
    }
};
