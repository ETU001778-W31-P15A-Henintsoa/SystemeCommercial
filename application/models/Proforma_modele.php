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

        public function calculMoinsDisant($idbesoin){
            $avoirDetailBesoins = $this->Generalisation->avoirTableSpecifique("detailbesoinachat", "*", sprintf("idbesoinachat='%s'", $idbesoin));
            $fournisseur = $this->Generalisation->avoirTable("fournisseur");
            
            for ($i=0; $i < count($avoirDetailBesoins); $i++) { 
                $data = array();
                for ($j=0; $j < count($fournisseur); $j++) { 
                    $data[$j]['fournisseur'] = $fournisseur[$j]; 
                    $donneeproforma = $this->Generalisation->avoirTableSpecifique("v_donneeproforma", "*", sprintf("idbesoinachat='%s' and idfournisseur='%s' and idarticle='%s'", $idbesoin, $fournisseur[$j]->idfournisseur, $avoirDetailBesoins[$i]->idarticle));
                    if(count($donneeproforma)!=0){
                        $data[$j]['donnee'] = $donneeproforma[0];
                    }
                }
                $avoirDetailBesoins[$i]['data'] = $data;
            }
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