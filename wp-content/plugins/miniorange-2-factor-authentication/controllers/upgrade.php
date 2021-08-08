<?php
      	include $mo2f_dirName . 'views'.DIRECTORY_SEPARATOR.'upgrade.php';
		MoWpnsUtility::checkSecurity();
		update_site_option("mo_2fa_pnp",time());