<?php
function dbConnect(){ 
	$connection = mysql_connect (DB_HOST, DB_USER, DB_PASSWORD); 
	mysql_select_db(DB_NAME, $connection); 
} 

function mouchard(){
	// choix des variables à afficher
	$toCheck = array();
	if(isset($_REQUEST)) $toCheck['REQUEST'] = $_REQUEST;
	if(isset($_SESSION)) $toCheck['SESSION'] = $_SESSION;	
	// affichage
	echo '<table style="position:fixed; bottom:5px; right:5px; vertical-align:bottom" class="postIt">';
	foreach ($toCheck as $intitulé=>$content){
		echo '<tr><th colspan="2">'.$intitulé.'</th></tr>';
		foreach($content as $param_name=>$param_val){
			echo '<tr>';
			echo '<td style="text-align:right;"><strong>'.$param_name.'</strong></td>';
			echo '<td>';
			if(is_array($param_val)) echo implode(', ', $param_val);
			else echo is_null($param_val)?'NULL':$param_val;
			echo '</td>';
			echo '</tr>';			
		}
	}
	echo '</table>';	
}

function formatUserPost(&$data, $clé=NULL){
	if(is_array($data)) {
		array_walk($data, 'formatUserPost');
	}
	else {
		//$data = htmlentities($data);
		$data = strip_tags($data);
		$data = trim($data);
	}
}	
function date_conversion($date_mysql){
	$date = ereg_replace('^([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})$','\\3/\\2/\\1', $date_mysql);
	return $date;					 
}

function formatDateForUser($input){	// 08/2005 révision (utilisation regex)
	if(empty($input)) return NULL;
	else {
		$output = ereg_replace('^([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})$','\\3/\\2/\\1', $input);
		//echo $input.' devient '.$output;
		return $output;
	}
}
function formatDateForBase($input){	// 08/2005 révision (utilisation regex)
	if(empty($input)) return NULL;
	else{
		$output = ereg_replace('^([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})$','\\3-\\2-\\1', $input);
		//echo $input.' devient '.$output;
		return $output;
	}
}
  
function VerifMail ($Mail){
  $Retour = eregi("^[[:alpha:]]{1}[[:alnum:]]*((\.|_|-)[[:alnum:]]+)*@".
                  "[[:alpha:]]{1}[[:alnum:]]*((\.|-)[[:alnum:]]+)*".
                  "(\.[[:alpha:]]{2,})$",
                  $Mail);
  return $Retour;
}

// HTML FUNCTIONS
function alerte($message){
	echo "<script>javascript:alert(\"$message\")</script>";
}
function champInvisible($nom, $valeur){
	echo "<input type=\"hidden\" name=\"$nom\" value=\"$valeur\">";
}
function champTexte($nom, $valeur, $taille, $longueurMax){
	echo "<input type=\"text\" name=\"$nom\" value=\"$valeur\" size=\"$taille\" maxlength=\"$longueurMax\">";
}
function zoneTexte($nom, $valeur, $nb_colonne, $nb_ligne){
	echo "<textarea name=\"$nom\" cols=\"$nb_colonne\" rows=\"$nb_ligne\">".$valeur."</textarea>";
}

function boutonRadio($nom, $valeur, $checked){
	if ($checked=="oui" OR $checked=="checked"){
		echo "<input type=\"radio\" name=\"$nom\" value=\"$valeur\" checked>";
	}
	else {
		echo "<input type=\"radio\" name=\"$nom\" value=\"$valeur\">";
	}
}

function getAlertBox($message, $liens='none'){
	echo '<div style="margin:20px;padding:10px;border:1px solid #000000;width:auto">';
	echo '<div style="float:left"><img src="images/point_exclam.gif" width=31 height=70 border=0></div>';
	echo '<div style="margin-left:60px">';
	echo '<p><big>'.$message.'</big></p>';
	if (is_array($liens)){
		echo '<div class="tools">';
		foreach ($liens as $lien){			
			echo '<ul>';	
			echo '<li><a href="'.$lien['url'].'">'.$lien['label'].'</a></li>';
			echo '</ul>';
		}
		echo '</div>';
	}
	echo '</div>';
	echo '</div>';
}

function getAnneeScolaire(){
	$annee_civile = date('Y');
	$mois = date('n');
	if ($mois>7) $annee_scolaire = $annee_civile."-".($annee_civile+1);
	else $annee_scolaire = ($annee_civile-1)."-".$annee_civile;
	return $annee_scolaire;
}

function getRadioDiscipline($selectedDiscipline="histoire"){
	$disciplines = array ('histoire','géographie','éducation civique');
	foreach ($disciplines as $discipline){
		if ($selectedDiscipline==$discipline) $etat="checked";
		else $etat="";
		boutonRadio("discipline_devoir", $discipline, $etat);
		echo ucfirst($discipline);		
	}
}
function getSelectEtablissement(){
	$sql = 'SELECT * FROM ';
	if(defined("DB_TABLE_PREFIX")) $sql.= DB_TABLE_PREFIX.'_';
	$sql.= 'etablissement';		
	$sql = ' ORDER BY nom';
	$selection = mysql_query($sql);
	echo "<select name=\"code_etablissement\">\n";
	echo '<option value=""> -- choisissez -- </option>';	
	while($e = mysql_fetch_object($selection)){
		echo "<option value=\"".$e->code."\">".$e->nom." (".$e->type.", ".$e->academie.")</option>\n";
	}
	echo "</select>";
}
// obsolète à remplacer par une méthode de l'objet Etablissement ?
function getSelectNiveau($type_etablissement="tous", $selected_one="aucun"){
	$niveaux = array();
	$niveaux['collège'] = array('6ème', '5ème', '4ème', '3ème');
	$niveaux['lycée'] = array('seconde', 'première', 'terminale');
	$niveaux['tous'] = array_merge ($niveaux['collège'], $niveaux['lycée']);
	echo '<select name="niveau">';
	echo '<option value="0"> -- indéfini -- </option>';
	foreach ($niveaux[$type_etablissement] as $niveau){
		echo '<option value="'.htmlentities($niveau).'"';
		if (strcmp($niveau, $selected_one)==0) echo ' selected="selected"';
		echo '>'.$niveau.'</option>';
	}
	echo "</select>\n";
}
function getClasses($annee_scolaire){
	dbconnect();
	$sql = 'SELECT * FROM ';
	if(defined("DB_TABLE_PREFIX")) $sql.= DB_TABLE_PREFIX.'_';
	$sql.= 'classe';		
	$sql.= ' WHERE annee_scolaire=\''.$annee_scolaire.'\'';
	return mysql_query ($sql);
}
  
function showAttributs($objet){
  	$attributs = get_object_vars($objet);
	while(list ($variable, $valeur) = each($attributs)){
		echo $variable.": ";
		echo $valeur."<br />";
	}
}
?>