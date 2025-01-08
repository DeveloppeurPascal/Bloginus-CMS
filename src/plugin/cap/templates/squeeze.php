<?php
	$titre_page = "";
	require_once(dirname(__FILE__)."/_haut.php");
?><div class="bloc_txt_haut"><?php print($cap->texte_haut); ?></div>
<table class="bloc_sqz">
	<tr>
		<td rowspan="2" class="bloc_sqz_gauche"><?php print($cap->video_script); ?></td><td class="bloc_sqz_droite"><img style="width: 273px; height: 114px;" src="<?php print(site_url()); ?>/cap/images/fleche-bas.gif"></td>
	</tr>
	<tr><td class="bloc_sqz_droite"><?php print($cap->autorepondeur_script); ?></td></tr>
</table>
<div class="bloc_txt_bas"><?php print($cap->texte_bas); ?></div><?php
	require_once(dirname(__FILE__)."/_bas.php");
?>