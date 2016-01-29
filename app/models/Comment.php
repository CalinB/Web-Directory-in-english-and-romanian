<?php

class Comment extends Eloquent {
	
	protected $table = 'comments';
		
	public function domain()
	{
		return $this->belongsTo('Domain');
	}
}