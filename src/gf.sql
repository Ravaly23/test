-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  Dim 15 sep. 2024 à 22:27
-- Version du serveur :  5.7.17
-- Version de PHP :  5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `gf`
--

-- --------------------------------------------------------

--
-- Structure de la table `effectuer`
--

CREATE TABLE `effectuer` (
  `IDUTILISATEUR` int(4) NOT NULL,
  `IDOPERATION` bigint(4) NOT NULL,
  `DATEUTILISATION` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `formule`
--

CREATE TABLE `formule` (
  `IDFORMULE` bigint(4) NOT NULL,
  `NOMFORMULE` varchar(255) NOT NULL,
  `EXPRESSIONFORMULE` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `formule`
--

INSERT INTO `formule` (`IDFORMULE`, `NOMFORMULE`, `EXPRESSIONFORMULE`) VALUES
(1, 'TauxVariationCA', '(CAn-CA)/CA'),
(2, 'TauxProbabilite', 'ResultatNet/CA'),
(3, 'TauxMargeCommercial', 'MargeCommerciale/CAMV'),
(4, 'TauxMarqueCommercial', 'MargeCommerciale/VenteMarchandise'),
(5, 'TauxMatierePremiere', 'CAMPC/ProductionExercice'),
(6, 'TauxChargeExterne', 'ChargeExterne/CA'),
(7, 'TauxValeurAjoute', 'ValeurAjouter/CA'),
(8, 'TauxChargePersonnel', 'ChargePersonnel/ValeurAjouter'),
(9, 'TauxEBE', 'EBE/CA'),
(10, 'TauxChargeFinanciere', 'ChargeFinanciere/CA'),
(11, 'TauxRCAI', 'RCAI/CA'),
(12, 'RotationProduitFinis', 'Vente/StockMoyen'),
(13, 'DelaiMoyenRecouvrementCompteClient', '(Creance*360)/Vente'),
(14, 'DelaiMoyenReglementFournisseurs', '(Dettes*360)/(Achats+SousTraitances)'),
(15, 'RotationMatieresPremiere', 'AchatsConsommes/StocksMoyens'),
(16, 'RentabiliteImmobilisation', 'Ventes/Immobilisations'),
(17, 'RentabiliteActif', 'Ventes/ActifTotal'),
(18, 'RatioLiquiditeGeneral', 'ActifCT/PassifCT'),
(19, 'RatioLiquiditeReduite', '(ActifCT-Stocks)/PassifCT'),
(20, 'RatioLiquiditeImmediate', 'Tresorerie/PassifCT'),
(21, 'DegreeEndetement', 'DetteTotal/ActifTotal'),
(22, 'RatioAutonomieFinanciere', 'CapitauxPropres/DetteTotale'),
(23, 'RatioEndettementTerme', 'CapitauxPropres/DetteLT'),
(24, 'ReturnOnInvestment', 'Benefices/Actifs'),
(25, 'ReturnOnEquity', 'Benefices/CapitauxPropres');

-- --------------------------------------------------------

--
-- Structure de la table `inscription`
--

CREATE TABLE `inscription` (
  `IDINSCRIPTION` int(4) NOT NULL,
  `NOM` varchar(255) NOT NULL,
  `MOTDEPASSE` varchar(128) NOT NULL,
  `CONFIRLATIONMOTDEPASSE` varchar(128) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `operation`
--

CREATE TABLE `operation` (
  `IDOPERATION` bigint(4) NOT NULL,
  `NOMRESULTAT` varchar(128) NOT NULL,
  `RESULTAT` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `IDUTILISATEUR` int(4) NOT NULL,
  `IDINSCRIPTION` int(4) NOT NULL,
  `NOM` varchar(255) NOT NULL,
  `MOTDEPASSE` varchar(128) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`IDUTILISATEUR`, `IDINSCRIPTION`, `NOM`, `MOTDEPASSE`) VALUES
(1, 1, 'Danny', 'Raladson'),
(2, 2, 'Valery', 'Rahvaly');

-- --------------------------------------------------------

--
-- Structure de la table `utiliser`
--

CREATE TABLE `utiliser` (
  `IDUTILISATEUR` int(4) NOT NULL,
  `IDFORMULE` bigint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `effectuer`
--
ALTER TABLE `effectuer`
  ADD PRIMARY KEY (`IDUTILISATEUR`,`IDOPERATION`),
  ADD KEY `I_FK_EFFECTUER_UTILISATEUR` (`IDUTILISATEUR`),
  ADD KEY `I_FK_EFFECTUER_OPERATION` (`IDOPERATION`);

--
-- Index pour la table `formule`
--
ALTER TABLE `formule`
  ADD PRIMARY KEY (`IDFORMULE`);

--
-- Index pour la table `inscription`
--
ALTER TABLE `inscription`
  ADD PRIMARY KEY (`IDINSCRIPTION`);

--
-- Index pour la table `operation`
--
ALTER TABLE `operation`
  ADD PRIMARY KEY (`IDOPERATION`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`IDUTILISATEUR`),
  ADD KEY `I_FK_UTILISATEUR_INSCRIPTION` (`IDINSCRIPTION`);

--
-- Index pour la table `utiliser`
--
ALTER TABLE `utiliser`
  ADD PRIMARY KEY (`IDUTILISATEUR`,`IDFORMULE`),
  ADD KEY `I_FK_UTILISER_UTILISATEUR` (`IDUTILISATEUR`),
  ADD KEY `I_FK_UTILISER_FORMULE` (`IDFORMULE`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `formule`
--
ALTER TABLE `formule`
  MODIFY `IDFORMULE` bigint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT pour la table `inscription`
--
ALTER TABLE `inscription`
  MODIFY `IDINSCRIPTION` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `operation`
--
ALTER TABLE `operation`
  MODIFY `IDOPERATION` bigint(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `IDUTILISATEUR` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
