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
