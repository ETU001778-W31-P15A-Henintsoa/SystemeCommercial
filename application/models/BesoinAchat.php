<?php
class BesoinAchat extends CI_Model {
    //Ces Fonctions retournent des tableaux d'objet
    public function avoirAchatNonValide($iddepartement){
        $nonValide=$this->Generalisation->avoirTableSpecifique("v_besoinAchat","*","iddepartement='".$iddepartement."' and etat=0");
        $affichageNonValide=array();
        $j=0;
        for ($i=0; $i <count($nonValide) ; $i++) { 
            $affichageNonValide[$j]['besoin']=$nonValide[$i];
            $affichageNonValide[$j]['detail']=$this->Generalisation->avoirTableSpecifique("v_detailbesoinAchat","*"," idBesoinAchat='".$nonValide[$i]->idbesoinachat."' and etat=1");
            $j++;
        }
        return $affichageNonValide;
    }

    public function avoirAchatValide(){ //ny systeme commerciale no mahita aazy
        $nonValide=$this->Generalisation->avoirTableSpecifique("v_besoinAchat","*","etat=1");
        $affichageValide=array();
        $j=0;
        for ($i=0; $i <count($nonValide) ; $i++) { 
            $affichageValide[$j]['besoin']=$nonValide[$i];
            $affichageValide[$j]['detail']=$this->Generalisation->avoirTableSpecifique("v_detailbesoinAchat","*"," idBesoinAchat='".$nonValide[$i]->idbesoinachat."' and etat=1");
            $j++;
        }
        return $affichageValide;
    }

    public function miseAJourBesoinAchat($idRegroupement){ //manova ny idregroupement ao amin'ilay besoin acaht ho lasa ilay regroupement vao generena
        $this->Generalisation->miseAJour("besoinAchat","etat=11,idRegroupement='".$idRegroupement."'"," etat=1");
    }

    public function entrerRegroupement($regroupement){
        date_default_timezone_set('Africa/Nairobi');
        $date=date('Y-m-d');
        $this->Generalisation->insertion("regroupement","(default,'".$date."',1)");
        $regroupementBase=$this->Generalisation->avoirTableAutrement("regroupement","*"," order by idRegroupement desc");
        $this->miseAJourBesoinAchat($regroupementBase[0]->idregroupement);
        for ($i=0; $i <count($regroupement) ; $i++) { 
            $valeur="(default,'".$regroupement[$i]->idarticle."',".$regroupement[$i]->quantite.",'".$regroupementBase[0]->idregroupement."',1)";
            $this->Generalisation->insertion("detailregroupement",$valeur);
        }
    }

    public function avoirAchatValideNonLivre($iddepartement){ //ilay nanaovan'ilay departement 
        $nonValide=$this->Generalisation->avoirTableSpecifique("v_besoinAchat","*","iddepartement='".$iddepartement."' and etat<11 and etat>0");
        $affichageValide=array();
        $j=0;
        for ($i=0; $i <count($nonValide) ; $i++) { 
            $affichageValide[$j]['besoin']=$nonValide[$i];
            $affichageValide[$j]['detail']=$this->Generalisation->avoirTableSpecifique("v_detailbesoinAchat","*"," idBesoinAchat='".$nonValide[$i]->idbesoinachat."' and etat<11");
            $j++;
        }
        return $affichageValide;
    }
}
