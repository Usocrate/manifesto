<?php
function __autoload($class_name) {
	$path = './classes/';
	if (is_file ( $path . $class_name . '.class.php' )) {
		include_once $path . $class_name . '.class.php';
	} elseif ($path . $class_name . '.interface.php') {
		include_once $path . $class_name . '.interface.php';
	}
}
session_start();

if (isset($_REQUEST['extended'])) {
	$_SESSION['extended'] = $_REQUEST['extended'];
}

$env = new Environment ( './config/host.json' );
$h = new HtmlFactory($env);
$m = new Manifesto($env);
$commitments = $m->getCommitments();
//print_r($commitments);

header('charset=utf-8');
?>
<!doctype html>
<html lang="fr">
<head>
	<meta charset="UTF-8">	
	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" />
	<meta name="description" content="<?php echo htmlspecialchars($env->getProjectDescription()) ?>" />
	<title><?php echo htmlspecialchars($env->getProjectName()) ?></title>
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="skin/home.css" />
	<?php echo $env->writeHtmlHeadTagsForFavicon(); ?>
</head>
<body id="manifesto-doc">
	<div class="container">
		<div class="jumbotron"><h1>Manifeste <span class="badge badge-info" style="display:none">beta</span><br><small>Pour une usocratie numérique</small></h1></div>
		<main>
			<section id="intro">
				<p>
					Le numérique est le moteur d'une révolution sociale qui dépasse les problématiques technologiques.<br>
					Sa pratique transforme en profondeur les relations interpersonnelles, les conditions de travail et la manière dont nous nous représentons le monde.</p>
				<p>
					Si les usages du numérique sont largement étudiés et commentés, les conditions dans lesquelles sont construites ces applications qui occupent nos vies sont plus rarement abordées.<br>
					C'est pourtant là que tout se décide.<br>
					Et le constat est simple : les modes de production industriels anciens, loin des enjeux collectifs et individuels de la transformation actuelle, sont encore très ancrés.<br>
				</p>
				<p>
					Le numérique a besoin d'une renaissance qui placerait l'humain au coeur de toute initiative... pour ne pas réduire l'innovation à une succession de gadgets technologiques inutiles, aliénants et hautement périssables.<br>
					Pour ceux qui portent une démarche de conception centrée sur l'humain et les usages (ergonomes, designers), trop d’énergie est encore dépensée à convaincre les donneurs d’ordre et à obtenir les moyens de travailler.
				</p>
				<p>
					Ce manifeste veut contribuer à lever quelques archaïsmes trop courants dans la conception de services numériques; pour libérer l’innovation et augmenter l’utilité sociale de notre production.<br/>
					Professionnel qui a entre les mains la destinée de services numériques (chef de produit, designers, chef de projets, financeur), ce manifeste s'adresse à toi.<br/>
				</p>
			</section>
			<section id="definition">
				<div class="row justify-content-md-center">
					<div class="col-md-6 col-lg-5">
						<dl>
							<dt><span class="brand monochrome">Technocrate</span> / tɛk.nɔ.kʁat</dt>
							<dd>Homme, femme politique ou haut fonctionnaire qui fait prévaloir les données techniques ou économiques sur les facteurs humains.</dd>
						</dl>
					</div>
					<div class="col-md-6 col-lg-5">
						<dl>
							<dt><span class="brand monochrome">Usocrate</span> / u.zɔ.kʁat</dt>
							<dd>Concepteur de produits ou services qui fait de l'adéquation aux besoins réels des usagers le vecteur principal du progrès et de l'innovation</dd>
						</dl>
					</div>
				</div>
			</section>			
			<section id="method">
				<h2><em>1</em> Méthode</h2>
				<div><p><strong><a href="https://www.iso.org/fr/standard/52075.html" target="_blank">ISO 9241-210</a></strong><br>Ergonomie de l'interaction homme-système -- Partie 210<br><em>Conception centrée sur l'opérateur humain pour les systèmes interactifs</em></p></div>
			</section>
			<section id="purpose">
				<h2><em>2</em> Ambitions</h2>
				<div class="row">
					<div class="col-md-6">
						<div class="area">
							<h3>Humaniste</h3>
							<ul>
								<li><strong>Améliorer la vie des gens</strong>, impacter notamment leurs conditions de travail en construisant des outils numériques adaptés, efficaces et libérant les potentiels individuels.</li>
								<li>Mettre le numérique <strong>au service de l'intelligence humaine</strong>, refuser d’en faire un instrument d’aliénation et de déshumanisation.</li>
								<li>Veiller à ce que les services développés soient accessibles et utilisables par tous pour <strong>une société numérique inclusive</strong>.</li>
							</ul>
							<p>
								<span class="badge badge-pill badge-default">Utilité</span>
								<span class="badge badge-pill badge-default">Progrès</span>
								<span class="badge badge-pill badge-default">Encapacitation</span>
							</p>
						</div>
					</div>
					<div class="col-md-6">
						<div class="area">
							<h3>Economique</h3>
							<ul>
								<li>
									Pour notre compétitivité, il est urgent de rompre avec l'apathie généralisée face à la nécessité de <strong>faire de bons produits</strong>.<br>
									Il s'agit de garantir l'<strong>utilité</strong>, l'<strong>utilisabilité</strong> et l'<strong>attractivité</strong> de notre production numérique.
								</li>
								<li>Penser "valeur d'usage" permet de <strong>rationaliser les politiques d'investissements</strong> et d'<strong>assurer la viabilité des produits développés</strong> qu’ils le soient dans un esprit de service public ou pour le secteur marchand.</li>
								<li>La <strong>proximité avec les usagers</strong> permet de découvrir des <strong>opportunités d'innover</strong>. Les entreprises ne sont plus condamnées à copier leurs concurrents à moindre coût.</li>
							</ul>
							<p>
								<span class="badge badge-pill badge-default">Créativité</span> 
								<span class="badge badge-pill badge-default">Valeur ajoutée</span> 
								<span class="badge badge-pill badge-default">Compétitivité</span>
							</p>
						</div>
					</div>
				</div>
			</section>
			<section id="commitment">
				<h2><em>3</em> Engagements</h2>
				<div class="area">
					<h3>1- Porter toute l’attention aux usagers</h3>
					<blockquote style="display:none">Focus on the user and all else will follow (Google)<br/>Make things people want vs Make people want things.</blockquote>
					<div class="row">
						<div class="col-md-6">
							<div class="area">
								<?php
									$quotes = $m->getCommitmentQuotes($commitments[1]);
									echo '<h4>'.ucfirst(htmlspecialchars($commitments[1]->getTitle())).'</h4>';
								?>								
								<p>Moi <span class="brand">usocrate</span>...</p>
								<ul>
									<?php
										foreach ($quotes as $q) {
											echo isset($_SESSION['extended']) ? '<li><a href="/quote.php?id='.$q->getId().'">'.ucfirst(htmlspecialchars($q->getContent())).'</a></li>' : '<li>'.ucfirst(htmlspecialchars($q->getContent())).'</a></li>';
										}
									?>
								</ul>
								<p><span class="badge badge-pill badge-default">Co-conception</span> <span class="badge badge-pill badge-default">Principe de réalité</span> <span class="badge badge-pill badge-default">IRL</span></p>
							</div>
						</div>
						<div class="col-md-6">
							<div class="area">
								<?php
									$quotes = $m->getCommitmentQuotes($commitments[2]);
									echo '<h4>'.ucfirst(htmlspecialchars($commitments[2]->getTitle())).'</h4>';
								?>								
								<p>Moi <span class="brand">usocrate</span>...</p>
								<ul>
									<?php
										foreach ($quotes as $q) {
											echo isset($_SESSION['extended']) ? '<li><a href="/quote.php?id='.$q->getId().'">'.ucfirst(htmlspecialchars($q->getContent())).'</a></li>' : '<li>'.ucfirst(htmlspecialchars($q->getContent())).'</a></li>';
										}
									?>
								</ul>
								<p><span class="badge badge-pill badge-default">Ecoute</span> <span class="badge badge-pill badge-default">Considération</span> <span class="badge badge-pill badge-default">Ethique</span></p>
							<div class="area">
						</div>
					</div>
				</div>
					</div>
				</div>
				
				<div class="area">
					<h3>2- Contribuer à changer les indicateurs de réussite des projets</h3>
					<blockquote style="display:none">Le numérique rend obsolète l'ancien modèle de production industriel.</blockquote>
					<div class="row">
						<div class="col-md-6">
							<div class="area">
								<?php
									$quotes = $m->getCommitmentQuotes($commitments[3]);
									echo '<h4>'.ucfirst(htmlspecialchars($commitments[3]->getTitle())).'</h4>';
								?>								
								<p>Moi <span class="brand">usocrate</span>...</p>
								<ul>
									<?php
										foreach ($quotes as $q) {
											echo isset($_SESSION['extended']) ? '<li><a href="/quote.php?id='.$q->getId().'">'.ucfirst(htmlspecialchars($q->getContent())).'</a></li>' : '<li>'.ucfirst(htmlspecialchars($q->getContent())).'</a></li>';
										}
									?>
								</ul>
								<p><span class="badge badge-pill badge-default">Valeur d'usage</span> <span class="badge badge-pill badge-default">Service</span> <span class="badge badge-pill badge-default">Bénéfice</span></p>
							</div>
						</div>
						<div class="col-md-6">
							<div class="area">
								<?php
									$quotes = $m->getCommitmentQuotes($commitments[4]);
									echo '<h4>'.ucfirst(htmlspecialchars($commitments[4]->getTitle())).'</h4>';
								?>								
								<p>Moi <span class="brand">usocrate</span>...</p>
								<ul>
									<?php
										foreach ($quotes as $q) {
											echo isset($_SESSION['extended']) ? '<li><a href="/quote.php?id='.$q->getId().'">'.ucfirst(htmlspecialchars($q->getContent())).'</a></li>' : '<li>'.ucfirst(htmlspecialchars($q->getContent())).'</a></li>';
										}
									?>
								</ul>
								<p><span class="badge badge-pill badge-default">Expérience utilisateur</span> <span class="badge badge-pill badge-default">Appropriation</span> <span class="badge badge-pill badge-default">Satisfaction</span> <span class="badge badge-pill badge-default">Productivité</span></p>							
							</div>
						</div>
					</div>
				</div>
				
				<div class="area">
					<h3>3- Rappeler que la production de valeur est une activité sociale.</h3>
					<blockquote style="display:none">Etre usocrate c'est être un organisateur et un facilitateur.<br/>C'est viser à régler les dysfonctionnements internes de l'entreprise pour que toute l'énergie mobilisable le soit au profit des utilisateurs, sans dissipation.<br/>C'est s'engager dans la rationalisation la chaîne de production et la promotion radicale de la collaboration entre les différents acteurs du projet. Leadership, vision collective et agilité.</blockquote>
					<div class="row">
						<div class="col-md-6">
							<div class="area">
								<?php
									$quotes = $m->getCommitmentQuotes($commitments[5]);
									echo '<h4>'.ucfirst(htmlspecialchars($commitments[5]->getTitle())).'</h4>';
								?>								
								<p>Moi <span class="brand">usocrate</span>...</p>
								<ul>
									<?php
										foreach ($quotes as $q) {
											echo isset($_SESSION['extended']) ? '<li><a href="/quote.php?id='.$q->getId().'">'.ucfirst(htmlspecialchars($q->getContent())).'</a></li>' : '<li>'.ucfirst(htmlspecialchars($q->getContent())).'</a></li>';
										}
									?>
								</ul>
								<p><span class="badge badge-pill badge-default">Collaboration</span> <span class="badge badge-pill badge-default">Planification</span> <span class="badge badge-pill badge-default">Agilité</span></p>								
							</div>
						</div>
						<div class="col-md-6">
							<div class="area">
								<?php
									$quotes = $m->getCommitmentQuotes($commitments[6]);
									echo '<h4>'.ucfirst(htmlspecialchars($commitments[6]->getTitle())).'</h4>';
								?>								
								<p>Moi <span class="brand">usocrate</span>...</p>
								<ul>
									<?php
										foreach ($quotes as $q) {
											echo isset($_SESSION['extended']) ? '<li><a href="/quote.php?id='.$q->getId().'">'.ucfirst(htmlspecialchars($q->getContent())).'</a></li>' : '<li>'.ucfirst(htmlspecialchars($q->getContent())).'</a></li>';
										}
									?>
								</ul>
								<p><span class="badge badge-pill badge-default">Créativité</span> <span class="badge badge-pill badge-default">Expérimentation</span></p>
							</div>
						</div>
					</div>
				</div>
			</section>
			<section id="subscriptionArea">
				<div class="row justify-content-md-center">
		         	<div class="col-xs-12 col-md-8">
						<div class="subscriptionCard">
			       			<h1 class="text-center brand"><small>Je suis</small> Usocrate <small>!</small></h1>
							<div>
								<p>Peut-on vous compter parmi les rangs usocrates ?</p>
								<ul>
									<li>Je partage la vision et souhaite donner du poids à ce discours</li>
									<li>J'ai conscience de ma responsabilité individuelle et témoigne de ma volonté de mise en oeuvre des principes du manifeste dans mes pratiques professionnelles quotidiennes</li>
								</ul>
					            <form id="subscription_form">
					            	<div class="form-group ">
										<label for="id_i">Je me présente</label>
										<input type="text" id="id_i" name="id" class="form-control input-lg" placeholder="un profil Twitter, LinkedIn,...">
				                  	</div>
									<div class="form-group ">
										<label for="mail_i">Un email ?</label>
										<input type="email" id="mail_i" name="mail" class="form-control input-lg" placeholder="pour être informé de l'évolution de l'initiative usocrate.fr">
						            </div>
						            <input name="cmd" value="registerSubscription" type="hidden">
						            <button type="submit" class="btn btn-block btn-primary">Oui, j'en suis</button>
						        </form>
							</div>
						</div>
		          	</div>
				</div>
			</section>
		</main>
		<?php echo $h->getFooterTag() ?>
	</div>
	
	<?php if ($env->hasGoogleAnalyticsKey()): ?>
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
	  ga('create', '<?php echo $env->getGoogleAnalyticsKey() ?>', 'auto');
	  ga('send', 'pageview');
	</script>
	<?php endif; ?>
	
	<script>
		$(document).ready(function(){
			$("#subscription_form").submit(function(e){
				e.preventDefault();
				
				<?php if ($env->hasGoogleAnalyticsKey()): ?>
					ga('send', 'event', {'eventCategory':'engagement','eventAction':'souscription','eventLabel':'nouvel usocrate','eventValue':$("#id_i").val()});
				<?php endif; ?>
				
				$.ajax({
				    url: "api.php",
				    data: $( "#subscription_form" ).serialize(),
				    type: "POST",
				    dataType : "json",
				})
				.done(function( json ) {
					alert(json.message);
				})
				.fail(function( xhr, status, errorThrown ) {
					console.log( "Erreur: " + errorThrown );
				    console.log( "Etat: " + status );
				    console.dir( xhr );
				 });
			});
		});
	</script>
	<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
</body>
</html>