<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Africa/Nairobi'); // Remplacez 'Africa/Nairobi' par le fuseau horaire approprié


class BonEntre extends CI_Controller {

    public function versFormulaireBonEntre(){
        $idEmploye=$_SESSION['user'];//emp3
        $employePoste=$this->Generalisation->avoirTableSpecifique("v_posteEmployeValidation","*"," idemploye='".$idEmploye."'");

        if($employePoste[0]->nombranche=="Magasinier"){
            $data['article']=$this->Generalisation->avoirTable("article");
            $this->load->view('header');
            $this->load->view('FormulaireBonEntre',$data);
        }else{
            $data["error"]="Vous n'avez pas accès à cette page";
            $this->load->view('header');
            $this->load->view('errors/erreurValidationAchat',$data);
        }
    }

    public function insertionBonEntre(){
        $idBonReception=$_POST['idBon'];
        $date=$_POST['dateEntre'];
        $valeur="(default,'".$date."',0,'".$idBonReception."')";
        $this->Generalisation->insertion("bonEntre",$valeur);
        $valeur=intval($_POST['nombreArticle']);
        echo $valeur;
        $bonentre=$this->Generalisation->avoirTable("bonentre");
        echo $bonentre[count($bonentre)-1]->idbonentre;
        for ($i=1; $i <=$valeur ; $i++) { 
            $val="(default,'".$bonentre[count($bonentre)-1]->idbonentre."','".$_POST['article'.$i]."',".$_POST['quantite'.$i].")";
            $this->Generalisation->insertion("detailbonentre",$val);
        }
        $data['article']=$this->Generalisation->avoirTable("article");
        $this->load->view('header');
        $this->load->view('acceuil',$data);
    }

    public function validerBonEntre(){
        $idBonEntre=$_GET['idBonEntre'];
        $verificationArticle=$this->BonEntreModele->verifierNombre($idBonEntre);
        echo count($verificationArticle);
        if(count($verificationArticle)==0){
            $this->BonEntreModele->insertionStock($idBonEntre);
            $this->Generalisation->miseAJour("bonentre"," etat=11"," idbonentre='".$idBonEntre."'");//11 ilay etat rehefa 
           // redirect("welcome/versAcceuil");
        }
        else{
            $data['nbArticleAnormal']=$verificationArticle;
            $this->load->view('header');
            $this->load->view('entreanormale',$data);
        }
    }

    public function avoirEntreNonValide(){
        $idEmploye=$_SESSION['user'];//emp3
        $employePoste=$this->Generalisation->avoirTableSpecifique("v_posteEmployeValidation","*"," idemploye='".$idEmploye."'");

        if($employePoste[0]->nombranche=="Magasinier"){
            $data['entre']=$this->Generalisation->BonEntreModele->avoirNonValide();
            $this->load->view('header');
            $this->load->view('entreNonValide',$data);
        }else{
            $data["error"]="Vous n'avez pas accès à cette page";
            $this->load->view('header');
            $this->load->view('errors/erreurValidationAchat',$data);
        }
    }

    public function versFormulaireExplication(){
        $data['idBon']=$_GET['idBon'];
        $this->load->view('header');
        $this->load->view('ExplicationEntre',$data);
    }

    public function insererExplication(){
        $idBonEntre=$_POST['idbon'];
        $raison=$_POST['raison'];
        $valeur="(default,'entre','".$idBonEntre."','".$raison."')";
        $this->Generalisation->insertion("explication",$valeur);
        $this->BonEntreModele->insertionStock($idBonEntre);
        $this->Generalisation->miseAJour("bonentre"," etat=11"," idbonentre='".$idBonEntre."'");//11 ilay etat rehefa
        redirect("welcome/versAcceuil");
    }
}

//stage impreniation
//prix,mora ampiasaina kokoa, mitondra innovation
//mbi