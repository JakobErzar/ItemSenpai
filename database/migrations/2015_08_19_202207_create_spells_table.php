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
            $table->integer('champion_id')->unsigned();
            $table->string('key');
            $table->string('name');
            $table->integer('max_rank');
            $table->string('symbol');
            $table->string('icon');
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
		Schema::drop('spells');
	}

}
