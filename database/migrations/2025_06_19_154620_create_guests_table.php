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
        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Guest's name
            $table->string('email')->unique()->nullable(); // Guest's email, unique for each guest
            $table->string('phone')->nullable(); // Guest's phone number, optional
            $table->string('status')->default('pending'); // e.g., pending, accepted
            $table->string('rsvp_limit')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guests');
    }
};
