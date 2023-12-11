<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Africa/Nairobi'); // Remplacez 'Africa/Nairobi' par le fuseau horaire approprié


    class BonSortiModele extends CI_Model {
        public function avoirSortiNonValideDept(){
            $sortie=$this->Generalisation->avoirTableSpecifique("v_bonSortie","*"," etat=0");
            $detailsortie=array();
            for ($i=0; $i <count($sortie); $i++) { 
                $detailsortie[$i]['sorti']=$sortie[$i];
                $detailsortie[$i]['detail']=$this->Generalisation->avoirTableSpecifique("v_detailBonsortieDept","*"," idbonsortie='".$sortie[$i]->idbonsortie."'");
            }
            return $detailsortie;
        }

        public function avoirSortiValideDept(){
            $sortie=$this->Generalisation->avoirTableSpecifique("v_bonSortie","*"," etat=11");
            $detailsortie=array();
            for ($i=0; $i <count($sortie); $i++) { 
                $detailsortie[$i]['sorti']=$sortie[$i];
                $detailsortie[$i]['detail']=$this->Generalisation->avoirTableSpecifique("v_detailBonsortieDept","*"," idbonsortie='".$sortie[$i]->idbonsortie."'");
            }
            return $detailsortie;
        }

        public function avoirSortiValideDeptUnitaire($iddepartement, $idsortie){
            $sortie=$this->Generalisation->avoirTableSpecifique("v_bonSortie","*", sprintf(" iddepartement='%s' and idbonsortie='%s' and etat=11", $iddepartement, $idsortie));
            $detailsortie=array();
            for ($i=0; $i <count($sortie); $i++) { 
                $detailsortie[$i]['sorti']=$sortie[$i];
                $detailsortie[$i]['detail']=$this->Generalisation->avoirTableSpecifique("v_detailBonsortieDept","*"," idbonsortie='".$sortie[$i]->idbonsortie."'");
            }
            return $detailsortie;
        }

        public function avoirdetailSortiSpecifique($idSorti){
            $sortie=$this->Generalisation->avoirTableSpecifique("bonsortie","*"," idbonsortie='".$idSorti."'");
            $detailsortie=array();
            for ($i=0; $i <count($sortie); $i++) { 
                $detailsortie[$i]['sorti']=$sortie[$i];
                $detailsortie[$i]['detail']=$this->Generalisation->avoirTableSpecifique("v_detailBonsortieDept","*","  idbonsortie='".$sortie[$i]->idbonsortie."'");
            }
            return $detailsortie;
        }

        public function misAJourStockParProduit($sorti,$idbonsorti){//ilau sorti eto dia ny 
            $valeurHistorique="(default,'".$sorti->datesortie."','".$sorti->idarticle."',".$sorti->quantite.",-1)";
            $this->Generalisation->insertion("historique",$valeurHistorique);
            $stock=$this->Generalisation->avoirTableSpecifique("v_stockArticle","*"," idArticle='".$sorti->idarticle."'");
            $valeur=$stock[0]->quantite-$sorti->quantite;
            $valeurStock="quantite=".$valeur;
            $this->Generalisation->miseAJour("stock",$valeurStock," idarticle='".$sorti->idarticle."'");
            $this->Generalisation->miseAJour("bonsortie"," etat=11"," idbonsortie='".$idbonsorti."'");
        }

        public function misAJourStock($sorti){
            for ($i=0; $i <count($sorti[0]['detail']) ; $i++) { 
                $this->misAJourStockParProduit($sorti[0]['detail'][$i],$sorti[0]['sorti']->idbonsortie);
            }
        }
        public function verifierStock($sorti){
           // $sorti=$this->avoirdetailSortiSpecifique($idSorti);
           $quantiteinsu=array();
           $j=0;
            for ($i=0; $i <count($sorti[0]['detail']) ; $i++) { 
                $stock=$this->Generalisation->avoirTableSpecifique("v_stockArticle","*"," idArticle='".$sorti[0]['detail'][$i]->idarticle."'");
                if( $stock[0]->quantite<$sorti[0]['detail'][$i]->quantite){
                    $quantiteinsu[$j]['article']=$stock[0]->nomarticle;
                    $quantiteinsu[$j]['quantitedemande']=$sorti[0]['detail'][$i]->quantite;
                    $quantiteinsu[$j]['quantiteStock']=$stock[0]->quantite;
                    $j++;
                }
            }
            return $quantiteinsu;
        }

        public function verifierSortie($sorti,$besoindepartement){//mijery sao ny quntite avoaka mihoatra noho ny nagatahanna koa hoe tsy nanao demande an'ilay article mihitsy ikay departement
            $quantiteSup=array();
            $j=0;
            for ($i=0; $i <count($sorti[0]['detail']) ; $i++) { 
                $besoinspecifique=$this->BesoinAchat->avoirBesoinSpecifique($sorti[0]['detail'][$i]->idarticle,$besoindepartement);
                if($besoinspecifique!=null){
                    if($besoinspecifique->quantite<$sorti[0]['detail'][$i]->quantite){
                        $quantiteSup[$j]["quantiteSorti"]=$besoinspecifique->quantite;
                        $quantiteSup[$j]["quantiteDemande"]=$sorti[0]['detail'][$i]->quantite;
                        $quantiteSup[$j]["article"]=$besoinspecifique->nomarticle;
                        $j++;
                    }
                }else{
                    $quantiteSup[$j]["quantiteSorti"]=$besoinspecifique->quantite;
                    $quantiteSup[$j]["quantiteDemande"]=0;
                    $quantiteSup[$j]["article"]=$sorti[0]['detail'][$i]->nomarticle;
                    $j++;
                }
            }
            return $quantiteSup;
        }


        public function avoirDonnee($iddepartement, $idbonsorti){
            $articleAQuantite= $this->avoirSortiValideDeptUnitaire($iddepartement, $idbonsorti);
            $data = array();
            $data['articles'] = $articleAQuantite;
            return $data;
        }
        
    }
?>