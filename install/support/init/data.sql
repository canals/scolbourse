
INSERT INTO `famille` (`num_famille`, `nom_famille`, `prenom_famille`, `adresse1_famille`, `adresse2_famille`, `code_postal_famille`, `ville_famille`, `num_tel_famille`, `indication_famille`, `adherent_association`, `enlevettfrais`) 
       VALUES (1, 'organisation_bourse', 'Aucun', 'Aucune', 'Aucune', 'Aucun', 'Aucune', 'Aucun', '', 'o', 'o');

INSERT INTO utilisateur (idUtilisateur, nom, prenom, login, pwd, typeUtilisateur) VALUES
(1, 'Admin', 'Admin', 'admin', '21232f297a57a5a743894a0e4a801fc3', 101);


INSERT INTO `taux` (`code_taux`, `taux_frais`, `montant_frais_envoi`) VALUES
(1, '5', 0.00);


INSERT INTO `reglement` (`code_reglement`, `mode_reglement`) VALUES
(1, 'esp�ces'),
(2, 'ch�que'),
(3, 'multipass'),
(4, 'Cheque caution'),
(5, 'esp�ces caution');

INSERT INTO `etat` (`code_etat`, `libelle_etat`, `pourcentage_etat`) VALUES
(1, 'excellent', 70),
(2, 'Bon', 55),
(3, 'Moyen', 40),
(4, 'Mauvais', 25);