<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Africa/Nairobi'); // Remplacez 'Africa/Nairobi' par le fuseau horaire approprié


class AccuseReception extends CI_Controller {

    public function versFormulaireAccuse(){
        $data['article']=$this->Generalisation->avoirTable("article");
        $this->load->view('header');
        $this->load->view('FormulaireAccuse',$data);
    }
    public function entrerAccuseReception(){
        $idSortie=trim($_POST['idBonSorti']);
        $date=trim($_POST['dateAccuse']);
        $employe=$_SESSION['user'];
        $dept=$this->Generalisation->avoirTableSpecifique("v_posteemploye","*"," idemploye='".$employe."'");
        $idDepartement=trim($dept[0]->iddepartement);
        $sortiedepartement=$this->Generalisation->avoirTAbleSpecifique("bonsortie","*"," etat>=11 and idbonsortie='".$idSortie."' and idDepartement='".$idDepartement."'");
        if(count($sortiedepartement)!=0){
             $valeur="(default,'".$date."','".$idDepartement."','".$idSortie."',0)";
            $this->Generalisation->insertion("accusereception",$valeur);
            $valeur=intval($_POST['nombreArticle']);
            $accusereception=$this->Generalisation->avoirTableAutrement("accusereception","*"," order by idaccusereception desc");
            for ($i=1; $i <=$valeur ; $i++) { 
                $val="(default,'".$accusereception[0]->idaccusereception."','".$_POST['article'.$i]."',".$_POST['quantite'.$i].")";
                $this->Generalisation->insertion("detailaccusereception",$val);
            }
            $data['article']=$this->Generalisation->avoirTable("article");
            $this->load->view('header');
            $this->load->view('acceuil',$data);
        }
       else{
       
            $data['erreur']="Ce bon de sortie n'existe pas encore ou n'est pas pour votre departement";
            $this->load->view('header');
            $this->load->view('ErreurAccuse',$data);
       }
    }

    public function versListeNonValide(){
        $employe=$_SESSION['user'];
        $dept=$this->Generalisation->avoirTableSpecifique("v_posteemploye","*"," idemploye='".$employe."'");
        $idDepartement=$dept[0]->iddepartement;
        $data['accuse']=$this->AccuseReceptionModele->avoirNonValide($idDepartement);
        $this->load->view('header');
        $this->load->view('AccuseReceptionNonValide',$data);
    }

    public function validerAccuseReception(){
        $idaccuse=$_GET['idaccuse'];
        $verificationArticle=$this->AccuseReceptionModele->verifierNombre($idaccuse);
        if(count($verificationArticle)==0){
            $this->Generalisation->miseAJour("accusereception"," etat=11"," idaccusereception='".$idaccuse."'");//11 ilay etat rehefa 
            redirect("welcome/versAcceuil");
        }
        else{
            $data['nbArticleAnormal']=$verificationArticle;
            $this->load->view('header');
            $this->load->view('accuseAnormal',$data);
        }
    }

    public function versExplication(){
        $data['accuse']=$_GET['accuse'];
        $this->load->view('header');
        $this->load->view('AccuseExplication',$data);
    }
    public function validerExplication(){
        $accuse=$_POST['idbon'];
        $raison=$_POST['raison'];
        $valeur="(default,'accuse','".$accuse."','".$raison."')";
        $this->Generalisation->insertion("explication",$valeur);
        $this->Generalisation->miseAJour("accusereception"," etat=11"," idaccusereception='".$accuse."'");//11 ilay etat rehefa
        redirect("welcome/versAcceuil");
    }
    public function annuler(){
        redirect("welcome/versAcceuil");
    }

    public function listevalide(){
        $employe=$_SESSION['user'];
        $dept=$this->Generalisation->avoirTableSpecifique("v_posteemploye","*"," idemploye='".$employe."'");
        $idDepartement=$dept[0]->iddepartement;
        $data['accuse']=$this->AccuseReceptionModele->avoirValide($idDepartement);
        $this->load->view('header');
        $this->load->view('AccuseValide',$data);
    }

    // PDF
    public function versBonAccusePdf($idaccuse){
        $data = $this->AccuseReceptionModele->avoirDonnee($idaccuse);    
        return $this->load->view('BonAccusePDF', $data, true);
    }

    public function genererPDF() {
        $idaccuse = $this->input->get('idaccuse');

        // Créer une instance de votre classe MYPDF
        $pdf = new TCPDF();

        $employe = $this->Generalisation->avoirTableSpecifique("v_posteemploye", "*", sprintf("idemploye='%s'", $_SESSION['user']));
        $departement = $this->Generalisation->avoirTableSpecifique("departement", "*", sprintf("iddepartement='%s'", $employe[0]->iddepartement));
    

        $nomPDF = "AccuseeReception_".date("Y-M-D")."_".$departement[0]->nomdepartement.".pdf";
        $pdf->AddPage();
        $data['content'] = $this->versBonAccusePdf($idaccuse);
    
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