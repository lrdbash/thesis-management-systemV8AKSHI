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
        Schema::table('intakes', function (Blueprint $table) {
            $table->json('chapters')->change(); // Change LONGTEXT to JSON
        });
    }
    
    public function down()
    {
        Schema::table('intakes', function (Blueprint $table) {
            $table->longText('chapters')->change(); // Revert if needed
        });
    }
    
};
