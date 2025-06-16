<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create the 'invitations' table. This table must exist before 'guests'
        // due to the foreign key constraint.
        Schema::create('invitations', function (Blueprint $table) {
            // The 'id' column serves as the primary key for invitations.
            // By default, it's an auto-incrementing unsigned big integer.
            $table->id();

            // 'code' column to store a unique invitation code.
            $table->string('code')->unique();

            // 'rsvp_limit' column to define how many RSVPs an invitation allows.
            // Default value is 1.
            $table->integer('rsvp_limit')->default(1);

            // 'timestamps' creates 'created_at' and 'updated_at' columns.
            // Corrected typo from 'times tamps()' to 'timestamps()'.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the 'invitations' table if it exists when rolling back migrations.
        Schema::dropIfExists('invitations');
    }
};