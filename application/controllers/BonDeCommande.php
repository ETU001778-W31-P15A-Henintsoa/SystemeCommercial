<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
        $idEmploye = $_SESSION['user'];
        $employePoste=$this->Generalisation->avoirTableSpecifique("v_posteEmployeValidation","*"," idemploye='".$idEmploye."'");
        if($employePoste[0]->libelle=="finance") {
            $this->load->model('BonDeCommande_modele');
            $data['bonDeCommandeNonValide'] = $this->BonDeCommande_modele->avoirListeBonDeCommandeNonValide();
            $data['bonDeCommandeValide'] = $this->BonDeCommande_modele->avoirListeBonDeCommandeValide();
            $this->load->view('header');
            $this->load->view('listeBonDeCommande',$data);
        }else{
            $data["error"]="Vous n'avez pas accès à cette page";
            $this->load->view('header');
            $this->load->view('errors/erreurValidationAchat',$data);
        }
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
        $idbondecommande = $_GET['id'];
        $this->Generalisation->miseAJour("bondecommande","etat=1"," idbondecommande='".$idbondecommande."'");
        redirect('BonDeCommande/versListeBonDeCommande');
    }
}
