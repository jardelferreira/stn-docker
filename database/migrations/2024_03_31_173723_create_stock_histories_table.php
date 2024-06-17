<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_histories', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('reason');
            $table->decimal('qtd');
            $table->text('event');
            $table->string('stock_name');
            $table->string('sector_name');
            $table->string('base_name');
            $table->string('project_name');
            $table->string('project_initials');
            $table->string('product_name');
            $table->string('user_name');
            $table->string('invoice_product_name');
            $table->string('provider_name');
            $table->foreignId('stock_id')->references('id')->on('stoks');
            $table->foreignId('sector_id')->references('id')->on('sectors');
            $table->foreignId('base_id')->references('id')->on('bases');
            $table->foreignId('project_id')->references('id')->on('projects');
            $table->foreignId('product_id')->references('id')->on('products');
            $table->foreignId('invoice_product_id')->references('id')->on('invoice_products');
            $table->foreignId('provider_id')->references('id')->on('providers');
            $table->foreignId('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('stock_histories');
    }
}
