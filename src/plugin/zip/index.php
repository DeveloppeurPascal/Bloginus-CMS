<?php
	// Bloginus
	// (c) Patrick Prémartin / Olf Software 07/2014 - 01/2016
	//
	// http://www.bloginus-lescript.fr

	$elem = bloginus_getvar("param");
	$nom_fichier = strtolower($elem[count($elem)-1]);
	$mimetype = "application/".((".zip" == substr($nom_fichier,strlen($nom_fichier)-4,4))?"zip":"octet-stream");
	if ((3 <= count($elem)) && ("admin" == $elem[1]) && ("zip" == $elem[0]))
	{
		if (file_exists(dirname(__FILE__)."/../admin/".$elem[0]."/".liste_parametres($elem,2)))
		{
			header("content-type: ".$mimetype);
			readfile(dirname(__FILE__)."/../admin/".$elem[0]."/".liste_parametres($elem,2));
			exit;
		}
	}
	else if ((2 <= count($elem)) && ("zip" == $elem[0]))
	{
		$theme = config_getvar("theme","_default");
		if (file_exists(dirname(__FILE__)."/../../theme/".$theme."/".$elem[0]."/".liste_parametres($elem,1)))
		{
			header("content-type: ".$mimetype);
			readfile(dirname(__FILE__)."/../../theme/".$theme."/".$elem[0]."/".liste_parametres($elem,1));
			exit;
		}
		else if (file_exists(dirname(__FILE__)."/../../theme/_default/".$elem[0]."/".liste_parametres($elem,1)))
		{
			header("content-type: ".$mimetype);
			readfile(dirname(__FILE__)."/../../theme/_default/".$elem[0]."/".liste_parametres($elem,1));
			exit;
		}
		else if (file_exists(dirname(__FILE__)."/../../".$elem[0]."/".liste_parametres($elem,1)))
		{
			header("content-type: ".$mimetype);
			readfile(dirname(__FILE__)."/../../".$elem[0]."/".liste_parametres($elem,1));
			exit;
		}
	}
	page404();
?>