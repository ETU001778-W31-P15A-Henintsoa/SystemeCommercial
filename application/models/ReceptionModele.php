<?php 
    if(! defined('BASEPATH')) exit('No direct script access allowed');
    class ReceptionModele extends CI_Model{
        public function verifierNombre($idReception){
            $detailReception=$this->Generalisation->avoirTableSpecifique("v_detailBonReception","*"," idbonreception='".$idReception."' order by idArticle desc");
            $detailBonCommande=$this->Generalisation->avoirTableSpecifique("v_articleBonCommande","*"," idBonDeCommande='".$detailReception[0]->idbondecommande."' order by idArticle desc");
            $articleAQuantiteanormal=array();
            $j=0;
            for ($i=0; $i <count($detailBonCommande) ; $i++) { 
                if($detailBonCommande[$i]->quantite!=$detailReception[$i]->quantite){
                    $articleAQuantiteanormal[$j]['article']=$detailReception[$i]->nomarticle;
                    $articleAQuantiteanormal[$j]['idreception']=$idReception;
                    $articleAQuantiteanormal[$j]['quantiteDemande']=$detailBonCommande[$i]->quantite;
                    $articleAQuantiteanormal[$j]['quantiteRecu']=$detailReception[$i]->quantite;
                    $articleAQuantiteanormal[$j]['fournisseur']=$detailBonCommande[$i]->idfournisseur;
                    $j++;
                }
            }
            return $articleAQuantiteanormal;
        }

        public function avoirNonValide(){
            $reception=$this->Generalisation->avoirTableSpecifique("bonreception","*"," etat=0");
            $detailReception=array();
            for ($i=0; $i <count($reception); $i++) { 
                $detailReception[$i]['reception']=$reception[$i];
                $detailReception[$i]['detail']=$this->Generalisation->avoirTableSpecifique("v_detailBonReception","*"," idbonreception='".$reception[$i]->idbonreception."'");
            }
            return $detailReception;
        }

        public function avoirDonnee($idReception){
            $articleAQuantiteanormal = $this->verifierNombre($idReception);

            $detailReception=$this->Generalisation->avoirTableSpecifique("v_detailBonReception","*"," idbonreception='".$idReception."' order by idArticle desc");

            $data = array();

            $data['reception'] = $detailReception;
            $data['anormal'] = $articleAQuantiteanormal;
            
            return $data;        
        }
    }
?>