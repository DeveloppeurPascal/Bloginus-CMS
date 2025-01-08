<?php
	// Bloginus
	// (c) Patrick Prémartin / Olf Software 06-08/2014
	//
	// http://www.bloginus-lescript.fr

	$msgerreur = "";
	$msginfo = "";
	
	// traitement des paramètres
	if (isset($_POST["id"]))
	{
		$categorie_id = trim($_POST["id"]);
	}
	else if (isset($_GET["id"]))
	{
		$categorie_id = trim($_GET["id"]);
	}
	else
	{
		$categorie_id = "_";
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
	{ // ajout ou mise à jour du contenu de la rubrique
		$categorie = array();
		$categorie["id"] = $categorie_id;
		$categorie["label"] = (isset($_POST["label"]))?trim($_POST["label"]):"";
		$categorie["text"] = (isset($_POST["text"]))?trim($_POST["text"]):"";
		$categorie["url"] = (isset($_POST["url"]))?trim($_POST["url"]):"";
		$categorie["published"] = (isset($_POST["published"]) && ("O" == $_POST["published"]));
		$categorie["seo"] = (isset($_POST["seo"]))?(("O" == $_POST["seo"])?true:(("N" == $_POST["seo"])?false:"")):"";
		$categorie["timestamp"] = time();
		if (false !== category_set_infos($categorie_id,$categorie))
		{
			$msginfo .= "Votre modification a bien été enregistrée au niveau de la page.\n";
			if (strlen($categorie_id) > 1)
			{
				$mere_id = substr($categorie_id,0,strlen($categorie_id)-1);
				if (false !== ($liste = category_get_liste($mere_id)))
				{
					$ok = false;
					reset($liste);
					while ((list($key,$value) = each($liste)) && (! $ok))
					{
						if ($value["id"] == $categorie_id)
						{
							$liste[$key]["published"]=$categorie["published"];
							$liste[$key]["timestamp"]=$categorie["timestamp"];
							$ok = true;
						}
					}
					if (! $ok)
					{
						$liste[] = array("id"=>$categorie_id, "published"=>$categorie["published"], "timestamp"=>$categorie["timestamp"]);
					}
				}
				else
				{
					$liste = array();
					$liste[] = array("id"=>$categorie_id, "published"=>$categorie["published"], "timestamp"=>$categorie["timestamp"]);
				}
				if (false !== category_set_liste($mere_id,$liste))
				{
					$msginfo .= "Votre modification a bien été enregistrée au niveau de la catégorie mère.\n";
				}
				else
				{
					$msgerreur .= "Une erreur est survenue lors de l'enregistrement de votre saisie. Une désynchronisation est possible au niveau de la catégorie mère.\n";
				}
			}
		}
		else
		{
			$msgerreur .= "Une erreur est survenue lors de l'enregistrement de votre saisie. Vos modifications n'ont pas été enregistrées.\n";
		}
	}
	else if ("catadd" == $op)
	{ // ajout d'une sous-rubrique à la rubrique actuelle
		if (false !== ($cat = category_get_infos($categorie_id)))
		{
			if (false !== ($liste = category_get_liste($categorie_id)))
			{
				$id_dispo = array("_","0","1","2","3","4","5","6","7","8","9","a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z");
				reset($liste);
				while (list($key,$value) = each($liste))
				{
					reset($id_dispo);
					while(list($key2,$value2)=each($id_dispo))
					{
						if ($categorie_id.$value2 == $value["id"])
						{
							unset($id_dispo[$key2]);
						}
					}
				}
				if (count($id_dispo) > 0)
				{
					sort($id_dispo);
					$categorie_id .= $id_dispo[0];
					$msginfo .= "Votre nouvelle catégorie a été créée.\n";
				}
				else
				{
					$msgerreur .= "Ajout de catégorie impossible : vous avez déjà le nombre maximal de sous-catégories dans cette catégorie.\n";
				}
			}
			else
			{
				$categorie_id .= "_";
				$msginfo .= "Votre nouvelle catégorie a été créée.\n";
			}
		}
		else
		{
			$msgerreur .= "Ajout de catégorie impossible : la catégorie mère (".$categorie_id.") n'existe pas.\n";
		}
	}

?><h2>Gestion de l'arborescence du site</h2><?php
	// affichage du fil d'ariane
	$ariane = "";
	$id = $categorie_id;
	while (strlen($id) > 0)
	{
		$cat = category_get_infos($id);
		$ariane = "<a href=\"".site_url()."/admin/c/?id=".$id."\">".(("" != trim($cat["label"]))?trim($cat["label"]):"*****")."</a>".((""!=$ariane)?" / ":"").$ariane;
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
	if (false === ($categorie = category_get_infos($categorie_id)))
	{
		$categorie = array();
		$categorie["id"] = $categorie_id;
		$categorie["label"] = "";
		$categorie["text"] = "";
		$categorie["url"] = "";
		$categorie["published"] = false;
		$categorie["seo"] = "";
		$categorie["timestamp"] = 0;
	}
	if (! isset($categorie["seo"]))
	{
		$categorie["seo"] = "";
	}
	if (! isset($categorie["timestamp"]))
	{
		$categorie["timestamp"] = 0;
	}
?><form id="frm" method="POST" action="<?php print(site_url()); ?>/admin/c/">
	<input type="hidden" name="op" id="frmop" value="update">
	<input type="hidden" name="id" id="frmid" value="<?php print(htmlentities($categorie["id"],ENT_COMPAT,"UTF-8")); ?>">
	<fieldset>
		<legend>Infos pour cette catégorie</legend>
		<p><label for="frmlabel">Titre</label><br />
		<input type="text" name="label" id="frmlabel" value="<?php print(htmlentities($categorie["label"],ENT_COMPAT,"UTF-8")); ?>"></p>
		<p><label for="frmtext">Texte</label><br />
		<textarea name="text" id="frmtext"><?php print(htmlentities($categorie["text"],ENT_COMPAT,"UTF-8")); ?></textarea></p>
		<p><label for="frmurl">Nom de la page web</label><br />
		<input type="text" name="url" id="frmurl" value="<?php print(htmlentities($categorie["url"],ENT_COMPAT,"UTF-8")); ?>"></p>
		<p><label for="frmpublished">Publiée ?</label><br />
		<select name="published" id="frmpublished">
			<option value="O"<?php print(($categorie["published"])?" selected=\"selected\"":""); ?>>Oui</option>
			<option value="N"<?php print(($categorie["published"])?"":" selected=\"selected\""); ?>>Non</option>
		</select></p>
		<p><label for="frmseo">Page à indexer par les moteurs de recherche ?</label><br />
		<select name="seo" id="frmseo">
			<option value=""<?php print(("" === $categorie["seo"])?" selected=\"selected\"":""); ?>>Par défaut</option>
			<option value="O"<?php print((true === $categorie["seo"])?" selected=\"selected\"":""); ?>>Oui</option>
			<option value="N"<?php print((false === $categorie["seo"])?" selected=\"selected\"":""); ?>>Non</option>
		</select></p>
		<p>Date de dernière modification : <?php print(aaaammjjhhmmss_to_string(date("YmdHis",intval($categorie["timestamp"])))); ?></p>
		<p>URL de sa page : <a href="<?php print(category_url($categorie_id)); ?>" target="_blank"><?php print(category_url($categorie_id)); ?></a></p>
		<p><input type="submit" value="Enregistrer"></p>
	</fieldset>
</form><script type="text/javascript">
	$(document).ready(function () {
		$('textarea').ckeditor();
	});
</script>
<?php

	// affichage de la liste des sous-rubriques
	$sousrubriques = "<a href=\"#\" onclick=\"$('#frmop').val('catadd');$('#frm').submit();return true;\">Ajouter une sous-catégorie</a><br />";
	$categorie_liste = category_get_liste($categorie_id);
	if (is_array($categorie_liste))
	{
		reset($categorie_liste);
		while (list($key,$value)=each($categorie_liste))
		{
			$cat = category_get_infos($value["id"]);
			$sousrubriques .= "<a href=\"".site_url()."/admin/c/?id=".$value["id"]."\">".$cat["id"]." - ".$cat["label"]."</a><br />";
		}
	}
?><div id="sousrubriques"><p>Sous rubriques de la rubriques en cours:<br /><?php print($sousrubriques); ?></p></div>
<ul>
	<li><a href="<?php print(site_url()); ?>/admin/">Retour au menu principal</a></li>
</ul>