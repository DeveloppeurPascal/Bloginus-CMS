<?php
	fichier_inclure("_header.php");
?><header>
			<h1><a href="">titre de la page</a></h1>
			<nav class="breadcrumb"><?php
	$fildariane = "";
	$id = (isset($categorie_id))?$categorie_id:"_";
	while (strlen($id) > 0)
	{
		$cat = category_get_infos($id);
		if (("_" == $cat["id"]) && ("" == $cat["label"]))
		{
			$cat["label"] = "Accueil";
		}
		if ($cat["published"])
		{
			$fildariane = "&gt; <a href=\"".category_url($cat["id"])."\">".(("" != trim($cat["label"]))?trim($cat["label"]):"*****")."</a> ".$fildariane;
		}
		$id = substr($id,0,strlen($id)-1);
	}
?><ul>
					<li></li>
					<li></li>
				</ul>
			</nav>
		</header>
		<?php print($article["text"]); ?>
		<footer>
			Mis à jour le <?php print(aaaammjjhhmmss_to_string(date("YmdHis",intval($article["timestamp"])))); ?>
		</footer><?php
	fichier_inclure("_footer.php");
?>