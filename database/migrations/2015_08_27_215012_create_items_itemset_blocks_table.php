<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsItemsetBlocksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('items_itemset_blocks', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('item_id')->unsigned();
            $table->integer('itemset_block_id')->unsigned();
            $table->integer('count')->unsigned();
            $table->integer('order')->unsigned();
			$table->timestamps();
            
            $table->foreign('item_id')->references('riot_id')->on('items')->onDelete('cascade');
            $table->foreign('itemset_block_id')->references('id')->on('itemset_blocks')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('items_itemset_blocks');
	}

}
