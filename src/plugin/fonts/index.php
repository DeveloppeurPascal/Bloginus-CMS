<?php
	// Bloginus
	// (c) Patrick Prémartin / Olf Software 03/2016
	//
	// http://www.bloginus-lescript.fr

	$elem = bloginus_getvar("param");
	if ((2 <= count($elem)) && ("fonts" == $elem[0]))
	{
		$extension = "";
		$ext = strtolower(pathinfo($elem[count($elem)-1],PATHINFO_EXTENSION));
		if (("otf" == $ext) || ("ttf" == $ext))
			$extension = "application/font-sfnt";
		if ("svg" == $ext)
			$extension = "image/svg+xml";
		if ("eot" == $ext)
			$extension = "application/vnd.ms-fontobject";
		if (("woff" == $ext) || ("woff2" == $ext))
			$extension = "application/font-woff";
		if ("" != $extension)
		{
			if ("admin" == $elem[1])
			{
				if (file_exists(dirname(__FILE__)."/../admin/".$elem[0]."/".liste_parametres($elem,2)))
				{
					header("content-type: ".$extension);
					readfile(dirname(__FILE__)."/../admin/".$elem[0]."/".liste_parametres($elem,2));
					exit;
				}
			}
			else
			{
				$theme = config_getvar("theme","_default");
				if (file_exists(dirname(__FILE__)."/../../theme/".$theme."/".$elem[0]."/".liste_parametres($elem,1)))
				{
					header("content-type: ".$extension);
					readfile(dirname(__FILE__)."/../../theme/".$theme."/".$elem[0]."/".liste_parametres($elem,1));
					exit;
				}
				else if (file_exists(dirname(__FILE__)."/../../theme/_default/".$elem[0]."/".liste_parametres($elem,1)))
				{
					header("content-type: ".$extension);
					readfile(dirname(__FILE__)."/../../theme/_default/".$elem[0]."/".liste_parametres($elem,1));
					exit;
				}
				else if (file_exists(dirname(__FILE__)."/../../".$elem[0]."/".liste_parametres($elem,1)))
				{
					header("content-type: ".$extension);
					readfile(dirname(__FILE__)."/../../".$elem[0]."/".liste_parametres($elem,1));
					exit;
				}
			}
		}
	}
	page404();
?>