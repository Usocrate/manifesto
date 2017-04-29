<?php
switch ($_SERVER ['SERVER_NAME']) {
	case 'usocrate.fr':
		define ( 'PROJECT_NAME', 'Usocrate.fr' );
		define ( 'PROJECT_DESCRIPTION', 'Manifeste pour l\'usocratie numérique' );
		define ( 'PROJECT_PUBLISHER', 'Usocrate.fr' );
		define ( 'PROJECT_CREATOR', 'Florent Chanavat' );
		define ( 'PROJECT_URL', 'https://usocrate.fr/' );
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
		break;
	case 'chosta' :
		define ( 'PROJECT_NAME', 'Usocrate (chosta)' );
		define ( 'PROJECT_DESCRIPTION', 'Manifeste pour l\'usocratie numérique');
		define ( 'PROJECT_PUBLISHER', 'usocrate' );
		define ( 'PROJECT_CREATOR', 'Florent Chanavat' );
		define ( 'PROJECT_URL', 'http://chosta/manifesto/' );
		break;
	case 'manifesto-usocrate.c9users.io' :
		define ( 'PROJECT_NAME', 'Usocrate (c9)' );
		define ( 'PROJECT_DESCRIPTION', 'Manifeste pour l\'usocratie numérique');
		define ( 'PROJECT_PUBLISHER', 'usocrate' );
		define ( 'PROJECT_CREATOR', 'Florent Chanavat' );
		define ( 'PROJECT_URL', 'https://manifesto-usocrate.c9users.io/' );
		break;			
}
// commun
iconv_set_encoding ( 'internal_encoding', 'UTF-8' );
iconv_set_encoding ( 'input_encoding', 'UTF-8' );
iconv_set_encoding ( 'output_encoding', 'UTF-8' );
?>
