<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemTagsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('item_tags', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('item_id')->unsigned();
            $table->string('name');
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
		Schema::drop('item_tags');
	}

}
