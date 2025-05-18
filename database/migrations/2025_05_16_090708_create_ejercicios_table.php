<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ejercicios', function (Blueprint $table) {
            $table->string('name')->primary();
            $table->string('force')->nullable();
            $table->string('level');
            $table->string('mechanic')->nullable();
            $table->string('equipment')->nullable();
            $table->json('primaryMuscles')->nullable(); // Array in JSON format
            $table->json('secondaryMuscles')->nullable(); // Array in JSON format
            $table->text('instructions')->nullable();
            $table->string('category');
            $table->json('images')->nullable(); // Array in JSON format
        });


    }

    public function down(): void
    {
        Schema::dropIfExists('ejercicios');
    }
};
