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
$detachedReferences = $manifesto->getDetachedReferences();
$doc_title = 'Les références';

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
					<li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($doc_title) ?></li>
				</ol>
			</nav>
			<h1><?php echo htmlspecialchars($doc_title) ?></h1>
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
				echo '<h2>';
				echo htmlspecialchars( $r->getTitle() );
				
				if (in_array( $r->getId(), array_keys($detachedReferences) )) {
					echo ' <small><span class="badge badge-warning"><a href="reference_edit.php?id='.$r->getId().'">à associer</a></span></small>';
				}
				echo '</h2>';
				
				if ( strlen($r->getAuthor()) > 0 ) {
					echo ' <p>'.htmlspecialchars($r->getAuthor()).'</p>';
				}
				echo '<p><a href="'.$r->getUrl().'" target="_blank">'.$r->getUrl().'</a><p>';
				if ( strlen($r->getComment())>0 ) {
					echo ' <p>'.htmlspecialchars($r->getComment()).'</p>';
				}
				echo '<div><a href="reference_edit.php?id='.$r->getId().'"><i class="fa fa-edit"></i> éditer</a></div>';
				echo '</li>';
			}
		?>
		</ul>

		<?php echo '<p><a href="reference_edit.php"></a></p>' ?>
		
		</main>
		<?php echo $h->getFooterTag() ?>
	</div>
	<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
</body>
</html>