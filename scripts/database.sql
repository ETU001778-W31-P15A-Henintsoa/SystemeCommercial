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

alter table branche add nomBranche varchar(40);

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
    etat int, --(-1 suspendu,0 non valide ni suspendu,1 valide,11 a deja eu une demande de proformat,21 achete)--
    dateInsertion date,
    foreign key(idEmploye) references employe(idEmploye),
    foreign key(idDepartement) references departement(idDepartement)
);

-----------------------------Type article---------------------------------
create sequence seqTypeArticle;
create table typeArticle(
    idTypeArticle varchar(20) default concat('TART'|| nextval('seqDetailBesoinAchat')) primary key,
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