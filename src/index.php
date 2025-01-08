<?php
	// Bloginus
	// (c) Patrick Prémartin / Olf Software 06-06/2015
	//
	// http://www.bloginus-lescript.fr
	session_start();
	
	define('_BloginusVersion_','4');

	// nettoyage des paramètres passés au programme
	if (get_magic_quotes_gpc())
	{
		// print("<br>nettoyage de \$_GET");
		reset($_GET);
		while (list($key,$value)=each($_GET))
		{
			$_GET[$key] = stripslashes($value);
		}
		// print("<br>nettoyage de \$_POST");
		reset($_POST);
		while (list($key,$value)=each($_POST))
		{
			$_POST[$key] = stripslashes($value);
		}
	}
	else
	{
		// print("<br>pas de nettoyage des paramètres");
	}

	// chargement des fichiers de /inc
	if ($dossier = opendir(dirname(__FILE__)."/inc"))
	{
		while (false !== ($fichier = readdir($dossier)))
		{
			if (preg_match("/\.php$/i",$fichier))
			{
				// print("<br>chargement de ".dirname(__FILE__)."/inc/".$fichier);
				require_once(dirname(__FILE__)."/inc/".$fichier);
			}
		}
	}
	
	// chargement de la clé
	if (false === bloginus_setvar("key",key_load()))
	{
		require_once(dirname(__FILE__)."/plugin/admin/setup.php");
		exit;
	}

	// chargement de la version
	if (intval(version_load()) < intval(_BloginusVersion_))
	{
			require_once(dirname(__FILE__)."/plugin/admin/setup.php");
			exit;
	}

	// décomposition des éléments de l'url appelée
	$url = substr($_SERVER["REQUEST_URI"],strlen(site_url())+1); // "/" final à prendre en compte
	// print("<br>adresse appelée : ".$url);
	$elem = explode("/",$url);
	reset($elem);
	while (list($key,$value) = each($elem))
	{
		$elem[$key] = trim($value);
	}
	if ("" == $elem[0])
	{
		$url = config_getvar("rooturl","");
		if ("" != $url)
		{
			header("location: ".$url);
			exit;
		}
		else
		{
			$elem[0] = "c";
			$elem[1] = "_";
		}
	}
	elseif ("index.html" == $elem[0])
	{
		$elem[0] = "c";
		$elem[1] = "_";
	}
	else
	{
		while ((count($elem) > 1) && ("." == substr($elem[0],0,1)))
		{
			array_shift($elem);
		}
		if ("." == substr($elem[0],0,1))
		{
			$elem[0] = "c";
			$elem[1] = "_";
		}
	}
	bloginus_setvar("param",$elem);
	
	if (file_exists(dirname(__FILE__)."/plugin/".$elem[0]."/index.php"))
	{
		require_once(dirname(__FILE__)."/plugin/".$elem[0]."/index.php");
		exit;
	}
	else
	{
		page404("module absent
".$_SERVER["PHP_SELF"]."
".basename($_SERVER["PHP_SELF"])."
".dirname($_SERVER["PHP_SELF"])."
".$_SERVER["REQUEST_URI"]."
".nl2br(print_r($elem,true)));
	}
?>