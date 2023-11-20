<?php 
    if(! defined('BASEPATH')) exit('No direct script access allowed');
    class Proforma_modele extends CI_Model{
        public function insertionReponseProforma($idfournisseur, $pj, $idbesoin){
            $this->Generalisation->insertion("proforma(idfournisseur, piecejointe, idbesoinachat)", sprintf("('%s', '%s', '%s')", $idfournisseur, $pj, $idbesoin));
            $proforma =  $this->Generalisation->avoirTableConditionnee("proforma order by idproforma");
            return $proforma[count($proforma)];
        }   
        
        public function insertionProforma($idproforma, $idarticle, $quantite, $prixTTC, $TVA, $livraison){
            if($TVA!=null){
                $tva=true;
            }

            if($livraison!=null){
                $livraison=true;
            }

            $this->Generalisation->insertion("donneeproforma(idproforma, idarticle, quantite, prixunitaire, tva, livraisonpartielle)", sprintf("('%s', '%s', %s, %s, %s, %s)", $idproforma, $idarticle, $quantite, $prixTTC, $TVA, $livraison));
        }

        public function avoirFournisseurArticle($idregroupement){
            $avoirDetailBesoins = $this->Generalisation->avoirTableSpecifique("regroupement", "*", sprintf("idregroupement='%s'", $idregroupement));
            $fournisseur = $this->Generalisation->avoirTable("fournisseur");
            $donnee = array();            

            for ($i=0; $i < count($avoirDetailBesoins); $i++) { 
                $donnee[$i]['regroupement'] = $avoirDetailBesoins[$i];
                $data = array();
                for ($j=0; $j < count($fournisseur); $j++) { 
                    $data[$j]['fournisseur'] = $fournisseur[$j]; 
                    $donneeproforma = $this->Generalisation->avoirTableSpecifique("v_donneeproforma", "*", sprintf("idregroupement='%s' and idfournisseur='%s' and idarticle='%s'", $idregroupement, $fournisseur[$j]->idfournisseur, $avoirDetailBesoins[$i]->idarticle));
                    if(count($donneeproforma)!=0){
                        $data[$j]['prixunitaire'] = ($donneeproforma[0]->prixunitaire);
                        $data[$j]['quantite'] = ($donneeproforma[0]->prixunitaire);
                    }
                }
                // $avoirDetailBesoins[$i]['data'] = $data;
                $donnee[$i]['data'] = $data;
            }
            return $avoirDetailBesoins;
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

        public function avoirMoinsDisant($idregroupement){
            // $detailBesoin = $this->avoirFournisseurArticle($idregroupement);
            $detailBesoin =$this->data();

            // var_dump($detailBesoin);
        
            for ($i=0; $i <count($detailBesoin) ; $i++) { 
                $detail = $detailBesoin[$i];
                // var_dump($detail);
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