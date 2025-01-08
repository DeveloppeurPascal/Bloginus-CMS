<?php
	fichier_inclure("_header.php");
?><div class="blog-post">
            <p class="blog-post-meta"><?php print(aaaammjjhhmmss_to_string(date("YmdHis",intval($article["timestamp"])))); ?></p><?php print($article["text"]); ?></div>
          <nav>
            <ul class="pager"><?php
	$article_precedent = array("id"=>"");
	$article_suivant = array("id"=>"");
	$niveau = -1;
	$sortie = false;
	foreach ($autresarticles as $key=>$value)
	{
		if ($sortie) break;
		if ($value["published"])
		{
			if ($value["id"] != $article["id"])
			{
				switch ($niveau)
				{
					case -1:
						$article_precedent = post_get_infos($value["id"]);
						break;
					case 1:
						$article_suivant = post_get_infos($value["id"]);
						$sortie = true;
				}
			}
			else
			{
				$niveau = 1;
			}
		}
	}
	if ("" !== $article_precedent["id"])
	{
		?><li><a href="<?php print(post_url($article_precedent["id"])); ?>" rel="prev" title="<?php print(htmlentities($article_precedent["label"],ENT_COMPAT,"UTF-8")); ?>">Précédent</a></li><?php
	}
	if ("" !== $article_suivant["id"])
	{
		?><li><a href="<?php print(post_url($article_suivant["id"])); ?>" rel="next" title="<?php print(htmlentities($article_suivant["label"],ENT_COMPAT,"UTF-8")); ?>">Suivant</a></li><?php
	}
?></ul>
          </nav><?php
	fichier_inclure("_footer.php");
?>