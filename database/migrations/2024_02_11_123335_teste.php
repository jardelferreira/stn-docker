<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Teste extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formlist_base_user',function(Blueprint $table){
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->foreignId('formlist_base_id')->references('id')->on('formlist_base');
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
        Schema::dropIfExists('formlist_base_user');
    }
}
