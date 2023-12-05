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
	
	public function versEnvoieMail()
	{
		$data = array();
		if(isset($_GET['erreur'])){
			$data['erreur'] = $_GET['erreur'];
		}

		$this->load->view('header');
		$this->load->view('envoiemail', $data);
	}

	public function versEnvoieMailBonDeCommande()
	{
		$idfournisseur = $this->input->get('idfournisseur');

		$data = array();
		$data['fournisseur'] = $this->Generalisation->avoirTableSpecifique("fournisseur", "*", sprintf("idfournisseur='%s'", $idfournisseur)); 

		if(isset($_GET['erreur'])){
			$data['erreur'] = $_GET['erreur'];
		}

		$this->load->view('header');
		$this->load->view('envoiemailBonDeCommande', $data);
	}

	public function upload_file($idregroupement) {
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
			redirect('Mail/versEnvoieMail?idregroupement='.$idregroupement.'&erreur='.$erreur);
		}
		}
		else
		{
			redirect('Mail/versEnvoieMail?idregroupement='.$idregroupement.'&erreur='.$erreur);
		}
		return $_FILES['piecejointe']['name'];
    }

	public function envoieMail(){
		$mail = $this->input->post('mail');
		$message = $this->input->post('message');
		$idregroupement = $this->input->post('idregroupement');
		$pj = $this->upload_file($idregroupement);

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

	public function envoieMailBonDeCommande(){
		$mail = $this->input->post('mail');
		$message = $this->input->post('message');
		$idregroupement = $this->input->post('idregroupement');
		$pj = $this->upload_file($idregroupement);

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
		$this->load->view('listeEmploye', $data);
	}

	public function versAfficheMessagesDepartement(){
		$iddepartement = $this->input->get('iddepartement');
		$ledestinataire = $this->Generalisation->avoirTableSpecifique("departement", "*", sprintf("iddepartement='%s'", $iddepartement));
		$destinataire = $this->Generalisation->avoirTableSpecifique("adressemail", "*", sprintf("idsociete='%s'", $iddepartement));

		$lenvoyeur = $this->Generalisation->avoirTableSpecifique('v_posteemploye', '*', sprintf("idemploye='%s'", $_SESSION['user']));
		$envoyeur = $this->Generalisation->avoirTableSpecifique("adressemail", "*", sprintf("idsociete='%s'", $lenvoyeur[0]->iddepartement));

		$data['messages'] = $this->Mail_modele->message($envoyeur[0]->idadressemail, $destinataire[0]->idadressemail);

		$data['taille'] = '';
		if(count($data['messages'])==0){
			$data['taille'] = 'Aucun message';
		}

		$data['nomFournisseur'] = $ledestinataire[0]->nomdepartement;

		$this->load->view('header');
		$this->load->view('affichagemail', $data);
	}
	
}
