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

if (isset($_REQUEST['cmd'])) {
	
	ToolBox::formatUserPost($_REQUEST);
	
	switch ($_REQUEST['cmd']) {
        case 'registerReference' :
        	$feedback = $manifesto->registerReference(new Reference($_REQUEST));
            $alerts[$feedback->getType()][]  = $feedback->getMessage();
            break;
        case 'deleteReference' :
        	$feedback = $manifesto->deleteReference($_REQUEST['id']);
        	$alerts[$feedback->getType()][]  = $feedback->getMessage();
            break;
        default:
        	$alerts['warning'] = 'commande inconnue';
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
			<h1><?php echo htmlspecialchars($doc_title) ?> <small><a href="reference_edit.php"><i class="fa fa-plus"></i></a></small></h1>
		</header>
		<main>
		<?php 
			//print_r($alerts);
			if (count($alerts)>0) {
				foreach($alerts as $type=>$messages) {
					$classes = array('alert');
					switch ($type) {
						case 'success' :
							$classes[] = 'alert-success';
							break;
						case 'warning' :
							$classes[] = 'alert-warning';
							break;
						default :
							$classes[] = 'alert-info';
					}
					echo '<div class="'.implode(' ',$classes).'">';
					foreach ($messages as $m) {
						echo htmlspecialchars($m).'<br>';
					}
					echo '</div>';
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
				echo '<div class="cmdbar"><a href="reference_edit.php?id='.$r->getId().'"><i class="fa fa-edit"></i> éditer</a> <a href="references.php?cmd=deleteReference&id='.$r->getId().'"><i class="fa fa-trash"></i> retirer</a></div>';
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