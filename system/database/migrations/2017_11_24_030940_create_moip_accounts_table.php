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

        // $admin = array(
        //     'user_id' => 7,
        //     'account_id' => 'MPA-4E16AE8363A6',
        //     'client_id' => 'CUS-HROH03UTOONQ',
        //     'access_token' => 'f89e5e7e2a0e405796f88a5a05c98263_v2'
        // );
        // DB::table('moip_accounts')->insert($admin);

        // $um = array(
        //     'user_id' => 8,
        //     'account_id' => 'MPA-5D743AF837A2',
        //     'client_id' => 'CUS-QVWBHNZ7WYAI',
        //     'access_token' => '224dde79d38a479b99c020086f3e27f6_v2'
        // );
        // DB::table('moip_accounts')->insert($um);

        // $dois = array(
        //     'user_id' => 9,
        //     'account_id' => 'MPA-6623A61B5C2E',
        //     'client_id' => 'CUS-1FGPNAJPCDS7 	',
        //     'access_token' => '620295cb5fc842db8c2b7c0e92c42074_v2'
        // );
        // DB::table('moip_accounts')->insert($dois);
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
