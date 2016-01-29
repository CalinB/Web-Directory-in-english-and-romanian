<?php

class Attempt extends Eloquent {
	
	protected $table = 'attempts';
	
	public static function seoURL($attempt_id, $lang = '')
	{
		$attempt = Attempt::find($attempt_id);
		
		$clean_chars = function ($string) 
		{
			$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
			$string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

			return preg_replace('/-+/', '-', strtolower($string)); // Replaces multiple hyphens with single one.
		};
			
		$name = Domain::formatDiacritics($clean_chars($attempt->name));				
		
		if(empty($lang))
		{
			$lang = LaravelLocalization::getCurrentLocale();
		}
		
		return URL::route('attempt.details', ['id' => $attempt->id]);
	}
}