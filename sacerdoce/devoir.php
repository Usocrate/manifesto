<?php
include_once 'config/main.inc.php';
include_once './class/devoir.class.php';
include_once 'util.php';

session_start();
if (empty($_SESSION['code_affectation'])) header('Location: index.php');
dbconnect();

//	le Devoir
$devoir = new Devoir($_REQUEST['code_devoir']);
$devoir->initFromDB();
//	la Classe
$classe =& $devoir->getClasse();
//	les Eleves
$eleves =& $classe->getEleves();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Un devoir</title>
<link rel="stylesheet" type="text/css" href="css/main.css" />
<style type="text/css">
	#survey {
		border:solid #D0D099;
		border-width:0 1px;
		float:left;
		width:180px;
		padding:0;
		margin:0 20px 20px 0;}
	#survey H1 {
		color:#FFFFFF;
		background-color:#D0D099;
		font-family:"Courier New",Courier, mono;
		font-size:11px;
	}
	#survey P {
		margin:0;
		padding: 4px 8px;	
	}
</style>
<script language="javascript">
		function suppressionDevoir() {
		  var confirmation = confirm("Toutes les informations concernant le devoir seront définitivement effacées. Confirmes tu la suppression ?");
			if (confirmation == true){
				window.parent.frames["main"].location.href="classe.php?code_classe=<?php echo $code_classe ?>&code_devoir=<?php echo $code_devoir ?>&supprimer_devoir=oui";
			}
		}
</script>
</head>
<body>
<h1><small><?php echo $devoir->getType() ?></small>&nbsp;<?php echo $devoir->getSujet() ?>
	<p>Coefficient&nbsp;<?php echo $devoir->getCoefficient() ?>&nbsp;-&nbsp;Trimestre&nbsp;<?php echo $devoir->getTrimestre() ?>&nbsp;(<?php echo $devoir->getDateRemiseFr() ?>)</p>
</h1>
<div id="survey">
	<h1>chiffre-clefs</h1>
	<p>
		<small>Moyenne du devoir</small><br/>
		<big><?php echo $devoir->getMoyenne() ?></big>
	</p>
	<p>
		<small>Meilleure note</small><br />
		<big><?php echo $devoir->getMeilleureNote() ?></big>
	</p>
	<p>
		<small>Moins bonne note</small><br />
		<big><?php echo $devoir->getPireNote() ?></big>
	</p>
	<p>
		<small>Pourcentage de notes inférieures à la moyenne</small><br />
		<big><?php echo $devoir->getNotesInferieuresPourcentage(10).' <small>%</small>' ?></big>
	</p>
	<p>
		<small>Nombre d'élèves non notés</small><br />
		<big><?php echo $classe->getElevesNb()-$devoir->getNotesNb(); ?></big>
	</p>	
	<?php if($_SESSION['code_affectation'] == $_SESSION['code_lastAffectation']): ?>
	<div class="tools">
		<ul>
			<li><a href="devoir_edit.php?code_devoir=<?php echo $devoir->getCode() ?>">Modifier le devoir</a></li>
			<li><a href="javascript:suppressionDevoir()">Supprimer le devoir</a></li>
		</ul>
	</div>
	<?php endif; ?>	
	<div class="jumpnav"><a target="_self" href="classe.php?code_classe=<?php echo $classe->getCode() ?>">Retour</a></div>
</div>

<table style="width:400px; table-layout:fixed">
	<thead>
		<tr>
			<th style="width:20px" />
			<th style="width:140px">élève</th>
			<th style="width:40px">note</th>
			<th style="width:200px">remarque</th>
		</tr>
	<thead>
	<tbody>
		<?php
			foreach ($eleves as $e) {
				$p =& $devoir->getPerformance($e->getCode());
				if (isset($p)) {
					$n =& $p->getNote();
					$app =& $p->getAppreciation();
				}
				echo '<tr id="'.$e->getCode().'">';
				echo '<td>';
				if (isset($n) && $n==$devoir->getMeilleureNote()) {
					echo '<img src="images/star.png" alt="Signe que l`élève a obtenu la meilleure note" />';
				}
				echo '</td>';
				
				echo '<td>';
				$href = 'eleves_frm.php?code_eleve='.$e->getCode().'&code_classe='.$classe->getCode();
				echo '<a href="'.$href.'">'.$e->getNomComplet().'</a>';
				echo '</td>';
				
				if (isset($n) || isset($app)) {
					echo '<td>'.$n.'</td>';
					echo '<td>'.$app.'</td>';
				} else {
					echo '<td style="text-align:center" colspan="2" class="alert">Non noté</td>';
				}
				echo '</tr>';
			}
			?>
	</tbody>
</table>
</body>
</html>
