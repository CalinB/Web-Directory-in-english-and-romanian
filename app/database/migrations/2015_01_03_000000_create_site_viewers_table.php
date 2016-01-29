<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteViewersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('site_viewers', function(Blueprint $table) {
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
		Schema::drop('site_viewers');
	}

}
