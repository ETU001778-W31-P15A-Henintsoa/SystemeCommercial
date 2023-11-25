<?php 
    if(! defined('BASEPATH')) exit('No direct script access allowed');
    class BonDeCommande_modele extends CI_Model{
        public function avoirMoinsDisant() {
            $proforma = $this->Generalisation->avoirTableAutrement("donneeProforma", "idarticle,idfournisseur,STRING_AGG(quantite::text, ', ') AS quantite,MIN(pu) AS pu", "GROUP BY idarticle, idfournisseur ORDER BY pu ASC");
            $quantiteDemandee = array('ART1' => 30, 'ART2' => 30);
            $this->genererBonDeCommande($quantiteDemandee,$proforma);
            return $proforma;
        }
        
        public function insertionBonDeCommande($NomTable, $data) {
            $this->db->insert($NomTable, $data);
            $this->Generalisation->insertion("bo");
        
            // Manually fetch the last value from the sequence
            $query = $this->db->query("SELECT concat('COM' || currval('seqBonDeCommande')) AS idbondecommande");
            $result = $query->row();
        
            // Get the last inserted ID
            $lastInsertedId = $result->idbondecommande;
        
            return $lastInsertedId;
        }
        
        public function avoirListeBonDeCommandeNonValide() {
            $sql = "SELECT * FROM bondecommande where etat = 0";
            $query = $this->db->query($sql);
            $result = $query->result_array();
            return $result;
        }

        public function avoirListeBonDeCommandeValide() {
            $sql = "SELECT * FROM bondecommande where etat = 21";
            $query = $this->db->query($sql);
            $result = $query->result_array();
            return $result;
        }

        public function avoirListeBonDeCommandeValideDG() {
            $sql = "SELECT * FROM bondecommande where etat = 31";
            $query = $this->db->query($sql);
            $result = $query->result_array();
            return $result;
        }

        public function avoirListePayment() {
            $sql = "SELECT * FROM TypedePaiment";
            $query = $this->db->query($sql);
            $result = $query->result_array();
            return $result;
        }

        public function avoirLivraison() {
            $sql = "SELECT * FROM Livraison";
            echo $sql;
            $query = $this->db->query($sql);
            $result = $query->result_array();
            return $result;
        }

        public function avoirQuantiteDemande($article,$idregroupement) {
            $sql = "select * from detailregroupement where idarticle=? and idregroupement= ?";
            
            $query = $this->db->query($sql,array($article, $idregroupement));
            $result = $query->result_array();
            return $result;
        }

        public function avoirDetailBonDeCommande($idbondecommande) {
            $sql = "SELECT * FROM v_bondecommande where idbondecommande = ?";
            // echo $sql;
            $query = $this->db->query($sql,array($idbondecommande));
            $result = $query->result_array();
            return $result;
        }

        public function avoirDetailRegroupement() {
            $sql = "SELECT * FROM regroupement where etat = 21";
            $query = $this->db->query($sql);
            $result = $query->result_array();
            return $result;
        }

        public function nombreEnLettres($nombre) {
            $unites = array("", "Un", "Deux", "Trois", "Quatre", "Cinq", "Six", "Sept", "Huit", "Neuf");
            $dizaines = array("", "Dix", "Vingt", "Trente", "Quarante", "Cinquante", "Soixante", "Soixante-Dix", "Quatre-Vingts", "Quatre-Vingt-Dix");
            $speciaux = array("", "Onze", "Douze", "Treize", "Quatorze", "Quinze", "Seize");

            if ($nombre < 0 || $nombre > 999999999) {
                return "Veuillez saisir un nombre entre 0 et 999999999.";
            }

            if ($nombre == 0) {
                return "Zéro";
            }

            $lettre = "";

            // Milliards
            $milliards = floor($nombre / 1000000000);
            if ($milliards > 0) {
                $lettre .= nombreEnLettres($milliards) . " Milliard";
                $nombre %= 1000000000;
                if ($nombre > 0) {
                    $lettre .= " ";
                }
            }

            // Millions
            $millions = floor($nombre / 1000000);
            if ($millions > 0) {
                $lettre .= nombreEnLettres($millions) . " Million";
                $nombre %= 1000000;
                if ($nombre > 0) {
                    $lettre .= " ";
                }
            }

            // Milliers
            $milliers = floor($nombre / 1000);
            if ($milliers > 0) {
                $lettre .= $this->nombreEnLettres($milliers) . " Mille";
                $nombre %= 1000;
                if ($nombre > 0) {
                    $lettre .= " ";
                }
            }

            // Centaines
            $centaines = floor($nombre / 100);
            if ($centaines > 0) {
                $lettre .= $unites[$centaines] . " Cent";
                $nombre %= 100;
                if ($nombre > 0) {
                    $lettre .= " ";
                }
            }

            // Dizaines
            $dizaine = floor($nombre / 10);
            $unite = $nombre % 10;

            if ($dizaine == 10) {
                // Cas spéciaux (11, 12, 13, ...)
                $lettre .= $speciaux[$unite];
            } else {
                if ($dizaine == 7 || $dizaine == 9) {
                    // Handle the special cases for 70 and 90
                    $lettre .= $dizaines[$dizaine];
                    if ($unite > 0) {
                        $lettre .= "-" . $unites[$unite];
                    }
                } else {
                    $lettre .= $dizaines[$dizaine];
                    if ($unite > 0) {
                        if ($unite == 1 && $dizaine > 1) {
                            // Add "et" for numbers like 21, 31, etc.
                            $lettre .= " et " . $unites[$unite];
                        } else {
                            $lettre .=  $unites[$unite];
                        }
                    }
                }
            }

            return $lettre;

        }

        public function GenerationBonDeCommande($date,$livraison,$paiement,$moinsDisant) {
            for($i=0;$i<count($moinsDisant);$i++) {
                $idregroupement = $moinsDisant[$i]['regroupement']->idregroupement;
                $quantiteDemandee = $moinsDisant[$i]['regroupement']->quantite;
                $reste = $quantiteDemandee;
                    $idArticle = $moinsDisant[$i]['regroupement']->idarticle;
                    
                    while($reste != 0 ) {
                        for($k=0;$k<count($moinsDisant[$i]['data']);$k++) {
                                $idbondecommande="";
                                $condition1 = "idfournisseur='".$moinsDisant[$i]['data'][$k]['fournisseur']->idfournisseur."'";
                                $bondecommande = $this->Generalisation->avoirTableSpecifique("bondecommande", "idbondecommande",$condition1);
                                if(count($bondecommande) != 0) {
                                    $idbondecommande = $bondecommande[0]->idbondecommande;  
                                    if($moinsDisant[$i]['data'][$k]['quantite'] >= $reste && $idArticle = $moinsDisant[$i]['regroupement']->idarticle) {
                                        $this->Generalisation->insertion("articlebondecommande(idbondecommande,idarticle,quantite,pu)",sprintf("('%s','%s','%s','%s')",$idbondecommande,$idArticle,$reste,$moinsDisant[$i]['data'][$k]['prixunitaire']));
                                        $reste = 0;
                                    }else {
                                        $reste -= $moinsDisant[$i]['data'][$k]['quantite'];
                                        $this->Generalisation->insertion("articlebondecommande(idbondecommande,idarticle,quantite,pu)",sprintf("('%s','%s','%s','%s')",$idbondecommande,$idArticle,$moinsDisant[$i]['data'][$k]['quantite'],$moinsDisant[$i]['data'][$k]['prixunitaire']));
                                    }
                                   
                                }else {
                                    if($moinsDisant[$i]['data'][$k]['quantite'] >= $reste && $idArticle = $moinsDisant[$i]['regroupement']->idarticle) {
                                        $this->Generalisation->insertion("bondecommande(idfournisseur,idpayement,idlivraison,delailivraison,idregroupement)", sprintf("('%s','%s','%s','%s','%s')",$moinsDisant[$i]['data'][$k]['fournisseur']->idfournisseur,$paiement,$livraison,$date,$idregroupement));  
                                        $commande = $this->Generalisation->avoirTableAutrement("bondecommande","idbondecommande","order by idbondecommande desc limit 1");
                                        $idbondecommande =$commande[0]->idbondecommande;  
                                        $this->Generalisation->insertion("articlebondecommande(idbondecommande,idarticle,quantite,pu)",sprintf("('%s','%s','%s','%s')",$idbondecommande,$idArticle,$reste,$moinsDisant[$i]['data'][$k]['prixunitaire']));
                                        $reste = 0;
                                    }else {
                                        $reste -= $moinsDisant[$i]['data'][$k]['quantite'];
                                        $this->Generalisation->insertion("bondecommande(idfournisseur,idpayement,idlivraison,delailivraison,idregroupement)", sprintf("('%s','%s','%s','%s','%s')",$moinsDisant[$i]['data'][$k]['fournisseur']->idfournisseur,$paiement,$livraison,$date,$idregroupement));
                                        $commande = $this->Generalisation->avoirTableAutrement("bondecommande","idbondecommande","order by idbondecommande desc limit 1");
                                        $idbondecommande =$commande[0]->idbondecommande;  
                                        $this->Generalisation->insertion("articlebondecommande(idbondecommande,idarticle,quantite,pu)",sprintf("('%s','%s','%s','%s')",$idbondecommande,$idArticle,$moinsDisant[$i]['data'][$k]['quantite'],$moinsDisant[$i]['data'][$k]['prixunitaire']));
                                    }
                                }
                        }      
                    }
            }
        }

    }   
?>