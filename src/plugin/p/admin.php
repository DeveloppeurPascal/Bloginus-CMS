<?php
	// Bloginus
	// (c) Patrick Prémartin / Olf Software 06-08/2014
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
		$article_id = trim($_POST["id"]);
	}
	else if (isset($_GET["id"]))
	{
		$article_id = trim($_GET["id"]);
	}
	else
	{
		$article_id = post_id_create(0,$categorie_id);
	}
	if ($categorie_id != post_get_category_id($article_id))
	{
		$categorie_id = post_get_category_id($article_id);
		$msgerreur .= "Incohérence dans le classement de l'article dans sa catégorie. Catégorie forcée à celle de l'article.\n";
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
	{ // ajout ou mise à jour du contenu de l'article
		$article = array();
		$article["id"] = $article_id;
		$article["label"] = (isset($_POST["label"]))?trim($_POST["label"]):"";
		$article["text"] = (isset($_POST["text"]))?trim($_POST["text"]):"";
		$article["url"] = (isset($_POST["url"]))?trim($_POST["url"]):"";
		$article["published"] = (isset($_POST["published"]) && ("O" == $_POST["published"]));
		$article["seo"] = (isset($_POST["seo"]))?(("O" == $_POST["seo"])?true:(("N" == $_POST["seo"])?false:"")):"";
		$article["timestamp"] = time();
		if (false !== post_set_infos($article_id,$article))
		{
			$msginfo .= "Votre modification a bien été enregistrée au niveau de l'article.\n";
			if (false !== ($liste = post_get_liste($categorie_id)))
			{
				$ok = false;
				reset($liste);
				while ((list($key,$value) = each($liste)) && (! $ok))
				{
					if ($value["id"] == $article_id)
					{
						$liste[$key]["published"]=$article["published"];
						$liste[$key]["timestamp"]=$article["timestamp"];
						$ok = true;
					}
				}
				if (! $ok)
				{
					$liste[] = array("id"=>$article_id, "published"=>$article["published"], "timestamp"=>$article["timestamp"]);
				}
			}
			else
			{
				$liste = array();
				$liste[] = array("id"=>$article_id, "published"=>$article["published"], "timestamp"=>$article["timestamp"]);
			}
			if (false !== post_set_liste($categorie_id,$liste))
			{
				$msginfo .= "La liste des articles de cette catégorie a bien été mise à jour.\n";
			}
			else
			{
				$msgerreur .= "Une erreur est survenue lors de l'enregistrement de votre saisie. Une désynchronisation est possible au niveau de la liste des articles sur la catégorie.\n";
			}
			if (false !== ($liste = post_get_liste_feed()))
			{
				$ok = false;
				reset($liste);
				while ((list($key,$value) = each($liste)) && (! $ok))
				{
					if ($value["id"] == $article_id)
					{
						$liste[$key]["published"]=$article["published"];
						$liste[$key]["timestamp"]=$article["timestamp"];
						$ok = true;
					}
				}
				if (! $ok)
				{
					$liste[] = array("id"=>$article_id, "published"=>$article["published"], "timestamp"=>$article["timestamp"]);
				}
			}
			else
			{
				$liste = array();
				$liste[] = array("id"=>$article_id, "published"=>$article["published"], "timestamp"=>$article["timestamp"]);
			}
			if (false !== post_set_liste_feed($liste))
			{
				$msginfo .= "La liste des articles du feed RSS a bien été mise à jour.\n";
			}
			else
			{
				$msgerreur .= "Une erreur est survenue lors de l'enregistrement de votre saisie. Une désynchronisation est possible au niveau de la liste des articles du feed RSS.\n";
			}
		}
		else
		{
			$msgerreur .= "Une erreur est survenue lors de l'enregistrement de votre saisie. Vos modifications n'ont pas été enregistrées.\n";
		}
	}
	else if ("postadd" == $op)
	{ // ajout d'un article à la rubrique actuelle
		if (false !== ($cat = category_get_infos($categorie_id)))
		{
			if (false !== ($liste = post_get_liste($categorie_id)))
			{
				$i = 0;
				$ok = false;
				while ((! $ok) && (3 <= strlen($id = post_id_create($i++,$categorie_id))-strlen($categorie_id)))
				{
					$trouve = false;
					reset($liste);
					while ((! $trouve) && (list($key,$value) = each($liste)))
					{
						$trouve = ($id == $value["id"]);
					}
					$ok = (! $trouve);
				}
				if ($ok)
				{
					$article_id = $id;
					$msginfo .= "Votre nouvel article a été créé.\n";
				}
				else
				{
					$msgerreur .= "Ajout d'article impossible : vous avez déjà le nombre maximal d'articles dans cette rubrique.\n";
				}
			}
			else
			{
				$article_id = post_id_create(0,$categorie_id);
				$msginfo .= "Votre nouvel article a été créé.\n";
			}
		}
		else
		{
			$msgerreur .= "Ajout d'article impossible : la catégorie (".$categorie_id.") n'existe pas.\n";
		}
	}

?><h2>Gestion des articles</h2><?php	
	// affichage du fil d'ariane
	$ariane = "";
	$id = $categorie_id;
	while (strlen($id) > 0)
	{
		$cat = category_get_infos($id);
		$ariane = "<a href=\"".site_url()."/admin/p/?categorie_id=".$id."\">".(("" != trim($cat["label"]))?trim($cat["label"]):"*****")."</a>".((""!=$ariane)?" / ":"").$ariane;
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
	if (false === ($article = post_get_infos($article_id)))
	{
		$article = array();
		$article["id"] = $article_id;
		$article["label"] = "";
		$article["text"] = "";
		$article["url"] = "";
		$article["published"] = false;
		$article["seo"] = "";
		$article["timestamp"] = 0;
	}
	if (! isset($article["seo"]))
	{
		$article["seo"] = "";
	}
?><form id="frm" method="POST" action="<?php print(site_url()); ?>/admin/p/">
	<input type="hidden" name="op" id="frmop" value="update">
	<input type="hidden" name="id" id="frmid" value="<?php print(htmlentities($article["id"],ENT_COMPAT,"UTF-8")); ?>">
	<input type="hidden" name="categorie_id" id="frmcategorieid" value="<?php print(htmlentities($categorie_id,ENT_COMPAT,"UTF-8")); ?>">
	<fieldset>
		<legend>Infos pour cet article</legend>
		<p><label for="frmlabel">Titre</label><br />
		<input type="text" name="label" id="frmlabel" value="<?php print(htmlentities($article["label"],ENT_COMPAT,"UTF-8")); ?>"></p>
		<p><label for="frmtext">Texte</label><br />
		<textarea name="text" id="frmtext"><?php print(htmlentities($article["text"],ENT_COMPAT,"UTF-8")); ?></textarea></p>
		<p><label for="frmurl">Nom de la page web</label><br />
		<input type="text" name="url" id="frmurl" value="<?php print(htmlentities($article["url"],ENT_COMPAT,"UTF-8")); ?>"></p>
		<p><label for="frmpublished">Publiée ?</label><br />
		<select name="published" id="frmpublished">
			<option value="O"<?php print(($article["published"])?" selected=\"selected\"":""); ?>>Oui</option>
			<option value="N"<?php print(($article["published"])?"":" selected=\"selected\""); ?>>Non</option>
		</select></p>
		<p><label for="frmpseo">Page à indexer par les moteurs de recherche ?</label><br />
		<select name="seo" id="frmseo">
			<option value=""<?php print(("" === $article["seo"])?" selected=\"selected\"":""); ?>>Par défaut</option>
			<option value="O"<?php print((true === $article["seo"])?" selected=\"selected\"":""); ?>>Oui</option>
			<option value="N"<?php print((false === $article["seo"])?" selected=\"selected\"":""); ?>>Non</option>
		</select></p>
		<p>Date de dernière modification : <?php print(aaaammjjhhmmss_to_string(date("YmdHis",intval($article["timestamp"])))); ?></p>
		<p>URL de sa page : <a href="<?php print(post_url($article_id)); ?>" target="_blank"><?php print(post_url($article_id)); ?></a></p>
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
		reset($categorie_liste);
		while (list($key,$value)=each($categorie_liste))
		{
			$cat = category_get_infos($value["id"]);
			$sousrubriques .= "<a href=\"".site_url()."/admin/p/?categorie_id=".$value["id"]."\">".$cat["id"]." - ".$cat["label"]."</a><br />";
		}
	}
?><div id="sousrubriques"><p>Sous rubriques de la rubriques en cours:<br /><?php print($sousrubriques); ?></p></div><?php

	// affichage de la liste des articles de la même catégorie
	$autresarticles = "<a href=\"#\" onclick=\"$('#frmop').val('postadd');$('#frm').submit();return true;\">Ajouter un article</a><br />";
	$article_liste = post_get_liste($categorie_id);
	if (is_array($article_liste))
	{
		reset($article_liste);
		while (list($key,$value)=each($article_liste))
		{
			$art = post_get_infos($value["id"]);
			$autresarticles .= "<a href=\"".site_url()."/admin/p/?categorie_id=".$categorie_id."&id=".$value["id"]."\">".$art["id"]." - ".aaaammjjhhmmss_to_string(date("YmdHis",intval($art["timestamp"])))." - ".$art["label"]."</a><br />";
		}
	}
?><div id="autresarticles"><p>Autres articles de la rubriques en cours:<br /><?php print($autresarticles); ?></p></div>
<ul>
	<li><a href="<?php print(site_url()); ?>/admin/">Retour au menu principal</a></li>
</ul>