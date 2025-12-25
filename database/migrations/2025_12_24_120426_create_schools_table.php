<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('emis_no')->nullable();
            $table->string('school_name');
            $table->string('address')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('email')->nullable();
            $table->foreignId('ward_id')->constrained('wards')->onDelete('cascade');
            $table->enum('school_type', ['public', 'private']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('schools');
    }
};
