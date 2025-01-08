<?php
	// Bloginus
	// (c) Patrick Prémartin / Olf Software 06/2014-06/2015
	//
	// http://www.bloginus-lescript.fr
?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Bloginus</title>
<meta name="author" content="(c) Patrick Premartin / Olf Software 06/2014">
<meta name="Robots" content="noindex,nofollow">
<meta http-equiv="Content-Language" content="fr">
<link rel="stylesheet" type="text/css" href="<?php print(site_url()); ?>/css/admin/styles.css">
<?php
	switch (config_getvar("jquery_cdn",""))
	{
		case "jquery":
			$jquery_url = "//code.jquery.com/jquery-1.11.3.min.js";
			break;
		case "google":
			$jquery_url = "//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js";
			break;
		case "microsoft":
			$jquery_url = "//ajax.aspnetcdn.com/ajax/jQuery/jquery-1.11.3.min.js";
			break;
		default :
			$jquery_url = "//cdn.olfsoftware.fr/jquery/1/latest.php";
	}
?><script type="text/javascript" src="<?php print($jquery_url); ?>"></script>
<?php
	$ckeditor = config_getvar("ckeditor_cdn","");
	switch ($ckeditor)
	{
		case "basic":
		case "standard":
		case "full":
			$ckeditor_url = "//cdn.ckeditor.com/4.4.7/".$ckeditor."/";
			break;
		default :
			$ckeditor_url = "//cdn.olfsoftware.fr/ckeditor/4/latest/";
	}
?><script type="text/javascript" src="<?php print($ckeditor_url); ?>ckeditor.js"></script>
<script type="text/javascript" src="<?php print($ckeditor_url); ?>adapters/jquery.js"></script>
</head>
<body>
<h1>Bloginus</h1>
