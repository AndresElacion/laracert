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
        Schema::create('certificate_template_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Add category_id to events table
        Schema::table('events', function (Blueprint $table) {
            $table->foreignId('certificate_template_category_id')
                  ->nullable()
                  ->constrained('certificate_template_categories')
                  ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropForeignId('events_certificate_template_category_id_foreign');
            $table->dropColumn('certificate_template_category_id');
        });
        Schema::dropIfExists('certificate_template_categories');
    }
};
