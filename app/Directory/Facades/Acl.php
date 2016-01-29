<?php

namespace Directory\Facades;

use Illuminate\Support\Facades\Facade;

class Acl extends Facade {

    protected static function getFacadeAccessor() { return 'acl'; }

}