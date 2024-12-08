<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWordCloudDataTable extends Migration
{
    public function up()
    {
        Schema::create('word_cloud_data', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('word'); // The word to display in the cloud
            $table->integer('value'); // The value associated with the word (affects font size)
            $table->timestamps(); // Timestamps for created_at and updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('word_cloud_data');
    }
}

