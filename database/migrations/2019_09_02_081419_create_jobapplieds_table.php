<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobappliedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobapplieds', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('candidate_id')->unsigned()->index();
            $table->Integer('job_id')->unsigned()->index();
            $table->unique(['candidate_id', 'job_id']);
            $table->foreign('candidate_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('job_id')->references('id')->on('jobs')->onDelete('cascade');
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
        Schema::dropIfExists('jobapplieds');
    }
}
