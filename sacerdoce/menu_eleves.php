<?php
	include_once 'config/main.inc.php';
	include_once './class/classe.class.php';
	require 'util.php';
	
	session_start();
	if (empty($_SESSION['code_affectation'])) header('Location: index.php');
	dbconnect();
	
	$classe = new Classe($_REQUEST['code_classe']);
	$classe->initFromDB();
	$classe->getEleves();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Les &eacute;l&egrave;ves</title>
	<link rel="stylesheet" type="text/css" href="css/main.css" />
</head>
<body style="margin:0">
<h1><big><?php echo count($classe->eleves); ?></big>&nbsp;élèves</h1>
<ul>
	<?php 
	foreach ($classe->eleves as $e){
		echo '<li>';
		echo "<a target=\"fiche_eleve\" href=\"eleve.php?code_classe=".$classe->code."&code_eleve=".$e->code."\">";
		echo $e->getNomComplet();
		echo '</a>';
		echo '</li>';
	}
	?>
</ul>
<div class="tools">
	<?php
		if ($_SESSION['code_affectation'] == $_SESSION['code_lastAffectation']){
			echo '<ul>';
			echo '<li><a target="fiche_eleve" href="eleve_edit.php?code_classe='.$classe->code.'">Ajouter un élève</a></li>';
			echo '</ul>';
		}
	?>
</div>
<div class="jumpnav"><a target="_parent" href="classe.php?code_classe=<?php echo $classe->code; ?>">Retour</a></div>
</body>
</html>