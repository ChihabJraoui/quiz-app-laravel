<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuizzesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quizzes', function (Blueprint $table)
        {
            $table->increments('id');
            $table->integer('subject_id')->unsigned()->index()->nullable();

            $table->string('slug')->unique()->nullable();
            $table->string('name');
            $table->boolean('is_active')->default(false);
            $table->boolean('is_waiting')->default(false);
            $table->boolean('is_started')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quizzes');
    }
}
