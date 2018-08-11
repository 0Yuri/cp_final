<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Address;

class CreateAddressTable extends Migration
{
    public function up()
    {
        Schema::create(Address::TABLE_NAME, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('store_id')->unsigned()->nullable();
            // Infos
            $table->string('cep', 10);
            $table->string('street', 50);
            $table->string('city', 20);
            $table->string('UF', 2);
            $table->string('number', 10);
            $table->string('neighborhood', 25);
            $table->string('complement', 50)->nullable();
            $table->string('reference', 50)->nullable();
            // Chaves estrangeiras
            $table->foreign('user_id')
            ->references('id')->on('users');
            $table->foreign('store_id')
            ->references('id')->on('stores');
            // Datas
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down()
    {
        Schema::dropIfExists(Address::TABLE_NAME);
    }
}
