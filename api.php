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

if (isset($_REQUEST['cmd'])) {
    
    ToolBox::formatUserPost($_REQUEST);
    
    switch ($_REQUEST['cmd']) {
        case 'registerSubscription' :
            $feedback  = $m->registerSubscription(new Subscription($_REQUEST));
            break;
        case 'registerReference' :
            $feedback = $m->registerReference(new Reference($_REQUEST));
            break;
        case 'getReferenceTitleFromUrl' :
            if (!empty($_REQUEST['url'])) {
                $r = new Reference();
                $r->setUrl($_REQUEST['url']);
                $title = $r->getTitleFromUrl();
                $feedback = new Feedback();
                $feedback->setType('success');
                $feedback->addDatum('title', $title);
            }
            break;
        default :
            $feedback = new Feedback('Commande indéterminée','warning');
    }
} else {
    $feedback = new Feedback('Commande indéterminée','warning');
}
header('Content-type: text/plain; charset=UTF-8');
echo $feedback->toJson();
?>