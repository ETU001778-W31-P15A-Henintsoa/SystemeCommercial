<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ControllerRegroupement extends CI_Controller {
    public function versListeRegroupementNonlivre(){//mbola tsy tonga any am departement mihtitsy ilay entana
		$data['regroupement']=$this->RegroupementModele->avoirDetailRegroupement();
		$this->load->view('header');
		$this->load->view('listeRegroupementNonLivre', $data);
	}

    public function avoirDetailRegroupement(){ //detail par department
        $idArticle=$_GET['idArticle'];
        $idRegroupement=$_GET['idRegroupement'];
        $data['detail']=$this->RegroupementModele->avoirDetailRegroupementDepartement($idArticle,$idRegroupement);
        $this->load->view('header');
		$this->load->view('DetailRegroupement', $data);
    }
}
?>
