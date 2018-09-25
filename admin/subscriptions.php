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
$subscriptions = $m->getSubscriptions();

header('charset=utf-8');
?>
<!doctype html>
<html lang="fr">
<head>
	<meta charset="UTF-8">	
	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" />
	<meta name="description" content="<?php echo htmlspecialchars($env->getProjectDescription()) ?>" />
	<title><?php echo htmlspecialchars($env->getProjectName()) ?></title>
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
			//print_r($subscriptions);
			foreach ($subscriptions as $s) {
				echo '<h2>'.htmlspecialchars($s[usocrate_id]);
				if (!empty($s[mail])) echo ' <small>('.htmlspecialchars($s[mail]).')</small>';
				echo '</h2>';
				echo '<p>Usocrate depuis le '.$s[timestamp].'</p>';
			}
			?>
		</main>
		<?php echo $h->getFooterTag() ?>
	</div>
	
	<?php if ($env->hasGoogleAnalyticsKey()): ?>
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
	  ga('create', '<?php echo $env->getGoogleAnalyticsKey() ?>', 'auto');
	  ga('send', 'pageview');
	</script>
	<?php endif; ?>
	
	<script>$(document).ready(function(){});</script>
</body>
</html>