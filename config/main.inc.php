<?php
switch ($_SERVER ['SERVER_NAME']) {
	case 'usocrate.fr':
		define ( 'PROJECT_NAME', 'Usocrate.fr' );
		define ( 'PROJECT_DESCRIPTION', 'Manifeste pour l\'usocratie numérique' );
		define ( 'PROJECT_PUBLISHER', 'Usocrate.fr' );
		define ( 'PROJECT_CREATOR', 'Florent Chanavat' );
		define ( 'PROJECT_URL', 'https://usocrate.fr/' );
		define ( 'SKIN_URL', 'https://usocrate.fr/skins/usocrate/' );
		define ( 'BOOKMARKS_URL', 'https://usocrate.fr/em/' );
		define ( 'CV_URL', 'https://usocrate.fr/cv/' );
		/**
		 * Google Analytics
		 */
		define ( 'GA_KEY', 'UA-6475427-3' );
		define ( 'GA_ACCOUNT', 'usocrate.fr' );
		break;
	case 'traktor' :
		define ( 'PROJECT_NAME', 'Usocrate (traktor)' );
		define ( 'PROJECT_DESCRIPTION', 'Manifeste pour l\'usocratie numérique' );
		define ( 'PROJECT_PUBLISHER', 'traktor' );
		define ( 'PROJECT_CREATOR', 'Florent Chanavat' );
		define ( 'PROJECT_URL', 'http://traktor/manifesto/' );
		define ( 'SKIN_URL', 'http://traktor/manifesto/skin/' );
		define ( 'BOOKMARKS_URL', 'http://traktor/em/' );
		define ( 'CV_URL', PROJECT_URL . 'cv/' );
		break;
	case 'chosta' :
			define ( 'PROJECT_NAME', 'Usocrate (chosta)' );
			define ( 'PROJECT_DESCRIPTION', 'Manifeste pour l\'usocratie numérique');
			define ( 'PROJECT_PUBLISHER', 'usocrate' );
			define ( 'PROJECT_CREATOR', 'Florent Chanavat' );
			define ( 'PROJECT_URL', 'http://chosta/manifesto/' );
			define ( 'SKIN_URL', 'http://chosta/manifesto//skins/usocrate/' );
			define ( 'BOOKMARKS_URL', 'http://chosta/em/' );
			define ( 'CV_URL', PROJECT_URL . 'http://chosta/cv/' );
			break;
}
// commun
define ( 'IMAGES_URL', SKIN_URL . 'images/' );
iconv_set_encoding ( 'internal_encoding', 'UTF-8' );
iconv_set_encoding ( 'input_encoding', 'UTF-8' );
iconv_set_encoding ( 'output_encoding', 'UTF-8' );
?>
