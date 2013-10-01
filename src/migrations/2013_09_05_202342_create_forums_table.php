<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateForumsTable extends Migration {

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

		Schema::create('forums', function(Blueprint $table) use ($foreign)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->string('title', 255);
			$table->text('content');
			$table->string('slug', 255);
			$table->enum('status', [
				'open', 
				'closed', 
			]);
			$table->softDeletes();
			$table->timestamps();

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
		Schema::drop('forums');
	}
}
