<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->string('airline');
            $table->string('flight_number');
            $table->string('departure');
            $table->string('destination');
            $table->dateTime('departure_time');
            $table->dateTime('arrival_time');
            $table->integer('price');
            $table->integer('seats_available');
            $table->boolean('last_minute')->default(false);
            $table->boolean('first_minute')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flights');
    }
};

