<?php
	include_once 'config/main.inc.php'; 
	include_once './class/affectation.class.php';	
	include_once './class/enseignant.class.php';
	include_once './class/etablissement.class.php';
	include_once 'util.php';
	session_start();	
	dbconnect();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link rel="stylesheet" type="text/css" href="css/main.css" />
	<?php
	if(isset($nom_enseignant)){
		// traitement du formulaire
		$sql = 'SELECT code FROM ';
		if(defined("DB_TABLE_PREFIX")) $sql.= DB_TABLE_PREFIX.'_';
		$sql.= 'enseignant';
		$sql.= ' WHERE nom_usage=\''.$nom_usage_enseignant.'\'';
		$selection = mysql_query($sql);
		if (mysql_num_rows($selection)<1){	
			$enseignant = new Enseignant();
			$enseignant -> setFeatures($nom_enseignant, $prenom_enseignant, $nom_usage_enseignant, $mot_de_passe_enseignant, $email_enseignant, $url_site_perso_enseignant);
			$enseignant -> toDB();
			$enseignant -> setCode(mysql_insert_id());
			$etablissement = new Etablissement();
			$etablissement -> setFeatures($nom_etablissement, $type_etablissement, $academie);	
			$sql = 'SELECT code FROM ';
			if(defined("DB_TABLE_PREFIX")) $sql.= DB_TABLE_PREFIX.'_';
			$sql.= 'etablissement';
			$sql.= ' WHERE nom_etablissement=\''.$nom_etablissement.'\'';
			$sql.= ' AND type=\''.$type_etablissement.'\'';
			$sql.= ' AND academie=\''.$academie.'\'';
			$selection = mysql_query($sql);
			if (mysql_num_rows($selection)<1){
				$etablissement->toDB();
			}
			else {
				$e = mysql_fetch_object($selection);
				$etablissement -> setCode($e->code);
			}		
			$affectation = new Affectation();
			$affectation->setFeatures($enseignant->code, $etablissement->code, $annee_scolaire);
			$affectation->toDB();
			// enregistrement des variables de session
			$_SESSION['code_enseignant'] = $enseignant->code;			
			$_SESSION['code_lastAffectation'] = mysql_insert_id();
			$_SESSION['code_affectation'] = $_SESSION['code_lastAffectation'];
			echo '<script language="JavaScript" type="text/javascript">';
			echo "window.document.location.href='$url_redirection';";
			echo '</script>';
		}
		else alerte("Il faut changer de nom d'usage (déjà pris) !");
	}
	?>	
	<script language="JavaScript" type="text/javascript">
		function Etablissement(code, nom, type, academie){
			this.code = code;
			this.nom = nom;
			this.type = type;
			this.academie = academie;
		}

		function checkAcademie(){
			if (document.forms[0].elements['academie'].options[0].selected==true){
				alert("L'académie doit être choisie !");
				document.forms[0].elements['academie'].focus();
				return false;
			}
			else return true;
		}

		function checkEmail(){
			var filtre  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9])+$/;
			if (!filtre.test(document.forms[0].elements['email_enseignant'].value)){
				alert("L'adresse e-mail saisie est invalide !");
				document.forms[0].elements['email_enseignant'].focus();
				return false;
			}
			else return true;
		}

		function checkForm(){
			if(checkEmail() && checkTypeEtablissement() && checkNomEtablissement() && checkAcademie() && checkNomUsage() && checkPassword()){
				document.forms[0].submit();
			}
		}

		function checkNomEtablissement(){
			if (document.forms[0].elements['nom_etablissement'].value.length==0){
				alert("Le nom de l'établissement doit être saisi !");
				document.forms[0].elements['nom_etablissement'].focus();
				return false;
			}
			else return true;
		}

		function checkNomUsage(){
			if (document.forms[0].elements['nom_usage_enseignant'].value.length==0){
				alert("Le nom d'usage doit être saisi !");
				document.forms[0].elements['nom_usage_enseignant'].focus();
				return false;
			}
			else return true;
		}

		function checkPassword(){
			if (document.forms[0].elements['mot_de_passe_enseignant'].value.length==0 && document.forms[0].elements['confirmation_mot_de_passe_enseignant'].value.length==0){
				alert("Le mot de passe et sa confirmation doivent être saisis !");
				document.forms[0].elements['mot_de_passe_enseignant'].focus();
				return false;
			}
			else if (document.forms[0].elements['mot_de_passe_enseignant'].value != document.forms[0].elements['confirmation_mot_de_passe_enseignant'].value){
				alert("Le mot de passe et sa confirmation diffèrent !");
				document.forms[0].elements['mot_de_passe_enseignant'].value = "";
				document.forms[0].elements['confirmation_mot_de_passe_enseignant'].value = "";				
				document.forms[0].elements['mot_de_passe_enseignant'].focus();
				return false;
			}
			else return true;
		}

		function checkTypeEtablissement(){
			if (document.forms[0].elements['type_etablissement'].selectedIndex==0){
				alert("Le type de l'établissement doit être choisi !");
				document.forms[0].elements['type_etablissement'].focus();
				return false;
			}
			else return true;
		}				

		function buildNomUsage(){
			var prenom = document.forms[0].elements['prenom_enseignant'].value;
			document.forms[0].elements['nom_usage_enseignant'].value=prenom;						
		}

		function fillEtablissementForm(selectedIndex){
			if(selectedIndex>0){
				////////////////////////////////////////
				//	mise à jour du formulaire de saisie
				////////////////////////////////////////
				document.forms[0].elements['nom_etablissement'].value = etablissements[selectedIndex-1].nom;
				for (i=0; i<document.forms[0].elements['type_etablissement'].length; i++){
					if (document.forms[0].elements['type_etablissement'].options[i].value==etablissements[selectedIndex-1].type){
						document.forms[0].elements['type_etablissement'].options[i].selected=true;
						break;
					}
				}
				for (i=0; i<document.forms[0].elements['academie'].length; i++){
					if (document.forms[0].elements['academie'].options[i].value==etablissements[selectedIndex-1].academie){
						document.forms[0].elements['academie'].options[i].selected=true;					
						break;
					}
				}
			}
			else {
				////////////////////////////////////////				
				//	réinitialisation du formulaire
				////////////////////////////////////////				
				document.forms[0].elements['nom_etablissement'].value="";			
				document.forms[0].elements['type_etablissement'].options[0].selected=true;			
				document.forms[0].elements['academie'].options[0].selected=true;
			}
		}
		
		var etablissements = new Array();
	
	</script>	
