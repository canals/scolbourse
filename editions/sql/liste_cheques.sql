SELECT
     dossier_depot.`num_dossier_depot` AS dossier_depot_num_dossier_depot,
     ucase(famille.`nom_famille`) AS famille_nom_famille,
     dossier_depot.`frais_dossier_depot` AS dossier_depot_frais_dossier_depot,
     dossier_depot.`montant_livre_depose_vendu` AS dossier_depot_montant_livre_depose_vendu,
     dossier_depot.`montant_livre_depose_vendu` - dossier_depot.`frais_dossier_depot` AS total_a_payer

FROM
     `famille` famille INNER JOIN `dossier_depot` dossier_depot ON famille.`num_famille` = dossier_depot.`num_dossier_depot`
where dossier_depot.`num_dossier_depot`
order by dossier_depot.num_dossier_depot