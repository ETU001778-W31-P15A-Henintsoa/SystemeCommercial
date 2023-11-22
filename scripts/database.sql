-- creation de la base de donnees
create database systemecommercial;
\c systemecommercial

------------------------------------Employe-----------------------------------------------
create sequence seqEmploye;
create table employe(
    idEmploye varchar(20) default concat('EMP'|| nextval('seqEmploye')) primary key,
    nom varchar(50),
    prenom varchar(50),
    adresse varchar(30),
    matricule varchar(20),
    dateNaissance date,
    mail varchar(50),
    motDePasse varchar(50),
    etat int-------(0 efa tsy miasa intsony, 1 mbola miasa tsara)-----
);
------------------------------------Departement-----------------------------------------------
create sequence seqDepartement;
create table departement(
    idDepartement varchar(20) default concat('DEPT'|| nextval('seqDepartement')) primary key,
    nomDepartement varchar(50)
);

------------------------------------------Branche------------------------------------------
create sequence seqBranche;
create table branche(
    idBranche varchar(20) default concat('BRA'|| nextval('seqBranche')) primary key,
    salaireMax float,
    salaireMin float,
    njHParPersonne float,
    mission text,
    descriptionPoste text
);

--------------------------------Branche Departement--------------------------------------------
create sequence seqBrancheDepartement;
create table brancheDepartement(
    idBrancheDepartement varchar(20) default concat('BDEPT'|| nextval('seqBrancheDepartement')) primary key,
    idBranche varchar(20),
    idDepartement varchar(20),
    foreign key(idBranche) references branche(idBranche),
    foreign key(idDepartement) references departement(idDepartement)
);

------------------------------------EmployePoste--------------------------------------------
create sequence seqEmployePoste;
create table employePoste(
    idEmployePoste varchar(20) default concat('EPOST'|| nextval('seqEmployePoste')) primary key,
    idBrancheDepartement varchar(20),
    dateEmbauche date,
    idEmploye varchar(20),
    foreign key(idEmploye) references employe(idEmploye),
    foreign key(idBrancheDepartement) references brancheDepartement(idBrancheDepartement)
);

---------------------------------Besoin Achat---------------------------------------------
create sequence seqBesoinAchat;
create table besoinAchat(
    idBesoinAchat varchar(20) default concat('BAchat'|| nextval('seqBesoinAchat')) primary key,
    idDepartement varchar(20),
    dateBesoin date,
    idEmploye varchar(20),
    etat int, --(-1 suspendu,0 non valide ni suspendu,1 valide,11 deja regroupe)--
    dateInsertion date,
    foreign key(idEmploye) references employe(idEmploye),
    foreign key(idDepartement) references departement(idDepartement)
);

-----------------------------Type article---------------------------------
create sequence seqTypeArticle;
create table typeArticle(
    idTypeArticle varchar(20) default concat('TART'|| nextval('seqTypeArticle')) primary key,
    libelle varchar(50)
);

---------------------------------Article----------------------------------------
create sequence seqArticle;
create table article(
    idArticle varchar(20) default concat('ART'|| nextval('seqArticle')) primary key,
    nomArticle varchar(50),
    idTypeArticle varchar(20),
    foreign key(idTypeArticle) references typeArticle(idTypeArticle)
);

---------------------------------------Detail besoin-----------------------------------------
create sequence seqDetailBesoinAchat;
create table detailBesoinAchat(
    idDetailBesoinAchat varchar(20) default concat('DETBes'|| nextval('seqDetailBesoinAchat')) primary key,
    idArticle varchar(20),
    quantite float,
    idBesoinAchat varchar(20),
    etat int,-------1 non efface 0 efface du besoin ------
    foreign key(idArticle) references article(idArticle),
    foreign key(idBesoinAchat) references besoinAchat(idBesoinAchat)
);

------------------------------------Validation--------------------------------------------
create sequence seqValidation;
create table validation(
    idValidation varchar(20) default concat('VAL'|| nextval('seqValidation')) primary key,
    idBrancheDepartement varchar(20),
    libelle varchar(40),
    foreign key(idBrancheDepartement) references brancheDepartement(idBrancheDepartement)
);

-- Henintsoa 18 Novembre 21:21
------------------------------------ VILLE ---------------------------------------
create sequence seqVille;
create table Ville(
    idVille varchar(20) default concat('VILLE' || nextval('seqVille')) primary key,
    nomVille varchar(30) -- Nom de la ville
);

------------------------------------ ENTREPRISE ---------------------------------------
create sequence seqEntreprise;
create table Entreprise(
    idEntreprise varchar(20) default concat('ENT' || nextval('seqEntreprise')) primary key,
    nomEntreprise varchar(20),
    adresse varchar(50),
    numerofax varchar(20),
    contact varchar(15),
    idVille varchar(20),
    foreign key (idVille) references  Ville(idVille)
);

------------------------------------ FOURNISSEUR ---------------------------------
create sequence seqFournisseur;
create table Fournisseur(
    idFournisseur varchar(20) default concat('FOU' || nextval('seqFournisseur')) primary key,
    nomFournisseur varchar(30), -- Nom de la societe
    email varchar(20),
    motdepasse varchar(20),
    adresse varchar(50),
    idVille varchar(20),
    foreign key (idVille) references Ville(idVille)
);

