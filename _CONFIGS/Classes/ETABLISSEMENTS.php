<?php
namespace App;

class ETABLISSEMENTS extends BDD
{
    public function monteur_recherche($niveau, $code, $type_etablissement, $raison_sociale): array
    {
        $query = "
SELECT 
       A.etablissement_code AS code, 
       B.type_etablissement_code AS code_type, 
       B.type_etablissement_libelle AS libelle_type, 
       A.raison_sociale  AS raison_sociale, 
       C.niveau_sanitaire_code AS code_niveau, 
       C.niveau_sanitaire_libelle AS libelle_niveau, 
       A.pays_code AS code_pays, 
       A.region_code AS code_region, 
       A.departement_code AS code_departement, 
       A.commune_code AS code_commune, 
       A.latitude  AS latitude , 
       A.longitude  AS longitude , 
       A.site_web AS site_web, 
       A.secteur_activite_code AS code_secteur_activite, 
       A.adresse_geographique AS adresse_geographique, 
       A.adresse_postale AS adresse_postale, 
       A.date_creation, 
       A.utilisateur_id_creation , 
       A.date_edition, 
       A.utilisateur_id_edition  
FROM 
     tb_etablissements A 
         JOIN tb_etablissements_types B 
             ON A.type_etablissement_code = B.type_etablissement_code 
         JOIN tb_etablissements_niveaux_sanitaires C 
             ON B.niveau_sanitaire_code = C.niveau_sanitaire_code 
                    AND C.niveau_sanitaire_code LIKE ?
                    AND A.etablissement_code LIKE ?
                    AND B.type_etablissement_code LIKE ?
                    AND A.raison_sociale LIKE ? 
ORDER BY 
         A.raison_sociale, A.etablissement_code
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array('%' . $niveau . '%', '%' . $code . '%', '%' . $type_etablissement . '%', '%' . $raison_sociale . '%'));
        return $a->fetchAll();
    }

    public function moteur_recherche_dossiers($code, $code_dossier, $num_rgb, $num_population, $nom_prenoms, $date_debut, $date_fin)
    {
        $a = $this->getBdd()->prepare("
SELECT 
       A.etablissement_code AS code_etablissement, 
       B.raison_sociale,
       A.population_num AS num_population, 
       C.rgb_num AS num_rgb, 
       A.dossier_code AS code_dossier, 
       A.patient_dossier_date_debut AS date_debut, 
       A.patient_dossier_date_fin AS date_fin,
       C.civilite_code AS code_civilite,
       C.population_nom AS nom,
       C.population_prenoms AS prenom,
       C.population_date_naissance AS date_naissance,
       A.date_creation, 
       A.utilisateur_id_creation, 
       A.date_edition, 
       A.utilisateur_id_edition
FROM 
     tb_patients_dossiers A 
         JOIN tb_etablissements B 
             ON A.etablissement_code = B.etablissement_code 
         JOIN tb_populations C 
             ON A.population_num = C.population_num
                    AND A.etablissement_code = ? 
                    AND A.dossier_code LIKE ?
                    AND C.rgb_num LIKE ? 
                    AND A.population_num LIKE ? 
                    AND CONCAT(C.population_nom,' ',C.population_prenoms) LIKE ?
                    AND A.patient_dossier_date_debut BETWEEN ? AND ?
ORDER BY A.date_creation DESC");
        $a->execute(array($code, '%'.$code_dossier.'%', '%'.$num_rgb.'%', '%'.$num_population.'%', '%'.$nom_prenoms.'%', $date_debut, $date_fin));
        return $a->fetchAll();
    }

    public function moteur_recherche_factures($code, $num_facture, $num_rgb, $num_population, $nom_prenoms, $date_debut, $date_fin)
    {
        $a = $this->getBdd()->prepare("
SELECT 
       A.date_creation, 
       A.facture_medicale_num AS num_facture, 
       A.dossier_code AS code_dossier, 
       B.population_num AS num_population,
       C.rgb_num AS num_rgb,
       C.population_prenoms AS prenom,
       C.population_nom AS nom,
       B.specialite_medicale_code AS code_specialite_medicale, 
       B.etablissement_code AS code_etablissement,
       SUM(D.acte_montant_patient) AS montant,
       A.statut_code AS code_statut
FROM tb_factures_medicales A 
    JOIN tb_patients_dossiers B 
        ON A.dossier_code = B.dossier_code 
    JOIN tb_populations C 
        ON B.population_num = C.population_num 
    JOIN tb_factures_medicales_actes D 
        ON A.facture_medicale_num = D.facture_medicale_num
           AND B.etablissement_code = ? 
           AND A.facture_medicale_num LIKE ? 
           AND C.rgb_num LIKE ? 
           AND B.population_num LIKE ? 
           AND CONCAT(C.population_nom, ' ', C.population_prenoms) LIKE ? 
           AND A.date_creation BETWEEN ? AND ? 
GROUP BY 
         A.date_creation,
         A.facture_medicale_num, 
         A.dossier_code, 
         B.population_num,
         C.rgb_num,
         C.population_prenoms,
         C.population_nom,
         B.specialite_medicale_code,
         B.etablissement_code,
         A.statut_code
ORDER BY A.date_creation DESC");
        $a->execute(array($code, '%'.$num_facture.'%', '%'.$num_rgb.'%', '%'.$num_population.'%', '%'.$nom_prenoms.'%', $date_debut, $date_fin));
        return $a->fetchAll();
    }

    public function moteur_recherche_bordereaux($code, $type_facture, $organisme, $date_debut, $date_fin)
    {
        $a = $this->getBdd()->prepare("
SELECT 
       A.bordereau_num AS num_bordereau, 
       A.bordereau_date_debut AS date_debut, 
       A.bordereau_date_fin AS date_fin,
       A.type_facture_code AS code_type_facture, 
       E.type_facture_libelle AS libelle_type_facture, 
       A.organisme_code AS code_organisme,
       D.organisme_libelle AS libelle_organisme,
       COUNT(DISTINCT B.facture_medicale_num) AS nombre_factures,
       COUNT(DISTINCT C.acte_code) AS nombre_actes,
       SUM(C.acte_montant_rgb) AS montant_rgb,
       SUM(C.acte_montant_rc) AS montant_rc
FROM 
     tb_etablissements_bordereaux A 
         JOIN tb_factures_medicales_bordereaux B 
             ON A.bordereau_num = B.bordereau_num 
         JOIN tb_factures_medicales_actes C 
             ON B.facture_medicale_num = C.facture_medicale_num 
         JOIN tb_organismes D 
             ON A.organisme_code = D.organisme_code 
         JOIN tb_ref_types_factures_medicales E 
             ON A.type_facture_code = E.type_facture_code 
                    AND E.type_facture_date_fin IS NULL
                    AND A.etablissement_code = ?
                    AND A.type_facture_code LIKE ?
                    AND A.organisme_code LIKE ?
                    AND A.date_creation BETWEEN ? AND ? 
GROUP BY 
         A.bordereau_num,
         A.bordereau_date_debut,
         A.bordereau_date_fin,
         A.type_facture_code,
         E.type_facture_libelle,
         A.organisme_code,
         D.organisme_libelle 
ORDER BY 
         A.date_creation DESC");
        $a->execute(array($code, '%'.$type_facture.'%', '%'.$organisme.'%', $date_debut, $date_fin));
        return $a->fetchAll();
    }

    public function moteur_recherche_produits($code, $code_produit, $libelle, $nature, $type)
    {
        $a = $this->getBdd()->prepare("
SELECT 
       etablissement_code AS code_etablissement, 
       produit_code AS code_produit, 
       produit_libelle AS libelle, 
       produit_statut_vente AS statut_vente, 
       produit_statut_achat AS statut_achat, 
       produit_statut_perissable AS statut_perissable, 
       produit_description AS description, 
       produit_limite_alerte_stock AS limite_stock, 
       produit_nature AS nature, 
       date_creation, 
       utilisateur_id_creation, 
       date_edition, 
       utilisateur_id_edition 
FROM 
     tb_etablissements_produits 
WHERE 
      etablissement_code = ? AND produit_code LIKE ? AND produit_libelle LIKE ? AND produit_nature LIKE ? AND produit_statut_perissable LIKE ?
ORDER BY 
         produit_libelle");
        $a->execute(array($code, '%'.$code_produit.'%', '%'.$libelle.'%', '%'.$nature.'%', '%'.$type.'%'));
        return $a->fetchAll();
    }

    public function moteur_recherche_commandes($code, $code_commande, $code_fournisseur, $statut, $date_debut, $date_fin)
    {
        $a = $this->getBdd()->prepare("
SELECT 
       A.etablissement_code AS code_etablissement, 
       A.commande_code AS code, 
       A.fournisseur_code AS code_fournisseur, 
       B.fournisseur_libelle AS libelle_fournisseur,
       A.commande_date AS date_commande, 
       A.commande_statut AS statut, 
       SUM(C.commande_prix_unitaire * C.commande_quantite) AS montant
FROM 
     tb_etablissements_commandes A 
         JOIN tb_fournisseurs B 
             ON A.fournisseur_code = B.fournisseur_code 
         JOIN tb_etablissements_commandes_produits C 
             ON A.commande_code = C.commande_code
                    AND A.etablissement_code = ? 
                    AND A.commande_code LIKE ? 
                    AND A.fournisseur_code LIKE ? 
                    AND A.commande_statut LIKE ? 
                    AND A.commande_date BETWEEN ? AND ? 
GROUP BY 
         A.etablissement_code,
         A.commande_code,
         A.fournisseur_code,
         B.fournisseur_libelle,
         A.commande_date,
         A.commande_statut
ORDER BY 
         A.commande_date DESC");
        $a->execute(array($code, '%'.$code_commande.'%', '%'.$code_fournisseur.'%', '%'.$statut.'%', $date_debut, $date_fin));
        return $a->fetchAll();
    }

    public function moteur_recherche_stock($code, $code_produit, $date_debut, $date_fin)
    {
        $a = $this->getBdd()->prepare("
SELECT 
       etablissement_code AS code_etablissement, 
       produit_code AS code, 
       produit_libelle AS libelle, 
       produit_statut_vente AS statut_vente,
       produit_statut_achat AS statut_achat, 
       produit_statut_perissable AS statut_perissable, 
       produit_description AS description, 
       produit_limite_alerte_stock AS limite_alerte_stock, 
       produit_nature AS nature, 
       date_creation, 
       utilisateur_id_creation, 
       date_edition, 
       utilisateur_id_edition 
FROM 
     tb_etablissements_produits 
WHERE 
      etablissement_code = ? AND produit_code LIKE ? ORDER BY produit_libelle");
        $a->execute(array($code, '%'.$code_produit.'%'));
        $produits = $a->fetchAll();
        $nb_produits = count($produits);
        if ($nb_produits !== 0) {
            foreach ($produits as $produit) {
                $prix_achat = 0;
                $prix_vente = 0;

                $effectif_entree = 0;
                $effectif_sortie = 0;

                if ((int)($produit['statut_vente']) === 1) {
                    $c = $this->getBdd()->prepare("SELECT tarif_achat AS prix_achat, tarif_vente AS prix_vente, tarif_date_debut AS date_debut FROM tb_etablissements_produits_tarifs WHERE etablissement_code = ? AND produit_code = ? AND tarif_date_fin IS NULL");
                    $c->execute(array($code, $produit['code']));
                    $tarif = $c->fetch();
                    if ($tarif) {
                        $prix_achat = $tarif['prix_achat'];
                        $prix_vente = $tarif['prix_vente'];
                    }
                }

                $b = $this->getBdd()->prepare("SELECT stock_mouvement AS mouvement, SUM(stock_quantite) AS quantite FROM tb_etablissements_produits_stocks WHERE etablissement_code = ? AND produit_code = ? GROUP BY stock_mouvement");
                $b->execute(array($code, $produit['code']));
                $mouvements = $b->fetchAll();
                $nb_mouvements = count($mouvements);
                if ($nb_mouvements !== 0) {
                    foreach ($mouvements as $mouvement) {
                        if ($mouvement['mouvement'] === 'E') {
                            $effectif_entree = $mouvement['quantite'];
                        } else {
                            $effectif_sortie = $mouvement['quantite'];
                        }
                    }
                    $quantite_restante = (int)($effectif_entree - $effectif_sortie);
                } else {
                    $quantite_restante = 0;
                }

                $json[] = array(
                    'code' => $produit['code'],
                    'libelle' => $produit['libelle'],
                    'statut_vente' => $produit['statut_vente'],
                    'statut_achat' => $produit['statut_achat'],
                    'statut_perissable' => $produit['statut_perissable'],
                    'description' => $produit['description'],
                    'stock_securite' => $produit['limite_alerte_stock'],
                    'nature' => $produit['nature'],
                    'prix_achat' => $prix_achat,
                    'prix_vente' => $prix_vente,
                    'quantite_restante' => $quantite_restante,
                    'date_creation' => $produit['date_creation']
                );
            }
        } else {
            $json = array();
        }
        return $json;
    }

    public function trouver_produit_stock_quantite($code, $code_produit): array
    {
        $b = $this->getBdd()->prepare("SELECT stock_mouvement AS mouvement, SUM(stock_quantite) AS quantite FROM tb_etablissements_produits_stocks WHERE etablissement_code = ? AND produit_code = ? GROUP BY stock_mouvement");
        $b->execute(array($code, $code_produit));
        $mouvements = $b->fetchAll();
        $nb_mouvements = count($mouvements);
        $effectif_entree = 0;
        $effectif_sortie = 0;
        if ($nb_mouvements != 0) {
            foreach ($mouvements as $mouvement) {
                if ($mouvement['mouvement'] === 'E') {
                    $effectif_entree = $mouvement['quantite'];
                } else {
                    $effectif_sortie = $mouvement['quantite'];
                }
            }
            $quantite_restante = (int)($effectif_entree - $effectif_sortie);
        } else {
            $quantite_restante = 0;
        }

        $json = array(
            'code' =>$code_produit,
            'quantite_restante' => $quantite_restante
        );
        return $json;
    }

    public function lister_rendez_vous($code, $num_population, $code_ps, $date)
    {
        $a = $this->getBdd()->prepare("
SELECT 
       A.etablissement_code AS code_etablissement,
       A.population_num AS num_population,
       B.population_nom AS nom,
       B.population_prenoms AS prenom,
       A.professionnel_sante_code AS code_professionnel_sante,
       C.utilisateur_id AS ps_id_user,
       D.utilisateur_nom AS ps_nom,
       D.utilisateur_prenoms AS ps_prenom,
       A.rendez_vous_date AS date,
       A.rendez_vous_heure_debut AS heure_debut,       
       A.rendez_vous_heure_fin AS heure_fin
FROM 
     tb_etablissements_rendez_vous A 
         JOIN tb_populations B 
             ON A.population_num = B.population_num 
         JOIN tb_professionnels_sante C 
             ON A.professionnel_sante_code = C.professionnel_sante_code 
         JOIN tb_utilisateurs D 
             ON C.utilisateur_id = D.utilisateur_id
                    AND A.etablissement_code = ? 
                    AND A.population_num LIKE ? 
                    AND A.professionnel_sante_code LIKE ? 
                    AND rendez_vous_date LIKE ? 
ORDER BY 
         A.rendez_vous_date DESC, 
         A.rendez_vous_heure_debut DESC");
        $a->execute(array($code, '%'.$num_population.'%', '%'.$code_ps.'%', '%'.$date.'%'));
        return $a->fetchAll();
    }

    private function ajouter_rendez_vous($code, $date, $heure_debut, $heure_fin, $num_population, $code_ps, $motif, $user)
    {
        $code_rdv = date('dmYHis', time()).str_pad(date('jnz', time()), 6, '0', STR_PAD_LEFT);
        $a = $this->getBdd()->prepare("INSERT INTO tb_etablissements_rendez_vous(rendez_vous_code, etablissement_code, population_num, professionnel_sante_code, rendez_vous_date, rendez_vous_heure_debut, rendez_vous_heure_fin, rendez_vous_motif, utilisateur_id_creation)
        VALUES(:rendez_vous_code, :etablissement_code, :population_num, :professionnel_sante_code, :rendez_vous_date, :rendez_vous_heure_debut, :rendez_vous_heure_fin, :rendez_vous_motif, :utilisateur_id_creation)");
        $a->execute(array(
            'rendez_vous_code' => $code_rdv,
            'etablissement_code' => $code,
            'population_num' => $num_population,
            'professionnel_sante_code' => $code_ps,
            'rendez_vous_date' => $date,
            'rendez_vous_heure_debut' => $heure_debut,
            'rendez_vous_heure_fin' => $heure_fin,
            'rendez_vous_motif' => $motif,
            'utilisateur_id_creation' => $user
        ));
        if ($a->errorCode() == "00000") {
            return array(
                "success" => true,
                "message" => 'Enregistrement effectué avec succès.'
            );
        } else {
            return array(
                "success" => false,
                "message" => $a->errorInfo()
            );
        }
    }

    private function modifier_rendez_vous($code, $code_rdv, $date, $heure_debut, $heure_fin, $code_ps, $motif, $user):array
    {
        $a = $this->getBdd()->prepare("UPDATE tb_etablissements_rendez_vous SET rendez_vous_date = ?, rendez_vous_heure_debut = ?, rendez_vous_heure_fin = ?, professionnel_sante_code = ?, rendez_vous_motif = ?, date_edition = ?, utilisateur_id_edition = ? WHERE etablissement_code = ? AND rendez_vous_code = ?");
        $a->execute(array($date, $heure_debut, $heure_fin, $code_ps, $motif, date('Y-m-d H:i:s', time()), $user, $code, $code_rdv));
        if ($a->errorCode() == "00000") {
            return array(
                "success" => true,
                "message" => 'Enregistrement effectué avec succès.'
            );
        } else {
            return array(
                "success" => false,
                "message" => $a->errorInfo()
            );
        }
    }

    public function lister_nombre_rendez_vous_ps($code, $date)
    {
        $a = $this->getBdd()->prepare("
SELECT 
       A.professionnel_sante_code AS code_professionnel_sante, 
       C.utilisateur_nom AS nom,
       C.utilisateur_prenoms AS prenom,
       COUNT(A.rendez_vous_code) AS nombre 
FROM 
     tb_etablissements_rendez_vous A 
         JOIN tb_professionnels_sante B 
             ON A.professionnel_sante_code = B.professionnel_sante_code 
         JOIN tb_utilisateurs C 
             ON B.utilisateur_id = C.utilisateur_id
                    AND A.etablissement_code = ? 
                    AND A.rendez_vous_date = ? 
GROUP BY 
         A.professionnel_sante_code, 
         C.utilisateur_nom, 
         C.utilisateur_prenoms");
        $a->execute(array($code, $date));
        return $a->fetchAll();
    }

    public function trouver_rendez_vous($code, $code_rdv)
    {
        $a = $this->getBdd()->prepare("
SELECT 
       A.rendez_vous_code AS code, 
       A.etablissement_code AS code_etablissement, 
       A.population_num AS num_population, 
       B.population_nom AS nom,
       B.population_prenoms AS prenom,
       A.professionnel_sante_code AS code_professionnel_sante,
       D.utilisateur_nom AS nom_professionnel_sante,
       D.utilisateur_prenoms AS prenom_professionnel_sante,
       A.rendez_vous_date AS date, 
       A.rendez_vous_heure_debut AS heure_debut, 
       A.rendez_vous_heure_fin AS heure_fin, 
       A.rendez_vous_motif AS motif_demande 
FROM 
     tb_etablissements_rendez_vous A 
         JOIN tb_populations B 
             ON A.population_num = B.population_num 
         JOIN tb_professionnels_sante C 
             ON A.professionnel_sante_code = C.professionnel_sante_code 
         JOIN tb_utilisateurs D 
             ON C.utilisateur_id = D.utilisateur_id
                    AND A.etablissement_code = ? 
                    AND A.rendez_vous_code = ?");
        $a->execute(array($code, $code_rdv));
        return $a->fetch();
    }

    public function editer_rendez_vous($code, $code_rdv, $date, $heure_debut, $heure_fin, $num_population, $code_ps, $motif, $user)
    {
        $rdv = $this->trouver_rendez_vous($code, $code_rdv);
        if ($rdv) {
            return $this->modifier_rendez_vous($code, $code_rdv, $date, $heure_debut, $heure_fin, $code_ps, $motif, $user);
        } else {
            return $this->ajouter_rendez_vous($code, $date, $heure_debut, $heure_fin, $num_population, $code_ps, $motif, $user);
        }
    }

    public function moteur_recherche_ecritures_comptables($code, $num_piece, $libelle, $date_debut, $date_fin)
    {
        $a = $this->getBdd()->prepare("
SELECT 
       depense_recette_type AS type,
       depense_recette_num AS num_piece,
       organisme_code AS code_organisme,
       facture_medicale_num AS num_facture,
       depense_recette_libelle AS libelle,
       depense_recette_montant AS montant,
       date_creation
FROM 
     tb_etablissements_depenses_recettes 
WHERE 
      etablissement_code = ? 
  AND depense_recette_num LIKE ? 
  AND depense_recette_libelle LIKE ? 
  AND date_creation BETWEEN ? AND ? 
ORDER BY date_creation DESC");
        $a->execute(array($code, '%'.$num_piece.'%', '%'.$libelle.'%', $date_debut, $date_fin));
        return $a->fetchAll();
    }

    public function lister_utilisateurs($code)
    {
        $query = "
SELECT 
       A.etablissement_code AS code, 
       A.utilisateur_id AS id_user, 
       A.utilisateur_etablissement_date_debut AS date_debut,
       B.utilisateur_num_secu AS num_secu,
       B.civilite_code AS code_civilite,
       B.utilisateur_nom AS nom,
       B.utilisateur_nom_patronymique AS nom_patronymique,
       B.utilisateur_prenoms AS prenoms,
       B.utilisateur_email AS email,
       B.utilisateur_date_naissance AS date_naissance,
       B.sexe_code AS code_sexe,
       A.date_creation,
       A.utilisateur_id_creation
FROM
     tb_utilisateurs_etablissements A 
         JOIN tb_utilisateurs B 
             ON A.utilisateur_id = B.utilisateur_id 
                    AND A.etablissement_code LIKE ? 
                    AND A.utilisateur_etablissement_date_fin IS NULL
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        return $a->fetchAll();
    }

    public function trouver_utilisateur($code, $id_user)
    {
        $query = "
SELECT 
       A.etablissement_code AS code, 
       A.utilisateur_id AS id_user, 
       A.utilisateur_etablissement_date_debut AS date_debut,
       B.utilisateur_num_secu AS num_secu,
       B.civilite_code AS code_civilite,
       B.utilisateur_nom AS nom,
       B.utilisateur_nom_patronymique AS nom_patronymique,
       B.utilisateur_prenoms AS prenoms,
       B.utilisateur_email AS email,
       B.utilisateur_date_naissance AS date_naissance,
       B.sexe_code AS code_sexe,
       B.utilisateur_photo AS photo,
       A.date_creation,
       A.utilisateur_id_creation
FROM
     tb_utilisateurs_etablissements A 
         JOIN tb_utilisateurs B 
             ON A.utilisateur_id = B.utilisateur_id 
                    AND A.etablissement_code = ? 
                    AND A.utilisateur_id = ? 
                    AND A.utilisateur_etablissement_date_fin IS NULL
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code, $id_user));
        return $a->fetch();
    }

    public function lister_coordonnees($code_etablissemnt)
    {
        $query = "
SELECT 
       A.etablissement_code AS code_ets,
       A.type_coordonnee_code AS code_type,
       A.coordonnee_valeur AS valeur,
       B.type_coordonnee_libelle AS libelle,
       A.coordonnee_date_debut AS date_debut,
       A.utilisateur_id_creation
FROM
     tb_etablissements_coordonnees A JOIN  tb_ref_types_coordonnees B
     ON A.type_coordonnee_code = B.type_coordonnee_code
WHERE etablissement_code LIKE ? AND
      coordonnee_date_fin IS NULL
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code_etablissemnt));
        $json = $a->fetchAll();
        return $json;
    }

    public function lister_servies($code_etablissemnt)
    {
        $query = "
SELECT 
       A.etablissement_code AS code_ets,
       A.etablissement_service_code AS code,
       B.etablissement_service_libelle AS libelle,
       A.etablissement_service_date_debut AS date_debut,
       A.utilisateur_id_creation
FROM
     tb_etablissements_services A 
         JOIN tb_ref_etablissements_services B 
             ON A.etablissement_service_code = B.etablissement_service_code
                    AND A.etablissement_code LIKE ? 
                    AND A.etablissement_service_date_fin IS NULL
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code_etablissemnt));
        return $a->fetchAll();
    }

    public function editer_type_ets($code_niveau, $code, $libelle, $user): array
    {
        $typetablissement = $this->trouver_type_ets($code);
        if ($typetablissement) {
            $date_fin = date('Y-m-d', strtotime('-1 day', time()));
            if (strtotime($date_fin) > strtotime($typetablissement['date_debut'])) {
                $edition = $this->fermer_type_ets($typetablissement['code'], $date_fin, $user);
                if ($edition['success'] == true) {
                    $json = $this->ajouter_type_ets($code_niveau, $code, $libelle, $user);
                } else {
                    $json = $edition;
                }
            } else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le " . date('d/m/Y', strtotime('+2 day', strtotime($typetablissement['date_debut'])))
                );
            }
        } else {
            $json = $this->ajouter_type_ets($code_niveau, $code, $libelle, $user);
        }
        return $json;
    }

    public function trouver_type_ets($code)
    {
        $query = "
SELECT 
       niveau_sanitaire_code AS code_niveau,
       type_etablissement_code AS code,
       type_etablissement_libelle AS libelle,
       type_etablissement_date_debut AS date_debut,
       utilisateur_id_creation
FROM
     tb_etablissements_types
WHERE
      type_etablissement_code LIKE ? AND 
      type_etablissement_date_fin IS NULL
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        return $a->fetch();
    }

    private function fermer_type_ets($code, $date_fin, $user): array
    {
        $a = $this->getBdd()->prepare("UPDATE tb_etablissements_types  SET type_etablissement_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE type_etablissement_code = ? AND type_etablissement_date_fin IS NULL");
        $a->execute(array($date_fin, date('Y-m-d H:i:s', time()), $user, $code));
        if ($a->errorCode() == "00000") {
            return array(
                "success" => true,
                "message" => 'Enregistrement effectué avec succès.'
            );
        } else {
            return array(
                "success" => false,
                "message" => $a->errorInfo()
            );
        }
    }

    private function ajouter_type_ets($code_niveau, $code, $libelle, $user): array
    {
        if (!$code) {
            $types = $this->lister_types_ets();
            $nb_types = count($types);
            $code = str_pad(intval($nb_types + 1), 3, '0', STR_PAD_LEFT);
        }
        $a = $this->getBdd()->prepare("INSERT INTO tb_etablissements_types(niveau_sanitaire_code,type_etablissement_code,type_etablissement_libelle,type_etablissement_date_debut,utilisateur_id_creation)
        VALUES(:niveau_sanitaire_code,:type_etablissement_code,:type_etablissement_libelle,:type_etablissement_date_debut,:utilisateur_id_creation) 
        ");
        $a->execute(array(
            'niveau_sanitaire_code' => $code_niveau,
            'type_etablissement_code' => $code,
            'type_etablissement_libelle' => $libelle,
            'type_etablissement_date_debut' => date('Y-m-d H:i:s', time()),
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
                "message" => $a->errorInfo()
            );
        }
    }

    public function lister_types_ets()
    {
        $query = "
SELECT 
       A.niveau_sanitaire_code AS code_niveau,
       B.niveau_sanitaire_libelle AS libelle_niveau,
       A.type_etablissement_code AS code, 
       A.type_etablissement_libelle AS libelle, 
       A.type_etablissement_date_debut AS date_debut, 
       A.date_creation, 
       A.utilisateur_id_creation
FROM 
     tb_etablissements_types A 
         JOIN tb_etablissements_niveaux_sanitaires B 
             ON A.niveau_sanitaire_code = B.niveau_sanitaire_code 
                    AND A.type_etablissement_date_fin IS NULL
ORDER BY A.type_etablissement_libelle
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array());
        return $a->fetchAll();
    }

    public function lister_types()
    {
        $a = $this->getBdd()->prepare("SELECT A.type_etablissement_code AS code, B.type_etablissement_libelle AS libelle, COUNT(A.type_etablissement_code) AS nombre FROM tb_etablissements A JOIN tb_etablissements_types B ON A.type_etablissement_code = B.type_etablissement_code AND B.type_etablissement_date_fin IS NULL GROUP BY A.type_etablissement_code, B.type_etablissement_libelle");
        $a->execute(array());
        return $a->fetchAll();
    }

    public function lister_niveaux()
    {
        $a = $this->getBdd()->prepare("SELECT A.niveau_sanitaire_code AS code, B.niveau_sanitaire_libelle AS libelle, COUNT(A.niveau_sanitaire_code) AS nombre FROM tb_etablissements_types A JOIN tb_etablissements_niveaux_sanitaires B ON A.niveau_sanitaire_code = B.niveau_sanitaire_code AND B.niveau_sanitaire_date_fin IS NULL GROUP BY A.niveau_sanitaire_code, B.niveau_sanitaire_libelle");
        $a->execute(array());
        return $a->fetchAll();
    }

    public function editer($code, $type_ets, $raison_sociale, $code_pays, $code_region, $code_departement, $code_commune, $latitude, $longitude, $code_secteur_activite, $adresse_geographique, $adresse_postale, $user): array
    {
        $etablissement = $this->trouver($code, null);
        if ($etablissement) {
            $json = $this->modifier($code, $type_ets, $raison_sociale, $code_pays, $code_region, $code_departement, $code_commune, $latitude, $longitude, $code_secteur_activite, $adresse_geographique, $adresse_postale, $user);
        } else {
            $json = $this->ajouter($code, $type_ets, $raison_sociale, $code_pays, $code_region, $code_departement, $code_commune, $latitude, $longitude, $code_secteur_activite, $adresse_geographique, $adresse_postale, $user);
        }
        return $json;
    }

    public function trouver($code, $raison_sociale)
    {
        $query = "
SELECT
       A.etablissement_code AS code, 
       A.type_etablissement_code AS type, 
       B.type_etablissement_libelle AS libelle, 
       A.raison_sociale  AS raison_sociale, 
       A.niveau_code AS niveau_sanitaire, 
       A.pays_code AS code_pays, 
       A.region_code AS code_region, 
       A.departement_code AS code_departement, 
       A.commune_code AS code_commune, 
       F.commune_nom AS commune, 
       E.departement_nom AS departement, 
       D.region_nom AS region, 
       C.pays_nom AS pays, 
       C.pays_indicatif_telephonique AS indicatif_telephonique, 
       A.latitude  AS latitude , 
       A.longitude  AS longitude , 
       A.site_web AS site_web, 
       A.secteur_activite_code AS code_secteur_activite, 
       A.adresse_geographique AS adresse_geographique, 
       A.adresse_postale AS adresse_postale, 
       A.etablissement_logo AS logo, 
       C.monnaie_code AS code_monnaie,
       G.monnaie_libelle AS libelle_monnaie,
       A.date_creation, 
       A.utilisateur_id_creation, 
       A.date_edition, 
       A.utilisateur_id_edition 
FROM
     tb_etablissements A 
         JOIN tb_etablissements_types B 
             ON  A.type_etablissement_code = B.type_etablissement_code 
         JOIN tb_ref_geo_pays C 
             ON A.pays_code = C.pays_code 
         JOIN tb_ref_geo_regions D 
             ON A.region_code = D.region_code 
         JOIN tb_ref_geo_departements E 
             ON A.departement_code = E.departement_code 
         JOIN tb_ref_geo_communes F 
             ON A.commune_code = F.commune_code 
         JOIN tb_ref_monnaies G 
             ON C.monnaie_code = G.monnaie_code
                    AND A.etablissement_code LIKE ? 
                    AND A.raison_sociale LIKE ? 
                    AND B.type_etablissement_date_fin IS NULL
                    AND C.pays_date_fin IS NULL
                    AND D.region_date_fin IS NULL
                    AND E.departement_date_fin IS NULL
                    AND F.commune_date_fin IS NULL
                    AND G.monnaie_date_fin IS NULL
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code, '%' . $raison_sociale . '%'));
        return $a->fetch();
    }

    private function modifier($code, $type_ets, $raison_sociale, $code_pays, $code_region, $code_departement, $code_commune, $latitude, $longitude, $code_secteur_activite, $adresse_geographique, $adresse_postale, $user): array
    {
        $a = $this->getBdd()->prepare("UPDATE tb_etablissements  SET type_etablissement_code = ?, raison_sociale = ?, pays_code = ?, region_code = ?, departement_code = ?, commune_code = ?, latitude = ?, longitude = ?, secteur_activite_code = ?, adresse_geographique = ?, adresse_postale = ?, date_edition = ?, utilisateur_id_edition = ? WHERE etablissement_code = ?");
        $a->execute(array($type_ets, $raison_sociale, $code_pays, $code_region, $code_departement, $code_commune, $latitude, $longitude, $code_secteur_activite, $adresse_geographique, $adresse_postale, date('Y-m-d H:i:s', time()), $user, $code));
        if ($a->errorCode() == "00000") {
            return array(
                "success" => true,
                "code" => $code,
                "message" => 'Enregistrement effectué avec succès.'
            );
        } else {
            return array(
                "success" => false,
                "message" => $a->errorInfo()
            );
        }
    }

    private function ajouter($code, $type_ets, $raison_sociale, $code_pays, $code_region, $code_departement, $code_commune, $latitude, $longitude, $code_secteur_activite, $adresse_geographique, $adresse_postale, $user): array
    {
        if (!$code) {
            $etablissements = $this->lister(null, null);
            $nb_etablissements = count($etablissements);
            $code = substr($code_commune, 1, 4).str_pad(intval($nb_etablissements + 1), 5, '0', STR_PAD_LEFT);
        }
        $a = $this->getBdd()->prepare("INSERT INTO tb_etablissements(etablissement_code, type_etablissement_code, raison_sociale, pays_code, region_code, departement_code, commune_code, latitude, longitude, secteur_activite_code, adresse_geographique, adresse_postale, utilisateur_id_creation)
        VALUES(:etablissement_code, :type_etablissement_code, :raison_sociale, :pays_code, :region_code, :departement_code, :commune_code, :latitude, :longitude, :secteur_activite_code, :adresse_geographique, :adresse_postale, :utilisateur_id_creation) 
        ");
        $a->execute(array(
            'etablissement_code' => $code,
            'type_etablissement_code' => $type_ets,
            'raison_sociale' => $raison_sociale,
            'pays_code' => $code_pays,
            'region_code' => $code_region,
            'departement_code' => $code_departement,
            'commune_code' => $code_commune,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'secteur_activite_code' => $code_secteur_activite,
            'adresse_geographique' => $adresse_geographique,
            'adresse_postale' => $adresse_postale,
            'utilisateur_id_creation' => $user
        ));
        if ($a->errorCode() == "00000") {
            $edition_statut = $this->ajouter_statut($code, 1, $user);
            if ($edition_statut['success'] == true) {
                return array(
                    "success" => true,
                    "code" => $code,
                    "message" => 'Enregistrement effectué avec succès'
                );
            } else {
                return $edition_statut;
            }
        } else {
            return array(
                "success" => false,
                "message" => $a->errorInfo()
            );
        }
    }

    public function lister($code, $raison_sociale)
    {
        $query = "
SELECT 
        A.etablissement_code AS code, 
        A.type_etablissement_code AS type, 
       A.raison_sociale  AS raison_sociale, 
       A.niveau_code AS niveau_sanitaire, 
       A.pays_code AS code_pays, 
       A.region_code AS code_region, 
       A.departement_code AS code_departement, 
       A.commune_code AS code_commune, 
       A.latitude  AS latitude , 
       A.site_web AS site_web, 
       A.secteur_activite_code AS code_secteur_activite, 
       A.adresse_geographique AS adresse_geographique, 
       A.adresse_postale AS adresse_postale, 
       A.date_creation, 
       A.utilisateur_id_creation, 
       A.date_edition, 
       A.utilisateur_id_edition 
FROM 
     tb_etablissements A
WHERE 
      A.etablissement_code LIKE ? 
  AND A.raison_sociale LIKE ? 
ORDER BY A.raison_sociale
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array('%' . $code . '%', '%' . $raison_sociale . '%'));
        return $a->fetchAll();
    }

    private function ajouter_statut($code_etablissement, $statut, $user): array
    {
        $a = $this->getBdd()->prepare("INSERT INTO tb_etablissements_statuts(etablissement_code, statut, statut_date_debut, utilisateur_id_creation)
            VALUES(:etablissement_code, :statut, :statut_date_debut, :utilisateur_id_creation)");
        $a->execute(array(
            'etablissement_code' => $code_etablissement,
            'statut' => $statut,
            'statut_date_debut' => date('Y-m-d', time()),
            'utilisateur_id_creation' => $user
        ));
        if ($a->errorCode() == "00000") {
            return array(
                'success' => true
            );
        } else {
            return array(
                'success' => false,
                'erreur_message' => $a->errorInfo()
            );
        }
    }

    public function editer_niveau_sanitaire($code, $libelle, $niveau, $user): array
    {
        $niveau_sanitaire = $this->trouver_niveau_sanitaire($code);
        if ($niveau_sanitaire) {
            $date_fin = date('Y-m-d', strtotime('-1 day', time()));
            if (strtotime($date_fin) > strtotime($niveau_sanitaire['date_debut'])) {
                $edition = $this->fermer_niveau_sanitaire($niveau_sanitaire['code'], $date_fin, $user);
                if ($edition['success'] == true) {
                    $json = $this->ajouter_niveau_sanitaire($code, $libelle, $niveau, $user);
                } else {
                    $json = $edition;
                }
            } else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le " . date('d/m/Y', strtotime('+2 day', strtotime($niveau_sanitaire['date_debut'])))
                );
            }
        } else {
            $json = $this->ajouter_niveau_sanitaire($code, $libelle, $niveau, $user);
        }
        return $json;
    }

    public function trouver_niveau_sanitaire($code)
    {
        $query = "
SELECT 
       niveau_sanitaire_code AS code,
       niveau_sanitaire_libelle AS libelle,
       niveau AS niveau,
       niveau_sanitaire_date_debut AS date_debut,
       utilisateur_id_creation
FROM
     tb_etablissements_niveaux_sanitaires
WHERE
      niveau_sanitaire_code LIKE ? AND 
      niveau_sanitaire_date_fin IS NULL
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        return $a->fetch();
    }

    private function fermer_niveau_sanitaire($code, $date_fin, $user): array
    {
        $a = $this->getBdd()->prepare("UPDATE tb_etablissements_niveaux_sanitaires SET niveau_sanitaire_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE niveau_sanitaire_code = ? AND niveau_sanitaire_date_fin IS NULL");
        $a->execute(array($date_fin, date('Y-m-d H:i:s', time()), $user, $code));
        if ($a->errorCode() == "00000") {
            return array(
                "success" => true,
                "message" => 'Enregistrement effectué avec succès.'
            );
        } else {
            return array(
                "success" => false,
                "message" => $a->errorInfo()
            );
        }
    }

    private function ajouter_niveau_sanitaire($code, $libelle, $niveau, $user): array
    {
        if (!$code) {
            $niveaux = $this->lister_niveaux_sanitaires();
            $nb_niveaux = count($niveaux);
            $code = str_pad(intval($nb_niveaux + 1), '3', '0', STR_PAD_LEFT);
        }
        $a = $this->getBdd()->prepare("INSERT INTO tb_etablissements_niveaux_sanitaires(niveau_sanitaire_code,niveau_sanitaire_libelle,niveau,niveau_sanitaire_date_debut,utilisateur_id_creation)
        VALUES(:niveau_sanitaire_code, :niveau_sanitaire_libelle,:niveau, :niveau_sanitaire_date_debut, :utilisateur_id_creation) 
        ");
        $a->execute(array(
            'niveau_sanitaire_code' => $code,
            'niveau_sanitaire_libelle' => $libelle,
            'niveau' => $niveau,
            'niveau_sanitaire_date_debut' => date('Y-m-d H:i:s', time()),
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
                "message" => $a->errorInfo()
            );
        }
    }

    public function lister_niveaux_sanitaires()
    {
        $query = "
SELECT 
      niveau_sanitaire_code AS code,
       niveau_sanitaire_libelle AS libelle,
       niveau AS niveau,
       niveau_sanitaire_date_debut AS date_debut,
       utilisateur_id_creation
FROM
     tb_etablissements_niveaux_sanitaires
WHERE
      niveau_sanitaire_date_fin IS NULL
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array());
        $json = $a->fetchAll();
        return $json;
    }

    public function editer_coordonnee($code, $type, $valeur, $user): array
    {
        $coordonnee = $this->trouver_coordonnee($code, $type);
        if ($coordonnee) {
            $date_fin = date('Y-m-d', strtotime('-1 day', time()));
            if (strtotime($date_fin) > strtotime($coordonnee['date_debut'])) {
                $edition = $this->fermer_coordonnee($coordonnee['code'], $date_fin, $user);
                if ($edition['success'] == true) {
                    $json = $this->ajouter_coordonnee($code, $type, $valeur, $user);
                } else {
                    $json = $edition;
                }
            } else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le " . date('d/m/Y', strtotime('+2 day', strtotime($coordonnee['date_debut'])))
                );
            }
        } else {
            $json = $this->ajouter_coordonnee($code, $type, $valeur, $user);
        }
        return $json;
    }

    public function trouver_coordonnee($code, $type)
    {
        $query = "
SELECT 
       etablissement_code AS code,
       type_coordonnee_code AS type,
       coordonnee_valeur AS valeur,
       coordonnee_date_debut AS date_debut,
       utilisateur_id_creation
FROM
     tb_etablissements_coordonnees
WHERE
      etablissement_code LIKE ? AND 
      type_coordonnee_code LIKE ? AND 
      coordonnee_date_fin IS NULL
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code, $type));
        return $a->fetch();
    }

    private function fermer_coordonnee($code, $date_fin, $user): array
    {
        $a = $this->getBdd()->prepare("UPDATE tb_etablissements_coordonnees SET coordonnee_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE etablissement_code = ? AND coordonnee_date_fin IS NULL");
        $a->execute(array($date_fin, date('Y-m-d H:i:s', time()), $user, $code));
        if ($a->errorCode() == "00000") {
            return array(
                "success" => true,
                "message" => 'Enregistrement effectué avec succès.'
            );
        } else {
            return array(
                "success" => false,
                "message" => $a->errorInfo()
            );
        }
    }

    private function ajouter_coordonnee($code, $type, $valeur, $user): array
    {
        $a = $this->getBdd()->prepare("INSERT INTO tb_etablissements_coordonnees(etablissement_code,type_coordonnee_code,coordonnee_valeur,coordonnee_date_debut,utilisateur_id_creation)
        VALUES(:etablissement_code,:type_coordonnee_code,:coordonnee_valeur,:coordonnee_date_debut, :utilisateur_id_creation) 
        ");
        $a->execute(array(
            'etablissement_code' => $code,
            'type_coordonnee_code' => $type,
            'coordonnee_valeur' => $valeur,
            'coordonnee_date_debut' => date('Y-m-d H:i:s', time()),
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
                "message" => $a->errorInfo()
            );
        }
    }

    public function editer_service($code_etablissement, $code_service, $user): array
    {
        $service = $this->trouver_service($code_etablissement, $code_service);
        if ($service) {
            $date_fin = date('Y-m-d', strtotime('-1 day', time()));
            if (strtotime($date_fin) > strtotime($service['date_debut'])) {
                $edition = $this->fermer_service($code_etablissement, $service['code'], $date_fin, $user);
                if ($edition['success'] == true) {
                    $json = $this->ajouter_service($code_etablissement, $code_service, $user);
                } else {
                    $json = $edition;
                }
            } else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le " . date('d/m/Y', strtotime('+2 day', strtotime($service['date_debut'])))
                );
            }
        } else {
            $json = $this->ajouter_service($code_etablissement, $code_service, $user);
        }
        return $json;
    }

    public function trouver_service($code_etablissement, $code_service)
    {
        $query = "
SELECT 
       A.etablissement_code AS code_ets,
       A.etablissement_service_code AS code,
       B.etablissement_service_libelle AS libelle,
       A.etablissement_service_date_debut AS date_debut,
       A.utilisateur_id_creation
FROM
     tb_etablissements_services A 
         JOIN tb_ref_etablissements_services B 
             ON A.etablissement_service_code = B.etablissement_service_code
                    AND A.etablissement_code LIKE ? 
                    AND A.etablissement_service_code LIKE ? 
                    AND A.etablissement_service_date_fin IS NULL
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code_etablissement, $code_service));
        return $a->fetch();
    }

    public function fermer_service($code_ets, $code, $date_fin, $user): array
    {
        $a = $this->getBdd()->prepare("UPDATE tb_etablissements_services SET etablissement_service_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE etablissement_code = ? AND etablissement_service_code = ? AND etablissement_service_date_fin IS NULL");
        $a->execute(array($date_fin, date('Y-m-d H:i:s', time()), $user, $code_ets, $code));
        if ($a->errorCode() == "00000") {
            return array(
                "success" => true,
                "message" => 'Enregistrement effectué avec succès.'
            );
        } else {
            return array(
                "success" => false,
                "message" => $a->errorInfo()
            );
        }
    }

    private function ajouter_service($code_etablissement, $service, $user): array
    {
        $a = $this->getBdd()->prepare("INSERT INTO tb_etablissements_services(etablissement_code, etablissement_service_code, etablissement_service_date_debut, utilisateur_id_creation)
        VALUES(:etablissement_code, :etablissement_service_code, :etablissement_service_date_debut, :utilisateur_id_creation) 
        ");
        $a->execute(array(
            'etablissement_code' => $code_etablissement,
            'etablissement_service_code' => $service,
            'etablissement_service_date_debut' => date('Y-m-d H:i:s', time()),
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
                "message" => $a->errorInfo()
            );
        }
    }

    public function editer_type_etablissement($code_etablissement, $code_type, $user): array
    {
        $etablissement = $this->trouver($code_etablissement, null);
        if ($etablissement) {
            $a = $this->getBdd()->prepare("UPDATE tb_etablissements SET type_etablissement_code  = ?, date_edition = ?, utilisateur_id_edition = ? WHERE etablissement_code = ?");
            $a->execute(array($code_type, date('Y-m-d H:i:s', time()), $user, $code_etablissement));
            if ($a->errorCode() == "00000") {
                return array(
                    'success' => true,
                    'message' => "Mise à jour effectuée avec succès"
                );
            } else {
                return array(
                    'success' => false,
                    'erreur_message' => $a->errorInfo()
                );
            }
        } else {
            return array(
                'success' => false,
                'message' => "Etablissement inconnu"
            );
        }
    }

    public function lister_historique_niveau_sanitaire($code)
    {
        $query = "
SELECT 
       A.niveau_sanitaire_code AS code,
       A.niveau_sanitaire_libelle AS libelle,
       A.niveau_sanitaire_date_debut AS date_debut,
       A.niveau_sanitaire_date_fin AS date_fin,
       A.utilisateur_id_creation,
       A.date_creation,
       B.utilisateur_nom AS nom,
       B.utilisateur_prenoms AS prenoms
FROM
     tb_etablissements_niveaux_sanitaires A JOIN tb_utilisateurs B 
         ON 
             A.utilisateur_id_creation = B.utilisateur_id AND A.niveau_sanitaire_code LIKE ?
ORDER BY 
         A.date_creation DESC
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        $json = $a->fetchAll();
        return $json;
    }

    public function lister_historique_type_ets($code)
    {
        $query = "
SELECT 
       A.niveau_sanitaire_code AS code_niveau,
       A.type_etablissement_code AS code, 
       A.type_etablissement_libelle AS libelle, 
       B.utilisateur_nom AS nom,
       B.utilisateur_prenoms AS prenoms, 
       A.type_etablissement_date_debut AS date_debut, 
       A.type_etablissement_date_fin AS date_fin, 
       A.date_creation, 
       A.utilisateur_id_creation
FROM 
     tb_etablissements_types A JOIN tb_utilisateurs B 
         ON 
             A.utilisateur_id_creation = B.utilisateur_id AND A.type_etablissement_code LIKE ?
ORDER BY 
         A.date_creation DESC
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array('%' . $code . '%'));
        return $a->fetchAll();
    }

    public function editer_utilisateur($id_user, $code, $user): array
    {
        $utilisateur = $this->trouver_utilisateur($code, $id_user);
        if ($utilisateur) {
            $date_fin = date('Y-m-d', time());
            return $this->fermer_utilisateur($id_user, $code, $date_fin, $user);
        } else {
            return $this->ajouter_utilisateur($id_user, $code, $user);
        }
    }

    public function fermer_utilisateur($id_user, $code, $date_fin, $user): array
    {
        $a = $this->getBdd()->prepare("UPDATE tb_utilisateurs_etablissements SET utilisateur_etablissement_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE etablissement_code = ? AND utilisateur_id = ? AND utilisateur_etablissement_date_fin IS NULL");
        $a->execute(array($date_fin, date('Y-m-d H:i:s', time()), $user, $code, $id_user));
        if ($a->errorCode() == '00000') {
            return array(
                'success' => true
            );
        } else {
            return array(
                'success' => false,
                'code' => $a->errorCode(),
                'message' => $a->errorInfo()[2]
            );
        }
    }

    public function ajouter_utilisateur($id_user, $code, $user): array
    {
        $a = $this->getBdd()->prepare("INSERT INTO tb_utilisateurs_etablissements(utilisateur_id, etablissement_code, utilisateur_etablissement_date_debut, utilisateur_id_creation) 
        VALUES(:utilisateur_id, :etablissement_code, :utilisateur_etablissement_date_debut, :utilisateur_id_creation)");
        $a->execute(array(
            'utilisateur_id' => $id_user,
            'etablissement_code' => $code,
            'utilisateur_etablissement_date_debut' => date('Y-m-d H:i:s', time()),
            'utilisateur_id_creation' => $user
        ));
        if ($a->errorCode() == '00000') {
            return array(
                'success' => true
            );
        } else {
            return array(
                'success' => false,
                'code' => $a->errorCode(),
                'message' => $a->errorInfo()[2]
            );
        }
    }

    public function editer_patient($code_ets, $num_population, $user): array
    {
        $patient = $this->trouver_patient($code_ets, $num_population);
        if ($patient) {
            $date_fin = date('Y-m-d', strtotime('-1 day', time()));
            if (strtotime($date_fin) > strtotime($patient['date_debut'])) {
                $edition = $this->fermer_patient($patient['code_ets'], $num_population, $date_fin, $user);
                if ($edition['success'] == true) {
                    $json = $this->ajouter_patient($code_ets, $num_population, $user);
                } else {
                    $json = $edition;
                }
            } else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le ".date('d/m/Y', strtotime('+2 day', strtotime($patient['date_debut'])))
                );
            }
        } else {
            $json = $this->ajouter_patient($code_ets, $num_population, $user);
        }
        return $json;
    }

    public function trouver_patient($code_ets, $num_population)
    {
        $query = "
SELECT 
       A.etablissement_code AS code_ets,
       A.population_num AS num_population,
       B.rgb_num AS num_rgb,
       B.civilite_code AS code_civilite,
       B.population_nom AS nom,
       B.population_nom_patronymique AS nom_patronymique,
       B.population_prenoms AS prenom,
       B.population_date_naissance AS date_naissance, 
       B.sexe_code AS code_sexe, 
       B.situation_familiale_code AS code_situation_familiale,
       B.profession_code AS code_profession,
       B.categorie_socio_professionnelle_code AS code_csp,
       B.residence_pays_code AS code_pays_residence,
       B.residence_region_code AS code_region_residence,
       B.residence_departement_code AS code_departement_residence,
       B.residence_commune_code AS code_commune_residence,
       B.residence_adresse_postale AS adresse_postale,
       B.residence_adresse_geographique AS adresse_geographique,
       B.groupe_sanguin_code AS code_groupe_sanguin,
       B.rhesus_code AS code_rhesus,
       B.population_photo AS photo,
       A.etablissement_patient_date_debut AS date_debut
FROM 
     tb_etablissements_patients A 
         JOIN tb_populations B 
             ON A.population_num = B.population_num 
                    AND A.etablissement_patient_date_fin IS NULL 
                    AND A.etablissement_code = ? 
                    AND A.population_num = ?";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code_ets, $num_population));
        return $a->fetch();
    }

    private function fermer_patient($code_ets, $num_population, $date_fin, $user): array
    {
        $a = $this->getBdd()->prepare("UPDATE tb_etablissements_patients SET etablissement_patient_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE etablissement_code = ? AND population_num = ? AND etablissement_patient_date_fin IS NULL");
        $a->execute(array($date_fin, date('Y-m-d H:i:s', time()), $user, $code_ets, $num_population));

        if ($a->errorCode() == '00000') {
            return array(
                'success' => true
            );
        } else {
            return array(
                'success' => false,
                'code' => $a->errorCode(),
                'message' => $a->errorInfo()[2]
            );
        }
    }

    private function ajouter_patient($code_ets, $num_population, $user): array
    {
        $a = $this->getBdd()->prepare("INSERT INTO tb_etablissements_patients(etablissement_code, population_num, etablissement_patient_date_debut, utilisateur_id_creation) VALUES(:etablissement_code, :population_num, :etablissement_patient_date_debut, :utilisateur_id_creation)");
        $a->execute(array(
            'etablissement_code' => $code_ets,
            'population_num' => $num_population,
            'etablissement_patient_date_debut' => date('Y-m-d', time()),
            'utilisateur_id_creation' => $user
        ));
        if ($a->errorCode() == '00000') {
            return array(
                'success' => true
            );
        } else {
            return array(
                'success' => false,
                'code' => $a->errorCode(),
                'message' => $a->errorInfo()[2]
            );
        }
    }

    public function moteur_recherche_patient($code_ets, $num_population, $num_rgb, $code_assurance, $nom_prenoms)
    {
        $query = "
SELECT 
       A.etablissement_code AS code_ets,
       A.population_num AS num_population,
       B.rgb_num AS num_rgb,
       B.civilite_code AS code_civilite,
       B.population_nom AS nom,
       B.population_nom_patronymique AS nom_patronymique,
       B.population_prenoms AS prenom,
       B.population_date_naissance AS date_naissance, 
       B.sexe_code AS code_sexe, 
       B.situation_familiale_code AS code_situation_familiale,
       A.etablissement_patient_date_debut AS date_debut
FROM 
     tb_etablissements_patients A 
         JOIN tb_populations B 
             ON A.population_num = B.population_num 
                    AND A.etablissement_patient_date_fin IS NULL 
                    AND A.etablissement_code = ? 
                    AND A.population_num LIKE ? 
                    AND B.rgb_num LIKE ? 
                    AND CONCAT(B.population_nom,' ', B.population_prenoms) LIKE ?";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code_ets, '%'.$num_population.'%', '%'.$num_rgb.'%', '%'.$nom_prenoms.'%'));
        return $a->fetchAll();
    }

    public function lister_dossiers($code_ets, $num_patient, $limit)
    {
        $a = $this->getBdd()->prepare("
SELECT 
       A.etablissement_code AS code_etablissement, 
       B.raison_sociale,
       A.population_num AS num_population, 
       A.dossier_code AS code_dossier, 
       A.patient_dossier_date_debut AS date_debut, 
       A.patient_dossier_date_fin AS date_fin, 
       A.date_creation, 
       A.utilisateur_id_creation, 
       A.date_edition, 
       A.utilisateur_id_edition 
FROM 
     tb_patients_dossiers A 
         JOIN tb_etablissements B 
             ON A.etablissement_code = B.etablissement_code 
                    AND A.etablissement_code = ? AND A.population_num LIKE ? ORDER BY A.date_creation DESC LIMIT {$limit}");
        $a->execute(array($code_ets, '%'.$num_patient.'%'));
        return $a->fetchAll();
    }

    public function lister_dossiers_ouverts($code_ets, $num_patient)
    {
        $a = $this->getBdd()->prepare("
SELECT 
       A.etablissement_code AS code_etablissement, 
       B.raison_sociale,
       A.population_num AS num_population, 
       A.dossier_code AS code_dossier, 
       A.patient_dossier_date_debut AS date_debut, 
       A.patient_dossier_date_fin AS date_fin, 
       A.date_creation, 
       A.utilisateur_id_creation, 
       A.date_edition, 
       A.utilisateur_id_edition 
FROM 
     tb_patients_dossiers A 
         JOIN tb_etablissements B 
             ON A.etablissement_code = B.etablissement_code 
                    AND A.etablissement_code = ? AND A.population_num LIKE ? AND A.patient_dossier_date_fin IS NULL");
        $a->execute(array($code_ets, '%'.$num_patient.'%'));
        return $a->fetchAll();
    }

    public function trouver_dossier($code_ets, $code_dossier)
    {
        $a = $this->getBdd()->prepare("
SELECT 
       A.etablissement_code AS code_etablissement, 
       B.raison_sociale,
       A.population_num AS num_population, 
       A.dossier_code AS code_dossier, 
       A.professionnel_sante_code AS code_professionnel, 
       A.patient_dossier_plainte AS plainte, 
       A.patient_dossier_diagnostic AS diagnostic, 
       A.patient_dossier_date_debut AS date_debut, 
       A.patient_dossier_date_fin AS date_fin, 
       A.date_creation, 
       A.utilisateur_id_creation, 
       A.date_edition, 
       A.utilisateur_id_edition 
FROM 
     tb_patients_dossiers A 
         JOIN tb_etablissements B 
             ON A.etablissement_code = B.etablissement_code 
                    AND A.etablissement_code = ? AND A.dossier_code LIKE ?");
        $a->execute(array($code_ets, '%'.$code_dossier.'%'));
        return $a->fetch();
    }

    public function editer_logo($code_ets, $nom_logo, $user): array
    {
        $a = $this->getBdd()->prepare("UPDATE tb_etablissements SET etablissement_logo = ?, date_edition = ?, utilisateur_id_edition = ? WHERE etablissement_code = ?");
        $a->execute(array($nom_logo, date('Y-m-d H:i:s', time()), $user, $code_ets));
        if ($a->errorCode() == "00000") {
            return array(
                "success" => true,
                "message" => 'Enregistrement effectué avec succès.'
            );
        } else {
            return array(
                "success" => false,
                "message" => $a->errorInfo()
            );
        }
    }

    public function editer_panier_acte($code_ets, $code, $type_facture, $tarif, $date_debut, $user)
    {
        $panier = $this->trouver_panier($code_ets);
        if ($panier) {
            $panier_acte = $this->trouver_panier_acte($panier['code'], $code);
            if ($panier_acte) {
                $date_fin = date('Y-m-d', strtotime('-1 day', time()));
                if (strtotime($date_fin) > strtotime($panier_acte['date_debut'])) {
                    $fermer = $this->fermer_panier_acte($panier, $panier_acte['code'], $date_fin, $user);
                    if ($fermer['success'] == true) {
                        $json = $this->ajouter_panier_acte($panier_acte['code_panier'], $panier_acte['code'], $type_facture, $tarif, $date_debut, $user);
                    } else {
                        $json = $fermer;
                    }
                } else {
                    $json = array(
                        'success' => false,
                        'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le " . date('d/m/Y', strtotime('+2 day', strtotime($panier['date_debut'])))
                    );
                }
            } else {
                $json = $this->ajouter_panier_acte($panier['code'], $code, $type_facture, $tarif, $date_debut, $user);
            }
        } else {
            $ets = $this->trouver($code_ets, null);
            if ($ets) {
                $panier = $this->ajouter_panier($ets['code'], $ets['raison_sociale'], $user);
                if ($panier['success'] == true) {
                    $json = $this->ajouter_panier_acte($panier['code'], $code, $type_facture, $tarif, $date_debut, $user);
                } else {
                    $json = $panier;
                }
            } else {
                $json = $ets;
            }
        }
        return $json;
    }

    public function trouver_panier($code_ets)
    {
        $a = $this->getBdd()->prepare("SELECT etablissement_code AS code_etablissement, panier_soins_code AS code, panier_soins_libelle AS libelle, panier_soins_date_debut AS date_debut, date_creation, utilisateur_id_creation FROM tb_paniers_soins WHERE etablissement_code = ? AND panier_soins_date_fin IS NULL");
        $a->execute(array($code_ets));
        return $a->fetch();
    }

    public function trouver_panier_acte($code_ets, $code_acte)
    {
        $a = $this->getBdd()->prepare("
SELECT 
       A.etablissement_code AS code_etablissement, 
       A.panier_soins_code AS code_panier_soins,
       B.acte_code AS code, 
       C.acte_libelle AS libelle,
       B.type_facture_code AS code_type_facture, 
       B.panier_soins_acte_tarif AS tarif, 
       B.panier_soins_acte_date_debut AS date_debut 
FROM tb_paniers_soins A 
    JOIN tb_paniers_soins_actes_medicaux B 
        ON A.panier_soins_code = B.panier_soins_code 
    JOIN tb_ref_actes_medicaux C 
        ON B.acte_code = C.acte_code
               AND etablissement_code = ? 
               AND B.acte_code = ? 
               AND A.panier_soins_date_fin IS NULL 
               AND B.panier_soins_acte_date_fin IS NULL 
               AND C.acte_date_fin IS NULL");
        $a->execute(array($code_ets, $code_acte));
        return $a->fetch();
    }

    private function fermer_panier_acte($code_panier, $code, $date_fin, $user): array
    {
        $a = $this->getBdd()->prepare("UPDATE tb_paniers_soins_actes_medicaux SET panier_soins_acte_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE panier_soins_code = ? AND acte_code = ? AND panier_soins_acte_date_fin IS NULL");
        $a->execute(array($date_fin, date('Y-m-d H:i:s', time()), $user, $code_panier, $code));
        if ($a->errorCode() == "00000") {
            return array(
                "success" => true,
                "message" => 'Enregistrement effectué avec succès.'
            );
        } else {
            return array(
                "success" => false,
                "message" => $a->errorInfo()[2]
            );
        }
    }

    private function ajouter_panier_acte($code_panier, $code, $type_facture, $tarif, $date_debut, $user): array
    {
        $a = $this->getBdd()->prepare("INSERT INTO tb_paniers_soins_actes_medicaux(panier_soins_code, acte_code, type_facture_code, panier_soins_acte_tarif, panier_soins_acte_date_debut, utilisateur_id_creation)
        VALUES(:panier_soins_code, :acte_code, :type_facture_code, :panier_soins_acte_tarif, :panier_soins_acte_date_debut, :utilisateur_id_creation)");
        $a->execute(array(
            'panier_soins_code' => $code_panier,
            'acte_code' => $code,
            'type_facture_code' => $type_facture,
            'panier_soins_acte_tarif' => $tarif,
            'panier_soins_acte_date_debut' => $date_debut,
            'utilisateur_id_creation' => $user
        ));
        if ($a->errorCode() == "00000") {
            return array(
                "success" => true,
                "message" => 'Enregistrement effectué avec succès.'
            );
        } else {
            return array(
                "success" => false,
                "message" => $a->errorInfo()[2]
            );
        }
    }

    private function ajouter_panier($code_ets, $libelle, $user): array
    {
        $z = $this->getBdd()->prepare("SELECT * FROM tb_paniers_soins");
        $z->execute(array());
        $paniers = $z->fetchAll();
        $nb_paniers = count($paniers);
        $code = 'PNS'.str_pad(intval($nb_paniers + 1), 7, '0', STR_PAD_LEFT);
        $a = $this->getBdd()->prepare("INSERT INTO tb_paniers_soins(etablissement_code, panier_soins_code, panier_soins_libelle, panier_soins_date_debut, utilisateur_id_creation)
                VALUES(:etablissement_code, :panier_soins_code, :panier_soins_libelle, :panier_soins_date_debut, :utilisateur_id_creation)");
        $a->execute(array(
            'etablissement_code' => $code_ets,
            'panier_soins_code' => $code,
            'panier_soins_libelle' => $libelle,
            'panier_soins_date_debut' => date('Y-m-d', time()),
            'utilisateur_id_creation' => $user
        ));
        if ($a->errorCode() == "00000") {
            return array(
                "success" => true,
                "code" => $code,
                "message" => 'Enregistrement effectué avec succès.'
            );
        } else {
            return array(
                "success" => false,
                "message" => $a->errorInfo()[2]
            );
        }
    }

    public function lister_facture_acte($code_ets, $libelle_acte, $type_facture, $date_soins)
    {
        $a = $this->getBdd()->prepare("
SELECT 
       A.etablissement_code AS code_etablissement,
       B.acte_code AS code,
       C.acte_libelle AS libelle,
       B.type_facture_code AS code_type_facture,
       B.panier_soins_acte_tarif AS tarif,
       B.panier_soins_acte_date_debut AS date_debut 
FROM 
     tb_paniers_soins A 
         JOIN tb_paniers_soins_actes_medicaux B 
             ON A.panier_soins_code = B.panier_soins_code 
         JOIN tb_ref_actes_medicaux C 
             ON B.acte_code = C.acte_code 
                    AND etablissement_code = ? 
                    AND C.acte_libelle LIKE ? 
                    AND B.type_facture_code LIKE ? 
                    AND A.panier_soins_date_fin IS NULL 
                    AND C.acte_date_fin IS NULL 
                    AND B.panier_soins_acte_date_debut <= ? 
                    AND (B.panier_soins_acte_date_fin IS NULL OR B.panier_soins_acte_date_fin >= ?) 
ORDER BY C.acte_libelle");
        $a->execute(array($code_ets, '%'.$libelle_acte.'%', '%'.$type_facture.'%', $date_soins, $date_soins));
        return $a->fetchAll();
    }

    public function lister_factures($code_ets, $num_patient, $statut)
    {
        $a = $this->getBdd()->prepare("
SELECT 
       A.organisme_code AS code_organisme,
       A.facture_medicale_num AS num_facture,
       A.type_facture_code AS code_type_facture,
       D.type_facture_libelle AS libelle_type_facture,
       A.dossier_code AS code_dossier,
       A.organisme_contrat_collectivite_taux AS taux_couverture,
       B.etablissement_code AS code_etablissement, 
       C.population_num AS num_population, 
       C.rgb_num AS num_rgb, 
       C.population_prenoms AS prenom, 
       C.population_nom AS nom, 
       C.population_date_naissance AS date_naissance,
       SUM(E.acte_tarif *  E.acte_quantite) AS montant_depense,
       SUM(acte_montant_rgb) AS montant_rgb,
       SUM(acte_montant_rc) AS montant_organisme,
       SUM(acte_montant_patient) AS montant_patient,
       A.statut_code AS code_statut,
       A.date_creation
FROM 
     tb_factures_medicales A 
         JOIN tb_patients_dossiers B 
             ON A.dossier_code = B.dossier_code 
         JOIN tb_populations C 
             ON B.population_num = C.population_num 
         JOIN tb_ref_types_factures_medicales D 
             ON A.type_facture_code = D.type_facture_code 
         JOIN tb_factures_medicales_actes E 
             ON A.facture_medicale_num = E.facture_medicale_num
                    AND B.etablissement_code = ?
                    AND B.population_num LIKE ? 
                    AND A.statut_code LIKE ? 
                    AND D.type_facture_date_fin IS NULL
GROUP BY 
         A.organisme_code,
         A.facture_medicale_num,
         A.type_facture_code,
         D.type_facture_libelle,
         A.dossier_code,
         A.organisme_contrat_collectivite_taux,
         B.etablissement_code, 
         C.population_num, 
         C.rgb_num, 
         C.population_prenoms, 
         C.population_nom, 
         C.population_date_naissance,
         A.statut_code,
        A.date_creation
ORDER BY 
         A.date_creation DESC");
        $a->execute(array($code_ets, '%'.$num_patient.'%','%'.$statut.'%'));
        return $a->fetchAll();
    }

    public function lister_factures_en_attente($code_ets, $num_patient)
    {
        $a = $this->getBdd()->prepare("
SELECT 
       A.facture_medicale_num AS num_facture, 
       A.dossier_code AS code_dossier, 
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
                    AND B.etablissement_code = ?
                    AND B.population_num LIKE ? 
                    AND A.statut_code = ?
ORDER BY 
         A.date_edition DESC");
        $a->execute(array($code_ets, '%'.$num_patient.'%','N'));
        return $a->fetchAll();
    }

    public function trouver_facture($code_ets, $num_facture)
    {
        $a = $this->getBdd()->prepare("
SELECT 
       A.organisme_code AS code_organisme,
       B.patient_dossier_date_debut AS date_soins,
       A.facture_medicale_num AS num_facture, 
       A.facture_medicale_initiale_num AS num_facture_initiale, 
       A.facture_organisme_entente_prealable_num AS num_organisme_entente_prealable, 
       A.facture_rgb_entente_prealable_num AS num_rgb_entente_prealable, 
       A.dossier_code AS code_dossier, 
       A.organisme_facture_num AS num_bon, 
       B.patient_dossier_date_debut AS date_soins,
       B.etablissement_code AS code_etablissement, 
       C.population_num AS num_population,
       C.rgb_num AS num_rgb,
       C.population_prenoms AS prenom, 
       C.population_nom AS nom, 
       C.population_date_naissance AS date_naissance,
       C.sexe_code AS code_sexe,
       A.facture_medicale_taux_remise AS taux_remise,
       A.statut_code AS code_statut,
       D.statut_libelle AS libelle_statut,
       A.date_creation,
       A.utilisateur_id_creation AS user_id,
       E.utilisateur_nom AS nom_utilisateur, 
       E.utilisateur_prenoms AS prenoms_utilisateur
FROM 
     tb_factures_medicales A 
         JOIN tb_patients_dossiers B 
             ON A.dossier_code = B.dossier_code 
         JOIN tb_populations C 
             ON B.population_num = C.population_num 
         JOIN tb_factures_medicales_statuts D 
             ON A.statut_code = D.statut_code 
         JOIN tb_utilisateurs E 
             ON A.utilisateur_id_creation = E.utilisateur_id
                    AND B.etablissement_code = ?
                    AND A.facture_medicale_num = ? 
                    AND D.statut_date_fin IS NULL");
        $a->execute(array($code_ets, $num_facture));
        return $a->fetch();
    }

    public function trouver_bordereau($code_ets, $num_bordereau)
    {
        $a = $this->getBdd()->prepare("
SELECT 
       A.bordereau_num AS num_bordereau, 
       A.bordereau_date_debut AS date_debut, 
       A.bordereau_date_fin AS date_fin,
       A.type_facture_code AS code_type_facture, 
       E.type_facture_libelle AS libelle_type_facture, 
       A.organisme_code AS code_organisme,
       D.organisme_libelle AS libelle_organisme,
       A.date_creation,
       A.utilisateur_id_creation AS id_user,
       COUNT(DISTINCT B.facture_medicale_num) AS nombre_factures,
       COUNT(DISTINCT C.acte_code) AS nombre_actes,
       SUM(C.acte_montant_rgb) AS montant_rgb,
       SUM(C.acte_montant_rc) AS montant_rc
FROM 
     tb_etablissements_bordereaux A 
         JOIN tb_factures_medicales_bordereaux B 
             ON A.bordereau_num = B.bordereau_num 
         JOIN tb_factures_medicales_actes C 
             ON B.facture_medicale_num = C.facture_medicale_num 
         JOIN tb_organismes D 
             ON A.organisme_code = D.organisme_code 
         JOIN tb_ref_types_factures_medicales E 
             ON A.type_facture_code = E.type_facture_code 
                    AND E.type_facture_date_fin IS NULL
                    AND A.etablissement_code = ?
                    AND A.bordereau_num = ?
GROUP BY 
         A.bordereau_num,
         A.bordereau_date_debut,
         A.bordereau_date_fin,
         A.type_facture_code,
         E.type_facture_libelle,
         A.organisme_code,
         D.organisme_libelle,
         A.date_creation,
         A.utilisateur_id_creation");
        $a->execute(array($code_ets, $num_bordereau));
        return $a->fetch();
    }

    public function lister_bordereau_factures($num_bordereau) {
        $a = $this->getBdd()->prepare("
SELECT 
       A.bordereau_num AS num_bordereau,
       A.facture_medicale_num AS num_facture,
       B.dossier_code AS code_dossier,
       D.patient_dossier_date_debut AS date_soins,
       D.population_num AS num_population,
       B.organisme_facture_num AS num_bon,
       COUNT(DISTINCT acte_code) AS nombre_actes,
       SUM(C.acte_montant_depense) AS montant_depense,
       SUM(C.acte_montant_rgb) AS montant_rgb,
       SUM(C.acte_montant_rc) AS montant_rc,
       SUM(C.acte_montant_patient) AS montant_patient
FROM 
     tb_factures_medicales_bordereaux A 
         JOIN tb_factures_medicales B 
             ON A.facture_medicale_num = B.facture_medicale_num 
         JOIN tb_factures_medicales_actes C 
             ON B.facture_medicale_num = C.facture_medicale_num 
         JOIN tb_patients_dossiers D 
             ON B.dossier_code = D.dossier_code
                    AND A.bordereau_num = ? 
GROUP BY 
         A.bordereau_num,
         A.facture_medicale_num,
         B.dossier_code,
         D.patient_dossier_date_debut,
         D.population_num,
         B.organisme_facture_num
ORDER BY 
         B.date_creation DESC");
        $a->execute(array($num_bordereau));
        return $a->fetchAll();
    }

    public function ajouter_bordereau($code_ets, $date_debut, $date_fin, $code_organisme, $type_facture, $user) {
        $a = $this->getBdd()->prepare("SELECT bordereau_num FROM tb_etablissements_bordereaux");
        $a->execute(array());
        $bordereaux = $a->fetchAll();
        $nb_bordereaux = count($bordereaux);
        $num_bordereau = (int)($nb_bordereaux + 1);

        $b = $this->getBdd()->prepare("INSERT INTO tb_etablissements_bordereaux(bordereau_num, bordereau_date_debut, bordereau_date_fin, etablissement_code, organisme_code, type_facture_code, utilisateur_id_creation)
        VALUES(:bordereau_num, :bordereau_date_debut, :bordereau_date_fin, :etablissement_code, :organisme_code, :type_facture_code, :utilisateur_id_creation)");
        $b->execute(array(
            'bordereau_num' => $num_bordereau,
            'bordereau_date_debut' => $date_debut,
            'bordereau_date_fin' => $date_fin,
            'etablissement_code' => $code_ets,
            'organisme_code' => $code_organisme,
            'type_facture_code' => $type_facture,
            'utilisateur_id_creation' => $user
        ));
        if ($b->errorCode() == "00000") {
            return array(
                "success" => true,
                "num_bordereau" => $num_bordereau,
                "message" => 'Enregistrement effectué avec succès.'
            );
        } else {
            return array(
                "success" => false,
                "message" => $b->errorInfo()[2]
            );
        }
    }

    public function ajouter_facture_bordereau($num_bordereau, $num_facture, $user) {
        $a = $this->getBdd()->prepare("INSERT INTO tb_factures_medicales_bordereaux(bordereau_num, facture_medicale_num, utilisateur_id_creation) 
        VALUES(:bordereau_num, :facture_medicale_num, :utilisateur_id_creation)");
        $a->execute(array(
            'bordereau_num' => $num_bordereau,
            'facture_medicale_num' => $num_facture,
            'utilisateur_id_creation' => $user
        ));
        if ($a->errorCode() == "00000") {
            $b = $this->getBdd()->prepare("UPDATE tb_factures_medicales SET bordereau_num = ? WHERE facture_medicale_num = ?");
            $b->execute(array($num_bordereau, $num_facture));
            if ($b->errorCode() == "00000") {
                return array(
                    "success" => true,
                    "message" => 'Enregistrement effectué avec succès.'
                );
            } else {
                return array(
                    "success" => false,
                    "message" => $b->errorInfo()[2]
                );
            }
        } else {
            return array(
                "success" => false,
                "message" => $a->errorInfo()[2]
            );
        }
    }

    public function lister_professionnels_de_sante($code_ets)
    {
        $a = $this->getBdd()->prepare("
SELECT 
       C.etablissement_code AS code_etablissement, 
       B.professionnel_sante_code AS code_professionnel,
       A.utilisateur_id AS id_user, 
       B.specialite_medicale_code AS code_specialite_medicale,
       D.specialite_medicale_libelle AS libelle_specialite_medicale,
       A.civilite_code AS code_civilite, 
       A.utilisateur_nom AS nom, 
       A.utilisateur_prenoms AS prenom,
       A.utilisateur_date_naissance AS date_naissance,
       A.sexe_code AS code_sexe
FROM 
     tb_utilisateurs A 
         JOIN tb_professionnels_sante B 
             ON A.utilisateur_id = B.utilisateur_id 
         JOIN tb_etablissements_professionnels C 
             ON B.professionnel_sante_code = C.professionnel_sante_code 
         JOIN tb_ref_specialites_medicales D 
             ON B.specialite_medicale_code = D.specialite_medicale_code
                    AND B.professionnel_date_fin IS NULL 
                    AND C.etablissement_professionnel_date_fin IS NULL 
                    AND D.specialite_medicale_date_fin IS NULL
                    AND C.etablissement_code = ?");
        $a->execute(array($code_ets));
        return $a->fetchAll();
    }

    public function trouver_professionnel_de_sante($code_ets, $code_professionnel)
    {
        $a = $this->getBdd()->prepare("
SELECT 
       A.utilisateur_id AS id_user,
       C.etablissement_code AS code_etablissement, 
       B.professionnel_sante_code AS code_professionnel,
       B.professionnel_sante_rgb_code AS code_rgb,
       A.utilisateur_id AS id_user, 
       B.specialite_medicale_code AS code_specialite_medicale,
       D.specialite_medicale_libelle AS libelle_specialite_medicale,
       A.civilite_code AS code_civilite, 
       A.utilisateur_nom AS nom, 
       A.utilisateur_prenoms AS prenom,
       A.utilisateur_date_naissance AS date_naissance,
       A.sexe_code AS code_sexe,
       A.utilisateur_email AS email
FROM 
     tb_utilisateurs A 
         JOIN tb_professionnels_sante B 
             ON A.utilisateur_id = B.utilisateur_id 
         JOIN tb_etablissements_professionnels C 
             ON B.professionnel_sante_code = C.professionnel_sante_code 
         JOIN tb_ref_specialites_medicales D 
             ON B.specialite_medicale_code = D.specialite_medicale_code
                    AND B.professionnel_date_fin IS NULL 
                    AND C.etablissement_professionnel_date_fin IS NULL 
                    AND D.specialite_medicale_date_fin IS NULL
                    AND C.etablissement_code = ? 
                    AND B.professionnel_sante_code = ?");
        $a->execute(array($code_ets, $code_professionnel));
        return $a->fetch();
    }

    public function ajouter_professionnel_de_sante($code_ets, $code_professionnel, $user)
    {
        $a = $this->getBdd()->prepare("INSERT INTO tb_etablissements_professionnels(etablissement_code, professionnel_sante_code, etablissement_professionnel_date_debut, utilisateur_id_creation)
        VALUEs(:etablissement_code, :professionnel_sante_code, :etablissement_professionnel_date_debut, :utilisateur_id_creation)");
        $a->execute(array(
            'etablissement_code' => $code_ets,
            'professionnel_sante_code' => $code_professionnel,
            'etablissement_professionnel_date_debut' => date('Y-m-d', time()),
            'utilisateur_id_creation' => $user
        ));
        if ($a->errorCode() == "00000") {
            return array(
                "success" => true,
                "message" => 'Enregistrement effectué avec succès.'
            );
        } else {
            return array(
                "success" => false,
                "message" => $a->errorInfo()[2]
            );
        }
    }

    public function fermer_professionnel_de_sante($code_ets, $code_professionnel, $user)
    {
        $a = $this->getBdd()->prepare("UPDATE tb_etablissements_professionnels SET etablissement_professionnel_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE etablissement_code = ? AND professionnel_sante_code = ? AND etablissement_professionnel_date_fin IS NULL");
        $a->execute(array(date('Y-m-d', time()), date('Y-m-d H:i:s', time()), $user, $code_ets, $code_professionnel));
        if ($a->errorCode() == "00000") {
            return array(
                "success" => true,
                "message" => 'Enregistrement effectué avec succès.'
            );
        } else {
            return array(
                "success" => false,
                "message" => $a->errorInfo()[2]
            );
        }
    }

    public function edition_paiement_facture($code_ets, $num_facture, $montant_brut, $remise, $montant_net, $mode_paiement, $montant_recu, $monnaie, $user)
    {
        $facture = $this->trouver_facture($code_ets, $num_facture);
        if ($facture) {
            if ($facture['code_statut'] != 'P') {
                $paiement = $this->trouver_facture_paiement($facture['num_facture']);
                if (!$paiement) {
                    $montant = 0;
                    $b = $this->getBdd()->prepare("SELECT (acte_montant_rc + acte_montant_rgb) AS montant FROM tb_factures_medicales_actes WHERE (acte_taux_couverture_rc != ? OR acte_taux_couverture_rgb != ?) AND facture_medicale_num = ?");
                    $b->execute(array(0, 0, $facture['num_facture']));
                    $actes = $b->fetchAll();
                    $nb_actes = count($actes);
                    if ($nb_actes != 0) {
                        foreach ($actes as $acte) {
                            $montant += $acte['montant'];
                        }
                    }

                    if ($montant != 0) {
                        $libelle = "FACTURE {$facture['code_organisme']} N° {$facture['num_facture']} DU ".date('d/m/Y', strtotime($facture['date_soins']))." POUR LE PATIENT N° {$facture['num_population']}";
                        $depense = $this->ajouter_depense($code_ets, '*', null, $facture['code_organisme'], $facture['num_facture'], $libelle, $montant, $libelle, $user);
                        if ($depense['success'] == true) {
                            $validation = 1;
                        } else {
                            $validation = 0;
                        }
                    } else {
                        $validation = 1;
                    }

                    if ($validation == 1) {
                        $num_paiement = substr($code_ets, 2, 6).date('YmdHis', time());
                        $c = $this->getBdd()->prepare("INSERT INTO tb_factures_medicales_paiements(paiement_num, facture_medicale_num, paiement_montant_brut, paiement_taux_remise, paiement_montant_net, type_reglement_code, paiement_montant_recu, paiement_monnaie_rendue, utilisateur_id_creation)
                        VALUES(:paiement_num, :facture_medicale_num, :paiement_montant_brut, :paiement_taux_remise, :paiement_montant_net, :type_reglement_code, :paiement_montant_recu, :paiement_monnaie_rendue, :utilisateur_id_creation)");
                        $c->execute(array(
                            'paiement_num' => $num_paiement,
                            'facture_medicale_num' => $num_facture,
                            'paiement_montant_brut' => $montant_brut,
                            'paiement_taux_remise' => $remise,
                            'paiement_montant_net' => $montant_net,
                            'type_reglement_code' => $mode_paiement,
                            'paiement_montant_recu' => $montant_recu,
                            'paiement_monnaie_rendue' => $monnaie,
                            'utilisateur_id_creation' => $user
                        ));
                        if ($c->errorCode() == "00000") {
                            $libelle_recette = "PAIEMENT FACTURE {$facture['code_organisme']} N° {$facture['num_facture']} DU ".date('d/m/Y', strtotime($facture['date_soins']))." POUR LE PATIENT N° {$facture['num_population']}";
                            $recette = $this->ajouter_depense($code_ets, 'R', null, null, $facture['num_facture'], $libelle_recette, $montant_net, $libelle_recette, $user);
                            if ($recette['success'] == true) {
                                $d = $this->getBdd()->prepare("UPDATE tb_factures_medicales SET statut_code = ?, date_edition = ?, utilisateur_id_edition = ? WHERE facture_medicale_num = ?");
                                $d->execute(array('P', date('Y-m-d H:i:s', time()), $user, $facture['num_facture']));
                                if ($d->errorCode() == "00000") {
                                    if($facture['code_organisme'] !== 'ORG00001') {
                                        $e = $this->getBdd()->prepare("INSERT INTO tb_factures_medicales_organismes(organisme_code, etablissement_code, population_num, facture_medicale_num, utilisateur_id_creation)
                                        VALUES (:organisme_code, :etablissement_code, :population_num, :facture_medicale_num, :utilisateur_id_creation)");
                                        $e->execute(array(
                                            'organisme_code' => $facture['code_organisme'],
                                            'etablissement_code' => $facture['code_etablissement'],
                                            'population_num' => $facture['num_population'],
                                            'facture_medicale_num' => $facture['num_facture'],
                                            'utilisateur_id_creation' => $user
                                        ));
                                        if ($e->errorCode() == "00000") {
                                            $verification_organisme = 1;
                                            $erreur_verification = null;
                                        }else {
                                            $verification_organisme = 0;
                                            $erreur_verification = array(
                                                'success' => false,
                                                'message' => $e->errorInfo()[2]
                                            );
                                        }
                                    }else {
                                        $verification_organisme = 1;
                                        $erreur_verification = null;
                                    }
                                    if($verification_organisme === 1) {
                                        return array(
                                            "success" => true,
                                            "num_paiement" => $num_paiement,
                                            "message" => 'Enregistrement effectué avec succès.'
                                        );
                                    }else {
                                        return $erreur_verification;
                                    }
                                } else {
                                    return array(
                                        "success" => false,
                                        "message" => $d->errorInfo()[2]
                                    );
                                }
                            } else {
                                return  $recette;
                            }
                        } else {
                            return array(
                                "success" => false,
                                "message" => $c->errorInfo()[2]
                            );
                        }
                    } else {
                        $json = array(
                            'success' => false,
                            'message' => "Une erreur est survenue lors de l'enregistrment de la facture de l'organisme. Veuillez contacter votre administrateur."
                        );
                    }
                } else {
                    $json = array(
                        'success' => false,
                        'message' => "Un paiement a déjà été effectué pour cette facture."
                    );
                }
            } else {
                $json = array(
                    'success' => false,
                    'message' => "Un paiement a déjà été effectué pour cette facture."
                );
            }
        } else {
            $json = array(
                'success' => false,
                'message' => "Aucune facture n'a été identifié pour ce paiement."
            );
        }
        return $json;
    }

    private function ajouter_depense($code_ets, $type, $num_depense_recette, $code_organisme, $num_facture, $libelle, $montant, $description, $user)
    {
        if (!$num_depense_recette) {
            $num_depense_recette = date('sdHYim', time()).strtolower($type).substr(uniqid('', true), 0, 5);
        }
        $a = $this->getBdd()->prepare("INSERT INTO tb_etablissements_depenses_recettes(depense_recette_num, depense_recette_type, etablissement_code, organisme_code, facture_medicale_num, depense_recette_libelle, depense_recette_description, depense_recette_montant, utilisateur_id_creation)
        VALUEs(:depense_recette_num, :depense_recette_type, :etablissement_code, :organisme_code, :facture_medicale_num, :depense_recette_libelle, :depense_recette_description, :depense_recette_montant, :utilisateur_id_creation)");
        $a->execute(array(
            'depense_recette_num' => $num_depense_recette,
            'depense_recette_type' => $type,
            'etablissement_code' => $code_ets,
            'organisme_code' => $code_organisme,
            'facture_medicale_num' => $num_facture,
            'depense_recette_libelle' => $libelle,
            'depense_recette_description' => $description,
            'depense_recette_montant' => $montant,
            'utilisateur_id_creation' => $user
        ));

        if ($a->errorCode() == "00000") {
            return array(
                "success" => true,
                "num_depense" => $num_depense_recette,
                "message" => 'Enregistrement effectué avec succès.'
            );
        } else {
            return array(
                "success" => false,
                "message" => $a->errorInfo()[2]
            );
        }
    }

    public function trouver_facture_paiement($num_facture)
    {
        $a = $this->getBdd()->prepare("
SELECT 
       A.paiement_num AS num_paiement, 
       A.facture_medicale_num AS num_facture,
       A.paiement_montant_brut AS montant_brut,
       A.paiement_taux_remise AS remise,
       A.paiement_montant_net AS montant_net,
       A.type_reglement_code AS code_type_reglement,
       B.type_reglement_libelle AS libelle_type_reglement,
       A.paiement_montant_recu AS montant_recu,
       A.paiement_monnaie_rendue AS monnaie,
       A.date_creation, A.utilisateur_id_creation AS user_id, 
       C.utilisateur_nom AS nom_utilisateur, 
       C.utilisateur_prenoms AS prenoms_utilisateur
FROM 
     tb_factures_medicales_paiements A 
         JOIN tb_ref_types_reglements B 
             ON A.type_reglement_code = B.type_reglement_code 
         JOIN tb_utilisateurs C 
             ON A.utilisateur_id_creation = C.utilisateur_id
                    AND B.type_reglement_date_fin IS NULL
                    AND A.facture_medicale_num = ?");
        $a->execute(array($num_facture));
        return $a->fetch();
    }

    public function lister_fournisseurs($code_ets)
    {
        $a = $this->getBdd()->prepare("
SELECT 
       G.etablissement_code AS code_etablissement, 
       A.fournisseur_code AS code, 
       A.fournisseur_libelle AS libelle, 
       A.pays_code AS code_pays, 
       B.pays_nom AS nom_pays,
       B.monnaie_code AS code_monnaie,
       F.monnaie_libelle AS libelle_monnaie,
       A.region_code AS code_region, 
       C.region_nom AS nom_region,
       A.departement_code AS code_departement, 
       D.departement_nom AS nom_departement,
       A.commune_code AS code_commune,
       E.commune_nom AS nom_commune,
       A.fournisseur_adresse_postale AS adresse_postale, 
       A.fournisseur_adresse_geographique AS adresse_geographique,
       A.fournisseur_email AS email, 
       A.fournisseur_num_telephone_1 AS num_telephone_1,
       A.fournisseur_num_telephone_2 AS num_telephone_2,       
       A.date_creation, 
       A.utilisateur_id_creation, 
       A.date_edition, 
       A.utilisateur_id_edition 
FROM 
     tb_fournisseurs A 
         JOIN tb_ref_geo_pays B 
             ON A.pays_code = B.pays_code 
         JOIN tb_ref_geo_regions C 
             ON A.region_code = C.region_code 
         JOIN tb_ref_geo_departements D 
             ON A.departement_code = D.departement_code 
         JOIN tb_ref_geo_communes E 
             ON A.commune_code = E.commune_code 
         JOIN tb_ref_monnaies F 
             ON B.monnaie_code = F.monnaie_code 
         JOIN tb_etablissements_fournisseurs G 
             ON A.fournisseur_code = G.fournisseur_code
                    AND B.pays_date_fin IS NULL 
                    AND C.region_date_fin IS NULL 
                    AND D.departement_date_fin IS NULL 
                    AND E.commune_date_fin IS NULL 
                    AND F.monnaie_date_fin IS NULL 
                    AND G.etablissement_fournisseur_date_fin IS NULL 
                    AND G.etablissement_code = ? 
ORDER BY 
         fournisseur_libelle");
        $a->execute(array($code_ets));
        return $a->fetchAll();
    }

    public function trouver_fournisseur($code_ets, $code_fournisseur)
    {
        $a = $this->getBdd()->prepare("
SELECT 
       G.etablissement_code AS code_etablissement, 
       A.fournisseur_code AS code, 
       A.fournisseur_libelle AS libelle, 
       A.pays_code AS code_pays, 
       B.pays_nom AS nom_pays,
       B.monnaie_code AS code_monnaie,
       F.monnaie_libelle AS libelle_monnaie,
       A.region_code AS code_region, 
       C.region_nom AS nom_region,
       A.departement_code AS code_departement, 
       D.departement_nom AS nom_departement,
       A.commune_code AS code_commune,
       E.commune_nom AS nom_commune,
       A.fournisseur_adresse_postale AS adresse_postale, 
       A.fournisseur_adresse_geographique AS adresse_geographique, 
       A.date_creation, 
       A.utilisateur_id_creation, 
       A.date_edition, 
       A.utilisateur_id_edition 
FROM 
     tb_fournisseurs A 
         JOIN tb_ref_geo_pays B 
             ON A.pays_code = B.pays_code 
         JOIN tb_ref_geo_regions C 
             ON A.region_code = C.region_code 
         JOIN tb_ref_geo_departements D 
             ON A.departement_code = D.departement_code 
         JOIN tb_ref_geo_communes E 
             ON A.commune_code = E.commune_code 
         JOIN tb_ref_monnaies F 
             ON B.monnaie_code = F.monnaie_code 
         JOIN tb_etablissements_fournisseurs G 
             ON A.fournisseur_code = G.fournisseur_code
                    AND B.pays_date_fin IS NULL 
                    AND C.region_date_fin IS NULL 
                    AND D.departement_date_fin IS NULL 
                    AND E.commune_date_fin IS NULL 
                    AND F.monnaie_date_fin IS NULL 
                    AND G.etablissement_fournisseur_date_fin IS NULL 
                    AND G.etablissement_code = ? 
                    AND A.fournisseur_code = ?");
        $a->execute(array($code_ets, $code_fournisseur));
        return $a->fetch();
    }

    public function ajouter_fournisseur($code_ets, $code_fournisseur, $user): array
    {
        $a = $this->getBdd()->prepare("INSERT INTO tb_etablissements_fournisseurs(etablissement_code, fournisseur_code, etablissement_fournisseur_date_debut, utilisateur_id_creation)
        VALUES(:etablissement_code, :fournisseur_code, :etablissement_fournisseur_date_debut, :utilisateur_id_creation)");
        $a->execute(array(
            'etablissement_code' => $code_ets,
            'fournisseur_code' => $code_fournisseur,
            'etablissement_fournisseur_date_debut' => date('Y-m-d', time()),
            'utilisateur_id_creation' => $user
        ));
        if ($a->errorCode() == "00000") {
            return array(
                "success" => true,
                "message" => 'Enregistrement effectué avec succès.'
            );
        } else {
            return array(
                "success" => false,
                "message" => $a->errorInfo()[2]
            );
        }
    }

    public function fermer_fournisseur($code_ets, $code_fournisseur, $date_fin, $user)
    {
        $a = $this->getBdd()->prepare("UPDATE tb_etablissements_fournisseurs SET etablissement_fournisseur_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE fournisseur_code = ? AND etablissement_code = ? AND etablissement_fournisseur_date_fin IS NULL");
        $a->execute(array($date_fin, date('Y-m-d H:i:s', time()), $user, $code_fournisseur, $code_ets));
        if ($a->errorCode() == "00000") {
            return array(
                "success" => true,
                "message" => 'Enregistrement effectué avec succès.'
            );
        } else {
            return array(
                "success" => false,
                "message" => $a->errorInfo()[2]
            );
        }
    }

    public function lister_produits($code_ets)
    {
        $a = $this->getBdd()->prepare("
SELECT 
       etablissement_code AS code_etablissement, 
       produit_code AS code_produit, 
       produit_libelle AS libelle, 
       produit_statut_vente AS statut_vente, 
       produit_statut_achat AS statut_achat, 
       produit_statut_perissable AS statut_perissable, 
       produit_description AS description, 
       produit_limite_alerte_stock AS limite_stock, 
       produit_nature AS nature, 
       date_creation, 
       utilisateur_id_creation, 
       date_edition, 
       utilisateur_id_edition 
FROM 
     tb_etablissements_produits 
WHERE 
      etablissement_code = ?
ORDER BY 
         produit_libelle");
        $a->execute(array($code_ets));
        return $a->fetchAll();
    }


    public function lister_produits_a_commander($code_ets, $code, $libelle)
    {
        $a = $this->getBdd()->prepare("
SELECT 
       etablissement_code AS code_etablissement, 
       produit_code AS code_produit, 
       produit_libelle AS libelle, 
       produit_statut_vente AS statut_vente, 
       produit_statut_achat AS statut_achat, 
       produit_statut_perissable AS statut_perissable, 
       produit_description AS description, 
       produit_limite_alerte_stock AS limite_stock, 
       produit_nature AS nature, 
       date_creation, 
       utilisateur_id_creation, 
       date_edition, 
       utilisateur_id_edition 
FROM 
     tb_etablissements_produits 
WHERE 
      etablissement_code = ? 
  AND produit_code LIKE ? 
  AND produit_libelle LIKE ? 
  AND produit_statut_achat = ?
ORDER BY 
         produit_libelle");
        $a->execute(array($code_ets, '%'.$code.'%', '%'.$libelle.'%', 1));
        return $a->fetchAll();
    }

    public function trouver_produit($code_ets, $code)
    {
        $a = $this->getBdd()->prepare("
SELECT 
       etablissement_code AS code_etablissement, 
       produit_code AS code_produit, 
       produit_libelle AS libelle, 
       produit_statut_vente AS statut_vente, 
       produit_statut_achat AS statut_achat, 
       produit_statut_perissable AS statut_perissable, 
       produit_description AS description, 
       produit_limite_alerte_stock AS limite_stock, 
       produit_nature AS nature, 
       date_creation, 
       utilisateur_id_creation, 
       date_edition, 
       utilisateur_id_edition 
FROM 
     tb_etablissements_produits 
WHERE 
      etablissement_code = ? 
  AND produit_code = ?
ORDER BY 
         produit_libelle");
        $a->execute(array($code_ets, $code));
        return $a->fetch();
    }

    public function editer_produit($code_ets, $code, $nature, $libelle, $achat, $prix_achat, $vente, $prix_vente, $perissable, $description, $limite_stock, $user)
    {
        if (!$code) {
            $produits = $this->lister_produits($code_ets);
            $nb_produits = count($produits);
            $code = $code_ets.str_pad((int)($nb_produits + 1), 11, 0, STR_PAD_LEFT);
        }
        $a = $this->getBdd()->prepare("INSERT INTO tb_etablissements_produits(etablissement_code, produit_code, produit_libelle, produit_statut_vente, produit_statut_achat, produit_statut_perissable, produit_description, produit_limite_alerte_stock, produit_nature, utilisateur_id_creation)
        VALUES(:etablissement_code, :produit_code, :produit_libelle, :produit_statut_vente, :produit_statut_achat, :produit_statut_perissable, :produit_description, :produit_limite_alerte_stock, :produit_nature, :utilisateur_id_creation)
        ON DUPLICATE KEY UPDATE produit_libelle = :produit_libelle, produit_statut_vente = :produit_statut_vente, produit_statut_achat = :produit_statut_achat, produit_statut_perissable = :produit_statut_perissable, produit_description = :produit_description, produit_limite_alerte_stock = :produit_limite_alerte_stock, produit_nature = :produit_nature, date_edition = :date_edition, utilisateur_id_edition = :utilisateur_id_edition");
        $a->execute(array(
            'etablissement_code' => $code_ets,
            'produit_code' => $code,
            'produit_libelle' => $libelle,
            'produit_statut_vente' => $vente,
            'produit_statut_achat' => $achat,
            'produit_statut_perissable' => $perissable,
            'produit_description' => $description,
            'produit_limite_alerte_stock' => $limite_stock,
            'produit_nature' => $nature,
            'utilisateur_id_creation' => $user,
            'date_edition' => date('Y-m-d H:i:s', time()),
            'utilisateur_id_edition' => $user
        ));
        if ($a->errorCode() == "00000") {
            if ($achat == 1 || $vente == 1) {
                return $this->editer_produit_tarif($code_ets, $code, $prix_achat, $prix_vente, $user);
            } else {
                return array(
                    "success" => true,
                    "code" => $code,
                    "message" => 'Enregistrement effectué avec succès.'
                );
            }
        } else {
            return array(
                "success" => false,
                "message" => $a->errorInfo()[2]
            );
        }
    }

    private function ajouter_produit_tarif($code_ets, $code, $prix_achat, $prix_vente, $user)
    {
        $a = $this->getBdd()->prepare("INSERT INTO tb_etablissements_produits_tarifs(etablissement_code, produit_code, tarif_achat, tarif_vente, tarif_date_debut, utilisateur_id_creation) 
        VALUES(:etablissement_code, :produit_code, :tarif_achat, :tarif_vente, :tarif_date_debut, :utilisateur_id_creation)");
        $a->execute(array(
            'etablissement_code' => $code_ets,
            'produit_code' => $code,
            'tarif_achat' => $prix_achat,
            'tarif_vente' => $prix_vente,
            'tarif_date_debut' => date('Y-m-d', time()),
            'utilisateur_id_creation' => $user
        ));

        if ($a->errorCode() == "00000") {
            return array(
                "success" => true,
                "message" => 'Enregistrement effectué avec succès.'
            );
        } else {
            return array(
                "success" => false,
                "message" => $a->errorInfo()[2]
            );
        }
    }

    private function fermer_produit_tarif($code_ets, $code, $date_fin, $user)
    {
        $a = $this->getBdd()->prepare("UPDATE tb_etablissements_produits_tarifs SET tarif_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE etablissement_code = ? AND produit_code = ? AND tarif_date_fin IS NULL");
        $a->execute(array($date_fin, date('Y-m-d H:i:s', time()), $user, $code_ets, $code));

        if ($a->errorCode() == "00000") {
            return array(
                "success" => true,
                "message" => 'Enregistrement effectué avec succès.'
            );
        } else {
            return array(
                "success" => false,
                "message" => $a->errorInfo()[2]
            );
        }
    }

    public function trouver_produit_tarif($code_ets, $code)
    {
        $a = $this->getBdd()->prepare("SELECT etablissement_code AS code_etablissement, produit_code AS code_produit, tarif_achat AS prix_achat, tarif_vente AS prix_vente, tarif_date_debut AS date_debut FROM tb_etablissements_produits_tarifs WHERE etablissement_code = ? AND produit_code = ? AND tarif_date_fin IS NULL");
        $a->execute(array($code_ets, $code));
        return $a->fetch();
    }

    public function editer_produit_tarif($code_ets, $code, $prix_achat, $prix_vente, $user)
    {
        $tarif = $this->trouver_produit_tarif($code_ets, $code);
        if ($tarif) {
            $date_fin = date('Y-m-d', strtotime('-1 day', time()));
            if (strtotime($date_fin) > strtotime($tarif['date_debut'])) {
                $edition = $this->fermer_produit_tarif($tarif['code_etablissement'], $tarif['code_produit'], $date_fin, $user);
                if ($edition['success'] == true) {
                    return $this->ajouter_produit_tarif($code_ets, $code, $prix_achat, $prix_vente, $user);
                } else {
                    return $edition;
                }
            } else {
                return array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le ".date('d/m/Y', strtotime('+2 day', strtotime($tarif['date_debut'])))
                );
            }
        } else {
            return $this->ajouter_produit_tarif($code_ets, $code, $prix_achat, $prix_vente, $user);
        }
    }

    public function ajouter_commande($code_ets, $code, $code_fournisseur, $user)
    {
        if (!$code) {
            $commandes = $this->lister_commandes($code_ets);
            $nb_commandes = count($commandes);
            $code = date('Ym', time()).$code_ets.str_pad((int)($nb_commandes + 1), 5, '0', STR_PAD_LEFT);
        }
        $a = $this->getBdd()->prepare("INSERT INTO tb_etablissements_commandes(etablissement_code, commande_code, fournisseur_code, commande_date, commande_statut, utilisateur_id_creation)
        VALUES(:etablissement_code, :commande_code, :fournisseur_code, :commande_date, :commande_statut, :utilisateur_id_creation)
        ON DUPLICATE KEY UPDATE fournisseur_code = :fournisseur_code, date_edition = :date_edition, utilisateur_id_edition = :utilisateur_id_edition");
        $a->execute(array(
            'etablissement_code' => $code_ets,
            'commande_code' => $code,
            'fournisseur_code' => $code_fournisseur,
            'commande_date' => date('Y-m-d', time()),
            'commande_statut' => '0',
            'utilisateur_id_creation' => $user,
            'date_edition' => date('Y-m-d H:i:s', time()),
            'utilisateur_id_edition' => $user,
        ));
        if ($a->errorCode() == "00000") {
            return array(
                "success" => true,
                "code" => $code,
                "message" => 'Enregistrement effectué avec succès.'
            );
        } else {
            return array(
                "success" => false,
                "message" => $a->errorInfo()[2]
            );
        }
    }

    public function editer_commande_statut($code_ets, $code_commande, $statut, $motif, $user)
    {
        $a = $this->getBdd()->prepare("UPDATE tb_etablissements_commandes SET commande_statut = ?, commande_motif = ?, date_edition = ?, utilisateur_id_edition = ? WHERE commande_code = ? AND etablissement_code = ?");
        $a->execute(array($statut, $motif, date('Y-m-d H:i:s', time()), $user, $code_commande, $code_ets));
        if ($a->errorCode() == "00000") {
            return array(
                "success" => true,
                "message" => 'Enregistrement effectué avec succès.'
            );
        } else {
            return array(
                "success" => false,
                "message" => $a->errorInfo()[2]
            );
        }
    }

    public function ajouter_commande_produit($code_commande, $code_produit, $quantite, $prix_unitiare, $taux_remise, $user)
    {
        $a = $this->getBdd()->prepare("INSERT INTO tb_etablissements_commandes_produits(commande_code, produit_code, commande_quantite, commande_prix_unitaire, commande_taux_remise, utilisateur_id_creation) 
        VALUES(:commande_code, :produit_code, :commande_quantite, :commande_prix_unitaire, :commande_taux_remise, :utilisateur_id_creation)
        ON DUPLICATE KEY UPDATE commande_quantite = :commande_quantite, commande_prix_unitaire = :commande_prix_unitaire, commande_taux_remise = :commande_taux_remise, date_edition = :date_edition, utilisateur_id_edition = :utilisateur_id_edition");
        $a->execute(array(
            'commande_code' => $code_commande,
            'produit_code' => $code_produit,
            'commande_quantite' => $quantite,
            'commande_prix_unitaire' => $prix_unitiare,
            'commande_taux_remise' => $taux_remise,
            'utilisateur_id_creation' => $user,
            'date_edition' => date('Y-m-d H:i:s', time()),
            'utilisateur_id_edition' => $user
        ));
        if ($a->errorCode() == "00000") {
            return array(
                "success" => true,
                "message" => 'Enregistrement effectué avec succès.'
            );
        } else {
            return array(
                "success" => false,
                "message" => $a->errorInfo()[2]
            );
        }
    }

    public function lister_stock($code_ets)
    {
        $a = $this->getBdd()->prepare("
SELECT 
       etablissement_code AS code_etablissement, 
       commande_code AS code_commande, 
       stock_code AS code, 
       produit_code AS code_produit, 
       stock_quantite AS quantite, 
       stock_date_expiration AS date_expiration, 
       date_creation, 
       utilisateur_id_creation 
FROM 
     tb_etablissements_produits_stocks 
WHERE 
      etablissement_code = ? 
ORDER BY date_creation DESC");
        $a->execute(array($code_ets));
        return $a->fetchAll();
    }

    public function ajouter_commande_stock($code_ets, $code_commande, $code, $mouvement, $code_produit, $quantite, $date_expiration, $user)
    {
        if (!$code) {
            $stocks = $this->lister_stock($code_ets);
            $nb_stocks = count($stocks);
            $code = date('His', time()).str_pad((int)($nb_stocks + 1), 6, 0, STR_PAD_LEFT).date('Ymd', time());
        }
        $a = $this->getBdd()->prepare("INSERT INTO tb_etablissements_produits_stocks(etablissement_code, commande_code, stock_code, stock_mouvement, produit_code, stock_quantite, stock_date_expiration, utilisateur_id_creation)
        VALUES(:etablissement_code, :commande_code, :stock_code, :stock_mouvement, :produit_code, :stock_quantite, :stock_date_expiration, :utilisateur_id_creation)");
        $a->execute(array(
            'etablissement_code' => $code_ets,
            'commande_code' => $code_commande,
            'stock_code' => $code,
            'stock_mouvement' => $mouvement,
            'produit_code' => $code_produit,
            'stock_quantite' => $quantite,
            'stock_date_expiration' => $date_expiration,
            'utilisateur_id_creation' => $user
        ));
        if ($a->errorCode() == "00000") {
            return array(
                "success" => true,
                "code" => $code,
                "message" => 'Enregistrement effectué avec succès.'
            );
        } else {
            return array(
                "success" => false,
                "message" => $a->errorInfo()[2]
            );
        }
    }

    public function lister_commandes($code_ets)
    {
        $a = $this->getBdd()->prepare("
SELECT 
       A.etablissement_code AS code_etablissement, 
       A.commande_code AS code, 
       A.fournisseur_code AS code_fournisseur, 
       B.fournisseur_libelle AS libelle_fournisseur,
       A.commande_date AS date_commande, 
       A.commande_statut AS statut, 
       A.date_creation, 
       A.utilisateur_id_creation, 
       A.date_edition, 
       A.utilisateur_id_edition 
FROM 
     tb_etablissements_commandes A 
         JOIN tb_fournisseurs B 
             ON A.fournisseur_code = B.fournisseur_code
                    AND A.etablissement_code = ? 
ORDER BY 
         date_creation DESC");
        $a->execute(array($code_ets));
        return $a->fetchAll();
    }

    public function trouver_commande($code_ets, $code)
    {
        $a = $this->getBdd()->prepare("
SELECT 
       A.etablissement_code AS code_etablissement, 
       A.commande_code AS code, 
       A.fournisseur_code AS code_fournisseur, 
       B.fournisseur_libelle AS libelle_fournisseur,
       B.fournisseur_email AS email_fournisseur,
       B.fournisseur_num_telephone_1 AS numero_telephone,
       A.commande_date AS date_commande, 
       A.commande_statut AS statut, 
       A.date_creation, 
       A.utilisateur_id_creation, 
       C.utilisateur_nom AS nom,
       C.utilisateur_prenoms AS prenoms,
       A.date_edition, 
       A.utilisateur_id_edition 
FROM 
     tb_etablissements_commandes A 
         JOIN tb_fournisseurs B 
             ON A.fournisseur_code = B.fournisseur_code 
         JOIN tb_utilisateurs C 
             ON A.utilisateur_id_creation = C.utilisateur_id
                    AND A.etablissement_code = ? 
                    AND A.commande_code = ?
ORDER BY 
         date_creation DESC");
        $a->execute(array($code_ets, $code));
        return $a->fetch();
    }

    public function lister_commande_produits($code_commande)
    {
        $a = $this->getBdd()->prepare("
SELECT 
       A.commande_code AS code_commande, 
       A.produit_code AS code,
       B.produit_libelle AS libelle,
       A.commande_quantite AS quantite, 
       A.commande_prix_unitaire AS prix_unitaire, 
       A.commande_taux_remise AS taux_remise, 
       A.date_creation,
       A.utilisateur_id_creation
FROM 
     tb_etablissements_commandes_produits A 
         JOIN tb_etablissements_produits B 
             ON A.produit_code = B.produit_code 
                    AND A.commande_code = ?");
        $a->execute(array($code_commande));
        return $a->fetchAll();
    }

    public function lister_ventes($code_ets, $date_debut, $date_fin)
    {
        $a = $this->getBdd()->prepare("
SELECT 
       A.etablissement_code AS code_etablissement, 
       A.facture_medicale_num AS num_facture, 
       A.vente_code AS num_ticket, 
       A.vente_montant_brut AS montant_brut, 
       A.vente_montant_rgb AS montant_rgb, 
       A.vente_montant_organisme AS montant_organisme, 
       A.vente_taux_remise AS taux_remise, 
       A.vente_montant_net AS montant_net, 
       A.type_reglement_code AS code_type_reglement, 
       A.vente_montant_recu AS montant_recu, 
       A.vente_monnaie_rendue AS monnaie_rendue, 
       A.vente_statut AS statut, 
       A.date_creation, 
       A.utilisateur_id_creation,
       B.utilisateur_nom AS nom_caissier,
       B.utilisateur_prenoms AS prenom_caissier,
       A.date_edition, 
       A.utilisateur_id_edition 
FROM 
     tb_etablissements_ventes A 
         JOIN tb_utilisateurs B 
             ON A.utilisateur_id_creation = B.utilisateur_id 
                    AND A.etablissement_code = ? 
                    AND A.date_creation BETWEEN ? AND ? 
ORDER BY 
         date_creation DESC");
        $a->execute(array($code_ets, $date_debut, $date_fin));
        return $a->fetchAll();
    }

    public function trouver_vente($code_ets, $code_vente)
    {
        $a = $this->getBdd()->prepare("
SELECT 
       A.etablissement_code AS code_etablissement, 
       A.facture_medicale_num AS num_facture, 
       A.vente_code AS num_ticket, 
       A.vente_montant_brut AS montant_brut, 
       A.vente_montant_rgb AS montant_rgb, 
       A.vente_montant_organisme AS montant_organisme, 
       A.vente_taux_remise AS taux_remise, 
       A.vente_montant_net AS montant_net, 
       A.type_reglement_code AS code_type_reglement, 
       A.vente_montant_recu As montant_recu, 
       A.vente_monnaie_rendue AS monnaie_rendue, 
       A.vente_statut AS statut, 
       A.date_creation, 
       A.utilisateur_id_creation, 
       B.utilisateur_nom AS nom_caissier,
       B.utilisateur_prenoms AS prenoms_caissier,
       A.date_edition, 
       A.utilisateur_id_edition 
FROM 
     tb_etablissements_ventes A JOIN tb_utilisateurs B 
         ON A.utilisateur_id_creation = B.utilisateur_id
                AND A.etablissement_code = ? 
                AND A.vente_code = ?");
        $a->execute(array($code_ets, $code_vente));
        return $a->fetch();
    }

    public function lister_vente_produits($code_vente)
    {
        $a = $this->getBdd()->prepare("
SELECT 
       A.vente_code AS num_ticket, 
       A.produit_code AS code, 
       B.produit_libelle AS libelle,
       A.vente_produit_prix_unitaire AS prix_unitaire, 
       A.vente_produit_quantite AS quantite, 
       A.vente_produit_taux_rgb AS taux_rgb, 
       A.vente_produit_taux_organisme AS organisme, 
       A.vente_produit_taux_remise AS taux_remise, 
       A.date_creation, 
       A.utilisateur_id_creation, 
       A.date_edition, 
       A.utilisateur_id_edition 
FROM 
     tb_etablissements_ventes_produits A 
         JOIN tb_etablissements_produits B 
             ON A.produit_code = B.produit_code 
                    AND A.vente_code = ?");
        $a->execute(array($code_vente));
        return $a->fetchAll();
    }

    public function editer_vente($code_ets, $num_facture, $code, $montant_brut, $montant_rgb, $montant_organisme, $taux_remise, $montant_net, $code_type_reglement, $montant_recu, $monnaie_rendue, $user)
    {

        if (!$code) {
            $date_debut = date('Y-m-d 00:00:00', time());
            $date_fin = date('Y-m-d 23:59:59', time());
            $ventes = $this->lister_ventes($code_ets, $date_debut, $date_fin);
            $nb_ventes = count($ventes);
            $code = date('Ymd', time()).random_int(10000000, 99999999).str_pad((int)($nb_ventes + 1), 4, '0', STR_PAD_LEFT);
        }

        $a = $this->getBdd()->prepare("INSERT INTO tb_etablissements_ventes(etablissement_code, facture_medicale_num, vente_code, vente_montant_brut, vente_montant_rgb, vente_montant_organisme, vente_taux_remise, vente_montant_net, type_reglement_code, vente_montant_recu, vente_monnaie_rendue, utilisateur_id_creation) 
        VALUES(:etablissement_code, :facture_medicale_num, :vente_code, :vente_montant_brut, :vente_montant_rgb, :vente_montant_organisme, :vente_taux_remise, :vente_montant_net, :type_reglement_code, :vente_montant_recu, :vente_monnaie_rendue, :utilisateur_id_creation)");
        $a->execute(array(
            'etablissement_code' => $code_ets,
            'facture_medicale_num' => $num_facture,
            'vente_code' => $code,
            'vente_montant_brut' => $montant_brut,
            'vente_montant_rgb' => $montant_rgb,
            'vente_montant_organisme' => $montant_organisme,
            'vente_taux_remise' => $taux_remise,
            'vente_montant_net' => $montant_net,
            'type_reglement_code' => $code_type_reglement,
            'vente_montant_recu' => $montant_recu,
            'vente_monnaie_rendue' => $monnaie_rendue,
            'utilisateur_id_creation' => $user
        ));
        if ($a->errorCode() == "00000") {
            $recette =  $this->ajouter_depense($code_ets, 'R', null, null, null, "PHARMACIE TICKET N° {$code} DU ".date('d/m/Y', time()), $montant_net, null, $user);
            if ($recette['success'] == true) {
                return array(
                    "success" => true,
                    "code" => $code,
                    "message" => 'Enregistrement effectué avec succès.'
                );
            } else {
                return $recette;
            }
        } else {
            return array(
                "success" => false,
                "message" => $a->errorInfo()[2]
            );
        }
    }

    public function editer_vente_produits($code_ets, $code_vente, $code_produit, $prix_unitaire, $quantite, $taux_rgb, $taux_organisme, $taux_remise, $user)
    {
        $a = $this->getBdd()->prepare("INSERT INTO tb_etablissements_ventes_produits(vente_code, produit_code, vente_produit_prix_unitaire, vente_produit_quantite, vente_produit_taux_rgb, vente_produit_taux_organisme, vente_produit_taux_remise, utilisateur_id_creation)
        VALUES(:vente_code, :produit_code, :vente_produit_prix_unitaire, :vente_produit_quantite, :vente_produit_taux_rgb, :vente_produit_taux_organisme, :vente_produit_taux_remise, :utilisateur_id_creation)");
        $a->execute(array(
            'vente_code' => $code_vente,
            'produit_code' => $code_produit,
            'vente_produit_prix_unitaire' => $prix_unitaire,
            'vente_produit_quantite' => $quantite,
            'vente_produit_taux_rgb' => $taux_rgb,
            'vente_produit_taux_organisme' => $taux_organisme,
            'vente_produit_taux_remise' => $taux_remise,
            'utilisateur_id_creation' => $user
        ));
        if ($a->errorCode() == "00000") {
            return $this->ajouter_commande_stock($code_ets, null, null, 'S', $code_produit, $quantite, null, $user);
        } else {
            return array(
                "success" => false,
                "message" => $a->errorInfo()[2]
            );
        }
    }

    public function lister_nouveau_bordereau_factures($code_ets, $code_organsime, $code_type_facture, $date_debut, $date_fin)
    {
        $a = $this->getBdd()->prepare("
SELECT 
       B.etablissement_code AS code_etablissement,
       A.facture_medicale_date AS date_facture, 
       A.organisme_code AS code_organisme, 
       A.organisme_contrat_collectivite_code, 
       A.organisme_contrat_collectivite_taux, 
       A.dossier_code AS code_dossier, 
       A.type_facture_code AS code_type_facture, 
       A.facture_medicale_num AS num_facture, 
       A.facture_medicale_initiale_num AS num_facture_initiale, 
       A.organisme_facture_num AS num_bon, 
       A.professionnel_code AS code_professionnel, 
       A.facture_medicale_taux_remise AS remise, 
       A.statut_code AS code_statut, 
       A.date_creation, 
       A.utilisateur_id_creation, 
       A.date_edition, 
       A.utilisateur_id_edition 
FROM 
     tb_factures_medicales A 
         JOIN tb_patients_dossiers B 
             ON A.dossier_code = B.dossier_code 
                    AND B.etablissement_code = ? 
                    AND A.organisme_code = ?
                    AND A.type_facture_code = ?
                    AND A.facture_medicale_date BETWEEN ? AND ?
                    AND A.statut_code = ? 
                    AND A.organisme_contrat_collectivite_taux != ? 
                    AND A.bordereau_num IS NULL
ORDER BY 
         date_creation DESC");
        $a->execute(array($code_ets, $code_organsime, $code_type_facture, $date_debut, $date_fin, 'P', 0));
        return $a->fetchAll();
    }

    public function editer_profil($code_ets, $code, $libelle, $user)
    {
        if (!$code) {
            $profils = $this->lister_profils(null);
            $nb_profils = count($profils);
            $code = 'PU'.str_pad((int)($nb_profils + 1), 8, '0', STR_PAD_LEFT);
        }
        $a = $this->getBdd()->prepare("INSERT INTO tb_utilisateurs_etablissements_profils(etablissement_code, etablissement_profil_code, etablissement_profil_libelle, utilisateur_id_creation) 
        VALUES(:etablissement_code, :etablissement_profil_code, :etablissement_profil_libelle, :utilisateur_id_creation)
        ON DUPLICATE KEY UPDATE etablissement_profil_libelle = :etablissement_profil_libelle, date_edition = :date_edition, utilisateur_id_edition = :utilisateur_id_edition");
        $a->execute(array(
            'etablissement_code' => $code_ets,
            'etablissement_profil_code' => $code,
            'etablissement_profil_libelle' => $libelle,
            'utilisateur_id_creation' => $user,
            'date_edition' => date('Y-m-d H:i:s', time()),
            'utilisateur_id_edition' => $user
        ));
        if ($a->errorCode() == "00000") {
            return array(
                "success" => true,
                "code" => $code,
                "message" => 'Enregistrement effectué avec succès.'
            );
        } else {
            return array(
                "success" => false,
                "message" => $a->errorInfo()[2]
            );
        }
    }

    public function editer_profil_habilitations($code_ets, $code, $modules, $sous_modules, $user)
    {
        $a = $this->getBdd()->prepare("UPDATE tb_utilisateurs_etablissements_profils SET etablissement_profil_modules = ?, etablissement_profil_sous_modules = ?, date_edition = ?, utilisateur_id_edition = ? WHERE etablissement_profil_code = ? AND etablissement_code = ?");
        $a->execute(array($modules, $sous_modules, date('Y-m-d H:i:s', time()), $user, $code, $code_ets));
        if ($a->errorCode() === "00000") {
            return array(
                "success" => true,
                "message" => 'Enregistrement effectué avec succès.'
            );
        } else {
            return array(
                "success" => false,
                "message" => $a->errorInfo()[2]
            );
        }
    }

    public function trouver_profil($code_ets, $code)
    {
        $a = $this->getBdd()->prepare("
SELECT 
       etablissement_code AS code_etablissement, 
       etablissement_profil_code AS code, 
       etablissement_profil_libelle AS libelle, 
       etablissement_profil_modules AS modules, 
       etablissement_profil_sous_modules AS sous_modules, 
       date_creation, 
       utilisateur_id_creation, 
       date_edition, 
       utilisateur_id_edition 
FROM 
     tb_utilisateurs_etablissements_profils 
WHERE 
      etablissement_code = ? 
  AND etablissement_profil_code = ?");
        $a->execute(array($code_ets, $code));
        return $a->fetch();
    }

    public function lister_profils($code_ets)
    {
        $a = $this->getBdd()->prepare("
SELECT 
       etablissement_code AS code_etablissement, 
       etablissement_profil_code AS code, 
       etablissement_profil_libelle AS libelle, 
       date_creation, 
       utilisateur_id_creation, 
       date_edition, 
       utilisateur_id_edition 
FROM 
     tb_utilisateurs_etablissements_profils 
WHERE 
      etablissement_code LIKE ? 
ORDER BY 
         etablissement_profil_libelle");
        $a->execute(array('%'.$code_ets.'%'));
        return $a->fetchAll();
    }

    private function ajouter_habilitations($code_profil, $id_user, $user)
    {
        $a = $this->getBdd()->prepare("INSERT INTO tb_utilisateurs_etablissements_profils_habilitations(etablissement_profil_code, utilisateur_id, habilitations_date_debut, utilisateur_id_creation)
        VALUES(:etablissement_profil_code, :utilisateur_id, :habilitations_date_debut, :utilisateur_id_creation)");
        $a->execute(array(
            'etablissement_profil_code' => $code_profil,
            'utilisateur_id' => $id_user,
            'habilitations_date_debut' => date('Y-m-d H:i:s', time()),
            'utilisateur_id_creation' => $user
        ));
        if ($a->errorCode() === "00000") {
            return array(
                "success" => true,
                "message" => 'Enregistrement effectué avec succès.'
            );
        } else {
            return array(
                "success" => false,
                "message" => $a->errorInfo()[2]
            );
        }
    }

    private function fermer_habilitations($code_profil, $id_user, $date_fin, $user)
    {
        $a = $this->getBdd()->prepare("UPDATE tb_utilisateurs_etablissements_profils_habilitations SET habilitations_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE etablissement_profil_code = ? AND utilisateur_id = ? AND habilitations_date_fin IS NULL");
        $a->execute(array($date_fin, date('Y-m-d H:i:s', time()), $user, $code_profil, $id_user));
        if ($a->errorCode() === "00000") {
            return array(
                "success" => true,
                "message" => 'Enregistrement effectué avec succès.'
            );
        } else {
            return array(
                "success" => false,
                "message" => $a->errorInfo()[2]
            );
        }
    }

    public function editer_habilitations($code_profil, $id_user, $user)
    {
        $habilitations = $this->trouver_habilitations($id_user);
        if ($habilitations) {
            if ($habilitations['code_profil'] !== $code_profil) {
                $date_fin = date('Y-m-d H:i:s', time());
                $fermer = $this->fermer_habilitations($code_profil, $id_user, $date_fin, $user);
                if ($fermer['success'] === true) {
                    return $this->ajouter_habilitations($code_profil, $id_user, $user);
                }
            } else {
                return array(
                    'success' => false,
                    'message' => "Profil utilisateur déjà défini."
                );
            }
        } else {
            return $this->ajouter_habilitations($code_profil, $id_user, $user);
        }
    }

    public function trouver_habilitations($id_user)
    {
        $a = $this->getBdd()->prepare("
SELECT 
       A.utilisateur_id AS id_user, 
       A.etablissement_profil_code AS code_profil,
       B.etablissement_profil_modules AS modules,
       B.etablissement_profil_sous_modules AS sous_modules,
       A.habilitations_date_debut AS date_debut
FROM 
     tb_utilisateurs_etablissements_profils_habilitations A 
         JOIN tb_utilisateurs_etablissements_profils B 
             ON A.etablissement_profil_code = B.etablissement_profil_code 
                    AND A.utilisateur_id = ? 
                    AND A.habilitations_date_fin IS NULL");
        $a->execute(array($id_user));
        return $a->fetch();
    }

    public function lister_chambres($code_ets)
    {
        $a = $this->getBdd()->prepare("
SELECT 
       etablissement_code AS code_etablissement, 
       chambre_code AS code, 
       chambre_libelle AS libelle, 
       chambre_date_debut AS date_debut, 
       chambre_date_fin AS date_fin, 
       date_creation, 
       utilisateur_id_creation, 
       date_edition, 
       utilisateur_id_edition 
FROM 
     tb_etablissements_chambres 
WHERE 
      etablissement_code LIKE ? 
ORDER BY 
         chambre_libelle");
        $a->execute(array('%'.$code_ets.'%'));
        return $a->fetchAll();
    }

    public function trouver_chambre($code_ets, $code)
    {
        $a = $this->getBdd()->prepare("
SELECT 
       etablissement_code AS code_etablissement, 
       chambre_code AS code, 
       chambre_libelle AS libelle, 
       chambre_date_debut AS date_debut, 
       chambre_date_fin AS date_fin, 
       date_creation, 
       utilisateur_id_creation, 
       date_edition, 
       utilisateur_id_edition 
FROM 
     tb_etablissements_chambres 
WHERE 
      etablissement_code = ? 
  AND chambre_code = ?");
        $a->execute(array($code_ets, $code));
        return $a->fetch();
    }

    private function ajouter_chambre($code_ets, $code, $libelle, $user)
    {
        if(!$code) {
            $chambres = $this->lister_chambres(null);
            $nb_chambres = count($chambres);
            $code = 'CHB'.str_pad((int)($nb_chambres + 1), 7, '0', STR_PAD_LEFT);
        }
        $a = $this->getBdd()->prepare("INSERT INTO tb_etablissements_chambres(etablissement_code, chambre_code, chambre_libelle, chambre_date_debut, utilisateur_id_creation)
        VALUES(:etablissement_code, :chambre_code, :chambre_libelle, :chambre_date_debut, :utilisateur_id_creation)");
        $a->execute(array(
            'etablissement_code' => $code_ets,
            'chambre_code' => $code,
            'chambre_libelle' => $libelle,
            'chambre_date_debut' => date('Y-m-d', time()),
            'utilisateur_id_creation' => $user
        ));
        if ($a->errorCode() === "00000") {
            return array(
                "success" => true,
                "code" => $code,
                "message" => 'Enregistrement effectué avec succès.'
            );
        } else {
            return array(
                "success" => false,
                "message" => $a->errorInfo()[2]
            );
        }
    }

    public function fermer_chambre($code_ets, $code, $date_fin, $user)
    {
        $a = $this->getBdd()->prepare("UPDATE tb_etablissements_chambres SET chambre_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE etablissement_code = ? AND chambre_code = ? AND chambre_date_fin IS NULL");
        $a->execute(array($date_fin, date('Y-m-d H:i:s', time()), $user, $code_ets, $code));
        if ($a->errorCode() === "00000") {
            return array(
                "success" => true,
                "code" => $code,
                "message" => 'Enregistrement effectué avec succès.'
            );
        } else {
            return array(
                "success" => false,
                "message" => $a->errorInfo()[2]
            );
        }
    }

    public function editer_chambre($code_ets, $code, $libelle, $user)
    {
        $chambre = $this->trouver_chambre($code_ets, $code);
        if ($chambre) {
            if (!$chambre['date_fin']) {
                $date_fin = date('Y-m-d', strtotime('-1 day', time()));
                if (strtotime($date_fin) > strtotime($chambre['date_debut'])) {
                    $edition = $this->fermer_chambre($code_ets, $chambre['code'], $date_fin, $user);
                    if ($edition['success'] === true) {
                        $json = $this->ajouter_chambre($code_ets, $code, $libelle, $user);
                    } else {
                        $json = $edition;
                    }
                } else {
                    $json = array(
                        'success' => false,
                        'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le ".date('d/m/Y', strtotime('+2 day', strtotime($chambre['date_debut'])))
                    );
                }
            } else {
                $json = $this->ajouter_chambre($code_ets, $code, $libelle, $user);
            }
        } else {
            $json = $this->ajouter_chambre($code_ets, $code, $libelle, $user);
        }
        return $json;
    }
}
