<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsetBlocksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('itemset_blocks', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('itemset_id')->unsigned();
            $table->string('name');
            $table->integer('type')->unsigned(); // 0 Final items, 1 Starting items, 2 Other
            $table->boolean('recMath')->default(false);
            $table->integer('minSummonerLevel')->default(-1);
            $table->integer('maxSummonerLevel')->default(-1);
            $table->string('showIfSummonerSpell')->default("");
            $table->string('hideIfSummonerSpell')->default("");
			$table->timestamps();
            
            $table->foreign('itemset_id')->references('id')->on('itemsets')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('itemset_blocks');
	}

}
