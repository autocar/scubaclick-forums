<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLabelsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('labels', function(Blueprint $table) {
			$table->increments('id');
			$table->string('title', 255);
			$table->string('slug', 255)->unique();
		});

		Schema::create('label_topic', function(Blueprint $table) {
			$table->increments('id');
            $table->integer('topic_id')->unsigned();
            $table->integer('label_id')->unsigned();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('labels');
		Schema::drop('label_topic');
	}
}
