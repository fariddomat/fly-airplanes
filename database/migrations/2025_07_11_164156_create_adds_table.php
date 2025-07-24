<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('adds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');
            $table->boolean('insurance_purchased');
            $table->foreignId('carrental_id')->constrained('carrentals')->onDelete('cascade');
            $table->foreignId('hotelbooking_id')->constrained('hotelbookings')->onDelete('cascade');
            $table->string('payment_method');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('adds');
    }
};