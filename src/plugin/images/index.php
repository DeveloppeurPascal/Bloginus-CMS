<?php
	// Bloginus
	// (c) Patrick Prémartin / Olf Software 07-08/2014
	//
	// http://www.bloginus-lescript.fr

	$elem = bloginus_getvar("param");
	if ((2 <= count($elem)) && ("images" == $elem[0]))
	{
		$extension = "";
		$ext = strtolower(pathinfo($elem[count($elem)-1],PATHINFO_EXTENSION));
		if ("gif" == $ext)
			$extension = "gif";
		if ("jpg" == $ext)
			$extension = "jpeg";
		if ("jpeg" == $ext)
			$extension = "jpeg";
		if ("png" == $ext)
			$extension = "png";
		if ("" != $extension)
		{
			if ("admin" == $elem[1])
			{
				if (file_exists(dirname(__FILE__)."/../admin/".$elem[0]."/".liste_parametres($elem,2)))
				{
					header("content-type: image/".$extension);
					readfile(dirname(__FILE__)."/../admin/".$elem[0]."/".liste_parametres($elem,2));
					exit;
				}
			}
			else
			{
				$theme = config_getvar("theme","_default");
				if (file_exists(dirname(__FILE__)."/../../theme/".$theme."/".$elem[0]."/".liste_parametres($elem,1)))
				{
					header("content-type: image/".$extension);
					readfile(dirname(__FILE__)."/../../theme/".$theme."/".$elem[0]."/".liste_parametres($elem,1));
					exit;
				}
				else if (file_exists(dirname(__FILE__)."/../../theme/_default/".$elem[0]."/".liste_parametres($elem,1)))
				{
					header("content-type: image/".$extension);
					readfile(dirname(__FILE__)."/../../theme/_default/".$elem[0]."/".liste_parametres($elem,1));
					exit;
				}
				else if (file_exists(dirname(__FILE__)."/../../".$elem[0]."/".liste_parametres($elem,1)))
				{
					header("content-type: image/".$extension);
					readfile(dirname(__FILE__)."/../../".$elem[0]."/".liste_parametres($elem,1));
					exit;
				}
			}
		}
	}
	page404();
?>