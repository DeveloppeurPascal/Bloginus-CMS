<table class="bas">
  <tbody>
    <tr>
      <td class="footer">
		Tous droits réservés. Reproduction interdite sans accord écrit préalable.<br />
		&copy; <?php print(htmlentities(config_getvar("auteur"),ENT_COMPAT,"UTF-8")); ?> <?php print(($annee = config_getvar("annee",date("Y"))).((date("Y") > $annee)?"-".date("Y"):"")); ?> - Powered by <a href="http://www.bloginus-lescript.fr">Bloginus</a>
      </td>
    </tr>
  </tbody>
</table><?php
	print(config_getvar("stats"));
?></body></html>