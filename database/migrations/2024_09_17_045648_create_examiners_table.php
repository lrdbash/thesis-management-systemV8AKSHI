<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExaminersTable extends Migration
{
    public function up()
    {
        Schema::create('examiners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('contact_details');
            $table->string('email')->unique();
            $table->string('cv_path'); // Path to store the uploaded CV
            $table->date('registered_at'); // Date they registered
            $table->date('registration_expires_at'); // Date registration expires
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('examiners');
    }
}

