<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSignaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('signatures', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('event');
            $table->string('signature');
            $table->longText('signature_image');
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->morphs('signaturable');
            $table->timestamps();
        });
        
        Schema::create('signature_user',function(Blueprint $table){
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('signature_id')->references('id')->on('signatures')->onDelete('cascade');
            $table->string('signature');
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
        Schema::dropIfExists('signature_user');
        Schema::dropIfExists('signatures');
    }
}
