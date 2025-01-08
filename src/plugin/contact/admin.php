<?php
	// Bloginus
	// (c) Patrick Prémartin / Olf Software 09/2014
	//
	// http://www.bloginus-lescript.fr

	$msgerreur = "";
	$msginfo = "";
	$contact_sujet = "";
	if (isset($_POST["contact_sujet"]))
	{
		$contact_sujet = trim($_POST["contact_sujet"]);
		if ($contact_sujet != "")
		{
			config_setvar("contact-sujet", $contact_sujet);
			$msginfo .= "Le sujet des emails a été mis à jour.\n";
		}
		else
		{
			$msgerreur .= "Veuillez renseigner le sujet des emails.\n";
		}
	}
	$destinataires = array();
	$i = 0;
	while ((isset($_POST["dest_nom".$i])) && (isset($_POST["dest_email".$i])))
	{
		$nom = trim(strip_tags($_POST["dest_nom".$i]));
		$email = trim(strip_tags($_POST["dest_email".$i]));
		if (("" != $nom) && ("" != $email))
		{
			$destinataires[$nom]=$email;
		}
		$i++;
	}
	if (count($destinataires) > 0)
	{
		ksort($destinataires);
		config_setvar("contact-destinataires", $destinataires);
		$msginfo .= "Les destinataires ont été mis à jour.\n";
	}
	else if ($i > 0)
	{
		$msgerreur .= "Veuillez renseigner au moins un destinataire du formulaire de contact.\n";
	}
?><h2>Configuration du formulaire de contact du site</h2><?php
	if ("" != $msgerreur)
	{
		print("<p class=\"msgerreur\">".nl2br($msgerreur)."</p>");
	}
	if ("" != $msginfo)
	{
		print("<p class=\"msginfo\">".nl2br($msginfo)."</p>");
	}
	
?><form method="POST" action="<?php print(site_url()); ?>/admin/contact/">
	<fieldset>
		<legend>Formulaire de contact</legend>
		<p><label for="frmcontact_sujet">Sujet des emails</label><br />
		<input type="text" name="contact_sujet" id="frmcontact_sujet" value="<?php print(htmlentities(config_getvar("contact-sujet"),ENT_COMPAT,"UTF-8")); ?>"></p>
<?php
	$i = 0;
	reset($destinataires);
	while (list($key,$value) = each($destinataires))
	{
?>
		<fieldset>
			<legend>Destinataire <?php print($i+1); ?>:</legend>
			<p><label for="dest_nom<?php print($i); ?>">Nom / Libellé du service (en choix sur le formulaire)</label><br />
			<input type="text" name="dest_nom<?php print($i); ?>" id="dest_nom<?php print($i); ?>" value="<?php print(htmlentities($key,ENT_COMPAT,"UTF-8")); ?>"></p>
			<p><label for="dest_email<?php print($i); ?>">Email qui recevra les messages</label><br />
			<input type="email" name="dest_email<?php print($i); ?>" id="dest_email<?php print($i); ?>" value="<?php print(htmlentities($value,ENT_COMPAT,"UTF-8")); ?>"></p>
		</fieldset>
<?php
		$i++;
	}
?>
		<fieldset>
			<legend>Destinataire <?php print($i+1); ?>:</legend>
			<p><label for="dest_nom<?php print($i); ?>">Nom / Libellé du service (en choix sur le formulaire)</label><br />
			<input type="text" name="dest_nom<?php print($i); ?>" id="dest_nom<?php print($i); ?>" value=""></p>
			<p><label for="dest_email<?php print($i); ?>">Email qui recevra les messages</label><br />
			<input type="email" name="dest_email<?php print($i); ?>" id="dest_email<?php print($i); ?>" value=""></p>
		</fieldset>
		<p><input type="submit" value="Enregistrer"></p>
	</fieldset>
</form><ul>
	<li><a href="<?php print(site_url()); ?>/admin/">Retour au menu principal</a></li>
</ul>