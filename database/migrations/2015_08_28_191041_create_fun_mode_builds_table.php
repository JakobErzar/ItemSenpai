<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFunModeBuildsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('fun_mode_builds', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('name');
            $table->string('description');
            $table->string('video');
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
		Schema::drop('fun_mode_builds');
	}

}
