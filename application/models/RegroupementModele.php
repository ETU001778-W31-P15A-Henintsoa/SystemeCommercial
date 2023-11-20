<?php
class RegroupementModele extends CI_Model {
    public function avoirDetailRegroupementDepartement($idArticle,$idregroupement){
        $data['regroupement'] = $this->Generalisation->avoirTableSpecifique("v_detailregroupement","*"," etat<=41");
        $detailBesoinAchat=$this->Generalisation->avoirTableSpecifique("v_detailBesoinAchat","*"," idArticle='".$idArticle."' and idregroupement='".$idregroupement."'");
        return $detailBesoinAchat;
    }

    public function avoirDetailRegroupement(){
        $regroup = $this->Generalisation->avoirTableSpecifique("regroupement","*"," etat<=41");
        $regroupement=array();
        $j=0;
        for ($i=0; $i <count($regroup) ; $i++) { 
            $regroupement[$j]["regroupement"]=$regroup[$i];
            $regroupement[$j]["detail"]= $this->Generalisation->avoirTableSpecifique("v_detailRegroupementArticle","*"," idRegroupement='".$regroup[$i]->idregroupement."'");
            $j++;
        }
        return $regroupement;
    }
}
