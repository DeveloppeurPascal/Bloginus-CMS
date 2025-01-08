<?php
	// Bloginus
	// (c) Patrick Prémartin / Olf Software 07-08/2014
	//
	// http://www.bloginus-lescript.fr

	$elem = bloginus_getvar("param");
	if ((2 <= count($elem)) && ("images" == $elem[0]))
	{
		$extension = "";
		$ext = strtolower(pathinfo($elem[1],PATHINFO_EXTENSION));
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
			header("content-type: image/".$extension);
			if ("admin" == $elem[1])
			{
				$elem[1] = $elem[2];
				if (file_exists(dirname(__FILE__)."/../admin/".$elem[0]."/".$elem[1]))
				{
					readfile(dirname(__FILE__)."/../admin/".$elem[0]."/".$elem[1]);
				}
				exit;
			}
			$theme = config_getvar("theme","_default");
			if (file_exists(dirname(__FILE__)."/../../theme/".$theme."/".$elem[0]."/".$elem[1]))
			{
				readfile(dirname(__FILE__)."/../../theme/".$theme."/".$elem[0]."/".$elem[1]);
			}
			else if (file_exists(dirname(__FILE__)."/../../theme/_default/".$elem[0]."/".$elem[1]))
			{
				readfile(dirname(__FILE__)."/../../theme/_default/".$elem[0]."/".$elem[1]);
			}
			exit;
		}
	}
?>