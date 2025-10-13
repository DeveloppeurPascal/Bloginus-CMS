<?php
	// Bloginus CMS
	// (c) 2014-2025 Patrick Prémartin / Olf Software
	//
	// This project is distributed under the AGPLv3 license.
	//
	// Go to this website for the documentation, download latest release,
	// buying a developer pro license or contacting us :
	// https://bloginus.olfsoftware.fr

	$miseajourdispo = false;
	$version1 = version_load();
	if (false === ($version2 = @file_get_contents("https://bloginus.olfsoftware.fr/version/")))
	{
		$version2 = "(en maintenance)";
	}
	else if (intval($version2) > intval($version1))
	{
		$miseajourdispo = true;
	}
?><h2>Infos de version</h2>
<p>Ce site est en version : <?php print($version1); ?><br />
Bloginus est en version : <?php print($version2); ?></p><?php
	if ($miseajourdispo)
	{
?><p>Une mise à jour est disponible.<br />
<a href="https://bloginus.olfsoftware.fr/zip/bloginus.zip">Téléchargez</a> la nouvelle version et <a href="https://bloginus.olfsoftware.fr/c/_21-mise-a-jour.html">installez là</a>.</p><?php
	}
?><h2>Licence</h2>
<p>En achetant le script <strong>Bloginus</strong>, vous avez acquis le droit de l'utiliser sur tous vos sites.</p>
<p>Vous n'avez pas le droit de distribuer le script <strong>Bloginus</strong> sous quelle que forme que ce soit. Il n'est disponible que depuis <a href="https://bloginus.olfsoftware.fr/">son site officiel</a> et ne doit en aucun cas circuler en dehors.</p>
<p>Vous n'avez pas le droit de donner ou revendre ce script ni un site conçu à l'aide de <strong>Bloginus</strong> si votre client n'a pas lui-même acquis une licence de <strong>Bloginus</strong> depuis <a href="https://bloginus.olfsoftware.fr/c/_1_-acheter.html">cette page</a>.</p>
<p>Merci de respecter ces règles et de soutenir notre travail en achetant une <a href="https://bloginus.olfsoftware.fr/c/_10-licence.html">licence d'utilisation</a> si vous ne l'avez pas encore.</p>
<h2>Documentation</h2>
<p>Pour utiliser, paramétrer et adapter <strong>Bloginus</strong>, rendez-vous sur la <a href="https://bloginus.olfsoftware.fr/c/_2-mode-d-emploi.html">documentation en ligne</a>.</p>
<p>Une <a href="https://bloginus.olfsoftware.fr/c/_3-themes.html">documentation sur les thèmes</a> y est également disponible. Vous pourrez également y trouver une sélection de thèmes clés en main si le thème par défaut ne vous inspire pas trop (ce que nous pouvons comprendre).</p>
<h2>Copyright</h2>
<p><strong>Bloginus</strong> a été initialement développé par <a href="https://patrick.premartin.fr">Patrick Prémartin</a> à l'été 2014 pour le compte de la société <a href="https://www.olfsoftware.fr">Olf Software</a>. Il est disponible à la vente pour tout le monde depuis <a href="https://bloginus.olfsoftware.fr/c/_1_-acheter.html">cette page</a>.</p>
<p></p>