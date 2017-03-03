-- phpMyAdmin SQL Dump
-- version 4.4.15.7
-- http://www.phpmyadmin.net
--
-- Client :  mysql
-- Généré le :  Jeu 02 Mars 2017 à 17:36
-- Version du serveur :  5.5.54-0+deb7u1-log
-- Version de PHP :  5.4.45-0+deb7u6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : 
--

--
-- Structure de la table `SB_Client`
--

CREATE TABLE IF NOT EXISTS `SB_Client` (
  `id` varchar(10) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `mdp` varchar(50) NOT NULL,
  `tsDerniereCx` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `superUser` tinyint(4) DEFAULT NULL,
  `maxDecouvert` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `SB_Client`
-- mot de passe admin 123123

INSERT INTO `SB_Client` (`id`, `nom`, `prenom`, `mdp`, `tsDerniereCx`, `superUser`, `maxDecouvert`) VALUES
('admin', 'admin', 'admin', '19e0a233bb45c64502f1c651fdcda6ea', '2017-03-02 10:48:38', 1, 0.00);

-- --------------------------------------------------------

--
-- Structure de la table `SB_Mouvement`
--

CREATE TABLE IF NOT EXISTS `SB_Mouvement` (
  `idCli` varchar(10) NOT NULL,
  `num` int(11) NOT NULL,
  `montant` decimal(10,2) NOT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `idTiers` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Structure de la table `SB_Param`
--

CREATE TABLE IF NOT EXISTS `SB_Param` (
  `id` varchar(100) NOT NULL,
  `valeur` varchar(100) NOT NULL,
  `filtre` varchar(50) NOT NULL DEFAULT 'entier positif',
  `commentaire` varchar(250) NOT NULL,
  `rubrique` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `SB_Param`
--

INSERT INTO `SB_Param` (`id`, `valeur`, `filtre`, `commentaire`, `rubrique`) VALUES
('affichageChronologique', '0', 'entier positif', '1 - affichage chronologique - 0 - affichage anti-chronologique', 'Gestion des comptes'),
('clientTiersFictif', 'Dépot en liquide', 'chaine', 'Identifiant du proprietaire du compte fictif. Ce compte ne sera pas débité. Il sert à initialiser les comptes des clients par une opération fictive.', 'Gestion des comptes'),
('commentaireRegex', '0-9', 'chaine', 'Commentaire affiché pour aider la saisie du MdP', 'Mot de passe'),
('copyrightImage', 'http://www.myfreetextures.com', 'chaine', 'Lien vers le site de l''auteur de l''image de fond', 'Application'),
('decouvertAutoriseDefaut', '0', 'entier positif', 'Valeur absolue de l''autorisation de découvert. 0 si pas de découvert autorisé. Ce paramètre initialise tous les comptes. L''administrateur (SU) peut modifier cette valeur pour chaque compte.', 'Gestion des comptes'),
('grainDeSel', '$r1#qF@', 'chaine', 'Salage du mot de passe. Ne pas modifier cette valeur !', 'Application'),
('libelleDeLaMonnaie', 'Brave', 'chaine', 'Libellé de la monnaie utilisée dans le jeu.', 'Monnaie'),
('longueurMaxi', '30', 'entier positif', 'Longueur maximum pour un mot de passe', 'Mot de passe'),
('longueurMini', '6', 'entier positif', 'Longueur minimum pour un mot de passe', 'Mot de passe'),
('nbLigneAffiche', '10', 'entier positif', 'Nombre maximum de ligne affichée lors d''une visualisation du compte à l''écran.', 'Gestion des comptes'),
('nbLigneAfficheAdmin', '40', 'entier positif', 'Nombre de ligne affichée dans la visualisation de l''admin', 'Gestion des comptes'),
('rappelRegexChiffre', '^[0-9]{%min%,%max%}$', 'chaine', 'Rappel de la valeur d''une regex obligeant un mot de passe composé de chiffres', 'Mot de passe'),
('rappelRegexComplexe', '^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[&#-_@=+*/?.!$]).{%min%,%max%}$', 'chaine', 'Rappel de la valeur d''une regex obligeant un mot de passe fort', 'Mot de passe'),
('rappelRegexLettre', '^[a-zA-Z]{%min%,%max%}$', 'chaine', 'Rappel de la valeur d''une regex obligeant un mot de passe composé de lettres', 'Mot de passe'),
('rappelRegexLettreChiffre', '^[0-9a-zA-Z]{%min%,%max%}$', 'chaine', 'Rappel de la valeur d''une regex obligeant un mot de passe composé de lettres et de chiffres', 'Mot de passe'),
('regexMDP', '^[0-9]{%min%,%max%}$', 'chaine', 'Expression régulière pour la vérification du mot de passe', 'Mot de passe'),
('symboleMonnaie', 'Br', 'chaine', 'Symbole de la monnaie utilisée dans le jeu.', 'Monnaie'),
('TitreApplication', 'Steam-Banque', 'chaine', 'Titre de l''application', 'Application'),
('valInitialeCompteClient', '200', 'entier positif', 'Valeur par défaut du compte d''un client quelconque lors de sa création. 0 minimum.', 'Gestion des comptes');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `SB_Client`
--
ALTER TABLE `SB_Client`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `SB_Mouvement`
--
ALTER TABLE `SB_Mouvement`
  ADD PRIMARY KEY (`idCli`,`num`);

--
-- Index pour la table `SB_Param`
--
ALTER TABLE `SB_Param`
  ADD PRIMARY KEY (`id`);

