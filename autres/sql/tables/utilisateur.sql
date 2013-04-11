-- --------------------------------------------------------

-- 
-- Structure de la table `utilisateur`
-- 

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `idUtilisateur` int(10) unsigned NOT NULL auto_increment,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `login` varchar(20) NOT NULL,
  `pwd` varchar(70) NOT NULL,
  `typeUtilisateur` int(10) unsigned NOT NULL default '1',
  PRIMARY KEY  (`idUtilisateur`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 PACK_KEYS=0;
