<?php

class DirectoryHelpers {

	/**
	 * Returns an string clean of UTF8 characters. It will convert them to a similar ASCII character
	 * www.unexpectedit.com
	 */
	public static function cleanString($text)
	{
		// 1) convert á ô => a o
		$text = preg_replace("/[áàâãªä]/u", "a", $text);
		$text = preg_replace("/[ÁÀÂÃÄ]/u", "A", $text);
		$text = preg_replace("/[ÍÌÎÏ]/u", "I", $text);
		$text = preg_replace("/[íìîï]/u", "i", $text);
		$text = preg_replace("/[éèêë]/u", "e", $text);
		$text = preg_replace("/[ÉÈÊË]/u", "E", $text);
		$text = preg_replace("/[óòôõºö]/u", "o", $text);
		$text = preg_replace("/[ÓÒÔÕÖ]/u", "O", $text);
		$text = preg_replace("/[úùûü]/u", "u", $text);
		$text = preg_replace("/[ÚÙÛÜ]/u", "U", $text);
		$text = preg_replace("/[’‘‹›‚]/u", "'", $text);
		$text = preg_replace("/[“”«»„]/u", '"', $text);
		$text = str_replace("–", "-", $text);
		$text = str_replace(" ", " ", $text);
		$text = str_replace("ç", "c", $text);
		$text = str_replace("Ç", "C", $text);
		$text = str_replace("ñ", "n", $text);
		$text = str_replace("Ñ", "N", $text);

		//2) Translation CP1252. &ndash; => -
		$trans = get_html_translation_table(HTML_ENTITIES);
		$trans[chr(130)] = '&sbquo;';	// Single Low-9 Quotation Mark
		$trans[chr(131)] = '&fnof;';	// Latin Small Letter F With Hook
		$trans[chr(132)] = '&bdquo;';	// Double Low-9 Quotation Mark
		$trans[chr(133)] = '&hellip;';	// Horizontal Ellipsis
		$trans[chr(134)] = '&dagger;';	// Dagger
		$trans[chr(135)] = '&Dagger;';	// Double Dagger
		$trans[chr(136)] = '&circ;';	// Modifier Letter Circumflex Accent
		$trans[chr(137)] = '&permil;';	// Per Mille Sign
		$trans[chr(138)] = '&Scaron;';	// Latin Capital Letter S With Caron
		$trans[chr(139)] = '&lsaquo;';	// Single Left-Pointing Angle Quotation Mark
		$trans[chr(140)] = '&OElig;';	// Latin Capital Ligature OE
		$trans[chr(145)] = '&lsquo;';	// Left Single Quotation Mark
		$trans[chr(146)] = '&rsquo;';	// Right Single Quotation Mark
		$trans[chr(147)] = '&ldquo;';	// Left Double Quotation Mark
		$trans[chr(148)] = '&rdquo;';	// Right Double Quotation Mark
		$trans[chr(149)] = '&bull;';	// Bullet
		$trans[chr(150)] = '&ndash;';	// En Dash
		$trans[chr(151)] = '&mdash;';	// Em Dash
		$trans[chr(152)] = '&tilde;';	// Small Tilde
		$trans[chr(153)] = '&trade;';	// Trade Mark Sign
		$trans[chr(154)] = '&scaron;';	// Latin Small Letter S With Caron
		$trans[chr(155)] = '&rsaquo;';	// Single Right-Pointing Angle Quotation Mark
		$trans[chr(156)] = '&oelig;';	// Latin Small Ligature OE
		$trans[chr(159)] = '&Yuml;';	// Latin Capital Letter Y With Diaeresis
		$trans['euro'] = '&euro;';	// euro currency symbol
		ksort($trans);

		foreach ($trans as $k => $v)
		{
			$text = str_replace($v, $k, $text);
		}

		// 3) remove <p>, <br/> ...
		$text = strip_tags($text);

		// 4) &amp; => & &quot; => '
		$text = html_entity_decode($text);

		// 5) remove Windows-1252 symbols like "TradeMark", "Euro"...
		$text = preg_replace('/[^(\x20-\x7F)]*/', '', $text);

		$targets = array('\r\n', '\n', '\r', '\t');
		$results = array(" ", " ", " ", "");
		$text = str_replace($targets, $results, $text);

		//XML compatible
		/*
		  $text = str_replace("&", "and", $text);
		  $text = str_replace("<", ".", $text);
		  $text = str_replace(">", ".", $text);
		  $text = str_replace("\\", "-", $text);
		  $text = str_replace("/", "-", $text);
		 */

		return ($text);
	}

	public static function seoString($string)
	{
		$dict = array(
			"I'm" => "I am",
			"thier" => "their",
		);
		return strtolower(
				preg_replace(
						array('#[\\s-]+#', '#[^A-Za-z0-9\. -]+#'), array('-', ''),
						self::cleanString(
								str_replace(// preg_replace to support more complicated replacements
										array_keys($dict), array_values($dict), urldecode($string)
								)
						)
				)
		);
	}
	
	
	// GOOGLE PAGE RANK
	public static function StrToNum($Str, $Check, $Magic) {
        $Int32Unit = 4294967296;  // 2^32
        $length = strlen($Str);
        for ($i = 0; $i < $length; $i++) {
            $Check *= $Magic;
            /*  If the float is beyond the boundaries of integer (usually +/- 2.15e+9 = 2^31),
                the result of converting to integer is undefined
                refer to http://www.php.net/manual/en/language.types.integer.php    */
            if ($Check >= $Int32Unit) {
                $Check = ($Check - $Int32Unit * (int) ($Check / $Int32Unit));
                //if the check less than -2^31
                $Check = ($Check < -2147483648) ? ($Check + $Int32Unit) : $Check;
            }
            $Check += ord($Str{$i});
        }
        return $Check;
    }
 
