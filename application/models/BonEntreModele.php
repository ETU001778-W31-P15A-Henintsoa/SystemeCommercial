<?php 
    if(! defined('BASEPATH')) exit('No direct script access allowed');
    class BonEntreModele extends CI_Model{
        public function verifierNombre($idEntre){
            $detailEntre=$this->Generalisation->avoirTableSpecifique("v_detailBonEntre","*"," idBonEntre='".$idEntre."' order by idArticle desc");
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
    }
?>