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

$output = array();

if (isset($_POST['cmd'])) {
    switch ($_POST['cmd']) {
        case 'subscription' :
            $statement = $system->getPdo()->prepare('INSERT INTO subscription SET id=:id, mail=:mail');
            $statement->bindValue(':id', $_POST['id'], PDO::PARAM_STR);
            $statement->bindValue(':mail', $_POST['mail'], PDO::PARAM_STR);
            if ($statement->execute()) {
                $output['success'] = true;
                $output['message'] = 'Bienvenue camarade usocrate.';
            }
            break;
    }
}
header('Content-type: text/plain; charset=UTF-8');
echo json_encode($output);
?>