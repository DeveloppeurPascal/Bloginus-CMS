<?php
	// thème par défaut, ne pas modifier ce fichier

	global $nom,$prenom,$email,$sujet,$message,$msgErreur;
	$titre_page = "Nous contacter";
	fichier_inclure("_header.php");
?><div id="pageContact"><form method="POST"><?php
	print(config_getvar("contact-haut","<p class=\"msgInfo\">Pour nous contacter, veuillez remplir ce formulaire :</p>"));
	if ("" != $msgErreur)
	{
?><p class="msgErreur"><?php print(nl2br($msgErreur)); ?></p><?php
	}
?><fieldset><input type="hidden" name="gogo" value="<?php print(uniqid()); ?>"><?php
	if (is_array($destinataires = config_getvar("contact-destinataires","")))
	{
		if (count($destinataires)>1)
		{
?><p><label for="frmdest">Choix du destinataire:</label><select name="dest" id="frmdest"><?php
			reset($destinataires);
			while(list($key,$value) = each($destinataires))
			{
?><option value="<?php print(htmlentities($key,ENT_COMPAT,"UTF-8")); ?>"><?php print(htmlentities($key,ENT_COMPAT,"UTF-8")); ?></option><?php
			}
?></select></p><?php
		}
		else
		{
			reset($destinataires);
			list($key,$value) = each($destinataires);
?><input type="hidden" name="dest" value="<?php print(htmlentities($key,ENT_COMPAT,"UTF-8")); ?>"><?php
		}
	}
	else
	{
?><input type="hidden" name="dest" value=""><?php
	}
?>
<p><label for="votrenom">Votre nom:</label><input type="text" name="nom" id="votrenom" value="<?php print(htmlentities($nom,ENT_COMPAT,"UTF-8")); ?>"></p>
<p><label for="votreprenom">Votre prénom:</label><input type="text" name="prenom" id="votreprenom" value="<?php print(htmlentities($prenom,ENT_COMPAT,"UTF-8")); ?>"></p>
<p><label for="votreemail">Votre email:</label><input type="email" name="email" id="votreemail" value="<?php print(htmlentities($email,ENT_COMPAT,"UTF-8")); ?>"></p>
<p><label for="votretitre">Sujet du message:</label><input type="text" name="sujet" id="votretitre" value="<?php print(htmlentities($sujet,ENT_COMPAT,"UTF-8")); ?>"></p>
<p><label for="votremessage">Votre message:</label><textarea name="message" id="votremessage"><?php print(htmlentities($message,ENT_COMPAT,"UTF-8")); ?></textarea></p>
<p><input type="submit" id="btnEnvoyer" value="Envoyer"></p>
</fieldset><?php
	print(config_getvar("contact-bas"));
?></form></div><?php
	fichier_inclure("_footer.php");
?>