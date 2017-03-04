<?php
include_once 'devoir.class.php';
include_once 'eleve.class.php';

class Performance {
	var $code;
	var $note;
	var $appreciation;
	var $eleve;
	var $devoir;
	var $mention;
	var $code_couleur;

	function Performance($code=NULL)
	{
		$this->code = $code;
	}
	/**
	 * Fixe la valeur d'un attribut.
	 * @since 08/2005	 
	 * @version 04/03/2006
	 */
	function setAttribute($name, $value)
	{
		$value = trim($value);
		$value = html_entity_decode($value);
		return $this->{$name} = $value;
	}
	/**
	 * @since 08/2005
	 */
	function getAttribute($name)
	{
		return isset($this->$name) ? $this->$name : NULL;
	}
	/**
	 * Obtient le code associé à la performance.
	 * @since 02/2005
	 */
	function getCode()
	{
		return $this->getAttribute('code');
	}
	/**
	 * Fixe le code associé à la performance.
	 * @since 02/03/2006
	 */
	function setCode($input)
	{
		return empty($input) ? false : $this->setAttribute('code', $input);
	}	
	/**
	 * @since 08/2005
	 */
	function dataFeed($array)
	{
		if (isset($array['code_performance'])) $this->code = $array['code_performance'];
		if (isset($array['note_performance'])) {
			$this->setNote($array['note_performance']);
			$this->setMention();
		}
		if (isset($array['appreciation_performance'])) {
			$this->setAppreciation($array['appreciation_performance']);
		}
		if (isset($array['code_eleve'])) {
			$this->setEleve(new Eleve($array['code_eleve']));
			$this->eleve->datafeed($array);
		}
		if (isset($array['code_devoir'])) {
			$this->setDevoir(new Devoir($array['code_devoir']));
			$this->devoir->datafeed($array);
		}
		return true;
	}
	/**
	 * @version 08/2005
	 */	
	function initFromDB()
	{
		if (empty($this->code)) return false;
		$sql = 'SELECT';
		$sql.= ' code AS code_performance,';
		$sql.= ' note AS note_performance,';
		$sql.= ' appreciation AS appreciation_performance,';
		$sql.= ' code_eleve,';
		$sql.= ' code_devoir';
		$sql.= ' FROM ';
		if (defined("DB_TABLE_PREFIX")) $sql.= DB_TABLE_PREFIX.'_';
		$sql.= 'performance';
		$sql.= ' WHERE code='.$this->code;			
		$rowset = mysql_query($sql);
		$row = mysql_fetch_assoc($rowset);
		mysql_free_result($rowset);
		if (!$row) return false;
		return $this->dataFeed($row);
	}
	/**
	 * @version 08/2005
	 * @version 03/2006
	 */	
	function toDB()
	{
		$new = empty($this->code);
		if (isset($this->note)) {
			$settings[] = strlen($this->note)==0 ? 'note=NULL' : 'note="'.$this->note.'"';
		}
		if (isset($this->appreciation)) {
			$settings[] = empty($this->appreciation) ? 'appreciation=NULL' : 'appreciation="'.addslashes($this->appreciation).'"';
		}
		if ($this->getCodeEleve()) {
			$settings[] = 'code_eleve='.$this->getCodeEleve();
		}
		if ($this->getCodeDevoir()) {
			$settings[] = 'code_devoir='.$this->getCodeDevoir();
		}
		$sql = $new?'INSERT INTO ':'UPDATE ';
		if (defined("DB_TABLE_PREFIX")) $sql.= DB_TABLE_PREFIX.'_';
		$sql.= 'performance SET ';
		$sql.= implode(', ',$settings);
		if (!$new) $sql.= ' WHERE code='.$this->code;
		//echo $sql.'<br />';
		$result = mysql_query($sql);
		if ($new) $this->code = mysql_insert_id();
		return $result;
	}
	function removeFromDB()
	{
		$sql = 'DELETE FROM ';
		if (defined("DB_TABLE_PREFIX")) $sql.= DB_TABLE_PREFIX.'_';
		$sql.= 'performance';
		$sql.= ' WHERE code_devoir='.$this->getCodeDevoir();
		$sql.= ' AND code_eleve='.$this->getCodeEleve();		
		if (!mysql_query($sql)) echo "Echec de la suppression de la performance de l'élève ".$this->code_eleve." au devoir ".$this->code_devoir."<br />";
	}
	/**
	 * @since 08/2005
	 */	
	function setEleve(&$eleve)
	{
		if (is_a($eleve, 'Eleve')) $this->eleve = $eleve;
	}
	/**
	 * @since 08/2005
	 */	
	function getAttributeEleve($name)
	{
		if (isset($this->eleve) && is_a($this->eleve, 'Eleve')) {
			return $this->eleve->getAttribute($name);
		}
	}
	/**
	 * @since 09/2005
	 */	
	function setAttributeEleve($name, $value)
	{
		if (isset($this->eleve) && is_a($this->eleve, 'Eleve')) {
			return $this->eleve->setAttribute($name, $value);
		}
	}
	/**
	 * @since 08/2005
	 */	
	function getCodeEleve()
	{
		return $this->getAttributeEleve('code');
	}
	/**
	 * @since 08/2005
	 */	
	function setCodeEleve($code)
	{
		return $this->setAttributeEleve('code', $code);
	}
	/**
	 * @since 08/2005
	 */	
	function setDevoir(&$devoir)
	{
		if (is_a($devoir, 'Devoir')) $this->devoir = $devoir;
	}
	/**
	 * Obtient le devoir.
	 * @since 04/03/2006
	 */	
	function getDevoir()
	{
		return isset($this->devoir) ? $this->devoir : NULL;
	}	
	/**
	 * @since 08/2005
	 * @version 03/2006
	 */	
	function getAttributeDevoir($name)
	{
		return isset($this->devoir) ? $this->devoir->getAttribute($name) : NULL;
	}
	/**
	 * @since 08/2005
	 */	
	function setAttributeDevoir($name, $value)
	{
		if (isset($this->devoir) && is_a($this->devoir, 'Devoir')) {
			return $this->devoir->setAttribute($name, $value);
		}
	}
	/**
	 * Obtient le code du devoir à l'origine de la performance.
	 * @since 08/2005
	 */
	function getCodeDevoir()
	{
		//return $this->getAttribute('code_devoir');
		return $this->getAttributeDevoir('code');
	}
	/**
	 * @since 08/2005
	 */	
	function setCodeDevoir($code)
	{
		return $this->setAttributeDevoir('code', $code);
	}
	/**
	 * Fixe la note.
	 * @version 04/03/2006
	 */
	function setNote($input)
	{
		return $this->setAttribute('note', $input) && $this->setMention();
	}
	/**
	 * Obtient la note.
	 * @since 08/2005
	 */	
	function getNote()
	{
		return $this->getAttribute('note');
	}
	/**
	 * Fixe l'appréciation.
	 * @version 02/03/2006
	 */
	function setAppreciation($input)
	{
		if (is_null($input) || strlen(trim($input))==0) {
			return false;
		} else {
			return $this->setAttribute('appreciation', $input);
		}
	}
	/**
	 * Obtient l'appréciation.
	 * @since 08/2005
	 */
	function getAppreciation()
	{
		return $this->getAttribute('appreciation');
	}
	function setMention(){
		if ($this->note >= 16) {
			$this->mention = 'Très Bien';
			$this->code_couleur = '#71DB4D';
		}	
		elseif ($this->note >= 13){
			$this->mention = 'Bien';
			$this->code_couleur = '#9CE683';			
		}	
		elseif ($this->note >= 10){
			$this->mention = 'Assez Bien';
			$this->code_couleur = '#BAEEA8';
		}	
		elseif ($this->note >= 7){
			$this->mention = 'Insuffisant';
			$this->code_couleur = '#FFC2C2';
		}
		elseif ($this->note >= 4){
			$this->mention = 'Très Insuffisant';
			$this->code_couleur = '#FF8383';
		}		
		elseif ($this->note >= 0){
			$this->mention = 'Situation Préoccupante';
			$this->code_couleur = '#FF4D4D';											
		}
	}
}
?>