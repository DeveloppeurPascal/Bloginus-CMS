<?php
	// Bloginus
	// (c) Patrick Prémartin / Olf Software 08/2014
	//
	// http://www.bloginus-lescript.fr

	global $page_id, $page;
	$page_id = "";
	$page = false;

	function page_url($id)
	{
		global $PAGE_INFO;
		if (! isset($PAGE_INFO[$id]))
		{
			page_get_infos($id);
		}
		if (isset($PAGE_INFO[$id]))
		{
			if ("" != $PAGE_INFO[$id]["url"])
			{
				return config_getvar("url")."/page/_".$id."-".en_url($PAGE_INFO[$id]["url"]).".html";
			}
			else
			{
				return config_getvar("url")."/page/_".$id."-".en_url($PAGE_INFO[$id]["label"]).".html";
			}
		}
		else
		{
			return false;
		}
	}
	function page_path()
	{
		return get_data_path()."/pages";
	}
	$PAGE_INFO = array();
	function page_get_infos($id)
	{
		global $PAGE_INFO;
		if (isset($PAGE_INFO[$id]))
		{
			return $PAGE_INFO[$id];
		}
		else if (false !== ($res = @file_get_contents(page_path()."/".$id.".dta")))
		{
			$PAGE_INFO[$id] = unserialize($res);
			return $PAGE_INFO[$id];
		}
		else
		{
			return false;
		}
	}
	function page_set_infos($id,$infos)
	{
		global $PAGE_INFO;
		$PAGE_INFO[$id] = $infos;
		return file_put_contents(creer_dossier(page_path())."/".$id.".dta",serialize($PAGE_INFO[$id]));
	}
	$PAGE_LISTE = array();
	function page_get_liste()
	{
		global $PAGE_LISTE;
		if (isset($PAGE_LISTE) && (count($PAGE_LISTE)>0))
		{
			return $PAGE_LISTE;
		}
		else if (false !== ($res = @file_get_contents(page_path()."/pages.dta")))
		{
			$PAGE_LISTE = unserialize($res);
			return $PAGE_LISTE;
		}
		else
		{
			return false;
		}
	}
	function page_set_liste($liste)
	{
		global $PAGE_LISTE;
		$PAGE_LISTE = $liste;
		return file_put_contents(creer_dossier(page_path())."/pages.dta",serialize($PAGE_LISTE));
	}
?>