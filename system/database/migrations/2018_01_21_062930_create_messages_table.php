<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
  public function up()
  {
      Schema::create('messages', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('writer_id')->unsigned();
          $table->integer('destiny_id')->unsigned();
          // Mensagem infos - Assunto, conteúdo
          $table->string('subject', 30);
          $table->string('content', 300);
          // Datas
          $table->timestamp('sent_at')->useCurrent();
          // Estrangeiras
          $table->foreign('writer_id')
          ->references('id')
          ->on('users');
          $table->foreign('destiny_id')
          ->references('id')
          ->on('users');
      });
  }

  public function down()
  {
    Schema::dropIfExists('messages');
  }
}
