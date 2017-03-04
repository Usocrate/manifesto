<?php
	include_once 'config/main.inc.php';
	include_once './class/classe.class.php';
	include_once './class/eleve.class.php';
	include_once './class/devoir.class.php';
	include_once './class/performance.class.php';
	require 'util.php';

	session_start();
	//if (empty($_SESSION['code_affectation'])) header('Location: index.php');
	dbconnect();

	$eleve = new Eleve($_REQUEST['code_eleve']);
	$eleve->initFromDB();
	$eleve->getPerformances();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo APPLI_NOM ?>: Une fiche élève</title>
<link rel="stylesheet" type="text/css" href="css/main.css" />
<script language="javascript">
	function suppressionEleve() {
		var confirmation = confirm("Toutes les informations concernant l'élève seront définitivement effacées. Confirmes tu la suppression ?");
		if (confirmation == true){
			window.parent.location.href="eleves_frm.php?code_classe=<?php echo $eleve->classe->code ?>&code_eleve=<?php echo $eleve->code ?>&eleve_remove_order=1";
		}
	}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<?php //mouchard() ?>
<h1><small>élève</small> <?php echo $eleve->getNomComplet(); ?>
	<p>
		<?php 
		if (!empty($eleve->date_naissance)){
			echo "né";
			if ($eleve->sexe=='f') echo "e";
			echo "&nbsp;le ".formatDateForUser($eleve->date_naissance);
			if($eleve->pays_naissance) { 
				echo "&nbsp;(".$eleve->pays_naissance.")";
			}
			echo '<br />';
		}
		if (!empty($eleve->doublant) && strcmp($eleve->doublant, 'oui')==0){
			echo 'doublant';
			echo '<br />';
		}
		if($eleve->getAdresse()){
			echo $eleve->getAdresse();
			echo '<br />';
		}
		if (!empty($eleve->commentaire))	{
			echo $eleve->commentaire;
			echo '<br />';
		}
		?>
	</p>
</h1>
<table style="width:100%">
	<thead>
		<tr>
			<th colspan=2>devoir</th>
			<th>coef.</th>
			<th>note</th>
			<th>remarque</th>
		</tr>
	</thead>
	<tbody>
		<?php
		if (count($eleve->performances[0]) || count($eleve->performances[1]) || count($eleve->performances[2])){
			for($trimestre=3; $trimestre>0; $trimestre--){
				if(isset($eleve->performances[$trimestre-1]) && count($eleve->performances[$trimestre-1])>0){
					for ($i=0; $i<count($eleve->performances[$trimestre-1]); $i++){
						$p =& $eleve->performances[$trimestre-1][$i];
						echo '<tr>';
						echo '<td>'.$p->devoir->type.'</td>';					
						echo '<td>';
						echo "<a target=\"_parent\" href=\"devoir.php?code_classe=".$eleve->classe->code."&code_devoir=".$p->devoir->code."&action=afficher\">";
						echo $p->devoir->sujet;
						echo '</a>';
						echo '</td>';
						echo "<td class=\"coef\">".$p->devoir->coef.'</td>';
						echo "<td class=\"note\" style=\"background-color:".$p->code_couleur."; padding:4px\">".$p->getNote().'</td>';
						echo "<td valign=\"top\" class=\"appreciation\" style=\"padding:4px\">".$p->appreciation.'</td>';
						echo '</tr>';
					}
					echo '<tr>';
					echo '<td colspan=3></td>';
					echo '<td align="right" class="moyenne">'.$eleve->getMoyenneTrimestrielle($trimestre).'</td>';
					echo '<td></td>';	
					echo '</tr>';
				}	
			}
		}
	?>
	</tbody>
</table>
<?php if ($_SESSION['code_affectation'] == $_SESSION['code_lastAffectation']): ?>
<div class="tools">
	<ul>
		<li><a target="_self" href="eleve_edit.php?code_classe=<?php echo $eleve->classe->code ?>&code_eleve=<?php echo $eleve->code ?>">Modifier les infos personnelles de l'élève</a></li>
		<li><a href="javascript:suppressionEleve()">Supprimer l'élève</a></li>
	</ul>
</div>
<?php endif; ?>
</body>
</html>
