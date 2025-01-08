<?php
	// thème par défaut, ne pas modifier ce fichier
?><!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php
	if (isset($article) && is_array($article))
	{
		$titre_page = trim($article["label"]);
	}
	else if (isset($categorie) && is_array($categorie) && ("0" != $categorie["id"]))
	{
		$titre_page = trim($categorie["label"]);
	}
	else
	{
		$titre_page = "";
	}
	$titre = (("" != $titre_page)?$titre_page." - ":"").trim(config_getvar("titre"));
	print(htmlentities($titre,ENT_COMPAT,"UTF-8"));
?></title>
<meta name="author" content="<?php print(htmlentities(config_getvar("auteur"),ENT_COMPAT,"UTF-8")); ?>">
<meta name="robots" content="follow,<?php print((isset($article) && is_array($article))?"index":"noindex,nocache"); ?>">
<meta http-equiv="Content-Language" content="<?php print(htmlentities(config_getvar("langue","fr"),ENT_COMPAT,"UTF-8")); ?>">
<link rel="stylesheet" type="text/css" href="<?php print(site_url()); ?>/css/styles.css">
</head><body><div id="header"><h1><?php print(htmlentities(("" == $titre_page)?$titre:$titre_page,ENT_COMPAT,"UTF-8")); ?></h1></div><div id="page"><div id="contenu"><?php
	$fildariane = "";
	$id = $categorie_id;
	while (strlen($id) > 0)
	{
		$cat = category_get_infos($id);
		if (("_" == $cat["id"]) && ("" == $cat["label"]))
		{
			$cat["label"] = "Accueil";
		}
		if ($cat["published"])
		{
			$fildariane = "<a href=\"".category_url($cat["id"])."\">".(("" != trim($cat["label"]))?trim($cat["label"]):"*****")."</a>".((""!=$fildariane)?" &gt; ":"").$fildariane;
		}
		$id = substr($id,0,strlen($id)-1);
	}
?><div id="fildariane">&gt; <?php print($fildariane); ?></div>