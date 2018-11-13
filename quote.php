<?php
function __autoload($class_name) {
	$path = './classes/';
	if (is_file ( $path . $class_name . '.class.php' )) {
		include_once $path . $class_name . '.class.php';
	} elseif ($path . $class_name . '.interface.php') {
		include_once $path . $class_name . '.interface.php';
	}
}

session_start();

$env = new Environment ( './config/host.json' );
$h = new HtmlFactory($env);
$manifesto = new Manifesto($env);

if (isset ($_REQUEST['id'])) {
	$quote = $manifesto->getQuote($_REQUEST['id']);
	$doc_title = ucfirst($quote->getContent());
} else {
	header ( 'Location:' . $env->getProjectUrl() );
	exit ();	
}

header('charset=utf-8');
?>
<!doctype html>
<html lang="fr">
<head>
	<meta charset="UTF-8">	
	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<meta name="description" content="<?php echo ToolBox::toHtml($env->getProjectDescription()) ?>" />
	<title><?php echo ToolBox::toHtml($quote->getContent()) ?></title>
	<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="skin/home.css" />
	<?php echo $env->writeHtmlHeadTagsForFavicon(); ?>
</head>
<body id="references-doc">
	<div class="container">
		<nav aria-label="breadcrumb" role="navigation">
		  <ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="index.php">Manifesto</a></li>
		    <li class="breadcrumb-item active" aria-current="page"><?php echo ToolBox::toHtml($quote->getContent()) ?></li>
		  </ol>
		</nav>
		<h1><?php echo ToolBox::toHtml($quote->getContent()) ?></h1>
		<main>
			<p><?php echo ToolBox::toHtml($quote->getComment()) ?></p>
			<?php 
				$tweets = $manifesto->getQuoteTweets($quote);
				foreach ($tweets as $t) {
					echo $t->getOEmbedHtml();
				}
			?>
			<?php
				$references = $manifesto->getQuoteReferences($quote);
				if (count($references)>0) {
					echo '<h2>Références</h2>';
					echo '<ul>';
					foreach ($references as $r) {
						echo '<li>';
						echo '<a href="'.$r->getUrl().'" target="_blank"><strong>'.ToolBox::toHtml($r->getTitle()).'</strong></a>';
						if ( strlen($r->getAuthor()) > 0 ) {
							echo ' <small>('.ToolBox::toHtml($r->getAuthor()).')</small>';
						}
						if ( strlen($r->getComment())>0 ) {
							echo '<br>'.ToolBox::toHtml($r->getComment());
						}
						echo '</li>';
					}
					echo '</ul>';
				}
			?>
		</main>
		<?php echo $h->getFooterTag() ?>
	</div>
	
<script id="twitter-wjs" type="text/javascript" async defer src="//platform.twitter.com/widgets.js"></script>
</body>
</html>