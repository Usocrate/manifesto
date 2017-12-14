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
$m = new Manifesto($env);
$subscriptions = $m->getSubscriptions();

header('charset=utf-8');
?>
<!doctype html>
<html lang="fr">
<head>
	<meta charset="UTF-8">	
	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" />
	<meta name="description" content="<?php echo htmlentities($env->getProjectDescription()) ?>" />
	<title><?php echo htmlentities($env->getProjectName()) ?></title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
	<link href="../skin/home.css" rel="stylesheet" type="text/css">
</head>
<body id="subscriptions-doc">
	<div class="container">
		<main>
		<h1>Usocrates</h1>
			<?php
			//print_r($subscriptions);
			foreach ($subscriptions as $s) {
				echo '<h2>'.htmlentities($s[usocrate_id]);
				if (!empty($s[mail])) echo ' <small>('.htmlentities($s[mail]).')</small>';
				echo '</h2>';
				echo '<p>Devenu Usocrate le '.$s[timestamp].'</p>';
			}
			?>
		</main>
		<footer>
			<span class="brand monochrome">Usocrate.fr</span> - 2017 - Usus magister est optimus
		</footer>
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
	
	<script>
		$(document).ready(function(){
		});
	</script>
</body>
</html>