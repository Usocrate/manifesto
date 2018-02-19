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
$reference = $manifesto->getReference($_REQUEST['id']);

header('charset=utf-8');
?>
<!doctype html>
<html lang="fr">
<head>
	<meta charset="UTF-8">	
	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<meta name="description" content="<?php echo htmlentities($env->getProjectDescription()) ?>" />
	<title><?php echo htmlentities($env->getProjectName()) ?></title>
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
					<li class="breadcrumb-item"><a href="references.php">Références</a></li>
					<li class="breadcrumb-item active" aria-current="page"><?php echo htmlentities($reference->getTitle()) ?></li>
				</ol>
			</nav>
			<h1><?php echo htmlentities($reference->getTitle()) ?></h1>
		</header>
		<main>
		<form method="post" action="references.php">
			<input type="hidden" name="cmd" value="registerReference" />
			<input type="hidden" name="reference_id" value="<? echo $reference->getId() ?>" />
			<div class="form-group">
				<label for="title_i">Intitulé</label>
				<input id="title_i"type="text" name="title" class="form-control" value="<?php echo $reference->getTitle() ?>"></input>
			</div>
			<div class="form-group">
				<label for="url_i">Url</label>
				<input id="url_i" type="url" name="url" class="form-control" value="<?php echo $reference->getUrl() ?>"></input>
			</div>
			<div class="form-group">
				<label for="comment_i">Commentaire</label>
				<input id="comment_i" type="text" name="comment" class="form-control" value="<?php echo $reference->getComment() ?>"></input>
			</div>
			<div class="form-group">
				<label for="author_i">Auteur</label>
				<input id="author_i" type="text" name="author" class="form-control" value="<?php echo $reference->getAuthor() ?>"></input>
			</div>
			<button type="submit" class="btn btn-primary">Enregistrer</input>
		</form>
		</main>
		<?php echo $h->getFooterTag() ?>
	</div>
	<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>	
</body>
</html>