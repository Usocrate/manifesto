<?php
class Etablissement{
	var $code;
	var $nom;	
	var $type;
	var $academie;

	function Etablissement($code=NULL){
		$this->code = $code;
	}
	function setCode($code){
		$this->code = $code;
	}
	function setFeatures($nom=NULL, $type=NULL, $academie=NULL){
		$this->nom = $nom;		
		$this->type = $type;	
		$this->academie = $academie;
	}	
	function identifyFromDB(){
		$sql = 'SELECT code FROM ';
		if(defined("DB_TABLE_PREFIX")) $sql.= DB_TABLE_PREFIX.'_';
		$sql.= 'etablissement';
		$sql.= ' WHERE nom=\''.$this->nom.'\'';
		$sql.= ' AND type=\''.$this->type.'\'';
		$sql.= ' AND academie=\''.$this->academie.'\'';
		$rowset = mysql_query($sql);
		if($row = mysql_fetch_assoc($rowset)){
			if (isset($row['code'])){
				$this->setCode($row['code']);
				return true;
			}
		}
		return false;
	}	
 	function getType(){
		if(!$this->type) $this->initFromDB();
		return $this->type;
	}
	function getTypeSelect($selectedValue=NULL){
		//	les valeurs envisageables
		$values = array('collège','lycée');
		$html = '<select id="type_etablissement" name="type_etablissement">';
		$html.= '<option value=""> -- choisissez -- </option>';
		foreach($values as $value){
			$html.= '<option value="'.$value.'"';
			if(strcmp($value, $selectedValue)==0) $html.=' selected="selected"';
			$html.= '>'.ucfirst($value).'</option>';
		}	
		$html.='</select>';
		return $html;
	}

	//data base access functions ----------------------------------------------------------------------------
	function toDB(){
		//	si l'établissement ne possède pas de code il est considéré comme nouveau (inconnu du système)
		if($this->nom) $settings[] = 'nom=\''.addslashes($this->nom).'\'';
		if($this->type) $settings[] = 'type=\''.addslashes($this->type).'\'';
		if($this->academie) $settings[] = 'academie=\''.addslashes($this->academie).'\'';
		$sql = ($this->code)?'UPDATE ':'INSERT INTO ';
		if(defined("DB_TABLE_PREFIX")) $sql.= DB_TABLE_PREFIX.'_';
		$sql.= 'etablissement SET ';
		$sql.= implode(', ',$settings);
		if($this->code) $sql.= ' WHERE code='.$this->code;
		//echo $sql.'<br />';
		$result = mysql_query($sql);
		if(!$this->code) $this->code = mysql_insert_id();
		return $result;
	}
	function initFromDB($row=NULL) {
		if(is_array($row)){
			//	les données de l'initialisation sont transmises
			$this->code = $row['code'];
			$this->nom = $row['nom'];
			$this->type = $row['type'];
			$this->academie = $row['academie'];
			return true;
		}
		elseif($this->code) {
			//	on ne transmet pas les données de l'initialisation
			//	mais on connaît le code de l'établissement
			$sql = 'SELECT * FROM ';
			if(defined("DB_TABLE_PREFIX")) $sql.= DB_TABLE_PREFIX.'_';			
			$sql.= 'etablissement WHERE code='.$this->code;
			$rowset = mysql_query($sql);
			$row = mysql_fetch_array($rowset);
			mysql_free_result($rowset);
			if(!$row) return false;
			return $this->initFromDB($row);
		}
		return false;
	}
}
?>