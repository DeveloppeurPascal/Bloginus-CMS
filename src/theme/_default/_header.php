<?php
	// Bloginus CMS
	// (c) 2014-2025 Patrick Prémartin / Olf Software
	//
	// This project is distributed under the AGPLv3 license.
	//
	// Go to this website for the documentation, download latest release,
	// buying a developer pro license or contacting us :
	// https://bloginus.olfsoftware.fr

	// **************************************************
	// * thème par défaut, ne pas modifier ce fichier
	// **************************************************
	
?><!DOCTYPE html>
<html>
<head><?php
	fichier_inclure("_header-meta.php");
?><meta name="viewport" content="width=device-width, initial-scale=1.0"><link rel="stylesheet" type="text/css" href="<?php print(site_url()); ?>/css/styles.css">
</head><body><div id="header"><h1><?php
	$titre = trim(config_getvar("titre"));
	print(htmlentities(("" == $titre_page)?$titre:$titre_page,ENT_COMPAT,"UTF-8")); ?></h1></div><div id="page"><div id="contenu"><?php
	$fildariane = "";
	$id = (isset($categorie_id))?$categorie_id:"_";
	while (strlen($id) > 0)
	{
		$cat = category_get_infos($id);
		if (("_" == $cat["id"]) && ("" == $cat["label"]))
		{
			$cat["label"] = "Accueil";
		}
		if ($cat["published"])
		{
			$fildariane = "&gt; <a href=\"".category_url($cat["id"])."\">".(("" != trim($cat["label"]))?trim($cat["label"]):"*****")."</a> ".$fildariane;
		}
		$id = substr($id,0,strlen($id)-1);
	}
?><div id="fildariane"><?php print($fildariane); ?></div>