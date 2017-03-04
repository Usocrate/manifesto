<?php
	include_once 'config/main.inc.php'; 
	include_once './class/affectation.class.php';	
	include_once './class/etablissement.class.php';
	include_once './class/enseignant.class.php';
	include_once './class/system.class.php';
	include_once 'util.php';
	
	session_start();
	dbconnect();

	//	identification de l'enseignant
	if(isset($_SESSION['code_enseignant'])) $enseignant = new Enseignant($_SESSION['code_enseignant']);
	else header('location:index.php');
	
	$system = new System();
	
	if(isset($_POST['affectation_submit'])){
		$affectation = new Affectation();
		$etablissement = new Etablissement();
		$etablissement->setFeatures($_POST['nom_etablissement'], $_POST['type_etablissement'], $_POST['academie']);
		if(!$etablissement->identifyFromDB()){
			//	nouvel établissement
			$etablissement->toDB();
		}
		$affectation->setFeatures($_SESSION['code_enseignant'], $etablissement->code, $_REQUEST['annee_scolaire']);
		$affectation->toDB();
		$_SESSION['code_lastAffectation'] = $affectation->getCode();
		$_SESSION['code_affectation'] = $_SESSION['code_lastAffectation'];
		header('location:frameset.php');
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Mon affectation</title>
	<link rel="stylesheet" type="text/css" href="./css/main.css" />
	<script language="JavaScript" type="text/javascript">
		function Etablissement(code, nom, type, academie){
			this.code = code;
			this.nom = nom;
			this.type = type;
			this.academie = academie;
		}
		function checkForm(){
			return checkTypeEtablissement() && checkNomEtablissement() && checkAcademie();
		}
		function checkAcademie(){
			input = document.getElementById('academie');
			if(input.selectedIndex>0) return true;
			else {
				alert("L'académie doit être choisie !");
				input.focus();
				return false;
			}
		}
		function checkNomEtablissement(){
			input = document.getElementById('nom_etablissement');
			if (input.value.length>0) return true;
			else {
				alert("Le nom de l'établissement doit être saisi !");
				input.focus();
				return false;
			}
		}
		function checkTypeEtablissement(){
			input = document.getElementById('type_etablissement');
			if (input.selectedIndex>0) return true;
			else {
				alert("Le type de l'établissement doit être choisi !");
				imput.focus();
				return false;
			}
		}				
		function fillEtablissementForm(selectedIndex){
			if(selectedIndex>0){
				document.getElementById('nom_etablissement').value = etablissements[selectedIndex-1].nom;
				for (i=0; i<document.getElementById('type_etablissement').length; i++){
					if (document.getElementById('type_etablissement').options[i].value==etablissements[selectedIndex-1].type){
						document.getElementById('type_etablissement').options[i].selected=true;
						break;
					}
				}
				for (i=0; i<document.getElementById('academie').length; i++){
					if (document.getElementById('academie').options[i].value==etablissements[selectedIndex-1].academie){
						document.getElementById('academie').options[i].selected=true;					
						break;
					}
				}
			}
		}
		var etablissements = new Array();
	</script>
</head>
<body>

<h1>Votre affectation</h1>
<p class="message">Vous changez d'&eacute;tablissement ou entamez une nouvelle ann&eacute;e</p>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onsubmit="return checkForm()">
<table>
<tr>
	<th colspan=2>Quelle est l'ann&eacute;e scolaire concern&eacute;e ?</th>
</tr>
<tr>
	<td><label>ann&eacute;e scolaire</label></td>		
	<td>
		<input name="annee_scolaire" type="text" value="<?php echo getAnneeScolaire(); ?>"></input>
	</td>
</tr>				
<tr>
	<th colspan=2>Quel&nbsp;est&nbsp;votre&nbsp;&eacute;tablissement&nbsp;?</th>
</tr>
<tr>
	<td><label>>>> Est-il dans cette liste ?</label></td>
	<td>
		<select name="code_etablissement" onchange="fillEtablissementForm(this.selectedIndex)">
		<?php
		$sql = 'SELECT * FROM ';
		if(defined("DB_TABLE_PREFIX")) $sql.= DB_TABLE_PREFIX.'_';
		$sql.= 'etablissement ORDER BY nom';
		$selection = mysql_query($sql);
		echo "<option style=\"text-align:center\" > -- choisissez un établissement -- </option>";
		$i = 0;
		while($e = mysql_fetch_object($selection)){
			echo '<option value="'.$e->getCode().'"';
			// if ($e->code=$code_etablissement_courant) echo " selected";
			echo '>'.$e->nom.' ('.$e->type.', '.$e->academie.')</option>';
			echo '<script language="JavaScript" type="text/javascript">';
			echo 'etablissements['.$i.'] = new Etablissement('.$e->code.',"'.$e->nom.'","'.$e->type.'","'.$e->academie.'");';
			echo '</script>';
			$i++;
		}
		mysql_free_result($selection);
		?>
		</select>
	</td>
</tr>	
<tr>
	<td><label>type</label></td>
	<td>
		<?php echo Etablissement::getTypeSelect();?>
	</td>
</tr>
<tr>
	<td><label>nom &eacute;tablissement</label></td>
	<td>
	<input id="nom_etablissement" name="nom_etablissement" value="" type="text" size=25 maxlength=75></input>
	</td>
</tr>
<tr>
	<td><label>acad&eacute;mie</label></td>
	<td>
	<?php echo $system->getAcademieSelect(); ?>
	</td>
</tr>
<tr>
	<td></td>
	<td>
		<button name="affectation_submit" type="submit" value="1">Valider</button>
		<button name="affectation_cancel" type="submit" value="1" onclick="document.location.href='accueil.php'">Abandonner</button>
	</td>
</tr>				
</table>
</form>
</body>
</html>