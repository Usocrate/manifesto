<?php
include_once '../bookmarks/config/main.inc.php';
include_once '../bookmarks/class/ToolBox.class.php';
include_once '../bookmarks/class/System.class.php';
include_once '../bookmarks/class/Topic.class.php';

//	MES FAVORIS
//	les identifiants des catégories de ressources mettre en relief
$topicstohighlight_ids = array(67,3);
$system = new System();
ToolBox::getDBAccess();
?>
<div class="menu_box">
<h1>CV</h1>
<ul>
	<li><a href="competences.php">Comp&eacute;tences</a></li>
	<li><span class="topic">Exp&eacute;riences</span>
	<ul>
		<li><a href="woonoz.php"><strong>Woonoz</strong></a></li>
		<li><a href="action-on-line.php">Action on line</a></li>
		<li><a href="idep-multimedia.php">Idep Multimedia</a></li>
		<li><a href="cosmosbay-vectis.php">Cosmosbay</a></li>
		<li><a href="cincom-dss.php">Cincom DSS</a></li>
		<!-- <li><a href="st-michel_cinema.php">Cin&eacute;ma St Michel</a></li>  -->
	</ul>
	</li>
	<li><a href="ergonomie-psychologie-cognitive.php" class="topic">Dipl&ocirc;mes</a></li>
</ul>
<br />
<p><span id="cv_pdf" class="alternateLink">PDF</span>&nbsp;<a href="cv_developpeur_chanavat_florent.pdf" target="_blank" onmouseover="document.getElementById('cv_pdf').className='pdfLink'"
	onmouseout="document.getElementById('cv_pdf').className='alternateLink'"
>CV au format pdf</a></p>
</div>
<br />

<div class="menu_box">
<h1><a target="_blank" href="<?php echo PROJECT_URL ?>">Ressources</a></h1>
<p style="margin: 6px;"><small>Une mani&egrave;re originale de d&eacute;couvrir mes centres d&rsquo;int&eacute;r&ecirc;ts : parcourez la liste de mes favoris ...</small></p>
<ul>
<?php
foreach ($topicstohighlight_ids as $id) {
	$t = new Topic($id);
	$t->hydrate($row);
	$html = '<li>';
	$html.= '<a href="'.PROJECT_URL.'topic.php?topic_id='.$t->getId().'" target="_blank">';
	$html.= htmlentities($t->getTitle(), ENT_QUOTES, 'UTF-8');
	$html.= '</a>';
	$html.= '</li>';
	echo $html;
}
?>
	<li><a target="_blank" href="<?php echo PROJECT_URL ?>">etc ...</a></li>
</ul>
</div>
<div><a href="index.php" target="_top"><small>&lt;&lt; Relire l&rsquo;introduction</small></a></div>
