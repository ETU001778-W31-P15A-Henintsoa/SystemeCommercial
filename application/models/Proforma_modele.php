<?php 
    if(! defined('BASEPATH')) exit('No direct script access allowed');
    class Proforma_modele extends CI_Model{
        public function insertionReponseProforma($idfournisseur, $pj, $idbesoin){
            $this->Generalisation->insertion("proforma(idfournisseur, piecejointe, idregroupement)", sprintf("('%s', '%s', '%s')", $idfournisseur, $pj, $idbesoin));
            $proforma =  $this->Generalisation->avoirTableConditionnee("proforma order by idproforma");
            return $proforma[count($proforma)-1];
        }   
        
        public function insertionProforma($idproforma, $idarticle, $quantite, $prixTTC, $TVA, $livraison){
            if($TVA!=null){
                $TVA='true';
            }else{
                $TVA = 'false';
            }

            if($livraison!=null){
                $livraison='true';
            }else{
                $livraison='false';
            }

            $this->Generalisation->insertion("donneeproforma(idproforma, idarticle, quantite, prixunitaire, tva, livraisonpartielle)", sprintf("('%s', '%s', %s, %s, %s, %s)", $idproforma, $idarticle, $quantite, $prixTTC, $TVA, $livraison));
        }

        public function avoirFournisseurArticle($idregroupement){
            $avoirDetailBesoins = $this->Generalisation->avoirTableSpecifique("v_detailregroupement", "*", sprintf("idregroupement='%s'", $idregroupement));

            $fournisseur = $this->Generalisation->avoirTable("fournisseur");
            $donnee = array();           

            for ($i=0; $i < count($avoirDetailBesoins); $i++) { 
                $donnee[$i]['regroupement'] = $avoirDetailBesoins[$i];
                $data = array();
                for ($j=0; $j < count($fournisseur); $j++) { 
                    $data[$j]['fournisseur'] = $fournisseur[$j]; 
                    // var_dump($avoirDetailBesoins);
                    $donneeproforma = $this->Generalisation->avoirTableConditionnee("v_donneeproforma where idregroupement='".$idregroupement."' and idfournisseur='".$fournisseur[$j]->idfournisseur."' and idarticle='".$avoirDetailBesoins[$i]->idarticle."'");
                    if(count($donneeproforma)!=0){
                        $data[$j]['prixunitaire'] = floatval($donneeproforma[0]->prixunitaire);
                        $data[$j]['quantite'] =floatval ($donneeproforma[0]->quantite);
                    }
                }
                // $avoirDetailBesoins[$i]['data'] = $data;
                $donnee[$i]['data'] = $data;
            }
            return $donnee;
        }

        public function data(){
            $regroupement = array();
            $regroupement[0]['data'] = array();
            $regroupement[0]['data'][0]['fournisseur'] = '1';
            $regroupement[0]['data'][0]['quantite']= 10;
            $regroupement[0]['data'][0]['prixunitaire']= 500;
            $regroupement[0]['data'][1]['fournisseur'] = '2';
            $regroupement[0]['data'][1]['quantite'] = 30;
            $regroupement[0]['data'][1]['prixunitaire'] = 1400;
            $regroupement[0]['data'][2]['fournisseur'] = '3';
            $regroupement[0]['data'][2]['quantite']= 2;
            $regroupement[0]['data'][2]['prixunitaire']= 200;
            return $regroupement;
        }

        public function calculReste($quantiteNecessaire, $qf){
            $reste = $qf - $quantiteNecessaire;

            if($reste<0){
                $quantiteNecessaire = $reste * (-1);
            }else{
                $quantiteNecessaire=0;
            }
            return $quantiteNecessaire;
        }

        public function transformerEnFloat($donnees){
            foreach($donnees as $donnee){
                $donnee['regroupement']->quantite = floatval($donnee['regroupement']->quantite);
            }
            return $donnees;
        }

        public function avoirMoinsDisant($idregroupement){
            $detailBesoin = $this->avoirFournisseurArticle($idregroupement);
            $detailBesoin = $this->transformerEnFloat($detailBesoin);
            // var_dump($detailBesoin);

            // $detailBesoin =$this->data();
            // var_dump($detailBesoin);
        
            for ($i=0; $i <count($detailBesoin) ; $i++) { 
                $detail = $detailBesoin[$i];
                if(count($detail['data'])!=0){
                    // Récupérer la liste des IDs
                    $prixunitaires = array_column($detail['data'], 'prixunitaire');

                    // Trier le tableau $data en fonction de l'ID
                    array_multisort($prixunitaires, SORT_ASC, $detail['data']);

                    $detailBesoin[$i]['data'] = $detail['data'];
                }
            }
            return $detailBesoin;
        }

        public function OuAcheterQuoi($donnee){
            $a = 0;
            $ouAcheterQuoi = array();

            // var_dump($donnee);

            foreach($donnee as $donne){
                $data = $donne['data'];
                $ouAcheterQuoi[$a]['idarticle'] = $donne['regroupement']->idarticle;
                $quantiteNecessaire = 15;
                $i=0;
                while($i<count($data) && $quantiteNecessaire!=0){
                    // echo $quantiteNecessaire." avant";
                    $intermediaire = $quantiteNecessaire;
                    $quantiteNecessaire = $this->calculReste($quantiteNecessaire, $data[$i]['quantite']);
                    // echo $quantiteNecessaire." apres";
                    $ouAcheterQuoi[$a]['fournisseur'][$i][0] =  $data[$i]['fournisseur'];
                    $ouAcheterQuoi[$a]['fournisseur'][$i][1] =  $intermediaire-$quantiteNecessaire;
                    $ouAcheterQuoi[$a]['fournisseur'][$i][2] =  $data[$i]['prixunitaire'];
                    $i++;
                }
            }
            return $ouAcheterQuoi;
        }

        public function OuAcheterQuoiParFournisseur($ouAcheterQuoi){
            $fournisseurs = $this->Generalisation->avoirTable('fournisseur');
            // var_dump($ouAcheterQuoi);
            foreach($fournisseurs as $fournisseur){
                foreach($ouAcheterQuoi as $acheter){
                    // var_dump($acheter['idarticle']);
                    $i = 0;
                    $fournisseur->aacheter = array();
                    $data = array();
                    foreach($acheter['fournisseur'] as $f){
                        if($f[0]->idfournisseur == $fournisseur->idfournisseur){
                            $data['acheter'][$i]['idarticle']=$acheter['idarticle'];
                            $data['acheter'][$i]['quantite'] = $f[1];
                            $data['acheter'][$i]['prixunitaire'] = $f[2];
                        }
                        $i++;
                    }
                    $fournisseur->aacheter = $data;
                }
            }
            return $fournisseurs;
        }


        // // Exemple de tableau multidimensionnel
        // $data = array(
        //     array('id' => 1, 'name' => 'John', 'age' => 25),
        //     array('id' => 2, 'name' => 'Jane', 'age' => 30),
        //     array('id' => 3, 'name' => 'Doe', 'age' => 20)
        // );

        // // Fonction de comparaison pour trier par rapport à la colonne 'age'
        // function sortByAge($a, $b) {
        //     return $a['age'] - $b['age'];
        // }

        // // Utilisation de usort() pour trier le tableau par rapport à la colonne 'age'
        // usort($data, 'sortByAge');

        // // Affichage du tableau trié
        // print_r($data);
    }
    
?>