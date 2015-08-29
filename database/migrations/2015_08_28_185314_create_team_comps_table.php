<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamCompsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('team_comps', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('name');
            $table->string('description');
            $table->string('slug');
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
		Schema::drop('team_comps');
	}

}
