<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('code')->unique();
            $table->string('father');
            $table->integer('family_code');
            $table->string('name');
            $table->string('description_1')->nullable();
            $table->text('description_2')->nullable();
            $table->string('color')->nullable();
            $table->string('capacity')->nullable();
            $table->string('material')->nullable();
            $table->string('size')->nullable();
            $table->string('qty_packing')->nullable();
            $table->string('weight')->nullable();
            $table->string('height')->nullable();
            $table->string('width')->nullable();
            $table->string('length')->nullable();
            $table->string('volume')->nullable();
            $table->string('print_technique')->nullable();
            $table->string('print_area')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
