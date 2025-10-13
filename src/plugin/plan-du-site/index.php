<?php
	// Bloginus CMS
	// (c) 2014-2025 Patrick Prémartin / Olf Software
	//
	// This project is distributed under the AGPLv3 license.
	//
	// Go to this website for the documentation, download latest release,
	// buying a developer pro license or contacting us :
	// https://bloginus.olfsoftware.fr

	function construit_plan_du_site($id)
	{
		$pds = new StdClass();
		$categorie = category_get_infos($id);
		if ($categorie["published"])
		{
			$pds->id = $categorie["id"];
			if (("_" == $categorie["id"]) && ("" == $categorie["label"]))
			{
				$categorie["label"] = "Accueil";
			}
			else if ("" == $categorie["label"])
			{
				$categorie["label"] = "*****";
			}
			$pds->label = $categorie["label"];
			$pds->subcat = array();
			$souscategories = category_get_liste($id);
			if (is_array($souscategories))
			{
				reset($souscategories);
				while(list($key,$souscat) = each($souscategories))
				{
					if ($souscat["published"])
					{
						$pds->subcat[] = construit_plan_du_site($souscat["id"]);
					}
				}
			}
		}
		return $pds;
	}
	
	$plandusite = construit_plan_du_site("_");
	fichier_inclure("plandusite.php");
