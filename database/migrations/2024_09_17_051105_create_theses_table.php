<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThesesTable extends Migration
{
    public function up()
    {
        Schema::create('theses', function (Blueprint $table) {
            $table->id(); // Thesis ID
            $table->string('title'); // Title of the thesis
            $table->string('author'); // Author name
            $table->boolean('approved')->default(false); // Approval status (false by default)
            $table->timestamps(); // created_at and updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('theses');
    }
}

