<?php
	// Bloginus
	// (c) Patrick Prémartin / Olf Software 06/2014
	//
	// http://www.bloginus-lescript.fr

	require_once(dirname(__FILE__)."/_header.php");
	// création de la clé si elle n'existe pas
	if (false === bloginus_setvar("key",key_save()))
	{
		print("<br>erreur : creation de la cle impossible");
	}

	// création de l'arborescence
	@mkdir(get_data_path());
	
	file_put_contents(get_data_path()."/.htaccess","order deny,allow\r\ndeny from all\r\n");
	file_put_contents(dirname(__FILE__)."/../../protected/.htaccess","order deny,allow\r\ndeny from all\r\n");

	// setup des différents plugins
	if ($dossier = opendir(dirname(__FILE__)."/.."))
	{
		while (false !== ($fichier = readdir($dossier)))
		{
			if (("." != substr($fichier,0,1)) && ("admin" != $fichier) && (is_dir(dirname(__FILE__)."/../".$fichier)) && (file_exists(dirname(__FILE__)."/../".$fichier."/setup.php")))
			{
				
				// print("<br>configuration de ".dirname(__FILE__)."/../".$fichier);
				require_once(dirname(__FILE__)."/../".$fichier."/setup.php");
			}
		}
	}

	// validation de la mise à jour (ou configuration)
	version_save();
	print("<br>mise a jour terminee, tout est ok");
	print("<br><a href=\"".site_url()."/admin/index.php\">administrer ce script</a>");
	require_once(dirname(__FILE__)."/_footer.php");
?>