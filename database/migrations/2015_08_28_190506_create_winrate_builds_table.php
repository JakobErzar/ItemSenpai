<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWinrateBuildsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('winrate_builds', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('winrate');
            $table->string('bestrate'); // true -> best winrate, false -> most frequent
            $table->integer('games');
            $table->string('lane');
            $table->integer('order');
            $table->integer('champion_id')->unsigned();
			$table->timestamps();
            
            $table->foreign('champion_id')->references('riot_id')->on('champions')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('winrate_builds');
	}

}
