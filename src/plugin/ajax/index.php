<?php
	// Bloginus
	// (c) Patrick Prémartin / Olf Software 03/2016
	//
	// http://www.bloginus-lescript.fr
	$elem = bloginus_getvar("param");
	// var_dump($elem);exit;
	if (("ajax" == $elem[0]) && ("admin" == $elem[1]) && (4 <= count($elem)))
	{ // url/ajax/admin/module/fichier
		// print(dirname(__FILE__)."/../admin/".$elem[2]."/ajaxadmin/".liste_parametres($elem,3));exit;
		if (file_exists(dirname(__FILE__)."/../".$elem[2]."/ajaxadmin/".liste_parametres($elem,3)))
		{
			require_once(dirname(__FILE__)."/../".$elem[2]."/ajaxadmin/".liste_parametres($elem,3));
			exit;
		}
	}
	elseif (("ajax" == $elem[0]) && (3 <= count($elem)))
	{ // url/ajax/module/fichier
		if (file_exists(dirname(__FILE__)."/../".$elem[2]."/ajax/".liste_parametres($elem,3)))
		{
			require_once(dirname(__FILE__)."/../".$elem[2]."/ajax/".liste_parametres($elem,3));
			exit;
		}
	}
	elseif (("ajax" == $elem[0]) && (2 <= count($elem)))
	{
		$theme = config_getvar("theme","_default");
		if (file_exists(dirname(__FILE__)."/../../theme/".$theme."/ajax/".liste_parametres($elem,1)))
		{
			require_once(dirname(__FILE__)."/../../theme/".$theme."/ajax/".liste_parametres($elem,1));
			exit;
		}
		else if (file_exists(dirname(__FILE__)."/../../theme/_default/ajax/".liste_parametres($elem,1)))
		{
			require_once(dirname(__FILE__)."/../../theme/_default/ajax/".liste_parametres($elem,1));
			exit;
		}
		else if (file_exists(dirname(__FILE__)."/../../ajax/".liste_parametres($elem,1)))
		{
			require_once(dirname(__FILE__)."/../../ajax/".liste_parametres($elem,1));
			exit;
		}
	}
	page404();
?>