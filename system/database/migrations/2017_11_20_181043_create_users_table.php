<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name_id', 150);
            // Login info
            $table->string('email', 100)->unique();
            $table->string('password', 300);
            $table->enum('account_type', ['admin', 'basic'])->default('basic');
            $table->enum('activated', ['yes', 'no'])->default('no');
            // Info
            $table->string('name', 50);
            $table->string('last_name', 50);
            $table->enum('gender', ['male', 'female']);
            $table->string('cpf',20);
            $table->string('rg', 25);
            $table->string('issuer', 25);
            $table->date('issue_date');
            $table->date('birthdate');
            // Contact
            $table->string('ddd_1', 4);
            $table->string('tel_1', 10);
            $table->string('ddd_2', 4);
            $table->string('tel_2', 10);
            // Dates
            $table->timestamp('created_at')->useCurrent();
        });

        // // Adicionando o administrador
        // $admin = array(
        //     'name_id' =>'admin5ab7a2db25316',
        //     'email' => 'admin@admin.com',
        //     'password' => '$2y$10$cnFUDM1BcRF2gO9DrvfHHO2fwyOHgaHkaCBxSr4pr8i8RnA1dAqVG',
        //     'activated' => 'yes',
        //     'account_type' => 'admin',
        //     'name' => 'Admin',
        //     'last_name' => 'Admin',
        //     'gender' => 'male',
        //     'cpf' => '61283412098',
        //     'rg' => '899999999',
        //     'issuer' => 'SDS',
        //     'issue_date' => '2006-01-20',
        //     'birthdate' => '1994-04-12',
        //     'ddd_1' => '81',
        //     'tel_1' => '999999999',
        //     'ddd_2' => '81',
        //     'tel_2' => '999999999'
        // );
        // DB::table('users')->insert($admin);

        // $dois = array(
        //     'name_id' =>'Vendedor5ac05bdfbd106',
        //     'email' => 'teste@teste.com',
        //     'password' => '$2y$10$ish5Ah0Mcc6wXchLQSd50uRvnrQCV8eD9Dk9SJtYlHv0ehyPMlDM.',
        //     'activated' => 'yes',
        //     'name' => 'Vendedor',
        //     'last_name' => 'Um',
        //     'gender' => 'male',
        //     'cpf' => '00450323005',
        //     'rg' => '899999999',
        //     'issuer' => 'SDS',
        //     'issue_date' => '2006-01-20',
        //     'birthdate' => '1944-12-12',
        //     'ddd_1' => '81',
        //     'tel_1' => '999999999',
        //     'ddd_2' => '81',
        //     'tel_2' => '999999999'
        // );
        // DB::table('users')->insert($dois);

        // $terceiro = array(
        //     'name_id' =>'Vendedor5ac05c25cec19',
        //     'email' => 'dois@dois.com',
        //     'password' => '$2y$10$J0h7FOA5DPJ8jvB4SbrG/O/hRr2oWYnFRrIAcK6C85C/nUb61S05i',
        //     'activated' => 'yes',
        //     'name' => 'Vendedor',
        //     'last_name' => 'Dois',
        //     'gender' => 'male',
        //     'cpf' => '54547992037',
        //     'rg' => '899999999',
        //     'issuer' => 'SDS',
        //     'issue_date' => '2006-01-20',
        //     'birthdate' => '1995-05-12',
        //     'ddd_1' => '81',
        //     'tel_1' => '999999999',
        //     'ddd_2' => '81',
        //     'tel_2' => '999999999'
        // );
        // DB::table('users')->insert($terceiro);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
