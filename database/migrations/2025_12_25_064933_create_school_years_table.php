<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('school_years', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools')->onDelete('cascade');
            $table->foreignId('academic_year_id')->constrained('academic_years')->onDelete('cascade');
            $table->integer('total_students');
            $table->integer('scholarship_no');
            $table->integer('scholarship_by_aarakshyan_no');
            $table->integer('scholarship_by_exam_no');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('school_years');
    }
};
