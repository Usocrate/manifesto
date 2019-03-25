<?php
function __autoload($class_name) {
	$path = '../classes/';
	if (is_file ( $path . $class_name . '.class.php' )) {
		include_once $path . $class_name . '.class.php';
	} elseif ($path . $class_name . '.interface.php') {
		include_once $path . $class_name . '.interface.php';
	}
}
$env = new Environment('../config/host.json');
$h = new HtmlFactory($env);
$manifesto = new Manifesto($env);

if (isset($_REQUEST['cmd'])) {
	
	ToolBox::formatUserPost($_REQUEST);
	
	switch ($_REQUEST['cmd']) {
		case 'quoteUp';
			//$alerts['info'][] = 'Une déclaration à remonter';
			if (!empty($_REQUEST['q_id']) && !empty($_REQUEST['t_id']) && !empty($_REQUEST['c_id'])) {
				$q = $manifesto->getQuote($_REQUEST['q_id']);
				$t = $manifesto->getQuote($_REQUEST['t_id']);					
				$c = $manifesto->getCommitment($_REQUEST['c_id']);
				$fb = $manifesto->placeQuoteBeforeAnotherInCommitment($q, $t, $c);
				if (is_a($fb, 'Feedback')) {
					$alerts[$fb->getType()][] = $fb->getMessage();
				}
			}
			break;
		case 'placeQuote';
			if (!empty($_REQUEST['q_id']) && !empty($_REQUEST['c_id'])) {
				$q = $manifesto->getQuote($_REQUEST['q_id']);
				$c = $manifesto->getCommitment($_REQUEST['c_id']);
				$fb = $manifesto->placeQuoteInCommitment($q, $c);
				if (is_a($fb, 'Feedback')) {
					$alerts[$fb->getType()][] = $fb->getMessage();
				}
			}
			break;
        default:
        	$alerts['warning'][] = 'commande inconnue';
    }
}

$commitment = $manifesto->getCommitment($_REQUEST['c_id']);

header('charset=utf-8');
?>
<!doctype html>
<html lang="fr">
<head>
	<meta charset="UTF-8">	
	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<meta name="description" content="<?php echo ToolBox::toHtml($env->getProjectDescription()) ?>" />
	<title><?php echo ToolBox::toHtml($env->getProjectName()) ?></title>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link href="../skin/home.css" rel="stylesheet" type="text/css">
	<?php echo $env->writeHtmlHeadTagsForFavicon(); ?>
</head>
<body>
	<div class="container">
		<header>
			<nav aria-label="breadcrumb" role="navigation">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="../index.php">Manifesto</a></li>
					<li class="breadcrumb-item"><a href="index.php">Administration</a></li>
					<li class="breadcrumb-item"><a href="commitments.php">Les engagements</a></li>
					<li class="breadcrumb-item active"><?php echo ucfirst(ToolBox::toHtml($commitment->getTitle())) ?></li>
				</ol>
			</nav>
			<h1><?php echo ucfirst(ToolBox::toHtml($commitment->getTitle())) ?> <small><a href="commitment_edit.php?c_id=<?php echo $commitment->getId() ?>"><i class="fa fa-edit"></i></a></small></h1>
		</header>		
		<main>
			<?php 
				$quotes = $manifesto->getCommitmentQuotes($commitment);
				
				$toPlace = array();
				$placed = array();
				
				foreach ($quotes as $q) {
					$p = $manifesto->getQuotePositionInCommitment($q, $commitment);
					if (empty($p)) {
						$toPlace[] = $q;
					} else {
						$placed[] = $q;
					}
				}
				
				if (count($quotes)>0) {
					// d'abord les déclarations déjà positionnées						
					for ($i=0; $i<count($placed); $i++) {
						if ($i>0) {
							$previous = $placed[$i-1];
						}
						echo '<h2>';
						echo '<a href="quote_edit.php?id='.$placed[$i]->getId().'">'.ToolBox::toHtml($placed[$i]->getContent()).'</a>';
						if (isset($previous)) {
							echo ' <small><a href="'.$_SERVER['PHP_SELF'].'?cmd=quoteUp&q_id='.$placed[$i]->getId().'&t_id='.$previous->getId().'&c_id='.$commitment->getId().'"><i class="fa fa-arrow-alt-circle-up"></i></a></small>';
						}
						echo '</h2>';
						echo '<div>'.ToolBox::toHtml($placed[$i]->getComment()).'</div>';
					}
					
					if (count($toPlace)>0) {
						echo '<ol>';
						// on affiche les déclarations à positionner à la fin
						foreach ($toPlace as $q) {
							echo '<li><a href="quote_edit.php?id='.$q->getId().'">'.ToolBox::toHtml($q->getContent()).'</a>';
							echo ' <span class="badge badge-warning"><a href="'.$_SERVER['PHP_SELF'].'?cmd=placeQuote&q_id='.$q->getId().'&c_id='.$commitment->getId().'">à positionner</a></span>';
							echo '</li>';
						}
						echo '</ol>';
					}
				}
			?>
		</main>
		<?php echo $h->getFooterTag() ?>
	</div>
	<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
</body>
</html>