<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stoks', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('slug');
            $table->foreignId('sector_id')->references('id')->on('sectors')->onDelete('cascade');
            $table->foreignId('base_id')->references('id')->on('bases')->onDelete('cascade');
            $table->foreignId('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreignId('invoice_products_id')->references('id')->on('invoice_products')->onDelete('cascade');
            $table->decimal('qtd',12,2,true);
            $table->string('status');
            $table->string('image_path');
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
        Schema::dropIfExists('stoks');
    }
}
