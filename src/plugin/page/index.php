<?php
	// Bloginus
	// (c) Patrick Prémartin / Olf Software 08-09/2014
	//
	// http://www.bloginus-lescript.fr

	$elem = bloginus_getvar("param");
	$page_id = "";
	$c = "";
	for ($i = 0; ($i < strlen($elem[1])) && ($c != "-"); $i++)
	{
		$c = substr($elem[1],$i,1);
		if ((($c >= "0") && ($c <= "9")) || (($c >= "a") && ($c <= "z")))
			$page_id .= $c;
	}
	if (false === ($page = page_get_infos($page_id)))
	{ // page inexistant
		page404();
	}
	else if ((! $page["published"]) && (! (isset($_SESSION["user_connected"]) && ("1" == $_SESSION["user_connected"]))))
	{ // page non publiée (sauf pour les membres connectés qui peuvent voir toutes les pages)
		unset($page);
		page404();
	}
	else if (false === ($page_url = page_url($page_id)))
	{ // pas d'URL pour la page
		unset($page);
		page404();
	}
	else if (($page_url != "") && ($page_url != config_getvar("url")."/page/".$elem[1]))
	{ // URL de la page différente de celle appelée, on retourne une erreur 404
		unset($page);
		page404();
	}
	else
	{
		fichier_inclure("page.php");
	}
?>