------------------------------------ ADRESSE MAIL ----------------------------------------
create sequence seqAdresseMail;
create table AdresseMail(
    idAdresseMail varchar(20) default concat('ADM' || nextval('seqAdresseMail')) primary key,
    idSociete varchar(20),
    adresseMAil varchar(50),
    motdepasse varchar(10)
);

------------------------------------ EMAIL ----------------------------------------
create sequence seqMail;
create table Mail(
    idMail varchar(20) default concat('MAIL' || nextval('seqMail')) primary key,
    dateenvoie timestamp,
    envoyeur varchar(20),
    destinataire varchar(20),
    foreign key (envoyeur) references AdresseMail(idAdresseMail),
    foreign key (destinataire) references AdresseMail(idAdresseMail)
);

------------------------------------ MESSAGE --------------------------------------
create sequence seqMessage;
create table Message(
    idMessage varchar(20) default concat('MESS' || nextval('seqMessage')) primary key,
    idMail varchar(20),
    libelle text,
    piecejointe varchar(20),
    foreign key (idMail) references Mail(idMail)
);

------------------------------------ PROFORMA --------------------------------------
create sequence seqProforma;
create table Proforma(
    idProforma varchar(20) default concat('PRO' || nextval('seqProforma')) primary key,
    idFournisseur varchar(20),
    piecejointe varchar(20),
    idRegroupement varchar(20),
    foreign key (idFournisseur) references Fournisseur(idFournisseur),
    foreign key (idregroupement) references Regroupement(idRegroupement)
);

------------------------------------ DONNEE PROFORMA -------------------------------------
create sequence seqDonneeProforma;
create table DonneeProforma(
    idDonneeProforma varchar(20) default concat('DOP' || nextval('seqDonneeProforma')) primary key,
    idProforma varchar(20),
    idArticle varchar(20),
    quantite float,
    prixUnitaire float,
    TVA boolean,
    livraisonPartielle boolean,
    foreign key (idProforma) references Proforma(idProforma)
);

-- ----------------------Santatra 20 nov 2023 14:10-------------------------------
create sequence seqPayement;
create table TypedePaiment(
    idTypeDePayement varchar(20) default concat('PAY' || nextval('seqPayement')) primary key,
    libelle varchar(50)
);

create sequence seqLivraison;
create table Livraison(
    idLivraison varchar(20) default concat('LIV' || nextval('seqLivraison')) primary key,
    libelle varchar(50)
);

-- ------------------Santatra 20/11/2023 BON DE COMMANDE -----------------------------------

create sequence seqBonDeCommande;
create table BonDeCommande(
    idBonDeCommande varchar(20) default concat('COM' || nextval('seqBonDeCommande')) primary key,
    idFournisseur varchar(20),
    DateBonDeCommande date default current_date,
    etat int default 0, --(0 non valide ni suspendu,11 valide)-
    idPayement varchar(20),
    idLivraison varchar(20),
    delailivraison date,
    idregroupement varchar(20),
    foreign key (idFournisseur) references Fournisseur(idFournisseur),
    foreign key (idPayement) references TypedePaiment(idTypeDePayement),
    foreign key (idLivraison) references Livraison(idLivraison),
    foreign key(idregroupement) references Regroupement(idRegroupement)
);

create sequence seqArtCommande;
create table ArticleBonDeCommande(
    idArticleBonDeCommande varchar(20) default concat('ACOM' || nextval('seqArtCommande')) primary key,
    idBonDeCommande varchar(20),
    idArticle varchar(20),
    quantite float,
    pu float,
    foreign key (idArticle) references Article(idArticle),
    foreign key(idBonDeCommande) references BonDeCommande(idBonDeCommande)
);
--------------------------- ALTER

alter table branche add nomBranche varchar(40);

-------------------------Fiderana 20 novembre 2023 09h------------------------------
-----------------------------------------regroupement---------------------------------------------
create sequence seqregroupement;
create table regroupement(
    idRegroupement varchar(20) default concat('REG' || nextval('seqregroupement')) primary key,
    dateRegroupement date
);


----------------------------------------detailRegroupement------------------------------------------
create sequence seqdetailregroupement;
create table detailregroupement(
    idDetailRegroupement varchar(20) default concat('DREG' || nextval('seqdetailregroupement')) primary key,
    idArticle varchar(20),
    quantite float,
    idRegroupement varchar(20),
    foreign key(idArticle) references article(idArticle),
    foreign key(idRegroupement) references regroupement(idRegroupement)
);


------------------------------------------alter besoinAchat-------------------------------------------------------
alter table besoinAchat add idRegroupement varchar(20), add constraint idregroup foreign key(idRegroupement) references regroupement(idRegroupement);
alter table regroupement add etat int; -------(1 rehefa vaao regroupe, 11 rehefa vita demande proforma)---------------


------------------------------------------alter besoinAchat-------------------------------------------------------
alter table besoinAchat add idRegroupement varchar(20), add constraint idregroup foreign key(idRegroupement) references regroupement(idRegroupement);
alter table regroupement add etat int; -------(1 rehefa vaao regroupe, 11 rehefa vita demande proforma)---------------


-- ----------------------------------------alter bon de commande------------------------------------------------
alter table BonDeCommande add delailivraison date;
alter table BonDeCommande add idregroupement varchar(20),add constraint idreg foreign key(idregroupement) references regroupement(idregroupement);