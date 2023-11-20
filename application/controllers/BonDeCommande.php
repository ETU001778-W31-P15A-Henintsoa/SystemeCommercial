<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BonDeCommande extends CI_Controller {
    public function moinsdisant() {
        $this->load->model('BonDeCommande_modele');
        $data['proforma'] = $this->BonDeCommande_modele->avoirMoinsDisant();
        $this->load->view('header');
    }

    public function versListeBonDeCommande() {
        $this->load->model('BonDeCommande_modele');
        $data['bonDeCommandeNonValide'] = $this->BonDeCommande_modele->avoirListeBonDeCommandeNonValide();
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
}
