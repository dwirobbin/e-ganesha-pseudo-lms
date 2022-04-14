<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUploadAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upload_answers', function (Blueprint $table) {
            $table->id();
            $table->string('file_name');
            $table->foreignId('teacher_course_id');
            $table->foreignId('course_id');
            $table->foreignId('class_year_id');
            $table->foreignId('bab_id');
            $table->foreignId('user_id');
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
        Schema::dropIfExists('upload_answers');
    }
}
