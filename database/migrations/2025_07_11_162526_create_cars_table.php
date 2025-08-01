<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rentalcompany_id')->constrained('rentalcompanies')->onDelete('cascade');
            $table->string('name');
            $table->integer('year');
            $table->enum('type', ['economy', 'compact', 'sedan', 'suv', 'luxury', 'van', 'convertible']);
            $table->enum('transmission', ['automatic', 'manual']);
            $table->enum('fuel_type', ['petrol', 'diesel', 'hybrid', 'electric']);
            $table->integer('price');
            $table->string('img');
            $table->integer('seats');
            $table->integer('luggage_capacity');
            $table->json('features')->nullable();
            $table->integer('rating')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
