<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\MoipClient;

class CreateMoipClientsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(MoipClient::TABLE_NAME, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->unique();            
            $table->string('client_id', 50)->nullable();
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
        Schema::dropIfExists(MoipClient::TABLE_NAME);
    }
}
