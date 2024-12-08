<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('intakes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name'); // e.g., "2024 Intake"
            $table->json('chapters')->nullable(); // Store chapter names and deadlines as JSON
            $table->date('final_submission_deadline');
            $table->date('presentation_date');
            $table->enum('status', ['open', 'closed'])->default('open'); // Intake status
            
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('intakes');
    }
};
