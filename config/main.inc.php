<?php
switch ($_SERVER ['SERVER_NAME']) {
	case 'usocrate.traktor' :
		define ( 'PROJECT_NAME', 'Usocrate (traktor)' );
		define ( 'PROJECT_DESCRIPTION', 'Site perso de Florent Chanavat' );
		define ( 'PROJECT_PUBLISHER', 'usocrate.traktor' );
		define ( 'PROJECT_CREATOR', 'Florent Chanavat' );
		define ( 'PROJECT_URL', 'http://usocrate.traktor/' );
		define ( 'SKIN_URL', 'http://usocrate.traktor/skins/usocrate/' );
		define ( 'BOOKMARKS_URL', 'http://em.usocrate.traktor/' );
		define ( 'CV_URL', PROJECT_URL . 'cv/' );
		break;
	case 'usocrate.mp110352' :
		define ( 'PROJECT_NAME', 'Usocrate (mp110352)' );
		define ( 'PROJECT_DESCRIPTION', 'Site perso de Florent Chanavat (test)' );
		define ( 'PROJECT_PUBLISHER', 'usocrate.mp110352' );
		define ( 'PROJECT_CREATOR', 'Florent Chanavat' );
		define ( 'PROJECT_URL', 'http://usocrate.mp110352/' );
		define ( 'SKIN_URL', 'http://usocrate.mp110352/skins/usocrate/' );
		define ( 'BOOKMARKS_URL', 'http://em.usocrate.fr/' );
		define ( 'CV_URL', PROJECT_URL . 'cv/' );
		break;
	default :
		define ( 'PROJECT_NAME', 'Usocrate.fr' );
		define ( 'PROJECT_DESCRIPTION', "Le design ce n'est pas du style, c'est de l'usage" );
		define ( 'PROJECT_PUBLISHER', 'Usocrate.fr' );
		define ( 'PROJECT_CREATOR', 'Florent Chanavat' );
		define ( 'PROJECT_URL', 'http://www.usocrate.fr/' );
		define ( 'SKIN_URL', 'http://usocrate.fr/skins/usocrate/' );
		define ( 'BOOKMARKS_URL', 'http://em.usocrate.fr/' );
		define ( 'CV_URL', 'http://cv.usocrate.fr/' );
		/**
		 * Google Analytics
		 */
		define ( 'GA_KEY', 'UA-6475427-3' );
		define ( 'GA_ACCOUNT', 'usocrate.fr' );
}
// commun
define ( 'IMAGES_URL', SKIN_URL . 'images/' );
iconv_set_encoding ( 'internal_encoding', 'UTF-8' );
iconv_set_encoding ( 'input_encoding', 'UTF-8' );
iconv_set_encoding ( 'output_encoding', 'UTF-8' );
?>