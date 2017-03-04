<?php
	include_once 'config/main.inc.php'; 
	include_once './class/classe.class.php';
	include_once 'util.php';

	session_start();
	if (empty($_SESSION['code_affectation'])) header('Location: index.php');

	dbconnect();
	$trimestre = $_REQUEST['trimestre'];
	$classe = new Classe($_REQUEST['code_classe']);
	$classe->initFromDB();
	$devoirs =& $classe->getDevoirs($trimestre);
	$eleves =& $classe->getEleves();
	
	$doc_title = $classe->getChaine().' / bilan Trimestre '.$trimestre;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo $doc_title ?></title>
	<link rel="STYLESHEET" type="text/css" href="css/bilan.css">
</head>

<body>
<h1><?php echo $doc_title ?></h1>
<table>
<?php
	// en-tête
	echo '<tr>';
	echo '<th>&nbsp;</th>';
	foreach ($devoirs as $d) {
		echo '<th>';
		echo $d->getType().'<br/>';
		echo '<strong>'.$d->getSujet().'</strong><br/>';			
		echo $d->getDateRemiseFr();
		echo '<br/>';
		echo 'coef&nbsp;'.$d->getCoefficient();
		echo '</div></th>';
	}
	echo '<th>Moyenne trimestrielle<br/>';
	echo '<strong>Trimestre&nbsp;'.$trimestre.'</strong></th>';
	echo '</tr>';

	// lignes élèves
	foreach ($eleves as $e) {
		$tr_class = isset($tr_class) && strcmp($tr_class, 'fond0')==0 ? 'fond1' : 'fond0'; 
		echo '<tr class="'.$tr_class.'">';
		echo '<th>'.$e->getNomComplet().'</th>';
		foreach ($devoirs as $d) {
			$p =& $e->getPerformance($d->getCode());
			if (isset($p)) {
				$n =& $p->getNote();
			}
			if (isset($n)) {
				echo '<td class="note">'.$n.'</td>';
			} else {
				echo '<td style="text-align:center"><small> - Non noté -<small></td>';				
			}	
		}
		echo '<td class="note">';
		echo '<strong>';
		echo $e->getMoyenneTrimestrielle($trimestre);
		echo '</strong>';
		echo '</td>';
		echo '</tr>';
	}
	echo '<tr>';
	echo '<td colspan="'.(count($devoirs)+2).'" class="note">';
	echo $classe->getMoyenneTrimestrielle($trimestre);
	echo '</td>';
	echo '</tr>';
?>
</table>
</body>
</html>