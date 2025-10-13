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
	if ((2 <= count($elem)) && ("pdf" == $elem[0]))
	{
		if ("admin" == $elem[1])
		{
			if (file_exists(dirname(__FILE__)."/../admin/".$elem[0]."/".liste_parametres($elem,2)))
			{
				header("content-type: application/pdf");
				readfile(dirname(__FILE__)."/../admin/".$elem[0]."/".liste_parametres($elem,2));
				exit;
			}
		}
		else
		{
			$theme = config_getvar("theme","_default");
			if (file_exists(dirname(__FILE__)."/../../theme/".$theme."/".$elem[0]."/".liste_parametres($elem,1)))
			{
				header("content-type: application/pdf");
				readfile(dirname(__FILE__)."/../../theme/".$theme."/".$elem[0]."/".liste_parametres($elem,1));
				exit;
			}
			else if (file_exists(dirname(__FILE__)."/../../theme/_default/".$elem[0]."/".liste_parametres($elem,1)))
			{
				header("content-type: application/pdf");
				readfile(dirname(__FILE__)."/../../theme/_default/".$elem[0]."/".liste_parametres($elem,1));
				exit;
			}
			else if (file_exists(dirname(__FILE__)."/../../".$elem[0]."/".liste_parametres($elem,1)))
			{
				header("content-type: application/pdf");
				readfile(dirname(__FILE__)."/../../".$elem[0]."/".liste_parametres($elem,1));
				exit;
			}
		}
	}
	page404();
