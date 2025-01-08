<?php
	// Bloginus
	// (c) Patrick Prémartin / Olf Software 06-08/2014
	//
	// http://www.bloginus-lescript.fr

	$elem = bloginus_getvar("param");
	$article_id = "";
	$c = "";
	for ($i = 0; ($i < strlen($elem[1])) && ($c != "-"); $i++)
	{
		$c = substr($elem[1],$i,1);
		if ((($c >= "0") && ($c <= "9")) || (($c >= "a") && ($c <= "z")) || ("_" == $c))
			$article_id .= $c;
	}
	if (false === ($article = post_get_infos($article_id)))
	{ // article inexistant
		page404();
	}
	else if ((! $article["published"]) && (! (isset($_SESSION["user_connected"]) && ("1" == $_SESSION["user_connected"]))))
	{ // article non publié (sauf pour les membres connectés qui peuvent voir toutes les pages)
		page404();
	}
	else if (false === ($article_url = post_url($article_id)))
	{ // pas d'URL pour l'article
		page404();
	}
	else if (($article_url != "") && ($article_url != config_getvar("url")."/p/".$elem[1]))
	{ // URL de l'article différente de celle appelée, on redirige vers la bonne
		header("location: ".$article_url, true, 301);
		exit;
	}
	else
	{
		$categorie_id = post_get_category_id($article_id);
		$categorie = category_get_infos($categorie_id);
		$souscategories = category_get_liste($categorie_id);
		$autresarticles = post_get_liste($categorie_id);
		fichier_inclure("post.php");
	}
?>