<?php
	// Bloginus
	// (c) Patrick Prémartin / Olf Software 09/2014
	//
	// http://www.bloginus-lescript.fr

	global $lien_id, $lien;
	$lien_id = "";
	$lien = false;

	function link_path($id)
	{
		$id = link_get_category_id($id);
		$path = get_data_path();
		for ($i = 0; $i < strlen($id); $i++)
		{
			$c = substr($id,$i,1);
			if ((($c >= "0") && ($c <= "9")) || (($c >= "a") && ($c <= "z")) || ("_" == $c))
				$path .= "/".$c;
		}
		return $path;
	}
	$LINK_INFO = array();
	function link_get_infos($id)
	{
		global $LINK_INFO;
		if (isset($LINK_INFO[$id]))
		{
			return $LINK_INFO[$id];
		}
		else if (false !== ($res = @file_get_contents(link_path($id)."/".link_get_id($id)."-link.dta")))
		{
			$LINK_INFO[$id] = unserialize($res);
			return $LINK_INFO[$id];
		}
		else
		{
			return false;
		}
	}
	function link_set_infos($id,$infos)
	{
		global $LINK_INFO;
		$LINK_INFO[$id] = $infos;
		return file_put_contents(creer_dossier(link_path($id))."/".link_get_id($id)."-link.dta",serialize($LINK_INFO[$id]));
	}
	$LINK_LISTE = array();
	function link_get_liste($category_id)
	{
		global $LINK_LISTE;
		if (isset($LINK_LISTE[$category_id]))
		{
			return $LINK_LISTE[$category_id];
		}
		else if (false !== ($res = @file_get_contents(category_path($category_id)."/links.dta")))
		{
			$LINK_LISTE[$category_id] = unserialize($res);
			return $LINK_LISTE[$category_id];
		}
		else
		{
			return false;
		}
	}
	function link_set_liste($category_id,$liste)
	{
		global $LINK_LISTE;
		$LINK_LISTE[$category_id] = $liste;
		return file_put_contents(creer_dossier(category_path($category_id))."/links.dta",serialize($LINK_LISTE[$category_id]));
	}
	function link_get_category_id($id)
	{
		return substr($id,0,strlen($id)-3);
	}
	function link_get_id($id)
	{
		return substr($id,strlen($id)-3,3);
	}
	function link_id_create($num,$categorie_id)
	{
		return $categorie_id.entier_vers_base36($num,3);
	}
?>