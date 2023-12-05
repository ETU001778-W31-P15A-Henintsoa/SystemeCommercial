<?php
class Login_modele extends CI_Model {
    public function verification_login($mail, $mdp){
        $error="";
		if ($mail == "" || $mdp == "") {
			$error['error'] = "Les Champs ne doivent pas etre vides.";
			$this->load->view('index', $error);
		} else {
			$users = $this->Generalisation->avoirTable('v_posteemploye');

			$test = FALSE;
			foreach ($users as $user) {
				if ($user->mail == $mail && $user->motdepasse == $mdp) {
					$test=TRUE;
					$_SESSION['user'] = $user -> idemploye;
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
