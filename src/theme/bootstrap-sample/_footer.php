        </div><!-- /.blog-main -->
        <div class="col-sm-3 col-sm-offset-1 blog-sidebar"><?php
	// bloc d'info en haut de sidebar
	if (isset($categorie) && is_array($categorie) && $categorie["published"])
	{
		if (isset($article) && is_array($article))
		{ // infos sur la catégorie en cours lorsqu'on est sur un article
			?><div class="sidebar-module sidebar-module-inset"><h4><?php print($categorie["label"]); ?></h4><?php print(substr(strip_tags($categorie["text"]),0,255)); ?> (<a href="<?php print(category_url($categorie["id"])); ?>" title="lire la suite">...</a>)</div><?php
		}
		else if (strlen($categorie["id"])>1)
		{ // infos sur la catégorie mère si on est sur une catégorie fille
			$mere = category_get_infos(substr($categorie["id"],0,strlen($categorie["id"])-1));
			if ($mere["published"])
			{
				?><div class="sidebar-module sidebar-module-inset"><h4><?php print($mere["label"]); ?></h4><?php print(substr(strip_tags($mere["text"]),0,255)); ?> (<a href="<?php print(category_url($mere["id"])); ?>" title="lire la suite">...</a>)</div><?php
			}
		}
	}
	// sous-rubriques de la rubrique en cours
	if (isset($souscategories) && is_array($souscategories))
	{
		$visible = false;
		$liste = array();
		foreach ($souscategories as $key=>$value)
		{
			if ($value["published"])
				$liste[] = category_get_infos($value["id"]);
		}
		for ($i =0; $i < count($liste); $i++)
		{
			if (! $visible)
			{
				$visible = true;
				?><div class="sidebar-module"><h4>Plus d'infos</h4><ol class="list-unstyled"><?php
			}
			?><li><a href="<?php print(category_url($liste[$i]["id"])); ?>"><?php print(htmlentities($liste[$i]["label"],ENT_COMPAT,"UTF-8")); ?></a></li><?php
		}
		if ($visible)
		{
		?></ol></div><?php
		}
	}
	// autres articles de la rubrique
	if (isset($autresarticles) && is_array($autresarticles) && $categorie["published"] && isset($article) && is_array($article))
	{
		$visible = false;
		$liste = array();
		foreach ($autresarticles as $key=>$value)
		{
			if ($value["published"])
				$liste[] = post_get_infos($value["id"]);
		}
		for ($i =0; $i < count($liste); $i++)
		{
			if (! $visible)
			{
				$visible = true;
				?><div class="sidebar-module"><h4>Sur le même thème</h4><ol class="list-unstyled"><?php
			}
			?><li><a href="<?php print(post_url($liste[$i]["id"])); ?>"><?php print(htmlentities($liste[$i]["label"],ENT_COMPAT,"UTF-8")); ?></a></li><?php
		}
		if ($visible)
		{
			?></ol></div><?php
		}
	}
	// liens liés à la rubrique
	$liens = link_get_liste($categorie["id"]);
	if (isset($liens) && is_array($liens) && $categorie["published"])
	{
		$visible = false;
		$liste = array();
		foreach ($liens as $key=>$value)
		{
			if ($value["published"])
				$liste[] = link_get_infos($value["id"]);
		}
		for ($i =0; $i < count($liste); $i++)
		{
			if (! $visible)
			{
				$visible = true;
				?><div class="sidebar-module"><h4>Sur le web</h4><ol class="list-unstyled"><?php
			}
			?><li><a href="<?php print($liste[$i]["url"]); ?>"><?php print(htmlentities($liste[$i]["label"],ENT_COMPAT,"UTF-8")); ?></a></li><?php
		}
		if ($visible)
		{
			?></ol></div><?php
		}
	}
?>
        </div><!-- /.blog-sidebar -->
      </div><!-- /.row -->
    </div><!-- /.container -->
    <footer class="blog-footer">
      <p><a href="<?php print(site_url()); ?>/plan-du-site/">Plan du site</a><?php
		if (is_array($destinataires = config_getvar("contact-destinataires","")))
		{
			?> - <a href="<?php print(site_url()); ?>/contact/">Nous contacter</a><?php
		}
	  ?><br />
	  <?php print(bloginus_powered_by()); ?> &amp; <a href="http://getbootstrap.com">Bootstrap</a> (adapté depuis un thème de <a href="https://twitter.com/mdo">@mdo</a>)<br />
	  &copy; <?php print(htmlentities(config_getvar("auteur"),ENT_COMPAT,"UTF-8")." ".($annee = config_getvar("annee",date("Y"))).((date("Y") > $annee)?"-".date("Y"):"")); ?></p>
      <p><a href="#">Retour en haut de page</a></p>
    </footer>
    <script src="<?php print(site_url()); ?>/js/jquery.min.js"></script>
    <script src="<?php print(site_url()); ?>/js/bootstrap.min.js"></script>
    <script src="<?php print(site_url()); ?>/js/ie10-viewport-bug-workaround.js"></script><?php
	print(config_getvar("stats"));
	if (defined("HIGHLIGHTJS") && constant("HIGHLIGHTJS"))
	{
?><script>
	$(document).ready(function() {
	  $('pre code').each(function(i, block) {
		hljs.highlightBlock(block);
	  });
	});
</script><?php
	}
?></body></html>