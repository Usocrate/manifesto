<?php 
	include_once 'config/main.inc.php'; 
	include_once './class/affectation.class.php';
	include_once './class/classe.class.php';
	include_once './class/devoir.class.php';		
	include_once './class/eleve.class.php';
	include_once './class/performance.class.php';		
	include_once 'util.php';

	session_start();

	if (empty($_SESSION['code_affectation'])) header('Location: index.php');
	dbconnect();

	$classe = new Classe($_REQUEST['code_classe']);
	$classe->initFromDB();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Les statistiques sur les &eacute;l&egrave;ves de <?php echo $classe->getChaine();?></title>
	<link rel="stylesheet" type="text/css" href="css/main.css" />
</head>
<body>
<table>
<?php
echo '<tr style="vertical-align:top">';
for ($trimestre=3; $trimestre>0; $trimestre--){
	if ($classe->getDevoirsNb($trimestre)>0){
		echo '<td>';
		$distribution = $classe->getDistribution($trimestre);
		if ($distribution){
			$clefs = array_keys($distribution);
			echo '<table cellpadding=0 cellspacing=0 border=0>';
			echo "<caption>Trimestre ".$trimestre."</caption>";				
			for ($i=0; $i<count($clefs); $i++){
				$clef = $clefs[$i];
				$nb_mentions = count($distribution[$clef]);
				if ($nb_mentions>0){
					echo "<tr><th colspan=\"2\">".$clef."&nbsp;(".$nb_mentions.")</th></tr>";				
					for ($j=0; $j<$nb_mentions; $j++){
						$e = $distribution[$clef][$j];
						echo '<tr>';				
						echo "<td>";
						echo "<a target=\"_self\" href=\"eleve.php?code_classe=".$classe->code."&code_eleve=".$e->code."\">".$e->nom."</a>";
						echo "&nbsp;".$e->prenom;
						echo '</td>';				
						echo "<td class=\"moyenne\">";
						echo $e->getMoyennetrimestrielle($trimestre);
						echo '</td>';				
						echo '</tr>';						
					}
				}
			}
			echo '</table>';	
		}
		echo '</td>';
	}
}	
echo '</tr>';			
?>
</table>
</body>
</html>