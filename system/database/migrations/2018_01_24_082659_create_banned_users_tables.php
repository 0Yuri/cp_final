<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBannedUsersTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('banned_users', function(Blueprint $table){
        $table->increments('id', 11)->unsigned();
        $table->integer('banned_id')->unsigned();
        $table->string('cpf');
        $table->string('rg');
        $table->string('email');
        $table->string('reason', 300);
        $table->timestamp('ban_date')->useCurrent();
        $table->foreign('banned_id')
        ->references('id')
        ->on('users');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schemma::dropIfExists('banned_users');
    }
}
