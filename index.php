<?php
require_once('includes/config.php');
require_once('includes/fonction.php');
require_once('classes/mouvement.php');
require_once('classes/categorie.php');

$_Head_TITRE_PAGE = 'Paye ta gestion financière';


if(isset($_POST['montant']) && $_POST['montant'] != '') {
    if(empty($_POST['id'])) {
    
        $mouvement = new Mouvement();
        $mouvement->setMontant($_POST['montant']);
        $mouvement->setJour($_POST['date']);
        $mouvement->setLibelle($_POST['libelle']);
        $mouvement->setCategorie($_POST['categorie']);
        $mouvement->MiseAJour();
    }
    
}

if(isset($_GET['id'])) {
    $mvt = new Mouvement($_GET['id']);
}
else {
    $mvt = new Mouvement();
}

$_Body = $mvt->form();

$_Body .= Mouvement::liste();


include_once('html/squelette.php');
?>
