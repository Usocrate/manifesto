<?php
	include_once 'config/main.inc.php';
	include_once './class/affectation.class.php';
	include_once './class/classe.class.php';
	include_once './class/enseignant.class.php';
	require 'util.php';

	session_start();
	if (empty($_SESSION['code_affectation'])) header('Location: index.php');
	dbconnect();

	if (isset($_REQUEST['add_classe'])){
		$c = new Classe();
		$c->setFeatures($_REQUEST['niveau'], $_REQUEST['indice'], $_SESSION['code_affectation']);
		$c->toDB();
	}
	
	if (isset($_REQUEST['remove_classe'])){
		$c = new Classe($_REQUEST['code_classe']);
		//	$c->getEleves();
		$c->initDevoirsFromDB();
		$c->removeFromDB();
	}
	
	$user = new Enseignant ($_SESSION['code_enseignant']);
	$affectation = new Affectation ($_SESSION['code_affectation']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>menu classes</title>
<link rel="stylesheet" type="text/css" href="css/main.css" />
<style type="text/css">
BODY {
	border-width:0 1px 0 0;
	border-color:#000;
	border-style:solid;
	width:250px;
	padding:0;
	margin: 0 0 0 auto;}
A {
	text-decoration:none;
	color:inherit}
A:hover {
	color:#CC0000}
H1{
	text-align:right;
	background-color:#fff;
	color:#9C0;
	font-family: "Memphis Extra Bold", "Courier New", Courier, mono;
	font-size:24px;
	text-transform:uppercase;
	margin: 0 0 0 0;
	border-width:1px solid #000000;}
H1 SMALL{
	color:inherit;
	font-size:16px;
	text-transform: capitalize;}
UL {
	text-align:left;
	padding:20px 10px;}
.tools{
	/*
	background-image:url('images/benet_part4.gif');
	background-position:top right;
	background-repeat:no-repeat;
	*/
}
#content{
	background-image:url('images/benet_cut.jpg');
	background-position:bottom right;
	background-repeat:no-repeat;
	text-align:right;
	padding:10px 100px 10px 10px;
	min-height:350px;
}
</style>
</head>
<body onload="if (document.forms[0].length>0) document.forms[0].elements[0].focus();">
<div id="content">
<h1><small>Mes</small><br />Classes</h1>
<?php 	
	if ($_REQUEST['mode_affichage']=='menu'){ 
		echo '<form action="frameset.php" target="_top" method="post">';
		echo '<label>année</label>&nbsp;';
		$user->getAffectationsSelect($_SESSION['code_affectation']);
		echo '</form>';
	}				
	else echo '<p>'.$affectation->getAnneeScolaire().'</p>';
?>
<?php
	switch($_REQUEST['mode_affichage']){
		case 'ajouter':
		if ($_SESSION['code_affectation'] == $_SESSION['code_lastAffectation']) {
			echo "<form action=\"".$_SERVER['PHP_SELF']."\" method=\"post\">\n";
			// sélection du niveau
			echo '<p>';
			echo '<label>Niveau</label><br />';	
			getSelectNiveau($affectation->getTypeEtablissement());
			echo '</p>';
			echo '<p>';				
			echo '<label>Numéro</label><br />';	
			echo "<input name=\"indice\" type=\"text\" size=\"2\" maxlength=\"2\">\n";
			echo "<input type=\"hidden\" name=\"mode_affichage\" value=\"menu\">";		
			echo '</p>';
			echo '<button type="submit" name="add_classe" value="1">créer</button>';
			echo '<button type="submit" name="annuler" value="1">abandonner</button>';
			echo "</form>\n";
		}
		break;

		case 'supprimer':
		if ($_SESSION['code_affectation']==$_SESSION['code_lastAffectation']) {
			if (!isset($affectation->classes)) $affectation->setClasses();	
			echo "<form action=\"menu_classes.php\" method=\"post\">";
			echo '<p>';
			echo '<label>Classe à supprimer</label><br />';
			echo "<select name=\"code_classe\">\n";
			echo "<option>-- choisir --</option>";
			for ($i=0; $i<count($affectation->classes); $i++){
				echo "<option value=\"".$affectation->classes[$i]->code."\">";
				echo $affectation->classes[$i]->getChaine();
				echo "</option>\n";
			}
			echo "</select>";
			echo '<p>';
			echo "<input type=\"hidden\" name=\"mode_affichage\" value=\"menu\">";
			echo '<button type="submit" name="remove_classe" value="1">supprimer</button>';
			echo '<button type="submit" name="annuler" value="1">abandonner</button>';
			echo "</form>";
		}
		break;

		default:
			if (!isset($affectation->classes))	$affectation->setClasses();
			//echo '<big>';
			echo '<ul>';
			foreach($affectation->classes as $c){
				echo '<li>';
				echo '<a href="classe.php?code_classe='.$c->code.'" target="main">';
				echo $c->getChaine();
				echo '</a>';
				echo '</li>';
			}
			echo '</ul>';
			//echo '</big>';				
		}
		echo '</div>';

		if($_REQUEST['mode_affichage']=='menu'){
			if ($_SESSION['code_affectation'] == $_SESSION['code_lastAffectation']) {
				echo '<div class="tools">';
				echo '<ul>';
				echo '<li><a href="menu_classes.php?mode_affichage=ajouter">Créer une classe</a></li>';
				echo '<li><a href="menu_classes.php?mode_affichage=supprimer">Supprimer une classe</a></li>';
				echo '</ul>';
				echo '</div>';
			}
		}
	?>
</div>
<div class="jumpnav"><a href="index.php?deconnexion=1" target="top">Quitter</a></div>
</body>
</html>
