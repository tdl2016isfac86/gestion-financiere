<?php
//***************************************************************
//																*
//			créer le 02/03/2017 gestion banquaire				*
//																*
//***************************************************************

//j'ai ajouter:
//	une requete sql
//	une vérification pour $montant
// une vérification pour $jour

class Mouvement{
	private $id;
	private $montant ;
	private $jour ;
	private $categorie ;
	private $libelle ;
//	private $photo ;
//***************************************************************

	function __construct($id = 0){
		//si j'ai ma variable id est different de 0
		if ($id != 0) {
			//alors je fait une requete sql pour recup les informations d'on j'ai besoin 
			//en MYSQLI
			$requete = dbQuery("SELECT * FROM mouvement WHERE id='".$id."' ");

			$this->id = $requete[0]['id'];
			$this->montant = $requete[0]['montant'];
			$this->jour = $requete[0]['jour'];
			$this->categorie = $requete[0]['categorie'];
			$this->libelle = $requete[0]['libelle'];
			//$this->photo = $requete[0]['photo'];
		}

	}
//***************************************************************

//------------- Id ----------------------
	function getId(){
		return $this->id;
	}

//-------------- Montant -----------------
	function getMontant(){
		return $this->montant;
	}

	function setMontant($montant){
		//si ma valeur donner est bien un chifre(is_numeric)
		if(is_numeric($montant)){
			//alors je redonne le montant avec 2 chiffres aprés la virgule
			$this->montant = number_format($montant,2);
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
//-------------- jour ---------------------
	function getJour(){
		return $this->jour;
	}

	function setJour($jour){
		// je vérifie si c'est une jour au format fr
		$timestamp = strtotime($jour);
		if(is_int($timestamp)) {
		    $this->jour = date('Y-m-d H:i:s',$timestamp);
		    return TRUE;
		}
		else{
			return FALSE;
		}
		
	}
//-------------- Categorie ----------------
	function getCategorie(){
		return $this->categorie;
	}

	function setCategorie($categorie){
		return $this->categorie =$categorie;
	}
//-------------- Libelle ------------------
	function getLibelle(){
		return $this->libelle;
	}

	function setLibelle($libelle){
		return $this->libelle =$libelle;
	}
//-------------- Photo --------------------
	function getPhoto(){
		return $this->photo;
	}

	function setPhoto($photo){
		return $this->photo =$photo;
	}
//***************************************************************

//---------------------------------------------------------------
//						fonctions principals 					-
//---------------------------------------------------------------

//---------------------------------------------------------------
//			Mise A Jour/Craeation
//---------------------------------------------------------------
	function MiseAJour(){
		// MAJ
		//si j'ai l'objet ID
		if(isset($this->id)){
			//alors je fait une requete sqli et je retourne le contennu de la requete
			$requete = dbQuery("
				UPDATE mouvement 
				SET montant ='".$this->montant."'
				WHERE id='".$this->id."'
				 ");
			return $requete;
		}
	//-----------------------
		// Insertion des données dans la base de donnée
		else {
			$requete = dbQuery("
				INSERT INTO mouvement
				VALUES
				(NULL,
				'".$this->montant."',
				'".$this->jour."',
				'".$this->categorie."',
				'".$this->libelle."'
				)
			");
			if (is_int($requete)) {
				$this->id = $requete;
				return TRUE;
			}
			else{
				return FALSE;
			}
		}
	}

//---------------------------------------------------------------
//			Suppression
//---------------------------------------------------------------

	function suppression(){
		$requete = dbQuery("DELETE FROM mouvement WHERE id = '".$this->id."' ");
		return $requete;
	}

//---------------------------------------------------------------
//			Formulaire
//---------------------------------------------------------------

	function form(){
		$retour = '
		<form method="post" action="index.php" class="form-group">
	    <label for="montant">Montant</label>
	    <input type="number" step="0.01" name="montant" class="form-control" value="'.$this->montant.'">
	    
	    <label for="date">Date</label>
	    <input type="text" id="datetime" class="form-control" name="jour" value="'.str_replace(' ','T',$this->jour).'"/>
	    
	    <label for="libelle" ">Libellé</label>
	    <textarea name="libelle" class="form-control">'.$this->libelle.'</textarea>
	    
	    <select name="categorie">
	    <option value="">Veuillez sélectionner une catégorie</option>';
	
	
	    $cats = dbQuery("SELECT * FROM categorie ORDER BY libelle");
	    foreach($cats as $cat) {
	    	// J'ai donc $cat['id'] et $cat['libelle']
	    	$retour .= '<option value="'.$cat['id'].'"';
	    	if($cat['id'] == $this->categorie) { 
	    		$retour .=' selected';
	    	}
	    	$retour .='>'.$cat['libelle'].'</option>';
	        
	    }
		$retour .='</select>
	    
	    <input type="hidden" name="id" value="'.$this->id.'" />
	  
	    
	    <input type="submit" class="btn btn-success" value="';
	    if(!empty($this->id)){
	    	$retour.= 'Modifier';
	    }
	    else{
	    	$retour.= 'Ajouter';
	    }
		$retour.='"/></form>';
		return $retour;
	}
//---------------------------------------------------------------
//			Lecture de donnée
//---------------------------------------------------------------

	static function liste(){
	// On fait des echo pour afficher les données du mouvement
	    $list = dbQuery("SELECT id FROM mouvement ORDER BY jour DESC");
	    $total = 0;
	    $retour = '<table class="table table-striped">';
	    foreach($list as $mvt) {
	        $retour .= '<tr>';
	        $m = new Mouvement($mvt['id']);
	        $total = $total + $m->getMontant();
	        $retour .= '<td><a href="index.php?action=modif&id='.$m->getId().'">'.$m->getLibelle().'</a></td>';
	        $retour .= '<td>'.$m->getJour().'</td>';
	        $retour .= '<td>'.$m->getCategorie().'</td>';
	        $retour .= '<td>'.$m->getMontant().' €</td>';
	        $retour .= '</tr>';
	    }
	    $retour .= '</table>';
        $retour .= '<h3 class="img-thumbnail">'.$total.' €</h3>';
        
        return $retour;
	}

}