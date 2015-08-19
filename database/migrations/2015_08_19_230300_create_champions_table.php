<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChampionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('champions', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('riot_id');
            $table->string('key');
            $table->string('name');
            $table->string('title');
            $table->string('icon');
            $table->string('splash');
            $table->string('loading');
            $table->string('role1');
            $table->string('role2');
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
		Schema::drop('champions');
	}

}
