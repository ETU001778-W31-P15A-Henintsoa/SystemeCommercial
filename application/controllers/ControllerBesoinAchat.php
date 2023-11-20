<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ControllerBesoinAchat extends CI_Controller {
    public function formulaireBesoinAchat(){
        $data['article']=$this->Generalisation->avoirTable("article");
        $this->load->view('header');
        $this->load->view('FormulaireBesoinAchat',$data);
    }

    public function entrerBesoin(){
        date_default_timezone_set('Africa/Nairobi');
        $date=date('Y-m-d');
        $idEmploye=$_SESSION['user'];
        $dateBesoin=$this->input->post('dateBesoin');
        $employePoste=$this->Generalisation->avoirTableSpecifique("v_posteEmploye","*"," idemploye='".$idEmploye."'");
        $valeur="(default,'".$employePoste[0]->iddepartement."','".$dateBesoin."','".$idEmploye."',0,'".$date."')";
        $this->Generalisation->insertion("besoinAchat",$valeur);
        $valeur=intval($_POST['nombreArticle']);
        $besoinAchat=$this->Generalisation->avoirTableAutrement("besoinAchat","*"," order by idBesoinAchat desc");
        for ($i=1; $i <=$valeur ; $i++) { 
            $val="(default,'".$_POST['article'.$i]."',".$_POST['quantite'.$i].",'".$besoinAchat[0]->idbesoinachat."',1)";
            $this->Generalisation->insertion("detailBesoinAchat",$val);
        }
        $data['article']=$this->Generalisation->avoirTable("article");
        $this->load->view('header');
        $this->load->view('FormulaireBesoinAchat',$data);
    }

    public function affichageAchatNonValide(){
        $idEmploye=$_SESSION['user'];
        $employePoste=$this->Generalisation->avoirTableSpecifique("v_posteEmployeValidation","*"," idemploye='".$idEmploye."'");
        echo $employePoste[0]->libelle;

        if($employePoste[0]->libelle=="achat"){
            $data['besoinAchat']=$this->BesoinAchat->avoirAchatNonValide($employePoste[0]->iddepartement);
            $this->load->view('header');
            $this->load->view('AchatNonValide',$data);
        }else{
            $data["error"]="Vous n'avez pas accès à cette page";
            $this->load->view('header');
            $this->load->view('errors/erreurValidationAchat',$data);
        }
    }

    public function valider(){
        $idBesoinAchat=$_GET['idBesoinAchat'];
        $this->Generalisation->miseAJour("besoinAchat","etat=1"," idBesoinAchat='".$idBesoinAchat."'");
        redirect('welcome/versAcceuil');
    }

    public function avoirAchatValide(){
        $idEmploye=$_SESSION['user'];
        $employePoste=$this->Generalisation->avoirTableSpecifique("v_posteEmployeValidation","*"," idemploye='".$idEmploye."'");
        if($employePoste[0]->nomdepartement=="Systeme commercial"){
            $data['besoinAchat']=$this->BesoinAchat->avoirAchatValide();
            $this->load->view('header');
            $this->load->view('AchatValide',$data);
        }
        else{
            $data["error"]="Vous n'avez pas accès à cette page";
            $this->load->view('header');
            $this->load->view('errors/erreurValidationAchat',$data);
        }
    }

    public function regrouper(){
        $regroupement=$this->Generalisation->avoirTableSpecifique("v_detailBesoinachat","idArticle,sum(quantite)as quantite"," etat=1 group by idArticle");
        $this->BesoinAchat->entrerRegroupement($regroupement);
        $data['article']=$this->Generalisation->avoirTable("article");
        $this->load->view('header');
        $this->load->view('FormulaireBesoinAchat',$data);
    }
}
