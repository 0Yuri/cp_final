<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address', function (Blueprint $table) {
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

        // $admin = array(
        //     'user_id' => 'Admin5ab7a2db25316',
        //     'cep' => '50721-200',
        //     'street' => 'Rua Adelino Frutuoso',
        //     'city' => 'Recife',
        //     'UF' => 'PE',
        //     'number' => '35',
        //     'neighborhood' => 'Cordeiro',
        //     'complement' => 'Apto 201',
        //     'reference' => 'perto'
        // );
        // DB::table('address')->insert($admin);

        // $dois = array(
        //     'user_id' => 'Vendedor5ac05bdfbd106',
        //     'cep' => '04514-030',
        //     'street' => 'Rua Pintassilgo',
        //     'city' => 'São Paulo',
        //     'UF' => 'SP',
        //     'number' => '211',
        //     'neighborhood' => 'Vila Uberabinha',
        //     'complement' => 'até 229/230',
        //     'reference' => 'teste'
        // );
        // DB::table('address')->insert($dois);

        // $tres = array(
        //     'user_id' => 'Vendedor5ac05c25cec19',
        //     'cep' => '22050-002',
        //     'street' => 'Avenida Nossa Senhora de Copacabana',
        //     'city' => 'Rio de Janeiro',
        //     'UF' => 'RJ',
        //     'number' => '221',
        //     'neighborhood' => 'Copacabana',
        //     'complement' => 'de 583 a 831 - lado ímpar',
        //     'reference' => 'teste'
        // );
        // DB::table('address')->insert($dois);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('address');
    }
}
