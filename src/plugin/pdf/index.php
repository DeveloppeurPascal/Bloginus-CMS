<?php
	// Bloginus
	// (c) Patrick Prémartin / Olf Software 08/2014
	//
	// http://www.bloginus-lescript.fr

	$elem = bloginus_getvar("param");
	if ((2 <= count($elem)) && ("pdf" == $elem[0]))
	{
		if ("admin" == $elem[1])
		{
			$elem[1] = $elem[2];
			if (file_exists(dirname(__FILE__)."/../admin/".$elem[0]."/".$elem[1]))
			{
				header("content-type: application/pdf");
				readfile(dirname(__FILE__)."/../admin/".$elem[0]."/".$elem[1]);
				exit;
			}
		}
		else
		{
			$theme = config_getvar("theme","_default");
			if (file_exists(dirname(__FILE__)."/../../theme/".$theme."/".$elem[0]."/".$elem[1]))
			{
				header("content-type: application/pdf");
				readfile(dirname(__FILE__)."/../../theme/".$theme."/".$elem[0]."/".$elem[1]);
				exit;
			}
			else if (file_exists(dirname(__FILE__)."/../../theme/_default/".$elem[0]."/".$elem[1]))
			{
				header("content-type: application/pdf");
				readfile(dirname(__FILE__)."/../../theme/_default/".$elem[0]."/".$elem[1]);
				exit;
			}
			else if (file_exists(dirname(__FILE__)."/../../".$elem[0]."/".$elem[1]))
			{
				header("content-type: application/pdf");
				readfile(dirname(__FILE__)."/../../".$elem[0]."/".$elem[1]);
				exit;
			}
		}
	}
	page404();
?>