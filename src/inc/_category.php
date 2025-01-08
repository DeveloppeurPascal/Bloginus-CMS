<?php
	// Bloginus
	// (c) Patrick Prémartin / Olf Software 06-08/2014
	//
	// http://www.bloginus-lescript.fr

	global $categorie_id, $categorie, $souscategories, $autresarticles;
	$categorie_id = "";
	$categorie = false;
	$souscategories = false;
	$autresarticles = false;

	function category_url($id)
	{
		global $CATEGORY_INFO;
		if (! isset($CATEGORY_INFO[$id]))
		{
			category_get_infos($id);
		}
		if (isset($CATEGORY_INFO[$id]))
		{
			if ("_" == $id)
			{
				return config_getvar("url")."/";
			}
			else if ("" != $CATEGORY_INFO[$id]["url"])
			{
				return config_getvar("url")."/c/".$id."-".en_url($CATEGORY_INFO[$id]["url"]).".html";
			}
			else
			{
				return config_getvar("url")."/c/".$id."-".en_url($CATEGORY_INFO[$id]["label"]).".html";
			}
		}
		else
		{
			return false;
		}
	}
	function category_path($id)
	{
		$path = get_data_path();
		for ($i = 0; $i < strlen($id); $i++)
		{
			$c = substr($id,$i,1);
			if ((($c >= "0") && ($c <= "9")) || (($c >= "a") && ($c <= "z")) || ("_" == $c))
				$path .= "/".$c;
		}
		return $path;
	}
	$CATEGORY_INFO = array();
	function category_get_infos($id)
	{
		global $CATEGORY_INFO;
		if (isset($CATEGORY_INFO[$id]))
		{
			return $CATEGORY_INFO[$id];
		}
		else if (false !== ($res = @file_get_contents(category_path($id)."/category.dta")))
		{
			$CATEGORY_INFO[$id] = unserialize($res);
			return $CATEGORY_INFO[$id];
		}
		else
		{
			return false;
		}
	}
	function category_set_infos($id,$infos)
	{
		global $CATEGORY_INFO;
		$CATEGORY_INFO[$id] = $infos;
		return file_put_contents(creer_dossier(category_path($id))."/category.dta",serialize($CATEGORY_INFO[$id]));
	}
	$CATEGORY_LISTE = array();
	function category_get_liste($id)
	{
		global $CATEGORY_LISTE;
		if (isset($CATEGORY_LISTE[$id]))
		{
			return $CATEGORY_LISTE[$id];
		}
		else if (false !== ($res = @file_get_contents(category_path($id)."/categories.dta")))
		{
			$CATEGORY_LISTE[$id] = unserialize($res);
			return $CATEGORY_LISTE[$id];
		}
		else
		{
			return false;
		}
	}
	function category_set_liste($id,$liste)
	{
		global $CATEGORY_LISTE;
		$CATEGORY_LISTE[$id] = $liste;
		return file_put_contents(creer_dossier(category_path($id))."/categories.dta",serialize($CATEGORY_LISTE[$id]));
	}
?>