-- phpMyAdmin SQL Dump
-- version 2.7.0-pl1
-- http://www.phpmyadmin.net
-- 
-- Serveur: localhost
-- Généré le : Mardi 05 Mai 2009 à 22:28
-- Version du serveur: 5.0.18
-- Version de PHP: 5.1.1
-- 
-- Base de données: `scoldev`
-- 

-- --------------------------------------------------------

-- 
-- Structure de la table `determine`
-- 

DROP TABLE IF EXISTS `determine`;
CREATE TABLE IF NOT EXISTS `determine` (
  `code_etat` smallint(5) NOT NULL default '0',
  `code_manuel` varchar(20) NOT NULL default '0',
  `tarif` decimal(8,2) default '0.00',
  PRIMARY KEY  (`code_etat`,`code_manuel`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Structure de la table `dossier_d_achat`
-- 

DROP TABLE IF EXISTS `dossier_d_achat`;
CREATE TABLE IF NOT EXISTS `dossier_d_achat` (
  `num_dossier_achat` int(20) NOT NULL default '0',
  `date_creation_achat` date default NULL,
  `date_dernier_achat` date default NULL,
  `frais_dossier_achat` decimal(8,2) default '0.00',
  `montant_livre_achete` decimal(8,2) default NULL,
  `etat_dossier_achat` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`num_dossier_achat`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 PACK_KEYS=0;

-- --------------------------------------------------------

-- 
-- Structure de la table `dossier_depot`
-- 

DROP TABLE IF EXISTS `dossier_depot`;
CREATE TABLE IF NOT EXISTS `dossier_depot` (
  `num_dossier_depot` int(20) NOT NULL default '0',
  `date_creation_depot` date default NULL,
  `date_dernier_depot` date default NULL,
  `frais_dossier_depot` decimal(8,2) default NULL,
  `frais_envoi_depot` decimal(8,2) default NULL,
  `montant_livre_depose_vendu` decimal(8,2) default NULL,
  `enlevefraisenv_depot` char(1) character set latin1 NOT NULL default 'n',
  `etat_dossier_depot` tinyint(4) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

-- 
-- Structure de la table `dossiers_montant`
-- 

DROP TABLE IF EXISTS `dossiers_montant`;
CREATE TABLE IF NOT EXISTS `dossiers_montant` (
  `num_dossier_depot` int(20) NOT NULL default '0',
  `montant` decimal(30,2) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

-- 
-- Structure de la table `etat`
-- 

DROP TABLE IF EXISTS `etat`;
CREATE TABLE IF NOT EXISTS `etat` (
  `code_etat` smallint(5) NOT NULL auto_increment,
  `libelle_etat` varchar(32) default NULL,
  `pourcentage_etat` tinyint(3) unsigned default NULL,
  PRIMARY KEY  (`code_etat`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 PACK_KEYS=0;

-- --------------------------------------------------------

-- 
-- Structure de la table `exemplaire`
-- 

DROP TABLE IF EXISTS `exemplaire`;
CREATE TABLE IF NOT EXISTS `exemplaire` (
  `code_exemplaire` varchar(20) NOT NULL default '0',
  `num_dossier_depot` int(20) NOT NULL default '0',
  `num_dossier_achat` int(20) default NULL,
  `code_etat` smallint(5) NOT NULL default '0',
  `code_manuel` varchar(20) NOT NULL default '0',
  `vendu` tinyint(4) default NULL,
  `date_vente` date default NULL,
  `date_rendu` date default NULL,
  PRIMARY KEY  (`code_exemplaire`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Structure de la table `famille`
-- 

DROP TABLE IF EXISTS `famille`;
CREATE TABLE IF NOT EXISTS `famille` (
  `num_famille` int(20) NOT NULL auto_increment,
  `nom_famille` varchar(32) default NULL,
  `prenom_famille` varchar(32) default NULL,
  `adresse1_famille` varchar(100) default NULL,
  `adresse2_famille` varchar(100) default NULL,
  `code_postal_famille` varchar(5) default NULL,
  `ville_famille` varchar(32) default NULL,
  `adresse1_cheque_famille` varchar(100) default NULL,
  `adresse2_cheque_famille` varchar(100) default NULL,
  `code_postal_cheque_famille` varchar(5) default NULL,
  `ville_cheque_famille` varchar(32) default NULL,
  `nom_cheque_famille` varchar(32) default NULL,
  `num_tel_famille` varchar(14) default NULL,
  `indication_famille` text,
  `adherent_association` char(1) NOT NULL default 'n',
  `enlevettfrais` char(1) NOT NULL default 'n',
  PRIMARY KEY  (`num_famille`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 PACK_KEYS=0;

-- --------------------------------------------------------

-- 
-- Structure de la table `liste`
-- 

DROP TABLE IF EXISTS `liste`;
CREATE TABLE IF NOT EXISTS `liste` (
  `code_liste` smallint(5) NOT NULL auto_increment,
  `libelle_liste` varchar(64) default NULL,
  `classe_liste` varchar(32) default NULL,
  PRIMARY KEY  (`code_liste`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Structure de la table `liste_manuel`
-- 

DROP TABLE IF EXISTS `liste_manuel`;
CREATE TABLE IF NOT EXISTS `liste_manuel` (
  `code_manuel` varchar(20) NOT NULL default '0',
  `code_liste` smallint(5) NOT NULL default '0',
  `num_manuel_liste` tinyint(2) default NULL,
  PRIMARY KEY  (`code_manuel`,`code_liste`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Structure de la table `manuel`
-- 

DROP TABLE IF EXISTS `manuel`;
CREATE TABLE IF NOT EXISTS `manuel` (
  `code_manuel` varchar(20) NOT NULL default '0',
  `titre_manuel` varchar(128) default NULL,
  `matiere_manuel` varchar(64) default NULL,
  `classe_manuel` varchar(20) default NULL,
  `editeur_manuel` varchar(32) default NULL,
  `date_edition_manuel` varchar(10) default NULL,
  `tarif_neuf_manuel` decimal(8,2) default NULL,
  `dispo_occasion_manuel` tinyint(1) NOT NULL default '1',
  `dispo_neuf_manuel` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`code_manuel`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 PACK_KEYS=0;

-- --------------------------------------------------------

-- 
-- Structure de la table `regle`
-- 

DROP TABLE IF EXISTS `regle`;
CREATE TABLE IF NOT EXISTS `regle` (
  `num_regle` int(10) NOT NULL auto_increment,
  `num_dossier_achat` int(20) NOT NULL default '0',
  `code_reglement` int(20) NOT NULL default '0',
  `montant` decimal(8,2) default NULL,
  `datereg` date default NULL,
  `numero_cheque` varchar(15) default NULL,
  PRIMARY KEY  (`num_regle`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 PACK_KEYS=0;

-- --------------------------------------------------------

-- 
-- Structure de la table `reglement`
-- 

DROP TABLE IF EXISTS `reglement`;
CREATE TABLE IF NOT EXISTS `reglement` (
  `code_reglement` int(20) NOT NULL default '0',
  `mode_reglement` varchar(50) default NULL,
  PRIMARY KEY  (`code_reglement`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Structure de la table `taux`
-- 

DROP TABLE IF EXISTS `taux`;
CREATE TABLE IF NOT EXISTS `taux` (
  `code_taux` int(3) NOT NULL auto_increment,
  `taux_frais` varchar(32) default NULL,
  `montant_frais_envoi` decimal(8,2) default NULL,
  PRIMARY KEY  (`code_taux`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 PACK_KEYS=0;

-- --------------------------------------------------------

-- 
-- Structure de la table `utilisateur`
-- 

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `idUtilisateur` int(10) unsigned NOT NULL auto_increment,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `login` varchar(20) NOT NULL,
  `pwd` varchar(70) NOT NULL,
  `typeUtilisateur` int(10) unsigned NOT NULL default '1',
  PRIMARY KEY  (`idUtilisateur`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 PACK_KEYS=0;
