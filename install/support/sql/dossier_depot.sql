-- --------------------------------------------------------

-- 
-- Structure de la table `dossier_depot`
-- 

DROP TABLE IF EXISTS `dossier_depot`;
CREATE TABLE IF NOT EXISTS `dossier_depot` (
  `num_dossier_depot` int(20) NOT NULL default '0',
  `date_creation_depot` date default NULL,
  `date_dernier_depot` date default NULL,
  `frais_dossier_depot` decimal(8,2) default NULL,
  `frais_envoi_depot` decimal(8,2) default NULL,
  `montant_livre_depose_vendu` decimal(8,2) default NULL,
  `enlevefraisenv_depot` char(1) character set latin1 NOT NULL default 'n',
  `etat_dossier_depot` tinyint(4) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci
