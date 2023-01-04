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
            $table->uuid('uuid');
            $table->string('slug');
            $table->unique(['invoice_type','number','provider_id','departament_cost_id'],'invoice_departament_unique');
            $table->string('number',15);
            $table->string('name',65);
            $table->foreignId('provider_id')->references('id')->on('providers')->onDelete('cascade');
            $table->foreignId('departament_cost_id')->references('id')->on('departament_costs')->onDelete('cascade');
            $table->foreignId('cost_sector_id')->references('id')->on('cost_sectors')->onDelete('cascade');
            $table->foreignId('cost_center_id')->references('id')->on('cost_centers')->onDelete('cascade');
            $table->foreignId('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->decimal('value');
            $table->decimal('value_departament')->nullable(); //definir este valores nas views
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('invoices');
    }
}
