<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRepliesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$foreign = Config::get('forums::user_id_foreign');

		if(is_callable($foreign)) {
			$foreign = $foreign();
		}

		Schema::create('replies', function(Blueprint $table) use ($foreign)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->integer('topic_id')->unsigned();
			$table->text('content');
			$table->timestamps();
			$table->softDeletes();

			$table->foreign('topic_id')
				->references('id')
				->on('topics');

            $table->foreign('user_id')
            	->references('id')
            	->on($foreign);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('replies');
	}

}
