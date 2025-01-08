<?php
	fichier_inclure("_header.php");
	?><div class="blog-post"><?php print($categorie["text"]); ?></div><?php
	if (isset($autresarticles) && is_array($autresarticles) && $categorie["published"] && (! (isset($article) && is_array($article))))
	{
		$liste = array();
		reset($autresarticles);
		while (list($key,$value)=each($autresarticles))
		{
			if ($value["published"])
				$liste[] = post_get_infos($value["id"]);
		}
		for ($i =0; $i < count($liste); $i++)
		{
			?><div class="blog-post"><h2 class="blog-post-title"><a href="<?php print(post_url($liste[$i]["id"])); ?>"><?php print(htmlentities($liste[$i]["label"],ENT_COMPAT,"UTF-8")); ?></a></h2>
            <p class="blog-post-meta"><?php print(aaaammjjhhmmss_to_string(date("YmdHis",intval($liste[$i]["timestamp"])))); ?></p><?php print(substr(strip_tags($liste[$i]["text"]),0,255)); ?> (<a href="<?php print(post_url($liste[$i]["id"])); ?>" title="lire la suite">...</a>)</div><?php
		}
	}
	fichier_inclure("_footer.php");
?>