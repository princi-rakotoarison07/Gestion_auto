-- ============================================
-- BASE DE DONNÉES GESTION AUTOMOBILE - VERSION SIMPLIFIÉE
-- ============================================

-- Création de la base de données (si nécessaire)
-- CREATE DATABASE IF NOT EXISTS gestion_automobile;
-- USE gestion_automobile;

-- ============================================
-- TABLES DE RÉFÉRENCE
-- ============================================

-- 1. TABLE MARQUE
CREATE TABLE marque (
  id_marque INT PRIMARY KEY AUTO_INCREMENT,
  libelle VARCHAR(50) NOT NULL UNIQUE,  -- Toyota, Honda, Mazda, Renault
  pays_origine VARCHAR(50),
  actif BOOLEAN DEFAULT TRUE,
  date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. TABLE TYPE_VEHICULE
CREATE TABLE type_vehicule (
  id_type_vehicule INT PRIMARY KEY AUTO_INCREMENT,
  libelle VARCHAR(30) NOT NULL UNIQUE,  -- Berline, SUV, Pick-up, etc.
  actif BOOLEAN DEFAULT TRUE,
  date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 3. TABLE MODELE
CREATE TABLE modele (
  id_modele INT PRIMARY KEY AUTO_INCREMENT,
  id_marque INT NOT NULL,
  id_type_vehicule INT NOT NULL,
  libelle VARCHAR(50) NOT NULL,          -- Corolla, Civic, CX-5
  annee_modele INT,                       -- Année du modèle
  date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  
  FOREIGN KEY (id_marque) REFERENCES marque(id_marque),
  FOREIGN KEY (id_type_vehicule) REFERENCES type_vehicule(id_type_vehicule),
  UNIQUE KEY unique_modele_marque (id_marque, libelle, annee_modele)
);

-- 4. TABLE COULEUR
CREATE TABLE couleur (
  id_couleur INT PRIMARY KEY AUTO_INCREMENT,
  libelle VARCHAR(30) NOT NULL UNIQUE,   -- Noir, Blanc, Rouge, etc.
  date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 5. TABLE STATUT_VEHICULE
CREATE TABLE statut_vehicule (
  id_statut_vehicule INT PRIMARY KEY AUTO_INCREMENT,
  libelle VARCHAR(30) NOT NULL UNIQUE,   -- en_stock, vendu, reserve
  date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 6. TABLE STATUT_VENTE
CREATE TABLE statut_vente (
  id_statut_vente INT PRIMARY KEY AUTO_INCREMENT,
  libelle VARCHAR(30) NOT NULL UNIQUE,   -- en_attente, confirmee, annulee
  date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 7. TABLE STATUT_PAIEMENT
CREATE TABLE statut_paiement (
  id_statut_paiement INT PRIMARY KEY AUTO_INCREMENT,
  libelle VARCHAR(30) NOT NULL UNIQUE,   -- en_attente, partiel, complet
  date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 8. TABLE TYPE_VENTE
CREATE TABLE type_vente (
  id_type_vente INT PRIMARY KEY AUTO_INCREMENT,
  libelle VARCHAR(50) NOT NULL UNIQUE,   -- Vente directe, Financement
  date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 9. TABLE MODE_PAIEMENT
CREATE TABLE mode_paiement (
  id_mode_paiement INT PRIMARY KEY AUTO_INCREMENT,
  libelle VARCHAR(50) NOT NULL UNIQUE,   -- espece, carte, cheque, mvola, orange
  actif BOOLEAN DEFAULT TRUE,
  date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ============================================
-- TABLES PRINCIPALES
-- ============================================

-- 10. TABLE VEHICULE
CREATE TABLE vehicule (
  id_vehicule INT PRIMARY KEY AUTO_INCREMENT,
  id_modele INT NOT NULL,
  id_couleur INT NOT NULL,
  id_statut_vehicule INT NOT NULL DEFAULT 1,
  
  -- Informations d'identification
  immatriculation VARCHAR(20) UNIQUE,
  numero_chassis VARCHAR(50) UNIQUE,
  
  -- Caractéristiques
  annee_fabrication INT NOT NULL,
  kilometrage INT DEFAULT 0,
  transmission VARCHAR(20),               -- Manuelle, Automatique
  type_carburant VARCHAR(20),            -- Essence, Diesel
  
  -- Information financières
  prix_achat DECIMAL(12,2) NOT NULL,
  prix_vente DECIMAL(12,2) NOT NULL,
  
  -- Dates importantes
  date_acquisition DATE,
  date_arrivee_stock DATE,
  date_vente DATE,
  
  -- Notes
  observations TEXT,
  date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  
  FOREIGN KEY (id_modele) REFERENCES modele(id_modele),
  FOREIGN KEY (id_couleur) REFERENCES couleur(id_couleur),
  FOREIGN KEY (id_statut_vehicule) REFERENCES statut_vehicule(id_statut_vehicule)
);

-- 11. TABLE CLIENT
CREATE TABLE client (
  id_client INT PRIMARY KEY AUTO_INCREMENT,
  type_client VARCHAR(20) DEFAULT 'particulier', -- particulier, professionnel
  
  -- Informations personnelles
  nom VARCHAR(50) NOT NULL,
  prenom VARCHAR(50) NOT NULL,
  
  -- Coordonnées
  telephone VARCHAR(20) NOT NULL,
  email VARCHAR(100),
  
  -- Adresse
  adresse TEXT,
  ville VARCHAR(50),
  
  -- Informations professionnelles (si professionnel)
  nom_entreprise VARCHAR(100),
  
  -- Notes
  notes TEXT,
  date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 12. TABLE EMPLOYE
CREATE TABLE employe (
  id_employe INT PRIMARY KEY AUTO_INCREMENT,
  nom VARCHAR(50) NOT NULL,
  prenom VARCHAR(50) NOT NULL,
  telephone VARCHAR(20) NOT NULL,
  email VARCHAR(100),
  poste VARCHAR(50),                     -- Vendeur, Commercial, Administrateur
  actif BOOLEAN DEFAULT TRUE,
  date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 13. TABLE UTILISATEUR (pour connexion)
CREATE TABLE utilisateur (
  id_utilisateur INT PRIMARY KEY AUTO_INCREMENT,
  id_employe INT NOT NULL,
  login VARCHAR(50) UNIQUE NOT NULL,
  mot_de_passe VARCHAR(255) NOT NULL,
  role VARCHAR(20) DEFAULT 'vendeur',    -- admin, vendeur
  actif BOOLEAN DEFAULT TRUE,
  date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  
  FOREIGN KEY (id_employe) REFERENCES employe(id_employe)
);

-- 14. TABLE VENTE
CREATE TABLE vente (
  id_vente INT PRIMARY KEY AUTO_INCREMENT,
  id_vehicule INT NOT NULL UNIQUE,
  id_client INT NOT NULL,
  id_employe INT NOT NULL,
  id_type_vente INT NOT NULL DEFAULT 1,
  id_statut_vente INT NOT NULL DEFAULT 1,
  
  -- Information financière
  montant_total DECIMAL(12,2) NOT NULL,
  montant_acompte DECIMAL(12,2) DEFAULT 0,
  
  -- Dates importantes
  date_vente DATE NOT NULL,
  date_livraison DATE,
  
  -- Notes
  notes TEXT,
  date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  
  FOREIGN KEY (id_vehicule) REFERENCES vehicule(id_vehicule),
  FOREIGN KEY (id_client) REFERENCES client(id_client),
  FOREIGN KEY (id_employe) REFERENCES employe(id_employe),
  FOREIGN KEY (id_type_vente) REFERENCES type_vente(id_type_vente),
  FOREIGN KEY (id_statut_vente) REFERENCES statut_vente(id_statut_vente)
);

-- 15. TABLE PAIEMENT
CREATE TABLE paiement (
  id_paiement INT PRIMARY KEY AUTO_INCREMENT,
  id_vente INT NOT NULL,
  id_mode_paiement INT NOT NULL,
  id_statut_paiement INT NOT NULL DEFAULT 1,
  
  montant DECIMAL(12,2) NOT NULL,
  date_paiement DATE NOT NULL,
  
  -- Informations de transaction
  reference_transaction VARCHAR(100),
  
  -- Notes
  notes TEXT,
  date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  
  FOREIGN KEY (id_vente) REFERENCES vente(id_vente),
  FOREIGN KEY (id_mode_paiement) REFERENCES mode_paiement(id_mode_paiement),
  FOREIGN KEY (id_statut_paiement) REFERENCES statut_paiement(id_statut_paiement)
);

-- 16. TABLE CAISSE
CREATE TABLE caisse (
  id_caisse INT PRIMARY KEY AUTO_INCREMENT,
  libelle VARCHAR(50) NOT NULL UNIQUE,   -- Caisse principale
  solde_actuel DECIMAL(12,2) DEFAULT 0,
  responsable_id INT,
  date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  
  FOREIGN KEY (responsable_id) REFERENCES employe(id_employe)
);

-- 17. TABLE OPERATION_CAISSE
CREATE TABLE operation_caisse (
  id_operation INT PRIMARY KEY AUTO_INCREMENT,
  id_caisse INT NOT NULL,
  id_vente INT,
  id_paiement INT,
  
  type_operation VARCHAR(10) NOT NULL,   -- entree, sortie
  montant DECIMAL(12,2) NOT NULL,
  description VARCHAR(255),
  date_operation DATETIME DEFAULT CURRENT_TIMESTAMP,
  
  FOREIGN KEY (id_caisse) REFERENCES caisse(id_caisse),
  FOREIGN KEY (id_vente) REFERENCES vente(id_vente),
  FOREIGN KEY (id_paiement) REFERENCES paiement(id_paiement)
);

-- ============================================
-- DONNÉES INITIALES
-- ============================================

-- Insertion des statuts de véhicule
INSERT INTO statut_vehicule (libelle) VALUES
('en_stock'),
('reserve'),
('vendu');

-- Insertion des statuts de vente
INSERT INTO statut_vente (libelle) VALUES
('en_attente'),
('confirmee'),
('annulee');

-- Insertion des statuts de paiement
INSERT INTO statut_paiement (libelle) VALUES
('en_attente'),
('partiel'),
('complet');

-- Insertion des types de vente
INSERT INTO type_vente (libelle) VALUES
('Vente directe'),
('Financement bancaire');

-- Insertion des modes de paiement
INSERT INTO mode_paiement (libelle) VALUES
('espece'),
('carte'),
('cheque'),
('mvola'),
('orange money'),
('virement');

-- Insertion des types de véhicule
INSERT INTO type_vehicule (libelle) VALUES
('Berline'),
('SUV'),
('Pick-up'),
('4x4'),
('Citadine');

-- Insertion des couleurs
INSERT INTO couleur (libelle) VALUES
('Noir'),
('Blanc'),
('Gris'),
('Bleu'),
('Rouge'),
('Vert'),
('Argent'),
('Beige');

-- Insertion des marques
INSERT INTO marque (libelle, pays_origine) VALUES
('Toyota', 'Japon'),
('Honda', 'Japon'),
('Mazda', 'Japon'),
('Renault', 'France'),
('Peugeot', 'France'),
('Mercedes', 'Allemagne'),
('BMW', 'Allemagne');

-- Insertion d'une caisse principale
INSERT INTO caisse (libelle, solde_actuel) VALUES
('Caisse principale', 10000000);

-- Insertion d'un administrateur par défaut
INSERT INTO employe (nom, prenom, telephone, email, poste) VALUES
('Admin', 'System', '0340000000', 'admin@automobile.mg', 'Administrateur');

INSERT INTO utilisateur (id_employe, login, mot_de_passe, role) VALUES
(1, 'admin', MD5('admin123'), 'admin');

-- Insertion d'un vendeur exemple
INSERT INTO employe (nom, prenom, telephone, email, poste) VALUES
('Dupont', 'Jean', '0341111111', 'jean@automobile.mg', 'Vendeur');

INSERT INTO utilisateur (id_employe, login, mot_de_passe, role) VALUES
(2, 'jean', MD5('vendeur123'), 'vendeur');

-- ============================================
-- REQUÊTES UTILES POUR L'APPLICATION
-- ============================================

-- 1. Vérifier les identifiants utilisateur
SELECT 
  u.id_utilisateur,
  u.login,
  u.role,
  e.nom,
  e.prenom,
  e.poste
FROM utilisateur u
JOIN employe e ON u.id_employe = e.id_employe
WHERE u.login = 'admin' 
  AND u.mot_de_passe = MD5('admin123')
  AND u.actif = TRUE
  AND e.actif = TRUE;

-- 2. Voir le stock de véhicules disponibles
SELECT 
  v.id_vehicule,
  v.immatriculation,
  ma.libelle as marque,
  mo.libelle as modele,
  tv.libelle as type_vehicule,
  c.libelle as couleur,
  v.annee_fabrication,
  v.kilometrage,
  v.prix_vente
FROM vehicule v
JOIN modele mo ON v.id_modele = mo.id_modele
JOIN marque ma ON mo.id_marque = ma.id_marque
JOIN type_vehicule tv ON mo.id_type_vehicule = tv.id_type_vehicule
JOIN couleur c ON v.id_couleur = c.id_couleur
WHERE v.id_statut_vehicule = (SELECT id_statut_vehicule FROM statut_vehicule WHERE libelle = 'en_stock')
ORDER BY v.date_creation;

-- 3. Voir les ventes en cours
SELECT 
  ve.id_vente,
  ve.date_vente,
  c.nom as client_nom,
  c.prenom as client_prenom,
  e.nom as vendeur_nom,
  e.prenom as vendeur_prenom,
  ma.libelle as marque,
  mo.libelle as modele,
  v.immatriculation,
  ve.montant_total,
  st.libelle as statut_vente
FROM vente ve
JOIN client c ON ve.id_client = c.id_client
JOIN employe e ON ve.id_employe = e.id_employe
JOIN vehicule v ON ve.id_vehicule = v.id_vehicule
JOIN modele mo ON v.id_modele = mo.id_modele
JOIN marque ma ON mo.id_marque = ma.id_marque
JOIN statut_vente st ON ve.id_statut_vente = st.id_statut_vente
WHERE st.libelle IN ('en_attente', 'confirmee')
ORDER BY ve.date_vente DESC;

-- 4. Voir les paiements en attente
SELECT 
  v.id_vente,
  v.date_vente,
  c.nom as client_nom,
  c.prenom as client_prenom,
  v.montant_total,
  COALESCE(SUM(p.montant), 0) as deja_paye,
  (v.montant_total - COALESCE(SUM(p.montant), 0)) as reste_a_payer
FROM vente v
JOIN client c ON v.id_client = c.id_client
LEFT JOIN paiement p ON v.id_vente = p.id_vente
  AND p.id_statut_paiement = (SELECT id_statut_paiement FROM statut_paiement WHERE libelle = 'complet')
WHERE v.id_statut_vente = (SELECT id_statut_vente FROM statut_vente WHERE libelle = 'confirmee')
GROUP BY v.id_vente
HAVING reste_a_payer > 0
ORDER BY v.date_vente;

-- 5. Voir le solde de la caisse
SELECT 
  c.libelle as caisse,
  c.solde_actuel,
  COALESCE(SUM(CASE WHEN oc.type_operation = 'entree' THEN oc.montant ELSE 0 END), 0) as entrees_jour,
  COALESCE(SUM(CASE WHEN oc.type_operation = 'sortie' THEN oc.montant ELSE 0 END), 0) as sorties_jour
FROM caisse c
LEFT JOIN operation_caisse oc ON c.id_caisse = oc.id_caisse 
  AND DATE(oc.date_operation) = CURDATE()
GROUP BY c.id_caisse;

-- 6. Ajouter un nouveau véhicule (exemple)
INSERT INTO vehicule (
  id_modele, id_couleur, id_statut_vehicule, 
  immatriculation, annee_fabrication, kilometrage,
  transmission, type_carburant, prix_achat, prix_vente,
  date_acquisition, date_arrivee_stock
) VALUES (
  1,  -- id_modele (à définir)
  1,  -- id_couleur (Noir)
  1,  -- id_statut_vehicule (en_stock)
  'ABC-123', 
  2023, 
  15000,
  'Manuelle',
  'Essence',
  15000000,
  18000000,
  CURDATE(),
  CURDATE()
);

-- 7. Enregistrer une nouvelle vente (exemple)
INSERT INTO vente (
  id_vehicule, id_client, id_employe, 
  id_type_vente, id_statut_vente,
  montant_total, montant_acompte, date_vente
) VALUES (
  1,  -- id_vehicule
  1,  -- id_client
  1,  -- id_employe
  1,  -- id_type_vente (Vente directe)
  2,  -- id_statut_vente (confirmee)
  18000000,
  5000000,
  CURDATE()
);

-- Mettre à jour le statut du véhicule
UPDATE vehicule 
SET id_statut_vehicule = (SELECT id_statut_vehicule FROM statut_vehicule WHERE libelle = 'vendu')
WHERE id_vehicule = 1;