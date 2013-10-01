<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTopicsTable extends Migration {

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

		Schema::create('topics', function(Blueprint $table) use ($foreign)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->integer('forum_id')->unsigned();
			$table->enum('status', [
				'open',
				'resolved',
			]);
			$table->string('title', 255);
			$table->text('content');
			$table->string('slug', 255);
			$table->string('ip', 255);
			$table->boolean('sticky')->default(0);
			$table->integer('views')->unsigned()->default(0);
			$table->timestamps();
			$table->softDeletes();

			$table->foreign('forum_id')
				->references('id')
				->on('forums')
				->onDelete('cascade');

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
		Schema::drop('topics');
	}
}
