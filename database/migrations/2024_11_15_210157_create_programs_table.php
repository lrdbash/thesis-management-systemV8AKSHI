<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramsTable extends Migration
{
    public function up()
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('name'); // Program name (e.g., 'MSc MFRA')
            $table->integer('students_count')->default(0); // Number of students per program
            $table->integer('enrolled_students')->default(0); // Number of enrolled students
            $table->integer('thesis_topics')->default(0); // Number of thesis topics
            $table->integer('approved_theses')->default(0); // Number of approved theses
            $table->integer('disapproved_theses')->default(0); // Number of disapproved theses
            $table->integer('examiner_duration_0_2')->default(0); // Number of examiners with 0-2 years of experience
            $table->integer('examiner_duration_2_5')->default(0); // Number of examiners with 2-5 years of experience
            $table->integer('examiner_duration_5_10')->default(0); // Number of examiners with 5-10 years of experience
            $table->integer('examiner_duration_10_plus')->default(0); // Number of examiners with 10+ years of experience
            $table->integer('average_response_time')->default(0); // Average response time for the program
            $table->timestamps(); // Timestamps for created_at and updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('programs');
    }
}

