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
            $table->foreignId('rentalcompany_id')->constrained('rentalcompanies')->onDelete('cascade');
            $table->foreignId('car_id')->constrained('cars')->onDelete('cascade');
            $table->text('pickup_location');
            $table->text('return_location');
            $table->datetime('pickup_date');
            $table->datetime('return_date');
            $table->integer('total_price');
            $table->datetime('booking_date');
            $table->enum('status', ['Confirmed', 'Cancelled', 'Pending']);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carrentals');
    }
};