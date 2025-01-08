<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php
	if ((!isset($titre_page)) || ("" == $titre_page))
	{
		if (isset($article) && is_array($article))
		{
			$titre_page = trim($article["label"]);
		}
		else if (isset($categorie) && is_array($categorie) && ("0" != $categorie["id"]))
		{
			$titre_page = trim($categorie["label"]);
		}
		else
		{
			$titre_page = "";
		}
	}
	$titre = (("" != $titre_page)?$titre_page." - ":"").trim(config_getvar("titre"));
	print(htmlentities($titre,ENT_COMPAT,"UTF-8"));
?></title>
<meta name="author" content="<?php print(htmlentities(config_getvar("auteur"),ENT_COMPAT,"UTF-8")); ?>">
<meta name="robots" content="<?php
	$robots = "follow,noindex,noarchive,nosnippet,noodp,noydir";
	if (isset($article) && is_array($article))
	{
		if ((isset($article["seo"]) && ((true === $article["seo"]) || (("" === $article["seo"]) && config_getvar("seo_p",true)))) || ((! isset($article["seo"])) && config_getvar("seo_p",true)))
		{
			$robots = "follow,index";
		}
	}
	else if (isset($categorie) && is_array($categorie))
	{
		if ((isset($categorie["seo"]) && ((true === $categorie["seo"]) || (("" === $categorie["seo"]) && config_getvar("seo_c",false)))) || ((! isset($categorie["seo"])) && config_getvar("seo_c",false)))
		{
			$robots = "follow,index";
		}
	}
	print($robots);
?>">
<meta http-equiv="Content-Language" content="<?php print(htmlentities(config_getvar("langue","fr"),ENT_COMPAT,"UTF-8")); ?>">