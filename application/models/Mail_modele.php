<?php 
    if(! defined('BASEPATH')) exit('No direct script access allowed');

    class Mail_modele extends CI_Model{

        public function copierPdf(){
            shell_exec("cp -rf /var/www/html/SystemeCommercial/SystemeCommercial/upload/* /var/www/html/Fournisseur/FournisseurSystemeCommercial/upload/");
        }

        // Fonctions Fonctionnelles
        public function envoieMail($destinataire, $message, $fichier, $idregroupement){
            $mail = $this->monMail();
            $message = "Demande de Proforma//".$message;
            $destinataire = $this->Generalisation->avoirTableSpecifique("adressemail", "*", sprintf("adressemail='%s'", $destinataire));
            $fichier = $fichier;
            // $this->envoyerEmailReel($destinataire, $sujet, $message, $fichier);

            // var_dump($destinataire);

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

        public function envoieMailBonDeCommande($destinataire, $messages, $idbondecommande){
            $mail = $this->monMail();
            $message = "Demande de Proforma//".$message;
            $destinataire = $this->Generalisation->avoirTableSpecifique("adressemail", "*", sprintf("adressemail='%s'", $destinataire));
            $fichier = $fichier;
            // $this->envoyerEmailReel($destinataire, $sujet, $message, $fichier);

            // var_dump($destinataire);

            if(count($destinataire)==0){
                return false;
            }

            $this->Generalisation->insertion("mail(dateenvoie, envoyeur, destinataire)", sprintf("(current_date, '%s', '%s')", $mail->idadressemail, $destinataire[0]->idadressemail));
            
            $mails = $this->Generalisation->avoirTableConditionnee("mail order by idmail");

            $this->Generalisation->insertion("message(idmail, libelle, piecejointe)", sprintf("('%s', '%s', '%s')", $mails[count($mails)-1]->idmail, $message, $fichier));

            $this->Generalisation->miseAJour("bondecommande", "etat=11", sprintf("idbondecommande='%s'", $idbondecommande));

            $this->copierPdf();

            return true;
        }

        // Fonctions Fonctionnelles
        public function envoieMailDepartement($envoyeur, $destinataire, $message, $fichier, $idregroupement){
            $mail = $this->monMail();
            $message = "Demande de Proforma//".$message;
            $destinataire = $this->Generalisation->avoirTableSpecifique("adressemail", "*", sprintf("adressemail='%s'", $destinataire));
            $fichier = $fichier;
            // $this->envoyerEmailReel($destinataire, $sujet, $message, $fichier);

            // var_dump($destinataire);

            if(count($destinataire)==0){
                return false;
            }

            $this->Generalisation->insertion("mail(dateenvoie, envoyeur, destinataire)", sprintf("(current_date, '%s', '%s')", $mail->idadressemail, $destinataire[0]->idadressemail));
            
            $mails = $this->Generalisation->avoirTableConditionnee("mail order by idmail");

            $this->Generalisation->insertion("message(idmail, libelle, piecejointe)", sprintf("('%s', '%s', '%s')", $mails[count($mails)-1]->idmail, $message, $fichier));

            // $this->Generalisation->miseAJour("regroupement", "etat=11", sprintf("idregroupement='%s'", $idregroupement));

            return true;
        }


        public function monMail(){
            $monentreprise = $this->Generalisation->avoirTable("entreprise");
            $mail = $this->Generalisation->avoirTableSpecifique("adressemail", "*", sprintf("idsociete='%s'", $monentreprise[0]->identreprise));
            return $mail[0];
        }


        public function message($mail, $fournisseur){
            $messages = $this->Generalisation->avoirTableConditionnee(sprintf("v_mailmessage where (envoyeur='%s' and destinataire='%s') or (envoyeur='%s' and destinataire='%s') order by dateenvoie", $mail, $fournisseur, $fournisseur, $mail));
            // var_dump($messages);
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