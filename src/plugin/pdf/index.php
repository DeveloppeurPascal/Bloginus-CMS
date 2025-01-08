<?php
	// Bloginus
	// (c) Patrick Prémartin / Olf Software 08-09/2014
	//
	// http://www.bloginus-lescript.fr

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
?>