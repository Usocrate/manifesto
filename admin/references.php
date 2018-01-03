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

if (isset($_POST['cmd'])) {
	switch ($_POST['cmd']) {
        case 'registerReference' :
            $alerts[]  = $manifesto->registerReference(new Reference($_POST));
            break;            
        default:
        	$alerts[] = 'commande inconnue';
    }
}

$references = $manifesto->getReferences();

header('charset=utf-8');
?>
<!doctype html>
<html lang="fr">
<head>
	<meta charset="UTF-8">	
	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<meta name="description" content="<?php echo htmlentities($env->getProjectDescription()) ?>" />
	<title><?php echo htmlentities($env->getProjectName()) ?></title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="../skin/home.css" />
</head>
<body id="references-doc">
	<div class="container">
		<header>
			<nav aria-label="breadcrumb" role="navigation">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="../index.php">Manifesto</a></li>
					<li class="breadcrumb-item"><a href="index.php">Administration</a></li>
					<li class="breadcrumb-item active" aria-current="page">Références</li>
				</ol>
			</nav>
			<h1>Les références</h1>
		</header>
		<main>
		<?php 
			if (count($alerts)>0) {
				foreach($alerts as $a) {
					echo '<div class="alert">'.htmlentities($a).'</div>';
				}
			}
		?>
		<ul>
		<?php 
			foreach ($references as $r) {
				echo '<li>';
				echo '<h2><a href="'.$r['url'].'" target="_blank">'.htmlentities($r['title']).'</a></h2>';
				if ( strlen($r['author'])>0 ) {
					echo ' <small>('.htmlentities($r['author']).'</small>)';
				}
				if ( strlen($r['comment'])>0 ) {
					echo ' <p>'.htmlentities($r['comment']).'</p>';
				}
				echo '</li>';
			}
		?>
		</ul>
		<h2>Nouvelle référence</h2>
		<form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
			<input type="hidden" name="cmd" value="registerReference" />
			<div class="form-group">
				<label for="title_i">Intitulé</label>
				<input id="title_i"type="text" name="title" class="form-control"></input>
			</div>
			<div class="form-group">
				<label for="url_i">Url</label>
				<input id="url_i" type="url" name="url" class="form-control"></input>
			</div>
			<div class="form-group">
				<label for="comment_i">Commentaire</label>
				<input id="comment_i" type="text" name="comment" class="form-control"></input>
			</div>
			<div class="form-group">
				<label for="author_i">Auteur</label>
				<input id="author_i" type="text" name="author" class="form-control"></input>
			</div>
			<button type="submit" class="btn btn-primary">Enregistrer</input>
		</form>
		</main>
		<?php echo $h->getFooterTag() ?>
	</div>
</body>
</html>