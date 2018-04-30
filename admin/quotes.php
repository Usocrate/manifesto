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
        case 'registerQuote' :
        	$feedback = $manifesto->registerQuote(new Quote($_REQUEST));
            $alerts[$feedback->getType()][]  = $feedback->getMessage();
            break;
        case 'deleteQuote' :
        	$feedback = $manifesto->deleteQuote($_REQUEST['id']);
            $alerts[$feedback->getType()][]  = $feedback->getMessage();
            break;
        default:
        	$alerts['warning'][] = 'commande inconnue';
    }
}

$quotes = $manifesto->getQuotes(null, 'Oldest edition first');
$detachedQuotes = $manifesto->getDetachedQuotes();
$pattern = '[quote] #usocrate https://usocrate.fr';

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
					<li class="breadcrumb-item active" aria-current="page">Les déclarations</li>
				</ol>
			</nav>
			<h1>Les déclarations <small><a href="quote_edit.php"><i class="fa fa-plus"></i></a></small></h1>
		</header>		
		<main>
			<?php echo $h->getAlertsTag($alerts) ?>	
			<ul>
			<?php 
				foreach ($quotes as $q) {
					echo '<li>';
					echo '<h2>'.ucfirst(htmlspecialchars($q->getContent()));
					echo ' <small>';
					echo '<a href="quote_edit.php?id='.$q->getId().'"><i class="fa fa-edit"></i></a>';
					echo '<a href="../quote.php?id='.$q->getId().'"><i class="fa fa-eye"></i></a>';
					echo '</small>';
					if (in_array( $q->getId(), array_keys($detachedQuotes) )) {
						echo '<br><small><span class="badge badge-warning"><a href="quote_edit.php?id='.$q->getId().'">à associer</a></span></small>';
					}					
					echo '</h2>';
					echo '<div>';
					echo '<p>'.nl2br(htmlspecialchars($q->getComment())).'</p>';
					echo '</div>';
					echo '<div>';
					$tweet = mb_eregi_replace('\[quote\]', $q->getContent(), $pattern);
					echo '<p>';
					echo '<i class="fab fa-twitter" style="color:#1da1f2"></i> ';
					echo '<small>';
					echo ucfirst(htmlspecialchars($tweet)).'</small>';
					echo mb_strlen($tweet)>140 ? ' <span class="badge badge-danger">+'.(mb_strlen($tweet)-140).'</span>':' <span class="badge badge-success">-'.(140-mb_strlen($tweet)).'</span>';
					echo '</p>';
					echo '</div>';
					if(!empty($q->getLastEdition())) {
						'<div><p><small>Révisée le '.htmlspecialchars($q->getLastEdition()).'</small></p><div>';
					}
					echo '<div class="cmdbar">';
					echo '<a href="quotes.php?cmd=deleteQuote&id='.$q->getId().'"><i class="fa fa-trash"></i> <span>retirer</span></a>';
					echo '</div>';
					echo '</li>';
				}
			?>
			</ul>
			<?php echo '<div class="cmdbar"><a href="quote_edit.php"><i class="fa fa-plus"></i> <span>Nouvelle déclaration<span></a></div>' ?>
		</main>
		<?php echo $h->getFooterTag() ?>
	</div>
	<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
</body>
</html>