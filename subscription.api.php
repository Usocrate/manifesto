<?php
function __autoload($class_name) {
	$path = './classes/';
	if (is_file ( $path . $class_name . '.class.php' )) {
		include_once $path . $class_name . '.class.php';
	} elseif ($path . $class_name . '.interface.php') {
		include_once $path . $class_name . '.interface.php';
	}
}
$env = new Environment ( './config/host.json' );

$output = array();

if (isset($_POST['cmd'])) {
    switch ($_POST['cmd']) {
        case 'subscription' :
            $output  = $env->registerSubscription($_POST['id'],$_POST['mail']);
    }
}
header('Content-type: text/plain; charset=UTF-8');
echo json_encode($output);
?>