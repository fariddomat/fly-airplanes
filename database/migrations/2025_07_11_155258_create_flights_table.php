<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->foreignId('departure_airport_id')->constrained('airports')->onDelete('cascade');
            $table->foreignId('arrival_airport_id')->constrained('airports')->onDelete('cascade');
            $table->datetime('departure_time');
            $table->datetime('arrival_time');
            $table->string('flight_number');
            $table->integer('price');
            $table->integer('available_seats');
            $table->enum('class', ['Economy', 'Business', 'First']);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('flights');
    }
};
