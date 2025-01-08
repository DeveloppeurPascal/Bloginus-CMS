<?php
	// Bloginus
	// (c) Patrick Prémartin / Olf Software 09/2014
	//
	// http://www.bloginus-lescript.fr

	$msgErreur = "";
	$gogo = isset($_POST["gogo"])?trim(strip_tags($_POST["gogo"])):"";
	$dest = isset($_POST["dest"])?trim(strip_tags($_POST["dest"])):"";
	if (is_array($destinataires = config_getvar("contact-destinataires","")))
	{
		if (! isset($destinataires[$dest]))
		{
			$msgErreur .= "Destinataire inconnu. Envoi de message impossible.\n";
		}
	}
	else
	{
		$msgErreur .= "La configuration des destinataires n'a pas encore été faite sur le site. envoi de message impossible.\n";
	}
	$nom = isset($_POST["nom"])?trim(strip_tags($_POST["nom"])):"";
	$msgErreur .= ("" == $nom)?"Merci de renseigner votre nom.\n":"";
	$prenom = isset($_POST["prenom"])?trim(strip_tags($_POST["prenom"])):"";
	$email = isset($_POST["email"])?trim(strip_tags($_POST["email"])):"";
	$msgErreur .= ("" == $email)?"Merci de renseigner votre email.\n":((($erremail = verifie_email($email)) != $email)?"Problème sur votre adresse email. ".$erremail."\n":"");
	$sujet = isset($_POST["sujet"])?trim(strip_tags($_POST["sujet"])):"";
	$message = isset($_POST["message"])?trim(strip_tags($_POST["message"])):"";
	$msgErreur .= ("" == $message)?"Merci de compléter le texte de votre message.\n":"";
	if (("" == $msgErreur) && ("" != $gogo))
	{
		$date = date("YmdHis");
		mail($destinataires[$dest],"[".config_getvar("contact-sujet",config_getvar("titre"))."] ".$dest,"Message en provenance du site ".config_getvar("url")." le ".aaaammjj_to_string($date)." à ".hhmmss_to_string($date)." envoyé depuis l'IP ".$_SERVER["REMOTE_ADDR"]."

Expéditeur :
- nom : ".$nom."
- prénom : ".$prenom."
- email : ".$email."

Objet : ".$sujet."

Message :
".$message,"From: <".$email.">\nReply-To: <".$email.">\n");
		fichier_inclure("contact-ok.php");
	}
	else
	{
		if ("" == $gogo)
		{
			$msgErreur = "";
		}
		fichier_inclure("contact-frm.php");
	}
?>