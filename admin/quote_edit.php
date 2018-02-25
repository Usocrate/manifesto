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

$quote = $manifesto->getQuote($_REQUEST['id']);
$doc_title = ucfirst($quote->getContent());

if (isset($_POST['cmd'])) {
	
	ToolBox::formatUserPost($_POST);
	
	switch ($_POST['cmd']) {
        default:
        	$alerts[] = 'commande inconnue';
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
					<li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($doc_title) ?></li>
				</ol>
			</nav>
			<h1>
				<?php
					echo htmlspecialchars($doc_title);
					if ($quote->hasId()) {
						echo ' <small><a href="../quote.php?id='.$quote->getId().'"><i class="fa fa-eye"></i></a></small>';
					}
				?>
			</h1>
		</header>
		<main>
		<?php
			//print_r($quote);
			
			if (count($alerts)>0) {
				foreach($alerts as $a) {
					echo '<div class="alert">'.htmlspecialchars($a).'</div>';
				}
			}
		?>
		<form method="post" action="quotes.php">
			<input type="hidden" name="cmd" value="registerQuote" />
			<input type="hidden" name="id" value="<?php echo $quote->getId() ?>" />
			<div class="form-group">
				<label for="content_i">Contenu</label>
				<textarea id="content_i" name="content" class="form-control" cols="140" rows="1"><?php echo htmlspecialchars($quote->getContent()) ?></textarea>
			</div>
			<div class="form-group">
				<label for="comment_i">Commentaire</label>
				<textarea id="comment_i" name="comment" class="form-control" rows="20"><?php echo htmlspecialchars($quote->getComment()) ?></textarea>
			</div>
			<div class="form-group">
				<label for="set_id_i">Groupe</label>
				<input id="set_id_i" type="tet" name="set_id" class="form-control" value="<?php echo $quote->getSetId() ?>"></input>
			</div>			
			<button type="submit" class="btn btn-primary">Enregistrer</button>
		</form>
		</main>
		<?php echo $h->getFooterTag() ?>
	</div>
	<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
</body>
</html>