<?php
class Individu {
	var $prenom;
	var $nom;
	var $sexe;
	var $date_naissance;	
	var $pays_naissance;
	var $adresse;
	var $ville;

	function Individu(){
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
	function getAttribute($name){	//	08/2005
		return isset($this->$name) ? $this->$name : NULL;
	}
	function getNom(){
		return $this->getAttribute('nom');
	}
	function getPrenom(){
		return $this->getAttribute('prenom');
	}
	/**
	 * @version 08/2005
	 */
	function getInitialesPrenom(){
		$prenom =& $this->getPrenom();
		$prenom = strtoupper($prenom);
		$pieces = explode('-', $prenom);
		for($i=0; $i<count($pieces); $i++){
			$pieces[$i] = substr($pieces[$i],0,1).'.';
		}
		return implode('-',$pieces);
	}
	/**
	 * @version 08/2005
	 */	
	function getNomComplet(){
		$n = $this->getNom();
		$p = $this->getPrenom();
		//	réduction éventuelle du prénom 
		if(strlen($p.$n)>15) $p = $this->getInitialesPrenom();
		// puis affichage
		$html = '<span title="'.$this->getPrenom().' '.$this->getNom().'">';
		$items = array();
		if(!empty($n)) $items[] = strtoupper($n);
		if(!empty($p)) $items[] = $p;
		$html.= implode(' ', $items);
		$html.= '</span>';
		return $html;
	}
	function getAdresse(){
		$adresse='';
		if ($this->adresse){
			$adresse.= $this->adresse;
			if ($this->ville) $adresse.="&nbsp;(".$this->ville.")";
			return $adresse;
		}
		elseif ($this->ville) {
			$adresse.= $this->ville;
			return $adresse;
		}
		else return false; 
	}
}  
?>