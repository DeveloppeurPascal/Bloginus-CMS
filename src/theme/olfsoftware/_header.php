<!DOCTYPE html>
<html>
<head><?php
	fichier_inclure("_header-meta.php");
?><meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="/favicon.ico">
	<link rel="apple-touch-icon" href="/apple-touch-icon.png">
	<link rel="stylesheet" type="text/css" href="<?php print(site_url()); ?>/css/styles.css">
</head>
<body>
<div id="page">
	<header id="page_header">
		<h1><a href=""><?php
	$titre = (("" != $titre_page)?$titre_page." - ":"").trim(config_getvar("titre"));
	print(htmlentities(("" == $titre_page)?$titre:$titre_page,ENT_COMPAT,"UTF-8"));
?></a></h1>
		<nav class="menu">
			<ul>
				<li></li>
				<li></li>
			</ul>
		</nav>
	</header>
	<article class="page_content">