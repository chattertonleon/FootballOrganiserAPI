<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('games', function (Blueprint $table){
            $table->increments('id');
            $table->date('date');
            $table->time('kick_off');
            $table->time('finish_time');
            $table->string('team_1_name');
            $table->string('team_2_name');
            $table->decimal('price_per_player');
            $table->integer('players_per_team');
            $table->timestamps();
        });

        Schema::create('players', function (Blueprint $table){
            $table->increments('id');
            $table->string('first_name');
            $table->string('surname');
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
        //
        Schema::dropIfExists('players');
        Schema::dropIfExists('games');
    }
};
