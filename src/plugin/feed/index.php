<?php
	// Bloginus
	// (c) Patrick Prémartin / Olf Software 06/2014-05/2017
	//
	// http://www.bloginus-lescript.fr

	header("content-type: application/rss+xml");	
?><<?php print("?"); ?>xml version="1.0" encoding="UTF-8"<?php print("?"); ?>>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
		<atom:link href="<?php print(config_getvar("url")); ?>/feed/" rel="self" type="application/rss+xml" />
        <title><![CDATA[<?php print(config_getvar("titre")); ?>]]></title>
        <description>Liste des articles du site.</description>
        <link><?php print(config_getvar("url")); ?></link>
        <language><?php print(config_getvar("langue")); ?></language><?php
	$articles = post_get_liste_feed();
	if (! is_array($articles))
	{
		feed_regenerer_liste();
		$articles = post_get_liste_feed();
	}
	if (is_array($articles))
	{
		foreach ($articles as $key=>$value)
		{
			if ($value["published"])
			{
				$article = post_get_infos($value["id"]);
				if (is_array($article))
				{
?><item><title><![CDATA[<?php print($article["label"]); ?>]]></title>
            <description><![CDATA[<?php print(substr(trim(strip_tags($article["text"])),0,200)." (...)"); ?>]]></description>
            <pubDate><?php print(date(DATE_RFC2822,$article["timestamp"])); ?></pubDate>
            <link><?php print(post_url($article["id"])); ?></link>
            <guid><?php print(post_url($article["id"])); ?></guid>
        </item>
<?php
				}
			}
		}
	}
?></channel>
</rss>