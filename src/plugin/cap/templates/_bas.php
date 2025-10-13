<?php
	// Bloginus CMS
	// (c) 2014-2025 Patrick Prémartin / Olf Software
	//
	// This project is distributed under the AGPLv3 license.
	//
	// Go to this website for the documentation, download latest release,
	// buying a developer pro license or contacting us :
	// https://bloginus.olfsoftware.fr

?><table class="bas">
  <tbody>
    <tr>
      <td class="footer">
		Tous droits réservés. Reproduction interdite sans accord écrit préalable.<br />
		&copy; <?php
		print(htmlentities(config_getvar("auteur"),ENT_COMPAT,"UTF-8")." ".($annee = config_getvar("annee",date("Y"))).((date("Y") > $annee)?"-".date("Y"):""));
		if (is_array($destinataires = config_getvar("contact-destinataires","")))
		{
			?> - <a href="<?php print(site_url()); ?>/contact/">Nous contacter</a><?php
		}
	  ?> - <?php print(bloginus_powered_by()); ?>
      </td>
    </tr>
  </tbody>
</table><?php
	print(config_getvar("stats"));
?></body></html>