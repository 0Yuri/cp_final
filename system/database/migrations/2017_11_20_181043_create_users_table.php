<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\User;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create(User::TABLE_NAME, function (Blueprint $table) {
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
            // Dates
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down()
    {
        Schema::dropIfExists(User::TABLE_NAME);
    }
}
