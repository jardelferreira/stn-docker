<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('slug',60)->unique();
            $table->foreignId('profession_id')->references('id')->on('professions')->onDelete('cascade');
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('registration')->unique();
            $table->string('area')->nullable();
            $table->string('cpf')->unique();
            $table->date('admission')->nullable();
            $table->timestamps();
        });
        
        Schema::create('employee_project', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreignId('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->timestamps();
        });
        
        Schema::create('employee_base', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('base_id')->references('id')->on('bases')->onDelete('cascade');
            $table->foreignId('employee_id')->references('id')->on('employees')->onDelete('cascade');
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
        Schema::dropIfExists('employee_project');
        Schema::dropIfExists('employee_base');
        Schema::dropIfExists('employees');
    }
}
