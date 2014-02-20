<?php

use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            Schema::create('events', function ($table) {
                $table->increments('id');
                $table->integer('dispatch_id');
                $table->string('day');
                $table->integer('date');
                $table->integer('month');
                $table->integer('year');
             });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
            Schema::drop('events');
	}

}