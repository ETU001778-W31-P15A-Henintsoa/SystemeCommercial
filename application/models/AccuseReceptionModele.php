<?php 
    if(! defined('BASEPATH')) exit('No direct script access allowed');
    class AccuseReceptionModele extends CI_Model{
        public function verifierNombre($idaccuse){
            $detailaccuse=$this->Generalisation->avoirTableSpecifique("v_detailaccusereception","*"," idaccusereception='".$idaccuse."' order by idArticle desc");
            $detailsortie=$this->Generalisation->avoirTableSpecifique("v_detailBonsortieDept","*"," idbonsortie='".$detailaccuse[0]->idbonsortie."' order by idArticle desc");
            $articleAQuantiteanormal=array();
            $j=0;
            for ($i=0; $i <count($detailsortie) ; $i++) { 
                if($detailsortie[$i]->quantite!=$detailaccuse[$i]->quantite){
                    $articleAQuantiteanormal[$j]['article']=$detailaccuse[$i]->nomarticle;
                    $articleAQuantiteanormal[$j]['quantiteDemande']=$detailsortie[$i]->quantite;
                    $articleAQuantiteanormal[$j]['quantiteRecu']=$detailaccuse[$i]->quantite;
                    $articleAQuantiteanormal[$j]['idaccusereception']=$detailaccuse[$i]->idaccusereception;
                    $j++;
                }
            }
            return $articleAQuantiteanormal;
        }

        public function avoirNonValide($iddepartement){
            $accuse=$this->Generalisation->avoirTableSpecifique("accusereception","*"," etat=0 and iddepartement='".$iddepartement."'");
            $daccuse=array();
            for ($i=0; $i <count($accuse); $i++) { 
                $daccuse[$i]['accuse']=$accuse[$i];
                $daccuse[$i]['detail']=$this->Generalisation->avoirTableSpecifique("v_detailaccusereception","*"," idaccusereception='".$accuse[$i]->idaccusereception."'");
            }
            return $daccuse;
        } 
    }
?>