<?php 
	include_once 'config/main.inc.php';
	include_once './class/enseignant.class.php';
	include_once 'util.php';

	session_start();
	dbconnect();
	
	$messages = array();
	
	//
	// traitement d'une demande d'autentification d'enseignant
	//
	if (isset($_POST['login_submit'])) {
		//
		//	limitation du nombre d'essais
		//
		if (!isset($_SESSION['nb_essais'])) {
			$_SESSION['nb_essais'] = 1;
		} elseif ($_SESSION['nb_essais']>3) {
			header('Location:inscription.php');
		} else {
			$_SESSION['nb_essais']++;
		}
		
		$enseignant = new Enseignant();
		if (isset($_POST['nom_usage'])) $enseignant->setNomUsage($_POST['nom_usage']);
		if (isset($_POST['mot_de_passe'])) $enseignant->setMotDePasse($_POST['mot_de_passe']);
		if ($enseignant->identification()) {
			//
			//	l'enseignant est identifié
			//
			unset($_SESSION['nb_essais']);
			$_SESSION['code_enseignant'] = $enseignant->getCode();
			$messages[] = 'Enseignant identifié';
			//	on récupère le code de sa dernière affectation
			//	puis redirection
			$lastAffectation = $enseignant->getLastAffectation();
			if (!empty($lastAffectation->code)) {
				$messages[] = 'La dernière identification est connue';
				$_SESSION['code_lastAffectation'] = $lastAffectation->code;
				$_SESSION['code_affectation'] = $lastAffectation->code;
				header('Location:frameset.php');
			} else {
				header('location:affectation.php');
			}
		}
	} elseif (isset($_REQUEST['deconnexion'])) {
		//
		// demande de déconnexion de l'enseignant
		//
		session_unset();
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Mes Classes</title>
<link rel="stylesheet" type="text/css" href="css/main.css" />
<style type="text/css">
	BODY {
		margin:auto;
		width:400px;
		border-style:none;}
	FORM {
		background-image:url('images/mc_form_bg.gif');
		border-width:0 0 1px 9px;
		border-style:solid;
		border-color:#000000;		
		margin:0;
		padding:10px 10px 10px 0;
		width:340px;
	}
	FROM DIV {margin:10px 0;padding:0px}
	FORM P {
		margin:10px 0;
		padding:4px;
		background-color:#ffffff;
		border-width:1px 1px 1px 0;
		border-style:solid;
		border-color:#000000;
		line-height:18px;}

	FORM LABEL {
		vertical-align:middle;
		text-align:right;
		background-color:#000000;
		color:#FFFFFF;
		font-family:"Courier New",Courier, mono;
		font-size:11px;
		padding:3px;
	}
	FORM INPUT {
		border-color:#000000;
		border-style:solid;
		border-width:1px;
		color:#000;
		font-family: Verdana, Arial, Helvetica, sans-serif;
		font-size:10px;
		padding:3px;
		margin:3px 6px;
		vertical-align:middle;
	}
	FORM BUTTON {
		border-color:#000000;
		border-style: outset;
		border-width:1px;
		background-color:#003399;
		color:#FFFFFF;
		font-family: Arial, Helvetica, sans-serif;
		font-weight:bold;
		font-size:11px;
		padding:2px;
		margin:3px 6px;
		vertical-align:middle;
	}	
</style>
</head>
<body>
<?php echo implode('<br/>', $messages); //mouchard(); ?>
<div><img src="images/mc_accueil_head.gif" /></div>
<div><img src="images/mc_accueil_title.gif" /></div>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
  <p>Mes Classes est un programme, dédié aux enseignants en histoire-géographie, permettant d'archiver les notes de leurs élèves </p>
  <div>
    <label for="nom_usage">identifiant</label>
    <input name="nom_usage" type="text" size="15" maxlength="35">
  </div>
  <div>
    <label for="mot_de_passe">mot de passe</label>
    <input name="mot_de_passe" type="password" size="15" maxlength="35">
    <button name="login_submit" type="submit" value="1">connexion</button>
  </div>
</form>
<div style="text-align:center; padding:4px"><small>conception et réalisation : <a href="http://www.usocrate.fr" target="_blank"><strong>Usocrate.fr</strong></a></small></div>
</body>
</html>
