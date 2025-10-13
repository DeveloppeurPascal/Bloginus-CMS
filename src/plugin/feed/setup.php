<?php
	// Bloginus CMS
	// (c) 2014-2025 Patrick Prémartin / Olf Software
	//
	// This project is distributed under the AGPLv3 license.
	//
	// Go to this website for the documentation, download latest release,
	// buying a developer pro license or contacting us :
	// https://bloginus.olfsoftware.fr

	@unlink(creer_dossier(get_data_path())."/posts-all.dta");
	feed_regenerer_liste();
	print("<p>Génération de la liste des articles du site pour les interactions avec les modules \"feed\" et \"atom\".</p>");
