<?php
require_once '../classes/Environment.class.php';

$env = new Environment ( '../config/host.json' );
$h = new HtmlFactory($env);
$manifesto = new Manifesto($env);

$alerts = array();

$reference = empty($_REQUEST['id']) ? new Reference : $manifesto->getReference($_REQUEST['id']);
$quotes = empty($_REQUEST['id']) ? array() : $manifesto->getReferenceQuotes($reference);

if (isset($_POST['cmd'])) {
	
	ToolBox::formatUserPost($_POST);
	
	switch ($_POST['cmd']) {
        case 'registerQuoteList':
        	$toAttach = array_diff($_POST['quote_id'],array_keys($quotes));
        	foreach ($toAttach as $id) {
        		$manifesto->attachQuoteToReference( $reference, new Quote( array('id'=>$id) ) );	
        	}
        	$toDetach = array_diff(array_keys($quotes),$_POST['quote_id']);
        	foreach ($toDetach as $id) {
        		$manifesto->detachQuoteFromReference( $reference, new Quote( array('id'=>$id) ) );	
        	}
        	$quotes = $manifesto->getReferenceQuotes($reference);
            break;
        default:
        	$alerts['warning'] = 'commande inconnue';
    }
}

header('charset=utf-8');
?>
<!doctype html>
<html lang="fr">
<head>
	<meta charset="UTF-8">	
	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<meta name="description" content="<?php echo ToolBox::toHtml($env->getProjectDescription()) ?>" />
	<title><?php echo ToolBox::toHtml($env->getProjectName()) ?></title>
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="../skin/home.css" />
	<?php echo $env->writeHtmlHeadTagsForFavicon(); ?>
</head>
<body id="references-doc">
	<div class="container">
		<header>
			<nav aria-label="breadcrumb" role="navigation">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="../index.php">Manifesto</a></li>
					<li class="breadcrumb-item"><a href="index.php">Administration</a></li>
					<li class="breadcrumb-item"><a href="references.php">Les références</a></li>
					<li class="breadcrumb-item active" aria-current="page"><?php echo ToolBox::toHtml($reference->getTitle()) ?></li>
				</ol>
			</nav>
			<h1><?php echo ToolBox::toHtml($reference->getTitle()) ?></h1>
		</header>
		<main>
		<?php echo $h->getAlertsTag($alerts) ?>
		<form method="post" action="references.php">
			<input type="hidden" name="cmd" value="registerReference" />
			<input type="hidden" name="id" value="<?php echo $reference->getId() ?>" />
			<div class="form-group">
				<label for="url_i">Url</label>
				<input id="url_i" type="url" name="url" class="form-control" value="<?php echo $reference->getUrl() ?>"></input>
			</div>
			<div class="form-group">
				<label for="title_i">Intitulé</label>
				<input id="title_i"type="text" name="title" class="form-control" value="<?php echo ToolBox::toHtml($reference->getTitle()) ?>"></input>
			</div>
			<div class="form-group">
				<label for="comment_i">Commentaire</label>
				<textarea id="comment_i" name="comment" class="form-control"><?php echo $reference->getComment() ?></textarea>
			</div>
			<div class="form-group">
				<label for="author_i">Auteur</label>
				<input id="author_i" type="text" name="author" class="form-control" value="<?php echo $reference->getAuthor() ?>"></input>
			</div>
			<button type="submit" class="btn btn-primary">Enregistrer</button>
		</form>
		<?php if ($reference->hasId()): ?>
		<h2>Associer à</h2>
		<form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
			<input type="hidden" name="cmd" value="registerQuoteList" />
			<input type="hidden" name="id" value="<?php echo $reference->getId() ?>" />
			<div class="form-group">
			<?php
				$attr = array();
				foreach ($manifesto->getQuotes() as $q) {
					echo '<div class="custom-control custom-checkbox">';
					echo '<input type="checkbox" class="custom-control-input" name="quote_id[]" id="q'.$q->getId().'" value="'.$q->getId().'"';
					if ( in_array( $q->getId(), array_keys($quotes) ) ) {
						echo ' checked';
					}
					echo '>';
					echo '<label class="custom-control-label" for="q'.$q->getId().'">';
					echo '<a href="quote_edit.php?id='.$q->getId().'">';
					echo ToolBox::toHtml(ucfirst($q->getContent()));
					echo '</a>';
					echo ' <small><a href="quote_edit.php?id='.$q->getId().'"><i class="fa fa-edit"></i></a> <a href="../quote.php?id='.$q->getId().'"><i class="fa fa-eye"></i></a></small>';
					echo '</label>';
					echo '</div>';
				}
			?>
			</div>
			<button type="submit" class="btn btn-primary">Enregistrer</button>
		</form>
		<?php endif; ?>
		
		</main>
		<?php echo $h->getFooterTag() ?>
	</div>
	<script>
		$(document).ready(function(){

    		function displayInputSuggestion(id, value) {
    			var i = $('#'+id);
    			var sid = id+'_s';
    			if (value !== null && value !== undefined && value.length>0) {
    		        if ($('#'+sid)) {
    		        	$('#'+sid).slideUp('slow').remove();
    		        }
    		        var html = '<div id="'+sid+'" class="info info-suggestion">Suggestion : <button type="button" value="'+value+'">'+value+'</button></div>';
    		        i.after(html);
    		        $('#'+sid+' button').each(function() {
    		    	    $(this).click(function () {
    		    	    	i.val($(this).val());
    		    	    	i.focus();
    		    	    });
    		    	});
    			} else {
    		        if ($('#'+sid)) {
    		        	$('#'+sid).slideUp('slow').remove();
    		        }
    			}
    		};
    		
    		function removeFormerSuggestions() {
    			$('.info-suggestion').slideUp('slow').remove();
    		};
    
    		function suggestTitleFromUrl() {
    			$.ajax({
    			  method:"GET",
    			  url:"../api.php",
    			  dataType:"json",
    			  data:{"cmd":"getReferenceTitleFromUrl","url": $("#url_i").val()}
    			}).done(function( r ) {
    	        	displayInputSuggestion('title_i', r.data.title);
    			});
    		};
    
    		$("#url_i").change(removeFormerSuggestions);
    		$("#url_i").change(suggestTitleFromUrl);
		});
	</script>	
	<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>	
</body>
</html>