<?php
function __autoload($class_name) {
	$path = '../classes/';
	if (is_file ( $path . $class_name . '.class.php' )) {
		include_once $path . $class_name . '.class.php';
	} elseif ($path . $class_name . '.interface.php') {
		include_once $path . $class_name . '.interface.php';
	}
}
$env = new Environment ( '../config/host.json' );
$h = new HtmlFactory($env);
$m = new Manifesto($env);

if (isset($_POST['cmd'])) {
	
	ToolBox::formatUserPost($_POST);
	
	switch ($_POST['cmd']) {
	    case 'registerSubscription' :
	    	// enregistrement des données de la souscription
	    	$feedback = $m->registerSubscription(new Subscription($_POST));
	        $alerts[$feedback->getType()][]  = $feedback->getMessage();
	        break;
	    default:
	    	$alerts['warning'] = 'commande inconnue';
	}	
}

if (isset($_REQUEST['requestedStatus']) && in_array($_REQUEST['requestedStatus'],Subscription::getStatusOptions())) {
    $requestedStatus = $_REQUEST['requestedStatus'];
} else {
    $requestedStatus = 'to check';
}
$criteria = array('status'=>$requestedStatus);
$subscriptions = $m->getSubscriptions($criteria);

header('charset=utf-8');
?>
<!doctype html>
<html lang="fr">
<head>
	<meta charset="UTF-8">	
	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" />
	<meta name="description" content="<?php echo ToolBox::toHtml($env->getProjectDescription()) ?>" />
	<title><?php echo ToolBox::toHtml($env->getProjectName()) ?></title>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link href="../skin/home.css" rel="stylesheet" type="text/css">
	<?php echo $env->writeHtmlHeadTagsForFavicon(); ?>
</head>
<body id="subscriptions-doc">
	<div class="container">
		<header>
			<nav aria-label="breadcrumb" role="navigation">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="../index.php">Manifesto</a></li>
					<li class="breadcrumb-item"><a href="index.php">Administration</a></li>
					<li class="breadcrumb-item active" aria-current="page">Souscriptions</li>
				</ol>
			</nav>
			<h1>Usocrates</h1>
		</header>
		<main>
			<?php
    			if (isset($alerts)) {
    			    echo $h->getAlertsTag($alerts);
    			}
			?>
		
			<form class="form-inline">
        		<label for="status-i">Statut</label>
        		<select id="status-i" name="requestedStatus" class="form-control ml-2" onchange="this.form.submit()">
        		<?php
        		 $options = Subscription::getStatusOptions();
        		 
        		 foreach ($options as $label=>$value) {
        		     echo '<option value="'.$value.'"';
        		     if (isset($requestedStatus) && strcmp($requestedStatus, $value)==0) {
        		         echo ' selected';
        		     }
        		     echo '>'.Toolbox::toHtml($label).'</option>';
        		 }
        		 ?>
        		</select>
			</form>			
			
			<?php
			//print_r($subscriptions);
			foreach ($subscriptions as $s) {
				echo '<h2>Matricule n°'.ToolBox::toHtml($s['id']);
				echo ' <a href="subscription_edit.php?id='.urlencode($s['id']).'"><i class="fas fa-edit"></i></a>';
				echo '</h2>';
				if (!empty($s['email'])) echo '<p><a href="mailto:'.$s['email'].'">'.$s['email'].'</a><p>';
				echo '<p>'.ToolBox::toHtml($s['introduction']).'</p>';
				echo '<p><small>Usocrate depuis le '.$s['timestamp'].'</small></p>';
				echo '<div class="checkingArea">';
				echo strcmp($s['status'], 'rejected')==0 ? '<span class="negativelyActive"><i class="fas fa-ban"></i> rejetée</span>' : '<i class="fas fa-ban"></i> rejetée';
				echo ' | ';
				echo strcmp($s['status'], 'validated')==0 ? '<span class="positivelyActive"><i class="fas fa-check"></i> validée</span>' : '<i class="fas fa-check"></i> validée';
				echo '</div>';
			}
			?>
		</main>
		<?php echo $h->getFooterTag() ?>
	</div>
	<script defer="" src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
	<script>$(document).ready(function(){});</script>
</body>
</html>