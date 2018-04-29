<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('unique_id');
            $table->integer('store_onwer')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->integer('ask_id')->unsigned();
            $table->string('question', 150);
            $table->string('answer', 150)->nullable();
            $table->enum('status', ['criada','respondida'])->default('criada');
            // Chaves estrangeiras
            $table->foreign('product_id')
            ->references('id')->on('products');
            $table->foreign('ask_id')
            ->references('id')->on('users');
            $table->foreign('store_owner')
            ->references('id')->on('stores');
            // Datas
            $table->timestamp('answered_at');
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
        Schema::dropIfExists('questions');
    }
}
