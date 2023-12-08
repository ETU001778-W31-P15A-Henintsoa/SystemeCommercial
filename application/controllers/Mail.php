<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mail extends CI_Controller {
	// use Google\Client;
	// use Google\Service\Gmail;
	// use Google\Service\Gmail\Message;

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function upload_file($valeur) {
        $dossier =  FCPATH . 'upload/';
		$fichier = basename($_FILES['piecejointe']['name']);
		$taille_maxi = 100000;
		$taille = filesize($_FILES['piecejointe']['tmp_name']);
		$extensions = array('.png', '.gif', '.jpg', '.jpeg', '.txt', '.pdf');
		$extension = strrchr($_FILES['piecejointe']['name'], '.');

		//Début des vérifications de sécurité...
		if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
		{
			$erreur = 'Vous devez uploader un fichier de type png, gif, jpg, jpeg, txt ou doc';
		}

		if($taille>$taille_maxi)
		{
			$erreur = 'Le fichier est trop gros...';
		}

		if(!isset($erreur)) //S'il n'y a pas d'erreur, on upload
		{
			//On formate le nom du fichier ici...
			$fichier = strtr($fichier,
			'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',
			'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
			$fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);

			if(move_uploaded_file($_FILES['piecejointe']['tmp_name'], $dossier . $fichier)) //Si
			{
				$erreur = 'Upload effectué avec succès !';
				// redirect("Mail/versEnvoieMail?erreur=".$erreur);
			}
		else //Sinon (la fonction renvoie FALSE).
		{
			$erreur = 'Echec de l\'upload !';
			redirect('Mail/'.$valeur.'&erreur='.$erreur);
		}
		}
		else
		{
			redirect('Mail/'.$valeur.'&erreur='.$erreur);
		}
		return $_FILES['piecejointe']['name'];
    }

	// Email Proforma
	public function versEnvoieMail(){
		$data = array();
		if(isset($_GET['erreur'])){
			$data['erreur'] = $_GET['erreur'];
		}

		$this->load->view('header');
		$this->load->view('envoiemail', $data);
	}

	public function envoieMail(){
		$mail = $this->input->post('mail');
		$message = $this->input->post('message');
		$idregroupement = $this->input->post('idregroupement');
		$pj = $this->upload_file(sprintf("versEnvoieMail?idregroupemt=%s".$idregroupement));

		if($mail=="" || $message==""){
			$erreur = 'Champ(s) vide(s)';
			redirect('Mail/versEnvoieMail?idregroupement='.$idregroupement.'&erreur='.$erreur);
		}

		// var_dump($idregroupement);
		$retour = $this->Mail_modele->envoieMail($mail, $message, $pj, $idregroupement);

		if($retour==false){
			$erreur = 'L\'Adresse mail du Fournisseur est invalide';
			redirect('Mail/versEnvoieMail?idregroupement='.$idregroupement.'&erreur='.$erreur);
		}

		redirect("welcome/versAcceuil");
	}

	public function envoieMailSimple(){
		$message = $this->input->post('reponse');
		$idfournisseur = $this->input->post('ido');
		$mailfournisseur = $this->Generalisation->avoirTableSpecifique("adressemail", "*", sprintf("idsociete='%s'", $idfournisseur));

		var_dump($mailfournisseur);

		$pj = "";

		if($_FILES['piecejointe']['name']!=""){
			$pj = $this->upload_file(sprintf("versAfficheMessages?idfournisseur=%s".$idfournisseur));
		}

		if($message==""){
			$erreur = 'Champ(s) vide(s)';
			redirect('Mail/versAfficheMessages?idfournisseur='.$idfournisseur.'&erreur='.$erreur);
		}


		$retour = $this->Mail_modele->envoieMailSimple($mailfournisseur[0], $message, $pj);

		if($retour==false){
			$erreur = 'L\'Adresse mail du Fournisseur est invalide';
			redirect('Mail/versAfficheMessages?idfournisseur='.$idfournisseur.'&erreur='.$erreur);
		}

		redirect("Mail/versAfficheMessages?idfournisseur=".$idfournisseur);
	}
	
	public function versAfficheMessages(){
		$idfourniseur = $this->input->get('idfournisseur');
		$fournisseur = $this->Generalisation->avoirTableSpecifique('fournisseur', '*', sprintf("idfournisseur='%s'", $idfourniseur));
		$mailFournissuer = $this->Generalisation->avoirTableSpecifique("adressemail", "*", sprintf("idsociete='%s'", $idfourniseur));
		$mail = $this->Mail_modele->monMail();


		$data['messages'] = $this->Mail_modele->message($mail, $mailFournissuer[0]);
		$data['taille'] = '';
		if(count($data['messages'])==0){
			$data['taille'] = 'Aucun message';
		}
		$data['nomFournisseur'] = $fournisseur[0]->nomfournisseur;
		// var_dump($fournisseur[0]);
		$data['idfournisseur'] = $fournisseur[0]->idfournisseur;
		$this->load->view('header');
		$this->load->view('affichagemail', $data);
	}

	public function versListeFournisseur(){
		$idEmploye=$_SESSION['user'];
		$employePoste=$this->Generalisation->avoirTableSpecifique("v_posteEmployeValidation","*"," idemploye='".$idEmploye."'");
		$data['fournisseurs'] = $this->Generalisation->avoirTable('fournisseur');
		if($employePoste[0]->nomdepartement=="Systeme commercial"){
			$this->load->view('header');
			$this->load->view('listeFournisseurs', $data);
        }else{
            $data["error"]="Vous n'avez pas accès à cette page";
            $this->load->view('header');
            $this->load->view('errors/erreurValidationAchat',$data);
        }
	}

	public function versListeDepartement(){
		$moi = $this->Generalisation->avoirTableSpecifique('v_posteemploye', '*', sprintf("idemploye='%s'", $_SESSION['user']));
		$data['departements'] = $this->Generalisation->avoirTableSpecifique('departement', '*', sprintf("iddepartement != '%s'", $moi[0]->iddepartement));
		$this->load->view('header');
		$this->load->view('listeDepartements', $data);
	}

	public function versAfficheMessagesDepartement(){
		$iddepartement = $this->input->get('iddepartement');

		$ledestinataire = $this->Generalisation->avoirTableSpecifique("departement", "*", sprintf("iddepartement='%s'", $iddepartement));
		
		$destinataire = $this->Generalisation->avoirTableSpecifique("adressemail", "*", sprintf("idsociete='%s'", $iddepartement));

		$lenvoyeur = $this->Generalisation->avoirTableSpecifique('v_posteemploye', '*', sprintf("idemploye='%s'", $_SESSION['user']));

		$envoyeur = $this->Generalisation->avoirTableSpecifique("adressemail", "*", sprintf("idsociete='%s'", $lenvoyeur[0]->iddepartement));

		$data['messages'] = $this->Mail_modele->message($envoyeur[0], $destinataire[0]);

		$data['taille'] = '';

		if(count($data['messages'])==0){
			$data['taille'] = 'Aucun message';
		}

		$data['nomdepartement'] = $ledestinataire[0]->nomdepartement;
		$data['iddepartement'] = $ledestinataire[0]->iddepartement;

		$this->load->view('header');
		$this->load->view('affichagemailDepartement', $data);
	}


	// Bon de Commande

	public function envoieMailBonDeCommande(){
		$idfournisseur = $this->input->post('idfournisseur');
		$idbondecommande = $this->input->post('idbondecommande');

		// var_dump($idfournisseur);

		$mailfournisseur = $this->Generalisation->avoirTableSpecifique("adressemail", "*", sprintf("idsociete='%s'", $idfournisseur));
		
		$message = $this->input->post('message');
		if($message==""){
			$erreur = 'Champ(s) vide(s)';
			redirect('Mail/versEnvoieMailBonDeCommande?idfournisseur='.$idfournisseur.'&erreur='.$erreur);
		}

		$pj = $this->upload_file(sprintf("versEnvoieMailBonDeCommande?idfournisseur=%s",$idfournisseur));
		

		$retour = $this->Mail_modele->envoieMailBonDeCommande($mailfournisseur[0], $message, $pj, $idbondecommande);

		if($retour==false){
			$erreur = 'L\'Adresse mail du Fournisseur est invalide';
			redirect('Mail/versEnvoieMailBonDeCommande?idfournisseur='.$idfournisseur.'&erreur='.$erreur);
		}

		redirect("welcome/versAcceuil");
	}

	public function versEnvoieMailBonDeCommande(){
		$idfournisseur = $this->input->get('idfournisseur');

		$data = array();
		$data['fournisseur'] = $this->Generalisation->avoirTableSpecifique("fournisseur", "*", sprintf("idfournisseur='%s'", $idfournisseur)); 

		// var_dump($data['fournisseur']);

		if(isset($_GET['erreur'])){
			$data['erreur'] = $_GET['erreur'];
		}

		$this->load->view('header');
		$this->load->view('envoiemailBonDeCommande', $data);
	}

	public function envoieMailSimpleDepartement(){
		$message = $this->input->post('reponse');

		$iddepartement = $this->input->post('iddepartement');

		$ledestinataire = $this->Generalisation->avoirTableSpecifique("departement", "*", sprintf("iddepartement='%s'", $iddepartement));

		$destinataire = $this->Generalisation->avoirTableSpecifique("adressemail", "*", sprintf("idsociete='%s'", $iddepartement));

		$lenvoyeur = $this->Generalisation->avoirTableSpecifique('v_posteemploye', '*', sprintf("idemploye='%s'", $_SESSION['user']));

		$envoyeur = $this->Generalisation->avoirTableSpecifique("adressemail", "*", sprintf("idsociete='%s'", $lenvoyeur[0]->iddepartement));

		$pj = "";

		if($_FILES['piecejointe']['name']!=""){
			$pj = $this->upload_file(sprintf("versAfficheMessagesDepartement?iddepartement=".$iddepartement));
		}

		if($message==""){
			$erreur = 'Champ(s) vide(s)';
			redirect('Mail/versAfficheMessagesDepartement?iddepartement='.$iddepartement.'&erreur='.$erreur);
		}

		$retour = $this->Mail_modele->envoieMailSimpleDepartement($envoyeur, $destinataire, $message, $pj);

		if($retour==false){
			$erreur = 'L\'Adresse mail du Fournisseur est invalide';
			redirect('Mail/versAfficheMessagesDepartement?iddepartement='.$iddepartement.'&erreur='.$erreur);
		}

		redirect("Mail/versAfficheMessagesDepartement?iddepartement=".$iddepartement);
	}


	// Reception
	public function versEnvoieMailBonDeReception(){
		$idfournisseur = $this->input->get('idfournisseur');
		$idreception = $this->input->post('idreception');

		$data = array();
		$data['fournisseur'] = $this->Generalisation->avoirTableSpecifique("fournisseur", "*", sprintf("idfournisseur='%s'", $idfournisseur)); 
		$data['reception'] = $idreception;

		// var_dump($data['fournisseur']);

		if(isset($_GET['erreur'])){
			$data['erreur'] = $_GET['erreur'];
		}

		$this->load->view('header');
		$this->load->view('envoiemailReception', $data);
	}

	public function envoieMailReception(){
		$idfournisseur = $this->input->post('idfournisseur');
		$idreception = $this->input->post('idreception');

		// var_dump($idfournisseur);

		$mailfournisseur = $this->Generalisation->avoirTableSpecifique("adressemail", "*", sprintf("idsociete='%s'", $idfournisseur));
		
		$message = $this->input->post('message');
		if($message==""){
			$erreur = 'Champ(s) vide(s)';
			redirect('Mail/versEnvoieMailBonDeReception?idfournisseur='.$idfournisseur.'&idreception='.$idreception.'&erreur='.$erreur);
		}

		$pj = $this->upload_file('versEnvoieMailBonDeReception?idfournisseur='.$idfournisseur.'&idreception='.$idreception);
		

		$retour = $this->Mail_modele->envoieMailReception($mailfournisseur[0], $message, $pj);

		$this->Mail_modele->updatereception($idreception);

		if($retour==false){
			$erreur = 'L\'Adresse mail du Fournisseur est invalide';
			redirect('Mail/versEnvoieMailBonDeReception?idfournisseur='.$idfournisseur.'&idreception='.$idreception.'&erreur='.$erreur);
		}

		redirect("welcome/versAcceuil");
	}


	// Bon d'entree
	public function versEnvoieMailBonEntree(){
		$iddepartement = $this->input->get('iddepartement');
		$idbonentree = $this->input->post('idbonentree');

		$data = array();
		$data['iddepartement'] = $this->Generalisation->avoirTableSpecifique("departement", "*", sprintf("iddepartement='%s'", $iddepartement)); 
		$data['idbonentree'] = $idbonentree;

		// var_dump($data['fournisseur']);

		if(isset($_GET['erreur'])){
			$data['erreur'] = $_GET['erreur'];
		}

		$this->load->view('header');
		$this->load->view('envoiemailBonEntre', $data);
	}

	public function envoieMailEntree(){
		$iddepartement= $this->input->post('iddepartement');
		$idreception = $this->input->post('idreception');

		$iddepartement = $this->Generalisation->avoirTableSpecifique("adressemail", "*", sprintf("idsociete='%s'", $iddepartement));
		
		$message = $this->input->post('message');
		if($message==""){
			$erreur = 'Champ(s) vide(s)';
			redirect('Mail/versEnvoieMailBonDeReception?idfournisseur='.$idfournisseur.'&idreception='.$idreception.'&erreur='.$erreur);
		}

		// $pj = $this->upload_file('versEnvoieMailBonDeReception?idfournisseur='.$idfournisseur.'&idreception='.$idreception);
		

		// $retour = $this->Mail_modele->envoieMailReception($mailfournisseur[0], $message, $pj);

		// $this->Mail_modele->updatereception($idreception);

		// if($retour==false){
		// 	$erreur = 'L\'Adresse mail du Fournisseur est invalide';
		// 	redirect('Mail/versEnvoieMailBonDeReception?idfournisseur='.$idfournisseur.'&idreception='.$idreception.'&erreur='.$erreur);
		// }

		redirect("welcome/versAcceuil");
	}


	// Bon de sortie
	public function versEnvoieMailBonDeSortie(){
		$iddepartement = $this->input->get('iddepartement');
		$idbonsortie = $this->input->post('idbondesorti');

		$data = array();
		$data['iddepartement'] = $this->Generalisation->avoirTableSpecifique("departement", "*", sprintf("iddepartement='%s'", $iddepartement)); 
		$data['idbonsortie'] = $idbonsortie;


		if(isset($_GET['erreur'])){
			$data['erreur'] = $_GET['erreur'];
		}

		$this->load->view('header');
		$this->load->view('envoiemailBonSorti', $data);
	}

	public function envoieMailSortie(){
		$iddepartement = $this->input->post('iddepartement');
		$idbonsortie = $this->input->post('idbonsortie');

		$mailDepartementDestinataire = $this->Generalisation->avoirTableSpecifique("adressemail", "*", sprintf("idsociete='%s'", $iddepartement));

		// envoyeur
		$employe =  $this->Generalisation->avoirTableSpecifique("v_posteemploye", "*", sprintf("idemploye='%s'", $_SESSION['user']));
		$mailDepartementEnvoyeur = $this->Generalisation->avoirTableSpecifique("adressemail", "*", sprintf("idsociete='%s'", $employe[0]->iddepartement));
		
		$message = $this->input->post('message');
		if($message==""){
			$erreur = 'Champ(s) vide(s)';
			redirect('Mail/versEnvoieMailBonDeSortie?iddepartement='.$iddepartement.'&idbonsortie='.$idbonsortie.'&erreur='.$erreur);
		}

		$pj = $this->upload_file('versEnvoieMailBonDeSortie?iddepartement='.$iddepartement.'&idreception='.$idbonsortie);
		

		$retour = $this->Mail_modele->envoieMailDepartement( $mailDepartementEnvoyeur, $mailDepartementDestinataire, $message, $pj);

		$this->Mail_modele->updatesortie($idbonsortie);

		if($retour==false){
			$erreur = 'L\'Adresse mail du Fournisseur est invalide';
			redirect('Mail/versEnvoieMailBonDeSortie?iddepartement='.$idfournisseur.'&idbonsortie='.$idbonsortie.'&erreur='.$erreur);
		}

		redirect("welcome/versAcceuil");
	}
	
}
