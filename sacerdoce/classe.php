<?php
	include_once 'config/main.inc.php'; 
	include_once './class/affectation.class.php';
	include_once './class/classe.class.php';
	include_once './class/eleve.class.php';
	include_once './class/devoir.class.php';		
	include_once './class/performance.class.php';		
	include_once 'util.php';

	session_start();

	if (empty($_SESSION['code_affectation'])) header('Location: index.php');
	dbconnect();

	if (isset($_REQUEST['supprimer_devoir'])){
		$devoir = new Devoir($_REQUEST['code_devoir']);
		$devoir->removeFromDB();
	}
	$classe = new Classe($_REQUEST['code_classe']);
	$classe->initFromDB();
	$classe->getEleves();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo APPLI_NOM ?>: accueil</title>
<link rel="stylesheet" type="text/css" href="css/main.css" />
<style type="text/css">
	/*
	#liste_devoirs {width:400px; float:left}
	#liste_eleves {width:200px; float:left}
	#bilans {clear:both}
	#bilans UL {display:inline;}
	#bilans LI{
		background-color:#3B5BA0;
		color:#FFFFFF;
		display:block;
		margin:1px;
		padding:1px;
		text-indent:24px;
		background-image: url('images/puce_defonce.gif');
		background-position:left;
		background-repeat:no-repeat;
		border-width:1px 0;
		border-style:solid;
		border-color: #3B5BA0;
		float:left;}
	
	#bilans A {color:#FFFFFF}
	*/
</style>
</head>
<body>
<h1><small>classe</small> <?php echo $classe->getChaine();?></h1>
<?php
if ($classe->getElevesNb()==0 && $_SESSION['code_affectation']==$_SESSION['code_lastAffectation']) {
	$message = "<strong>Aucun élève</strong> n'a encore été affecté à cette classe.";
	$liens = array();
	$liens[] = array(
		'url'=>"eleves_frm.php?code_classe=".$classe->getCode()."&task=edit", 
		'label'=>"Affecter un élève à cette classe"
	);
	getAlertBox($message, $liens);	
} elseif ($classe->getDevoirsNb()==0 && $_SESSION['code_affectation']==$_SESSION['code_lastAffectation']) {
	$message = "<strong>Aucun devoir</strong> n'a encore été archivé pour cette classe.";		
	$liens = array();
	$liens[] = array(
		'url'=>'devoir_edit.php?code_classe='.$classe->getCode(), 
		'label'=>"Archiver le premier devoir de cette classe"
	);
	getAlertBox($message, $liens);	
}
?>
<div id="liste_devoirs">
	<h2><span>Les devoirs</span></h2>
	<?php
		echo '<table>';
		//echo '<caption>Les devoirs</caption>';
		echo '<thead>';
		//echo '<tr><th colspan="4">Les devoirs</th></tr>';
		echo '<tr><th>Type</th><th>Sujet</th><th>participation</th><th>moyenne</th></tr>';		
		//echo '<tr><td>Type</td><td>Sujet</td><td>participation</td><td>moyenne</td></tr>';		
		echo '</thead>';
		if ($_SESSION['code_affectation']==$_SESSION['code_lastAffectation'] && $classe->getElevesNb()>0) {
			echo '<tfoot>';
			echo '<tr>';
			echo '<td colspan="4">';
			echo '<ul>';
			echo '<li><a href="devoir_edit.php?code_classe='.$classe->getCode().'">Ajouter un devoir</a></li>';
			echo '</ul>';
			echo '</td>';
			echo '</tr>';
			echo '</tfoot>';			
		}
		
		for ($trimestre=1; $trimestre<4; $trimestre++) {
			$trimestre_devoirs =& $classe->getDevoirs($trimestre);
			foreach ($trimestre_devoirs as $d) {
				echo '<tr>';
				echo '<td title="type du devoir">'.$d->type.'</td>';					
				echo '<td>';
				echo '<a href="devoir.php?code_classe='.$classe->getCode().'&code_devoir='.$d->code.'&action=afficher" title="sujet du devoir">'.$d->sujet.'</a>';
				echo '</td>';
				echo '<td title="participation">'.$d->getNotesNb().'</td>';
				echo '<td class="moyenne" title="moyenne des notes">'.$d->moyenne.'</td>';
				echo '</tr>';
			}
		}
		echo '</table>';
	?>
</div>
<div id="liste_eleves">
	<h2><span>Les élèves</span></h2>
	<form action="eleves_frm.php">
		<input type="hidden" name="code_classe" value="<?php echo $classe->getCode(); ?>" />
		<select name="code_eleve">
			<option value="">-- liste complète --</option>
			<?php echo $classe->getElevesOptionsTags(); ?>
		</select>
		<button type="submit">Voir</button>
	</form>
</div>
<div id="bilans">
	<h2><span>Les Bilans</span></h2>
	<ul>
		<?php
		for ($trimestre=1; $trimestre<4; $trimestre++){
			echo '<li>';			
			$href = 'bilan_trimestre.php?trimestre='.$trimestre.'&code_classe='.$classe->getCode();
			echo '<a href="'.$href.'" target="_blank" title="Lien vers bilan du trimestre">Trimestre '.$trimestre.'</a>';
			echo '</li>';				
		}	
	?>
	<li><a href="bilan_annuel.php?code_classe=<?php echo $classe->getCode(); ?>" target="_blank" title="Liens vers bilan de l'année">Année</a></li>
	</ul>
</div>
</body>
</html>