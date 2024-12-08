<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgram1sTable extends Migration
{
    public function up()
    {
        Schema::create('program1s', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('enrolled_students');
            $table->integer('passed_students');
            $table->integer('failed_students');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('program1s');
    }
}

