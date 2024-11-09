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
        Schema::table('events', function (Blueprint $table) {
            $table->dropConstrainedForeignId('coordinator_id');
        });

        // Create the pivot table
        Schema::create('event_coordinators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->foreignId('coordinator_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            // Prevent duplicate assignments
            $table->unique(['event_id', 'coordinator_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::dropIfExists('event_coordinator');

        // Restore the original column
        Schema::table('events', function (Blueprint $table) {
            $table->foreignId('coordinator_id')
                  ->nullable()
                  ->constrained('coordinators')
                  ->nullOnDelete();
        });
    }
};
