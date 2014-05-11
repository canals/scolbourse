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
) ENGINE=MyISAM DEFAULT CHARSET=latin1
