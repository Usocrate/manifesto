<?php
function __autoload($class_name) {
	$path = './classes/';
	if (is_file ( $path . $class_name . '.class.php' )) {
		include_once $path . $class_name . '.class.php';
	} elseif ($path . $class_name . '.interface.php') {
		include_once $path . $class_name . '.interface.php';
	}
}
$system = new System ( './config/host.json' );

if (isset($_REQUEST['cmd'])) {
    switch ($cmd) {
        case 'subscription' :
            $statement = $system->getPdo()->prepare('INSERT INTO subscription SET id=:id, mail=:mail');
            $statement->bindValue(':id', $_REQUEST['id'], PDO::PARAM_STR);
            $statement->bindValue(':mail', $_REQUEST['mail'], PDO::PARAM_STR);
            $statement->execute();
            break;
    }
}
header('charset=utf-8');
?>