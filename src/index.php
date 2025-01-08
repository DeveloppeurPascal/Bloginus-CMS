<?php
	// Bloginus
	// (c) Patrick Prémartin / Olf Software 06/2014 - 01/2016
	//
	// http://www.bloginus-lescript.fr
	session_start();
	
	define('_BloginusVersion_','6'); // 20220502 - mise à niveau vers PHP 7.x

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
	foreach ($elem as $key=>$value)
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