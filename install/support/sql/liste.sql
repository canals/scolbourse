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
) ENGINE=MyISAM DEFAULT CHARSET=latin1
