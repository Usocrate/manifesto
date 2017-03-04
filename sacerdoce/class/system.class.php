<?php 
class System{

	function System(){
	}

	function getAcademieSelect($selectedValue=NULL){
		$html = '<select id="academie" name="academie">';
		$html.= '<option value=""> -- choisissez -- </option>';
		$html.= $this->getAcademieOptionsTags($selectedValue);
		return $html.= '</select>';
	}
	function getAcademieOptionsTags($selectedValue='Lyon'){
		//	la liste des valeurs possibles
		$values = array ('Aix', 'Amiens', 'Besan�on', 'Bordeaux', 'Caen', 'Clermont-Ferrand', 'Corse', 'Cr�teil',
		'Dijon', 'Grenoble', 'Guadeloupe', 'Guyane', 'Lille', 'Limoges', 'Lyon', 'Martinique', 'Mayotte', 'Montpellier',
		'Nancy', 'Nantes', 'Nice', 'Orl�ans', 'Nouvelle-Cal�donie', 'Paris', 'Poitiers', 'Polyn�sie fran�aise',
		'Reims', 'Rennes', 'R�union', 'Rouen', 'Saint Pierre et Miquelon', 'Strasbourg', 'TOM', 'Toulouse', 'Versailles', 'Wallis');

		$html = '';
		foreach ($values as $value){
			$html.= '<option value="'.$value.'"';
			if (strcmp($selectedValue, $value)==0) $html.= ' selected="selected"';
			$html.= '>'.$value.'</option>';
		}
		return $html;
	}
}
?>