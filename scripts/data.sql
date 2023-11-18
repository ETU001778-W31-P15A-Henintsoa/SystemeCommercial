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

------------------------------------ FOURNISSEUR ---------------------------------
insert into Fournisseur(nomFournisseur, email, motdepasse, adresse, idVille) values 
('SHOPRITE', 'shoprite@gmail.com', 'shoprite', 'Lot II BIS Tanjobato', 'VILLE1'),
('JUMBO SCORE', 'jumbo@gmail.com', 'jumbo', 'Lot III BIS Ankorondrano', 'VILLE1'),
('LEADER PRICE', 'lederprice@gmail.com', 'leaderprice', 'Lot VI BIS Ankorondrano', 'VILLE1');
