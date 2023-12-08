<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Africa/Nairobi'); // Remplacez 'Africa/Nairobi' par le fuseau horaire approprié


class BonSorti extends CI_Controller {

    public function versFormulaireBonSortiClient(){
        $idEmploye=$_SESSION['user'];//emp3
        $employePoste=$this->Generalisation->avoirTableSpecifique("v_posteEmployeValidation","*"," idemploye='".$idEmploye."'");

        if($employePoste[0]->nombranche=="Magasinier"){
            $data['article']=$this->Generalisation->avoirTable("article");
            $data['client']=$this->Generalisation->avoirTable("client");
            $this->load->view('header');
            $this->load->view('FormulaireBonSortiClient',$data);
        }else{
            $data["error"]="Vous n'avez pas accès à cette page";
            $this->load->view('header');
            $this->load->view('errors/erreurValidationAchat',$data);
        }
    }

    public function versFormulaireBonSortiDepartement(){
        $data['article']=$this->Generalisation->avoirTable("article");
        $data['departement']=$this->Generalisation->avoirTable("departement");
        $this->load->view('header');
        $this->load->view('FormulaireSortiDepartement',$data);
    }

    public function entrerSortiClient(){
        $date=$_POST['dateReception'];
        $idClient=$_POST['idClient'];
        $valeur="(default,'".$date."',default,'".$idClient."',0)";
        $this->Generalisation->insertion("bonsortie",$valeur);
        $valeur=intval($_POST['nombreArticle']);
        $bonsortie=$this->Generalisation->avoirTableAutrement("bonsortie","*"," order by idBonSortie desc");
        for ($i=1; $i <=$valeur ; $i++) { 
            $val="(default,".$_POST['article'.$i]."',".$_POST['quantite'.$i].",'".$bonsortie[0]->idbonsortie."')";
            $this->Generalisation->insertion("detailbonsortie",$val);
        }
        $data['article']=$this->Generalisation->avoirTable("article");
        $this->load->view('header');
        $this->load->view('acceuil',$data);
    }

    public function entrerSortidepartement(){
        $date=$_POST['datesorti'];
        $idDepartement=$_POST['idDepartement'];
        $valeur="(default,'".$date."','".$idDepartement."',default,0)";
        $this->Generalisation->insertion("bonsortie",$valeur);
        $valeur=intval($_POST['nombreArticle']);
        $bonsortie=$this->Generalisation->avoirTable("bonsortie");
        for ($i=1; $i <=$valeur ; $i++) { 
            $val="(default,'".$_POST['article'.$i]."',".$_POST['quantite'.$i].",'".$bonsortie[count($bonsortie)-1]->idbonsortie."')";
            $this->Generalisation->insertion("detailbonsortie",$val);
        }
        $data['article']=$this->Generalisation->avoirTable("article");
        $this->load->view('header');
        $this->load->view('acceuil',$data);
    }

    public function avoirSortiNonValideDept(){
        $idEmploye=$_SESSION['user'];
        $employePoste=$this->Generalisation->avoirTableSpecifique("v_posteEmployeValidation","*"," idemploye='".$idEmploye."'");

        if($employePoste[0]->nombranche=="Magasinier"){
            $data['sorti']=$this->BonSortiModele->avoirSortiNonValidedept();
            $this->load->view('header');
            $this->load->view('sortideptnonvalide',$data);
        }else{
            $data["error"]="Vous n'avez pas accès à cette page";
            $this->load->view('header');
            $this->load->view('errors/erreurValidationAchat',$data);
        }
    }

    public function validerBonSortiDept(){
        $idbonsortie=$_GET['idbonsortie'];
        $sorti=$this->BonSortiModele->avoirdetailSortiSpecifique($idbonsortie);
        $quantiteinsu=$this->BonSortiModele->verifierStock($sorti);
        if(count($quantiteinsu)==0){
            $this->BonSortiModele->misAJourStock($sorti);
        }else{
            $data['insu']=$quantiteinsu;
            $this->load->view('header');
            $this->load->view('sortiinsuffisant',$data);
        }
    }

    public function annulerSorti(){
        $idbonsorti=$_GET['idbonsorti'];
        $valeur="etat=-1";
        $this->Generalisation->miseAJour("bonsortie",$valeur," idbonsortie='".$idbonsorti."'");
        redirect("welcome/versAcceuil");
    }
}
?>