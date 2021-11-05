<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssessmentTables extends Migration
{
    public function up()
    {
        Schema::create('trn_teacher', function (Blueprint $table) {
            $table->id();
            $table->string('nickname');
            $table->integer('status');
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('trn_teacher_role', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('trn_teacher')->cascadeOnDelete();
            $table->integer('role');
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('trn_time_table', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('trn_teacher')->cascadeOnDelete();
            $table->dateTime('lesson_datetime');
            $table->integer('status');
        });

        Schema::create('trn_evaluation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('trn_teacher')->cascadeOnDelete();
            $table->integer('result');
            $table->dateTime('lesson_datetime');
            $table->timestamp('created_at')->useCurrent();
        });
    }
}
