<?php
	// thème par défaut, ne pas modifier ce fichier
	
	fichier_inclure("_header.php");
?><div id="postBloc">
	<div id="postText"><?php print($article["text"]); ?></div>
	<div id="postDate">Mis à jour le <?php print(aaaammjjhhmmss_to_string(date("YmdHis",intval($article["timestamp"])))); ?></div>
</div><?php
	fichier_inclure("_footer.php");
?>