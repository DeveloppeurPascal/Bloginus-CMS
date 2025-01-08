<?php
	// Bloginus
	// (c) Patrick Prémartin / Olf Software 06/2014-07/2015
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
	
	if (! is_dir(dirname(__FILE__)."/../../temp"))
	{
		@mkdir(dirname(__FILE__)."/../../temp");
		if (! is_dir(dirname(__FILE__)."/../../temp"))
		{
			print("<br>création du dossier /temp effectuée");
		}
		else
		{
			print("<br>erreur : impossible de créer le dossier /temp");
		}
	}
	
	file_put_contents(get_data_path()."/.htaccess","order deny,allow\r\ndeny from all\r\n");
	file_put_contents(dirname(__FILE__)."/../../protected/.htaccess","order deny,allow\r\ndeny from all\r\n");
	
	if (false === file_exists(dirname(__FILE__)."/../../.htaccess"))
	{
		rename(dirname(__FILE__)."/../../htaccess.txt", dirname(__FILE__)."/../../.htaccess");
	}
	else if (false !== file_exists(dirname(__FILE__)."/../../htaccess.txt"))
	{
		$acc_pt = file_get_contents(dirname(__FILE__)."/../../.htaccess");
		$acc_txt = file_get_contents(dirname(__FILE__)."/../../htaccess.txt");
		if ($acc_pt === $acc_txt)
		{
			unlink(dirname(__FILE__)."/../../htaccess.txt");
		}
		else
		{
			print("<br>Une mise à jour du .htaccess est nécessaire, mais nous ne pouvons la faire pour vous. Veuillez comparer .htaccess et htaccess.txt présents à la racine de votre site pour les fusionner, puis supprimer le fichier htaccess.txt");
			exit;
		}
	}

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