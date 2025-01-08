<?php
	// Bloginus
	// (c) Patrick Prémartin / Olf Software 08/2014 - 02/2016
	//
	// http://www.bloginus-lescript.fr

	$msgerreur = "";
	$msginfo = "";
	
	// traitement des paramètres
	if (isset($_POST["id"]))
	{
		$page_id = trim($_POST["id"]);
	}
	else if (isset($_GET["id"]))
	{
		$page_id = trim($_GET["id"]);
	}
	else
	{
		$page_id = "0";
	}
	if (isset($_POST["op"]))
	{
		$op = trim($_POST["op"]);
	}
	else
	{
		$op = "";
	}
	
	// traitement des actions
	if ("update" == $op)
	{ // ajout ou mise à jour du contenu de la page
		$page = page_get_infos($page_id);
		if (false == $page)
		{
			$page = array();
		}
		$page["id"] = $page_id;
		$page["label"] = (isset($_POST["label"]))?trim($_POST["label"]):"";
		$page["text"] = (isset($_POST["text"]))?trim($_POST["text"]):"";
		if (config_getvar("saisieabstract",true))
		{
			$page["abstract"] = (isset($_POST["abstract"]))?trim($_POST["abstract"]):"";
		}
		$page["url"] = (isset($_POST["url"]))?trim($_POST["url"]):"";
		$page["published"] = (isset($_POST["published"]) && ("O" == $_POST["published"]));
		$page["seo"] = (isset($_POST["seo"]))?(("O" == $_POST["seo"])?true:(("N" == $_POST["seo"])?false:"")):"";
		$page["timestamp"] = time();
		if (false !== page_set_infos($page_id,$page))
		{
			$msginfo .= "Votre modification a bien été enregistrée au niveau de la page.\n";
			if (false !== ($liste = page_get_liste()))
			{
				$ok = false;
				reset($liste);
				while ((list($key,$value) = each($liste)) && (! $ok))
				{
					if ($value["id"] == $page_id)
					{
						$liste[$key]["published"]=$page["published"];
						$liste[$key]["timestamp"]=$page["timestamp"];
						$ok = true;
					}
				}
				if (! $ok)
				{
					$liste[] = array("id"=>$page_id, "published"=>$page["published"], "timestamp"=>$page["timestamp"]);
				}
			}
			else
			{
				$liste = array();
				$liste[] = array("id"=>$page_id, "published"=>$page["published"], "timestamp"=>$page["timestamp"]);
			}
			if (false !== page_set_liste($liste))
			{
				$msginfo .= "La liste des pages a bien été mise à jour.\n";
			}
			else
			{
				$msgerreur .= "Une erreur est survenue lors de l'enregistrement de votre saisie. Une désynchronisation est possible au niveau de la liste des pages.\n";
			}
			if (isset($_POST["rootpage"]) && ("X" == $_POST["rootpage"]))
			{
				config_setvar("rooturl", page_url($page_id));
			}
			else if (isset($_POST["rootpageprevious"]) && ("X" == $_POST["rootpageprevious"]))
			{
				config_setvar("rooturl", "");
			}
		}
		else
		{
			$msgerreur .= "Une erreur est survenue lors de l'enregistrement de votre saisie. Vos modifications n'ont pas été enregistrées.\n";
		}
	}
	else if ("pageadd" == $op)
	{ // ajout d'une page
		if (false !== ($liste = page_get_liste()))
		{
			$id_max = 0;
			reset($liste);
			// var_dump($liste);
			while (list($key,$value) = each($liste))
			{
				$id = base36_vers_entier($value["id"]);
				// print("<p>id=".$id."</p>");
				if ($id >= $id_max)
					$id_max = $id+1;
			}
			// print("<p>id_max=".$id_max."</p>");
			$page_id = entier_vers_base36($id_max);
			// print("<p>page_id=".$page_id."</p>");
			$msginfo .= "Votre nouvelle page a été créée.\n";
		}
		else
		{
			$page_id = "0";
			$msginfo .= "Votre nouvelle page a été créée.\n";
		}
	}

