<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoresTable extends Migration
{
  public function up()
  {
      Schema::create('stores', function (Blueprint $table) {
          $table->increments('id');
          $table->string('unique_id');
          $table->integer('owner_id')->unsigned()->unique();
          $table->enum('status', ['ativado', 'desativado'])->default('ativado');
          $table->integer('sales')->default(0);
          // Image Settings
          $table->string('profile_image', 120)->default('default_profile1.png');
          $table->string('banner_image', 120)->default('default_banner1.png');
          // Basic Info
          $table->string('name', 255);
          $table->string('description', 255);
          $table->string('ddd', 4);
          $table->string('phone', 10);
          // Chaves estrangeiras
          $table->foreign('owner_id')
          ->references('id')->on('users');
          // Datas
          $table->timestamp('created_at')->useCurrent();
      });
  }

  public function down()
  {
    Schema::dropIfExists('stores');
  }
}
