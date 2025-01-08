<?php
	// Bloginus
	// (c) Patrick Prémartin / Olf Software 06/2014-05/2017
	//
	// http://www.bloginus-lescript.fr

	header("content-type: application/atom+xml");	
?><<?php print("?"); ?>xml version="1.0" encoding="UTF-8"<?php print("?"); ?>>
<feed xmlns="http://www.w3.org/2005/Atom">
	<title type="html"><![CDATA[<?php print(htmlentities(config_getvar("titre"),ENT_COMPAT,"UTF-8")); ?>]]></title>
	<link href="<?php print(config_getvar("url")); ?>" />
	<updated><?php print(date(DATE_ATOM)); ?></updated>
	<author><name><![CDATA[<?php print(config_getvar("auteur")); ?>]]></name></author>
	<link rel="self" type="application/atom+xml" href="<?php print(config_getvar("url")."/atom/"); ?>" />
	<id><?php print(config_getvar("url")."/atom/"); ?></id><?php
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
?><entry><title type="html"><![CDATA[<?php print(htmlentities($article["label"],ENT_COMPAT,"UTF-8")); ?>]]></title>
            <link href="<?php print(post_url($article["id"])); ?>" />
            <id><?php print(post_url($article["id"])); ?></id>
            <updated><?php print(date(DATE_ATOM,$article["timestamp"])); ?></updated>
			<summary type="html"><![CDATA[<?php print(substr(trim(strip_tags($article["text"])),0,200)." (...)"); ?>]]></summary>
        </entry>
<?php
				}
			}
		}
	}
?></feed>