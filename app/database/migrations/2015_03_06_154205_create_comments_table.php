<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('comments', function(Blueprint $table) {
			$table->increments('id');
			
			$table->boolean('status')->default(0);
			
			$table->integer('domain_id')->unsigned()->index();
			$table->foreign('domain_id')->references('id')->on('domains');
			
			$table->integer('user_id')->nullable();
			
			$table->text('comment', 1000);			
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
		Schema::drop('comments');
	}

}
