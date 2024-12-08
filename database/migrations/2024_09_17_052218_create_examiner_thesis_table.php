<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExaminerThesisTable extends Migration
{
    public function up()
    {
        Schema::create('examiner_thesis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('examiner_id')->constrained()->onDelete('cascade');
            $table->foreignId('thesis_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('examiner_thesis');
    }
}

