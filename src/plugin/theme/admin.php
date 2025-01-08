<?php
	// Bloginus
	// (c) Patrick Prémartin / Olf Software 07/2014
	//
	// http://www.bloginus-lescript.fr

	$msgerreur = "";
	$msginfo = "";
	$theme = "";
	if (isset($_POST["theme"]))
	{
		$theme = trim($_POST["theme"]);
		if (($theme != "") && (is_dir(dirname(__FILE__)."/../../theme/".$theme)))
		{
			config_setvar("theme", $theme);
			$msginfo .= "Le nouveau thème est pris en compte dès maintenant.\n";
		}
		else
		{
			$msgerreur .= "Ce thème n'existe pas, le thème actuel n'a pas été modifié.\n";
		}
	}

?><h2>Gestion des thèmes</h2><?php
	if ("" != $msgerreur)
	{
		print("<p class=\"msgerreur\">".nl2br($msgerreur)."</p>");
	}
	if ("" != $msginfo)
	{
		print("<p class=\"msginfo\">".nl2br($msginfo)."</p>");
	}
	
	$theme_liste = array();
	$path=dirname(__FILE__)."/../../theme/";
	if ($dossier = opendir($path))
	{
		while (false !== ($fichier = readdir($dossier)))
		{
			if (("." != substr($fichier,0,1)) && (is_dir($path.$fichier)))
			{
				$theme_liste[] = $fichier;
			}
		}
	}
	sort($theme_liste);

?><form method="POST" action="<?php print(site_url()); ?>/admin/theme/">
	<fieldset>
		<legend>Choisir le thème du site</legend>
		<p><label for="frmtheme">Thèmes disponibles</label><br />
<?php
	reset($theme_liste);
	$i = 0;
	while(list($key,$themepropose) = each($theme_liste))
	{
		$i++;
		print("<input type=\"radio\" id=\"theme".$i."\" name=\"theme\" value=\"".htmlentities($themepropose,ENT_COMPAT,"UTF-8")."\"".((config_getvar("theme","_default") == $themepropose)?" checked=\"checked\"":"")."> <label for=\"theme".$i."\">".$themepropose."</label><br />");
	}
?>
		<p><input type="submit" value="Enregistrer"></p>
	</fieldset>
</form><ul>
	<li><a href="<?php print(site_url()); ?>/admin/">Retour au menu principal</a></li>
</ul>