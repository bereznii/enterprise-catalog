<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWorkersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('workers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('position');
			$table->string('supervisor')->nullable();
			$table->date('hired_at')->default('2018-06-11');
			$table->timestamps();
			$table->integer('salary');
			$table->string('photo')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('workers');
	}

}
