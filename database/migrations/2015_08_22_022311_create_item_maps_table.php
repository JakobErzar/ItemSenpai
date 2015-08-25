<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemMapsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('item_maps', function(Blueprint $table)
		{
            $table->increments('id');
            $table->integer('map_id')->unsigned();
            $table->integer('item_id')->unsigned();
            $table->string('map_name');
            
            $table->foreign('item_id')->references('riot_id')->on('items')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('item_maps');
	}

}
