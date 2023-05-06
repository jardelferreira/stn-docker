<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShortcutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shortcuts', function (Blueprint $table) {
            $table->id();
            $table->string('shortcut',10)->unique();
            $table->string('route_name')->nullable();
            $table->string('name');
            $table->json('atributes')->nullable();
            $table->string('url');
            $table->string('secure_url')->nullable();
            $table->boolean('active')->default(true);
            $table->morphs('shortcutable');
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
        Schema::dropIfExists('shortcuts');
    }
}
