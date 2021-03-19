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
$h = new HtmlFactory ( $env );
$manifesto = new Manifesto ( $env );

if (isset ( $_REQUEST ['cmd'] )) {

	ToolBox::formatUserPost ( $_REQUEST );

	switch ($_REQUEST ['cmd']) {
		case 'registerCommitment' :
			// enregistrement des données de l'engagement
			$feedback = $manifesto->registerCommitment ( new Commitment ( $_REQUEST ) );
			$alerts [$feedback->getType ()] [] = $feedback->getMessage ();
			$commitment = $feedback->getDatum ( 'registredCommitment' );
			break;
		default :
			$alerts ['warning'] [] = 'commande inconnue';
	}
}

if (!isset($commitment)) {
	if (!empty($_REQUEST['id'])) {
		$commitment = $manifesto->getCommitment($_REQUEST['id']);
	} else {
		$commitment = new Commitment;
	}
}

header ( 'charset=utf-8' );
?>
<!doctype html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport"
	content="width=device-width, height=device-height, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="description"
	content="<?php echo ToolBox::toHtml($env->getProjectDescription()) ?>" />
<title><?php echo ToolBox::toHtml($env->getProjectName()) ?></title>
<script
	src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"
	integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh"
	crossorigin="anonymous"></script>
<link
	href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
	rel="stylesheet"
	integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
	crossorigin="anonymous">
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
					<li class="breadcrumb-item"><a href="commitments.php">Les
							engagements</a></li>
					<li class="breadcrumb-item active"><?php echo ucfirst(ToolBox::toHtml($commitment->getTitle())) ?></li>
				</ol>
			</nav>
			<h1><?php echo ucfirst(ToolBox::toHtml($commitment->getTitle())) ?> <small>(édition)</small></h1>
		</header>
		<main>
		<?php echo $h->getAlertsTag($alerts) ?>
		<form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
			<input type="hidden" name="cmd" value="registerCommitment" />
			<input type="hidden" name="id" value="<?php echo $commitment->getId() ?>" />
			<div class="form-group">
				<label for="title_i">Intitulé</label>
				<textarea id="title_i" name="title" class="form-control" cols="140" rows="1"><?php echo $commitment->getTitle() ?></textarea>
			</div>
			<button type="submit" class="btn btn-primary">Enregistrer</button>
		</form>
			<?php

			?>
		</main>
		<?php echo $h->getFooterTag() ?>
	</div>
	<script defer
		src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
</body>
</html>