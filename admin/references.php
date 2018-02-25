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
	
	ToolBox::formatUserPost($_POST);
	
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
					<li class="breadcrumb-item active" aria-current="page">Références</li>
				</ol>
			</nav>
			<h1>Les références</h1>
		</header>
		<main>
		<?php 
			if (count($alerts)>0) {
				foreach($alerts as $a) {
					echo '<div class="alert">'.htmlspecialchars($a).'</div>';
				}
			}
		?>
		<ul>
		<?php 
			foreach ($references as $r) {
				echo '<li>';
				echo '<h2>'.htmlspecialchars($r->getTitle()).' <small><a href="reference_edit.php?id='.$r->getId().'"><i class="fa fa-edit"></i></a></small></h2>';
				if ( strlen($r->getAuthor()) > 0 ) {
					echo ' <p>'.htmlspecialchars($r->getAuthor()).'</p>';
				}
				echo '<p><a href="'.$r->getUrl().'" target="_blank">'.$r->getUrl().'</a><p>';
				if ( strlen($r->getComment())>0 ) {
					echo ' <p>'.htmlspecialchars($r->getComment()).'</p>';
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
				<textarea id="comment_i" name="comment" class="form-control"></textarea>
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
	<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
</body>
</html>