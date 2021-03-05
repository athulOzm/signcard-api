<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocialmediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('socialmedia', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unSignedBigInteger('card_id');
            $table->foreign('card_id')->references('id')->on('cards')->onDelete('cascade');
            $table->string('fb')->nullable();
            $table->string('twitter')->nullable();
            $table->string('wt')->nullable();
            $table->string('insta')->nullable();
            $table->string('in')->nullable();
            $table->string('youtube')->nullable();
            $table->string('reddit')->nullable();
            $table->string('podcasts')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('socialmedia');
    }
}
