<?php
function __autoload($class_name) {
	$path = './classes/';
	if (is_file ( $path . $class_name . '.class.php' )) {
		include_once $path . $class_name . '.class.php';
	} elseif ($path . $class_name . '.interface.php') {
		include_once $path . $class_name . '.interface.php';
	}
}

//session_start();

$env = new Environment ( './config/host.json' );
$m = new Manifesto($env);

$output = array();

if (isset($_POST['cmd'])) {
    
    ToolBox::formatUserPost($_POST);
    
    switch ($_POST['cmd']) {
        case 'registerSubscription' :
            $output  = $m->registerSubscription($_POST['id'],$_POST['mail']);
            break;
        case 'registerReference' :
        	$reference = new Reference($_POST);
            $feedback  = $m->registerReference($reference);
            $output = $feedback->getMessage();
            break;            
    }
}
header('Content-type: text/plain; charset=UTF-8');
echo json_encode($output);
?>