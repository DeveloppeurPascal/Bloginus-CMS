<?php
	// Bloginus
	// (c) Patrick Prémartin / Olf Software 07/2014 - 02/2016
	//
	// http://www.bloginus-lescript.fr

	$msgerreur = "";
	$msginfo = "";
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
	if (isset($_POST["rooturl"]))
	{
		config_setvar("rooturl", trim(strip_tags($_POST["rooturl"])));
		$msginfo .= "L'adresse de la page d'accueil du site a été mise à jour.\n";
	}
	if (isset($_POST["seoc"]))
	{
		config_setvar("seo_c", (isset($_POST["seoc"]) && ("O" == $_POST["seoc"])));
		$msginfo .= "Le prérenseignement de l'indexation des catégories a été mise à jour.\n";
	}
	if (isset($_POST["seop"]))
	{
		config_setvar("seo_p", (isset($_POST["seop"]) && ("O" == $_POST["seop"])));
		$msginfo .= "Le prérenseignement de l'indexation des pages a été mise à jour.\n";
	}
	if (isset($_POST["seopage"]))
	{
		config_setvar("seo_page", (isset($_POST["seopage"]) && ("O" == $_POST["seopage"])));
		$msginfo .= "Le prérenseignement de l'indexation des pages a été mise à jour.\n";
	}
	if (isset($_POST["stats"]))
	{
		$stats = trim($_POST["stats"]);
		config_setvar("stats", $stats);
		$msginfo .= "Le code de statistiques du site a été mise à jour.\n";
	}
	if (isset($_POST["ckeditor_cdn"]))
	{
		switch ($_POST["ckeditor_cdn"])
		{
			case "basic":
			case "standard":
			case "full":
				config_setvar("ckeditor_cdn", $_POST["ckeditor_cdn"]);
				break;
			default:
				config_setvar("ckeditor_cdn", "");
		}
		$msginfo .= "La version utilisée de CK Editor a été mise à jour a été mise à jour.\n";
	}
	if (isset($_POST["jquery_cdn"]))
	{
		switch ($_POST["jquery_cdn"])
		{
			case "jquery":
			case "google":
			case "microsoft":
				config_setvar("jquery_cdn", $_POST["jquery_cdn"]);
				break;
			default:
				config_setvar("jquery_cdn", "");
		}
		$msginfo .= "La version utilisée de jQuery a été mise à jour a été mise à jour.\n";
	}
	if (isset($_POST["1tpe_pseudo"]))
	{
		config_setvar("1tpe_pseudo", trim(strip_tags($_POST["1tpe_pseudo"])));
		$msginfo .= "Votre pseudo d'affilié chez 1TPE a été mis à jour.\n";
	}
	if (isset($_POST["saisieabstract"]))
	{
		config_setvar("saisieabstract", (isset($_POST["saisieabstract"]) && ("O" == $_POST["saisieabstract"])));
		$msginfo .= "Le conditionnement du champ de saisie des chapeaux a été mise à jour.\n";
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
		<legend>Informations sur le site</legend>
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
		<p><label for="frmrooturl">Adresse de la page d'accueil (facultatif, par défaut ce sera la rubrique racine du blog)</label><br />
		<input type="text" name="rooturl" id="frmrooturl" value="<?php print(htmlentities(config_getvar("rooturl",""),ENT_COMPAT,"UTF-8")); ?>"></p>
	</fieldset>
	<fieldset>
		<legend>Statistiques et SEO</legend>
		<p><label for="frmseoc">Par défaut, indexer les pages de catégories dans les moteurs de recherche ?</label><br />
		<select name="seoc" id="frmseoc">
			<option value="O"<?php print((config_getvar("seo_c",false))?" selected=\"selected\"":""); ?>>Oui</option>
			<option value="N"<?php print((config_getvar("seo_c",false))?"":" selected=\"selected\""); ?>>Non</option>
		</select></p>
		<p><label for="frmseop">Par défaut, indexer les pages d'articles dans les moteurs de recherche ?</label><br />
		<select name="seop" id="frmseop">
			<option value="O"<?php print((config_getvar("seo_p",true))?" selected=\"selected\"":""); ?>>Oui</option>
			<option value="N"<?php print((config_getvar("seo_p",true))?"":" selected=\"selected\""); ?>>Non</option>
		</select></p>
		<p><label for="frmseopage">Par défaut, indexer les pages indépendantes dans les moteurs de recherche ?</label><br />
		<select name="seopage" id="frmseopage">
			<option value="O"<?php print((config_getvar("seo_page",true))?" selected=\"selected\"":""); ?>>Oui</option>
			<option value="N"<?php print((config_getvar("seo_page",true))?"":" selected=\"selected\""); ?>>Non</option>
		</select></p>
		<p><label for="frmstats">Tag de statistiques</label><br />
		<textarea name="stats" id="frmstats" cols="80" rows="10"><?php print(config_getvar("stats")); ?></textarea></p>
	</fieldset>
	<fieldset>
		<legend>Paramètres de Bloginus</legend>
		<p><label for="frmckeditor">Version de CK Editor à utiliser en administration du blog ?</label><br />
		<select name="ckeditor_cdn" id="frmckeditor">
			<option value=""<?php print(("" == config_getvar("ckeditor_cdn",""))?" selected=\"selected\"":""); ?>>4.x.x full (CDN Olf Software)</option>
			<option value="basic"<?php print(("basic" == config_getvar("ckeditor_cdn",""))?" selected=\"selected\"":""); ?>>4.5.6 basic (CDN CK Editor)</option>
			<option value="standard"<?php print(("standard" == config_getvar("ckeditor_cdn",""))?" selected=\"selected\"":""); ?>>4.5.6 standard (CDN CK Editor)</option>
			<option value="full"<?php print(("full" == config_getvar("ckeditor_cdn",""))?" selected=\"selected\"":""); ?>>4.5.6 full (CDN CK Editor)</option>
		</select></p>
		<p><label for="frmjquery">Version de jQuery à utiliser en administration du blog ?</label><br />
		<select name="jquery_cdn" id="frmjquery">
			<option value=""<?php print(("" == config_getvar("jquery_cdn",""))?" selected=\"selected\"":""); ?>>1.x.x (CDN Olf Software)</option>
			<option value="jquery"<?php print(("jquery" == config_getvar("jquery_cdn",""))?" selected=\"selected\"":""); ?>>1.12.0 (CDN jQuery)</option>
			<option value="google"<?php print(("google" == config_getvar("jquery_cdn",""))?" selected=\"selected\"":""); ?>>1.12.0 (CDN Google)</option>
			<option value="microsoft"<?php print(("microsoft" == config_getvar("jquery_cdn",""))?" selected=\"selected\"":""); ?>>1.12.0 (CDN Microsoft)</option>
		</select></p>
		<p><label for="frm1tpe">Pseudo d'affilié <a href="http://vasur.fr/1tpe" target="_blank">1TPE</a> (utilisé sur le "powered by" en pied de page des thèmes)</label><br />
		<input type="text" name="1tpe_pseudo" id="frm1tpe" value="<?php print(htmlentities(config_getvar("1tpe_pseudo",""),ENT_COMPAT,"UTF-8")); ?>"></p>
		<p><label for="frmabstractonoff">Permettre la saisie d'un chapeau/extrait/abstract au niveau des rubriques, pages, articles et liens ?</label><br />
		<select name="saisieabstract" id="frmabstractonoff">
			<option value="O"<?php print((config_getvar("saisieabstract",true))?" selected=\"selected\"":""); ?>>Oui</option>
			<option value="N"<?php print((config_getvar("saisieabstract",true))?"":" selected=\"selected\""); ?>>Non</option>
		</select></p>
	</fieldset>
	<p><input type="submit" value="Enregistrer"></p>
</form><ul>
	<li><a href="<?php print(site_url()); ?>/admin/">Retour au menu principal</a></li>
</ul>