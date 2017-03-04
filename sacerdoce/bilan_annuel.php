<?php
	include_once 'config/main.inc.php'; 
	include_once './class/classe.class.php';
	include_once './class/eleve.class.php';
	include_once './class/devoir.class.php';		
	include_once './class/performance.class.php';		
	include_once 'util.php';

	session_start();
	if (empty($_SESSION['code_affectation'])) header('Location: index.php');

	dbconnect();
	$c = new Classe($_REQUEST['code_classe']);
	$c->initFromDB();	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Bilan annuel</title>
	<link rel="stylesheet" type="text/css" href="css/bilan.css" />
</head>

<body>
	<h1>
		<?php echo $c->getChaine()?>
		&nbsp;/&nbsp;bilan&nbsp;annuel
	</h1>
	<table border=1 cellspacing=0 cellpadding=0>
	<tr>
		<th>&nbsp;</th>
		<th>Trimestre 1</th>
		<th>Trimestre 2</th>
		<th>Trimestre 3</th>
		<th>Ann&eacute;e</th>
	</tr>
	<?php
		$c->getEleves();
		foreach ($c->eleves as $e) {
			$nb_moyennes_eleve=0;
			$class = isset($class) && strcmp($class, 'fond0')==0 ? 'fond1' : 'fond0';
			echo '<tr class="'.$class.'">';
			echo '<th>'.$e->getNomComplet().'</th>';
			for ($trimestre=1; $trimestre<4; $trimestre++) {
				$moyenne = $e->getMoyenneTrimestrielle($trimestre);
				if ($moyenne) {
					echo '<td class="note">'.$moyenne.'</td>';
					$nb_moyennes_eleve++;
				} else {
					echo '<td>&nbsp;</td>';				
				}	
			}
			echo '<td class="note">';
			if ($nb_moyennes_eleve>0) {
				echo '<strong>';
				echo number_format($e->getMoyenneAnnuelle(), 2);
				echo '</strong>';
			}
			echo '</td>';		
			echo '</tr>';
		}
		echo '<tr>';
		echo "<td>&nbsp;</td>\n";
		$nb_moyennes_trimestrielles=0;
		$somme_moyennes_trimestrielles=0;				
		for ($trimestre=1; $trimestre<4; $trimestre++) {
			$moyenne = $c->getMoyenneTrimestrielle($trimestre);
			if ($moyenne){
				echo '<td class="note"><strong>'.$moyenne.'</strong></td>';
				$somme_moyennes_trimestrielles+=$moyenne;
				$nb_moyennes_trimestrielles++;
			} else {
				echo '<td>&nbsp;</td>';
			}	
		}
		echo '<td class="note">';
		if ($nb_moyennes_trimestrielles>0) {
			echo '<strong>';
			echo number_format($somme_moyennes_trimestrielles/$nb_moyennes_trimestrielles, 2);
			echo '</strong>';
		}
		echo '</td>';		
		echo '</tr>';
	?>
</table>
</body>
</html>