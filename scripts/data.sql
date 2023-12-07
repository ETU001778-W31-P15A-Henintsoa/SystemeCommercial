---------------------------------employe------------------------------------------------------
INSERT INTO Employe (nom, prenom, adresse, matricule, dateNaissance, mail, motDePasse, etat)
VALUES
  ('Doe', 'John', '123 Rue de la Paix', 'MAT123', '1990-05-15', 'john.doe@email.com', 'motdepasse123', 1),
  ('Smith', 'Jane', '456 Avenue des Fleurs', 'MAT456', '1985-08-22', 'jane.smith@email.com', 'mdp456', 1),
  ('Johnson', 'Robert', '789 Rue du Paradis', 'MAT789', '1982-03-10', 'robert.johnson@email.com', '123abc', 1);

  ----------------------------------------------departement-------------------------------------------------
INSERT INTO Departement (nomDepartement)
VALUES
    ('Ressources Humaines'),
    ('Informatique'),
    ('Systeme commercial'),
    ('Finance' );

-----------------------------------------------Branche----------------------------------------------------------
INSERT INTO Branche (nomBranche,salaireMax, salaireMin, njHParPersonne, mission, descriptionPoste)
VALUES
    ('Chef de projet',50000.00, 30000.00, 8.0, 'Gestion des projets', 'Chef de projet responsable de la gestion des projets.'),
    ('Developpeur',60000.00, 35000.00, 7.5, 'Développement logiciel', 'Ingénieur logiciel spécialisé dans le développement Java.'),
    ('Comptable',70000.00, 40000.00, 8.5, 'Finance et comptabilité', 'Analyste financier responsable de lanalyse des états financiers.'),
    ('Responsable commerciale',55000.00, 32000.00, 8.0, 'Système Commercial', 'Responsable des ventes spécialisé dans le système commercial.');

------------------------------------------Branche departement------------------------------------------------
insert into brancheDepartement(idBranche,idDepartement) values
('BRA1','DEPT2'),
('BRA2','DEPT2'),
('BRA3','DEPT4'),
('BRA4','DEPT3');

--------------------------------------Poste EMploye-----------------------------------------------------------
insert into employePoste(idBrancheDepartement,dateEmbauche,idEmploye) values
('BDEPT3','2020-02-04','EMP1'),
('BDEPT4','2019-06-12','EMP2'),
('BDEPT3','2020-02-04','EMP3');


----------------------------------type article---------------------------------------------------------
insert into typeArticle(libelle) values
('fourniture de bureau'),
('materielle informatique');


---------------------------------------article---------------------------------------------------
INSERT INTO Article (nomArticle, idTypeArticle)
VALUES
    ('Stylo', 'TART1'),
    ('Cahier', 'TART1'),
    ('Classeur', 'TART1'),
    ('Ordinateur portable', 'TART2'),
    ('Souris sans fil', 'TART2'),
    ('Imprimante laser', 'TART2');


---------------------------------validation--------------------------------------------------
insert into validation(idBrancheDepartement,libelle) values
('BDEPT1','achat'),
('BDEPT3','premier validation bon acahat');

-- Henintsoa 18 Novembre 21:21
------------------------------------ VILLE ---------------------------------------
insert into Ville(nomVille) values
 ('Antananarivo'),
 ('Antsirable');

------------------------------------ Entreprise ---------------------------------------
insert into entreprise(nomEntreprise, adresse, numerofax, contact, idVille) values
('DIMPEX', 'Lot 12 II BIS Andoharanofotsy', '00499221/709-338', '+261 332178522', 'VILLE1');


------------------------------------ FOURNISSEUR ---------------------------------
insert into Fournisseur(nomFournisseur, email, motdepasse, adresse, idVille) values 
('SHOPRITE', 'shoprite@gmail.com', 'shoprite', 'Lot II BIS Tanjobato', 'VILLE1'),
('JUMBO SCORE', 'jumbo@gmail.com', 'jumbo', 'Lot III BIS Ankorondrano', 'VILLE1'),
('LEADER PRICE', 'leader@gmail.com', 'leaderprice', 'Lot VI BIS Ankorondrano', 'VILLE1');

------------------------------------ ADRESSEMAIL ------------------------------------------
insert into adresseMail(idsociete, adresseMAil, motdepasse) values
('ENT1', 'dimpex@gmail.com', 'dimpex'),
('FOU1', 'shoprite@gmail.com', 'shoprite'),
('FOU2', 'jumbo@gmail.com', 'jumbo'),
('FOU3', 'leader@gmail.com', 'leader');


