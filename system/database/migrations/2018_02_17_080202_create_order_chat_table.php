<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderChatTable extends Migration
{
  public function up()
  {
    Schema::create('orders_chat', function(Blueprint $table){
      $table->increments('id')->unsigned();
      $table->string('unique_id', 30);
      $table->integer('writer_id')->unsigned();
      $table->string('content', 300);
      $table->timestamp('sent_at')->useCurrent();
      $table->foreign('unique_id')
      ->references('unique_id')
      ->on('pedidos');
      $table->foreign('writer_id')
      ->references('id')
      ->on('users');
    });
  }

  public function down()
  {
    Schema::dropIfExists('orders_chat');
  }
}
