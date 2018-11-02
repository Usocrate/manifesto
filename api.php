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
            $feedback  = $m->registerSubscription(new Subscription($_POST));
            $output = array();
            $output['type'] = $feedback->getType();
            $output['message'] = $feedback->getMessage();
            break;
        case 'registerReference' :
            $feedback  = $m->registerReference(new Reference($_POST));
            break;            
    }
}
header('Content-type: text/plain; charset=UTF-8');
echo json_encode($output);
?>