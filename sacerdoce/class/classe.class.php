<?php
include_once 'affectation.class.php';
include_once 'devoir.class.php';
include_once 'eleve.class.php';
include_once 'performance.class.php';

class Classe {
	var $code;
	var $niveau;
	var $indice;
	var $affectation; // objet
	var $chaine;
	var $annee_scolaire;
	var $eleves;
	var $nb_eleves;
	var $devoirs;
	
	function Classe($code=NULL)
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
	* @since 08/2005
	*/
	function toDB()
	{
		$new = empty($this->code);
		if (isset($this->niveau)) $settings[] = 'niveau="'.addslashes($this->niveau).'"';
		if (isset($this->indice)) $settings[] = 'indice="'.addslashes($this->indice).'"';
		if ($this->affectation->code) $settings[] = 'code_affectation='.$this->affectation->code;
		$sql = $new ? 'INSERT INTO ' : 'UPDATE ';
		if (defined("DB_TABLE_PREFIX")) $sql.= DB_TABLE_PREFIX.'_';
		$sql.= 'classe SET ';
		$sql.= implode(', ',$settings);
		if (!$new) $sql.= ' WHERE code='.$this->code;
		//echo $sql.'<br />';
		$result = mysql_query($sql);
		if ($new) $this->code = mysql_insert_id();
		return $result;
	}
	/**
	* @version 08/2005
	*/
	function dataFeed($row)
	{
		if (is_array($row)){
			if (isset($row['code_classe'])) $this->code = $row['code_classe'];
			if (isset($row['niveau_classe'])) $this->niveau = $row['niveau_classe'];
			if (isset($row['indice_classe'])) $this->indice = $row['indice_classe'];
			if (isset($row['code_affectation'])) $this->affectation = new Affectation($row['code_affectation']);
			return true;
		}
		return false;
	}
	/**
	* @version 08/2005
	*/	
	function initFromDB()
	{
		if (empty($this->code)) return false;
		$sql = 'SELECT';
		$sql.= ' code AS code_classe,';
		$sql.= ' niveau AS niveau_classe,';
		$sql.= ' indice AS indice_classe,';
		$sql.= ' code_affectation';
		$sql.= ' FROM ';
		if (defined("DB_TABLE_PREFIX")) $sql.= DB_TABLE_PREFIX.'_';
		$sql.= 'classe';
		$sql.= ' WHERE code='.$this->code;			
		$rowset = mysql_query($sql);
		$row = mysql_fetch_assoc($rowset);
		mysql_free_result($rowset);
		if (!$row) return false;
		return $this->dataFeed($row);
	}
	/**
	* @version 08/2005
	*/	
	function getDevoirsRowset($trimestre=NULL, $tri_critère='date_remise', $tri_ordre='DESC')
	{
		$sql = 'SELECT';
		$sql.= ' d.code AS code_devoir,';
		$sql.= ' code_classe,';
		$sql.= ' date_remise AS date_devoir,';
		$sql.= ' trimestre AS trimestre_devoir,';
		$sql.= ' discipline AS discipline_devoir,';
		$sql.= ' sujet AS sujet_devoir,';
		$sql.= ' type AS type_devoir,';
		$sql.= ' coef AS coef_devoir,';
		$sql.= ' ROUND(AVG(note),2) AS moyenne_devoir,';
		$sql.= ' COUNT(*) AS participation_devoir';
		$sql.= ' FROM ';
		if (defined("DB_TABLE_PREFIX")) $sql.= DB_TABLE_PREFIX.'_';
		$sql.= 'devoir AS d LEFT JOIN ';
		if (defined("DB_TABLE_PREFIX")) $sql.= DB_TABLE_PREFIX.'_';
		$sql.= 'performance AS p ON d.code=p.code_devoir';
		$sql.= ' WHERE d.code_classe='.$this->code;
		if (is_array($trimestre)){
			$sql.= ' AND d.trimestre IN('.implode(',', $trimestre).')';
		} elseif (!is_null($trimestre)) {
			$sql.= ' AND d.trimestre='.$trimestre;
		}
		$sql.= ' GROUP BY d.code';
		//echo $sql.= ' ORDER BY '.$tri_critère.' '.$tri_ordre;
		return mysql_query($sql);	
	}
	/**
	* @version 12/02/2006
	*/
	function getDevoirs($trimestre=NULL)
	{
		if (!isset($this->devoirs)) {
			$this->devoirs = array(array(), array(), array());
			$rowset = $this->getDevoirsRowset();
			while ($row = mysql_fetch_assoc($rowset)) {
				$d = new Devoir();
				$d->dataFeed($row);
				$this->devoirs[$d->getTrimestre()-1][] = $d;
			}
			mysql_free_result($rowset);
		}
		return isset($trimestre)? $this->devoirs[$trimestre-1] : $this->devoirs;
	}
	/**
	* Obtient le nombre de devoirs administr�s � la classe.
	* @return int Le nombre de devoirs
	* @param int $trimestre Pour limiter la recherche � un seul trimestre
	* @since 12/02/2006
	*/	
	function getDevoirsNb($trimestre=NULL)
	{
		$this->getDevoirs();
		if (isset($trimestre)) {
			$nb = count($this->devoirs[$trimestre-1]);
		} else {
			$nb = $this->getDevoirsNb(1) + $this->getDevoirsNb(2) + $this->getDevoirsNb(3);
		}
		return $nb;
	}
	/**
	* @version 09/2005
	*/	
	function getEleves()
	{
		if (!isset($this->eleves)) {
			$this->eleves = array();
			$fields = array('code AS code_eleve', 'prenom AS prenom_eleve', 'nom AS nom_eleve', 'sexe AS sexe_eleve', 'doublant AS doublant_eleve', 'date_naissance AS date_naissance_eleve', 'pays_naissance AS pays_naissance_eleve', 'adresse AS adresse_eleve', 'ville AS ville_eleve', 'commentaire AS commentaire_eleve');
			$sql = 'SELECT ';
			$sql.= implode(',', $fields);
			$sql.= ' FROM ';	
			if (defined("DB_TABLE_PREFIX")) $sql.= DB_TABLE_PREFIX.'_';
			$sql.= 'eleve';
			$sql.= ' WHERE code_classe='.$this->code;
			$sql.= ' ORDER BY nom, prenom';
			$rowset = mysql_query($sql);
			//echo $sql.'<br />';
			while ($row = mysql_fetch_assoc($rowset)) {
				$eleve = new Eleve();
				$eleve->dataFeed($row);
				$this->eleves[$eleve->getCode()] = $eleve;
			}
			mysql_free_result($rowset);
		}
		return $this->eleves;
	}
	/**
	* Obtient le nombre d'�l�ves affect�s � la classe.
	* @return int Le nombre d'�l�ves
	* @since 12/02/2006
	*/	
	function getElevesNb()
	{
		return $this->getEleves() ? count($this->eleves) : NULL;
	}	
	/**
	* @version 08/2005
	*/	
	function getElevesOptionsTags($selectedValue=NULL)
	{
		$options =& $this->getEleves();
		$html = '';
		foreach($options as $e){
			$html.= '<option ';
			$html.= 'value="'.$e->getCode().'"';
			if (strcasecmp($e->getCode(), $selectedValue)==0) $html.= ' selected="selected"';
			$html.= '>';
			$html.= $e->getNomComplet();
			$html.= '</option>';
		}
		return $html;
	}	
	function getEleve($code_eleve)
	{
		if (!is_array($this->eleves)) $this->getEleves();
		foreach($this->eleves as $eleve){
			if ($eleve->code == $code_eleve) return $eleve;
		}
	}
	/**
	* @version 15/07/2005
	*/	
	function getElevesPerformancesRowset($trimestre=NULL)
	{
		$sql = 'SELECT';
		$sql.= ' e.code, e.nom, e.prenom,';
		$sql.= ' d.code, d.coef,';		
		$sql.= ' SUM(note*coef)/SUM(coef) AS moyenne,';
		$sql.= ' MIN(note) AS minimum,';
		$sql.= ' MAX(note) AS maximum,';
		$sql.= ' STD(note) AS \'ecart-type\'';		
		$sql.= ' FROM ';
		if (defined("DB_TABLE_PREFIX")) $sql.= DB_TABLE_PREFIX.'_';
		$sql.= 'eleve AS e, ';
		if (defined("DB_TABLE_PREFIX")) $sql.= DB_TABLE_PREFIX.'_';
		$sql.= 'performance AS p, ';
		if (defined("DB_TABLE_PREFIX")) $sql.= DB_TABLE_PREFIX.'_';
		$sql.= 'devoir AS d';
		$clauses = array();
		$clauses[] = 'e.code_classe='.$this->code;
		$clauses[] = 'e.code=p.code_eleve';
		$clauses[] = 'p.code_devoir=d.code';
		if (!is_null($trimestre)){
			$clauses[] = is_array($trimestre)?'d.trimestre IN('.implode(',', $trimestre).')':'d.trimestre='.$trimestre;
		}
		$sql.= ' WHERE '.implode(' AND ',$clauses);
		$sql.= ' GROUP BY e.code';
		$sql.= ' ORDER BY e.nom ASC';
		return mysql_query($sql);
	}
	function getChaine()
	{
		return $this->niveau."&nbsp;".$this->indice;
	}		
	function getDistribution($trimestre)
	{
		if (count($this->eleves)>0) {
			$distribution = array("Tr�s Bien"=>array(),"Bien"=>array(),"Assez Bien"=>array(),"Insuffisant"=>array(),"Tr�s Insuffisant"=>array(),"Situation Pr�occupante"=>array());
			for ($i=0; $i<count($this->eleves); $i++){
				$moy = $this->eleves[$i]->getMoyenneTrimestrielle($trimestre);
				if ($moy) {
					$p = new Performance();
					$p->setNote($moy);
					$distribution[$p->mention][] = $this->eleves[$i];
				}
			}			
			return $distribution;
		}
		else return false;		
	}
	/**
	* Obtient la moyenne trimestrielle d'une classe.
	* @version 12/02/2006
	*/
	function getMoyenneTrimestrielle($trimestre)
	{
		$somme_moyennes = 0;
		$nb_moyennes = 0;
		if (!isset($this->eleves)) $this->getEleves();
		if (count($this->eleves)>0) {
			foreach ($this->eleves as $e) {
				$moyenne = $e->getMoyenneTrimestrielle($trimestre);
				if ($moyenne) {
					$somme_moyennes += $moyenne;
					$nb_moyennes ++;
				}					
			}
			if ($nb_moyennes>0) return number_format($somme_moyennes/$nb_moyennes, 2);
		}
		return false;
	}
	/**
	* @todo � reprendre
	*/
	function removeFromDB()
	{
	  	//effacement des �l�ves de la classe
		for ($i=0; $i<count($this->eleves); $i++){
			$this->eleves[$i]->removeFromDB();
		}
	  	//effacement des devoirs de la classe
		for($trimestre=1; $trimestre<4; $trimestre++){
			for ($i=0; $i<$this->getDevoirsNb($trimestre); $i++){
				$this->devoirs[$trimestre-1][$i]->removeFromDB();
			}		
		}
	   //effacement de la classe
		$sql = 'DELETE FROM ';
		if (defined("DB_TABLE_PREFIX")) $sql.= DB_TABLE_PREFIX.'_';
		$sql.= 'classe';
		$sql.= ' WHERE code='.$this->code;	   
		$suppression = mysql_query($sql);
		if (!$suppression) echo "La classe n'a pu �tre effac�e de la base<b>"; 
	}
	function showMoyennes()
	{
		echo '<table>';
		echo '<tr>';
		echo '<td><label>moyenne</label></td>';
			for ($trimestre=1; $trimestre<4; $trimestre++){
				if ($this->getDevoirsNb($trimestre)>0) {
					echo "<td title=\"Moyenne au trimestre ".$trimestre."\" class=\"moyenne\">\n";
					echo "<strong>".$this->getMoyenneTrimestrielle($trimestre)."</strong>";
					echo '</td>';				
				}	
			}
		echo '</tr>';
		echo '</table>';
	}
	function setFeatures($niveau, $indice, $code_affectation)
	{
		$this->niveau = $niveau;		
		$this->indice = $indice;
		$this->affectation = new Affectation($code_affectation);	
		$this->setChaine();		
	}	
	function setChaine()
	{
		$this->chaine = $this->niveau.'&nbsp;'.$this->indice;
	}
	/**
	* @version 11/02/2006
	*/
	function setCode($input)
	{
		return $this->code = $input;
	}
	/**
	* @version 11/02/2006
	*/	
	function getCode()
	{
		return isset($this->code) ? $this->code : NULL;
	}
}
?>