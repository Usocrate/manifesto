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
		
        case 'registerQuote' :
        	// enregistrement des données de la déclaration
        	$feedback = $manifesto->registerQuote(new Quote($_REQUEST));
            $alerts[$feedback->getType()][]  = $feedback->getMessage();
            $quote = $feedback->getDatum('registredQuote');
            
            // association à un engagement
            if (isset($_REQUEST['commitment_id'])) {
            	$c = new Commitment();
            	$c->setId($_REQUEST['commitment_id']);
            	if (!$manifesto->isQuoteAttachedToCommitment($quote, $c)) {
            		$feedback = $manifesto->attachQuoteToCommitment($quote, $c);
					$alerts[$feedback->getType()][]  = $feedback->getMessage();
            	}
            }
            header('Location:./quotes.php');
            exit;
        default:
        	$alerts['warning'] = 'commande inconnue';
    }
}


if (!isset($quote)) {
	if (!empty($_REQUEST['id'])) {
		$quote = $manifesto->getQuote($_REQUEST['id']);
	} else {
		$quote = new Quote;
	}	
}

$doc_title = $quote->hasId() ? ucfirst($quote->getContent()) : 'Nouvelle déclaration';

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
					<li class="breadcrumb-item"><a href="quotes.php">Les déclarations</a></li>
					<li class="breadcrumb-item active" aria-current="page"><?php echo ToolBox::toHtml($doc_title) ?></li>
				</ol>
			</nav>
			<h1>
				<?php
					echo ToolBox::toHtml($doc_title);
					if ($quote->hasId()) {
						echo ' <small><a href="../quote.php?id='.$quote->getId().'"><i class="fa fa-eye"></i></a></small>';
					}
				?>
			</h1>
		</header>
		<main>
		<?php echo $h->getAlertsTag($alerts) ?>
		<form method="post" action="quote_edit.php">
			<input type="hidden" name="cmd" value="registerQuote" />
			<input type="hidden" name="id" value="<?php echo $quote->getId() ?>" />
			<div class="form-group">
				<label for="content_i">Contenu</label>
				<textarea id="content_i" name="content" class="form-control" cols="140" rows="1"><?php echo $quote->getContent() ?></textarea>
			</div>
			<div class="form-group">
				<label for="comment_i">Commentaire</label>
				<textarea id="comment_i" name="comment" class="form-control" rows="20"><?php echo $quote->getComment() ?></textarea>
			</div>
			<div class="form-group">
				<label for="commitment_id_i">Engagement</label>
				<select id="commitment_id_i" name="commitment_id" class="form-control">
					<?php
						$valueToSelect = $manifesto->getQuoteCommitment($quote)->getId();
						foreach ($manifesto->getCommitments() as $c) {
							echo strcmp($c->getId(), $valueToSelect)==0 ? '<option value="'.$c->getId().'" selected>' : '<option value="'.$c->getId().'">';
							echo ToolBox::toHtml($c->getTitle());
							echo '</option>';
						}
					?>
				</select>
			</div>
			<button type="submit" class="btn btn-primary">Enregistrer</button>
		</form>
		<section>
		<p>
		<?php
			$tweets = $manifesto->getQuoteTweets($quote);
			if (count($tweets) > 0) {
				$label = count($tweets).' tweet';
				if (count($tweets) > 1) {
					$label.= 's';
				}
			} else {
				$label = 'Associer un tweet';	
			}
			echo '<a href="quote_tweets.php?quote_id='.$quote->getId().'">'.ToolBox::toHtml($label).'</a>';
		?>
		</p>
		</section>
		</main>
		<?php echo $h->getFooterTag() ?>
	</div>
	<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
</body>
</html>