<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThesisAllocationsTable extends Migration
{
    public function up()
    {
        Schema::create('thesis_allocations', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('label'); // The label for the treemap
            $table->string('parent'); // The parent label (hierarchy)
            $table->integer('value'); // The allocated value
            $table->timestamps(); // Timestamps for created_at and updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('thesis_allocations');
    }
}

