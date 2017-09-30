<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWellnessQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wellness_questions', function (Blueprint $table) {

            $table->increments('id');

            $table->string('question');

            $table->string('category');

            $table->string('option_1');
            $table->string('option_2');
            $table->string('option_3')->nullable();
            $table->string('option_4')->nullable();

            $table->timestamps();
        });

        Schema::create('user_records', function (Blueprint $table) {

            $table->engine = 'InnoDB';

            $table->increments('id');

            $table->integer('wellness_record_id')->unsigned();

            $table->integer('wellness_question_id')->unsigned();

            $table->string('answer_key');

            $table->foreign('wellness_record_id')
                ->references('id')->on('wellness_records')
                ->onDelete('cascade');

            $table->foreign('wellness_question_id')
                ->references('id')->on('wellness_questions')
                ->onDelete('cascade');

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
        Schema::dropIfExists('wellness_questions');
        Schema::dropIfExists('user_records');
    }
}
