select sum(tarif)
from dossier_depot dd, exemplaire ex, determine de
where dd.num_dossier_depot=ex.num_dossier_depot
    and ex.code_manuel=de.code_manuel
	and ex.code_etat=de.code_etat

select sum(tarif)
from dossier_d_achat dd, exemplaire ex, determine de
where dd.num_dossier_achat=ex.num_dossier_achat
    and ex.code_manuel=de.code_manuel
	and ex.code_etat=de.code_etat
	
select sum(montant_livre_achete), sum(frais_dossier_achat)
from dossier_d_achat dd

select sum(montant_livre_depose_vendu), sum(frais_dossier_depot)
from dossier_depot

select code_reglement, sum(montant)
from regle
group by code_reglement

select sum(montant)
from regle
