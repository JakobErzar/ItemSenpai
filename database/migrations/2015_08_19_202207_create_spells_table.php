<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpellsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('spells', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('riot_id');
            $table->integer('champion_id');
            $table->string('key');
            $table->string('name');
            $table->integer('max_rank');
            $table->string('symbol');
            $table->string('icon');
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
		Schema::drop('spells');
	}

}
