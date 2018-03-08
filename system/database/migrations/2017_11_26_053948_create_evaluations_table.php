<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('evaluations', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->enum('rate',
        //     ['Excelente', 'Muito bom', 'Bom', 'Normal', 'Ruim', 'Péssimo', 'Terrível'])
        //     ->default('Normal');
        //     $table->integer('evaluator_id')->unsigned();
        //     $table->integer('evaluated_id')->unsigned();
        //     $table->string('order_id', 30);
        //     // Chaves estrangeiras
        //     $table->foreign('evaluator_id')
        //     ->references('id')
        //     ->on('users');
        //     $table->foreign('evaluated_id')
        //     ->references('id')
        //     ->on('users');
        //     // Datas
        //     $table->timestamp('created_at');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('evaluations');
    }
}
