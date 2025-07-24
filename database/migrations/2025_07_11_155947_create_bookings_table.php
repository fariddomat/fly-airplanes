<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('flight_id')->constrained('flights')->onDelete('cascade');
            $table->integer('num_passengers');
            $table->datetime('booking_date');
            $table->integer('total_price');
            $table->enum('status', ['Confirmed', 'Cancelled', 'Pending']);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};