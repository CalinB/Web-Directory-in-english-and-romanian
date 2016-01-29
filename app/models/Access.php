<?php

class Access extends Eloquent {
	
	protected $table = 'access';
	
	
	// relations
	public function categories()
	{
		return $this->hasMany('Category');
	}	
	
	public function domains()
	{
		return $this->hasMany('Domain');
	}
}