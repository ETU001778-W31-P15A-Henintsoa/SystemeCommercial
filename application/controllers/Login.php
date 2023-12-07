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

			// var_dump(trim($mdp));
			// var_dump(trim($mail));

			$reponse = $this->Login_modele->verification_login(trim($mail), trim($mdp));

			// var_dump($_SESSION['user']);

			if($reponse==""){
				redirect("welcome/versAcceuil");
			}
		}

		

		public function deconnection(){
			session_destroy();

			$this->load->view('index');
			// redirection('index.php');
		}
    }
?>