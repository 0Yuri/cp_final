<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('store_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->integer('brand_id')->unsigned();
            $table->string('unique_id', 70);
            // Info
            $table->string('name', 50);
            $table->string('description', 600);
            $table->enum('status', ['ativado', 'desativado'])->default('ativado');
            $table->enum('gender', ['meninos', 'meninas', 'papai', 'mamae']);
            $table->enum('quality', ['Novo', 'Bom estado', 'Com marcas de uso']);
            $table->string('discount', 3)->default("0");
            $table->integer('stock')->default(1);
            $table->integer('solds')->default(0);
            // Preço
            $table->decimal('original_price', 7,2);
            $table->decimal('price', 7,2);
            // Formas de envio
            $table->boolean('local')->default(1);
            $table->boolean('shipping')->default(1);
            // Dimensões
            $table->bigInteger('height');
            $table->bigInteger('width');
            $table->bigInteger('length');
            $table->bigInteger('weight');
            // Chaves estrangeiras
            $table->foreign('store_id')
            ->references('id')->on('stores');
            // Datas
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
