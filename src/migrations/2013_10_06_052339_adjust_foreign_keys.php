<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AdjustForeignKeys extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('topics', function($table)
		{
			$table->dropForeign('topics_forum_id_foreign');

			$table->foreign('forum_id')
				->references('id')
				->on('forums')
				->onDelete('cascade')
				->onUpdate('cascade');
		});

		Schema::table('replies', function($table)
		{
			$table->dropForeign('replies_topic_id_foreign');

			$table->foreign('topic_id')
				->references('id')
				->on('topics')
				->onDelete('cascade')
				->onUpdate('cascade');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('topics', function($table)
		{
			$table->dropForeign('topics_forum_id_foreign');

			$table->foreign('forum_id')
				->references('id')
				->on('forums')
				->onDelete('cascade');
		});

		Schema::table('replies', function($table)
		{
			$table->dropForeign('replies_topic_id_foreign');

			$table->foreign('topic_id')
				->references('id')
				->on('topics')
				->onDelete('cascade');
		});
	}
}
