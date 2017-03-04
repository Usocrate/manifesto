<?php
	include_once 'config/main.inc.php';
	include_once './class/enseignant.class.php';
	include_once 'util.php';

	session_start();

	if(isset($_REQUEST['code_affectation'])){
		$_SESSION['code_affectation'] = $_REQUEST['code_affectation'];
	}
	if(empty($_SESSION['code_affectation'])) header('location:index.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Mes Classes : outil de gestion de bulletins de notes à disposition des enseignants d'histoire - géographie</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<frameset cols="300, *" border="0">
  <frame scrolling="no" name="menu" src="menu_classes.php?mode_affichage=menu">
  <frame name="main" src="accueil.php">
</frameset>
<noframes></noframes>
</html>