</head>

<body style="text-align:center" onload="if (document.forms[0].length>0) document.forms[0].elements[0].focus();">
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
<table cellpadding=4 cellspacing="0" width="1" border="0" align="center">
<tr>
	<td>
		<div class="titre1">Formulaire d'inscription</div>
		<div class="message">Donne acc&egrave;s aux 2 outils pr&eacute;sents sur le site</div>
	</td>
	<td style="text-align:right; vertical-align:bottom"><sup title="donnée facultative">*&nbsp;</sup><span class="label">saisie facultative</span></td>
</tr>
<tr>
	<td class="en-tete3" colspan="2">Pr&eacute;sentez-vous ...</td>
</tr>
<tr>
	<td class="message"><p>Aucun usage commercial ne sera fait de ces donn&eacute;es.</p><p>Votre e-mail nous permettra de vous envoyer votre mot de passe en cas d'oubli.</p></td>
	<td class="tools">
		<table cellpadding=4 cellspacing="0">
		<tr>
			<td style="text-align:right"><span class="label">votre nom</span><sup title="donnée facultative">*</sup></td>
			<td><input name="nom_enseignant" value="<?php echo $nom_enseignant ?>" type="text" size="25" maxlength="50" onchange="javascript:buildNomUsage()"></input></td>
		</tr>
		<tr>
			<td style="text-align:right"><span class="label">pr&eacute;nom</span><sup title="donnée facultative">*</sup></td>
			<td><input name="prenom_enseignant" value="<?php echo $prenom_enseignant ?>" type="text" size="25" maxlength="50" onchange="javascript:buildNomUsage()"></input></td>
		</tr>
		<tr>
			<td class="label">e-mail</td>
			<td><input name="email_enseignant" type="text" value="<?php echo "$email_enseignant" ?>" size="30" maxlength="75"></input></td>
		</tr>
		<tr>
			<td style="text-align:right"><span class="label">url site perso</span><sup title="donnée facultative">*</sup></td>
			<?php 
				if (isset ($url_site_perso_enseignant))	$value = $url_site_perso_enseignant;
				else $value = "http://";
			?>
			<td><input name="url_site_perso_enseignant" type="text" value="<?php echo $value ?>" size="30" maxlength="75"></input></td>
		</tr>
		</table>	
	</td>
