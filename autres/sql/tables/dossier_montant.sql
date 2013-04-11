-- --------------------------------------------------------

-- 
-- Structure de la table `dossiers_montant`
-- 

DROP TABLE IF EXISTS `dossiers_montant`;
CREATE TABLE IF NOT EXISTS `dossiers_montant` (
  `num_dossier_depot` int(20) NOT NULL default '0',
  `montant` decimal(30,2) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
