<?php
	// Bloginus CMS
	// (c) 2014-2025 Patrick Prémartin / Olf Software
	//
	// This project is distributed under the AGPLv3 license.
	//
	// Go to this website for the documentation, download latest release,
	// buying a developer pro license or contacting us :
	// https://bloginus.olfsoftware.fr

	// **************************************************
	// * thème par défaut, ne pas modifier ce fichier
	// **************************************************
	
	$titre_page = "Message envoyé";
	fichier_inclure("_header.php");
?><div id="pageContact"><?php
	print(config_getvar("contact-merci","<p class=\"msgInfo\">Votre message a bien été envoyé. Nous vous répondrons dès que possible.</p>"));
?></div><?php
	fichier_inclure("_footer.php");
