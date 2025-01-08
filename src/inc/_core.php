<?php
	// Bloginus
	// (c) Patrick Prémartin / Olf Software 06/2014 - 01/2016
	//
	// http://www.bloginus-lescript.fr

	// **********          **********          **********          **********          **********          **********
	// * use those functions if you want to make a new theme or plugin
	// **********          **********          **********          **********          **********          **********

	$BLOGINUS = array();
	$BLOGINUS_CONF = array();

	// bloginus_setvar : set Bloginus global variable
	function bloginus_setvar($name, $value)
	{
		global $BLOGINUS;
		$name = strtolower($name);
		$BLOGINUS[$name] = $value;
		return $BLOGINUS[$name];
	}

	// bloginus_getvar : get Bloginus global variable
	function bloginus_getvar($name)
	{
		global $BLOGINUS;
		$name = strtolower($name);
		if (isset($BLOGINUS[$name]))
		{
			return $BLOGINUS[$name];
		}
		else
		{
			return false;
		}
	}

	// config_setvar : set Bloginus config variable
	function config_setvar($name, $value)
	{
		global $BLOGINUS_CONF;
		$name = strtolower($name);
		if (! isset($BLOGINUS_CONF[$name]))
		{
			if (false !== ($res = @file_get_contents(get_data_path()."/config.dta")))
			{
				$BLOGINUS_CONF = unserialize($res);
			}
		}
		$BLOGINUS_CONF[$name] = $value;
		file_put_contents(get_data_path()."/config.dta",serialize($BLOGINUS_CONF));
		return $value;
	}

	// config_getvar : get Bloginus config variable
	function config_getvar($name,$default="")
	{
		global $BLOGINUS_CONF;
		$name = strtolower($name);
		if (! isset($BLOGINUS_CONF[$name]))
		{
			if (false !== ($res = @file_get_contents(get_data_path()."/config.dta")))
			{
				$BLOGINUS_CONF = unserialize($res);
			}
		}
		if (isset($BLOGINUS_CONF[$name]))
		{
			return $BLOGINUS_CONF[$name];
		}
		else
		{
			return $default;
		}
	}
	
	// get_data_path : return "data" absolute pathname (without final "/")
	function get_data_path()
	{
		if (false !== bloginus_getvar("key"))
		{
			return dirname(__FILE__)."/../data-".bloginus_getvar("key");
		}
		else
		{
			return false;
		}
	}

	// site_url : return web site's url (absolute path without domain name)
	function site_url()
	{
		$res = dirname($_SERVER["PHP_SELF"]);
		if ("/" == $res)
		{
			$res = "";
		}
		return $res;
	}

	// **********          **********          **********          **********          **********          **********
	// * core functions only, don't use or modify them
	// **********          **********          **********          **********          **********          **********
	
	// key_load : load content of protected/key.dta or false if it doesn't exists
	function key_load()
	{
		if (false === ($key = @file_get_contents(dirname(__FILE__)."/../protected/key.dta")))
		{
			require_once(dirname(__FILE__)."/../plugin/admin/setup.php");
			exit;
		}
		else
		{
			return $key;
		}
	}

	// key_save : create file protected/key.dta if it doesn't exists and return it's value
	function key_save()
	{
		if (! file_exists(dirname(__FILE__)."/../protected/key.dta"))
		{
			@mkdir(dirname(__FILE__)."/../protected");
			file_put_contents(dirname(__FILE__)."/../protected/key.dta",($key = uniqid()));
			return $key;
		}
		else
		{
			return key_load();
		}
	}
	
	// version_load : load release number
	function version_load()
	{
		if (false === ($version = @file_get_contents(get_data_path()."/version.dta")))
		{
			require_once(dirname(__FILE__)."/../plugin/admin/setup.php");
			exit;
		}
		else
		{
			return $version;
		}
	}

	// version_save : save release number
	function version_save()
	{
		@mkdir(get_data_path());
		file_put_contents(get_data_path()."/version.dta",_BloginusVersion_);
	}

	function creer_dossier($nom_dossier)
	{
		if (! is_dir($nom_dossier)) {
			if ($n = strrpos($nom_dossier, "/")) {
				creer_dossier(substr($nom_dossier, 0, $n));
				mkdir ($nom_dossier, 0777);
				chmod($nom_dossier, 0775);
			}
		}
		return $nom_dossier;
	}
	function en_url($ch) {
		$let1 = array("à","â","ä","é","è","ë","ê","î","ï","ô","ö","ù","ü","û","%","'",",","ç","&","/","\\");
		$let2 = array("a","a","a","e","e","e","e","i","i","o","o","u","u","u","pourcent"," "," ","c","-","-","-");
		$ch = str_replace($let1,$let2,trim(strtolower(stripslashes($ch))));
		$res = "";
		for ($i = 0; $i < strlen ($ch); $i++) {
			$c = substr ($ch, $i, 1);
			if ((($c >= "a") && ($c <= "z")) || (($c >= "0") && ($c <= "9")) || ($c == "-") || ($c == "_") || ($c == ",") || ($c == " ")) {
				$res .= $c;
			}
		}
		return substr(urlencode(substr(str_replace("--", "-", str_replace(" ", "-", trim($res))),0,128)),0,128);
	}
	function fichier_inclure($nom_fichier)
	{
		global $categorie_id, $categorie, $souscategories, $autresarticles, $article_id, $article, $plandusite, $titre_page, $page;

		$theme = config_getvar("theme","_default");
		// $theme = config_getvar("theme","bootstrap-sample");
		if (file_exists(dirname(__FILE__)."/../theme/".$theme."/".$nom_fichier))
		{
			require_once(dirname(__FILE__)."/../theme/".$theme."/".$nom_fichier);
		}
		else if (file_exists(dirname(__FILE__)."/../theme/_default/".$nom_fichier))
		{
			require_once(dirname(__FILE__)."/../theme/_default/".$nom_fichier);
		}
		else if (file_exists(dirname(__FILE__)."/../theme/".$theme."/404.php"))
		{
			require_once(dirname(__FILE__)."/../theme/".$theme."/404.php");
		}
		else if (file_exists(dirname(__FILE__)."/../theme/_default/404.php"))
		{
			require_once(dirname(__FILE__)."/../theme/_default/404.php");
		}
	}
	function page404($log="")
	{
		header('HTTP/1.0 404 Not Found', true, 404);
		fichier_inclure("404.php");
		if ("" != $log)
		{
			print("<!-- ".nl2br($log)." -->");
		}
		exit;
	}

	function base36_vers_entier($base36)
	{
		$base36 = trim(strtolower($base36));
		$entier = 0;
		for ($i = 0; $i < strlen($base36); $i++)
		{
			$c = substr($base36,$i,1);
			if (($c >= "0") && ($c <= "9"))
			{
				$chiffre = ord($c)-ord("0");
			}
			else if (($c >= "a") && ($c <= "z"))
			{
				$chiffre = ord($c)-ord("a")+10;
			}
			else
			{
				$chiffre = 0;
			}
			$entier = $entier * 36 + $chiffre;
		}
		return $entier;
	}

	function entier_vers_base36($entier,$nb_chiffres=0)
	{
		$base36 = "";
		do
		{
			$chiffre = $entier % 36;
			if ($chiffre < 10)
			{
				$c = chr(ord("0")+$chiffre);
			}
			else
			{
				$c = chr(ord("a")+$chiffre-10);
			}
			$base36 = $c.$base36;
			$entier = floor($entier / 36);
		} while ($entier > 0);
		for ($i = strlen($base36); $i < $nb_chiffres; $i++)
		{
			$base36 = "0".$base36;
		}
		return $base36;
	}

	function aaaammjj_to_string ($date)
	{
		return substr ($date, 6, 2)."/".substr ($date, 4, 2)."/".substr ($date, 0, 4);
	}

	function hhmmss_to_string ($heure, $dateheure=true)
	{
		if ($dateheure)
		{
			return substr ($heure, 8, 2).":".substr ($heure, 10, 2).":".substr ($heure, 12, 2);
		}
		else
		{
			return substr ($heure, 0, 2).":".substr ($heure, 2, 2).":".substr ($heure, 4, 2);
		}
	}

	function aaaammjjhhmmss_to_string ($date)
	{
		return substr ($date, 6, 2)."/".substr ($date, 4, 2)."/".substr ($date, 0, 4)." ".substr ($date, 8, 2).":".substr ($date, 10, 2).":".substr ($date, 12, 2);
	}
	
	function liste_parametres($elem,$indice)
	{
		$res = "";
		for ($i = $indice; $i < count($elem); $i++)
		{
			$res .= ((""!=$res)?"/":"").$elem[$i];
		}
		return $res;
	}

	// verifie_email
	//		contrôle la validité d'une adresse email (format et existence du domaine correspondant)
	function verifie_email($email2)
	{
		$email = strtolower($email2);
		if (strlen($email) < 6)
		{
			return $email2." : Email trop court";
		}
		if (strlen($email) > 255)
		{
			return $email2." : Email trop long";
		}
		if (!@ereg("@",$email))
		{
			return $email2." : Le email n'a pas d'arobase (@)";
		}
		if (preg_match_all("/([^a-zA-Z0-9_\@\.\-])/i", $email, $trouve))
		{
			return $email2." :  caractère(s) interdit dans un email (".implode(", ",$trouve[0]).").";
		}
		if (!preg_match("/^([a-zA-Z0-9_]|\\-|\\.)+@(([a-zA-Z0-9_]|\\-)+\\.)+[a-zA-Z]{2,4}\$/i", $email))
		{
			return $email2." : n'est pas un email valide.";
		}
		list($compte,$domaine)=explode("@",$email,2);
		if ((function_exists (checkdnsrr)) && (!checkdnsrr($domaine,"MX")))
		{
			return $email2." : Ce domaine (".$domaine.") n'accepte pas les emails";
		}
		return $email2;
	}
	
	function bloginus_powered_by()
	{
		$res = "Powered by <a href=\"";
		$pseudo = trim(strip_tags(config_getvar("1tpe_pseudo","")));
		if ($pseudo != "")
		{
			$res .= "http://go.".$pseudo.".olfsoft.2.1tpe.net";
		}
		else
		{
			$res .= "http://www.bloginus-lescript.fr/";
		}
		$res .= "\" target=\"_blank\">Bloginus</a>";
		return $res;
	}
?>