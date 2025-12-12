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
    Schema::table('users', function (Blueprint $table) {
        $table->boolean('estado')->default(1); // o 0 según lo que necesites
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('estado');
    });
}
};