</tr>
<tr>
	<td class="en-tete3" colspan="2">Quel est votre &eacute;tablissement ?</td>
</tr>
<tr>
	<td class="message">
		<p>Est-il pr&eacute;sent dans cette liste ?</p>
		<?php
			$sql = 'SELECT * FROM ';
			if(defined("DB_TABLE_PREFIX")) $sql.= DB_TABLE_PREFIX.'_';
			$sql.= 'etablissement';		
			$sql = ' ORDER BY nom';
			$selection = mysql_query($sql);
			echo '<select name="code_etablissement" onchange="fillEtablissementForm(this.selectedIndex)">';
			echo '<option style="text-align:center"> -- choisissez un établissement -- </option>';
			for($i=0; $i<mysql_num_rows($selection); $i++){
				$e = mysql_fetch_object($selection);			
				echo '<option value="'.$e->getCode().'">'.$e->nom.' ('.$e->type.', '.$e->academie.')</option>';
				echo '<script language="JavaScript" type="text/javascript">';
				echo "etablissements[$i]=new Etablissement(\"$e->code\",\"$e->nom\",\"$e->type\",\"$e->academie\"); ";
				echo '</script>';
			}
			echo '</select>';
		?>
	</td>
	<td class="tools">
		<table cellpadding=4 cellspacing="0">
		<tr>
			<td class="label">type</td>
			<td><?php echo Etablissement::getTypeSelect($type_etablissement)?></td>
		</tr>
		<tr>
			<td class="label">nom &eacute;tablissement</td>
			<td>
				<input name="nom_etablissement" value="<?php echo $nom_etablissement ?>" type="text" size="25" maxlength="75"></input>
			</td>
		</tr>
		<tr>
			<td class="label">acad&eacute;mie</td>
			<td>
				<?php echo getAcademieSelect($academie)?>
				<input name="annee_scolaire" type="hidden" value="<?php echo getAnneeScolaire() ?>"></input>
			</td>
		</tr>
		</table>
	</td>
</tr>
<tr>
	<td class="en-tete3">Choisissez vos identifiants</td>
	<td class="alert">&nbsp;&agrave; retenir&nbsp;</td>
</tr>						
<tr>
	<td class="message">Une suggestion de nom d'usage vous est faite en fonction du nom et du pr&eacute;nom saisis, vous pouvez en changer librement.</td>
	<td class="tools">
		<table cellpadding=4>
		<tr>
			<td class="label">nom d'usage sur le site<br />(pseudonyme)</td>
			<td><input name="nom_usage_enseignant" value="<?php echo $nom_usage_enseignant ?>" type="text" size="25" maxlength="50"></input></td>
		</tr>		
		<tr>
			<td class="label">mot de passe</td>
			<td><input name="mot_de_passe_enseignant" value="<?php echo $mot_de_passe_enseignant ?>" type="password" size="25" maxlength="50"></input></td>
		</tr>
		<tr>
			<td class="label">confirmation du mot de passe</td>
			<td><input name="confirmation_mot_de_passe_enseignant" value="<?php echo $mot_de_passe_enseignant ?>" type="password" size="25" maxlength="50"></input></td>
		</tr>				
		</table>	
	</td>
</tr>
<tr><td><img src="images/cale.gif" width="200" height="1" border="0"></td><td></td></tr>
<tr>
	<td></td>
	<td>
		<input name="url_redirection" type="hidden" value="<?php echo $url_redirection ?>"></input>
		<input name="soumettre_inscription" type="button" value="Ok" onclick="checkForm()">&nbsp;
		<input type="button" value="abandonner" onclick="javascript:window.history.go(-1)">
	</td>
</tr>				
</table>
</form>
</body>
</html>