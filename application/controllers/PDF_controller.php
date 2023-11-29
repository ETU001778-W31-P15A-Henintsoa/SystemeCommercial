<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class PDF_controller extends CI_Controller {

		public function pdf(){
			$this->load->model('PDF_modele');
            $this->PDF_modele->genererPDF();
			// redirection('index.php');
		}
    }
?>