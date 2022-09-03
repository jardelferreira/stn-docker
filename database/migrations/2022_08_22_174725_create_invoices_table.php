<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('number',15);
            $table->string('name',65);
            $table->foreignId('provider_id')->references('id')->on('providers')->onDelete('cascade');
            $table->decimal('value');
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('departament_cost_id')->references('id')->on('departament_costs')->onDelete('cascade');
            $table->date('issue');
            $table->date('due_date');
            $table->string('file_path');
            $table->enum('invoice_type',['NF','NFS','CTE','FAT','REC']);
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
        Schema::dropIfExists('invoices');
    }
}
