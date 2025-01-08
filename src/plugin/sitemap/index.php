<?php
	// Bloginus
	// (c) Patrick Prémartin / Olf Software 06-08/2014
	//
	// http://www.bloginus-lescript.fr
	
	function ajoute_url($url,$timestamp)
	{
		if ("" != $url)
		{
			print("<url>");
			print("<loc>".$url."</loc>");
			if (0 < $timestamp)
			{
				print("<lastmod>".date("Y",$timestamp)."-".date("m",$timestamp)."-".date("d",$timestamp)."</lastmod>");
			}
			print("</url>");
		}
	}
	function parcourt_arborescence($id)
	{
		$categorie = category_get_infos($id);
		if (is_array($categorie))
		{
			if ($categorie["published"] && ((config_getvar("seo_c",false) && (! isset($categorie["seo"]))) || ((true === $categorie["seo"]) || (("" === $categorie["seo"]) && config_getvar("seo_c",false)))))
			{
				ajoute_url(category_url($id),(isset($categorie["timestamp"]))?$categorie["timestamp"]:0);
			}
		}
		$souscategories = category_get_liste($id);
		if (is_array($souscategories))
		{
			reset($souscategories);
			while(list($key,$subcat)=each($souscategories))
			{
				parcourt_arborescence($subcat["id"]);
			}
		}
		$articles = post_get_liste($id);
		if (is_array($articles))
		{
			reset($articles);
			while(list($key,$article)=each($articles))
			{
				if ($article["published"] && ((config_getvar("seo_p",false) && (! isset($article["seo"]))) || ((true === $article["seo"]) || (("" === $article["seo"]) && config_getvar("seo_p",false)))))
				{
					ajoute_url(post_url($article["id"]),(isset($article["timestamp"]))?$article["timestamp"]:0);
				}
			}
		}
	}
	header("content-type: application/xml");
?><<?php print("?"); ?>xml version="1.0" encoding="UTF-8"<?php print("?"); ?>>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"><?php
	parcourt_arborescence("_");
?></urlset>