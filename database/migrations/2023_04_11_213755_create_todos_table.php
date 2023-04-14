<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTodosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('todos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('performer')->references('id')->on('users');
            $table->foreignId('requester')->references('id')->on('users');
            $table->foreignId('project_id')->references('id')->on('projects');
            $table->string('task');
            $table->string('description');
            $table->enum('priority',['urgent','high','medium','normal','low']);
            $table->dateTime('start_date');
            $table->dateTime('end_date');
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
        Schema::dropIfExists('todos');
    }
}
