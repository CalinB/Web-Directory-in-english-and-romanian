<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
  xmlns:xhtml="http://www.w3.org/1999/xhtml">
<?php
$domains = Domain::where('status', 1)
	->orderBy('updated_at', 'DESC')
	->get(['id', 'updated_at']);

	if($domains) :	
		foreach($domains as $domain) : 
			$ro_url = LaravelLocalization::getLocalizedURL('ro', Domain::seoURL($domain->id), 'ro');
			$en_url = LaravelLocalization::getLocalizedURL('en', Domain::seoURL($domain->id), 'en');
?>
			<url>
				<loc><?php echo $ro_url ?></loc>
				<xhtml:link rel="alternate" hreflang="ro" href="<?php echo $ro_url ?>" />
				<xhtml:link rel="alternate" hreflang="en" href="<?php echo $en_url ?>" />
				<priority>1</priority>
				<lastmod><?php echo date('c', strtotime($domain->updated_at)) ?></lastmod>
				<changefreq>daily</changefreq>
			</url>
			<url>
				<loc><?php echo $en_url ?></loc>
				<xhtml:link rel="alternate" hreflang="ro" href="<?php echo $ro_url ?>" />
				<xhtml:link rel="alternate" hreflang="en" href="<?php echo $en_url ?>" />
				<priority>1</priority>
				<lastmod><?php echo date('c', strtotime($domain->updated_at)) ?></lastmod>
				<changefreq>daily</changefreq>
			</url>
			<?php
		endforeach;
	endif; ?>
</urlset>