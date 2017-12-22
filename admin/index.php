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
?>
<!DOCTYPE html>
<html>
    <head>
    	<meta charset="UTF-8">	
    	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    	<title>Administration</title>
    	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    	<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    	<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    	<link rel="stylesheet" type="text/css" href="../skin/home.css" />
    </head>    
    <body>
        <div class="container">
    		<header>
        		<nav aria-label="breadcrumb" role="navigation">
        		  <ol class="breadcrumb">
            		  <li class="breadcrumb-item"><a href="../index.php">Manifesto</a></li>
            		  <li class="breadcrumb-item active" aria-current="page">Administration</li>
        		  </ol>
        		</nav>
                <h1>Administration</h1>
            </header>
            <main>
                <ul>
                    <li><a href="<?php echo $env->getProjectUrl() ?>/index.php?extended">Le manifeste en mode augmenté</a> (test des fonctionnalités non ouvertes au public)</li>
                    <li><a href="./references.php">La liste des références</a></li>
                    <li><a href="./subscription.php">La liste des souscriptions</a></li>
                    <li><a href="./tweet_check.php">Contrôle de la longueur des déclarations</a> (pour Twitter)</li>
                </ul>
            </main>
        </div>
    </body>
</html>