<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->enum('status', ['ativado', 'desativado'])->default('ativado');
            $table->string('name', 50);
        });

        DB::table('brands')->insert(array('name' => 'Outros'));
        DB::table('brands')->insert(array('name' => 'Tigor Tigre'));
        DB::table('brands')->insert(array('name' => 'Tip Top'));
        DB::table('brands')->insert(array('name' => 'Chicco'));
        DB::table('brands')->insert(array('name' => 'Burigotto'));
        DB::table('brands')->insert(array('name' => 'Croes'));
        DB::table('brands')->insert(array('name' => 'Hello Kitty'));
        DB::table('brands')->insert(array('name' => 'Melissa'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('brands');
    }
}
