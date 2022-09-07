<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfficesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('professions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('slug',60)->unique();
            $table->string('name');
            $table->string('description');
            $table->decimal('salary',8,2,true);
            $table->boolean('aditional');
            $table->decimal('percent',2,2,true);
            $table->timestamps();
        });
        
        Schema::create('profession_project', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreignId('profession_id')->references('id')->on('professions')->onDelete('cascade');
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
        Schema::dropIfExists('profession_project');
        Schema::dropIfExists('professions');
    }
}
