<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->string('status');
            $table->string('type');
            $table->string('arquive');
            $table->string('serie');
            $table->json('complements')->nullable();
            $table->date('expiration');
            $table->timestamps();
        });

        Schema::create('project_documents', function(Blueprint $table){
            $table->id();
            $table->foreignId('project_id')->references('id')->on('projects');
            $table->foreignId('document_id')->references('id')->on('documents');
            $table->timestamps();
        });
        
        Schema::create('stok_documents', function(Blueprint $table){
            $table->id();
            $table->foreignId('stok_id')->references('id')->on('stoks');
            $table->foreignId('document_id')->references('id')->on('documents');
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
        Schema::dropIfExists('stok_documents');
        Schema::dropIfExists('project_documents');
        Schema::dropIfExists('documents');
    }
}
