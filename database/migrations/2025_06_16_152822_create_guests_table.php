<?php

use App\Models\Invitation;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create the 'guests' table.
        // This table has a foreign key relationship with the 'invitations' table.
        Schema::create('guests', function (Blueprint $table) {
            // The 'id' column serves as the primary key for guests.
            // By default, it's an auto-incrementing unsigned big integer.
            $table->id();

            // 'name' column to store the guest's name.
            $table->string('name');

            // 'email' column to store the guest's email, must be unique and can be null.
            $table->string('email')->unique()->nullable();

            // 'rsvp_count' column to track the number of RSVPs associated with this guest.
            // Default value is 0.
            $table->integer('rsvp_count')->default(0);

            // Define the foreign key relationship:
            // 'invitation_id' will be an unsignedBigInteger column.
            // It references the 'id' column in the 'invitations' table.
            // 'onDelete('cascade')' means if an invitation is deleted,
            // all associated guests will also be deleted.
            $table->foreignIdFor(Invitation::class, 'invitation_id')
                ->constrained() // Automatically assumes 'invitations' table and 'id' column
                ->onDelete('cascade');

            // 'timestamps' creates 'created_at' and 'updated_at' columns.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the 'guests' table if it exists when rolling back migrations.
        Schema::dropIfExists('guests');
    }
};
