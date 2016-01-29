<?php

class SiteViewer extends Eloquent {
	
	protected $table = 'site_viewers';
	
	public function domains()
	{
		return $this->hasMany('Domain');
	}
	
	public static function viewerExists($id)
	{
		$viewer_ip = Request::instance()->getClientIp();

		return self::where('domain_id', $id)->where('ip', $viewer_ip)->count();		 
	}
}