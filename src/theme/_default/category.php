<?php
	// thème par défaut, ne pas modifier ce fichier
	
	fichier_inclure("_header.php");
?><div id="categoryText"><?php print($categorie["text"]); ?></div><div id="postListe"><?php
	for ($i = 0; $i < count($autresarticles); $i++)
	{
		if ($autresarticles[$i]["published"])
		{
			if (false !== ($article = post_get_infos($autresarticles[$i]["id"])))
			{
?><div id="postBloc">
	<h2 id="postTitre"><a href="<?php print(post_url($article["id"])); ?>"><?php print($article["label"]); ?></a></h2>
	<div id="postText"><p><?php print(substr(strip_tags($article["text"]),0,255)); ?>... (<a href="<?php print(post_url($article["id"])); ?>">lire la suite</a>)</p></div>
	<div id="postDate">Mis à jour le <?php print(aaaammjjhhmmss_to_string(date("YmdHis",intval($article["timestamp"])))); ?></div>
</div><?php
			}
		}
	}
?></div><?php
	fichier_inclure("_footer.php");
?>