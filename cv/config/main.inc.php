<?php
switch ($_SERVER['SERVER_NAME']) {
	case 'cv.usocrate.fr' :
		define('SKIN_URL', '/skin/');
		/**
		 * Google Analytics
		 */
		define('GA_KEY', 'UA-6475427-1');
		define('GA_ACCOUNT', 'usocrate.fr');
		break;
	default :
		define('SKIN_URL', '../skins/cv/');
}
?>