<?php
	// Bloginus
	// (c) Patrick Prémartin / Olf Software 06-08/2014
	//
	// http://www.bloginus-lescript.fr

	global $article_id, $article;
	$article_id = "";
	$article = false;

	function post_url($id)
	{
		global $POST_INFO;
		if (! isset($POST_INFO[$id]))
		{
			post_get_infos($id);
		}
		if (isset($POST_INFO[$id]))
		{
			if ("_" == $id)
			{
				return config_getvar("url")."/";
			}
			else if ("" != $POST_INFO[$id]["url"])
			{
				return config_getvar("url")."/p/".$id."-".en_url($POST_INFO[$id]["url"]).".html";
			}
			else
			{
				return config_getvar("url")."/p/".$id."-".en_url($POST_INFO[$id]["label"]).".html";
			}
		}
		else
		{
			return false;
		}
	}
	function post_path($id)
	{
		$id = post_get_category_id($id);
		$path = get_data_path();
		for ($i = 0; $i < strlen($id); $i++)
		{
			$c = substr($id,$i,1);
			if ((($c >= "0") && ($c <= "9")) || (($c >= "a") && ($c <= "z")) || ("_" == $c))
				$path .= "/".$c;
		}
		return $path;
	}
	$POST_INFO = array();
	function post_get_infos($id)
	{
		global $POST_INFO;
		if (isset($POST_INFO[$id]))
		{
			return $POST_INFO[$id];
		}
		else if (false !== ($res = @file_get_contents(post_path($id)."/".post_get_id($id)."-post.dta")))
		{
			$POST_INFO[$id] = unserialize($res);
			return $POST_INFO[$id];
		}
		else
		{
			return false;
		}
	}
	function post_set_infos($id,$infos)
	{
		global $POST_INFO;
		$POST_INFO[$id] = $infos;
		return file_put_contents(creer_dossier(post_path($id))."/".post_get_id($id)."-post.dta",serialize($POST_INFO[$id]));
	}
	$POST_LISTE = array();
	function post_get_liste($category_id)
	{
		global $POST_LISTE;
		if (isset($POST_LISTE[$category_id]))
		{
			return $POST_LISTE[$category_id];
		}
		else if (false !== ($res = @file_get_contents(category_path($category_id)."/posts.dta")))
		{
			$POST_LISTE[$category_id] = unserialize($res);
			return $POST_LISTE[$category_id];
		}
		else
		{
			return false;
		}
	}
	function post_set_liste($category_id,$liste)
	{
		global $POST_LISTE;
		$POST_LISTE[$category_id] = $liste;
		return file_put_contents(creer_dossier(category_path($category_id))."/posts.dta",serialize($POST_LISTE[$category_id]));
	}
	function post_get_category_id($id)
	{
		return substr($id,0,strlen($id)-3);
	}
	function post_get_id($id)
	{
		return substr($id,strlen($id)-3,3);
	}
	function post_id_create($num,$categorie_id)
	{
		return $categorie_id.entier_vers_base36($num,3);
	}
?>