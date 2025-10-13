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
	
	fichier_inclure("_header.php");
?><div id="postBloc">
	<div id="postText"><?php print($article["text"]); ?></div>
	<div id="postDate">Mis à jour le <?php print(aaaammjjhhmmss_to_string(date("YmdHis",intval($article["timestamp"])))); ?></div>
</div><?php
	fichier_inclure("_footer.php");
