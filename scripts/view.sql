---------------------------v_brancheDepartement--------------------------------
create or replace view v_brancheDepartement as 
    select b.*,d.*,bd.idBrancheDepartement from brancheDepartement bd
        join departement as d on d.idDepartement=bd.idDepartement
        join branche as b on b.idBranche=bd.idBranche;

-----------------------v_posteEmploye------------------------------
create or replace view v_posteEmploye as
    select e.*,ePoste.dateEmbauche,bd.* from employePoste as ePoste
        join v_brancheDepartement as bd on ePoste.idBrancheDepartement=bd.idBrancheDepartement
        join employe as e on e.idEmploye=ePoste.idEmploye;

------------------------v_posteEmployeValidation-----------------------
create or replace view v_posteEmployeValidation as 
    select pEmp.*,libelle from v_posteEmploye as pEmp
        left join validation as v on v.idBrancheDepartement=pEmp.idBrancheDepartement;


----------------------------------- V_DonneeProforma ------------------------------
create or replace view v_DonneeProforma as
    select Proforma.idProforma, Proforma.idFournisseur, Proforma.piecejointe,
    DonneeProforma.idDonneeProforma, DonneeProforma.prixUnitaire, DonneeProforma.TVA, DonneeProforma.livraisonPartielle,
    v_detailregroupementArticle.*
    from Proforma
        join DonneeProforma on DonneeProforma.idProforma = Proforma.idProforma
        join v_detailregroupementArticle on v_detailregroupementArticle.idregroupement=Proforma.idregroupement;
-------------------------Fiderana 20 novembre 2023 09h15------------------------------
--------------------------------v_besoinAchat-------------------------------------------------
create or replace view v_besoinAchat as
    select ba.*,e.nom,e.prenom,d.nomDepartement from besoinAchat ba
        join employe e on e.idEmploye=ba.idEmploye
        join departement d on d.idDepartement=ba.idDepartement;

-------------------------------------v_detailbesoinachat------------------------------------------
create or replace view v_detailbesoinachat as 
    select dba.idArticle,quantite,dba.etat as etatDetail, nomArticle,ba.* from detailBesoinAchat dba
        join article a on a.idArticle=dba.idArticle
        join v_besoinAchat as ba on ba.idBesoinAchat=dba.idBesoinAchat;


--------------------------------------v_detailregroupement--------------------------------------
create or replace view v_detailregroupement as
    select r.*,dr.quantite,dr.idArticle from regroupement r
        join detailRegroupement dr on r.idRegroupement=dr.idRegroupement;

--------------------------------------v_detailregroupement--------------------------------------
create or replace view v_detailregroupementArticle as
    select r.*,dr.quantite, Article.* from regroupement r
        join detailRegroupement dr on r.idRegroupement=dr.idRegroupement
        join article on Article.idArticle = dr.idArticle;
        
-- ----------------------v_bondecommande-----------------------------------
create or replace view v_BonDeCommande AS
select abdc.*,bdc.idfournisseur,bdc.DateBonDeCommande,Fournisseur.nomFournisseur,Livraison.libelle as livraison,TypedePaiment.libelle as paiement from BonDeCommande bdc
join Fournisseur on bdc.idfournisseur=Fournisseur.idfournisseur
join ArticleBonDeCommande abdc on bdc.idBonDeCommande=abdc.idBonDeCommande
join Livraison on bdc.idLivraison = Livraison.idLivraison
join TypedePaiment on bdc.idpayement = TypedePaiment.idTypeDePayement;


