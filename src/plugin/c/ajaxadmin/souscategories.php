<?php
	// Bloginus CMS
	// (c) 2014-2025 Patrick Prémartin / Olf Software
	//
	// This project is distributed under the AGPLv3 license.
	//
	// Go to this website for the documentation, download latest release,
	// buying a developer pro license or contacting us :
	// https://bloginus.olfsoftware.fr

	$liste = array();
	$categorie_id = (! isset($_GET["c"]))?"":$_GET["c"]; // catégorie dont on veut les sous-categories
	$categorie_liste = category_get_liste($categorie_id);
	if (is_array($categorie_liste))
	{
		reset($categorie_liste);
		while (list($key,$value)=each($categorie_liste))
		{
			$cat = category_get_infos($value["id"]);
			$elem = new StdClass();
			$elem->id = $cat["id"];
			$elem->label = $cat["label"];
			$liste[] = $elem;
			unset($elem);
		}
	}
	elseif ("" == $categorie_id)
	{
		$cat = category_get_infos("_");
		$elem = new StdClass();
		$elem->id = $cat["id"];
		$elem->label = ("" == $cat["label"])?"*****":$cat["label"];
		$liste[] = $elem;
		unset($elem);
	}
	print(json_encode($liste));
	exit;
