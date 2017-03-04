<?php
include_once 'classe.class.php';
include_once 'individu.class.php';

class Enseignant extends Individu{
	var $code;
	var $nom_usage;
	var $mot_de_passe;	
	var $email;
	var $url_site_perso;
	
	// variables issues de la table etablissement
	var $nom_etablissement;
	var $type_etablissement;
	var $academie;
	// variables issues de la table affectation
	var $code_lastAffectation;
	var $annee_scolaire;
	// tableaux d'objets
	var $classes;
	// autres variables
	var $nb_eleves;

	function Enseignant($code=NULL)
	{
		$this->code = $code;
	}
	function setCode($code)
	{
		if(!empty($code)) {
			$this->code = $code;
			return true;
		}
		return false;
	}
	function getCode()
	{
		return $this->code;
	}
	function setNomUsage($nom_usage)
	{
		$this->nom_usage = $nom_usage;
	}
	function getNomUsage()
	{
		return $this->nom_usage;
	}
	function setMotDePasse($mot_de_passe)
	{
		$this->mot_de_passe= $mot_de_passe;
	}
	function getMotDePasse()
	{
		return $this->mot_de_passe;
	}
	function identification()
	{
		$sql = 'SELECT code FROM ';
		if (defined("DB_TABLE_PREFIX")) $sql.= DB_TABLE_PREFIX.'_';
		$sql.= 'enseignant';
		$sql.= ' WHERE nom_usage="'.$this->getNomUsage().'"';
		$sql.= ' AND mot_de_passe="'.$this->getMotDePasse().'"';
		//echo $sql.'<br />';
		$rowset = mysql_query($sql);
		if ($row = mysql_fetch_assoc($rowset)) {
			$this->setCode($row['code']);
			return true;
		}
		return false;
	}
	function setClasses($code_affectation)
	{
		$this->classes = array();
		$sql = 'SELECT * FROM ';
		if (defined("DB_TABLE_PREFIX")) $sql.= DB_TABLE_PREFIX.'_';
		$sql.= 'classe';
		$sql.= ' WHERE code_affectation='.$code_affectation;
		$sql.= ' ORDER BY niveau';
		$selection = mysql_query($sql);				
		//echo "nb de classes:".mysql_num_rows($selection)."<br />";	
		while ($c = mysql_fetch_object($selection)) {
			$classe = new Classe($c->code);
			$classe->setFeatures($c->niveau, $c->indice, $c->code_affectation);
			$this->classes[]=$classe;			
		}
	}
	function setFeatures($nom,$prenom,$nom_usage,$mot_de_passe,$email,$url_site_perso)
	{
		$this->nom = $nom;		
		$this->prenom = $prenom;	
		$this->nom_usage = $nom_usage;
		$this->mot_de_passe = $mot_de_passe;
		$this->email = $email;				
		$this->url_site_perso = $url_site_perso;						
	}	
	function getAcademie($code_affectation)
	{
		if (!$this->academie){
			$sql = 'SELECT e.academie FROM ';
			if (defined("DB_TABLE_PREFIX")) $sql.= DB_TABLE_PREFIX.'_';
			$sql.= 'affectation AS a, ';
			if (defined("DB_TABLE_PREFIX")) $sql.= DB_TABLE_PREFIX.'_';
			$sql.= 'etablissement AS e';		
			$sql.= ' WHERE a.code='.$code_affectation;
			$sql.= ' AND e.code = a.code_etablissement';
			//echo $sql.'<br />';
			$rowset = mysql_query($sql);	
			$row = mysql_fetch_array($rowset);
			mysql_free_result($rowset);
			$this->academie = $row['academie'];
		}
		return $this->academie;
	}

	function getChaine($code_affectation)
	{
		$chaine = $this->getNomUsage();
		$chaine .= '<span style="font-weight:normal">';		
		$chaine .= '&nbsp;(';
		$chaine .= $this->getNomEtablissement($code_affectation);		
		$chaine .= ',&nbsp;';
		$chaine .= $this->getAcademie($code_affectation);
		$chaine .= ')&nbsp;';
		$chaine .= '</span>';		
		return $chaine;		
	}

