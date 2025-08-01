<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
         Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('email')->nullable();
            $table->integer('star_rating')->nullable();
            $table->text('description')->nullable();
            $table->decimal('price_per_night', 8, 2)->default(100.00); // Added for pricing
            $table->float('rating')->nullable(); // Added for hotel rating
            $table->json('amenities')->nullable(); // Added for amenities like wifi, pool, etc.
            $table->string('image')->nullable(); // Added for hotel image
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};
