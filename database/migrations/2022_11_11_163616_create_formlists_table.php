<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormlistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // ['uuid','name','initials','revision','area','base_id']
        Schema::create('formlists', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('revision');
            $table->string('area');
            $table->timestamps();
        });


        Schema::create('formlist_base',function(Blueprint $table){
            $table->id();
            $table->foreignId('base_id')->references('id')->on('bases')->onDelete('cascade');
            $table->foreignId('formlist_id')->references('id')->on('formlists')->onDelete('cascade');
            $table->unique(['base_id','formlist_id'],'base_formlist_unique');
            $table->timestamps();
        });
        Schema::create('formlist_employee',function(Blueprint $table){
            $table->id();
            $table->foreignId('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreignId('formlist_id')->references('id')->on('formlists')->onDelete('cascade');
            $table->unique(['employee_id','formlist_id'],'formlist_employee_unique');
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
        Schema::dropIfExists('formlist_employee');
        Schema::dropIfExists('formlist_base');
        Schema::dropIfExists('formlists');
    }
}