--------------------------------------Fiderana 19-11-23 13:07-------------------------------------------
update employePoste set idBrancheDepartement='BDEPT1' where idemployePoste='EPOST3';
update validation set libelle='premier validation bon achat' where idValidation='VAL2';

--------------------------------------Santatra 20-11-23 14:13-------------------------------------------
insert into TypedePaiment(libelle) values('virement bancaire'),('cheque');
insert into Livraison(libelle) values('non partielle'),('partielle');



------------------------------------- Henintsoa November 22--------------------------------------------

-----------------------------------------------Branche----------------------------------------------------------
INSERT INTO Branche (nomBranche,salaireMax, salaireMin, njHParPersonne, mission, descriptionPoste)
VALUES
('Directeur de Service Finance',550000.00, 320000.00, 8.0, 'Gestion du departement de Finance', 'Assure le bon fonctionnement des activites dans le departement Finance.');

------------------------------------- Branche Departement ------------------------------------------------------
insert into brancheDepartement(idBranche,idDepartement) values
('BRA5','DEPT4');

---------------------------------employe------------------------------------------------------
INSERT INTO Employe (nom, prenom, adresse, matricule, dateNaissance, mail, motDePasse, etat)
VALUES
  ('Lova', 'Henintsoa', 'GVAS 8 Soama', 'MAT145521', '2001-12-11', 'henintsoa@gmail.com', 'henintsoa', 1);

---------------------------------validation--------------------------------------------------
insert into validation(idBrancheDepartement,libelle) values
('BDEPT5','achat'),
('BDEPT4','achat');

--------------------------------------Poste EMploye-----------------------------------------------------------
insert into employePoste(idBrancheDepartement,dateEmbauche,idEmploye) values
('BDEPT5','2020-02-04','EMP4');


-- -----------------------------------
INSERT INTO Employe (nom, prenom, adresse, matricule, dateNaissance, mail, motDePasse, etat)
VALUES
  ('Koto', 'Ny Aina', '123 Rue de la Paix', 'MAT1234', '2000-05-15', 'koto@email.com', 'motdepasse1234', 1);

INSERT INTO Departement (nomDepartement)
VALUES
    ('hors departement');

INSERT INTO Branche (nomBranche,salaireMax, salaireMin, njHParPersonne)
VALUES
    ('Directeur Generale',2000000.00, 5000000.00, 8.0);

insert into brancheDepartement(idBranche,idDepartement) values
('BRA5','DEPT5');

insert into employePoste(idBrancheDepartement,dateEmbauche,idEmploye) values
('BDEPT5','2020-02-04','EMP5');

insert into validation(idBrancheDepartement,libelle)
values('BDEPT5','Directeur General');


------------------------------------ ADRESSEMAIL ------------------------------------------
insert into adresseMail(idsociete, adresseMAil, motdepasse) values
('DEPT1', 'rhumaine@gmail.com', 'rhumaine'),
('DEPT2', 'informatique@gmail.com', 'info'),
('DEPT3', 'scommecial@gmail.com', 'scom'),
('DEPT4', 'finance@gmail.com', 'finance');
('DEPT5', 'hors@gmail.com', 'hors');


---------------------------------------------Fiderana 05-12-23---------------------------------------------------
  ----------------------------------------------departement-------------------------------------------------
INSERT INTO Departement (nomDepartement)
VALUES
    ('logistique');

INSERT INTO Employe (nom, prenom, adresse, matricule, dateNaissance, mail, motDePasse, etat)
VALUES
  ('Mayette', 'Johnson', '123 Rue de la Sarbone', 'MAT12345', '1990-05-15', 'johnson.doe@email.com', 'mdp123', 1);

-----------------------------------------------Branche----------------------------------------------------------
INSERT INTO Branche (nomBranche,salaireMax, salaireMin, njHParPersonne, mission, descriptionPoste)
VALUES
    ('Magasinier',50000.00, 30000.00, 8.0, 'Reponsable des stocks de produits', 'Gestion de sortie et entré des stocks');

-----------------------------------------------BrancheDepartement-------------------------------------------------
insert into brancheDepartement(idBranche,idDepartement) values
('BRA7','DEPT6');

--------------------------------------Poste EMploye-----------------------------------------------------------
insert into employePoste(idBrancheDepartement,dateEmbauche,idEmploye) values
('BDEPT6','2023-02-04','EMP6');

--------------------------------------Validation-----------------------------------------------------------
insert into validation(idBrancheDepartement,libelle) values
('BDEPT6','validation entre');

update validation set libelle='validation entre' where idbranchedepartement='BDEPT6';  
