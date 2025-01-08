<!DOCTYPE html>
<html lang="<?php print(htmlentities(config_getvar("langue","fr"),ENT_COMPAT,"UTF-8")); ?>">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1"><?php
	fichier_inclure("_header-meta.php");
?><link rel="icon" href="<?php print(site_url()); ?>/favicon.ico">
	<link rel="apple-touch-icon" href="<?php print(site_url()); ?>/apple-touch-icon.png">
    <link href="<?php print(site_url()); ?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php print(site_url()); ?>/css/blog.css" rel="stylesheet">
    <!--[if lt IE 9]><script src="<?php print(site_url()); ?>/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="<?php print(site_url()); ?>/js/ie-emulation-modes-warning.js"></script>
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="blog-masthead">
      <div class="container">
        <nav class="blog-nav"><?php
		$liste = array();
		$liste[] = category_get_infos("_");
		$menu = category_get_liste("_");
		reset($menu);
		while (list($key,$value)=each($menu))
		{
			if ($value["published"])
				$liste[] = category_get_infos($value["id"]);
		}
		for ($i =0; $i < count($liste); $i++)
		{
?><a href="<?php print(category_url($liste[$i]["id"])); ?>"  class="blog-nav-item<?php if (("__" == $categorie_id.$liste[$i]["id"]) || (substr($categorie_id,0,2) == $liste[$i]["id"])) print(" active"); ?>"><?php print(htmlentities(("_"==$liste[$i]["id"])?"Accueil":$liste[$i]["label"],ENT_COMPAT,"UTF-8")); ?></a><?php
		}
?></nav>
      </div>
    </div>
    <div class="container">
      <div class="blog-header">
        <h1 class="blog-title"><?php
	$titre = (("" != $titre_page)?$titre_page." - ":"").trim(config_getvar("titre"));
	print(htmlentities(("" == $titre_page)?$titre:$titre_page,ENT_COMPAT,"UTF-8"));
?></h1>
<?php // <p class="lead blog-description">sous-titre</p> ?>
      </div>
      <div class="row">
        <div class="col-sm-8 blog-main">