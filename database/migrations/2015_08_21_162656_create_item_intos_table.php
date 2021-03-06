<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemIntosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */    
	public function up()
	{
		Schema::create('item_intos', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('item_id')->unsigned();
            $table->integer('other_item_id')->unsigned();
            $table->foreign('item_id')->references('riot_id')->on('items')->onDelete('cascade');
            //$table->foreign('other_item_id')->references('riot_id')->on('items')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('item_intos');
	}

}
