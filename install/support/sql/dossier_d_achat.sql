-- --------------------------------------------------------

-- 
-- Structure de la table `dossier_d_achat`
-- 

DROP TABLE IF EXISTS `dossier_d_achat`;
CREATE TABLE IF NOT EXISTS `dossier_d_achat` (
  `num_dossier_achat` int(20) NOT NULL default '0',
  `date_creation_achat` date default NULL,
  `date_dernier_achat` date default NULL,
  `frais_dossier_achat` decimal(8,2) default '0.00',
  `montant_livre_achete` decimal(8,2) default NULL,
  `etat_dossier_achat` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`num_dossier_achat`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 PACK_KEYS=0
