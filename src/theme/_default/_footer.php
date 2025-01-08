<?php
	// thème par défaut, ne pas modifier ce fichier
?></div><div id="sidebar"><?php
	fichier_inclure("_sidebar.php");
?></div><div class="clear"></div></div><div id="footer"><p>&copy; <?php print(htmlentities(config_getvar("auteur"),ENT_COMPAT,"UTF-8")); ?> <?php print(($annee = config_getvar("annee",date("Y"))).((date("Y") > $annee)?"-".date("Y"):"")); ?> - Powered by <a href="http://www.bloginus-lescript.fr">Bloginus</a></p></div><?php
	print(config_getvar("stats"));
?></body></html>