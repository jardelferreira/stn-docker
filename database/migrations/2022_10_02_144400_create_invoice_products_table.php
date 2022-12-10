<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_products', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('slug');
            $table->string('name');
            $table->string('description');
            $table->decimal('qtd',12,2,true);
            $table->decimal('qtd_available',12,2,true); // cada vez que adicionar, subtrair a quatidade
            $table->string('und');
            $table->decimal('value_und',12,2,true);
            $table->decimal('value_total',12,2,true);
            $table->string('owner')->nullable();
            $table->string('ca_number')->nullable();
            $table->string('image_path')->nullable();
            $table->foreignId('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
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
        Schema::dropIfExists('invoice_products');
    }
}
