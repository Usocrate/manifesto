<?php
	include_once 'config/main.inc.php';
	include_once './class/classe.class.php';
	include_once './class/eleve.class.php';
	include_once './class/devoir.class.php';		
	include_once './class/performance.class.php';
	include_once './class/system.class.php';	
	include_once 'util.php';

	session_start();

	if (empty($_SESSION['code_affectation'])) header('Location: index.php');	
	dbconnect();

	$system =  new System();
	$eleve =  new Eleve();
	
	//	récupération des données en base
	if(!empty($_REQUEST['code_eleve'])) {
		$eleve->setCode($_REQUEST['code_eleve']);
		$eleve->initFromDB();
	}
	//	ajout ou modification de l'élève
	if (isset($_POST['eleve_save_order'])){
		formatUserPost($_POST);
		$eleve->dataFeed($_POST);
		$eleve->toDB();
	}
	//	suppression de élève
	if (isset($_POST['eleve_remove_order'])){
		$eleve->removeFromDB();
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Une fiche&eacute;l&egrave;ve</title>
	<link rel="stylesheet" type="text/css" href="css/main.css" />
	<script language="JavaScript" type="text/javascript">
		function checkForm(){
			return (checkNom() && checkPrenom() && checkDateNaissance());
		}
		function checkDateNaissance(){
			var filtre  = /^\d{1,2}\/\d{1,2}\/\d{4}$/;
			if (!filtre.test(document.forms[0].elements['date_naissance'].value)){
				alert("La date de naissance doit être au format suivant: jj/mm/aaaa !");
				document.forms[0].elements['date_naissance'].focus();
				return false;
			}
			else return true;
		}	
		function checkNom(){
			if (document.forms[0].elements['nom'].value.length==0){
				alert("Le nom de l'élève doit être saisi !");
				document.forms[0].elements['nom'].focus();
				return false;
			}
			else return true;
		}
		function checkPrenom(){
			if (document.forms[0].elements['nom'].value.length==0){
				alert("Le nom de l'élève doit être saisi !");
				document.forms[0].elements['nom'].focus();
				return false;
			}
			else return true;
		}
		function confirmSuppressionEleve() {
		  return confirm("Toutes les informations concernant l'élève seront définitivement effacées. Confirmes tu la suppression ?");
		}		
	</script>
</head>
<body onload="document.getElementById('firstinput').focus()">
<h1><small>élève</small>&nbsp;<?php echo $eleve->getCode() ? $eleve->getNomComplet() : 'nouveau' ?></h1>
<form target="_parent" action="eleves_frm.php" method="post" onsubmit="return checkForm()">
	<input type="hidden" name="code_classe" value="<?php echo $_REQUEST['code_classe']; ?>" />
	<input type="hidden" name="code_eleve" value="<?php echo $eleve->getCode(); ?>" />
	<input type="hidden" name="task" value="edit" />
	<table>
	<tbody>
		<tr>
			<td><label>Nom</label></td>
			<td>
				<input id="firstinput" name="nom_eleve" value="<?php echo $eleve->nom; ?>" type="text" size="15" maxlength="50">
			</td>
		</tr>
		<tr>
			<td><label>Pr&eacute;nom</label></td>
			<td>
				<input name="prenom_eleve" value="<?php echo $eleve->prenom; ?>" type="text" size="15" maxlength="30">
			</td>
		</tr>
		<tr>
			<td><label>Sexe</label></td>
			<td>
				<input name="sexe_eleve" type="radio" value="m"<?php if($eleve->sexe=='m') echo ' checked="checked"'; ?>>m
				<input name="sexe_eleve" type="radio" value="f"<?php if($eleve->sexe=='f') echo ' checked="checked"'; ?>>f
			</td>
		</tr>	
		<tr>
			<td nowrap><label>Date de naissance</label></td>
			<td>
				<input name="date_naissance_eleve" value="<?php echo formatDateForUser($eleve->date_naissance); ?>" type="text" size="10" maxlength="10">
				<span>&nbsp;jj/mm/aaaa</span>
			</td>
		</tr>
		<tr>
			<td><label>Doublant</label></td>
			<td>
				<input name="doublant_eleve" type="radio" value="oui"<?php if($eleve->doublant=='oui') echo ' checked'; ?>>oui
				<input name="doublant_eleve" type="radio" value="non"<?php if($eleve->doublant=='non') echo ' checked'; ?>>non
			</td>
		</tr>
		<tr>
			<td nowrap><label>Pays de naissance</label></td>
			<td>
				<input name="pays_naissance_eleve" value="<?php echo $eleve->pays_naissance; ?>" type="text" size="15" maxlength="35">
			</td>
		</tr>	
		<tr>
			<td style="vertical-align:top"><label>Commentaire libre</label></td>
			<td><textarea name="commentaire_eleve" cols="20" rows="5"><?php echo $eleve->commentaire; ?></textarea></td>
		</tr>
	</tbody>
	</table>
	<button name="eleve_save_order" type="submit" value="1">enregistrer</button>
	<?php if($eleve->getCode()): ?><button name="eleve_remove_order" type="submit" onclick="confirmSuppressionEleve()">Supprimer</button><?php endif; ?>
</form>
</body>
</html>