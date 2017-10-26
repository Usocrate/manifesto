<?php
function __autoload($class_name) {
	$path = './classes/';
	if (is_file ( $path . $class_name . '.class.php' )) {
		include_once $path . $class_name . '.class.php';
	} elseif ($path . $class_name . '.interface.php') {
		include_once $path . $class_name . '.interface.php';
	}
}
$env = new Environment ( './config/host.json' );
$m = new Manifesto($env);
$quotes = $m->getQuotes();

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
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans|Sigmar+One" rel="stylesheet">
	<link href="skin/home.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div class="container">
		<section id="usocrateDef">
			<header>
				<div class="jumbotron">
					<div style="display:none">
						<h1 class="brand">Usocrate<small>.fr</small></h1>
						<p>Usus magister est optimus</p>
						<dl>
							<dt>Technocrate / tɛk.nɔ.kʁat</dt>
							<dd>Homme, femme politique ou haut fonctionnaire qui fait prévaloir les données techniques ou économiques sur les facteurs humains.</dd>
							<dt>Démocrate / de.mɔ.kʁat</dt>
							<dd>Partisan d'un régime politique dans lequel l’ensemble du peuple dispose du pouvoir souverain.</dd>
							<dt>Usocrate / u.zɔ.kʁat</dt>
							<dd>Concepteur de produits ou services qui fait de l'adéquation aux besoins réels des usagers le vecteur principal du progrès et de l'innovation</dd>
						</dl>
					</div>
				</div>
			</header>
		</section>
		<section id="manifesto">
			<h1>Manifeste<br><small>Pour une usocratie numérique</small></h1>
			<section id="intro">
				<p>
					Le numérique est le moteur d’une révolution sociale qui dépasse les problématiques technologiques.<br>
					Sa pratique transforme en profondeur les relations interpersonnelles, les rapports de production et la manière dont nous nous représentons le monde.</p>
				<p>
					Le constat est simple: les anciens modes de production industriels ne sont pas à la mesure des enjeux collectifs et individuels de cette transformation.<br>
					Le numérique a besoin d'une renaissance qui placerait l'humain au coeur de toute initiative... pour ne pas réduire l'innovation à une succession de gadgets technologiques inutiles, aliénants et hautement périssables.
				</p>
				<p>
					Pour ceux qui portent une démarche de conception centrée sur l’humain et les usages (ergonomes, designers), trop d’énergie est encore dépensée à convaincre les donneurs d’ordre et à obtenir les moyens de travailler.
				</p>
				<p>
					Ce manifeste veut contribuer à lever certains archaïsmes trop courants dans la conception de services numériques pour libérer l’innovation et augmenter l’utilité sociale de notre production.<br/>
					Professionnel du secteur numérique qui a entre les mains la destinée de services numériques (chef de produit, designers, chef de projets, financeur), ce manifeste s'adresse à toi.<br/>
				</p>
			</section>
			
			<section id="method">
				<h2><em>1</em> Méthode</h2>
				<h3>Conception Centrée Utilisateur</h3>
				<div>
					<p><strong><a href="https://www.iso.org/fr/standard/52075.html" target="_blank">ISO 9241-210</strong></a><br>Ergonomie de l'interaction homme-système -- Partie 210: Conception centrée sur l'opérateur humain pour les systèmes interactifs</p>
				</div>
			</section>

			<section id="purpose">
				<h2><em>2</em> Ambitions</h2>
				<div class="row">
					<div class="col-md-6">
						<div class="area">
							<h3>Humaniste</h3>
							<ul>
								<li><strong>Améliorer la vie des gens</strong>, impacter notamment leurs conditions de travail en construisant des outils numériques adaptés, efficaces et libérant les potentiels individuels.</li>
								<li>Mettre le numérique <strong>au service de l'intelligence humaine</strong>, refuser d’en faire un vecteur d’aliénation et de déshumanisation.</li>
								<li>Veiller à ce que les services développés soient accessibles et utilisables par tous pour <strong>une société numérique inclusive</strong>.</li>
							</ul>
							<p>
								<span class="badge badge-pill badge-default">Utilité</span>
								<span class="badge badge-pill badge-default">Progrès</span>
								<span class="badge badge-pill badge-default">Intégration</span>
								<span class="badge badge-pill badge-default">Société</span>
								<span class="badge badge-pill badge-default">Ethique</span>
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
								<li>Etre à l'écoute des usagers est <strong>le meilleur axe d’innovation</strong> pour les entreprises en ne les condamnant pas à copier leurs concurrents à moindre coût.</li>
							</ul>
							<p><span class="badge badge-pill badge-default">Rationalité</span> <span class="badge badge-pill badge-default">Créativité</span> <span class="badge badge-pill badge-default">Valeur ajoutée</span> <span class="badge badge-pill badge-default">Compétivité</span> <span class="badge badge-pill badge-default">Innovation</span> <span class="badge badge-pill badge-default">Agilité</span></p>
						</div>				
					</div>
				</div>
			</section>

			<section id="commitment">
				<h2><em>3</em> Engagements</h2>
				<h3>1- Porter toute l’attention aux usagers</h3>
				<blockquote style="display:none">Focus on the user and all else will follow (Google)<br/>Make things people want vs Make people want things.</blockquote>
				<div class="row">
					<div class="col-md-6">
						<div class="area">
							<h4>Aller sur le terrain, aimer le réel</h4>
							<p>Moi <span class="brand">usocrate</span>...</p>
							<ul>
								<?php
									foreach ($quotes as $q) {
										if (strcmp($q['set_id'], '1')==0) {
											echo '<li>'.ucfirst(htmlentities($q['content'])).'</li>';
										}
									}
								?>
							</ul>
							<p><span class="badge badge-default">Co-conception</span> <span class="badge badge-default">Principe de réalité</span> <span class="badge badge-default">#IRL</span></p>
						</div>
					</div>
					<div class="col-md-6">
						<div class="area">
							<h4>Respecter les usagers</h4>
							<p>Moi <span class="brand">usocrate</span>...</p>
							<ul>
								<?php
									foreach ($quotes as $q) {
										if (strcmp($q['set_id'], '2')==0) {
											echo '<li>'.ucfirst(htmlentities($q['content'])).'</li>';
										}
									}
								?>
							</ul>
							<p><span class="badge badge-default">Ecoute</span> <span class="badge badge-default">Considération</span> <span class="badge badge-default">Ethique</span></p>
						</div>
					</div>
				</div>
				
				<h3>2- Contribuer à changer les indicateurs de réussite des projets</h3>
				<blockquote style="display:none">Le numérique rend obsolète l'ancien modèle de production industriel.</blockquote>
				<div class="row">
					<div class="col-md-6">
						<div class="area">
							<h4>La valeur d’usage comme objectif</h4>
							<p>Moi <span class="brand">usocrate</span>...</p>
							<ul>
								<?php
									foreach ($quotes as $q) {
										if (strcmp($q['set_id'], '3')==0) {
											echo '<li>'.ucfirst(htmlentities($q['content'])).'</li>';
										}
									}
								?>
							</ul>
							<p><span class="badge badge-default">Valeur d'usage</span> <span class="badge badge-default">Service</span> <span class="badge badge-default">Bénéfice</span></p>								
						</div>
					</div>
					<div class="col-md-6">
						<div class="area">
							<h4>Mesurer la qualité de l’expérience</h4>
							<p>Moi <span class="brand">usocrate</span>...</p>
							<ul>
								<?php
									foreach ($quotes as $q) {
										if (strcmp($q['set_id'], '4')==0) {
											echo '<li>'.ucfirst(htmlentities($q['content'])).'</li>';
										}
									}
								?>
							</ul>
							<p><span class="badge badge-default">Expérience utilisateur</span> <span class="badge badge-default">Appropriation</span> <span class="badge badge-default">Satisfaction</span> <span class="badge badge-default">Productivité</span></p>							
						</div>
					</div>
				</div>
				
				<h3>3- Rappeler que la production de valeur est une activité sociale.</h3>
				<blockquote style="display:none">Etre usocrate c'est être un organisateur et un facilitateur.<br/>C'est viser à régler les dysfonctionnements internes de l'entreprise pour que toute l'énergie mobilisable le soit au profit des utilisateurs, sans dissipation.<br/>C'est s'engager dans la rationalisation la chaîne de production et la promotion radicale de la collaboration entre les différents acteurs du projet. Leadership, vision collective et agilité.</blockquote>
				<div class="row">
					<div class="col-md-6">
						<div class="area">
							<h4>Collaborer pour l'efficacité économique</h4>
							<p>Moi <span class="brand">usocrate</span>...</p>
							<ul>
								<?php
									foreach ($quotes as $q) {
										if (strcmp($q['set_id'], '5')==0) {
											echo '<li>'.ucfirst(htmlentities($q['content'])).'</li>';
										}
									}
								?>
							</ul>
							<p><span class="badge badge-default">Collaboration</span> <span class="badge badge-default">Planification</span> <span class="badge badge-default">Agilité</span></p>								
						</div>
					</div>
					<div class="col-md-6">
						<div class="area">
							<h4>Collaborer pour la créativité</h4>
							<p>Moi <span class="brand">usocrate</span>...</p>
							<ul>
								<?php
									foreach ($quotes as $q) {
										if (strcmp($q['set_id'], '6')==0) {
											echo '<li>'.ucfirst(htmlentities($q['content'])).'</li>';
										}
									}
								?>
							</ul>
							<p><span class="badge badge-default">Créativité</span> <span class="badge badge-default">Expérimentation</span></p>
						</div>
					</div>
				</div>
			</section>

			<section id="subscriptionArea">
				<div class="row justify-content-md-center">
		         	<div class="col-xs-12 col-md-8">
						<div class="card">
							<div class="card-block">
				       			<h1 class="text-center card-title brand"><small>Je suis</small> Usocrate <small>!</small></h1>
								<div class="card-text">
									<p>Peut-on vous compter parmi les rangs usocrates ?</p>
									<ol>
										<li>Je partage la vision et souhaite donner du poids à ce discours</li>
										<li>J'ai conscience de ma responsabilité individuelle et témoigne de ma volonté de mise en oeuvre des principes du manifeste dans mes pratiques professionnelles quotidiennes</li>
									</ol>
						            <form id="subscription_form">
						            	<div class="form-group ">
											<label>Je me présente</label>
											<input class="form-control input-lg" id="" name="id" value="" placeholder="un profil web Twitter, LinkedIn,..." type="text">
					                  	</div>
										<div class="form-group ">
											<label>Un email ?</label>
											<input required="" class="form-control input-lg" id="" name="mail" value="" placeholder="pour être informé de l'évolution de l'initiative usocrate.fr" type="email">
							            </div>
							            <input name="cmd" value="subscription" type="hidden"></input>
							            <button type="submit" class="btn btn-block btn-primary">Oui, j'en suis</button>
							        </form>
								</div>
							</div>
						</div>
		          	</div>
				</div>
			</section>

			<section id="socialSpreadArea" style="display:none">
				<div class="text-center">
						<a class="twitter-share-button"
					  href="https://twitter.com/intent/tweet?text=Hello%20world"
					  data-size="large">
					Tweet</a>
				</div>
			</section>

			<section id="references" style="display:none">
				<div class="area">
					<strong>Références</strong>
					<div class="row">
						<div>
							<ul>
								<li><a href="https://leblog.wcie.fr/2017/05/23/bauhaus-une-ethique-moderne-de-la-modernite/#.WSUcC0AQAW0.twitter">Bauhaus, une éthique moderne de la modernité</a></li>
								<li><a href="https://www.ted.com/talks/david_kelley_on_human_centered_design?language=fr">David Kelley parle du design centré sur l’humain</a> <small>(David Kelley)</small></li>
								<li><a href="http://www.gartner.com/smarterwithgartner/improve-user-experience-by-reducing-features/">Improve-user-experience-by-reducing-features, curing featuritis</a> <small>(Gartner)</small></li>
								<li><a href="http://headrush.typepad.com/creating_passionate_users/2005/06/featuritis_vs_t.html">Featuritis vs. the Happy User Peak</a> <small>(Create passionate users)</small></li>
								<li><a href="https://journal.thriveglobal.com/how-technology-hijacks-peoples-minds-from-a-magician-and-google-s-design-ethicist-56d62ef5edf3">How Technology is Hijacking Your Mind</a> <small>(Tristan Harris)</small></li>
								<li><a href="http://www.timewellspent.io/">timewellspent.io</a> <small>(Tristan Harris)</small></li>
								<li><a href="https://www.microsoft.com/en-us/design/inclusive">Inclusive Design at Microsoft</a> <small>(Microsoft)</small></li>
								<li><a href="https://youtu.be/-aMGT4DMiFY">L’avenir des interactions Hommes-Données</a> <small>(Caroline Goulard)</small><br/>Compréhension / Interaction / Attention / Responsabilisation / Adhésion</li>
								<li><a href="https://deardesignstudent.com/tagged/ethics">Ethics @deardesignstudent.com</a></li>
								<li><a href="https://mixpanel.com/">Mixpanel</a></li>
								<li><a href="http://boxesandarrows.com/monitoring-user-experience-through-product-usage-metrics/">Monitoring User Experience Through Product Usage Metrics</a> <small>(Jerrod Larson and Daan Lindhout)</small></li>
								<li><a href="http://blog.popcornmetrics.com/5-user-engagement-metrics-for-growth/">User Engagement: 5 Awesome Metrics for Growth</a></li>
								<li><a href="http://www.uxmatters.com/mt/archives/2014/06/choosing-the-right-metrics-for-user-experience.php">Choosing the Right Metrics for User Experience</a> <small>(Pamela Pavliscak)</small></li>
								<li><a href="https://library.gv.com/how-to-choose-the-right-ux-metrics-for-your-product-5f46359ab5be">How to choose the right ux metrics for your product</a> <small>(Kerry Rodden)</small></li>
								<li><a href="https://static1.squarespace.com/static/57c6b79629687fde090a0fdd/t/589911ba3a04117857abca73/1486426561759/dschool+operator%27s+handbook+G+Kembel+edit.pdf">George Kembel's "d.school Operator's Handbook"</a></li>
							</ul>
						</div>
					</div>
				</div>
			</section>
		</section>
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
				$.ajax({
				    url: "subscription.api.php",
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
</body>
</html>