<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('text');
            $table->string('type')->nullable();
            $table->string('color')->nullable();
            $table->string('textColor')->nullable();
            $table->string('progressColor')->nullable();
            $table->integer('duration');
            $table->float('progress');
            $table->dateTime('start_date');
            $table->integer('parent');
            $table->integer('sortorder')->default(0);
            $table->integer('priority')->default(1);
            $table->timestamps();
        });

        Schema::create('project_tasks',function(Blueprint $table){
            $table->id();
            $table->foreignId('task_id')->references('id')->on('tasks');
            $table->foreignId('project_id')->references('id')->on('projects');
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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('project_tasks');
        Schema::dropIfExists('tasks');
    }
}
