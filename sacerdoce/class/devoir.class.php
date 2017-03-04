<?php
include_once 'classe.class.php';
include_once 'performance.class.php';

class Devoir {
	var $code;
	var $date_remise;
	var $trimestre;
	var $discipline;
	var $sujet;
	var $type;
	var $coef;	
	var $moyenne;
	var $performances;	//tableau d'objets
	var $classe; //objet
	
	function Devoir($code=NULL)
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
	* @version 08/2005
	*/	
	function getAttribute($name)
	{
		return isset($this->$name)?$this->$name:NULL;
	}
	/**
	* @version 08/2005
	*/	
	function dataFeed($array=NULL)
	{
		if (is_null($array) || !is_array($array)) {
			return $this->initFromDB();
		} else {
			if (isset($array['code_devoir'])) $this->code = $array['code_devoir'];
			if (isset($array['code_classe'])) $this->classe = new Classe($array['code_classe']);
			if (isset($array['date_devoir'])) $this->date_remise = $array['date_devoir'];
			if (isset($array['trimestre_devoir'])) $this->trimestre = $array['trimestre_devoir'];
			if (isset($array['discipline_devoir'])) $this->discipline = $array['discipline_devoir'];
			if (isset($array['sujet_devoir'])) $this->sujet = $array['sujet_devoir'];
			if (isset($array['type_devoir'])) $this->type = $array['type_devoir'];
			if (isset($array['coef_devoir'])) $this->coef = $array['coef_devoir'];
			//	ajouts 07/2005
			if (isset($array['participation_devoir'])) $this->participation = $array['participation_devoir'];
			if (isset($array['moyenne_devoir'])) $this->moyenne = $array['moyenne_devoir'];		
			return true;
		}
	}	
	function toDB()
	{
		$new = empty($this->code);
		if ($this->classe->code) $settings[] = 'code_classe='.$this->classe->code;
		if (!empty($this->date_remise)) {
			$settings[] = 'date_remise=\''.$this->date_remise.'\'';
		}
		elseif ($new) {
			$settings[] = 'date_remise=NOW()';		
		}
		if ($this->trimestre) $settings[] = 'trimestre=\''.$this->trimestre.'\'';
		if ($this->discipline) $settings[] = 'discipline=\''.$this->discipline.'\'';
		if ($this->sujet) $settings[] = 'sujet=\''.addslashes($this->sujet).'\'';
		if ($this->type) $settings[] = 'type=\''.$this->type.'\'';				
		if ($this->coef) $settings[] = 'coef=\''.$this->coef.'\'';
		$sql = $new?'INSERT INTO ':'UPDATE ';
		if (defined("DB_TABLE_PREFIX")) $sql.= DB_TABLE_PREFIX.'_';		
		$sql.= 'devoir SET ';
		$sql.= implode(', ',$settings);
		if (!$new) $sql.= ' WHERE code='.$this->code;
		//echo $sql.'<br />';
		$result = mysql_query($sql);
		if ($new) $this->code = mysql_insert_id();
		return $result;
	}
	function removeFromDB()
	{
		//effacement du devoir
		$sql = 'DELETE FROM ';
		if (defined("DB_TABLE_PREFIX")) $sql.= DB_TABLE_PREFIX.'_';
		$sql.= 'devoir';
		$sql.= ' WHERE code='.$this->code;		
		mysql_query($sql);
		//effacement des performances
		$sql = 'DELETE FROM ';
		if (defined("DB_TABLE_PREFIX")) $sql.= DB_TABLE_PREFIX.'_';
		$sql.= 'performance';
		$sql.= ' WHERE code_devoir='.$this->code;		
		mysql_query($sql);
	}
	/**
	* @version 08/2005
	*/	
	function initFromDB()
	{
		if (empty($this->code)) return false;
		$sql = 'SELECT';
		$sql.= ' code AS code_devoir,';
		$sql.= ' code_classe,';
		$sql.= ' date_remise AS date_devoir,';
		$sql.= ' trimestre AS trimestre_devoir,';
		$sql.= ' discipline AS discipline_devoir,';
		$sql.= ' sujet AS sujet_devoir,';
		$sql.= ' type AS type_devoir,';
		$sql.= ' coef AS coef_devoir';
		$sql.= ' FROM ';
		if (defined("DB_TABLE_PREFIX")) $sql.= DB_TABLE_PREFIX.'_';
		$sql.= 'devoir';
		$sql.= ' WHERE code='.$this->code;			
		$rowset = mysql_query($sql);
		$row = mysql_fetch_assoc($rowset);
		mysql_free_result($rowset);
		if (!$row) return false;
		return $this->dataFeed($row);
	}
	function setStats()
	{
		$this->moyenne = $this->getMoyenne();
	}
	function initPerformancesFromDB()
	{
		$this->performances = array();
		if (!$this->code) return false;
		$sql = 'SELECT';
		$sql.= ' code AS code_performance,';
		$sql.= ' note AS note_performance,';
		$sql.= ' appreciation AS appreciation_performance,';
		$sql.= ' code_eleve,';
		$sql.= ' code_devoir';
		$sql.= ' FROM ';
		if (defined("DB_TABLE_PREFIX")) $sql.= DB_TABLE_PREFIX.'_';		
		$sql.= 'performance';
		$sql.= ' WHERE code_devoir='.$this->code;
		//echo $sql.'<br />';
		$rowset = mysql_query($sql);
		while ($row = mysql_fetch_array($rowset)) {
			$p = new Performance();
			$p->dataFeed($row);
			$this->performances[] = $p;
		}
		mysql_free_result($rowset);
	}	
	function getPerformances()
	{
		if (!isset($this->performances)) {
			$this->initPerformancesFromDB();
		}
		return $this->performances;
	}
	function getPerformance($code_eleve)
	{
		if (!isset($this->performances)) $this->getPerformances();
		
		foreach ($this->performances as $p){
			if (strcmp($p->getCodeEleve(), $code_eleve)==0) return $p;
		}
		return NULL;
	}
	/**
	 * Obtient le nombre de notes enregistrées.
	 * @return int
	 * @since 02/03/2006
	 */
	function getNotesNb()
	{
		if (!is_array($this->performances)) $this->getPerformances();
		$nb = 0;
		foreach ($this->performances as $p) {
			$n =& $p->getNote();
			if (isset($n) && strlen($n)>0) $nb++;
		}
		return $nb;
	}
	/**
	 * Obtient la meilleure note obtenue par un élève au devoir.
	 * @version 04/03/2006
	 */
	function getMeilleureNote()
	{
		if (!is_array($this->performances)) $this->getPerformances();
		$note = NULL;
		foreach ($this->performances as $p) {
			$n =& $p->getNote();
			if (isset($n) && strlen($n)>0 && ($n > $note) || is_null($note)) {
				// la note évaluée est meilleure que la note référence
				$note = $n;
			}
		}	
		return $note;	
	}
	function getPireNote()
	{
		if (!is_array($this->performances)) $this->getPerformances();
		$note = NULL;
		foreach ($this->performances as $p){
			$n =& $p->getNote();
			if (isset($n) && strlen($n)>0 && ($n < $note || is_null($note))){
				// la note évaluée est pire que la note référence
				$note = $n;
			}
		}
		return $note;
	}
	/**
	 * Obtient la moyenne des notes des élèves.
	 * @version 04/03/2006
	 */
	function getMoyenne()
	{
		if (!isset($this->performances)) {
			$this->getPerformances();
		}
		$notes_somme = 0;
		$notes_nb = 0;
		foreach ($this->performances as $p){
			$n =& $p->getNote();
			if (isset($n) && strlen($n)>0) {
				$notes_somme += $n;
				$notes_nb++;
			}
		}
		return $notes_nb>0 ? number_format($notes_somme/$notes_nb, 2) : NULL;
	}
	/**
	 * Obtient le nombre de notes inférieures à une note référence.
	 * @param $note La note référence
	 * @version 04/03/2006
	 */
	function getNotesInferieuresNb($note)
	{
		if (!is_array($this->performances)) $this->getPerformances();
		$nb = 0;
		foreach ($this->performances as $p){
			$n =& $p->getNote();
			if (is_null($n) || strlen($n)==0) {
				continue;
			} elseif ($n < $note) {
				// la note évaluée est inférieure à la note référence.
				$nb++;
			}
		}
		return $nb;
	}
	/**
	 * Obtient le pourcentage de notes inférieures à une note référence.
	 * @param $note La note référence.
	 * @since 03/2006
	 */
	function getNotesInferieuresPourcentage($note)
	{
		return number_format(($this->getNotesInferieuresNb($note)*100)/$this->getNotesNb(), 2);
	}
	/**
	* @version 09/2005
	*/	
	function setCode($code)
	{
		return $this->setAttribute('code', $code);
	}
	/**
	* @version 08/2005
	*/	
	function getCode()
	{
		return $this->getAttribute('code');
	}
	/**
	* @version 09/2005
	*/
	function getClasse()
	{
		return isset($this->classe) && is_a($this->classe, 'Classe') ? $this->classe : NULL;
	}	
	function setClasse(&$objet)
	{
		if (is_a($objet, 'Classe')) $this->classe = $objet;
	}	
	/**
	* Obtient le trimestre pendant lequel a été administré le devoir.
	* @version 12/02/2006
	*/
	function getTrimestre()
	{
		return isset($this->trimestre) ? $this->trimestre : NULL;
	}
	/**
	* @since 08/2005
	*/	
	function getTrimestreOptionsTags($selectedValue=NULL)
	{
		$html = '';
		for($option=1; $option<4; $option++){
			$html.= '<option ';
			$html.= 'value="'.$option.'"';
			//	le paramètre $selection est prioritaire sur la valeur courante $this->trimestre
			if ($option==$selectedValue) $html.= ' selected="selected"';
			elseif (isset($this->trimestre) && $option==$this->trimestre) $html.= ' selected="selected"';
			$html.= '>';
			$html.= $option;
			$html.= '</option>';
		}
		return $html;
	}
	/**
	* @version 08/2005
	*/
	function getCoefficient()
	{
		return $this->getAttribute('coef');
	}
	/**
	* @since 08/2005
	*/	
	function getCoefficientOptionsTags($selectedValue=NULL)
	{
		$html = '';
		$options = array(0.5,1,2);
		foreach ($options as $option) {
			$html.= '<option ';
			$html.= 'value="'.$option.'"';
			//	le paramètre $selection est prioritaire sur la valeur courante $this->coef
			if ($option==$selectedValue) $html.= ' selected="selected"';
			elseif (isset($this->coef) && $option==$this->coef) $html.= ' selected="selected"';
			$html.= '>';
			$html.= $option;
			$html.= '</option>';
		}
		return $html;
	}
	/**
	* @version 08/2005
	*/
	function getType()
	{
		return $this->getAttribute('type');
	}
	/**
	* @version 08/2005
	*/	
	function getTypeOptionsTags($selectedValue=NULL)
	{
		$options = array('DS','DM');
		$html = '';
		foreach ($options as $option){
			$html.= '<option ';
			$html.= 'value="'.$option.'"';
			//	le paramètre $selection est prioritaire sur la valeur courante $this->type
			if (strcasecmp($option, $selectedValue)==0) $html.= ' selected="selected"';
			elseif (isset($this->type) && strcasecmp($option, $this->type)==0) $html.= ' selected="selected"';
			$html.= '>';
			$html.= $option;
			$html.= '</option>';
		}
		return $html;
	}
	/**
	* @version 09/2005
	*/
	function getSujet()
	{
		return $this->getAttribute('sujet');
	}
	/**
	* @version 09/2005
	*/	
	function setSujet($input)
	{
		return $this->setAttribute('sujet', $input);
	}	
	/**
	* @version 08/2005
	*/
	function getDiscipline()
	{
		return $this->getAttribute('discipline');
	}
	/**
	* @version 08/2005
	*/	
	function getDisciplineOptionsTags($selectedValue=NULL)
	{
		$options = array('histoire', 'géographie', 'éducation civique');
		$html = '';
		foreach ($options as $option){
			$html.= '<option ';
			$html.= 'value="'.$option.'"';
			//	le paramètre $selection est prioritaire sur la valeur courante $this->discipline
			if (strcasecmp($option, $selectedValue)==0) $html.= ' selected="selected"';
			elseif (isset($this->type) && strcasecmp($option, $this->type)==0) $html.= ' selected="selected"';
			$html.= '>';
			$html.= $option;
			$html.= '</option>';
		}
		return $html;
	}
	/**
	* @version 09/2005
	*/
	function getDateRemise()
	{
		return $this->getAttribute('date_remise');
	}
	/**
	* @version 09/2005
	*/	
	function getDateRemiseFr()
	{
		return formatDateForUser($this->getAttribute('date_remise'));
	}
	/**
	* @version 09/2005
	*/
	function setDateRemise($input)
	{
		return $this->setAttribute('date_remise', $input);
	}		
}
?>
