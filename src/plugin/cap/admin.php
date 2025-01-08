<?php
	// Bloginus
	// (c) Patrick Prémartin / Olf Software 09/2014
	//
	// http://www.bloginus-lescript.fr

	$msgErreur = "";
	$msgInfo = "";
	$op = isset($_POST["op"])?strtolower(trim(strip_tags($_POST["op"]))):"liste";
	$num = isset($_POST["num"])?intval($_POST["num"]):0;
	$changement = false;
	$cap = new StdClass();
	$cap->type = isset($_POST["captype"])?strtoupper(trim(strip_tags($_POST["captype"]))):"";
	if ("chgsqueeze" == $op)
	{
		$cap->texte_haut = isset($_POST["texte_haut"])?trim($_POST["texte_haut"]):"";
		$cap->video_script = isset($_POST["video_script"])?trim($_POST["video_script"]):"";
		$cap->autorepondeur_script = isset($_POST["autorepondeur_script"])?trim($_POST["autorepondeur_script"]):"";
		$cap->texte_bas = isset($_POST["texte_bas"])?trim($_POST["texte_bas"]):"";
		if (($cap->texte_haut == "") && ($cap->texte_bas == ""))
		{
			$msgErreur .= "Veuillez saisir au moins un texte pour le haut ou le bas de page.\n";
		}
		if ($cap->autorepondeur_script == "")
		{
			$msgErreur .= "Veuillez saisir le script HTML d'affichage de votre autorépondeur.\n";
		}
		if ("S" != $cap->type)
		{
			$msgErreur .= "Prise en compte impossible : incohérence de type.\n";
		}
		$num = 0;
		$op = substr($op,3);
		$changement = ("" == $msgErreur);
	}
	else if ("chgmerci" == $op)
	{
		$cap->texte = isset($_POST["texte"])?trim($_POST["texte"]):"";
		if ($cap->texte == "")
		{
			$msgErreur .= "Veuillez saisir un texte incitant à cliquer sur le lien de confirmation dans l'email envoyé par votre autorépondeur.\n";
		}
		if ("M" != $cap->type)
		{
			$msgErreur .= "Prise en compte impossible : incohérence de type.\n";
		}
		$num = 1;
		$op = substr($op,3);
		$changement = ("" == $msgErreur);
	}
	else if ("chgdeja" == $op)
	{
		$cap->texte = isset($_POST["texte"])?trim($_POST["texte"]):"";
		if ($cap->texte == "")
		{
			$msgErreur .= "Veuillez saisir un texte expliquant à votre visiteur que son email est déjà inscrite dans la liste.\n";
		}
		if ("D" != $cap->type)
		{
			$msgErreur .= "Prise en compte impossible : incohérence de type.\n";
		}
		$num = 2;
		$op = substr($op,3);
		$changement = ("" == $msgErreur);
	}
	else if ("chgreco" == $op)
	{
		$cap->email_titre = isset($_POST["email_titre"])?trim($_POST["email_titre"]):"";
		$cap->email_texte = isset($_POST["email_texte"])?trim($_POST["email_texte"]):"";
		if ($cap->email_texte == "")
		{
			$msgErreur .= "Veuillez saisir un texte qui sera envoyé par vos visiteurs à leurs amis, pensez à y mettre l'URL de la squeeze page (".config_getvar("url")."/cap/) ou du site (".config_getvar("url").").\n";
		}
		if ("R" != $cap->type)
		{
			$msgErreur .= "Prise en compte impossible : incohérence de type.\n";
		}
		$num = 3;
		$op = substr($op,3);
		$changement = ("" == $msgErreur);
	}
	else if ("chgvideo" == $op)
	{
		$cap->titre = isset($_POST["titre"])?trim($_POST["titre"]):"";
		$cap->texte_haut = isset($_POST["texte_haut"])?trim($_POST["texte_haut"]):"";
		$cap->video_script = isset($_POST["video_script"])?trim($_POST["video_script"]):"";
		$cap->texte_bas = isset($_POST["texte_bas"])?trim($_POST["texte_bas"]):"";
		$cap->url = isset($_POST["url"])?trim($_POST["url"]):"";
		if ($cap->video_script == "")
		{
			$msgErreur .= "Veuillez saisir le script HTML d'affichage de votre vidéo.\n";
		}
		if ($cap->url == "")
		{
			if ($cap->titre == "")
			{
				$msgErreur .= "Veuillez donner un titre à votre page ou son URL (exemple : \"video 1\", \"mon choix 1\", \"video 1\").\n";
			}
			else
			{
				$cap->url = en_url($cap->titre);
			}
		}
		if ("V" != $cap->type)
		{
			$msgErreur .= "Prise en compte impossible : incohérence de type (".$cap->type.").\n";
		}
		if ($num < 4)
		{
			$msgErreur .= "Prise en compte impossible : identifiant de la page erroné.\n";
		}
		$op = substr($op,3);
		$changement = ("" == $msgErreur);
	}
	if ($changement)
	{
		config_setvar("cap_page_".$num,$cap);
		if ($num >= config_getvar("cap_nb",0))
		{
			config_setvar("cap_nb",$num+1);
		}
		$op = "liste";
		$msgInfo .= "Mise à jour enregistrée.\n";
	}
