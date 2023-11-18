-- creation de la base de donnees
create database systemecommercial;
\c systemecommercial

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

------------------------------------ EMAIL ----------------------------------------
create sequence seqMail;
create table Mail(
    idMail varchar(20) default concat('MAIL' || nextval('seqMail')) primary key,
    dateenvoie timestamp,
    envoyeur varchar(20),
    destinataire varchar(20)
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

------------------------------------ MESSAGE --------------------------------------
create sequence seqProforma;
create table Proforma(
    idProforma varchar(20) default concat('PRO' || nextval('seqProforma')) primary key,
    idFournisseur varchar(20),
    piecejointe varchar(20),
    idbesoin varchar(20),
    foreign key (idFournisseur) references Fournisseur(idFournisseur)
);

------------------------------------ MESSAGE --------------------------------------
create sequence seqDonneeProforma;
create table DonneeProforma(
    idDonneeProforma varchar(20) default concat('DOP' || nextval('seqDonneeProforma')) primary key,
    idArticle varchar(20),
    id varchar(20),
    foreign key (idFournisseur) references Fournisseur(idFournisseur)
);