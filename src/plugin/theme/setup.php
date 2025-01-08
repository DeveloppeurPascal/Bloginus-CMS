<?php
	// Bloginus
	// (c) Patrick Prémartin / Olf Software 01/2016
	//
	// http://www.bloginus-lescript.fr
	print("<p>Forçage du thème &quot;Bootstrap-Sample&quot; en tant que thème par défaut si aucun autre n'est indiqué.<br />");
	if ("" == config_getvar("theme",""))
	{
		config_setvar("theme", "bootstrap-sample");
	}
?>