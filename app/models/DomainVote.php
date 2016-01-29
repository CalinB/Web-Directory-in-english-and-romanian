<?php

class DomainVote extends Eloquent {
	
	protected $table = 'domain_votes';
	
	public function domains()
	{
		return $this->hasMany('Domain');
	}
	
	public static function voterExists($id)
	{
		$viewer_ip = Request::instance()->getClientIp();

		return self::where('domain_id', $id)->where('ip', $viewer_ip)->count();		 
	}
}