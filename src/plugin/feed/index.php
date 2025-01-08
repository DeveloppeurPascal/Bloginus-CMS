<?php
	// Bloginus
	// (c) Patrick Prémartin / Olf Software 06/2014-06/2015
	//
	// http://www.bloginus-lescript.fr

	header("content-type: application/rss+xml");	
?><<?php print("?"); ?>xml version="1.0" encoding="UTF-8"<?php print("?"); ?>>
<rss version="2.0">
    <channel>
        <title><![CDATA[<?php print(htmlentities(config_getvar("titre"),ENT_COMPAT,"UTF-8")); ?>]]></title>
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
		reset($articles);
		while(list($key,$value)=each($articles))
		{
			if ($value["published"])
			{
				$article = post_get_infos($value["id"]);
				if (is_array($article))
				{
?><item><title><!CDATA[[<?php print(htmlentities($article["label"],ENT_COMPAT,"UTF-8")); ?>]]></title>
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