<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoipAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('moip_accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->unique();
            $table->string('account_id', 50)->nullable();
            $table->string('client_id', 50)->nullable();
            $table->string('accessToken', 60)->nullable();
            // Chaves estrangeiras
            $table->foreign('user_id')
            ->references('id')->on('users');
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
        Schema::dropIfExists('moip_accounts');
    }
}
