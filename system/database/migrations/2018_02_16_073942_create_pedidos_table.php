<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePedidosTable extends Migration
{
  public function up()
  {
      Schema::create('pedidos', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('buyer_id')->unsigned();
          $table->string('unique_id', 30)->unique();
          $table->string('order_id', 50);
          $table->string('multiorder_id', 50)->nullable();
          $table->integer('store_id')->unsigned()->nullable();
          $table->enum('delivery_method', ['retirada', 'pac', 'sedex'])->nullable();
          $table->enum('payment_method', ['boleto', 'cartao', 'debit']);
          $table->string('delivery_address', 500)->nullable();
          $table->enum('status', ['Aguardando pagamento', 'Pago', 'Cancelado', 'Reembolsado'])->default('Aguardando pagamento');
          $table->string('tracking_code', 50)->nullable();
          $table->foreign('buyer_id')
          ->references('id')
          ->on('users');
          $table->foreign('store_id')
          ->references('id')
          ->on('stores');
          $table->timestamp('created_at')->useCurrent();
      });
  }

  public function down()
  {
    Schema::dropIfExists('pedidos');
  }
}
