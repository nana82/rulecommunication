<?php

use Illuminate\Database\Migrations\Migration;

class CreateDispatchesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            Schema::create('dispatches', function ($table) {
                $table->increments('id');
                $table->time('time');
                $table->integer('repeat');
             });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
            Schema::drop('dispatches');
	}

}