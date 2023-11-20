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

-- ----------------------v_bondecommande-----------------------------------
create or replace view v_BonDeCommande AS
select abdc.*,bdc.idfournisseur,bdc.DateBonDeCommande,Fournisseur.nomFournisseur from BonDeCommande bdc
join Fournisseur on bdc.idfournisseur=Fournisseur.idfournisseur
join ArticleBonDeCommande abdc on bdc.idBonDeCommande=abdc.idBonDeCommande;