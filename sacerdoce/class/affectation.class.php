<?php
include_once 'enseignant.class.php';
include_once 'etablissement.class.php';
include_once 'classe.class.php';
	
class Affectation{
	var $code;
	var $annee_scolaire;
	var $etablissement; // objet de type Etablissement
	var $enseignant; // objet de Type Enseignant
	var $classes; // tableau d'objets de type Classe

	function Affectation($code=NULL){
		$this->code = $code;
	}
	//data base access functions ----------------------------------------------------------------------------
	function toDB(){	// 08/07/2005 r�vision
		$new = empty($this->code);
		//	si l'affectation ne poss�de pas de code elle est consid�r�e comme nouvelle
		if(isset($this->annee_scolaire)) $settings[] = 'annee_scolaire=\''.$this->annee_scolaire.'\'';
		if(isset($this->etablissement->code)) $settings[] = 'code_etablissement='.$this->etablissement->code;
		if(isset($this->enseignant->code)) $settings[] = 'code_enseignant='.$this->enseignant->code;
		if($new) $settings[] = 'date_creation=NOW()';
		$sql = $new?'INSERT INTO ':'UPDATE ';
		if(defined("DB_TABLE_PREFIX")) $sql.= DB_TABLE_PREFIX.'_';
		$sql.= 'affectation SET ';
		$sql.= implode(', ',$settings);
		if($this->code) $sql.= ' WHERE code='.$this->code;
		//echo $sql.'<br />';
		$result = mysql_query($sql);
		if(!$this->code) $this->code = mysql_insert_id();
		return $result;
	}
	function initFromDB($row=NULL) {
		if(is_array($row)){
			//	les donn�es de l'initialisation sont transmises
			$this->code = $row['code'];
			$this->annee_scolaire = $row['annee_scolaire'];
			$this->date_creation = $row['date_creation'];
			$this->etablissement = new Etablissement($row['code_etablissement']);
			$this->enseignant = new Enseignant($row['code_enseignant']);			
			return true;
		}
		elseif($this->code) {
			//	on ne transmet pas les donn�es de l'initialisation
			//	mais on conna�t le code de l'affectation
			$sql = 'SELECT * FROM ';
			if(defined("DB_TABLE_PREFIX")) $sql.= DB_TABLE_PREFIX.'_';
			$sql.= 'affectation WHERE code='.$this->code;
			$rowset = mysql_query($sql);
			$row = mysql_fetch_assoc($rowset);
			mysql_free_result($rowset);
			if(!$row) return false;
			return $this->initFromDB($row);
		}
		return false;
	}	
	function setClasses(){	// 08/2005 r�vision (nomenclature des alias des champs)
		$this->classes = array();
		$sql = 'SELECT';
		$sql.= ' code AS code_classe,';
		$sql.= ' niveau AS niveau_classe,';
		$sql.= ' indice AS indice_classe,';
		$sql.= ' code_affectation';
		$sql.= ' FROM ';
		if(defined("DB_TABLE_PREFIX")) $sql.= DB_TABLE_PREFIX.'_';		
		$sql.= 'classe'; 
		$sql.= ' WHERE code_affectation='.$this->code;
		$sql.= ' ORDER BY niveau';
		$rowset = mysql_query($sql);
		while ($row = mysql_fetch_array($rowset)){
			$classe = new Classe();
			$classe->dataFeed($row);
			$this->classes[] = $classe;			
		}
		mysql_free_result($rowset);
	}
	function setCode($code){
		$this->code = $code;
	}
 	function getCode(){
		return $this->code;
	}	
	function setFeatures($code_enseignant, $code_etablissement, $annee_scolaire='2002-2003'){
		$this->enseignant = new Enseignant($code_enseignant);		
		$this->etablissement = new Etablissement($code_etablissement);	
		$this->annee_scolaire = $annee_scolaire;
	}
	function setDateCreation($date){	// 08/07/2005
		if(!empty($date)) {
			$this->date_creation = $date;
			return true;
		}
		return false;
	}

 	function getAnneeScolaire(){
		if(!$this->annee_scolaire) $this->initFromDB();
		return $this->annee_scolaire;
	}

	function getTypeEtablissement(){	
		return (isset($this->etablissement) && $this->etablissement instanceof Etablissement) ? $this->etablissement->getType():NULL;
	}
}
?>