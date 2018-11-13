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
$manifesto = new Manifesto($env);

$alerts = array();

if (isset($_REQUEST['cmd'])) {
	
	ToolBox::formatUserPost($_REQUEST);
	//print_r($_REQUEST);
	
	switch ($_POST['cmd']) {
        case 'registerSubscription' :
        	// enregistrement des données de la souscription
        	$feedback = $manifesto->registerSubscription(new Subscription($_REQUEST));
            $alerts[$feedback->getType()][]  = $feedback->getMessage();
            break;
        default:
        	$alerts['warning'] = 'commande inconnue';
    }
}


if (!isset($subscription)) {
	if (!empty($_REQUEST['id'])) {
		$subscription = $manifesto->getSubscription($_REQUEST['id']);
	} else {
		$subscription = new Subscription;
	}	
}

$doc_title = $subscription->hasId() ? 'Matricule n°'.ucfirst($subscription->getId()) : 'Nouvelle Souscription';

header('charset=utf-8');
?>
<!doctype html>
<html lang="fr">
<head>
	<meta charset="UTF-8">	
	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<meta name="description" content="<?php echo ToolBox::toHtml($env->getProjectDescription()) ?>" />
	<title><?php echo ToolBox::toHtml($env->getProjectName()) ?></title>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="../skin/home.css" />
	<?php echo $env->writeHtmlHeadTagsForFavicon(); ?>
</head>
<body id="references-doc">
	<div class="container">
		<header>
			<nav aria-label="breadcrumb" role="navigation">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="../index.php">Manifesto</a></li>
					<li class="breadcrumb-item"><a href="index.php">Administration</a></li>
					<li class="breadcrumb-item"><a href="subscriptions.php">Les souscriptions</a></li>
					<li class="breadcrumb-item active" aria-current="page"><?php echo ToolBox::toHtml($doc_title) ?></li>
				</ol>
			</nav>
			<h1><?php echo ToolBox::toHtml($doc_title) ?></h1>
		</header>
		<main>
		<?php echo $h->getAlertsTag($alerts) ?>
		<form method="post" action="subscriptions.php">
			<input type="hidden" name="cmd" value="registerSubscription" />
			<input type="hidden" name="id" value="<?php echo $subscription->getId() ?>" />
			<div class="form-group">
				<label for="introduction_i">Introduction du souscripteur</label>
				<textarea id="introduction_i" name="introduction" class="form-control" cols="140" rows="3"><?php echo $subscription->getIntroduction() ?></textarea>
			</div>
			<div class="form-group">
				<label for="email_i">Email</label>
				<input type="email" id="email_i" name="email" class="form-control" rows="140" value="<?php echo ToolBox::toHtml($subscription->getEmail()) ?>"></input>
			</div>
			<div class="form-group">
				<label for="timestamp_i">Timestamp</label>
				<input type="text" id="timestamp_i" name="timestamp" class="form-control" rows="140" value="<?php echo ToolBox::toHtml($subscription->getTimestamp()) ?>"></input>
			</div>			
			<button type="submit" class="btn btn-primary">Enregistrer</button>
		</form>
		</main>
		<?php echo $h->getFooterTag() ?>
	</div>
	<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
</body>
</html>