    // Generate a proper hash for an url
    public static function HashURL($String)
    {
        $Check1 = self::StrToNum($String, 0x1505, 0x21);
        $Check2 = self::StrToNum($String, 0, 0x1003F);
 
        $Check1 >>= 2;
        $Check1 = (($Check1 >> 4) & 0x3FFFFC0 ) | ($Check1 & 0x3F);
        $Check1 = (($Check1 >> 4) & 0x3FFC00 ) | ($Check1 & 0x3FF);
        $Check1 = (($Check1 >> 4) & 0x3C000 ) | ($Check1 & 0x3FFF);
 
        $T1 = (((($Check1 & 0x3C0) << 4) | ($Check1 & 0x3C)) <<2 ) | ($Check2 & 0xF0F );
        $T2 = (((($Check1 & 0xFFFFC000) << 4) | ($Check1 & 0x3C00)) << 0xA) | ($Check2 & 0xF0F0000 );
 
        return ($T1 | $T2);
    }
 
    // Generate a checksum for the hash
    public static function CheckHash($Hashnum) {
        $CheckByte = 0;
        $Flag = 0;
        $HashStr = sprintf('%u', $Hashnum) ;
        $length = strlen($HashStr);
        for ($i = $length - 1;  $i >= 0;  $i --) {
            $Re = $HashStr{$i};
            if (1 === ($Flag % 2)) {
                $Re += $Re;
                $Re = (int)($Re / 10) + ($Re % 10);
            }
            $CheckByte += $Re;
            $Flag ++;
        }
        $CheckByte %= 10;
        if (0 !== $CheckByte) {
            $CheckByte = 10 - $CheckByte;
            if (1 === ($Flag % 2) ) {
                if (1 === ($CheckByte % 2)) {
                    $CheckByte += 9;
                }
                $CheckByte >>= 1;
            }
        }
        return '7' . $CheckByte . $HashStr;
    }
 
    // Get the Google Pagerank
    public static function getPagerank($url) {
        $query = "http://toolbarqueries.google.com/tbr?client=navclient-auto&ch=" . self::CheckHash(self::HashURL($url)) . "&features=Rank&q=info:" . $url;
        $data = self::file_get_contents_curl($query);
        $pos = strpos($data, "Rank_");
        if($pos !== false){
            $pagerank = substr($data, $pos + 9);
            return trim($pagerank);
        }
    }
	
	public static function getAlexaRank($url) {
		$xml = simplexml_load_file("http://data.alexa.com/data?cli=10&url=".$url);
		if(isset($xml->SD)):
			return $xml->SD->REACH->attributes();
		endif;
		
		return 'N/A';
	}
	
	public static function getGoogleCount($url) {
		$content = file_get_contents('http://ajax.googleapis.com/ajax/services/' .
			'search/web?v=1.0&filter=0&q=site:' . urlencode($url));
		$data = json_decode($content);
		
		return isset($data->responseData->cursor->estimatedResultCount) ? intval($data->responseData->cursor->estimatedResultCount) : 'N/A';
	}
 
    // Use curl the get the file contents
    public static function file_get_contents_curl($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Set curl to return the data instead of printing it to the browser.
        curl_setopt($ch, CURLOPT_URL, $url);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
	
	public static function formatURL($url)
	{
		$protocolos = ['http://', 'https://'];
		
		if (strpos($a, $protocolos) !== false) 
		{
			return true;
		}
		
		return false;
		
		$format_url = rtrim(str_replace(['http://', 'https://'], '', $url), '/');
		
		
	}
	
	public static function generateThumb($domain)
	{
		$image_final = '';
	
		$image = new ThumbGenerator(); // create object
		$image->request($domain); // send request
		
		if ($image->headers['Status'] == "OK" || $image->headers['Status'] == "LOCAL") 
		{
			$image_full_dir = $image->local_cache_subdir;

			$pos = strrpos($image_full_dir, '/');
			
			$image_dir = ($pos === false) ? $image_full_dir : substr($image_full_dir, $pos + 1);
			
			$image_name = $image->local_cache_file;
			
			$image_final = $image_dir.'/'.$image_name;
		}
		
		return $image_final;
	}
	
	public static function lastVisited($date)
	{
		if( ! $date)
		{
			return 'N/A';
		}	
		
		return \Carbon\Carbon::createFromTimeStamp(strtotime($date))
			->diffForHumans();
	}
	
	public static function correctText($text, $char = ',')
	{
		$pieces = explode($char, $text);

		$i = 0;
		$r = '';
		
		foreach($pieces as $pice)
		{
			$a = trim($pice);
			
			$r .= ($i > 0 && !empty($a))? $char.' '.$a : $a;
		
			$i++;			
		}
		
		return preg_replace ("/ +/", " ", $r);
	}

}
