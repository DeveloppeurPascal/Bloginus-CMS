<?php
	// Bloginus
	// (c) Patrick Prémartin / Olf Software 07/2014
	//
	// http://www.bloginus-lescript.fr

	$elem = bloginus_getvar("param");
	if ((2 <= count($elem)) && ("js" == $elem[0]))
	{
		header("content-type: application/javascript");
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
?>