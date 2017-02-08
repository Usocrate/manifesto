<?php
require_once 'config/main.inc.php';
require_once 'class/Cv.class.php'
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="FR" lang="FR">
<head>
<title>CV de Florent Chanavat : Concepteur | D&eacute;veloppeur Web PHP
(Lyon)</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Keywords"
	content="<?php echo htmlentities(Cv::getMainKeywords(),ENT_QUOTES,'UTF-8') ?>" />
<meta name="Description"
	content="<?php echo htmlentities(Cv::getMainDescription(),ENT_QUOTES,'UTF-8'); ?>" />
<meta name="author" content="Florent CHANAVAT" />
<link rel="icon" type="image/x-icon"
	href="<?php echo SKIN_URL ?>img/favicon.ico" />
<link rel="alternate" href="cv_developpeur_chanavat_florent.pdf"
	type="application/pdf" media="print"
	title="Le cv de Florent Chanavat au format pdf" />
<link rel="stylesheet" type="text/css"
	href="<?php echo SKIN_URL ?>home.css" />
<?php include_once 'inc/ga_tracker.inc.php' ?>
</head>
<body>
<div class="wrapper">
<h1><span>Concepteur | D&eacute;veloppeur Web</span></h1>
<div id="badge"></div>
<div id="etiquette"><img src="<?php echo SKIN_URL ?>img/nom.gif"
	width="13" height="107" alt="Florent Chanavat" /></div>
<div id="corps">
<h2>Mon profil en quelques lignes ...</h2>
<p>Professionnel du web <strong>depuis 2000</strong>, un parcours riche
en expériences (SSII, WebAgency, Start-up) ...</p>
<p>7 ans d&rsquo;expérience en <strong>d&eacute;veloppement PHP</strong>,
conception et gestion de <strong>bases de donn&eacute;es MySQL</strong>,
mise en page et mise en interactivit&eacute; de documents web (XHMTL,
CSS, DOM, ECMAScript, ActionScript) ...</p>
<p>Dipl&ocirc;m&eacute; en <span title="DESS de Paris V obtenu en 1999">ergonomie
cognitive</span> appliqu&eacute;e &agrave; la conception d&rsquo;IHM
(Interface Homme-Machine) pour une <strong>conception orientée
utilisateur</strong> ...</p>
<p>Une <strong>culture graphique</strong> (histoire, typographie,
logiciels)...</p>
<p><a href="competences.php">&gt; Parcourir mon CV</a></p>
</div>
<div id="foot"><?php include './inc/foot.inc.php' ?></div>
</div>
</body>
</html>
