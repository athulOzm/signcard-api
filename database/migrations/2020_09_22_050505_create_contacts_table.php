<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unSignedBigInteger('card_id');
            $table->foreign('card_id')->references('id')->on('cards')->onDelete('cascade');
            $table->string('place')->nullable();
            $table->string('address')->nullable();
            $table->string('mob')->nullable();
            $table->boolean('mob_verify')->default(false);
            $table->string('tel')->nullable();
            $table->string('email')->nullable();
            $table->boolean('email_verify')->default(false);
            $table->string('fax')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
