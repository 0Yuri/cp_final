<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('product_images', function(Blueprint $table){
        $table->increments('id')->unsigned();
        // Padrão
        $table->enum('type', ['profile', 'extra']);
        $table->integer('product_id')->unsigned();
        $table->string('filename', 100)->default('default');
        // Foreign
        $table->foreign('product_id')
        ->references('id')
        ->on('products');
        // Datas
        $table->timestamp('added_at')->useCurrent();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::dropIfExists('product_images');
    }
}
