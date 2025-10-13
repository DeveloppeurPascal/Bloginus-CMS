<?php
	// Bloginus CMS
	// (c) 2014-2025 Patrick Prémartin / Olf Software
	//
	// This project is distributed under the AGPLv3 license.
	//
	// Go to this website for the documentation, download latest release,
	// buying a developer pro license or contacting us :
	// https://bloginus.olfsoftware.fr

	$elem = bloginus_getvar("param");
	$categorie_id = "";
	$c = "";
	for ($i = 0; ($i < strlen($elem[1])) && ($c != "-"); $i++)
	{
		$c = substr($elem[1],$i,1);
		if ((($c >= "0") && ($c <= "9")) || (($c >= "a") && ($c <= "z")) || ("_" == $c))
			$categorie_id .= $c;
	}
	if (false === ($categorie = category_get_infos($categorie_id)))
	{ // catégorie inexistante
		page404();
	}
	else if ((! $categorie["published"]) && (! (isset($_SESSION["user_connected"]) && ("1" == $_SESSION["user_connected"]))))
	{ // catégorie non publiée (sauf pour les membres connectés qui peuvent voir toutes les pages)
		page404();
	}
	else if (false === ($categorie_url = category_url($categorie_id)))
	{ // pas d'URL pour la catégorie
		page404();
	}
	else if (($categorie_url != "") && ($categorie_url != config_getvar("url").((("_"==$categorie_id) && ("_"==$elem[1]))?"/":"/c/".$elem[1])))
	{ // URL de la catégorie différente de celle appelée, on redirige vers la bonne
		header("location: ".$categorie_url, true, 301);
		exit;
	}
	else
	{
		$souscategories = category_get_liste($categorie_id);
		$autresarticles = post_get_liste($categorie_id);
		if ("_" == $categorie_id)
		{
			fichier_inclure("index.php");
		}
		else
		{
			fichier_inclure("category.php");
		}
	}
