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
            // foreach($moinsDisant as $article) {
            //     var_dump($article);
            // }
            $quantiteRestantes = 0;
            for($i=0;$i<count($moinsDisant);$i++) {
                $idArticle = $moinsDisant[$i]['regroupement']->idarticle;
                $avoirQuantite = $this->avoirQuantiteDemande($idArticle, $moinsDisant[$i]['regroupement']->idregroupement); 
                $quantiteDemandee = $avoirQuantite[$i]['quantite'];
                $quantiteRestantes = $quantiteDemandee;
                $quantiteDisponible = min($moinsDisant[$i]['regroupement']->quantite, $quantiteDemandee, $quantiteRestantes);
                var_dump($moinsDisant[$i]);
                while($quantiteRestantes != 0 && $quantiteDisponible > 0) {
                    echo "tafiditra";
                    // $j = count($moinsDisant[$i]['data'])
                    $existingRecord = 0;
                    // echo count($moinsDisant[$i]['data']);
                    for($i=0;$i<count($moinsDisant);$i++) {
                        for ($j = 0; $j < count($moinsDisant[$i]['data']); $j++) {
                            echo count($moinsDisant[$i]['data']);
                            echo "tafiditra ato";
                            var_dump($moinsDisant[$i]['data']);
                            // echo $moinsDisant[$j]['data'][$j]['fournisseur']->idfournisseur;
                            $condition1 = "idfournisseur='".$moinsDisant[$i]['data'][$j]['fournisseur']->idfournisseur."'";
                            $existingRecord = $this->Generalisation->avoirTableSpecifique("bondecommande", "idbondecommande",$condition1);
                            $quantite_entree = 0;
                            // echo "quantite== ".$quantiteDisponibleArticleF[0];
                            $idbondecommande;
                            echo "count". count($existingRecord);
                            $condition = "idarticle='".$idArticle."' and idfournisseur='".$moinsDisant[$i]['data'][$j]['fournisseur']->idfournisseur."'";
                                $quantiteDisponibleArticleF = $this->Generalisation->avoirTableSpecifique("v_donneeproforma2","disponible",$condition); 
                                
                            if(count($existingRecord) != 0) {
                                $idbondecommande = $existingRecord[0]->idbondecommande;                
                            }else {
                                
                               

                                echo "tafiditra 2";
                                // $quantiteDisponibleArticleF = $this->Generalisation->avoirTableSpecifique("v_donneeproforma2","disponible","idarticle='%s' and idfournisseur='%s'",sprintf($idArticle,$moinsDisant[$i]['data'][$j]['fournisseur']->idfournisseur)); 
                                // var_dump($quantiteDisponibleArticleF);
                                if($quantiteDemandee >= $quantiteRestantes ) {
                                    echo "tafiditra_3";
                                    $quantite_entree = $quantiteDisponibleArticleF[0]->disponible;
                                    $quantiteRestantes = 0;
                                    $bondecommande = $this->Generalisation->insertion("bondecommande(idfournisseur,delailivraison,idpayement,idlivraison)", sprintf("('%s', '%s', '%s', '%s')",$moinsDisant[$i]['data'][$j]['fournisseur']->idfournisseur,$date,$paiement,$livraison ));
                                    // $idbondecommande = $bondecommande[0]->idbondecommande;
                                    $commande = $this->Generalisation->avoirTableAutrement("bondecommande","idbondecommande","order by idbondecommande desc limit 1");
                                    $idbondecommande =$commande[0]->idbondecommande;
                                    echo $idbondecommande;
                                    $this->Generalisation->insertion(
                                        "ArticleBonDeCommande(idbondecommande,idArticle,quantite,pu)",
                                        sprintf("('%s','%s','%s','%s')", $idbondecommande, $idArticle, $quantite_entree, $moinsDisant[$i]['data'][$j]['prixunitaire'])
                                    );

                                    
                                }else {
                                    $quantiteRestantes = $quantiteRestantes - $quantiteDemandee;
                                    
                                }
                            }
                        }   
                    }
                    }
            }
            // $quantiteRestantes = 0;
            // var_dump($moinsDisant);
            // $i=0;
            
            //
            // echo $quantiteDemandee;
            
            // echo $idArticle;
            /*foreach ($moinsDisant as $article) {
                // var_dump($article);
                $i =0 ;
                $idArticle = $article['regroupement']->idarticle;
                $avoirQuantite = $this->avoirQuantiteDemande($idArticle, $article['regroupement']->idregroupement); // Quantite demande par l'article
                $quantiteDemandee = $avoirQuantite[$i]['quantite'];
                $quantiteRestantes = $quantiteDemandee;
                $quantiteDisponible = min($article['regroupement']->quantite, $quantiteDemandee, $quantiteRestantes); 
                echo "disponible ".$quantiteDisponible;
                 
                if ($quantiteDisponible > 0) {
                    
                       
                    // Check if a record for the same supplier and date already exists
                    $existingRecord = $this->db->get_where('bondecommande', array(
                        'idfournisseur' => $article['data'][$i]['fournisseur']->idfournisseur,
                        'datebondecommande' => date('Y-m-d') // Assuming you want to use the current date
                    ))->row();
                    
                    if ($existingRecord) {
                        $idbondecommande = $existingRecord->idbondecommande;
                    } else {
                        // Insert a new record for the supplier and date
                         $this->Generalisation->insertion("bondecommande(idfournisseur,delailivraison,idpayement,idlivraison)", sprintf("('%s', '%s', '%s', '%s')",$article['data'][$i]['fournisseur']->idfournisseur,$date,$paiement,$livraison ));
                        $bondecommande = $this->Generalisation->avoirTableAutrement("bondecommande", "idbondecommande", "order by idbondecommande limit 1" );
                        // var_dump($bondecommande);
                        $idbondecommande = $bondecommande[0]->idbondecommande;
                         
                    }
        
                    echo "commande " . $idbondecommande;
        
                    // Insert into ArticleBonDeCommande
                    $this->Generalisation->insertion(
                        "ArticleBonDeCommande(idbondecommande,idArticle,quantite,pu)",
                        sprintf("('%s','%s','%s','%s')", $idbondecommande, $idArticle, $quantiteDisponible, $article['data'][0]['prixunitaire'])
                    );
        
                    $quantiteRestantes = $quantiteRestantes - $quantiteDisponible;
                    echo "quantiterestatnte== ".$quantiteRestantes;
                    $i++;
                }
        
                // $quantiteRestante = sum($quantiteRestantes);
                $quantiteRestante = 0;
                $quantiteRestante = $quantiteRestante + $quantiteRestantes; 
                if ($quantiteRestante == 0) {
                    break;
                }
            }*/
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