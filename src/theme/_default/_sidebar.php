<?php
	// thème par défaut, ne pas modifier ce fichier
	
	if (isset($souscategories) && is_array($souscategories))
	{
		$visible = false;
		$liste = array();
		foreach ($souscategories as $key=>$value)
		{
			if ($value["published"])
				$liste[] = category_get_infos($value["id"]);
		}
		for ($i =0; $i < count($liste); $i++)
		{
			if (! $visible)
			{
				$visible = true;
?><div id="caterogyListSB">
<h2>Rubriques</h2>
<ul><?php
			}
?><li><a href="<?php print(category_url($liste[$i]["id"])); ?>"><?php print(htmlentities($liste[$i]["label"],ENT_COMPAT,"UTF-8")); ?></a></li><?php
		}
		if ($visible)
		{
?></ul></div><?php
		}
	}
	if (isset($autresarticles) && is_array($autresarticles) && $categorie["published"])
	{
		$visible = false;
		$liste = array();
		foreach ($autresarticles as $key=>$value)
		{
			if ($value["published"])
				$liste[] = post_get_infos($value["id"]);
		}
		for ($i =0; $i < count($liste); $i++)
		{
			if (! $visible)
			{
				$visible = true;
?><div id="postListSB">
<h2>Articles</h2>
<ul><?php
			}
?><li><a href="<?php print(post_url($liste[$i]["id"])); ?>"><?php print(htmlentities($liste[$i]["label"],ENT_COMPAT,"UTF-8")); ?></a></li><?php
		}
		if ($visible)
		{
?></ul></div><?php
		}
	}
	$liens = link_get_liste($categorie["id"]);
	if (isset($liens) && is_array($liens) && $categorie["published"])
	{
		$visible = false;
		$liste = array();
		foreach ($liens as $key=>$value)
		{
			if ($value["published"])
				$liste[] = link_get_infos($value["id"]);
		}
		for ($i =0; $i < count($liste); $i++)
		{
			if (! $visible)
			{
				$visible = true;
?><div id="urlListSB">
<h2>Liens</h2>
<ul><?php
			}
?><li><a href="<?php print($liste[$i]["url"]); ?>"><?php print(htmlentities($liste[$i]["label"],ENT_COMPAT,"UTF-8")); ?></a></li><?php
		}
		if ($visible)
		{
?></ul></div><?php
		}
	}
?>