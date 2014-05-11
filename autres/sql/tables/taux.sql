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
