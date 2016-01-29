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
		$transliterationTable = array('á' => 'a', 'Á' => 'A', 'à' => 'a', 'À' => 'A', '?' => 'a', '?' => 'A', 'â' => 'a', 'Â' => 'A', 
			'å' => 'a', 'Å' => 'A', 'ã' => 'a', 'Ã' => 'A', '?' => 'a', '?' => 'A', '?' => 'a', '?' => 'A', 'ä' => 'ae', 'Ä' => 'AE', 
			'æ' => 'ae', 'Æ' => 'AE', '?' => 'b', '?' => 'B', '?' => 'c', '?' => 'C', '?' => 'c', '?' => 'C', '?' => 'c', '?' => 'C', 
			'?' => 'c', '?' => 'C', 'ç' => 'c', 'Ç' => 'C', '?' => 'd', '?' => 'D', '?' => 'd', '?' => 'D', '?' => 'd', '?' => 'D', 
			'ğ' => 'dh', 'Ğ' => 'Dh', 'é' => 'e', 'É' => 'E', 'è' => 'e', 'È' => 'E', '?' => 'e', '?' => 'E', 'ê' => 'e', 'Ê' => 'E', 
			'?' => 'e', '?' => 'E', 'ë' => 'e', 'Ë' => 'E', '?' => 'e', '?' => 'E', '?' => 'e', '?' => 'E', '?' => 'e', '?' => 'E', 
			'?' => 'f', '?' => 'F', 'ƒ' => 'f', '?' => 'F', '?' => 'g', '?' => 'G', '?' => 'g', '?' => 'G', '?' => 'g', '?' => 'G', 
			'?' => 'g', '?' => 'G', '?' => 'h', '?' => 'H', '?' => 'h', '?' => 'H', 'í' => 'i', 'Í' => 'I', 'ì' => 'i', 'Ì' => 'I', 
			'î' => 'i', 'Î' => 'I', 'ï' => 'i', 'Ï' => 'I', '?' => 'i', '?' => 'I', '?' => 'i', '?' => 'I', '?' => 'i', '?' => 'I', 
			'?' => 'j', '?' => 'J', '?' => 'k', '?' => 'K', '?' => 'l', '?' => 'L', '?' => 'l', '?' => 'L', '?' => 'l', '?' => 'L', 
			'?' => 'l', '?' => 'L', '?' => 'm', '?' => 'M', '?' => 'n', '?' => 'N', '?' => 'n', '?' => 'N', 'ñ' => 'n', 'Ñ' => 'N', 
			'?' => 'n', '?' => 'N', 'ó' => 'o', 'Ó' => 'O', 'ò' => 'o', 'Ò' => 'O', 'ô' => 'o', 'Ô' => 'O', '?' => 'o', '?' => 'O', 
			'õ' => 'o', 'Õ' => 'O', 'ø' => 'oe', 'Ø' => 'OE', '?' => 'o', '?' => 'O', '?' => 'o', '?' => 'O', 'ö' => 'oe', 'Ö' => 'OE', 
			'?' => 'p', '?' => 'P', '?' => 'r', '?' => 'R', '?' => 'r', '?' => 'R', '?' => 'r', '?' => 'R', '?' => 's', '?' => 'S', 
			'?' => 's', '?' => 'S', 'š' => 's', 'Š' => 'S', '?' => 's', '?' => 'S', '?' => 's', '?' => 'S', '?' => 's', '?' => 'S', 
			'ß' => 'SS', '?' => 't', '?' => 'T', '?' => 't', '?' => 'T', '?' => 't', '?' => 'T', '?' => 't', '?' => 'T', '?' => 't', 
			'?' => 'T', 'ú' => 'u', 'Ú' => 'U', 'ù' => 'u', 'Ù' => 'U', '?' => 'u', '?' => 'U', 'û' => 'u', 'Û' => 'U', '?' => 'u', 
			'?' => 'U', '?' => 'u', '?' => 'U', '?' => 'u', '?' => 'U', '?' => 'u', '?' => 'U', '?' => 'u', '?' => 'U', '?' => 'u', 
			'?' => 'U', 'ü' => 'ue', 'Ü' => 'UE', '?' => 'w', '?' => 'W', '?' => 'w', '?' => 'W', '?' => 'w', '?' => 'W', '?' => 'w', 
			'?' => 'W', 'ı' => 'y', 'İ' => 'Y', '?' => 'y', '?' => 'Y', '?' => 'y', '?' => 'Y', 'ÿ' => 'y', 'Ÿ' => 'Y', '?' => 'z', 
			'?' => 'Z', '' => 'z', '' => 'Z', '?' => 'z', '?' => 'Z', 'ş' => 'th', 'Ş' => 'Th', 'µ' => 'u', '?' => 'a', '?' => 'a', 
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