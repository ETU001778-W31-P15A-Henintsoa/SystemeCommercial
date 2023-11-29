<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Africa/Nairobi');
class Proforma extends CI_Controller {

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
	
	public function versEnregistrementProforma(){
		$this->load->view('header');
		$idproforma = $this->input->get("idproforma");
		$articles = $this->Generalisation->avoirTable("article");
		$data['idproforma'] = $idproforma;
		$data['articles'] = $articles;
		$this->load->view('enregistrerProforma', $data);
	}

	public function versEnregistrementReponseProforma(){
		if(isset($_GET['erreur'])){
			$data['erreur'] = $_GET['erreur'];
		};

		$this->load->view('header');
		$fournisseur = $this->Generalisation->avoirTable("fournisseur");
		$data['fournisseur'] = $fournisseur;
		$this->load->view('EnregistrerReponseFournisseur', $data);
	}

	public function upload_file() {
		$dossier =  FCPATH . 'upload/';
		$fichier = basename($_FILES['piecejointe']['name']);
		$taille_maxi = 1000000000;
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
				// redirect("proforma/versEnregistrementReponseProforma?erreur=".$erreur);
			}
		else //Sinon (la fonction renvoie FALSE).
		{
			$erreur = 'Echec de l\'upload !';
			redirect("proforma/versEnregistrementReponseProforma?erreur=".$erreur);
		}
		}
		else
		{
			redirect("proforma/versEnregistrementReponseProforma?erreur=".$erreur);
		}
		return $_FILES['piecejointe']['name'];
    }

	public function formulaireEnregistrementReponseProforma(){
		$idFournisseur = $this->input->post("idfournisseur");
		$idregroupement = $this->input->post("idregroupement");

		$pj = $this->upload_file();
		
		$proforma = $this->Proforma_modele->insertionReponseProforma($idFournisseur, $pj, $idregroupement);
		// var_dump($proforma);
		redirect("proforma/versEnregistrementproforma?idproforma=".$proforma->idproforma);
	}

	public function formulaireEnregitrementProforma(){
		$idproforma = $this->input->post("idproforma");
		$idarticle = $this->input->post("idarticle");
		$quantite = $this->input->post("quantite");
		$prixTTc = $this->input->post("prixTTc");
		$TVA = $this->input->post("tva");
		$livraisonpartielle = $this->input->post("livraisonpartielle");

		$this->Proforma_modele->insertionProforma($idproforma, $idarticle, $quantite, $prixTTc, $TVA, $livraisonpartielle);

		redirect("proforma/versEnregistrementProforma?idproforma=".$idproforma);
	}

	public function vers21(){
		$idregroupement = $this->input->get("idregroupement");
		$this->Generalisation->miseAJour("regroupement", "etat=21", sprintf("idregroupement='%s'", $idregroupement));
		redirect('welcome/versAcceuil');
	}

	public function versMoinsDisant(){
		// $data =$this->Proforma_modele->avoirMoinsDisant("REG5");
		// $ou = $this->Proforma_modele->OuAcheterQuoi($data);
		// $f = $this->Proforma_modele->OuAcheterQuoiParFournisseur("REG5");

		// $regroupement = $this->Generalisation->avoirTableConditionnee("v_detailregroupementarticle where idregroupement='"."REG5"."'");
		// $data['regroupement'] = $regroupement;
	
		// $this->load->view('proformaPourFournisseur', $data);
	}

	public function versViewDemandeProforma(){
		$idregroupement = $this->input->get('idregroupement');
		// $idregroupement = "REG5";

		$regroupement = $this->Generalisation->avoirTableConditionnee("v_detailregroupementarticle where idregroupement='".$idregroupement."'");
		$data['regroupement'] = $regroupement;
	
		$this->load->view('proformaPourFournisseur', $data);
	}

	public function genererPDFContenu($idregroupement) {
		$regroupement = $this->Generalisation->avoirTableConditionnee("v_detailregroupementarticle where idregroupement='".$idregroupement."'");
		$data['regroupement'] = $regroupement;
		return $this->load->view('proformaPourFournisseur', $data,true);
	}

	public function genererPDF() {
		$pdf = new TCPDF();
		$idregroupement = $this->input->get('idregroupement');
		$date = date("Y-m-d");
		$pdf->AddPage();
        $data['content'] = $this->genererPDFContenu($idregroupement);
		$pdf->writeHTML($data['content'], true, false, true, false, '');
		$data['pdf'] = $pdf;
		$this->load->view('proformaPourFournisseur', $data);
        $pdf->Output("demandeproforma_".$idregroupement."_".$date.".pdf", 'I');
	}


}
