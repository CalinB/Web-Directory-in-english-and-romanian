<?php

class ThumbGenerator {

	const _THUMBALIZR = 1;
	
	public $thumbalizr_config;
	public $thumbalizr_defaults;

	function __construct()
	{
		$this->setConfig();		
		
		$this->api_key = $this->thumbalizr_config['api_key'];
		$this->service_url = $this->thumbalizr_config['service_url'];
		$this->use_local_cache = $this->thumbalizr_config['use_local_cache'];
		
		//$this->local_cache_dir = $this->thumbalizr_config['local_cache_dir'];
		$this->local_cache_dir = public_path('assets/thumbs');
		
		$this->local_cache_expire = $this->thumbalizr_config['local_cache_expire'];
		$this->encoding = $this->thumbalizr_defaults['encoding'];
		$this->quality = $this->thumbalizr_defaults['quality'];
		$this->delay = $this->thumbalizr_defaults['delay'];
		$this->bwidth = $this->thumbalizr_defaults['bwidth'];
		$this->mode = $this->thumbalizr_defaults['mode'];
		$this->bheight = $this->thumbalizr_defaults['bheight'];
		$this->width = $this->thumbalizr_defaults['width'];
	}
	
	private function setConfig()
	{
		$this->thumbalizr_config = Config::get('thumb.thumbalizr_config');
		$this->thumbalizr_defaults = Config::get('thumb.humbalizr_defaults');
	}

	private function build_request($url)
	{
		$this->request_url = $this->service_url . "?" .
			"api_key=" . $this->api_key . "&" .
			"quality=" . $this->quality . "&" .
			"width=" . $this->width . "&" .
			"encoding=" . $this->encoding . "&" .
			"delay=" . $this->delay . "&" .
			"mode=" . $this->mode . "&" .
			"bwidth=" . $this->bwidth . "&" .
			"bheight=" . $this->bheight . "&" .
			"url=" . $url;
		$this->local_cache_file = md5($url) . "_" . $this->bwidth . "_" . $this->bheight . "_" . $this->delay . "_" . $this->quality . "_" . $this->width . "." . $this->encoding;
		$this->local_cache_subdir = $this->local_cache_dir . "/" . substr(md5($url), 0, 2);
	}

	function request($url)
	{
		$this->build_request($url);
		if (file_exists($this->local_cache_subdir . "/" . $this->local_cache_file))
		{
			$filetime = filemtime($this->local_cache_subdir . "/" . $this->local_cache_file);
			$cachetime = time() - $filetime - ($this->local_cache_expire * 60 * 60);
		}
		else
		{
			$cachetime = -1;
		}
		if ( ! file_exists($this->local_cache_subdir . "/" . $this->local_cache_file) || $cachetime >= 0)
		{
			$this->img = file_get_contents($this->request_url);
			$headers = "";
			foreach ($http_response_header as $tmp) {
				if (strpos($tmp, 'X-Thumbalizr-') !== false)
				{
					$tmp1 = explode('X-Thumbalizr-', $tmp);
					$tmp2 = explode(': ', $tmp1[1]);
					$headers[$tmp2[0]] = $tmp2[1];
				}
			}
			$this->headers = $headers;
			$this->save();
		}
		else
		{
			$this->img = file_get_contents($this->local_cache_subdir . "/" . $this->local_cache_file);
			$this->headers['URL'] = $url;
			$this->headers['Status'] = 'LOCAL';
		}
	}

	private function save()
	{
		if ($this->img && $this->use_local_cache === TRUE && $this->headers['Status'] == "OK")
		{
			if ( ! file_exists($this->local_cache_subdir))
			{
				mkdir($this->local_cache_subdir);
			}
			$fp = fopen($this->local_cache_subdir . "/" . $this->local_cache_file, 'w');
			fwrite($fp, $this->img);
			fclose($fp);
		}
	}

	function output($sendHeader = true, $destroy = true)
	{
		if ($this->img)
		{
			if ($sendHeader)
			{
				if ($this->encoding == "jpg")
				{
					header("Content-type: image/jpeg");
				}
				else
				{
					header("Content-type: image/png");
				}
				foreach ($this->headers as $k => $v) {
					header("X-Thumbalizr-" . $k . ": " . $v);
				}
			}
			echo $this->img;
			if ($destroy)
			{
				$this->img = false;
			}
		}
		else
		{
			return false;
		}
	}

}
