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
	
	switch ($_REQUEST['cmd']) {
        default:
        	$alerts['warning'][] = 'commande inconnue';
    }
}

$commitments = $manifesto->getCommitments();
$detachedQuotes = $manifesto->getDetachedQuotes();
if (count($detachedQuotes) > 0) {
	$alerts['info'][] = '<a href="quotes.php">'.count($detachedQuotes).' déclarations</a> ne sont associées à aucun engagement.';
}

header('charset=utf-8');
?>
<!doctype html>
<html lang="fr">
<head>
	<meta charset="UTF-8">	
	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<meta name="description" content="<?php echo htmlspecialchars($env->getProjectDescription()) ?>" />
	<title><?php echo htmlspecialchars($env->getProjectName()) ?></title>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link href="../skin/home.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div class="container">
		<header>
			<nav aria-label="breadcrumb" role="navigation">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="../index.php">Manifesto</a></li>
					<li class="breadcrumb-item"><a href="index.php">Administration</a></li>
					<li class="breadcrumb-item active" aria-current="page">Les engagements</li>
				</ol>
			</nav>
			<h1>Les engagements <small><a href="commitment_edit.php"><i class="fa fa-plus"></i></a></small></h1>
		</header>		
		<main>
			<?php echo $h->getAlertsTag($alerts) ?>	
			<ul>
			<?php 
				foreach ($commitments as $c) {
					echo '<li>';
					echo '<h2>'.ucfirst(htmlspecialchars($c->getTitle())).'</h2>';
					$quotes = $manifesto->getCommitmentQuotes($c);
					if (count($quotes)>0) {
						echo '<ol>';
						foreach ($quotes as $q) {
							echo '<li>'.htmlspecialchars($q->getContent()).'</li>';
						}
						echo '</ol>';
					}
					echo '</li>';
				}
			?>
			</ul>
		</main>
		<?php echo $h->getFooterTag() ?>
	</div>
	<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
</body>
</html>