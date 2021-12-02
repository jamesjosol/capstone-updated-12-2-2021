<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnrollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enrolls', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('school_year_id')->unsigned();
            $table->bigInteger('section_id')->unsigned()->nullable();
            $table->bigInteger('student_id')->unsigned();
            $table->bigInteger('level_id')->unsigned();
            $table->string('tracks', 60)->nullable();
            $table->string('strand', 60)->nullable();
            $table->string('status', 10);
            $table->string('requirement_images');
            $table->decimal('entrance_amount', 8, 2);
            $table->string('OR_num')->nullable();
            $table->string('OR_date')->nullable();
            $table->string('payment_images');

            $table->foreign('school_year_id')->references('id')->on('school_years');
            $table->foreign('section_id')->references('id')->on('sections');
            $table->foreign('student_id')->references('id')->on('students');
            $table->foreign('level_id')->references('id')->on('levels');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enrolls');
    }
}
