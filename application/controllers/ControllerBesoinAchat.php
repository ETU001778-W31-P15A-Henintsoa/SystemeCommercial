<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ControllerBesoinAchat extends CI_Controller {
    public function formulaireBesoinAchat(){
        $data['article']=$this->Generalisation->avoirTable("article");
        $this->load->view('header');
        $this->load->view('formulaireBesoinAchat',$data);
    }

    public function entrerBesoin(){
        date_default_timezone_set('Africa/Nairobi');
        $date=date('Y-m-d');
        $idEmploye='EMP1';
        $dateBesoin=$_POST['dateBesoin'];
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
        $this->load->view('formulaireBesoinAchat',$data);
    }
}
