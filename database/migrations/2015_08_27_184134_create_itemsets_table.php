<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsetsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('itemsets', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('name');
            $table->string('type')->default('custom');
            $table->string('map')->default('any');
            $table->string('mode')->default('any');
            $table->boolean('priority')->default(false);
            $table->integer('sortrank')->unsigned()->nullable();
            $table->string('point1');
            $table->string('point2');
            $table->string('point3');
            $table->string('max1');
            $table->string('max2');
            $table->string('max3');
            $table->integer('champion_id')->unsigned();
            $table->integer('summoner1')->unsigned();
            $table->integer('summoner2')->unsigned();
            $table->integer('bildernus_id');
            $table->string('bildernus_type');
			$table->timestamps();
            
            $table->foreign('champion_id')->references('riot_id')->on('champions')->onDelete('cascade');
            $table->foreign('summoner1')->references('riot_id')->on('summoner_spells')->onDelete('cascade');
            $table->foreign('summoner2')->references('riot_id')->on('summoner_spells')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('itemsets');
	}

}
