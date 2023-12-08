<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Africa/Nairobi'); // Remplacez 'Africa/Nairobi' par le fuseau horaire approprié


class BonReception extends CI_Controller {
    public function versFormulaireBonReception(){
        $idEmploye=$_SESSION['user'];//emp3
        $employePoste=$this->Generalisation->avoirTableSpecifique("v_posteEmployeValidation","*"," idemploye='".$idEmploye."'");

        if($employePoste[0]->nomdepartement=="Systeme commercial"){
            $data['article']=$this->Generalisation->avoirTable("article");
            $this->load->view('header');
            $this->load->view('FormulaireReception',$data);
            // redirect("welcome/versAcceuil");
        }else{
            $data["error"]="Vous n'avez pas accès à cette page";
            $this->load->view('header');
            $this->load->view('errors/erreurValidationAchat',$data);
        }
    }

    public function insertionBonReception(){
        $idbondecommande=$_POST['idBon'];
        $date=$_POST['dateReception'];
        $valeur="(default,'".$date."','".$idbondecommande."',0)";
        $this->Generalisation->insertion("Bonreception",$valeur);
        $valeur=intval($_POST['nombreArticle']);
        $bonreception=$this->Generalisation->avoirTable("bonreception");
        for ($i=1; $i <=$valeur ; $i++) { 
            $val="(default,'".$bonreception[count($bonentre)-1]->idbonreception."','".$_POST['article'.$i]."',".$_POST['quantite'.$i].")";
            $this->Generalisation->insertion("detailbonreception",$val);
        }
        $data['article']=$this->Generalisation->avoirTable("article");
        $this->load->view('header');
        $this->load->view('acceuil',$data);
    }

    public function validerBonReception(){
        $idReception=$_GET['idbonreception'];
        $verificationArticle=$this->ReceptionModele->verifierNombre($idReception);
        if(count($verificationArticle)==0){
            $this->Generalisation->miseAJour("bonreception"," etat=11"," idbonreception='".$idReception."'");//11 ilay etat rehefa 
           // redirect("welcome/versAcceuil");
        }
        else{
            $data['nbArticleAnormal']=$verificationArticle;
            $this->load->view('header');
            $this->load->view('receptionAnormal',$data);
        }
    }

    public function avoirReceptionNonValide(){
        $idEmploye=$_SESSION['user'];//emp3
        $employePoste=$this->Generalisation->avoirTableSpecifique("v_posteEmployeValidation","*"," idemploye='".$idEmploye."'");

        if($employePoste[0]->nomdepartement=="Systeme commercial" && $employePoste[0]->libelle=="achat"){
            $data['reception']=$this->Generalisation->ReceptionModele->avoirNonValide();
            $this->load->view('header');
            $this->load->view('receptionNonValide',$data);
        }else{
            $data["error"]="Vous n'avez pas accès à cette page";
            $this->load->view('header');
            $this->load->view('errors/erreurValidationAchat',$data);
        }
    }

            public function avoirDonnee($idReception){
            $articleAQuantiteanormal = $this->verifierNombre($idReception);

            $detailReception=$this->Generalisation->avoirTableSpecifique("v_detailBonReception","*"," idbonreception='".$idReception."' order by idArticle desc");

            $data = array();

            $data['reception'] = $detailReception;
            $data['anormal'] = $articleAQuantiteanormal;
            
            return $data;        
        }
}

//stage impreniation
//prix,mora ampiasaina kokoa, mitondra innovation
//mbi   