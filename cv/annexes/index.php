<?php
require_once '../config/main.inc.php';
$doc_title = 'CV de Florent Chanavat : documents annexes';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo htmlentities($doc_title, ENT_QUOTES, 'UTF-8') ?></title>
<meta name="Keywords" content="dipl&ocirc;mes, bulletins de salaires, lettres de motivation" />
<meta name="Description" content="Pi&egrave;ces &agrave; apporter &agrave; mes dossiers de candidature." />
<meta name="author" content="Florent CHANAVAT" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="icon" type="image/x-icon" href="<?php echo SKIN_URL ?>img/favicon.ico" />
<link rel="stylesheet" type="text/css" href="<?php echo SKIN_URL ?>room.css" />
<style type="text/css">
	#corps {margin:4px auto;}
</style>
  
</head>
<body>
<div class="page">
	<div id="entete"><?php include '../inc/head.inc.php' ?></div>
	<div id="corps">
	<h1><?php echo htmlentities($doc_title, ENT_QUOTES, 'UTF-8') ?></h1>
	<dl>
	<dt><a href="dess_diplome.pdf">Le dipl&ocirc;me le plus significatif</a></dt>
	<dd>Version num&eacute;rique de mon dipl&ocirc;me Bac+5 (DESS d&rsquo;ergonomie), d&eacute;livr&eacute; en 1999 par l&rsquo;Universit&eacute; Paris V.</dd>
	<dt><a href="salaire_bulletin.pdf">Un bulletin de salaire</a></dt>
	<dd>Un exemplaire (d&eacute;c. 2006) de mes bulletins de salaires chez Action on line.</dd>
	<dt><a href="cpam_motivation_lettre.pdf">Une lettre de motivation</a></dt>
	<dd>Lettre &agrave; l&rsquo;attention du directeur du service informatique de la CPAM.</dd>
	<dt><a href="alg_reco_lettre.pdf">Une lettre de recommandation</a></dt>
	<dd>Alexis Garin, Directeur Général de la société Action on line en 2005 et 2006, fut mon supérieur hiérarchique pendant ces deux années.</dd>
	<dt><a href="cni.tif">Ma carte nationale d&rsquo;identité</a></dt>
	<dd>Au format .tif</dd>	
	</dl>
	</div>
	<div id="foot">
		<?php include '../inc/foot.inc.php' ?>
	</div>
</div>
</body>
</html>
