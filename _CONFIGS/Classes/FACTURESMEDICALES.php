<?php
namespace App;

class FACTURESMEDICALES extends BDD
{
    public function ajouter($date_soins, $code_organisme, $taux_organisme, $code_dossier, $type_facture, $num_facture, $num_facture_initiale, $num_bon, $taux_remise, $statut, $user): array
    {
        if (!$num_facture) {
            $factures = $this->lister(null, date('Y', time()), date('m', time()));
            $nb_factures = count($factures);
            $num_facture = date('ymd', time()).substr($code_dossier, 16, 4).str_pad((int)($nb_factures + 1), 8, '0', STR_PAD_LEFT);

            if ($num_bon) {
                $b = $this->getBdd()->prepare("SELECT * FROM tb_factures_medicales WHERE organisme_code = ? AND organisme_facture_num = ?");
                $b->execute(array($code_organisme, $num_bon));
                $bons = $b->fetchAll();
                $nb_bons = count($bons);
                if ($nb_bons === 0) {
                    $validation = 1;
                } else {
                    $validation = 0;
                }
            } else {
                $validation = 1;
            }

            if ($validation === 1) {
                $a = $this->getBdd()->prepare("INSERT INTO tb_factures_medicales(facture_medicale_date, facture_medicale_num, facture_medicale_initiale_num, organisme_code, organisme_contrat_collectivite_taux, dossier_code, type_facture_code, organisme_facture_num, facture_medicale_taux_remise, statut_code, utilisateur_id_creation)
                VALUES(:facture_medicale_date, :facture_medicale_num, :facture_medicale_initiale_num, :organisme_code, :organisme_contrat_collectivite_taux, :dossier_code, :type_facture_code, :organisme_facture_num, :facture_medicale_taux_remise, :statut_code, :utilisateur_id_creation)");
                $a->execute(array(
                    'facture_medicale_date' => $date_soins,
                    'facture_medicale_num' => $num_facture,
                    'facture_medicale_initiale_num' => $num_facture_initiale,
                    'organisme_code' => $code_organisme,
                    'organisme_contrat_collectivite_taux' => $taux_organisme,
                    'dossier_code' => $code_dossier,
                    'type_facture_code' => $type_facture,
                    'organisme_facture_num' => $num_bon,
                    'facture_medicale_taux_remise' => $taux_remise,
                    'statut_code' => $statut,
                    'utilisateur_id_creation' => $user
                ));

                if ($a->errorCode() == "00000") {
                    return array(
                        "success" => true,
                        "num_facture" => $num_facture,
                        "message" => 'Enregistrement effectué avec succès'
                    );
                } else {
                    return array(
                        "success" => false,
                        'test' => $num_facture,
                        "message" => $a->errorInfo()[2]
                    );
                }
            } else {
                return array(
                    "success" => false,
                    'message' => "Le numéro du bon {$num_bon} a déjà été utilisé pour cet organisme."
                );
            }
        } else {
            $a = $this->getBdd()->prepare("UPDATE tb_factures_medicales SET organisme_code = ?, type_facture_code = ?, organisme_facture_num = ?, date_edition = ?, utilisateur_id_edition = ? WHERE facture_medicale_num = ?");
            $a->execute(array($code_organisme, $type_facture, $num_bon, date('Y-m-d H:i:s', time()), $user, $num_facture));

            if ($a->errorCode() == "00000") {
                return array(
                    "success" => true,
                    "num_facture" => $num_facture,
                    "message" => 'Enregistrement effectué avec succès'
                );
            } else {
                return array(
                    "success" => false,
                    'test' => $num_facture,
                    "message" => $a->errorInfo()[2]
                );
            }
        }
    }

    public function lister($code_ets, $annee, $mois)
    {
        $a = $this->getBdd()->prepare("
SELECT 
       B.etablissement_code AS code_etablissement,
       A.facture_medicale_num AS num_facture,
       A.organisme_facture_num AS num_bon,
       A.dossier_code AS code_dossier,
       A.organisme_code AS code_organisme      
FROM 
     tb_factures_medicales A 
         JOIN tb_patients_dossiers B 
             ON A.dossier_code = B.dossier_code 
                    AND B.etablissement_code LIKE ? 
                    AND YEAR(A.date_creation) LIKE ? 
                    AND MONTH(A.date_creation) LIKE ?
ORDER BY A.date_edition DESC");
        $a->execute(array('%'.$code_ets.'%', '%'.$annee.'%', '%'.$mois.'%'));
        return $a->fetchAll();
    }

    public function ajouter_acte($num_facture, $code_acte, $prix_unitaire, $quantite, $taux_rgb, $montant_rgb, $taux_organisme, $taux_remise, $date_soins, $user): array
    {
        $montant_depense = (int)($prix_unitaire * $quantite);
        $montant_restant = (int)($montant_depense - $montant_rgb);
        $montant_rc = (int)($montant_restant * $taux_organisme / 100);

        $montant_brut_patient = (int)($montant_restant - $montant_rc);
        $montant_remise = (int)($montant_brut_patient * $taux_remise / 100);
        $montant_net_patient = ($montant_brut_patient - $montant_remise);

        $a = $this->getBdd()->prepare("INSERT INTO tb_factures_medicales_actes(facture_medicale_num, acte_code, acte_tarif, acte_quantite, acte_taux_couverture_rgb, acte_taux_couverture_rc, acte_taux_remise, acte_montant_depense, acte_montant_rgb, acte_montant_rc, acte_montant_patient, acte_date_debut, utilisateur_id_creation)
        VALUES(:facture_medicale_num, :acte_code, :acte_tarif, :acte_quantite, :acte_taux_couverture_rgb, :acte_taux_couverture_rc, :acte_taux_remise, :acte_montant_depense, :acte_montant_rgb, :acte_montant_rc, :acte_montant_patient, :acte_date_debut, :utilisateur_id_creation)");
        $a->execute(array(
            'facture_medicale_num' => $num_facture,
            'acte_code' => $code_acte,
            'acte_tarif' => $prix_unitaire,
            'acte_quantite' => $quantite,
            'acte_taux_couverture_rgb' => $taux_rgb,
            'acte_taux_couverture_rc' => $taux_organisme,
            'acte_taux_remise' => $taux_remise,
            'acte_montant_depense' => $montant_depense,
            'acte_montant_rgb' => $montant_rgb,
            'acte_montant_rc' => $montant_rc,
            'acte_montant_patient' => $montant_net_patient,
            'acte_date_debut' => $date_soins,
            'utilisateur_id_creation' => $user
        ));
        if ($a->errorCode() == "00000") {
            return array(
                "success" => true,
                "message" => 'Enregistrement effectué avec succès'
            );
        } else {
            return array(
                "success" => false,
                "message" => $a->errorInfo()[2]
            );
        }
    }

    public function lister_actes($num_facture)
    {
        $facture = $this->trouver($num_facture);
        if ($facture) {
            $a = $this->getBdd()->prepare("
SELECT 
       A.facture_medicale_num AS num_facture,
       A.acte_code AS code,
       B.acte_libelle AS libelle,
       A.acte_tarif AS prix_unitaire,
       A.acte_quantite AS quantite,
       A.acte_montant_depense AS montant_depense,
       A.acte_taux_couverture_rgb AS taux_rgb,
       A.acte_taux_couverture_rc AS taux_rc,
       A.acte_taux_remise AS taux_remise,
       A.acte_montant_rgb AS montant_rgb,
       A.acte_montant_rc AS montant_rc,
       A.acte_montant_patient AS montant_patient,
       A.acte_date_debut AS date_debut,
       A.acte_date_fin AS date_fin, 
       A.date_creation,
       A.utilisateur_id_creation
FROM tb_factures_medicales_actes A 
    JOIN tb_ref_actes_medicaux B 
        ON A.acte_code = B.acte_code 
               AND B.acte_date_fin IS NULL 
               AND A.facture_medicale_num = ?");
            $a->execute(array($num_facture));
            return $a->fetchAll();
        }
    }

    public function trouver($num_facture)
    {
        $a = $this->getBdd()->prepare("
SELECT 
       A.facture_medicale_num AS num_facture, 
       A.dossier_code AS code_dossier, 
       A.organisme_facture_num AS num_bon,
       A.organisme_code AS code_organisme,
       A.organisme_contrat_collectivite_code AS num_assurance,
       A.organisme_contrat_collectivite_taux AS taux_organisme,
       B.etablissement_code AS code_etablissement, 
       C.population_num AS num_population, 
       C.rgb_num AS num_rgb, 
       C.population_prenoms AS prenom, 
       C.population_nom AS nom, 
       C.population_date_naissance AS date_naissance,
       A.date_creation
FROM 
     tb_factures_medicales A 
         JOIN tb_patients_dossiers B 
             ON A.dossier_code = B.dossier_code 
         JOIN tb_populations C 
             ON B.population_num = C.population_num 
                    AND A.facture_medicale_num = ?");
        $a->execute(array($num_facture));
        return $a->fetch();
    }

    public function moteur_recherche_organisme_factures($code_organisme, $rubrique, $num_facture, $num_population, $nom_prenoms, $code_etablissement) {
        if($rubrique === 'reception') {
            $a = $this->getBdd()->prepare("
SELECT 
       A.organisme_code AS code_organisme, 
       A.etablissement_code AS code_etablissement,
       C.raison_sociale AS raison_sociale,
       B.type_facture_code AS code_type_facture,
       A.facture_medicale_num AS num_facture,
       B.organisme_facture_num AS num_bon,
       B.facture_medicale_date AS date_soins,
       A.population_num AS num_population,
       D.rgb_num AS num_rgb,
       D.population_nom AS nom,
       D.population_prenoms AS prenoms
FROM 
     tb_factures_medicales_organismes A 
         JOIN tb_factures_medicales B 
             ON A.facture_medicale_num = B.facture_medicale_num 
         JOIN tb_etablissements C 
             ON A.etablissement_code = C.etablissement_code 
         JOIN tb_populations D 
             ON A.population_num = D.population_num
                    AND A.organisme_code = ? 
                    AND (B.organisme_facture_num LIKE ? OR A.facture_medicale_num LIKE ?) 
                    AND (D.rgb_num LIKE ? OR A.population_num LIKE ?) 
                    AND CONCAT(D.population_nom, ' ', D.population_prenoms) LIKE ? 
                    AND A.etablissement_code LIKE ? 
                    AND A.facture_medicale_date_reception IS NULL 
ORDER BY 
         A.date_creation DESC");
        }else {
            $a = $this->getBdd()->prepare("
SELECT 
       A.organisme_code AS code_organisme, 
       A.etablissement_code AS code_etablissement,
       C.raison_sociale AS raison_sociale,
       B.type_facture_code AS code_type_facture,
       A.facture_medicale_num AS num_facture,
       B.organisme_facture_num AS num_bon,
       B.facture_medicale_date AS date_soins,
       A.facture_medicale_date_reception AS date_reception,
       A.population_num AS num_population,
       D.rgb_num AS num_rgb,
       D.population_nom AS nom,
       D.population_prenoms AS prenoms
FROM 
     tb_factures_medicales_organismes A 
         JOIN tb_factures_medicales B 
             ON A.facture_medicale_num = B.facture_medicale_num 
         JOIN tb_etablissements C 
             ON A.etablissement_code = C.etablissement_code 
         JOIN tb_populations D 
             ON A.population_num = D.population_num
                    AND A.organisme_code = ? 
                    AND (B.organisme_facture_num LIKE ? OR A.facture_medicale_num LIKE ?) 
                    AND (D.rgb_num LIKE ? OR A.population_num LIKE ?) 
                    AND CONCAT(D.population_nom, ' ', D.population_prenoms) LIKE ? 
                    AND A.etablissement_code LIKE ? 
                    AND A.facture_medicale_date_reception IS NOT NULL 
ORDER BY 
         A.date_creation DESC");
        }
        $a->execute(array($code_organisme, '%'.$num_facture.'%', '%'.$num_facture.'%', '%'.$num_population.'%', '%'.$num_population.'%', '%'.$nom_prenoms.'%', '%'.$code_etablissement.'%'));
        return $a->fetchAll();
    }

    public function edition_organisme_facture_etat($code_organisme, $num_facture, $date_reception, $user) {
        $a = $this->getBdd()->prepare("UPDATE tb_factures_medicales_organismes SET facture_medicale_date_reception = ?, date_edition = ?, utilisateur_id_edition = ? WHERE organisme_code = ? AND facture_medicale_num = ?");
        $a->execute(array($date_reception, date('Y-m-d H:i:s', time()), $user, $code_organisme, $num_facture));
        if ($a->errorCode() == "00000") {
            return array(
                "success" => true,
                "message" => 'Enregistrement effectué avec succès'
            );
        } else {
            return array(
                "success" => false,
                "message" => $a->errorInfo()[2]
            );
        }
    }

    public function trouver_organisme_facture($code_organisme, $num_facture) {
        $a = $this->getBdd()->prepare("
SELECT 
       organisme_code AS code_organisme, 
       etablissement_code AS code_etablissement, 
       population_num AS num_population, 
       facture_medicale_num AS num_facture, 
       facture_medicale_date_reception AS date_reception, 
       facture_medicale_date_liquidation AS date_liquidation, 
       facture_medicale_code_statut AS statut, 
       facture_medicale_code_motif_rejet AS code_motif_rejet, 
       date_creation, 
       utilisateur_id_creation, 
       date_edition, 
       utilisateur_id_edition 
FROM 
     tb_factures_medicales_organismes 
WHERE 
      organisme_code = ? 
  AND facture_medicale_num = ?");
        $a->execute(array($code_organisme, $num_facture));
        return $a->fetch();
    }
}
