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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 PACK_KEYS=0
