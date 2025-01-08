<!DOCTYPE html>
<html>
<head><?php
	fichier_inclure("_header-meta.php");
?><meta name="viewport" content="width=device-width, initial-scale=1.0"><style>
	body {
		margin: 0px;
		padding: 0px;
	}
	.haut {
		background-image: url(<?php print(site_url()); ?>/cap/images/page_header_bg.png);
		background-repeat: repeat-x;
		border-style: none;
		height: 90px;
		width: 100%;
	}
	.header {
		text-align: center;
		vertical-align: top;
		color: #ffffff;
		font-weight: bold;
		font-size: 1.2em;
	}
	.bloc_txt_haut {
		margin: 1em;
	}
	.bloc_partagez {
		text-align: center;
		font-weight: bold;
		margin: 1em;
	}
	.txt_partagez {
		color: rgb(0, 0, 153);
		font-size: 1.8em;
		padding-bottom: 1em;
	}
	.bloc_txt_centre {
		margin: 1em;
	}
	.bloc_video {
		text-align: center;
		margin: 1em;
	}
	.bloc_txt_bas {
		margin: 1em;
	}
	.footer {
		text-align: center;
		vertical-align: middle;
		color: #ffffff;
		font-weight: bold;
		font-size: 0.8em;
	}
	.footer a {
		color: rgb(204, 204, 204);
	}
	.bas {
		background-image: url(<?php print(site_url()); ?>/cap/images/page_footer_bg.png);
		background-repeat: repeat-x;
		border-style: none;
		height: 270px;
		width: 100%;
	}
</style></head><body>
<table class="haut">
  <tbody>
    <tr>
      <td class="header"><?php print(htmlentities($titre_page,ENT_COMPAT,"UTF-8")); ?></td>
    </tr>
  </tbody>
</table>