	function getCodeEtablissement($code_affectation)
	{
		$sql = 'SELECT code_etablissement FROM ';
		if (defined("DB_TABLE_PREFIX")) $sql.= DB_TABLE_PREFIX.'_';
		$sql.= 'affectation';
		$sql.= ' WHERE code='.$code_affectation;
		$selection = mysql_query($sql);
		$affectation = mysql_fetch_object($selection);
		$code = $affectation->code_etablissement;
		return $code;
	}	
	function getNbDocuments()
	{
		$sql = 'SELECT code FROM ';
		if (defined("DB_TABLE_PREFIX")) $sql.= DB_TABLE_PREFIX.'_';
		$sql.= 'document';
		$sql.= ' WHERE code_enseignant='.$this->code;
		$selection = mysql_query($sql);
		return mysql_num_rows($selection);
	}
	function getAffectationsSelect($selected)
	{
		$sql = 'SELECT code, annee_scolaire FROM ';
		if (defined("DB_TABLE_PREFIX")) $sql.= DB_TABLE_PREFIX.'_';
		$sql.= 'affectation ';
		$sql.= 'WHERE code_enseignant='.$this->code.' ';
		$sql.= 'ORDER BY annee_scolaire DESC';		
		$selection = mysql_query($sql);
		echo '<select name="code_affectation" onchange="this.form.submit()">';
		while($item = mysql_fetch_object($selection)){
			echo '<option value="'.$item->code.'"';
			if ($item->code==$selected) echo ' selected';
			echo '>'.$item->annee_scolaire.'</option>';
		}	
		echo '</select>';
		mysql_free_result($selection);
	}
	/**
	* @version 08/07/2005
	*/
	function getLastAffectation()
	{
		if (is_null($this->code)) return NULL;
		$sql = 'SELECT * FROM ';
		if (defined("DB_TABLE_PREFIX")) $sql.= DB_TABLE_PREFIX.'_';
		$sql.= 'affectation';
		$sql.= ' WHERE code_enseignant='.$this->code;
		$sql.= ' ORDER BY date_creation DESC';
		$sql.= ' LIMIT 1';		
		//echo $sql.'<br />';
		$rowset = mysql_query($sql);
		if ($row = mysql_fetch_assoc($rowset)) {
			$affectation = new Affectation();
			$affectation->initFromDB($row);
			return $affectation;
		} else {
			return NULL;
		}
	}
	function getNomEtablissement($code_affectation)
	{
		$sql = 'SELECT e.nom FROM ';
		if (defined("DB_TABLE_PREFIX")) $sql.= DB_TABLE_PREFIX.'_';
		$sql.= 'affectation AS a, ';
		if (defined("DB_TABLE_PREFIX")) $sql.= DB_TABLE_PREFIX.'_';
		$sql.= 'etablissement AS e';			
		$sql.= ' WHERE e.code = a.code_etablissement';
		$sql.= ' AND a.code = '.$code_affectation;
		$selection = mysql_query($sql);
		$etablissement = mysql_fetch_object($selection);
		return $etablissement->nom;
	}
	function getTypeEtablissement($code_affectation)
	{
		$sql = 'SELECT e.type FROM ';
		if (defined("DB_TABLE_PREFIX")) $sql.= DB_TABLE_PREFIX.'_';
		$sql.= 'affectation AS a, ';
		if (defined("DB_TABLE_PREFIX")) $sql.= DB_TABLE_PREFIX.'_';
		$sql.= 'etablissement AS e';
		$sql.= ' WHERE e.code = a.code_etablissement';
		$sql.= ' AND a.code='.$code_affectation;
		//echo $sql.'<br />';
		$rowset = mysql_query($sql);
		$row = mysql_fetch_array($rowset);
		mysql_free_result($rowset);
		return $row['type'];
	}
	function toDB()
	{
		//	si l'enseignant ne possède pas de code il est considéré comme nouveau
		if ($this->nom) $settings[] = 'nom=\''.addslashes($this->nom).'\'';
		if ($this->prenom) $settings[] = 'prenom=\''.addslashes($this->prenom).'\'';
		if ($this->nom_usage) $settings[] = 'nom_usage=\''.addslashes($this->nom_usage).'\'';
		if ($this->mot_de_passe) $settings[] = 'mot_de_passe=\''.addslashes($this->mot_de_passe).'\'';
		if ($this->email) $settings[] = 'email=\''.addslashes($this->email).'\'';
		if ($this->url_site_perso) $settings[] = 'url_site_perso=\''.addslashes($this->url_site_perso).'\'';
		$sql = ($this->code)?'UPDATE ':'INSERT INTO ';
		if (defined("DB_TABLE_PREFIX")) $sql.= DB_TABLE_PREFIX.'_';
		$sql.= 'enseignant SET ';
		$sql.= implode(', ',$settings);
		if ($this->code) $sql.= ' WHERE code='.$this->code;
		//echo $sql.'<br />';
		$result = mysql_query($sql);
		if (!$this->code) $this->code = mysql_insert_id();
		return $result;
	}
	function initFromDB($row=NULL)
	{
		if (is_array($row)) {
			//	les données de l'initialisation sont transmises
			$this->code = $row['code'];
			$this->nom = stripslashes($row['nom']);
			$this->prenom = stripslashes($row['prenom']);
			$this->nom_usage = stripslashes($row['nom_usage']);
			$this->mot_de_passe = stripslashes($row['mot_de_passe']);
			$this->email = stripslashes($row['email']);
			$this->url_site_perso = stripslashes($row['url_site_perso']);
			return true;
		} elseif ($this->code) {
			//	on ne transmet pas les données de l'initialisation
			//	mais on connaît le code de l'enseignant
			$sql = 'SELECT * FROM ';
			if (defined("DB_TABLE_PREFIX")) $sql.= DB_TABLE_PREFIX.'_';
			$sql.= 'enseignant WHERE code='.$this->code;
			$rowset = mysql_query($sql);
			$row = mysql_fetch_array($rowset);
			mysql_free_result($rowset);
			if (!$row) return false;
			return $this->initFromDB($row);
		}
		return false;
	}
}
?>