<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCostSectorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       
        Schema::create('cost_sectors', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('slug',60)->unique();
            $table->string('name',155);
            $table->string('description');
            $table->foreignId('cost_center_id')->references('id')->on('cost_centers')->onDelete('cascade');
            $table->foreignId('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->decimal('amount',12,2,true)->default(0,00);
            $table->timestamps();
        });

        Schema::create('cost_sectors_status', function(Blueprint $table){
            $table->id();
            $table->foreignId('status_id')->references('id')->on('status')->onDelete('cascade');
            $table->foreignId('cost_sector_id')->references('id')->on('cost_sectors')->onDelete('cascade');
            $table->decimal('percent',3,2,true)->default(0.00);
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
        Schema::dropIfExists('cost_sectors');
        Schema::dropIfExists('cost_sectors_status');
    }
}
