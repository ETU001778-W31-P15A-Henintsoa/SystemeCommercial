<?php
class Login_modele extends CI_Model {
    public function verification_login($mail, $mdp){
        $error="";
		if ($mail == "" || $mdp == "") {
			$error['error'] = "Les Champs ne doivent pas etre vides.";
			$this->load->view('index', $error);
		} else {
			$users = $this->Generalisation->avoirTable('employe');

			$test = FALSE;
			foreach ($users as $user) {
				// var_dump($users);
				if ($user->mail == $mail && $user->mdp == $mdp) {
					// var_dump($user);
					if($user->estactif == false) {
						$error['error'] = "Cet Employe ne travail plus ici. Acces interdit";
						$this->load->view('index',$error);
						return false;
					}else{
						session_start();
						$this->load->library('session');
						return true; 
					}
				}
			}
			
			if ($test == FALSE) {
				$error['error'] = "Mot de passe ou mail incorrect";
				$this->load->view('index', $error);
			}
            return $error;
		}
	}
}
?>
