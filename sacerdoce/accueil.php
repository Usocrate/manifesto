<?php
	include_once 'config/main.inc.php';
	include_once './class/enseignant.class.php';
	include_once 'util.php';

	session_start();
	if (empty($_SESSION['code_affectation'])) header('Location: index.php');
	dbconnect();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Accueil mesClasses</title>
	<link rel="stylesheet" type="text/css" href="css/main.css" />
</head>
<body>
<?php
	$user = new Enseignant($_SESSION['code_enseignant']);
	if ($_SESSION['code_lastAffectation']!=$_SESSION['code_affectation']){
		echo '<h1>';
		echo $user->getNomEtablissement($_SESSION['code_affectation']).'<br />';
		echo '<small>( archives )</small>';
		echo '</h1>';		
	}
	else {
		echo '<h1>';
		echo '<small>Bienvenue au&nbsp;'.$user->getTypeEtablissement($_SESSION['code_affectation']).'</small><br />';
		echo $user->getNomEtablissement($_SESSION['code_affectation']);
		echo '</h1>';
		echo '<div class="tools">';
		echo '<h1>Nouvelle affectation</h1>';
		echo '<p>Si vous changez d\'établissement en cours d\'année<br /> ou si vous voulez entamer une nouvelle année scolaire,</p>';
		echo '<a href="affectation.php" target="_top"><strong>>&nbsp;Cliquez ici</strong></a>';		
		echo '</div>';
	}
?>
</body>
</html>