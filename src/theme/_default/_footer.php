<?php
	// thème par défaut, ne pas modifier ce fichier
?></div><div id="sidebar"><?php
	fichier_inclure("_sidebar.php");
?></div><div class="clear"></div></div><div id="footer"><p><a href="<?php print(site_url()); ?>/plan-du-site/">Plan du site</a><?php
		if (is_array($destinataires = config_getvar("contact-destinataires","")))
		{
			?> - <a href="<?php print(site_url()); ?>/contact/">Nous contacter</a><?php
		}
	  ?><br />&copy; <?php print(htmlentities(config_getvar("auteur"),ENT_COMPAT,"UTF-8")); ?> <?php print(($annee = config_getvar("annee",date("Y"))).((date("Y") > $annee)?"-".date("Y"):"")); ?> - <?php print(bloginus_powered_by()); ?></p></div><?php
	print(config_getvar("stats"));
?></body></html>