?><h2>Gestion de pack "Club Affiliation Pro"</h2>
<p>Ce module est destiné aux membres du <a href="http://vasur.fr/clubaffiliationpro" target="_blank">Club Affiliation Pro</a>. Retrouvez toutes les informations sur le forum du club.</p><?php
	if ("" != $msgErreur)
	{
		print("<p class=\"msgErreur\">".nl2br($msgErreur)."</p>");
	}
	if ("" != $msgInfo)
	{
		print("<p class=\"msgInfo\">".nl2br($msgInfo)."</p>");
	}
	
?><form name="formul" id="frm" method="POST" action="<?php print(site_url()); ?>/admin/cap/"><input type="hidden" name="op" value=""><input type="hidden" name="num" value=""><input type="hidden" name="captype" value=""><?php
	if ("liste" == $op)
	{
?><fieldset>
	<legend>Liste des pages</legend>
<?php
	if (false === ($cap = config_getvar("cap_page_0",false)))
	{
		$cap = new StdClass();
		$cap->type = "S";
		$cap->texte_haut = "";
		$cap->video_script = "";
		$cap->autorepondeur_script = "";
		$cap->texte_bas = "";
	}
	$cap->url = config_getvar("url")."/cap/";
?><fieldset>
		<legend>Page "Squeeze" => vidéo d'accueil et formulaire d'inscription</legend>
		<p><strong>Texte haut :</strong> <?php print(strip_tags($cap->texte_haut)); ?></p>
		<p><strong>Script vidéo :</strong> <?php print(htmlentities($cap->video_script,ENT_COMPAT,"UTF-8")); ?></p>
		<p><strong>Script autorepondeur :</strong> <?php print(htmlentities($cap->autorepondeur_script,ENT_COMPAT,"UTF-8")); ?></p>
		<p><strong>Texte bas :</strong> <?php print(strip_tags($cap->texte_bas)); ?></p>
		<p><strong>URL :</strong> <?php print("<a href=\"".$cap->url."\" target=\"_blank\">".$cap->url."</a>"); ?></p>
		<p><input type="button" onclick="document.formul.op.value='squeeze';document.formul.num.value='0';$('#frm').submit();" value="Modifier"></p>
	</fieldset><?php
	if (false === ($cap = config_getvar("cap_page_1",false)))
	{
		$cap = new StdClass();
		$cap->type = "M";
		$cap->texte = "";
	}
	$cap->url = config_getvar("url")."/cap/merci.html";
?><fieldset>
		<legend>Page "Merci" => demande de confirmation d'inscription</legend>
		<p><strong>Texte :</strong> <?php print(strip_tags($cap->texte)); ?></p>
		<p><strong>URL :</strong> <?php print("<a href=\"".$cap->url."\" target=\"_blank\">".$cap->url."</a>"); ?></p>
		<p><input type="button" onclick="document.formul.op.value='merci';document.formul.num.value='1';$('#frm').submit();" value="Modifier"></p>
	</fieldset><?php
	if (false === ($cap = config_getvar("cap_page_2",false)))
	{
		$cap = new StdClass();
		$cap->type = "D";
		$cap->texte = "";
	}
	$cap->url = config_getvar("url")."/cap/dejainscrit.html";
?><fieldset>
		<legend>Page "Déjà inscrit" => inscription sur liste déjà faite</legend>
		<p><strong>Texte :</strong> <?php print(strip_tags($cap->texte)); ?></p>
		<p><strong>URL :</strong> <?php print("<a href=\"".$cap->url."\" target=\"_blank\">".$cap->url."</a>"); ?></p>
		<p><input type="button" onclick="document.formul.op.value='deja';document.formul.num.value='2';$('#frm').submit();" value="Modifier"></p>
	</fieldset><?php
	if (false === ($cap = config_getvar("cap_page_3",false)))
	{
		$cap = new StdClass();
		$cap->type = "R";
		$cap->email_titre = "";
		$cap->email_texte = "";
	}
?><fieldset>
		<legend>Infos de recommandation par email</legend>
		<p><strong>Titre de l'email :</strong> <?php print(strip_tags($cap->email_titre)); ?></p>
		<p><strong>Texte de l'email :</strong> <?php print(strip_tags($cap->email_texte)); ?></p>
		<p><input type="button" onclick="document.formul.op.value='reco';document.formul.num.value='3';$('#frm').submit();" value="Modifier"></p>
	</fieldset><?php
	$cap_nb = config_getvar("cap_nb",0);
	for ($i = 4; $i < $cap_nb; $i++)
	{
		if (false === ($cap = config_getvar("cap_page_".$i,false)))
		{
			$cap = new StdClass();
			$cap->type = "V";
			$cap->titre = "";
			$cap->texte_haut = "";
			$cap->video_script = "";
			$cap->texte_bas = "";
			$cap->url = "";
		}
		else
		{
			$cap->url = config_getvar("url")."/cap/".en_url($cap->url).".html";
		}
?><fieldset>
		<legend>Page "Vidéo"</legend>
		<p><strong>Titre :</strong> <?php print(strip_tags($cap->titre)); ?></p>
		<p><strong>Texte haut :</strong> <?php print(strip_tags($cap->texte_haut)); ?></p>
		<p><strong>Script vidéo :</strong> <?php print(htmlentities($cap->video_script,ENT_COMPAT,"UTF-8")); ?></p>
		<p><strong>Texte bas :</strong> <?php print(strip_tags($cap->texte_bas)); ?></p>
		<p><strong>URL :</strong> <?php print("<a href=\"".$cap->url."\" target=\"_blank\">".$cap->url."</a>"); ?></p>
		<p><input type="button" onclick="document.formul.op.value='video';document.formul.num.value='<?php print($i); ?>';$('#frm').submit();" value="Modifier"></p>
	</fieldset><?php
	}
?><fieldset>
		<legend>Nouvelle page "Vidéo"</legend>
		<p><input type="button" onclick="document.formul.op.value='video';document.formul.num.value='<?php print((4>$cap_nb)?4:$cap_nb); ?>';$('#frm').submit();" value="Ajouter une page de vidéo"></p>
	</fieldset>
</fieldset><?php
	}
	else if ("squeeze" == $op)
	{
		if (("" == $msgErreur) && (false === ($cap = config_getvar("cap_page_0",false))))
		{
			$cap = new StdClass();
			$cap->type = "S";
			$cap->texte_haut = "";
			$cap->video_script = "";
			$cap->autorepondeur_script = "";
			$cap->texte_bas = "";
		}
?><fieldset>
		<legend>Page "Squeeze" => vidéo d'accueil et formulaire d'inscription</legend>
		<p><label for="frmTxtH">Texte en haut de page</label><br />
		<textarea class="miseEnForme" name="texte_haut" id="frmTxtH" cols="80" rows="10"><?php print(htmlentities($cap->texte_haut,ENT_COMPAT,"UTF-8")); ?></textarea></p>
		<p><label for="frmVidScript">Script de votre vidéo</label><br />
		<textarea name="video_script" id="frmVidScript" cols="80" rows="10"><?php print(htmlentities($cap->video_script,ENT_COMPAT,"UTF-8")); ?></textarea></p>
		<p><label for="frmRepScript">Script de votre autorépondeur (formulaire d'inscription)</label><br />
		<textarea name="autorepondeur_script" id="frmRepScript" cols="80" rows="10"><?php print(htmlentities($cap->autorepondeur_script,ENT_COMPAT,"UTF-8")); ?></textarea></p>
		<p><label for="frmTxtB">Texte en bas de page</label><br />
		<textarea class="miseEnForme" name="texte_bas" id="frmTxtB" cols="80" rows="10"><?php print(htmlentities($cap->texte_bas,ENT_COMPAT,"UTF-8")); ?></textarea></p>
		<p><input type="button" onclick="document.formul.op.value='chgsqueeze';document.formul.num.value='0';document.formul.captype.value='<?php print($cap->type); ?>';$('#frm').submit();" value="Enregistrer"> <input type="button" onclick="document.formul.op.value='liste';$('#frm').submit();" value="Annuler"></p>
	</fieldset><?php
	}
	else if ("merci" == $op)
	{
		if (("" == $msgErreur) && (false === ($cap = config_getvar("cap_page_1",false))))
		{
			$cap = new StdClass();
			$cap->type = "M";
			$cap->texte = "";
		}
?><fieldset>
		<legend>Page "Merci" => demande de confirmation d'inscription</legend>
		<p><label for="frmtexte">Texte de la page</label><br />
		<textarea class="miseEnForme" name="texte" id="frmtexte" cols="80" rows="10"><?php print(htmlentities($cap->texte,ENT_COMPAT,"UTF-8")); ?></textarea></p>
		<p><input type="button" onclick="document.formul.op.value='chgmerci';document.formul.num.value='1';document.formul.captype.value='<?php print($cap->type); ?>';$('#frm').submit();" value="Enregistrer"> <input type="button" onclick="document.formul.op.value='liste';$('#frm').submit();" value="Annuler"></p>
	</fieldset><?php
	}
	else if ("deja" == $op)
	{
		if (("" == $msgErreur) && (false === ($cap = config_getvar("cap_page_2",false))))
		{
			$cap = new StdClass();
			$cap->type = "D";
			$cap->texte = "";
		}
?><fieldset>
		<legend>Page "Déjà inscrit" => inscription sur liste déjà faite</legend>
		<p><label for="frmtexte">Texte de la page</label><br />
		<textarea class="miseEnForme" name="texte" id="frmtexte" cols="80" rows="10"><?php print(htmlentities($cap->texte,ENT_COMPAT,"UTF-8")); ?></textarea></p>
		<p><input type="button" onclick="document.formul.op.value='chgdeja';document.formul.num.value='2';document.formul.captype.value='<?php print($cap->type); ?>';$('#frm').submit();" value="Enregistrer"> <input type="button" onclick="document.formul.op.value='liste';$('#frm').submit();" value="Annuler"></p>
	</fieldset><?php
	}
	else if ("reco" == $op)
	{
		if (("" == $msgErreur) && (false === ($cap = config_getvar("cap_page_3",false))))
		{
			$cap = new StdClass();
			$cap->type = "R";
			$cap->email_titre = "";
			$cap->email_texte = "";
		}
?><fieldset>
		<legend>Infos de recommandation par email</legend>
		<p><label for="frmemail_titre">Titre de l'email</label><br />
		<input type="text" name="email_titre" id="frm" value="<?php print(htmlentities($cap->email_titre,ENT_COMPAT,"UTF-8")); ?>"></p>
		<p><label for="frmemail_texte">Texte de l'email</label><br />
		<textarea name="email_texte" id="frmemail_texte" cols="80" rows="10"><?php print(htmlentities($cap->email_texte,ENT_COMPAT,"UTF-8")); ?></textarea></p>
		<p><input type="button" onclick="document.formul.op.value='chgreco';document.formul.num.value='3';document.formul.captype.value='<?php print($cap->type); ?>';$('#frm').submit();" value="Enregistrer"> <input type="button" onclick="document.formul.op.value='liste';$('#frm').submit();" value="Annuler"></p>
	</fieldset><?php
	}
	else if (("video" == $op) && ($num > 3))
	{
		if (("" == $msgErreur) && (false === ($cap = config_getvar("cap_page_".$num,false))))
		{
			$cap = new StdClass();
			$cap->type = "V";
			$cap->titre = "";
			$cap->texte_haut = "";
			$cap->video_script = "";
			$cap->texte_bas = "";
			$cap->url = "";
		}
?><fieldset>
		<legend>Page "Vidéo"</legend>
		<p><label for="frmtitre">Titre de la vidéo</label><br />
		<input type="text" name="titre" id="frmtitre" value="<?php print(htmlentities($cap->titre,ENT_COMPAT,"UTF-8")); ?>"></p>
		<p><label for="frmTxtH">Texte en haut de page</label><br />
		<textarea class="miseEnForme" name="texte_haut" id="frmTxtH" cols="80" rows="10"><?php print(htmlentities($cap->texte_haut,ENT_COMPAT,"UTF-8")); ?></textarea></p>
		<p><label for="frmVidScript">Script d'affichage de la vidéo</label><br />
		<textarea name="video_script" id="frmVidScript" cols="80" rows="10"><?php print(htmlentities($cap->video_script,ENT_COMPAT,"UTF-8")); ?></textarea></p>
		<p><label for="frmTxtB">Texte en bas de page</label><br />
		<textarea class="miseEnForme" name="texte_bas" id="frmTxtB" cols="80" rows="10"><?php print(htmlentities($cap->texte_bas,ENT_COMPAT,"UTF-8")); ?></textarea></p>
		<p><label for="frmurl">URL de la page</label><br />
		<input type="text" name="url" id="frmurl" value="<?php print(htmlentities($cap->url,ENT_COMPAT,"UTF-8")); ?>"></p>
		<p><input type="button" onclick="document.formul.op.value='chgvideo';document.formul.num.value='<?php print($num); ?>';document.formul.captype.value='<?php print($cap->type); ?>';$('#frm').submit();" value="Enregistrer"> <input type="button" onclick="document.formul.op.value='liste';$('#frm').submit();" value="Annuler"></p>
	</fieldset><?php
	}
?></form><script type="text/javascript">
	$(document).ready(function () {
		$('.miseEnForme').ckeditor();
	});
</script><ul>
	<li><a href="<?php print(site_url()); ?>/admin/">Retour au menu principal</a></li>
</ul>