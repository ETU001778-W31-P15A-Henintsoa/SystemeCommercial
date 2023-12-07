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
        $bonreception=$this->Generalisation->avoirTableAutrement("bonreception","*"," order by idBonReception desc");
        for ($i=1; $i <=$valeur ; $i++) { 
            $val="(default,'".$bonreception[0]->idbonreception."','".$_POST['article'.$i]."',".$_POST['quantite'.$i].")";
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
            $this->load->view('receptionanormal',$data);
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

    public function versBonDeReceptionPdf($idboncommande, $idfournisseur){
        $fournisseur = $this->Generalisation->avoirTableSpecifique("fournisseur", "*", sprintf("idfournisseur='%s'", $idfournisseur));
        $data = $this->ReceptionModele->avoirDonnee($idboncommande);
        $data['fournisseur'] = $fournisseur[0];
        return $this->load->view('BonReceptionPDF', $data, true);
    }

    public function genererPDF() {
        $idboncommande = $this->input->get('idreception');
        $idfournisseur = $this->input->get('idfourniseur');

        $fournisseur = $this->Generalisation->avoirTableSpecifique("fournisseur", "*", sprintf("idfournisseur='%s'", $idfournisseur));

        // Créer une instance de votre classe MYPDF
        $pdf = new TCPDF();
    

        $nomPDF = "Reception_".date("Y-M-D")."_DIMPEX.pdf";
        $pdf->AddPage();
        $data['content'] = $this->versBonDeReceptionPdf($idboncommande, $idfournisseur);
    
        // Ajoutez le HTML au PDF
        $pdf->writeHTML($data['content'], true, false, true, false, '');
    
        // Ajoutez le PDF- aux données
        $data['pdf'] = $pdf;
    
        // Chargez la vue avec les données
        $this->load->view('BonDeCommandePDF', $data);
        $pdf->Output($nomPDF, 'I');
    }

}

//stage impreniation
//prix,mora ampiasaina kokoa, mitondra innovation
//mbi   