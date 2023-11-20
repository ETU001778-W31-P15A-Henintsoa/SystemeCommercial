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

	public function upload_file() {
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
				// $erreur = 'Upload effectué avec succès !';
				// redirect("Mail/versEnvoieMail?erreur=".$erreur);
			}
		else //Sinon (la fonction renvoie FALSE).
		{
			$erreur = 'Echec de l\'upload !';
			redirect("Mail/versEnvoieMail?erreur=".$erreur);
		}
		}
		else
		{
			redirect("Mail/versEnvoieMail?erreur=".$erreur);
		}
		return $_FILES['piecejointe']['name'];
    }

	public function envoieMail(){
		$mail = $this->input->post('mail');
		$message = $this->input->post('message');
		$pj = $this->upload_file();

		if($mail=="" || $message==""){
			$erreur = 'Champ(s) vide(s)';
			redirect('Mail/versEnvoieMail?erreur='.$erreur);
		}

		$retour = $this->Mail_modele->envoieMail($mail, $message, $pj);

		if($retour==false){
			$erreur = 'L\'Adresse mail du Fournisseur est invalide';
			redirect('Mail/versEnvoieMail?erreur='.$erreur);
		}

		redirect("welcome/versAcceuil");
	}

	
}
