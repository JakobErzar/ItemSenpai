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
            $table->double('winrate');
            $table->boolean('bestrate'); // true -> best winrate, false -> most frequent
            $table->integer('gamers');
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
		Schema::drop('winrate_builds');
	}

}