?><h2>Gestion des pages</h2><?php
	// affichage des messages d'info et d'erreur
	if ("" != $msgerreur)
	{
		print("<p class=\"msgerreur\">".nl2br($msgerreur)."</p>");
	}
	if ("" != $msginfo)
	{
		print("<p class=\"msginfo\">".nl2br($msginfo)."</p>");
	}

	// affichage du formulaire de modification de la page en cours
	if (false === ($page = page_get_infos($page_id)))
	{
		$page = array();
		$page["id"] = $page_id;
		$page["label"] = "";
		$page["text"] = "";
		$page["abstract"] = "";
		$page["url"] = "";
		$page["published"] = false;
		$page["seo"] = "";
		$page["timestamp"] = 0;
	}
	if (! isset($page["abstract"]))
	{
		$page["abstract"] = "";
	}
?><form id="frm" method="POST" action="<?php print(site_url()); ?>/admin/page/">
	<input type="hidden" name="op" id="frmop" value="update">
	<input type="hidden" name="id" id="frmid" value="<?php print(htmlentities($page["id"],ENT_COMPAT,"UTF-8")); ?>">
	<fieldset>
		<legend>Infos pour cette page</legend>
		<p><label for="frmlabel">Titre</label><br />
		<input type="text" name="label" id="frmlabel" value="<?php print(htmlentities($page["label"],ENT_COMPAT,"UTF-8")); ?>"></p>
		<p><label for="frmtext">Texte</label><br />
		<textarea name="text" id="frmtext"><?php print(htmlentities($page["text"],ENT_COMPAT,"UTF-8")); ?></textarea></p><?php
	if (config_getvar("saisieabstract",true))
	{
?><p><label for="frmabstract">Extrait / chapeau</label><br />
<textarea name="abstract" id="frmabstract"><?php print(htmlentities($page["abstract"],ENT_COMPAT,"UTF-8")); ?></textarea></p><?php
	}
?><p><label for="frmurl">Nom de la page web</label><br />
		<input type="text" name="url" id="frmurl" value="<?php print(htmlentities($page["url"],ENT_COMPAT,"UTF-8")); ?>"></p>
		<p><label for="frmpublished">Publiée ?</label><br />
		<select name="published" id="frmpublished">
			<option value="O"<?php print(($page["published"])?" selected=\"selected\"":""); ?>>Oui</option>
			<option value="N"<?php print(($page["published"])?"":" selected=\"selected\""); ?>>Non</option>
		</select></p>
		<p><label for="frmpseo">Page à indexer par les moteurs de recherche ?</label><br />
		<select name="seo" id="frmseo">
			<option value=""<?php print(("" === $page["seo"])?" selected=\"selected\"":""); ?>>Par défaut</option>
			<option value="O"<?php print((true === $page["seo"])?" selected=\"selected\"":""); ?>>Oui</option>
			<option value="N"<?php print((false === $page["seo"])?" selected=\"selected\"":""); ?>>Non</option>
		</select></p>
		<p>Date de dernière modification : <?php print(aaaammjjhhmmss_to_string(date("YmdHis",intval($page["timestamp"])))); ?></p>
		<p>URL de cette page : <a href="<?php print(page_url($page_id)); ?>" target="_blank"><?php print(page_url($page_id)); ?></a></p>
		<p><input type="checkbox" value="X" name="rootpage" id="frmrootpage" <?php print((("" != config_getvar("rooturl")) && (config_getvar("rooturl")==page_url($page_id)))?"checked=\"checked\" ":""); ?>/><input type="hidden" name="rootpageprevious" value="<?php print((config_getvar("rooturl")==page_url($page_id))?"X":""); ?>" /> <label for="frmrootpage">utiliser en page d'accueil du site</label></p>
		<p><input type="submit" value="Enregistrer"></p>
	</fieldset>
</form><script type="text/javascript">
	$(document).ready(function () {
		$('textarea').ckeditor();
	});
</script>
<?php
	// affichage de la liste des pages
	$autrespages = "<a href=\"#\" onclick=\"$('#frmop').val('pageadd');$('#frm').submit();return true;\">Ajouter une page</a><br />";
	$page_liste = page_get_liste();
	if (is_array($page_liste))
	{
		reset($page_liste);
		while (list($key,$value)=each($page_liste))
		{
			$pag = page_get_infos($value["id"]);
			$autrespages .= "<a href=\"".site_url()."/admin/page/?id=".$pag["id"]."\"><!-- ".$pag["id"]." -->".aaaammjjhhmmss_to_string(date("YmdHis",intval($pag["timestamp"])))." - ".$pag["label"]."</a><br />";
		}
	}
?><div id="autrespages"><p>Autres pages du site:<br /><?php print($autrespages); ?></p></div>
<ul>
	<li><a href="<?php print(site_url()); ?>/admin/">Retour au menu principal</a></li>
</ul>