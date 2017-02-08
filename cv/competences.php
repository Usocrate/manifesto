<?php
require_once 'config/main.inc.php';
require_once 'class/Cv.class.php';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>CV de Florent Chanavat : Développement web (PHP) &amp; Ergonomie</title>
<meta name="Keywords" content="<?php echo htmlentities(Cv::getMainKeywords(),ENT_QUOTES,'UTF-8') ?>" />
<meta name="Description" content="<?php echo htmlentities(Cv::getMainDescription(),ENT_QUOTES,'UTF-8') ?>" />
<meta name="author" content="Florent CHANAVAT" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="alternate" href="cv_developpeur_chanavat_florent.pdf" type="application/pdf" media="print" title="Le cv de Florent Chanavat au format pdf" />
<link rel="icon" type="image/x-icon" href="<?php echo SKIN_URL ?>img/favicon.ico" />
<link rel="stylesheet" type="text/css" href="<?php echo SKIN_URL ?>room.css" />
<?php include_once 'inc/ga_tracker.inc.php' ?>
</head>
<body>
<div class="page">
<div id="entete"><?php include './inc/head.inc.php' ?></div>
<div id="menu"><?php include './inc/menu.inc.php' ?></div>
<div id="corps">
<h1><strong>Comp&eacute;tences</strong></h1>
<small>Développement web &amp; Ergonomie</small>
<h2>D&eacute;veloppement web</h2>
<p>Programmation orient&eacute;e objet avec <strong>PHP5</strong>.</p>
<p>Conception, r&eacute;alisation et exploitation de bases de donn&eacute;es <strong>MySQL</strong>.</p>
<p>D&eacute;veloppement <strong>Action Script</strong> avec utilisation de sources de donn&eacute;es dynamiques (php/mySQL et XML).</p>
<p>Mise en page <strong>HTML</strong>, feuilles de style <strong>CSS</strong> et programmation <strong>Javascript</strong>.<br />
Mise en forme de documents <strong>XML</strong> via <strong>XSL</strong>.</p>
<p>Connaissance approfondie des <strong>standards W3C</strong> suivants: XML, RDF, RSS, SVG, XSL, XPath, XHTML, HTML, CSS et DOM.</p>
<p>Impl&eacute;mentation des standards e-learning concernant l'interop&eacute;rabilit&eacute; entre contenus p&eacute;dagogiques et plateformes de diffusion : <strong>AICC</strong> et <strong>SCORM</strong>.</p>
<h3>Logiciels de pr&eacute;dilection</h3>
<p><strong>Eclipse</strong> (PDT), Dreamweaver</p>
<h3>Frameworks</h3>
<p>PHP : <strong>PEAR</strong>, Zend, EzComponents</p>
<p>Javascript CSS :<strong>YUI</strong>, DOJO</p>
<h2>Conseil en ergonomie</h2>
<p><strong>Analyse fonctionnelle et formalisation du besoin</strong>: recueil de donn&eacute;es aupr&egrave;s des utilisateurs en activit&eacute; par interview et observation (comportement op&eacute;ratoires, proc&eacute;dures m&eacute;tiers).
Mod&eacute;lisation de la t&acirc;che.</p>
<p><strong>Architecture de site</strong>: d&eacute;coupage fonctionnel et hi&eacute;rarchisation du contenu en &eacute;crans (arborescence)</p>
<p><strong>Sp&eacute;cification d&rsquo;interfaces web</strong>: d&eacute;finition des principes de navigation et de pr&eacute;sentation, simulation de l&rsquo;interactivit&eacute; et recherche de coh&eacute;rence (storyboard).</p>
<p><strong>Audit d&rsquo;un existant</strong>: &eacute;valuation de la qualit&eacute; ergonomique d&rsquo;un site existant.</p>
<h2>Graphisme et Typographie</h2>
<h3>Logiciels de pr&eacute;dilection</h3>
<p><strong>Photoshop</strong>, Flash, Fireworks, GIMP, Inkscape</p>
<h2>Langues</h2>
<p><strong>Anglais</strong> : technique (articles,documentations).<br />
<strong>Italien</strong> : lectures (littérature, presse), voyages.</p>
</div>
<div id="foot"><?php include './inc/foot.inc.php' ?></div>
</div>
</body>
</html>