<?php 
    if(! defined('BASEPATH')) exit('No direct script access allowed');
    date_default_timezone_set('Africa/Nairobi'); 
    class BonEntreModele extends CI_Model{
        public function verifierNombre($idEntre){
            $detailEntre=$this->Generalisation->avoirTableSpecifique("v_detailBonEntre","*"," idBonEntre='".$idEntre."' order by idArticle desc");
            // var_dump($detailEntre);
            $detailReception=$this->Generalisation->avoirTableSpecifique("v_detailBonReception","*"," idBonReception='".$detailEntre[0]->idbonreception."' order by idArticle desc");
            $articleAQuantiteanormal=array();
            $j=0;
            for ($i=0; $i <count($detailReception) ; $i++) {
                if($detailReception[$i]->quantite!=$detailEntre[$i]->quantite){
                    $articleAQuantiteanormal[$j]['article']=$detailEntre[$i]->nomarticle;
                    $articleAQuantiteanormal[$j]['quantiteDemande']=$detailReception[$i]->quantite;
                    $articleAQuantiteanormal[$j]['quantiteRecu']=$detailEntre[$i]->quantite;
                    $articleAQuantiteanormal[$j]['idbonentre']=$detailEntre[$i]->idbonentre;
                    $j++;
                }
            }
            return $articleAQuantiteanormal;
        }

        public function avoirNonValide(){
            $entre=$this->Generalisation->avoirTableSpecifique("bonentre","*"," etat=0");
            $detailentre=array();
            for ($i=0; $i <count($entre); $i++) { 
                $detailentre[$i]['entre']=$entre[$i];
                $detailentre[$i]['detail']=$this->Generalisation->avoirTableSpecifique("v_detailBonEntre","*"," idbonentre='".$entre[$i]->idbonentre."'");
            }
            return $detailentre;
        }

        public function avoirEntreSpecifique($identre){
            return $this->Generalisation->avoirTableSpecifique("v_detailBonEntre","*"," idbonentre='".$identre."'");
        }

        public function insertionStock($identre){
            $detailEntre=$this->avoirEntreSpecifique($identre);
            for ($i=0; $i <count($detailEntre) ; $i++) { 
                 // echo "yess";
                $stock=$this->Generalisation->avoirTableSpecifique("stock","*"," idarticle='".$detailEntre[$i]->idarticle."'");
                if(count($stock)==0){
                    $valeur="(default,'".$detailEntre[$i]->dateentre."','".$detailEntre[$i]->idarticle."',".$detailEntre[$i]->quantite.")";
                    $this->Generalisation->insertion("stock",$valeur);
                }else{
                    $quantite=$detailEntre[$i]->quantite+$stock[0]->quantite;
                    $this->Generalisation->miseAJour("stock"," quantite=".$quantite," idarticle='".$detailEntre[$i]->idarticle."'");
                }
                $valeur="(default,'".$detailEntre[$i]->dateentre."','".$detailEntre[$i]->idarticle."',".$detailEntre[$i]->quantite.",1)";
                $this->Generalisation->insertion("historique",$valeur);
            }
        }

        public function avoirDonnee($idEntre){
            $articleAQuantiteanormal = $this->verifierNombre($idEntre);
            $detailEntre=$this->Generalisation->avoirTableSpecifique("v_detailBonEntre","*"," idBonEntre='".$idEntre."' order by idArticle desc");

            $data = array();

            $data['entree'] = $detailEntre;
            $data['anormal'] = $articleAQuantiteanormal;
            
            return $data;        
        }
    }
?>