<?php
//***************************************************************
//																*
//			créer le 09/03/2017 gestion banquaire				*
//																*
//***************************************************************

class Categorie{
	private $id;
	private $libelle ;

//***************************************************************

	function __construct($id = 0){
		//si j'ai ma variable id est different de 0
		if ($id != 0) {
			//alors je fait une requete sql pour recup les informations d'on j'ai besoin 
			//en MYSQLI
			$requete = dbQuery("SELECT * FROM categorie WHERE id='".$id."' ");

			$this->id = $requete[0]['id'];
			$this->libelle = $requete[0]['libelle'];
		}

	}
//***************************************************************

//------------- Id ----------------------
	function getId(){
		return $this->id;
	}

//-------------- Libelle ------------------
	function getLibelle(){
		return $this->libelle;
	}

	function setLibelle($libelle){
		return $this->libelle =$libelle;
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
				UPDATE categorie 
				SET libelle ='".$this->libelle."'
				WHERE id='".$this->id."'
				 ");
			return $requete;
		}
	//-----------------------
		// Insertion des données dans la base de donnée
		else {
			$requete = dbQuery("
				INSERT INTO categorie
				VALUES
				(NULL,
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
		$requete = dbQuery("DELETE FROM categorie WHERE id = '".$this->id."' ");
		return $requete;
	}

//---------------------------------------------------------------
//			Formulaire
//---------------------------------------------------------------

	function form(){
		$retour = '
	<form method="post" action="index.php">
    <label for="libelle" value="'.$this->libelle.'">Libellé</label>
    <textarea name="libelle"></textarea>
    
    <input type="hidden" name="id" value="" />
  
    
    <input type="submit" value="Ajouter"/>
	</form>';
	}
//---------------------------------------------------------------
//			Lecture de donnée
//---------------------------------------------------------------

	static function liste(){
	// On fait des echo pour afficher les données du mouvement
	    $list = dbQuery("SELECT id FROM categorie ORDER BY libelle");
	    $total = 0;
	    echo '<table class="table table-striped">';
	    foreach($list as $mvt) {
	        echo '<tr>';
	        $m = new Categorie($mvt['id']);
	        echo '<td><a href="index.php?action=modif&id='.$m->getId().'">'.$m->getLibelle().'</a></td>';
	        echo '</tr>';
	    }
	    echo '</table>';
        echo $total;
	}

}