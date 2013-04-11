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
