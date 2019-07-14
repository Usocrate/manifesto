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
$m = new Manifesto($env);

if (isset($_POST['cmd'])) {
	
	ToolBox::formatUserPost($_POST);
	
	switch ($_POST['cmd']) {
	    case 'registerSubscription' :
	    	// enregistrement des données de la souscription
	    	$feedback = $m->registerSubscription(new Subscription($_POST));
	        $alerts[$feedback->getType()][]  = $feedback->getMessage();
	        break;
	    default:
	    	$alerts['warning'] = 'commande inconnue';
	}	
}

if (isset($_REQUEST['requestedStatus']) && in_array($_REQUEST['requestedStatus'],Subscription::getStatusOptions())) {
    $requestedStatus = $_REQUEST['requestedStatus'];
} else {
    $requestedStatus = 'to check';
}
$criteria = array('status'=>$requestedStatus);
$subscriptions = $m->getSubscriptions($criteria);

header('charset=utf-8');
?>
<!doctype html>
<html lang="fr">
<head>
	<meta charset="UTF-8">	
	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" />
	<meta name="description" content="<?php echo ToolBox::toHtml($env->getProjectDescription()) ?>" />
	<title><?php echo ToolBox::toHtml($env->getProjectName()) ?></title>
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link href="../skin/home.css" rel="stylesheet" type="text/css">
	<?php echo $env->writeHtmlHeadTagsForFavicon(); ?>
</head>
<body id="subscriptions-doc">
	<div class="container">
		<header>
			<nav aria-label="breadcrumb" role="navigation">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="../index.php">Manifesto</a></li>
					<li class="breadcrumb-item"><a href="index.php">Administration</a></li>
					<li class="breadcrumb-item active" aria-current="page">Souscriptions</li>
				</ol>
			</nav>
			<h1>Usocrates</h1>
		</header>
		<main>
			<?php
    			if (isset($alerts)) {
    			    echo $h->getAlertsTag($alerts);
    			}
			?>
		
			<form class="form-inline">
        		<label for="status-i">Statut</label>
        		<select id="status-i" name="requestedStatus" class="form-control ml-2" onchange="this.form.submit()">
        		<?php
        		 $options = Subscription::getStatusOptions();
        		 
        		 foreach ($options as $label=>$value) {
        		     echo '<option value="'.$value.'"';
        		     if (isset($requestedStatus) && strcmp($requestedStatus, $value)==0) {
        		         echo ' selected';
        		     }
        		     echo '>'.Toolbox::toHtml($label).'</option>';
        		 }
        		 ?>
        		</select>
			</form>			
			
			<?php
			//print_r($subscriptions);
			foreach ($subscriptions as $s) {
			    echo '<div subscription-id="'.$s['id'].'">';
				echo '<h2>Matricule n°'.ToolBox::toHtml($s['id']);
				echo ' <a href="subscription_edit.php?id='.urlencode($s['id']).'"><i class="fas fa-edit"></i></a>';
				echo '</h2>';
				if (!empty($s['email'])) echo '<p><a href="mailto:'.$s['email'].'">'.$s['email'].'</a><p>';
				echo '<p>'.ToolBox::toHtml($s['introduction']).'</p>';
				switch ($requestedStatus) {
				    case 'to check':
				        echo '<p><small>Demande enregistrée le '.$s['timestamp'].'</small></p>';
				        echo '<div class="checkingArea">';
				        echo '<button class="ban-button"><i class="fas fa-ban"></i> rejeter</button>';
				        echo ' ';
				        echo '<button class="check-button"><i class="fas fa-check"></i> valider</button>';
				        echo '</div>';
				        break;
				    case 'validated':
				        echo '<p><small>Usocrate depuis le '.$s['timestamp'].'</small></p>';
				        break;
				    case 'rejected':
				        echo '<p><small>Demande enregistrée le '.$s['timestamp'].'</small></p>';
				        break;
				}
				echo '</div>';
			}
			?>
		</main>
		<?php echo $h->getFooterTag() ?>
	</div>
	<script defer="" src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
	<script>
	$(document).ready(function(){
		$(".ban-button").on("click", function( event ){
			var button = $(this);
			var checkingArea = $(this).parent();
			var item = checkingArea.parent();
			var id = item.attr('subscription-id');
			$.ajax({
			    url: "../api.php",
			    data: "cmd=registerSubscriptionAsRejected&id="+id,
			    dataType : "json",
			})
			.done(function( json ) {
				//alert(json.message);
				button.addClass( "negativelyActive" );
				item.slideUp(400, function(){$(this).remove()});
			})
			.fail(function( xhr, status, errorThrown ) {
				console.log( "Erreur: " + errorThrown );
			    console.log( "Etat: " + status );
			    console.dir( xhr );
			 });
		});
		
		$(".check-button").on("click", function( event ){
			var button = $(this);
			var checkingArea = $(this).parent();
			var item = checkingArea.parent();
			var id = item.attr('subscription-id');
			$.ajax({
			    url: "../api.php",
			    data: "cmd=registerSubscriptionAsValidated&id="+id,
			    dataType : "json",
			})
			.done(function( json ) {
				//alert(json.message);
				button.addClass( "positivelyActive" );
				item.slideUp(400, function(){$(this).remove()});
			})
			.fail(function( xhr, status, errorThrown ) {
				console.log( "Erreur: " + errorThrown );
			    console.log( "Etat: " + status );
			    console.dir( xhr );
			 });
		});		
	});
	</script>
</body>
</html>