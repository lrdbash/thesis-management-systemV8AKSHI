<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPasswordToExaminersTable extends Migration
{
    public function up()
    {
        Schema::table('examiners', function (Blueprint $table) {
            $table->string('password');  // Add password column
        });
    }

    public function down()
    {
        Schema::table('examiners', function (Blueprint $table) {
            $table->dropColumn('password');  // Drop password column if rolling back
        });
    }
}
