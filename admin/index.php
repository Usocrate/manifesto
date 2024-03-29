<?php
require_once '../classes/Environment.class.php';

$env = new Environment ( '../config/host.json' );
?>
<!DOCTYPE html>
<html>
    <head>
    	<meta charset="UTF-8">	
    	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    	<title>Administration</title>
    	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    	<link rel="stylesheet" type="text/css" href="../skin/home.css" />
    	<?php echo $env->writeHtmlHeadTagsForFavicon(); ?>
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
                    <li><a href="commitments.php">Les engagements</a> <a href="commitment_edit.php"><i class="fa fa-plus"></i></a></li>
                    <li><a href="quotes.php">Les déclarations</a> <a href="reference_edit.php"><i class="fa fa-plus"></i></a></li>
                    <li><a href="references.php">Les références</a> <a href="reference_edit.php"><i class="fa fa-plus"></i></a></li>
                    <li><a href="subscriptions.php">Les souscriptions</a></li>
                    <li><a href="php_info.php">phpinfo</a></li>
                </ul>
            </main>
        </div>
        <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
    </body>
</html>