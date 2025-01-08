<?php
	// thème par défaut, ne pas modifier ce fichier

	if (is_object($plandusite) && isset($plandusite->id))
	{
		$titre_page = "Plan du site";
		fichier_inclure("_header.php");
?><div id="planDuSite"><?php
		function affiche_plan_du_site($noeud)
		{
			$res = "";
			if (isset($noeud->label))
			{
				$res .= "<li>";
				$res .= "<a href=\"".category_url($noeud->id)."\">".$noeud->label."</a>";
				if (isset($noeud->subcat) && is_array($noeud->subcat) && (count($noeud->subcat)>0))
				{
					$res .= "<ul>";
					reset($noeud->subcat);
					while(list($key,$noeud2) = each($noeud->subcat))
					{
						$res .= affiche_plan_du_site($noeud2);
					}
					$res .= "</ul>";
				}
				$res .= "</li>";
			}
			return $res;
		}
		print("<ul>".affiche_plan_du_site($plandusite)."</ul>");
?></div><?php
		fichier_inclure("_footer.php");
	}
	else
	{
		page404();
	}
?>