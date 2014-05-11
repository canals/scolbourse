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
  `num_tel_famille` varchar(14) default NULL,
  `indication_famille` text,
  `adherent_association` char(1) NOT NULL default 'n',
  `enlevettfrais` char(1) NOT NULL default 'n',
  PRIMARY KEY  (`num_famille`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 PACK_KEYS=0;
