<?php
function __autoload($class_name) {
	$path = './classes/';
	if (is_file ( $path . $class_name . '.class.php' )) {
		include_once $path . $class_name . '.class.php';
	} elseif ($path . $class_name . '.interface.php') {
		include_once $path . $class_name . '.interface.php';
	}
}
$system = new System ( './config/host.json' );

header('charset=utf-8');
?>
<!doctype html>
<html lang="fr">
<head>
	<meta charset="UTF-8">	
	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<meta name="description" content="<?php echo htmlentities($system->getProjectDescription()) ?>" />
	<title><?php echo htmlentities($system->getProjectName()) ?></title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="skin/home.css" />
</head>
<body>
	<div class="container">
		<?php //phpinfo(); ?>
		<section id="usocrateDef">
			<header>
				<div class="jumbotron">
					<div>
						<h1>Usocrate.fr</h1>
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
					Sa pratique transforme en profondeur les relations interpersonnelles, les rapports de production ou la manière dont nous nous représentons le monde.</p>
				<p>
					Les anciens modes de production industriels ne sont plus à la mesure des enjeux collectifs et individuels liés à la transformation actuelle.<br>
					Nous avons besoin d'une renaissance numérique qui placerait l'humain au coeur de toute initiative... pour ne pas réduire l'innovation à une succession de gadgets technologiques inutiles, aliénants et hautement périssables.<br>
				</p>
				<p>
					Pour ceux qui portent une démarche de conception centrée sur l’humain et les usages (ergonomes, designers), trop d’énergie est encore dépensée à convaincre les donneurs d’ordre et à obtenir les moyens de travailler.
				</p>
				<p>
					Ce manifeste veut contribuer à lever certains archaïsmes trop courants dans la conception de services numériques pour libérer l’innovation et augmenter l’utilité sociale de notre production.<br/>
					Professionnel du secteur numérique qui a entre les mains la destinée de services numériques (chef de produit, designers, chef de projets, financeur), ce manifeste s'adresse à toi.<br/>
					Il te propose de partager une vision.
				</p>
			</section>
			
			<section id="method">
				<h2>1 Méthode</h2>
				<div class="area">
					<p>Aller <strong>à la rencontre des usagers</strong> et faire de la <strong>valeur d’usage</strong> le premier indicateur du progrès et de l’innovation.</p>
				</div>
			</section>

			<section id="purpose">
				<h2>2 Ambitions</h2>
				<div class="row">
					<div class="col-md-6">
						<div class="area">
							<h4>Humaniste</h4>
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
							<h4>Economique</h4>
							<ul>
								<li>
									Pour notre compétitivité, il est urgent de rompre avec l'apathie généralisée face à la nécessité de <strong>faire de bons produits</strong>.<br>
									Il s'agit de garantir l'<strong>utilité</strong>, l'<strong>utilisabilité</strong> et l'<strong>attractivité</strong> de notre production numérique.
								</li>
								<li>Penser "valeur d'usage" permet de <strong>rationaliser les politiques d'investissements</strong> et d'<strong>assurer la viabilité des services numériques développés</strong> qu’ils le soient dans un esprit de service public ou pour le secteur marchand.</li>
								<li>Etre à l'écoute des usagers est <strong>le meilleur axe d’innovation</strong> pour les entreprises en ne les condamnant pas à copier leurs concurrents à moindre coût.</li>
							</ul>
							<p><span class="badge badge-pill badge-default">Rationalité</span> <span class="badge badge-pill badge-default">Créativité</span> <span class="badge badge-pill badge-default">Valeur ajoutée</span> <span class="badge badge-pill badge-default">Compétivité</span> <span class="badge badge-pill badge-default">Innovation</span> <span class="badge badge-pill badge-default">Agilité</span></p>
						</div>				
					</div>
				</div>
			</section>

			<section id="commitment">
				<h2>3 Engagements</h2>
				<h3>1- Porter toute l'attention aux usagers</h3>
				<blockquote style="display:none">Focus on the user and all else will follow (Google)<br/>Make things people want vs Make people want things.</blockquote>
				<div class="row">
					<div class="col-md-6">
						<div class="area">
							<h4>Aller sur le terrain, aimer le réel</h4>
							<p>Moi usocrate...</p>
							<ul>
								<li>J’affirme l’impossibilité d'un design hors sol, sans connaissance du contexte dans lequel le produit sera utilisé.</li>
								<li>J’ai la volonté de sortir de mon bureau pour aller à la rencontre des usagers aussi souvent que possible.</li>
								<li>Je fais de la résolution des problèmes des usagers l'objectif premier d'une démarche de conception</li>
								<li>Je refuse l'idée d'un utilisateur générique et idéalisé qui adhèrerait à la logique du produit, sans culture, besoins ou problématiques particulières.</li>
								<li>Je favorise les approches de co-conception, impliquant directement les usagers, même si cela complexifie les prises de décisions</li>
								<li>Je mets en place des méthodes et outils pour collecter de l’information de terrain et travaille à la maîtrise de ces outils</li>
								<li>Je m’attache à des faits, pas à des opinions</li>
								<li>Je confronte au plus tôt les usagers au produit</li>
								<li>Je pense qu'il est important que les prototypes testés auprès d'usagers potentiels soient construits sur des données réelles, c'est à dire non fictives, parcellaires ou fantaisistes.</li>
							</ul>
							<p><span class="badge badge-default">Co-conception</span> <span class="badge badge-default">Principe de réalité</span> <span class="badge badge-default">#IRL</span></p>
						</div>
					</div>
					<div class="col-md-6">
						<div class="area">
							<h4>Respecter les usagers</h4>
							<p>Moi usocrate...</p>
							<ul>
								<li>Je valorise l'écoute et l'empathie</li>
								<li>Je ne recycle pas a priori des solutions existantes sans considérer ce que le projet a de spécifique</li>
								<li>Je ne discrédite pas les usagers et ne justifie pas de dysfonctionnements par leur incapacité</li>
								<li>J’admets l’idée que les comportements des usagers face au produit puissent être en décalage avec ce qui était attendu</li>
								<li>Je ne m’approprie pas le produit pour en faire ce qu'il me plairait, je ne me substitue pas aux usagers</li>
								<li>Je modère l'expression des opinions et goûts personnels des membres de l'équipe projet.</li>
								<li>Je n'abandonne pas les usagers aux possibilités de paramétrage dont les outils disposent et vise à leur proposer un produit adapté.</li>
								<li>Je suppose que les usagers ont autre chose à faire que de lire de la documentation ou suivre des tutoriaux</li>
								<li>Je ne cherche pas à tromper les usagers pour obtenir des profits courts termes mais travaille à développer une relation de confiance durable</li>
								<li>Je prends soin des usagers en me souciant de l'impact des choix de conception sur leur bien-être</li>
								<li>Je reconnais la dimension éthique du design</li>
							</ul>
							<p><span class="badge badge-default">Ecoute</span> <span class="badge badge-default">Ethique</span></p>
						</div>
					</div>
				</div>
				
				<h3>2- Contribuer à changer les indicateurs de réussite des projets</h3>
				<blockquote style="display:none">Le numérique rend obsolète l'ancien modèle de production industriel.</blockquote>
				<div class="row">
					<div class="col-md-6">
						<div class="area">
							<h4>La valeur d’usage comme projet économique</h4>
							<p>Moi usocrate...</p>
							<ul>
								<li>Je crois que c'est la qualité du service rendu à l'usager qui permet d'asseoir la pérennité d'une production numérique.</li>
								<li>Je pense que l'échec de beaucoup de produits numériques est prévisible si leur utilité et leur désirabilité n'ont pas été questionnées auprès des usagers.</li>
								<li>Je pense qu'aujourd'hui le principal moteur de croissance c'est le produit et plus les forces de ventes et le marketing.</li>
								<li>Je lutte contre une stratégie produit réduite à l'accumulation de fonctionnalités en affirmant que ce n’est ni la somme de celles-ci, ni le temps consacré à les développer qui fait la valeur du produit.</li>
								<li>Je recherche la simplicité comme un objectif en soi</li>
								<li>Je crois pas que parce que quelque chose est possible techniquement et à moindre coût, qu'il faut le faire, et refuse que la faisabilité technique décide de la feuille de route.</li>
								<li>Je pense que la disponibilité des développeurs informatiques ne justifie en aucun cas d'engager des évolutions du produit et que la volonté d'optimiser leur taux d’occupation ne devrait jamais être décisive.</li>
								<li>Je constate que fixer des échéances de livraison du produit a priori trahit le plus souvent un manque de vision produit.</li>
								<li>Je ne crois pas que la tenue des délais de livraison soit une fin en soi.</li>
								<li>Je ne suis pas un suiveur de tendances.</li>
								<li>Je ne confonds pas nouveauté et innovation.</li>
								<li>Je crois que la volonté de se distinguer de la concurrence n'est pas une bonne motivation pour innover.</li>							
								<li>Je pense qu'à copier les concurrents, on met en danger la compétitivité des produits dont on a la charge.</li>
								<li>Je crois que la démonstration technologique spectaculaire intéresse davantage les forces de ventes que les usagers.</li>
								<li>Je pense que l'industrialisation de la chaîne de production ne devrait jamais se faire au détriment de la capacité à proposer aux usagers des services adaptés à leurs besoins.</li>
							</ul>
							<p><span class="badge badge-default">Valeur d'usage</span> <span class="badge badge-default">Service</span> <span class="badge badge-default">Bénéfice</span></p>								
						</div>
					</div>
					<div class="col-md-6">
						<div class="area">
							<h4>Mesurer les résultats</h4>
							<p>Moi usocrate...</p>
							<ul>
								<li>Je pense que les bénéfices apportés aux usagers par un service numérique se mesurent.</li>
								<li>Je mets systématiquement en place une démarche et des outils de captation des retours d’expérience</li>
								<li>Je pense qu'une bonne stratégie produit s'accompagne nécessairement d'indicateurs permettant d'en mesurer la pertinence.</li>
								<li>Je mesure la pertinence des orientations prises aux bénéfices perceptibles par les usagers.</li>							
								<li>Je pense qu'une conception réussie sert des objectifs qu'on se fixe au départ.</li>
								<li>Je ne considère pas que le travail soit terminé lorsqu'une fonctionalité est publiée à moins d'un engagement durable et effectif des usagers à l'utiliser.</li>
								<li>J'organise la chaîne de production pour diffuser en continu les évolutions du produit afin d'apprendre au plus tôt des réactions des usagers.</li>
								<li>Je pense que la facilité de compréhension et de prise en main d'un produit numérique est un avantage concurrentiel majeur.</li>
								<li>Je pense que la satisfaction et la confiance des usagers sont des conditions nécessaires à leur fidélisation et à l'éventualité qu'ils recommandent le service.</li>
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
							<p>Moi usocrate...</p>
							<ul>
								<li>Je pense que le partage d'une vision commune entre les protagonistes du projet est un facteur clé de réussite.</li>
								<li>Je ne stigmatise pas a priori comme improductifs les temps d'échange.</li>
								<li>Je refuse le jargon et j'ai le soucis que tous les membres de l'équipe parlent le même langage.</li>							
								<li>Je n'ai pas le goût des débats d'experts</li>
								<li>Je mobilise toute mon énergie à l'amélioration du produit livré aux usagers.</li>
								<li>Je ne suis pas attaché à ma propre position d'expert et privilégie la collaboration à la juxtaposition d'avis.</li>
								<li>Je pense que les activités de tous les contributeurs du projet doivent être planifiées de manière cohérente, sans discrimination.</li>
								<li>Je crois aux vertus de la planification.</li>
								<li>Je travaille à la résolution des conflits d’intérêts plutôt qu'à leur exploitation à des fins politiques.</li>
								<li>Je fais la chasse aux livrables inutiles et privilégie l'échange à la documentation.</li>
								<li>Je considère de mon devoir de répondre aux demandes des usagers.</li>
								<li>Je m'attache à ce que chaque membre de l'équipe se sente responsable de la réussite du projet.</li>
							</ul>
							<p><span class="badge badge-default">Collaboration</span> <span class="badge badge-default">Planification</span> <span class="badge badge-default">Agilité</span></p>								
						</div>
					</div>
					<div class="col-md-6">
						<div class="area">
							<h4>Collaborer pour la créativité et l'innovation</h4>
							<p>Moi usocrate...</p>
							<ul>
								<li>Je m’assure que tous les participants au projet se sentent légitimes dans leur rôle contributif.</li>
								<li>Je travaille à casser les silos cloisonnant les différents métiers de l'entreprise au service des usagers.</li>
								<li>Je crois que les meilleures solutions émanent d'équipes pluridisciplinaires.</li>
								<li>Je suis convaincu qu'une phase d'exploration, d'ouverture à des domaines connexes, d'acculturation est nécessaire à toute démarche d'innovation. Je valorise et organise de telles phases de recherche.</li>
								<li>Je valorise l'expérimentation.</li>
								<li>Je fais la promotion de la culture design.</li>
								<li>Je pense qu'un dispositif de cocréation favorise l'efficacité en alignant tous les membres du projets sur les objectifs des usagers.</li>
								<li>J'essaie de faire preuve d’humilité, je respecte les autres membres du projet, leur point de vue.</li>
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
				       			<h3 class="text-center card-title">Je suis Usocrate !</h3>
								<div class="card-text">
									<p>Peut-on vous compter parmi les rangs usocrates ?</p>
									<ul>
										<li>Je partage la vision, je souhaite donner du poids à ce discours</li>
										<li>J'ai conscience de ma responsabilité individuelle et je témoigne de ma volonté à mettre en oeuvre les principes du manifeste dans mes pratiques professionnelles quotidiennes</li>
									</ul>
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

			<section id="socialSpreadArea">
				<div class="text-center">
						<a class="twitter-share-button"
					  href="https://twitter.com/intent/tweet?text=Hello%20world"
					  data-size="large">
					Tweet</a>
				</div>
			</section>

			<section id="references">
				<div class="area">
					<strong>Références</strong>
					<div class="row">
						<div>
							<ul>
								<li><a href="https://leblog.wcie.fr/2017/05/23/bauhaus-une-ethique-moderne-de-la-modernite/#.WSUcC0AQAW0.twitter">Bauhaus, une éthique moderne de la modernité</a></li>
								<li><a href="http://www.gartner.com/smarterwithgartner/improve-user-experience-by-reducing-features/">Improve-user-experience-by-reducing-features, curing featuritis (Gartner)</a></li>
								<li><a href="http://headrush.typepad.com/creating_passionate_users/2005/06/featuritis_vs_t.html">Featuritis vs. the Happy User Peak (Create passionate users)</a></li>
								<li><a href="https://journal.thriveglobal.com/how-technology-hijacks-peoples-minds-from-a-magician-and-google-s-design-ethicist-56d62ef5edf3">How Technology is Hijacking Your Mind</a> <small>(Tristan Harris)</small></li>
								<li><a href="http://www.timewellspent.io/">timewellspent.io</a> <small>(Tristan Harris)</small></li>
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
	
	<?php if ($system->hasGoogleAnalyticsKey()): ?>
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
	  ga('create', '<?php echo $system->getGoogleAnalyticsKey() ?>', 'auto');
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