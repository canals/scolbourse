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
) ENGINE=MyISAM DEFAULT CHARSET=latin1
