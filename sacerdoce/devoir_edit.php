<?php
include_once 'config/main.inc.php';
include_once './class/devoir.class.php';
include_once './class/eleve.class.php';
include_once './class/performance.class.php';
include_once 'util.php';
session_start();
if (empty($_SESSION['code_affectation'])) header('Location: index.php');
dbconnect();

$devoir = new Devoir();
if (isset($_REQUEST['code_devoir'])) {
	//	on connaît le code du Devoir
	$devoir->setCode($_REQUEST['code_devoir']);
	$devoir->initFromDB();
	//	la classe
	$classe =& $devoir->getClasse();
} else {
	//	on déclare le Devoir comme appartenant à la Classe dont le code est passé en paramètre
	//	c'est un nouveau Devoir
	$classe = new Classe($_REQUEST['code_classe']);
	$devoir->setClasse($classe);
}
//	tous les Elèves de la Classe
$eleves =& $classe->getEleves();

if (isset($_POST['devoir_edit_submission'])) {
	// enregistrement des caractéristiques du devoir
	formatUserPost($_POST);
	$devoir->dataFeed($_POST);
	$devoir->toDB();
	// enregistrement des performances
	for ($i=0; $i < count($_POST['performance_eleve_code']); $i++) {
		$p = new Performance();
		if (isset($_POST['performance_code'][$i])) {
			$p->setCode($_POST['performance_code'][$i]);
		}
		$p->setEleve($eleves[$_POST['performance_eleve_code'][$i]]);
		$p->setDevoir($devoir);
		$p->setNote($_POST['performance_note'][$i]);
		$p->setAppreciation($_POST['performance_appreciation'][$i]);
		$p->toDB();
	}
	header('location:devoir.php?code_devoir='.$devoir->getCode());
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Un devoir</title>
<link rel="stylesheet" type="text/css" href="css/main.css" />
<style type="text/css">
		BODY {margin-top:18px; margin-right:0px; margin-bottom:18px; margin-left:0px}
	</style>
</head>
<body>
<?php //mouchard() ?>
<h1>Un devoir</h1>
<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
  <?php
	if ($devoir->getCode()) {
		echo '<input type="hidden" name="code_devoir" value="'.$devoir->getCode().'">';
	} elseif ($classe->getCode()) {
		echo '<input type="hidden" name="code_classe" value="'.$classe->getCode().'">';
	}
?>
  <table>
    <tr>
      <td><label>Type</label></td>
      <td><select name="type_devoir">
          <?php echo $devoir->getTypeOptionsTags(); ?>
        </select>
      </td>
    </tr>
    <tr>
      <td><label>Discipline</label></td>
      <td><select name="discipline_devoir">
          <?php echo $devoir->getDisciplineOptionsTags(); ?>
        </select>
      </td>
    </tr>
    <tr>
      <td><label>Trimestre</label></td>
      <td><select name="trimestre_devoir">
          <?php echo $devoir->getTrimestreOptionsTags(); ?>
        </select>
      </td>
    </tr>
    <tr>
      <td><label>Coefficient</label></td>
      <td><select name="coef_devoir">
          <?php echo $devoir->getCoefficientOptionsTags(); ?>
        </select>
      </td>
    </tr>
    <tr>
      <td><label>Sujet</label></td>
      <td><?php champTexte('sujet_devoir', $devoir->getSujet(), 35, 100); ?></td>
    </tr>
  </table>
  <table>
    <tfoot>
      <tr>
        <td></td>
        <td colspan="2"><button name="devoir_edit_submission" type="submit" value="1">enregistrer</button></td>
      </tr>
    </tfoot>
    <?php if(count($eleves)>0): ?>
    <tbody>
      <tr>
        <th>élève</th>
        <th>note</th>
        <th>remarque</th>
      </tr>
      <?php 
		foreach ($eleves as $e) {
			$p =& $devoir->getPerformance($e->getCode());
			if (!isset($p) && !is_a($p, 'Performance')) {
				$p = new Performance();
			}
			echo '<tr>';
			echo '<td>'.$e->getNomComplet().'</td>';
			echo '<td style="text-align:center">';
			champTexte('performance_note[]', $p->getNote(), 4, 4);
			champInvisible('performance_code[]', $p->getCode());
			champInvisible('performance_eleve_code[]', $e->getCode());		
			echo '</td>';
			echo '<td>';
			zoneTexte('performance_appreciation[]', $p->getAppreciation(), 40, 2);
			echo '</td>';
			echo '</tr>';
		}
	?>
    </tbody>
    <?php endif; ?>
  </table>
</form>
</body>
</html>