<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagamentosTable extends Migration
{
  public function up()
  {
      Schema::create('pagamentos', function (Blueprint $table) {
          $table->increments('id');
          $table->string('order_id', 30);
          $table->string('payment_id', 50);
          $table->enum('type', ['boleto', 'card', 'debit']);
          $table->foreign('order_id')
          ->references('unique_id')
          ->on('pedidos');
          $table->timestamp('created_at')->useCurrent();
      });
  }

  public function down()
  {
      Schema::dropIfExists('pagamentos');
  }  
}
