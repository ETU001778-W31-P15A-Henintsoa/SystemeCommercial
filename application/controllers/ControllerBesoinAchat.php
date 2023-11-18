<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ControllerBesoinAchat extends CI_Controller {
    public function formulaireBesoinAchat(){
        $data['article']=$this->Generalisation->avoirTable("article");
        $this->load->view('header');
        $this->load->view('formulaireBesoinAchat',$data);
    }
}
