<?php
	// Bloginus
	// (c) Patrick Prémartin / Olf Software 06-08/2014
	//
	// http://www.bloginus-lescript.fr
	print("<p>Déclaration de votre sitemap aux moteurs de recherche.<br />");
	$robots_filename = dirname(__FILE__)."/../../robots.txt";
	$robots_sitemap = "Sitemap: ".config_getvar("url","http://".$_SERVER["HTTP_HOST"].site_url())."/sitemap/";
	if (false === file_exists($robots_filename))
	{
		file_put_contents($robots_filename,$robots_sitemap."\r\n");
		print("Fichier robots.txt créé:<br />".nl2br(file_get_contents($robots_filename)));
	}
	else
	{
		$robotstxt = file_get_contents($robots_filename);
		if (strpos($robotstxt,$robots_sitemap) === false)
		{
			file_put_contents($robots_filename,$robots_sitemap."\r\n".$robotstxt);
			print("Fichier robots.txt modifié:<br />".nl2br(file_get_contents($robots_filename)));
		}
		else
		{
			print("Fichier robots.txt inchangé:<br />".nl2br(file_get_contents($robots_filename)));
		}
	}
	print("Fin de la mise à jour pour le sitemap. <strong>Assurez-vous que le lien indiqué après \"sitemap:\" fonctionne correctement.</strong></p>");
?>