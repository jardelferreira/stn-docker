<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    // 'uuid','qtd_required','qtd_delivered',
    //     'date_delivered','date_returned',
    //     'signature_delivered','signature_returned',
    //     'stok_id','ca_first','ca_second','formlist_employee_id','observation','add_by'
    public function up()
    {
        Schema::create('fields', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('qtd_required');
            $table->string('qtd_delivered')->nullable();
            $table->string('observation')->nullable();
            $table->integer('signature_returned',false,true)->nullable();
            $table->string('ca_first')->nullable();
            $table->string('ca_second')->nullable();
            $table->date('date_delivered');
            $table->date('date_returned')->nullable();
            $table->foreignId('stok_id')->references('id')->on('stoks')->onDelete('cascade');
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreignId('signature_delivered')->references('id')->on('signatures')->onDelete('cascade');
            $table->foreignId('formlist_base_employee_id')->references('id')->on('formlist_base_employee')->onDelete('cascade');
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
        Schema::dropIfExists('fields');
    }
}
