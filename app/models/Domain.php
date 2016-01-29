<?php

class Domain extends Eloquent {
	
	protected $table = 'domains';
	
	public function siteViewers()
	{
		return $this->hasMany('SiteViewer');
	}
	
	public function domainVotes()
	{
		return $this->hasMany('DomainVote');
	}
	
	public function comments()
	{
		return $this->hasMany('Comment');
	}
	
	public function totalActiveComments()
	{
		return $this->hasMany('Comment')
			->where('status', 1);
	}
	
	public static function formatDiacritics($txt)
	{
		$transliterationTable = array('�' => 'a', '�' => 'A', '�' => 'a', '�' => 'A', '?' => 'a', '?' => 'A', '�' => 'a', '�' => 'A', 
			'�' => 'a', '�' => 'A', '�' => 'a', '�' => 'A', '?' => 'a', '?' => 'A', '?' => 'a', '?' => 'A', '�' => 'ae', '�' => 'AE', 
			'�' => 'ae', '�' => 'AE', '?' => 'b', '?' => 'B', '?' => 'c', '?' => 'C', '?' => 'c', '?' => 'C', '?' => 'c', '?' => 'C', 
			'?' => 'c', '?' => 'C', '�' => 'c', '�' => 'C', '?' => 'd', '?' => 'D', '?' => 'd', '?' => 'D', '?' => 'd', '?' => 'D', 
			'�' => 'dh', '�' => 'Dh', '�' => 'e', '�' => 'E', '�' => 'e', '�' => 'E', '?' => 'e', '?' => 'E', '�' => 'e', '�' => 'E', 
			'?' => 'e', '?' => 'E', '�' => 'e', '�' => 'E', '?' => 'e', '?' => 'E', '?' => 'e', '?' => 'E', '?' => 'e', '?' => 'E', 
			'?' => 'f', '?' => 'F', '�' => 'f', '?' => 'F', '?' => 'g', '?' => 'G', '?' => 'g', '?' => 'G', '?' => 'g', '?' => 'G', 
			'?' => 'g', '?' => 'G', '?' => 'h', '?' => 'H', '?' => 'h', '?' => 'H', '�' => 'i', '�' => 'I', '�' => 'i', '�' => 'I', 
			'�' => 'i', '�' => 'I', '�' => 'i', '�' => 'I', '?' => 'i', '?' => 'I', '?' => 'i', '?' => 'I', '?' => 'i', '?' => 'I', 
			'?' => 'j', '?' => 'J', '?' => 'k', '?' => 'K', '?' => 'l', '?' => 'L', '?' => 'l', '?' => 'L', '?' => 'l', '?' => 'L', 
			'?' => 'l', '?' => 'L', '?' => 'm', '?' => 'M', '?' => 'n', '?' => 'N', '?' => 'n', '?' => 'N', '�' => 'n', '�' => 'N', 
			'?' => 'n', '?' => 'N', '�' => 'o', '�' => 'O', '�' => 'o', '�' => 'O', '�' => 'o', '�' => 'O', '?' => 'o', '?' => 'O', 
			'�' => 'o', '�' => 'O', '�' => 'oe', '�' => 'OE', '?' => 'o', '?' => 'O', '?' => 'o', '?' => 'O', '�' => 'oe', '�' => 'OE', 
			'?' => 'p', '?' => 'P', '?' => 'r', '?' => 'R', '?' => 'r', '?' => 'R', '?' => 'r', '?' => 'R', '?' => 's', '?' => 'S', 
			'?' => 's', '?' => 'S', '�' => 's', '�' => 'S', '?' => 's', '?' => 'S', '?' => 's', '?' => 'S', '?' => 's', '?' => 'S', 
			'�' => 'SS', '?' => 't', '?' => 'T', '?' => 't', '?' => 'T', '?' => 't', '?' => 'T', '?' => 't', '?' => 'T', '?' => 't', 
			'?' => 'T', '�' => 'u', '�' => 'U', '�' => 'u', '�' => 'U', '?' => 'u', '?' => 'U', '�' => 'u', '�' => 'U', '?' => 'u', 
			'?' => 'U', '?' => 'u', '?' => 'U', '?' => 'u', '?' => 'U', '?' => 'u', '?' => 'U', '?' => 'u', '?' => 'U', '?' => 'u', 
			'?' => 'U', '�' => 'ue', '�' => 'UE', '?' => 'w', '?' => 'W', '?' => 'w', '?' => 'W', '?' => 'w', '?' => 'W', '?' => 'w', 
			'?' => 'W', '�' => 'y', '�' => 'Y', '?' => 'y', '?' => 'Y', '?' => 'y', '?' => 'Y', '�' => 'y', '�' => 'Y', '?' => 'z', 
			'?' => 'Z', '�' => 'z', '�' => 'Z', '?' => 'z', '?' => 'Z', '�' => 'th', '�' => 'Th', '�' => 'u', '?' => 'a', '?' => 'a', 
			'?' => 'b', '?' => 'b', '?' => 'v', '?' => 'v', '?' => 'g', '?' => 'g', '?' => 'd', '?' => 'd', '?' => 'e', '?' => 'E', 
			'?' => 'e', '?' => 'E', '?' => 'zh', '?' => 'zh', '?' => 'z', '?' => 'z', '?' => 'i', '?' => 'i', '?' => 'j', '?' => 'j', 
			'?' => 'k', '?' => 'k', '?' => 'l', '?' => 'l', '?' => 'm', '?' => 'm', '?' => 'n', '?' => 'n', '?' => 'o', '?' => 'o', 
			'?' => 'p', '?' => 'p', '?' => 'r', '?' => 'r', '?' => 's', '?' => 's', '?' => 't', '?' => 't', '?' => 'u', '?' => 'u', 
			'?' => 'f', '?' => 'f', '?' => 'h', '?' => 'h', '?' => 'c', '?' => 'c', '?' => 'ch', '?' => 'ch', '?' => 'sh', '?' => 'sh', 
			'?' => 'sch', '?' => 'sch', '?' => '', '?' => '', '?' => 'y', '?' => 'y', '?' => '', '?' => '', '?' => 'e', '?' => 'e', 
			'?' => 'ju', '?' => 'ju', '?' => 'ja', '?' => 'ja');

		return str_replace(array_keys($transliterationTable), array_values($transliterationTable), html_entity_decode($txt));
	}
		
	public static function seoURL($domain_id, $lang = '')
	{
		$domain = Domain::find($domain_id);
		
		$clean_chars = function ($string) 
		{
			$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
			$string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

			return preg_replace('/-+/', '-', strtolower($string)); // Replaces multiple hyphens with single one.
		};
			
		$domain_name = self::formatDiacritics($clean_chars($domain->name));				
		
		if(empty($lang))
		{
			$lang = LaravelLocalization::getCurrentLocale();
		}
		
		return URL::route('domain.details', ['name' => $domain_name, 'id' => $domain->id]);
	}
}