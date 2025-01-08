<?php
	// Bloginus
	// (c) Patrick Prémartin / Olf Software 09/2014
	//
	// http://www.bloginus-lescript.fr

	$elem = bloginus_getvar("param");
	if ((3 <= count($elem)) && ("images" == $elem[1]))
	{
		$extension = "";
		$ext = strtolower(pathinfo($elem[count($elem)-1],PATHINFO_EXTENSION));
		if ("gif" == $ext)
			$extension = "gif";
		if ("jpg" == $ext)
			$extension = "jpeg";
		if ("jpeg" == $ext)
			$extension = "jpeg";
		if ("png" == $ext)
			$extension = "png";
		if ("" != $extension)
		{
			if (file_exists(dirname(__FILE__)."/images/".$elem[2]))
			{
				header("content-type: image/".$extension);
				readfile(dirname(__FILE__)."/images/".$elem[2]);
				exit;
			}
		}
	}
	else
	{
		$cap_nb = config_getvar("cap_nb",0);
		if ($cap_nb < 5)
		{ // aucune page de vidéo n'a été configurée
			page404();
		}
		else
		{ // récupération des données des pages du module "cap"
			$cap = new StdClass();
			$cap->email_titre = "";
			$cap->email_texte = "";
			$page_trouvee = false;
			$page_nom = "";
			for ($i = 0; $i < $cap_nb; $i++)
			{
				if (false !== ($page = config_getvar("cap_page_".$i,false)))
				{
					switch ($page->type)
					{
						case "S" : // squeeze page
							if ("" == $elem[1])
							{
								$cap->texte_haut = $page->texte_haut;
								$cap->video_script = $page->video_script;
								$cap->autorepondeur_script = $page->autorepondeur_script;
								$cap->texte_bas = $page->texte_bas;
								$page_trouvee = true;
								$page_nom = "squeeze.php";
							}
							break;
						case "M" : // page merci
							if ("merci.html" == $elem[1])
							{
								$cap->texte = $page->texte;
								$page_trouvee = true;
								$page_nom = "merci.php";
							}
							break;
						case "D" : // page déjà inscrit
							if ("dejainscrit.html" == $elem[1])
							{
								$cap->texte = $page->texte;
								$page_trouvee = true;
								$page_nom = "dejainscrit.php";
							}
							break;
						case "V" : // page vidéo
							if ($page->url.".html" == $elem[1])
							{
								$cap->titre = $page->titre;
								$cap->texte_haut = $page->texte_haut;
								$cap->video_script = $page->video_script;
								$cap->texte_bas = $page->texte_bas;
								$page_trouvee = true;
								$page_nom = "video.php";
							}
							break;
						case "R" : // infos de recommandation (pas de page de recommandation)
							$cap->email_titre = $page->email_titre;
							$cap->email_texte = $page->email_texte;
							break;
					}
				}
			}
			if (($page_trouvee) && ("" != $page_nom) && (file_exists(dirname(__FILE__)."/templates/".$page_nom)))
			{
				require_once(dirname(__FILE__)."/templates/".$page_nom);
			}
			else
			{
				unset($page);
				page404();
			}
		}
	}
?>