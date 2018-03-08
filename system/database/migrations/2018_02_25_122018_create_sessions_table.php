<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSessionsTable extends Migration
{
  public function up()
  {
      Schema::create('sessions', function (Blueprint $table) {
          $table->increments('id');
          $table->string('browser');
          $table->string('platform');
          $table->string('version');
          $table->timestamp('logged_at')->useCurrent();
      });
  }

  public function down()
  {
      Schema::dropIfExists('sessions');
  }
}
