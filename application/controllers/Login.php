<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Login extends CI_Controller {
		public function index(){
			$this->load->view('login');
		}
		
        public function traitementlogin()
		{
			$mail = $this->input->post('mail');
			$mdp = $this->input->post('mdp');

			$reponse = $this->Login_modele->verification_login($mail, $mdp);


			if($reponse==true){
				redirect("welcome/header");
			}
		}

		

		public function deconnection(){
			session_destroy();

			$this->load->view('index');
			// redirection('index.php');
		}
    }
?>