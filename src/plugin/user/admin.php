<?php
	// Bloginus
	// (c) Patrick Prémartin / Olf Software 07/2014-01/2016
	//
	// http://www.bloginus-lescript.fr

	$msgerreur = "";
	$msginfo = "";
	$user = "";
	$password = "";
	$password2 = "";
	if (isset($_GET["logoff"]))
	{
		$_SESSION["user_connected"] = "0";
		$msginfo .= "Déconnexion enregistrée.\n";
	}
	else if (isset($_GET["dspchglnp"]) && isset($_POST["lognpass_phrase"]))
	{
		$lognpass_key = trim($_POST["lognpass_key"]);
		if ((false === ($lognpass_phrase_actuelle = @file_get_contents(get_data_path()."/lognpass.dta"))) || ("" != $lognpass_key))
		{
			require_once(dirname(__FILE__)."/../../inc/manual/lognpass-inc.php");
			lognpass_set_temp_dir(dirname(__FiLE__)."/../../temp");
			if (("" == $lognpass_key) || lognpass_check_password($lognpass_phrase_actuelle,$lognpass_key))
			{
				$lognpass_phrase = trim($_POST["lognpass_phrase"]);
				if ("" != $lognpass_phrase)
				{
					file_put_contents(get_data_path()."/lognpass.dta", md5($lognpass_phrase));
				}
				else
				{
					@unlink(get_data_path()."/lognpass.dta");
				}
				$msginfo .= "Paramètres enregistrés.\n";
			}
			else
			{
				$msgerreur .= "Clé de sécurité invalide.";
			}
		}
		else
		{
			$msgerreur .= "Pour modifier votre phrase mystère Log'n Pass, vous devez fournir le code de sécurité actuel.\n";
		}
	}
	else if (isset($_GET["dspchg"]) && isset($_POST["password"]))
	{
		$password = trim($_POST["password"]);
		if (isset($_POST["password2"]))
		{
			$password2 = trim($_POST["password2"]);
		}
		else
		{
			$password2 = "";
		}
		if ("" != $password)
		{
			if ($password == $password2)
			{
				if (false !== ($res = @file_get_contents(get_data_path()."/user.dta")))
				{
					$utilisateur = unserialize($res);
					file_put_contents(get_data_path()."/user.dta",serialize(array("user"=>$utilisateur["user"],"password"=>md5($password))));
					$msginfo .= "Paramètres enregistrés. Pensez à noter votre nouveau mot de passe pour vos futures connexions.\n";
				}
				else
				{
					$msgerreur .= "Problème lors de l'enregistrement de votre nouveau mot de passe.\n";
				}
			}
			else
			{
				$msgerreur .= "Les mots de passe saisis ne correspondent pas, veuillez saisir le même dans les deux champs.\n";
			}
		}
		else
		{
			$msgerreur .= "Veuillez indiquer un mot de passe (de préférence compliqué).\n";
		}
	}
	else if (isset($_POST["user"]) && isset($_POST["password"]))
	{
		$_SESSION["user_connected"] = "0";
		$user = trim($_POST["user"]);
		$password = trim($_POST["password"]);
		if (false !== ($res = @file_get_contents(get_data_path()."/user.dta")))
		{
			$utilisateur = unserialize($res);
			if ("" != $user)
			{
				if ("" != $password)
				{
					$lognpass_key = isset($_POST["lognpass_key"])?$_POST["lognpass_key"]:"";
					if ($lognpass_active = file_exists(get_data_path()."/lognpass.dta"))
					{
						if ("" != $lognpass_key)
						{
							require_once(dirname(__FILE__)."/../../inc/manual/lognpass-inc.php");
							lognpass_set_temp_dir(dirname(__FiLE__)."/../../temp");
							if (lognpass_check_password(@file_get_contents(get_data_path()."/lognpass.dta"),$lognpass_key) && (md5($user) == $utilisateur["user"]) && (md5($password) == $utilisateur["password"]))
							{
								$_SESSION["user_connected"] = "1";
								$msginfo .= "Connexion établie. Vous pouvez travailler.\nPensez à fermer votre navigateur ou vous déconnecter en fin de session.\n";
							}
							else
							{
								$msgerreur .= "Accès refusé.\n";
							}
						}
						else
						{
							$msgerreur .= "Veuillez indiquer votre clé de sécurité.\n";
						}
					}
					else if ((md5($user) == $utilisateur["user"]) && (md5($password) == $utilisateur["password"]))
					{
						$_SESSION["user_connected"] = "1";
						$msginfo .= "Connexion établie. Vous pouvez travailler.\nPensez à fermer votre navigateur ou vous déconnecter en fin de session.\n";
					}
					else
					{
						$msgerreur .= "Le mot de passe saisi ne correspond pas à celui enregistré. Veuillez recommencer.\n";
					}
				}
				else
				{
					$msgerreur .= "Veuillez indiquer votre mot de passe.\n";
				}
			}
			else
			{
				$msgerreur .= "Veuillez indiquer votre nom d'utilisateur.\n";
			}
		}
		else
		{
			if (isset($_POST["password2"]))
			{
				$password2 = trim($_POST["password2"]);
			}
			else
			{
				$password2 = "";
			}
			if ("" != $user)
			{
				if ("" != $password)
				{
					if ($password == $password2)
					{
						file_put_contents(get_data_path()."/user.dta",serialize(array("user"=>md5($user),"password"=>md5($password))));
						$_SESSION["user_connected"] = "1";
						$msginfo .= "Paramètres enregistrés. Pensez à noter vos identifiants pour vos futures connexions.\n";
					}
					else
					{
						$msgerreur .= "Les mots de passe saisis ne correspondent pas, veuillez saisir le même dans les deux champs.\n";
					}
				}
				else
				{
					$msgerreur .= "Veuillez indiquer un mot de passe (de préférence compliqué).\n";
				}
			}
			else
			{
				$msgerreur .= "Veuillez indiquer un nom d'utilisateur.\n";
			}
		}
	}

	if (isset($_SESSION["user_connected"]) && ("1" == $_SESSION["user_connected"]))
	{
?><h2>Gestion de votre compte utilisateur</h2><?php
	}
	if ("" != $msgerreur)
	{
		print("<p class=\"msgerreur\">".nl2br($msgerreur)."</p>");
	}
	if ("" != $msginfo)
	{
		print("<p class=\"msginfo\">".nl2br($msginfo)."</p>");
	}
	if (isset($_GET["logoff"]))
	{ // déconnexion faite
?><ul>
	<li><a href="<?php print(site_url()); ?>/admin/">Retour au menu principal</a></li>
</ul><?php
	}
	else if (isset($_SESSION["user_connected"]) && ("1" == $_SESSION["user_connected"]))
	{ // affichage des pages en cas d'utilisateur connecté
		if (isset($_GET["dspchg"]))
		{
?><form method="POST" action="<?php print(site_url()); ?>/admin/user/?dspchg=1">
	<fieldset>
		<legend>Changement de mot de passe</legend>
		<p><label for="frmpassword">Mot de passe</label><br />
		<input type="password" name="password" id="frmpassword"></p>
		<p><label for="frmpassword2">Répétez votre mot de passe</label><br />
		<input type="password" name="password2" id="frmpassword2"></p>
		<p><input type="submit" value="Enregistrer"></p>
	</fieldset>
</form><ul>
	<li><a href="<?php print(site_url()); ?>/admin/user/">Retour au menu</a></li>
	<li><a href="<?php print(site_url()); ?>/admin/">Retour au menu principal</a></li>
</ul><?php
		}
		else if (isset($_GET["dspchglnp"]))
		{
?><form method="POST" action="<?php print(site_url()); ?>/admin/user/?dspchglnp=1">
	<p>Afin de sécuriser vos accès au site, même sur un ordinateur qui n'est pas le vôtre, vous pouvez activer la double authentification par <a href="http://www.lognpass.fr" target="_blank">Log'n Pass</a>.</p>
	<p>Avant cela vous devez avoir téléchargé et installé le logiciel gratuit <a href="http://www.lognpass.fr" target="_blank">Log'n Pass</a> qui vous fournira un code d'accès unique à chaque connexion au site.</p>
	<fieldset>
		<legend>Changement de la phrase mystère</legend>
		<p><label for="frmlnpp">Nouvelle phrase mystère</label><br />
		<input type="text" name="lognpass_phrase" id="frmlnpp"></p><?php
	if (! file_exists(get_data_path()."/lognpass.dta"))
	{
?><input type="hidden" name="lognpass_key" value=""><?php
	}
	else
	{
?><p><label for="frmlnpk">Code de sécurité actuel</label><br />
<input type="text" name="lognpass_key" id="frmlnpk"></p><?php
	}
?><p><input type="submit" value="Enregistrer"></p>
	</fieldset>
	<p><small>Si vous perdez votre phrase mystère, vous pourrez toujours désactiver cette fonctionnalité en supprimant le fichier <?php print(get_data_path()."/lognpass.dta"); ?> de votre FTP mais ne pourrez pas vous connecter au backoffice jusqu'à ce que ce soit fait.</small></p>
</form><ul>
	<li><a href="<?php print(site_url()); ?>/admin/user/">Retour au menu</a></li>
	<li><a href="<?php print(site_url()); ?>/admin/">Retour au menu principal</a></li>
</ul><?php
		}
		else
		{
?><ul>
	<li><a href="<?php print(site_url()); ?>/admin/">Retour au menu principal</a></li>
	<li><a href="<?php print(site_url()); ?>/admin/user/?dspchg=1">Changer mon mot de passe</a></li>
	<li><a href="<?php print(site_url()); ?>/admin/user/?dspchglnp=1">Changer ma phrase mystère Log'n Pass</a></li>
	<li><a href="<?php print(site_url()); ?>/admin/user/?logoff=1">Me déconnecter</a></li>
</ul><?php
		}
	}
	else if (! file_exists(get_data_path()."/user.dta"))
	{ // affichage du formulaire de connexion
?><form method="POST" action="<?php print(site_url()); ?>/admin/user">
	<fieldset>
		<legend>Création de votre identifiant</legend>
		<p><label for="frmuser">Utilisateur</label><br />
		<input type="text" name="user" id="frmuser" value="<?php print(htmlentities($user,ENT_COMPAT,"UTF-8")); ?>"></p>
		<p><label for="frmpassword">Mot de passe</label><br />
		<input type="password" name="password" id="frmpassword"></p>
		<p><label for="frmpassword2">Répétez votre mot de passe</label><br />
		<input type="password" name="password2" id="frmpassword2"></p>
		<p><input type="submit" value="Me connecter"></p>
	</fieldset>
</form><?php
	}
	else
	{ // affichage du formulaire de connexion
?><form method="POST" action="<?php print(site_url()); ?>/admin/user">
	<fieldset>
		<legend>Identification</legend>
		<p><label for="frmuser">Utilisateur</label><br />
		<input type="text" name="user" id="frmuser" value="<?php print(htmlentities($user,ENT_COMPAT,"UTF-8")); ?>"></p>
		<p><label for="frmpassword">Mot de passe</label><br />
		<input type="password" name="password" id="frmpassword"></p><?php
	if (file_exists(get_data_path()."/lognpass.dta"))
	{
?><p style="background-image:url(<?php print(site_url()); ?>/images/admin/lognpass-32x32.png);background-repeat:no-repeat;padding-left:35px;"><label for="frmlnpk">Code d'accès <a href="http://www.lognpass.fr" target="_blank">Log'n Pass</a></label><br />
<input type="text" name="lognpass_key" id="frmlnpk"></p><?php
	}
?><p><input type="submit" value="Me connecter"></p>
	</fieldset>
</form><?php
	}
?>