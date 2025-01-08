<?php
	// Bloginus
	// (c) Patrick Prémartin / Olf Software 07/2014
	//
	// http://www.bloginus-lescript.fr

	$msgerreur = "";
	$msginfo = "";
	$titre = "";
	if (isset($_POST["titre"]))
	{
		$titre = trim($_POST["titre"]);
		if ($titre != "")
		{
			config_setvar("titre", $titre);
			$msginfo .= "Le titre du site a été mis à jour.\n";
		}
		else
		{
			$msgerreur .= "Veuillez renseigner le titre du site.\n";
		}
	}
	$auteur = "";
	if (isset($_POST["auteur"]))
	{
		$auteur = trim($_POST["auteur"]);
		if ($auteur != "")
		{
			config_setvar("auteur", $auteur);
			$msginfo .= "L'auteur du site a été mis à jour.\n";
		}
		else
		{
			$msgerreur .= "Veuillez indiquer qui est l'auteur du site (pour le copyright dans le source de ses pages).\n";
		}
	}
	$langue = "";
	if (isset($_POST["langue"]))
	{
		$langue = trim($_POST["langue"]);
		if ($langue != "")
		{
			config_setvar("langue", $langue);
			$msginfo .= "La langue du site a été mise à jour.\n";
		}
		else
		{
			$msgerreur .= "Veuillez indiquer la langue du site (fr, en, it, es, ...) du site.\n";
		}
	}
	$url = "";
	if (isset($_POST["url"]))
	{
		$url = trim($_POST["url"]);
		if ($url != "")
		{
			config_setvar("url", $url);
			$msginfo .= "L'adresse du site a été mise à jour.\n";
		}
		else
		{
			$msgerreur .= "Veuillez renseigner l'adresse du site.\n";
		}
	}
	$annee = "";
	if (isset($_POST["annee"]))
	{
		$annee = trim($_POST["annee"]);
		if ($annee != "")
		{
			config_setvar("annee", $annee);
			$msginfo .= "L'année de lancement du site a été mise à jour.\n";
		}
		else
		{
			$msgerreur .= "Veuillez renseigner l'année de lancement du site.\n";
		}
	}
	$stats = "";
	if (isset($_POST["stats"]))
	{
		$stats = trim($_POST["stats"]);
		config_setvar("stats", $stats);
		$msginfo .= "Le code de statistiques du site a été mise à jour.\n";
	}
	$seoc = false;
	if (isset($_POST["seoc"]))
	{
		$seoc = (isset($_POST["seoc"]) && ("O" == $_POST["seoc"]));
		config_setvar("seo_c", $seoc);
		$msginfo .= "Le prérenseignement de l'indexation des catégories a été mise à jour.\n";
	}
	$seop = true;
	if (isset($_POST["seop"]))
	{
		$seop = (isset($_POST["seop"]) && ("O" == $_POST["seop"]));
		config_setvar("seo_p", $seop);
		$msginfo .= "Le prérenseignement de l'indexation des pages a été mise à jour.\n";
	}

?><h2>Configuration du site</h2><?php
	if ("" != $msgerreur)
	{
		print("<p class=\"msgerreur\">".nl2br($msgerreur)."</p>");
	}
	if ("" != $msginfo)
	{
		print("<p class=\"msginfo\">".nl2br($msginfo)."</p>");
	}
	
?><form method="POST" action="<?php print(site_url()); ?>/admin/config/">
	<fieldset>
		<legend>Paramètres du site</legend>
		<p><label for="frmtitre">Titre</label><br />
		<input type="text" name="titre" id="frmtitre" value="<?php print(htmlentities(config_getvar("titre"),ENT_COMPAT,"UTF-8")); ?>"></p>
		<p><label for="frmauteur">Auteur</label><br />
		<input type="text" name="auteur" id="frmauteur" value="<?php print(htmlentities(config_getvar("auteur"),ENT_COMPAT,"UTF-8")); ?>"></p>
		<p><label for="frmlangue">Langue du site</label><br />
		<input type="text" name="langue" id="frmlangue" value="<?php print(htmlentities(config_getvar("langue","fr"),ENT_COMPAT,"UTF-8")); ?>"></p>
		<p><label for="frmurl">Adresse</label><br />
		<input type="text" name="url" id="frmurl" value="<?php print(htmlentities(config_getvar("url","http://".$_SERVER["HTTP_HOST"].site_url()),ENT_COMPAT,"UTF-8")); ?>"></p>
		<p><label for="frmannee">Année de lancement du site</label><br />
		<input type="text" name="annee" id="frmannee" value="<?php print(htmlentities(config_getvar("annee",date("Y")),ENT_COMPAT,"UTF-8")); ?>"></p>
		<p><label for="frmstats">Tag de statistiques</label><br />
		<textarea name="stats" id="frmstats" cols="80" rows="10"><?php print(config_getvar("stats")); ?></textarea></p>
		<p><label for="frmseoc">Par défaut, indexer les pages de catégories dans les moteurs de recherche ?</label><br />
		<select name="seoc" id="frmseoc">
			<option value="O"<?php print((config_getvar("seo_c",false))?" selected=\"selected\"":""); ?>>Oui</option>
			<option value="N"<?php print((config_getvar("seo_c",false))?"":" selected=\"selected\""); ?>>Non</option>
		</select></p>
		<p><label for="frmseop">Par défaut, indexer les pages dans les moteurs de recherche ?</label><br />
		<select name="seop" id="frmseop">
			<option value="O"<?php print((config_getvar("seo_p",true))?" selected=\"selected\"":""); ?>>Oui</option>
			<option value="N"<?php print((config_getvar("seo_p",true))?"":" selected=\"selected\""); ?>>Non</option>
		</select></p>
		<p><input type="submit" value="Enregistrer"></p>
	</fieldset>
</form><ul>
	<li><a href="<?php print(site_url()); ?>/admin/">Retour au menu principal</a></li>
</ul>