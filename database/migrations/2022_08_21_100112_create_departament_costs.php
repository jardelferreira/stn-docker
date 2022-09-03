<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartamentCosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departament_costs', function (Blueprint $table) {
            $table->id();
            $table->string('name',45);
            $table->foreignId('cost_sector_id')->references('id')->on('cost_sectors')->onDelete('cascade');
            $table->decimal('amount',12,2,true)->default(0.00);
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
        Schema::dropIfExists('departament_costs');
    }
}
