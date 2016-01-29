<?php

namespace Directory\Providers;

use Illuminate\Support\ServiceProvider;

class AclServiceProvider extends ServiceProvider {

	public function register()
	{
		$this->app->bind('acl', function() {
			return new \Directory\Acl();
		});
	}

}
