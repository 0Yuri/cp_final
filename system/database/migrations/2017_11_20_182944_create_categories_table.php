<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{

    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->enum('status', ['ativado', 'desativado'])->default('ativado');
            $table->string('name');
        });

        DB::table('categories')->insert(array('name' => 'Outros'));
        DB::table('categories')->insert(array('name' => 'Acessórios'));
        DB::table('categories')->insert(array('name' => 'Banho e Higiene'));
        DB::table('categories')->insert(array('name' => 'Brinquedos'));
        DB::table('categories')->insert(array('name' => 'Móveis'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
