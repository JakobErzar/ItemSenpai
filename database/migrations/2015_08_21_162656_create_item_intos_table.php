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
            $table->integer('item_id');
            $table->integer('other_item_id');
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
