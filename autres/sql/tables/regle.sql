-- --------------------------------------------------------

-- 
-- Structure de la table `regle`
-- 

DROP TABLE IF EXISTS `regle`;
CREATE TABLE IF NOT EXISTS `regle` (
  `num_regle` int(10) NOT NULL auto_increment,
  `num_dossier_achat` int(20) NOT NULL default '0',
  `code_reglement` int(20) NOT NULL default '0',
  `montant` decimal(8,2) default NULL,
  `datereg` date default NULL,
  `numero_cheque` varchar(15) default NULL,
  PRIMARY KEY  (`num_regle`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 PACK_KEYS=0;
