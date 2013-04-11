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
