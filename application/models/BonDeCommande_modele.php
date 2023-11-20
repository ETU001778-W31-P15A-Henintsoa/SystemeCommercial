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
        

        public function genererBonDeCommande($date,$livraison,$paiement, $moinsDisant) {
            date_default_timezone_set('Africa/Nairobi');
            usort($moinsDisant, function ($a, $b) {
                return $a->pu - $b->pu;
            });
            // $moinsDisant = $this->Proforma_modele->avoirMoinsDisant();
            $quantiteRestantes = 0;
        
            foreach ($moinsDisant as $article) {
                var_dump($article);
                $idArticle = $article['regroupement']->idarticle;
                $quantiteDemandee = $this->avoirQuantiteDemande($idArticle, $article['regroupement']->idregroupement); // Quantite demande par l'article
                $quantiteRestantes = $quantiteDemandee;
                $quantiteDisponible = min($article['regroupement']->quantite, $quantiteDemandee, $quantiteRestantes);
                echo "disponible ".$quantiteDisponible;
                if ($quantiteDisponible > 0) {
                    // Check if a record for the same supplier and date already exists
                    $existingRecord = $this->db->get_where('bondecommande', array(
                        'idfournisseur' => $article['data'][0]['fournisseur']->idfournisseur,
                        'datebondecommande' => date('Y-m-d') // Assuming you want to use the current date
                    ))->row();
        
                    if ($existingRecord) {
                        $idbondecommande = $existingRecord->idbondecommande;
                    } else {
                        // Insert a new record for the supplier and date
                        $data = array(
                            'idfournisseur' => $article['data'][0]['fournisseur']->idfournisseur,
                            'delailivraison' => $date,
                            'idpayement' => $paiement,
                            'idlivraison' => $livraison,
                            'datebondecommande' => date('Y-m-d')
                        );
                        // $idbondecommande = $this->insertionBonDeCommande("bondecommande", $data);
                        $idbondecommande = $this->Generalisation->insertion("bondecommande(idfournisseur,delailivraison,idpayement,idlivraison)", sprintf("('%s', '%s', '%s', '%s')",$article['data'][0]['fournisseur']->idfournisseur,$date,$paiement,$livraison ));
                    }
        
                    echo "commande " . $idbondecommande;
        
                    // Insert into ArticleBonDeCommande
                    $this->Generalisation->insertion(
                        "ArticleBonDeCommande(idbondecommande,idArticle,quantite,pu)",
                        sprintf("('%s','%s','%s','%s')", $idbondecommande, $idArticle, $quantiteDisponible, $article['data'][0]['prixunitaire'])
                    );
        
                    $quantiteRestantes[$idArticle] -= $quantiteDisponible;
                }
        
                $quantiteRestante = array_sum($quantiteRestantes);
                if ($quantiteRestante == 0) {
                    break;
                }
            }
        }
        
        
        public function avoirListeBonDeCommandeNonValide() {
            $sql = "SELECT * FROM bondecommande where etat = 0";
            $query = $this->db->query($sql);
            $result = $query->result_array();
            return $result;
        }

        public function avoirListeBonDeCommandeValide() {
            $sql = "SELECT * FROM bondecommande where etat = 1";
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
            $sql = "SELECT * FROM v_detailregroupement where etat = 21";
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

            if ($dizaine == 1) {
                // Cas spéciaux (11, 12, 13, ...)
                $lettre .= $speciaux[$unite];
            } else {
                $lettre .= $dizaines[$dizaine];
                if ($unite > 0) {
                    $lettre .= "-" . $unites[$unite];
                }
            }

            return $lettre;
        }

    }
    
?>