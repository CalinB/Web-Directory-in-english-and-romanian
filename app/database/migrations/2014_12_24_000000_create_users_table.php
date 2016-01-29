<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table) {
			$table->increments('id');
			$table->enum('type', array('random_user', 'admin'))->default('random_user');
			$table->string('firstname', 20)->default('');
			$table->string('lastname', 20)->default('');
			$table->string('email', 100)->unique()->index();
			$table->string('password', 64);
			$table->boolean('confirmed')->default(0);
			$table->boolean('status')->default(1);
            $table->string('confirmation_code')->nullable();
            $table->rememberToken();
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
		Schema::drop('users');
	}

}
