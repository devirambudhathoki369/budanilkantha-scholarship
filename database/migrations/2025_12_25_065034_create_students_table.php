<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools')->onDelete('cascade');
            $table->foreignId('academic_year_id')->constrained('academic_years')->onDelete('cascade');
            $table->foreignId('school_year_id')->constrained('school_years')->onDelete('cascade');
            $table->string('student_name');
            $table->string('address')->nullable();
            $table->string('parent_name')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('email')->nullable();
            $table->string('emis_no')->nullable();
            $table->enum('scholarship_type', ['from_aarakshyan', 'from_exam']);
            $table->foreignId('aarakshya_main_id')->nullable()->constrained('aarakshya_main')->onDelete('set null');
            $table->enum('school_type', ['public', 'private'])->nullable();
            $table->decimal('gpa', 3, 2)->nullable();
            $table->integer('entrance_exam_marks')->nullable();
            $table->decimal('total_marks', 5, 2)->nullable();
            $table->integer('rank')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('students');
    }
};
