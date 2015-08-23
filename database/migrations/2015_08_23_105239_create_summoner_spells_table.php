<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSummonerSpellsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('summoner_spells', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('riot_id');
            $table->string('key');
            $table->string('name');
            $table->string('description');
            $table->string('icon');
            $table->integer('summoner_level');
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
		Schema::drop('summoner_spells');
	}

}
