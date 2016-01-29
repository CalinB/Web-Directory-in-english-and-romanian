<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDomainVotes extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('domain_votes', function(Blueprint $table) {
			$table->increments('id');
			
			$table->integer('domain_id')->unsigned();
			$table->foreign('domain_id')->references('id')->on('domains');
			
			$table->string('ip')->index();
			
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
		Schema::drop('domain_votes');
	}

}
