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
$m = new Manifesto($env);

if (isset ($_REQUEST['id'])) {
	$quote = $m->getQuote($_REQUEST['id']);
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
	<meta name="description" content="<?php echo htmlentities($env->getProjectDescription()) ?>" />
	<title><?php echo htmlentities($quote->getContent()) ?></title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="skin/home.css" />
</head>
<body id="references-doc">
	<div class="container">
		<nav aria-label="breadcrumb" role="navigation">
		  <ol class="breadcrumb">
		     <li class="breadcrumb-item"><a href="index.php">Manifesto</a></li>
		    <li class="breadcrumb-item active" aria-current="page">Déclaration <?php echo htmlentities($quote->getId()) ?></li>
		  </ol>
		</nav>
		<h1><?php echo htmlentities($quote->getContent()) ?></h1>
		<main>
			<p><?php echo htmlentities($quote->getComment()) ?></p>
		</main>
		<?php echo $h->getFooterTag() ?>
	</div>
</body>
</html>