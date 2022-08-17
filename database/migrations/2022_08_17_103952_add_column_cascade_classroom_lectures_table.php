<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('classroom_lectures', function (Blueprint $table){
           $table->foreignId('lecture_id')->nullable()->nullOnDelete()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('classroom_lectures', function (Blueprint $table){
            $table->foreignId('lecture_id')->change();
        });
    }
};
