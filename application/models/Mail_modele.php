<?php 
    if(! defined('BASEPATH')) exit('No direct script access allowed');

    class Mail_modele extends CI_Model{

        public function copierPdf(){
            shell_exec("cp -rf /var/www/html/SystemeCommercial/SystemeCommercial/upload/* /var/www/html/Fournisseur/FournisseurSystemeCommercial/upload/");
        }

        public function updatereception($idreception){
            $this->Generalisation->miseAJour("bonreception", "etat=21", sprintf("idbonreception='%s'", $idreception));
        }

        // Fonctions Fonctionnelles
        public function envoieMail($destinataire, $message, $fichier, $idregroupement){
            $mail = $this->monMail();
            $message = "Demande de Proforma//".$message;
            $destinataire = $this->Generalisation->avoirTableSpecifique("adressemail", "*", sprintf("adressemail='%s'", $destinataire));

            if(count($destinataire)==0){
                return false;
            }

            $this->Generalisation->insertion("mail(dateenvoie, envoyeur, destinataire)", sprintf("(current_date, '%s', '%s')", $mail->idadressemail, $destinataire[0]->idadressemail));
            
            $mails = $this->Generalisation->avoirTableConditionnee("mail order by idmail");

            $this->Generalisation->insertion("message(idmail, libelle, piecejointe)", sprintf("('%s', '%s', '%s')", $mails[count($mails)-1]->idmail, $message, $fichier));

            $this->Generalisation->miseAJour("regroupement", "etat=11", sprintf("idregroupement='%s'", $idregroupement));

            $this->copierPdf();

            return true;
        }

        public function envoieMailBonDeCommande($destinataire, $message, $piecejointe, $idbondecommande){
            $mail = $this->monMail();
            $message = "Demande de Proforma//".$message;
        
            // $this->envoyerEmailReel($destinataire, $sujet, $message, $fichier);

            // var_dump($destinataire);

            if(count($destinataire)==0){
                return false;
            }

            $this->Generalisation->insertion("mail(dateenvoie, envoyeur, destinataire)", sprintf("(current_date, '%s', '%s')", $mail->idadressemail, $destinataire->idadressemail));
            
            $mails = $this->Generalisation->avoirTableConditionnee("mail order by idmail");

            $this->Generalisation->insertion("message(idmail, libelle, piecejointe)", sprintf("('%s', '%s', '%s')", $mails[count($mails)-1]->idmail, $message, $piecejointe));

            $this->Generalisation->miseAJour("bondecommande", "etat=41", sprintf("idbondecommande='%s'", $idbondecommande));

            $this->copierPdf();

            return true;
        }

        public function envoieMailReception($destinataire, $message, $piecejointe){
            $mail = $this->monMail();
            $message = "Demande de Proforma//".$message;

            if(count($destinataire)==0){
                return false;
            }

            $this->Generalisation->insertion("mail(dateenvoie, envoyeur, destinataire)", sprintf("(current_date, '%s', '%s')", $mail->idadressemail, $destinataire->idadressemail));
            
            $mails = $this->Generalisation->avoirTableConditionnee("mail order by idmail");

            $this->Generalisation->insertion("message(idmail, libelle, piecejointe)", sprintf("('%s', '%s', '%s')", $mails[count($mails)-1]->idmail, $message, $piecejointe));

            $this->copierPdf();

            return true;
        }

        public function envoieMailSimple($destinataire, $message, $piecejointe){
            $mail = $this->monMail();
            $message = "//".$message;

            if(count($destinataire)==0){
                return false;
            }

            $this->Generalisation->insertion("mail(dateenvoie, envoyeur, destinataire)", sprintf("(current_date, '%s', '%s')", $mail->idadressemail, $destinataire->idadressemail));
            
            $mails = $this->Generalisation->avoirTableConditionnee("mail order by idmail");

            $this->Generalisation->insertion("message(idmail, libelle, piecejointe)", sprintf("('%s', '%s', '%s')", $mails[count($mails)-1]->idmail, $message, $piecejointe));

            $this->copierPdf();

            return true;
        }

        // Fonctions Fonctionnelles
        public function envoieMailSimpleDepartement($envoyeur, $destinataire, $message, $fichier, $idregroupement){
            $mail = $this->monMail();
            $message = "MailDepartement//".$message;

            if(count($destinataire)==0){
                return false;
            }

            $this->Generalisation->insertion("mail(dateenvoie, envoyeur, destinataire)", sprintf("(current_date, '%s', '%s')", $envoyeur[0]->idadressemail, $destinataire[0]->idadressemail));
            
            $mails = $this->Generalisation->avoirTableConditionnee("mail order by idmail");

            $this->Generalisation->insertion("message(idmail, libelle, piecejointe)", sprintf("('%s', '%s', '%s')", $mails[count($mails)-1]->idmail, $message, $fichier));

            return true;
        }

        public function monMail(){
            $monentreprise = $this->Generalisation->avoirTable("entreprise");
            $mail = $this->Generalisation->avoirTableSpecifique("adressemail", "*", sprintf("idsociete='%s'", $monentreprise[0]->identreprise));
            return $mail[0];
        }

        public function message($mail, $fournisseur){
            // var_dump($mail);
            $messages = $this->Generalisation->avoirTableConditionnee(sprintf("v_mailmessage where (envoyeur='%s' and destinataire='%s') or (envoyeur='%s' and destinataire='%s') order by dateenvoie", $mail->idadressemail, $fournisseur->idadressemail, $fournisseur->idadressemail, $mail->idadressemail));
            
            foreach($messages as $message){
                $message->etat = 0;
                $message->p = 0;
                if($message->envoyeur == $mail->idadressemail){
                    $message->etat = 1;
                }
                if($message->piecejointe!="" && $message->piecejointe!=null){
                    $message->p = 1;
                }
            }
            return $messages;
        }

    }
    
?>