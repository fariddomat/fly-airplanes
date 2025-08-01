<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('carrentals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('car_id')->constrained('cars')->onDelete('cascade');
            $table->text('pickup_location');
            $table->text('return_location')->nullable();
            $table->date('pickup_date');
            $table->string('pickup_time');
            $table->date('return_date');
            $table->string('dropoff_time');
            $table->integer('total_price');
            $table->datetime('booking_date');
            $table->enum('status', ['Confirmed', 'Cancelled', 'Pending']);
            $table->enum('rental_type', ['same-location', 'different-location']);
            $table->enum('driver_age', ['21-24', '25-29', '30-64', '65+']);
            $table->json('extras')->nullable();
            $table->json('driver_details')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carrentals');
    }
};
