<?php
	// Bloginus CMS
	// (c) 2014-2025 Patrick Prémartin / Olf Software
	//
	// This project is distributed under the AGPLv3 license.
	//
	// Go to this website for the documentation, download latest release,
	// buying a developer pro license or contacting us :
	// https://bloginus.olfsoftware.fr

	print("<p>Forçage du thème &quot;Bootstrap-Sample&quot; en tant que thème par défaut si aucun autre n'est indiqué.<br />");
	if ("" == config_getvar("theme",""))
	{
		config_setvar("theme", "bootstrap-sample");
	}
