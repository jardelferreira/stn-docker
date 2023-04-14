<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTodoProgressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('todo_progress', function (Blueprint $table) {
            $table->id();
            $table->enum('status',['created','finished','running', 'pending','stopped', 'cancelled'])->default('created');
            $table->foreignId('status_id')->references('id')->on('status');
            $table->string('description');
            $table->foreignId('todo_id')->references('id')->on('todos');
            $table->integer('last_progress')->default(-1);
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
        Schema::dropIfExists('todo_progress');
    }
}
