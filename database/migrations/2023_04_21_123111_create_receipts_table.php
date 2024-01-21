<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipts', function (Blueprint $table) { 
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->foreignId('branch_id')->references('id')->on('branches');
            $table->integer('signature_id',false,true)->default(0);
            $table->string('favored');
            $table->string('link')->nullable();
            $table->string('temporary_link')->nullable();
            $table->string('register');
            $table->decimal('value',8,2,true);
            $table->string('local');
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
        Schema::dropIfExists('receipts');
    }
}
