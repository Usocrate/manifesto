<?php 
switch($_SERVER['SERVER_ADDR']){
	case '127.0.0.1':
		define ('DB_NAME', 'uf');
		define ('APPLI_DIR', 'c:/travail/perso/user-factory/sacerdoce/');
		//define ('DB_NAME', 'sacerdoce');
		//define ('APPLI_DIR', 'C:/Program Files/EasyPHP/www/user-factory/sacerdoce/');
		define ('DB_TABLE_PREFIX', 'sdc');
		define ('DB_USER', 'root');
		define ('DB_PASSWORD', '');
		define ('DB_HOST', 'localhost');
		define ('APPLI_URL','http://localhost/user-factory/sacerdoce/');
		break;
	default :
		define ('DB_NAME', 'usocratefr');
		define ('DB_TABLE_PREFIX', 'sdc');
		define ('DB_USER', 'usocratefr');
		define ('DB_PASSWORD', 'tcIhToEg');
		define ('DB_HOST', 'sql1.usocrate.fr');
		define ('APPLI_DIR', $_SERVER['DOCUMENT_ROOT'].'/var/www/sites/usocrate.fr/public_html/sacerdoce/');
		define ('APPLI_URL','http://sacerdoce.usocrate.fr/');
}
define ('APPLI_NOM', 'Mes Classes');
define ('APPLI_VERSION', '2.00');
define ('CSS_URL', APPLI_URL.'css/');
define ('IMAGES_URL', APPLI_URL.'images/');

define ('CLASS_DIR', APPLI_DIR.'class/');
?>