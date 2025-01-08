<?php
	$titre_page = $cap->titre;
	require_once(dirname(__FILE__)."/_haut.php");
?><div class="bloc_txt_haut"><?php print($cap->texte_haut); ?></div>
<div class="bloc_partagez">
<p class="txt_partagez">Partagez ces vidéos gratuites avec vos amis !</p>
<p>
<a href="https://www.facebook.com/sharer.php?u=<?php print(urlencode(config_getvar("url")."/cap/")); ?>" title="Recommander ces vidéos sur Facebook" target="_blank"><img src="<?php print(config_getvar("url")); ?>/cap/images/facebook-64x64.png" alt="Facebook" border="0" height="64" width="64" /></a>
<a href="https://twitter.com/intent/tweet?text=<?php print(urlencode("Allez voir ces vidéos gratuites. Elles sont vraiment pleines d'infos utiles !")); ?>&url=<?php print(urlencode(config_getvar("url")."/cap/")); ?>" title="Recommander ces vidéos sur Twitter" target="_blank"><img src="<?php print(config_getvar("url")); ?>/cap/images/twitter-64x64.png" alt="Twitter" border="0" height="64" width="64" /></a>
<a href="mailto:?subject=<?php print(rawurlencode($cap->email_titre)); ?>&body=<?php print(rawurlencode($cap->email_texte)); ?>" title="Recommander ces vidéos par email" target="_blank"><img src="<?php print(config_getvar("url")); ?>/cap/images/email-64x64.png" alt="Email" border="0" height="64" width="64" /></a>
</p></div>
<div class="bloc_video"><?php print($cap->video_script); ?></div>
<div class="bloc_txt_bas"><?php print($cap->texte_bas); ?></div><?php
	require_once(dirname(__FILE__)."/_bas.php");
?>