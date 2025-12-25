<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('academic_years', function (Blueprint $table) {
            $table->id();
            $table->string('academic_year');
            $table->string('start_date');
            $table->string('end_date');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('academic_years');
    }
};
