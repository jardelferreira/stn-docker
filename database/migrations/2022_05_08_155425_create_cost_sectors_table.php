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
    }
}
