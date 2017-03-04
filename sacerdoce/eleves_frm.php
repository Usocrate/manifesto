<?php
	include_once 'config/main.inc.php'; 
	include_once './class/classe.class.php';
	include_once './class/eleve.class.php';
	include_once './class/system.class.php';	
	include_once 'util.php';

	session_start();
	if (empty($_SESSION['code_affectation'])) header('Location: index.php');	
	dbconnect();
	
	$system = new system();
	$classe = new Classe($_REQUEST['code_classe']);

	//	l'élève à traiter ou à mettre en évidence
	$eleve = new Eleve();
	if(!empty($_REQUEST['code_eleve'])) $eleve->setCode($_REQUEST['code_eleve']);
	
	//	enregistrement d'un élève
	if (isset($_POST['eleve_save_order'])){
		formatUserPost($_POST);	
		$eleve->dataFeed($_POST);
		$eleve->toDB();
	}
	//	suppression d'un élève
	if (isset($_REQUEST['eleve_remove_order'])){
		$eleve->removeFromDB();
	}
?>	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<frameset cols="160, *" frameborder="0">
	<frame scrolling="auto" name="menu_eleves" src="menu_eleves.php?code_classe=<?php echo $classe->code ?>">
	<?php
	if (isset($_REQUEST['task'])){
		switch ($_REQUEST['task']) {
			case 'edit' :
				$src = 'eleve_edit.php?code_classe='.$classe->code;
				break;	
		}
	}
	elseif (isset($_POST['eleve_save_order']) || !empty($eleve->code)){
		$src = 'eleve.php?code_eleve='.$eleve->code.'&code_classe='.$classe->code;
	}
	else {
		$src = 'stats_eleves.php?code_classe='.$classe->code;
	}
	?>
	<frame name="fiche_eleve" src="<?php echo $src ?>">
</frameset>
<noframes></noframes>
</html>