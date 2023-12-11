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
        $idEmploye=$_SESSION['user'];//emp3
        $employePoste=$this->Generalisation->avoirTableSpecifique("v_posteEmployeValidation","*"," idemploye='".$idEmploye."'");

        if($employePoste[0]->nombranche=="Magasinier"){
            $data['article']=$this->Generalisation->avoirTable("article");
            $data['departement']=$this->Generalisation->avoirTable("departement");
            $data['besoin']=$this->BesoinAchat->avoirToutAchatValideNonLivre();
            $this->load->view('header');
            $this->load->view('FormulaireSortiDepartement',$data);
        }else{
            $data["error"]="Vous n'avez pas accès à cette page";
            $this->load->view('header');
            $this->load->view('errors/erreurValidationAchat',$data);
        }
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
        $besoin=$this->Generalisation->avoirTableSpecifique("v_detailbesoinachat","*"," iddepartement='".$sorti[0]['sorti']->iddepartement."'");
        $quantitesup=$this->BonSortiModele->verifierSortie($sorti,$besoin);
        $quantiteinsu=$this->BonSortiModele->verifierStock($sorti);
       // echo count( $quantitesup);
        if(count($quantitesup)==0){
             if(count($quantiteinsu)==0){
                $this->BonSortiModele->misAJourStock($sorti);
                redirect("Welcome/versAcceuil");
            }else{
                $data['insu']=$quantiteinsu;
                $this->load->view('header');
                $this->load->view('sortiinsuffisant',$data);
            }
        }else{
            $data['quantitesup']=$quantitesup;
            $this->load->view('header');
            $this->load->view('SortiSup',$data);
        }
    }

    public function annulerSorti(){
        $idbonsorti=$_GET['idbonsorti'];
        $valeur="etat=-1";
        $this->Generalisation->miseAJour("bonsortie",$valeur," idbonsortie='".$idbonsorti."'");
        redirect("Welcome/versAcceuil");
    }

    public function avoirSortiValideDept(){
        $idEmploye=$_SESSION['user'];
        $employePoste=$this->Generalisation->avoirTableSpecifique("v_posteEmployeValidation","*"," idemploye='".$idEmploye."'");

        if($employePoste[0]->nombranche=="Magasinier"){
            $data["sorti"]=$this->BonSortiModele->avoirSortiValideDept();
            $this->load->view('header');
            $this->load->view('SortiDeptValide',$data);
        }else{
            $data["error"]="Vous n'avez pas accès à cette page";
            $this->load->view('header');
            $this->load->view('errors/erreurValidationAchat',$data);
        }
    }


    public function versBonSortiePdf($iddepartement, $idbonsortie){
        $data = $this->BonSortiModele->avoirDonnee($iddepartement, $idbonsortie);    
        return $this->load->view('BonSortiePDF', $data, true);
    }

    public function genererPDF() {
        $idbonsorti = $this->input->get('idbonsorti');
        $iddepartement = $this->input->get('iddepartement');

        $departement = $this->Generalisation->avoirTableSpecifique("departement", "*", sprintf("iddepartement='%s'", $iddepartement));

        // Créer une instance de votre classe MYPDF
        $pdf = new TCPDF();
    

        $nomPDF = "Sortie".date("Y-M-D")."_".$departement[0]->nomdepartement.".pdf";
        $pdf->AddPage();
        $data['content'] = $this->versBonSortiePdf($iddepartement, $idbonsorti);
    
        // Ajoutez le HTML au PDF0
        $pdf->writeHTML($data['content'], true, false, true, false, '');
    
        // Ajoutez le PDF- aux données
        $data['pdf'] = $pdf;
    
        // Chargez la vue avec les données
        $this->load->view('BonDeCommandePDF', $data);
        $pdf->Output($nomPDF, 'I');
    }
}
?>