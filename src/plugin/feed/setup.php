<?php
	// Bloginus
	// (c) Patrick Prémartin / Olf Software 06-08/2014
	//
	// https://bloginus.olfsoftware.fr
	
	@unlink(creer_dossier(get_data_path())."/posts-all.dta");
	feed_regenerer_liste();
	print("<p>Génération de la liste des articles du site pour les interactions avec les modules \"feed\" et \"atom\".</p>");
?>