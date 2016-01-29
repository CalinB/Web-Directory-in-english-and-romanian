<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDomainsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('domains', function(Blueprint $table) {
			$table->increments('id');
			
			$table->integer('category_id')->unsigned();
			$table->foreign('category_id')->references('id')->on('categories');
			
			$table->boolean('status')->default(1);
			$table->string('name')->index();
			$table->string('url')->index();
			$table->string('page_rank')->nullable();
			$table->text('description', 1000);
			$table->text('keywords', 1000);
			$table->string('thumb')->nullable();
			$table->string('hits');
			$table->integer('votes_up')->default(0)->unsigned();
			$table->integer('votes_down')->default(0)->unsigned();
			$table->timestamp('last_visit')->nullable();
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
		Schema::drop('domains');
	}

}
