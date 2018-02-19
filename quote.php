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
	<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
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