<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Africa/Nairobi'); // Remplacez 'Africa/Nairobi' par le fuseau horaire approprié


class BonDeCommande extends CI_Controller {
    public function moinsdisant() {
        $this->load->model('BonDeCommande_modele');
        $data['proforma'] = $this->BonDeCommande_modele->avoirMoinsDisant();
        $this->load->view('header');
    }

    public function generer() {
        $data['idregroupement'] = $this->input->get('idregroupement');
        $this->load->model('BonDeCommande_modele');
        $data['typepaiement'] = $this->BonDeCommande_modele->avoirListePayment();
        $data['livraison'] = $this->BonDeCommande_modele->avoirLivraison();
        $this->load->view('header');
        $this->load->view('GenererBonDeCommande',$data);
    }

    public function genererBonDeCommande() {
        $idregroupement = $this->input->post('idregroupement');
        $this->load->library('MYPDF');
        $datedelai = $this->input->post('delai');
        $paiement = $this->input->post('paiement');
        $livraison = $this->input->post('livraison');
        $this->load->model('BonDeCommande_modele');
        $idregroupement;
        $moinsDisant=$this->Proforma_modele->avoirMoinsDisant($idregroupement);
        $this->BonDeCommande_modele->genererBonDeCommande($datedelai,$livraison,$paiement, $moinsDisant);
        redirect('welcome/versAcceuil');
    }

    public function listeregroupement() {
        $this->load->model('BonDeCommande_modele');
        $data['regroupement'] = $this->BonDeCommande_modele->avoirDetailRegroupement();
        $this->load->view('header');
        $this->load->view('ListeRegroupements',$data);
    }

    public function versListeBonDeCommande() {
        $this->load->model('BonDeCommande_modele');
        $data['bonDeCommandeNonValide'] = $this->BonDeCommande_modele->avoirListeBonDeCommandeNonValide();
        $data['bonDeCommandeValide'] = $this->BonDeCommande_modele->avoirListeBonDeCommandeValide();
        $data['bonDeCommandeValideDG'] = $this->BonDeCommande_modele->avoirListeBonDeCommandeValideDG();
        $this->load->view('header');
        $this->load->view('listeBonDeCommande',$data);
    }

    public function versDetailBonDeCommande() {
        $idbondecommande = $this->input->get('id');
        $this->load->model('BonDeCommande_modele');
        $data['donnee'] = $this->BonDeCommande_modele->avoirDetailBonDeCommande($idbondecommande);
        // Calculer le TTC pour chaque élément dans $data['donnee']
        $sommeTTC = 0;
        foreach ($data['donnee'] as &$article) {
            $article['ttc'] = $article['quantite'] * $article['pu'];
            $sommeTTC += $article['ttc'];
        }
        $data['sommeTTC'] = $sommeTTC;
        $data['lettre'] = $this->BonDeCommande_modele->nombreEnLettres($data['sommeTTC']);
        $this->load->view('header');
        $this->load->view('DetailBonDeCommande',$data); 
    }

    public function valider(){
        $idEmploye = $_SESSION['user'];
        $employePoste=$this->Generalisation->avoirTableSpecifique("v_posteEmployeValidation","*"," idemploye='".$idEmploye."'");
        $idbondecommande = $_GET['id'];
        $idregroupement = $_GET['idregroupement'];
        echo $employePoste[0]->libelle;
        if($employePoste[0]->libelle == "premier validation bon achat") {
            $this->Generalisation->miseAJour("bondecommande","etat=21"," idbondecommande='".$idbondecommande."'");
            $this->Generalisation->miseAJour("regroupement","etat=31"," idregroupement='".$idregroupement."'");
            redirect('BonDeCommande/versListeBonDeCommande');
        }else{
            $data["error"]="Vous n'avez pas accès à cette page";
            $this->load->view('header');
            $this->load->view('errors/erreurValidationAchat',$data);
        }
    }

    public function validerparDG(){
        $idEmploye = $_SESSION['user'];
        $employePoste=$this->Generalisation->avoirTableSpecifique("v_posteEmployeValidation","*"," idemploye='".$idEmploye."'");
        $idbondecommande = $_GET['id'];
        $idregroupement = $_GET['idregroupement'];
        echo $employePoste[0]->libelle;
        if($employePoste[0]->libelle == "DG"){
            $this->Generalisation->miseAJour("bondecommande","etat=31"," idbondecommande='".$idbondecommande."'");
            $this->Generalisation->miseAJour("regroupement","etat=41"," idregroupement='".$idregroupement."'");
            redirect('BonDeCommande/versListeBonDeCommande');
        }else{
            $data["error"]="Vous n'avez pas accès à cette page";
            $this->load->view('header');
            $this->load->view('errors/erreurValidationAchat',$data);
        }
    }

    public function genererPDFContenu($idbondecommande) {
        
        $this->load->model('BonDeCommande_modele');
        $data['donnee'] = $this->BonDeCommande_modele->avoirDetailBonDeCommande($idbondecommande);
        
        // Calculer le TTC pour chaque élément dans $data['donnee']
        $sommeTTC = 0;
        foreach ($data['donnee'] as &$article) {
            $article['ttc'] = $article['quantite'] * $article['pu'];
            $sommeTTC += $article['ttc'];
        }
        $data['sommeTTC'] = $sommeTTC;
        $data['lettre'] = $this->BonDeCommande_modele->nombreEnLettres($data['sommeTTC']);
    
        if (empty($data['donnee'])) {
            show_error("Aucune donnée trouvée pour le bon de commande avec l'ID $idbondecommande");
        }
    
        // Charger la vue dans une variable
        $this->load->view('header');
        return $this->load->view('BonDeCommandePDF', $data, true);
    }
  
    public function genererPDF() {
        // require_once APPPATH . 'libraries/MYPDF.php'; // Assurez-vous que le chemin est correct
    
        // Créer une instance de votre classe MYPDF
        $pdf = new TCPDF();
    
        // Récupérer le contenu du PDF
        $idbondecommande = $this->input->get('id');
        $data['content'] = $this->genererPDFContenu($idbondecommande);
    
        // Ajoutez vos personnalisations TCPDF ici si nécessaire
        $pdf->AddPage();
    
        // Ajoutez le HTML au PDF
        $pdf->writeHTML($data['content'], true, false, true, false, '');
    
        // Ajoutez le PDF aux données
        $data['pdf'] = $pdf;
    
        // Chargez la vue avec les données
        $this->load->view('BonDeCommandePDF', $data);
        $pdf->Output('commande.pdf', 'I');
    }
    
    
    
    
    
    
    
    
}
?>