<?php
	// Bloginus
	// (c) Patrick Prémartin / Olf Software 06-08/2014
	//
	// http://www.bloginus-lescript.fr
	
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
				foreach ($souscategories as $key=>$souscat)
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
?>