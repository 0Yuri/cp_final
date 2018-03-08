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
