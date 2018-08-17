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

if (empty($_REQUEST['quote_id'])) {
    header('Location:./quotes.php');
    exit;
} else {
	$quote = $manifesto->getQuote($_REQUEST['quote_id']);	
}

if (isset($_REQUEST['cmd'])) {
	
	ToolBox::formatUserPost($_REQUEST);
	//print_r($_REQUEST);
	
	switch ($_POST['cmd']) {
        case 'attachTweetToQuote' :
        	if (isset($_REQUEST['tweet_url'])) {
        		$tweet = new Tweet($_REQUEST['tweet_url']);
        		$feedback = $manifesto->attachTweetToQuote($tweet, $quote);
        	}
            $alerts[$feedback->getType()][] = $feedback->getMessage();
        default:
        	$alerts['warning'] = 'commande inconnue';
    }
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
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="../skin/home.css" />
</head>
<body id="references-doc">
	<div class="container">
		<header>
			<nav aria-label="breadcrumb" role="navigation">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="../index.php">Manifesto</a></li>
					<li class="breadcrumb-item"><a href="index.php">Administration</a></li>
					<li class="breadcrumb-item"><a href="quotes.php">Les déclarations</a></li>
					<li class="breadcrumb-item"><a href="quote_edit.php?id=<?php echo $quote->getId() ?>"><?php echo ucfirst($quote->getContent()) ?></a></li>
					<li class="breadcrumb-item active">Tweets</li>
				</ol>
			</nav>
			<h1><?php echo htmlspecialchars('Tweets'); ?></h1>
		</header>
		<main>
			<section><?php echo $h->getAlertsTag($alerts) ?></section>
			<?php 
				$tweets = $manifesto->getQuoteTweets($quote);
				if (count($tweets)>0) {
					echo '<section>';
					foreach ($tweets as $t) {
						echo $t->getOEmbedHtml();
					}
					echo '</section>';
				}
			?>	
			<section>
				<form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
					<input type="hidden" name="cmd" value="attachTweetToQuote" />
					<input type="hidden" name="quote_id" value="<?php echo $quote->getId() ?>" />
					<div class="form-group">
						<label for="tweet_url_i">Url du tweet</label>
						<input id="tweet_url_i" name="tweet_url" class="form-control" />
					</div>
					<button type="submit" class="btn btn-primary">Associer</button>
				</form>				
			</section>
		</main>
		<?php echo $h->getFooterTag() ?>
	</div>
	<script id="twitter-wjs" type="text/javascript" async defer src="//platform.twitter.com/widgets.js"></script>
</body>
</html>