<?php
include_once 'classe.class.php';
include_once 'devoir.class.php';
include_once 'individu.class.php';
include_once 'performance.class.php';

class Eleve extends Individu {
	var $code;
	var $doublant;
	var $classe; //	objet de type classe
	var $commentaire;
	var $performances;

	function Eleve($code=NULL)
	{
		$this->code = $code; 
	}
	function toDB()
	{
		//	si l'élève ne possède pas de code il est considéré comme nouveau
		if (isset($this->nom)) $settings[] = 'nom="'.addslashes($this->nom).'"';
		if (isset($this->prenom)) $settings[] = 'prenom="'.addslashes($this->prenom).'"';		
		if (isset($this->sexe)) $settings[] = 'sexe="'.$this->sexe.'"';
		if (isset($this->doublant)) $settings[] = 'doublant=\''.$this->doublant.'\'';
		if (isset($this->date_naissance)) $settings[] = 'date_naissance="'.$this->date_naissance.'"';
		if (isset($this->pays_naissance)) $settings[] = 'pays_naissance="'.addslashes($this->pays_naissance).'"';
		if (isset($this->adresse)) $settings[] = 'adresse="'.addslashes($this->adresse).'"';
		if (isset($this->ville)) $settings[] = 'ville="'.addslashes($this->ville).'"';
		if (isset($this->commentaire)) $settings[] = 'commentaire="'.addslashes($this->commentaire).'"';
		if (isset($this->classe->code)) $settings[] = 'code_classe='.$this->classe->code;
		$sql = (empty($this->code))?'INSERT INTO ':'UPDATE ';
		if (defined("DB_TABLE_PREFIX")) $sql.= DB_TABLE_PREFIX.'_';
		$sql.= 'eleve SET ';
		$sql.= implode(', ',$settings);
		if ($this->code) $sql.= ' WHERE code='.$this->code;
		//echo $sql.'<br />';
		$result = mysql_query($sql);
		if (!$this->code) $this->code = mysql_insert_id();
		return $result;
	}
	function dataFeed($array)
	{
		if (isset($array['code_eleve'])) $this->code = $array['code_eleve'];
		if (isset($array['nom_eleve'])) $this->nom = $array['nom_eleve'];
		if (isset($array['prenom_eleve'])) $this->prenom = $array['prenom_eleve'];
		if (isset($array['sexe_eleve'])) $this->sexe = $array['sexe_eleve'];
		if (isset($array['doublant_eleve'])) $this->doublant = $array['doublant_eleve'];
		if (isset($array['date_naissance_eleve'])) $this->date_naissance = formatDateForBase($array['date_naissance_eleve']);
		if (isset($array['pays_naissance_eleve'])) $this->pays_naissance = $array['pays_naissance_eleve'];
		if (isset($array['adresse_eleve'])) $this->adresse = $array['adresse_eleve'];
		if (isset($array['commentaire_eleve'])) $this->commentaire = $array['commentaire_eleve'];
		if (isset($array['code_classe'])) $this->classe = new Classe($array['code_classe']);
	}
	function removeFromDB()
	{
		//effacement de l'élève
		$sql = 'DELETE FROM ';
		if (defined("DB_TABLE_PREFIX")) $sql.= DB_TABLE_PREFIX.'_';
		$sql.= 'eleve';
		$sql.= ' WHERE code='.$this->code;		
		mysql_query($sql);		

		//effacement des performances de l'élève
		$sql = 'DELETE FROM ';
		if (defined("DB_TABLE_PREFIX")) $sql.= DB_TABLE_PREFIX.'_';
		$sql.= 'performance';
		$sql.= ' WHERE code_eleve='.$this->code;		
		mysql_query($sql);		
	}	
	function initFromDB($array=NULL)
	{
		if (is_array($array)){
			//	les données de l'initialisation sont transmises
			$this->code = $array['code'];
			$this->nom = $array['nom'];
			$this->prenom = $array['prenom'];
			$this->sexe = $array['sexe'];
			$this->doublant = $array['doublant'];
			$this->date_naissance = $array['date_naissance'];
			$this->pays_naissance = $array['pays_naissance'];
			$this->adresse = $array['adresse'];
			$this->ville = $array['ville'];
			$this->commentaire = $array['commentaire'];
			if (isset($array['code_classe'])) $this->classe = new Classe($array['code_classe']);
			return true;
		} elseif ($this->code) {
			//	on ne transmet pas les données de l'initialisation
			//	mais on connaît le code de l'élève
			$sql = 'SELECT * FROM ';
			if (defined("DB_TABLE_PREFIX")) $sql.= DB_TABLE_PREFIX.'_';		
			$sql.= 'eleve';
			$sql.= ' WHERE code='.$this->code;
			//echo $sql.'<br />';
			$rowset = mysql_query($sql);
			$row = mysql_fetch_array($rowset);
			mysql_free_result($rowset);
			if (!$row) return false;
			return $this->initFromDB($row);
		}
		return false;
	}
	/**
	* Fixe le code de la classe.
	*/
	function setCode($code)
	{
		if ($code) $this->code=$code;
	}
	/**
	* Obtient le code de la classe.
	* @since 08/2005
	*/
	function getCode()
	{
		return $this->getAttribute('code');
	}
	function getPerformances()
	{
		if (!is_array($this->performances)) {
			$sql = 'SELECT';
			//	champs Devoir
			$sql.= ' d.code AS code_devoir,';
			$sql.= ' d.code_classe,';
			$sql.= ' d.date_remise AS date_devoir,';
			$sql.= ' d.trimestre AS trimestre_devoir,';
			$sql.= ' d.discipline AS discipline_devoir,';
			$sql.= ' d.sujet AS sujet_devoir,';
			$sql.= ' d.type AS type_devoir,';
			$sql.= ' d.coef AS coef_devoir,';
			//	champs Performance
			$sql.= ' p.code AS code_performance, p.note AS note_performance, p.appreciation AS appreciation_performance';
			$sql.= ' FROM ';
			if (defined("DB_TABLE_PREFIX")) $sql.= DB_TABLE_PREFIX.'_';		
			$sql.= 'performance AS p, ';
			if (defined("DB_TABLE_PREFIX")) $sql.= DB_TABLE_PREFIX.'_';		
			$sql.= 'devoir AS d';			
			$sql.= ' WHERE p.code_devoir = d.code';
			$sql.= ' AND p.code_eleve='.$this->code;
			//if ($trimestre) $sql.= ' AND d.trimestre=\''.$trimestre.'\'';
			$sql.= ' ORDER BY d.trimestre';		
			//echo $sql.'<br />';
			$rowset = mysql_query($sql);
			while ($row = mysql_fetch_assoc($rowset)) {
				$p = new Performance();
				$p->dataFeed($row);
				if (empty($this->performances[$row['trimestre_devoir']-1])) $this->performances[$row['trimestre_devoir']-1] = array();
				$this->performances[$row['trimestre_devoir']-1][] = $p;
			}
			mysql_free_result($rowset);
		}
		//print_r($this->performances);
		return $this->performances;
	}
	/**
	 * Obtient la moyenne de l'élève au cours d'un trimestre donné.
	 * @version 04/03/2006
	 */
	function getMoyenneTrimestrielle($trimestre)
	{
		if (!isset($this->performances)) {
			//
			// récupération de toutes les performances de l'élève.
			//
			$this->getPerformances();
		}
		if (!isset($this->performances[$trimestre-1])) {
			return NULL;
		} else {
			//
			// calcul de la moyenne.
			//
			$total = 0;
			$sommeCoef = 0;
			foreach ($this->performances[$trimestre-1] as $p){
				$n =& $p->getNote();
				if (isset($n)) {
					$d =& $p->getDevoir();
					$total += $n * $d->getCoefficient();
					$sommeCoef += $d->getCoefficient();
				}
			}
			return $sommeCoef!=0 ? number_format($total/$sommeCoef, 2) : NULL;
		}
	}
	/**
	 * Obtient la moyenne annuelle de l'élève.
	 * @since 27/05/2006
	 */
	function getMoyenneAnnuelle()
	{
		$moyennes_nb=0;
		for ($trimestre=1; $trimestre<4; $trimestre++) {
			$m = $this->getMoyenneTrimestrielle($trimestre);
			if (!is_null($m)) {
				$moyennes_nb++;
				$moyennes_total = isset($moyennes_total) ? $moyennes_total+$m : $m;
			}
		}
		return $moyennes_nb==0 ? NULL : $moyennes_total/$moyennes_nb;
	}
	/**
	 * Obtient la performance de l'élève à un devoir donné.
	 * @version 04/03/2006
	 */
 	function getPerformance($code_devoir)
 	{
		if (!is_array($this->performances)) {
			$this->getPerformances();
		}
		for ($trimestre=1; $trimestre<4; $trimestre++){
			if (!isset($this->performances[$trimestre-1])) {
				// aucune performances de l'élève au cours du trimestre
				continue;
			} else {
				for ($i=0; $i<count($this->performances[$trimestre-1]); $i++){
					$p =& $this->performances[$trimestre-1][$i];
					$d =& $p->getDevoir();
					if ($d->getCode()==$code_devoir) {
						return $p;
					}
				}
			}
		}
		return NULL;
	}
}  
?>