<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hotelbookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('hotel_id')->constrained('hotels')->onDelete('cascade');
            $table->date('check_in_date');
            $table->date('check_out_date');
            $table->string('room_type')->nullable();
            $table->integer('total_price');
            $table->datetime('booking_date');
            $table->enum('status', ['Confirmed', 'Cancelled', 'Pending']);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hotelbookings');
    }
};