<?php
	// Bloginus
	// (c) Patrick Prémartin / Olf Software 06/2014
	//
	// http://www.bloginus-lescript.fr

	$elem = bloginus_getvar("param");
	require_once(dirname(__FILE__)."/_header.php");
	if (isset($_SESSION["user_connected"]) && ("1" == $_SESSION["user_connected"]))
	{
		$menu = array();
		if ($dossier = opendir(dirname(__FILE__)."/.."))
		{
			while (false !== ($plugin = readdir($dossier)))
			{
				if (("." != substr($plugin,0,1)) && (is_dir(dirname(__FILE__)."/../".$plugin)) && (file_exists(dirname(__FILE__)."/../".$plugin."/admin.php")))
				{
					$menu[] = $plugin;
				}
			}
		}
		sort($menu);
		if (count($menu) > 0)
		{
			print("<div id=\"menu\">");
			while(list($key,$option) = each($menu))
			{
				print("<a href=\"".site_url()."/admin/".$option."/admin.php\">".$option."</a>");
			}
			print("</div>");
		}
		if ((isset($elem[1]) && ("." != substr($elem[1],0,1)) && (file_exists(dirname(__FILE__)."/../".$elem[1]."/admin.php"))))
		{
			require_once(dirname(__FILE__)."/../".$elem[1]."/admin.php");
		}
	}
	else if (file_exists(dirname(__FILE__)."/../user/admin.php"))
	{
		require_once(dirname(__FILE__)."/../user/admin.php");
	}
	require_once(dirname(__FILE__)."/_footer.php");
?>