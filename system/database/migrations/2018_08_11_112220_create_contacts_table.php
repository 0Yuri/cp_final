<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Contact;
use App\User;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Contact::TABLE_NAME, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            // Contact
            $table->string('ddd_1', 4);
            $table->string('tel_1', 10);
            $table->string('ddd_2', 4);
            $table->string('tel_2', 10);
            // References
            $table->foreign('user_id')->references('id')->on(User::TABLE_NAME);
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
        Schema::dropIfExists(Contact::TABLE_NAME);
    }
}
