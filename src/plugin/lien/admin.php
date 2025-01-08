<?php
	// Bloginus
	// (c) Patrick Prémartin / Olf Software 09/2014 - 02/2016
	//
	// http://www.bloginus-lescript.fr

	$msgerreur = "";
	$msginfo = "";
	
	// traitement des paramètres
	if (isset($_POST["categorie_id"]))
	{
		$categorie_id = trim($_POST["categorie_id"]);
	}
	else if (isset($_GET["categorie_id"]))
	{
		$categorie_id = trim($_GET["categorie_id"]);
	}
	else
	{
		$categorie_id = "_";
	}
	if (isset($_POST["id"]))
	{
		$lien_id = trim($_POST["id"]);
	}
	else if (isset($_GET["id"]))
	{
		$lien_id = trim($_GET["id"]);
	}
	else
	{
		$lien_id = link_id_create(0,$categorie_id);
	}
	if ($categorie_id != link_get_category_id($lien_id))
	{
		$categorie_id = link_get_category_id($lien_id);
		$msgerreur .= "Incohérence dans le classement du lien dans sa catégorie. Catégorie forcée à celle du lien.\n";
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
	{ // ajout ou mise à jour du contenu du lien
		$lien = link_get_infos($lien_id);
		if (false == $lien)
		{
			$lien = array();
		}
		$lien["id"] = $lien_id;
		$lien["label"] = (isset($_POST["label"]))?trim($_POST["label"]):"";
		$lien["text"] = (isset($_POST["text"]))?trim($_POST["text"]):"";
		if (config_getvar("saisieabstract",true))
		{
			$lien["abstract"] = (isset($_POST["abstract"]))?trim($_POST["abstract"]):"";
		}
		$lien["url"] = (isset($_POST["url"]))?trim($_POST["url"]):"";
		$lien["published"] = (isset($_POST["published"]) && ("O" == $_POST["published"]));
		$lien["timestamp"] = time();
		if (false !== link_set_infos($lien_id,$lien))
		{
			$msginfo .= "Votre modification a bien été enregistrée au niveau du lien.\n";
			if (false !== ($liste = link_get_liste($categorie_id)))
			{
				$ok = false;
				foreach ($liste as $key=>$value)
				{
					if ($value["id"] == $lien_id)
					{
						$liste[$key]["published"]=$lien["published"];
						$liste[$key]["timestamp"]=$lien["timestamp"];
						$ok = true;
						break;
					}
				}
				if (! $ok)
				{
					$liste[] = array("id"=>$lien_id, "published"=>$lien["published"], "timestamp"=>$lien["timestamp"]);
				}
			}
			else
			{
				$liste = array();
				$liste[] = array("id"=>$lien_id, "published"=>$lien["published"], "timestamp"=>$lien["timestamp"]);
			}
			if (false !== link_set_liste($categorie_id,$liste))
			{
				$msginfo .= "La liste des liens de cette catégorie a bien été mise à jour.\n";
			}
			else
			{
				$msgerreur .= "Une erreur est survenue lors de l'enregistrement de votre saisie. Une désynchronisation est possible au niveau de la liste des liens sur la catégorie.\n";
			}
		}
		else
		{
			$msgerreur .= "Une erreur est survenue lors de l'enregistrement de votre saisie. Vos modifications n'ont pas été enregistrées.\n";
		}
	}
	else if ("linkadd" == $op)
	{ // ajout d'un lien à la rubrique actuelle
		if (false !== ($cat = category_get_infos($categorie_id)))
		{
			if (false !== ($liste = link_get_liste($categorie_id)))
			{
				$i = 0;
				$ok = false;
				while ((! $ok) && (3 <= strlen($id = link_id_create($i++,$categorie_id))-strlen($categorie_id)))
				{
					$trouve = false;
					foreach ($liste as $key=>$value)
					{
						$trouve = ($id == $value["id"]);
						if ($trouve) break;
					}
					$ok = (! $trouve);
				}
				if ($ok)
				{
					$lien_id = $id;
					$msginfo .= "Votre nouvel lien a été créé.\n";
				}
				else
				{
					$msgerreur .= "Ajout d'un lien impossible : vous avez déjà le nombre maximal de liens dans cette rubrique.\n";
				}
			}
			else
			{
				$lien_id = link_id_create(0,$categorie_id);
				$msginfo .= "Votre nouvel lien a été créé.\n";
			}
		}
		else
		{
			$msgerreur .= "Ajout de lien impossible : la catégorie (".$categorie_id.") n'existe pas.\n";
		}
	}

?><h2>Gestion des liens</h2><?php	
	// affichage du fil d'ariane
	$ariane = "";
	$id = $categorie_id;
	while (strlen($id) > 0)
	{
		$cat = category_get_infos($id);
		$ariane = "<a href=\"".site_url()."/admin/lien/?categorie_id=".$id."\">".(("" != trim($cat["label"]))?trim($cat["label"]):"*****")."</a>".((""!=$ariane)?" / ":"").$ariane;
		$id = substr($id,0,strlen($id)-1);
	}
?><div id="fildariane"><?php print($ariane); ?></div><?php

	// affichage des messages d'info et d'erreur
	if ("" != $msgerreur)
	{
		print("<p class=\"msgerreur\">".nl2br($msgerreur)."</p>");
	}
	if ("" != $msginfo)
	{
		print("<p class=\"msginfo\">".nl2br($msginfo)."</p>");
	}

	// affichage du formulaire de modification de la rubrique en cours
	if (false === ($lien = link_get_infos($lien_id)))
	{
		$lien = array();
		$lien["id"] = $lien_id;
		$lien["label"] = "";
		$lien["text"] = "";
		$lien["abstract"] = "";
		$lien["url"] = "";
		$lien["published"] = false;
		$lien["timestamp"] = 0;
	}
	if (! isset($lien["abstract"]))
	{
		$lien["abstract"] = "";
	}
?><form id="frm" method="POST" action="<?php print(site_url()); ?>/admin/lien/">
	<input type="hidden" name="op" id="frmop" value="update">
	<input type="hidden" name="id" id="frmid" value="<?php print(htmlentities($lien["id"],ENT_COMPAT,"UTF-8")); ?>">
	<input type="hidden" name="categorie_id" id="frmcategorieid" value="<?php print(htmlentities($categorie_id,ENT_COMPAT,"UTF-8")); ?>">
	<fieldset>
		<legend>Infos pour cet lien</legend>
		<p><label for="frmlabel">Titre</label><br />
		<input type="text" name="label" id="frmlabel" value="<?php print(htmlentities($lien["label"],ENT_COMPAT,"UTF-8")); ?>"></p>
		<p><label for="frmtext">Texte</label><br />
		<textarea name="text" id="frmtext"><?php print(htmlentities($lien["text"],ENT_COMPAT,"UTF-8")); ?></textarea></p><?php
	if (config_getvar("saisieabstract",true))
	{
?><p><label for="frmabstract">Extrait / chapeau</label><br />
<textarea name="abstract" id="frmabstract"><?php print(htmlentities($lien["abstract"],ENT_COMPAT,"UTF-8")); ?></textarea></p><?php
	}
?><p><label for="frmurl">URL</label><br />
		<input type="text" name="url" id="frmurl" value="<?php print(htmlentities($lien["url"],ENT_COMPAT,"UTF-8")); ?>"></p>
		<p><label for="frmpublished">Publié ?</label><br />
		<select name="published" id="frmpublished">
			<option value="O"<?php print(($lien["published"])?" selected=\"selected\"":""); ?>>Oui</option>
			<option value="N"<?php print(($lien["published"])?"":" selected=\"selected\""); ?>>Non</option>
		</select></p>
		<p>Date de dernière modification : <?php print(aaaammjjhhmmss_to_string(date("YmdHis",intval($lien["timestamp"])))); ?></p>
		<p><input type="submit" value="Enregistrer"></p>
	</fieldset>
</form><script type="text/javascript">
	$(document).ready(function () {
		$('textarea').ckeditor();
	});
</script>
<?php

	// affichage de la liste des sous-rubriques
	$sousrubriques = "";
	$categorie_liste = category_get_liste($categorie_id);
	if (is_array($categorie_liste))
	{
		foreach ($categorie_liste as $key=>$value)
		{
			$cat = category_get_infos($value["id"]);
			$sousrubriques .= "<a href=\"".site_url()."/admin/lien/?categorie_id=".$value["id"]."\"><!-- ".$cat["id"]." -->".$cat["label"]."</a><br />";
		}
	}
?><div id="sousrubriques"><p>Sous rubriques de la rubrique en cours:<br /><?php print($sousrubriques); ?></p></div><?php

	// affichage de la liste des liens de la même catégorie
	$autresliens = "<a href=\"#\" onclick=\"$('#frmop').val('linkadd');$('#frm').submit();return true;\">Ajouter un lien</a><br />";
	$lien_liste = link_get_liste($categorie_id);
	if (is_array($lien_liste))
	{
		foreach ($lien_liste as $key=>$value)
		{
			$art = link_get_infos($value["id"]);
			$autresliens .= "<a href=\"".site_url()."/admin/lien/?categorie_id=".$categorie_id."&id=".$value["id"]."\"><!-- ".$art["id"]." -->".aaaammjjhhmmss_to_string(date("YmdHis",intval($art["timestamp"])))." - ".$art["label"]."</a><br />";
		}
	}
?><div id="autresliens"><p>Autres liens de la rubrique en cours:<br /><?php print($autresliens); ?></p></div>
<ul>
	<li><a href="<?php print(site_url()); ?>/admin/">Retour au menu principal</a></li>
</ul>