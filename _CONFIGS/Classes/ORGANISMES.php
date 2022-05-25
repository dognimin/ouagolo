<?php
namespace App;

class ORGANISMES extends BDD
{
    public function editer($code, $code_rgb, $libelle, $adresse_postale, $adresse_geographique, $code_pays, $code_region, $code_departement, $code_commune, $latitude, $longitude, $date_fin, $motif_fin, $user): array
    {
        if($code) {
            $organisme = $this->trouver($code);
            if ($organisme) {
                if ($date_fin) {
                    return $this->fermer($code, $date_fin, $motif_fin, $user);
                } else {
                    return $this->modifier($code, $code_rgb, $libelle, $adresse_postale, $adresse_geographique, $code_pays, $code_region, $code_departement, $code_commune, $latitude, $longitude, $user);
                }
            } else {
                return $this->ajouter($code_rgb, $libelle, $adresse_postale, $adresse_geographique, $code_pays, $code_region, $code_departement, $code_commune, $latitude, $longitude, $user);
            }
        }else {
            return $this->ajouter($code_rgb, $libelle, $adresse_postale, $adresse_geographique, $code_pays, $code_region, $code_departement, $code_commune, $latitude, $longitude, $user);
        }
    }

    public function trouver($code)
    {
        $a = $this->getBdd()->prepare("
SELECT 
       A.organisme_code AS code, 
       A.rgb_code AS code_rgb, 
       A.organisme_libelle AS libelle, 
       A.organisme_adresse_postale AS adresse_postale, 
       A.organisme_adresse_geographique AS adresse_geographique, 
       A.organisme_date_debut AS date_debut, 
       A.organisme_logo AS logo, 
       B.pays_code AS code_pays, 
       B.pays_nom AS nom_pays,
       B.monnaie_code AS code_monnaie,
       F.monnaie_libelle AS libelle_monnaie,
       F.monnaie_symbole AS symbole_monnaie,
       C.region_code AS code_region, 
       C.region_nom AS nom_region,
       D.departement_code AS code_departement, 
       D.departement_nom AS nom_departement,
       E.commune_code AS code_commune, 
       E.commune_nom AS nom_commune,
       A.organisme_latitude AS latitude, 
       A.organisme_longitude AS longitude, 
       A.date_creation, 
       A.utilisateur_id_creation, 
       A.date_edition, 
       A.utilisateur_id_edition 
FROM 
     tb_organismes A 
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
                    AND A.organisme_code = ? 
                    AND B.pays_date_fin IS NULL 
                    AND C.region_date_fin IS NULL 
                    AND D.departement_date_fin IS NULL 
                    AND E.commune_date_fin IS NULL 
                    AND A.organisme_date_fin IS NULL
                    AND F.monnaie_date_fin IS NULL");
        $a->execute(array($code));
        return $a->fetch();
    }

    private function fermer($code, $date_fin, $motif, $user): array
    {
        $a = $this->getBdd()->prepare("UPDATE tb_organismes SET organisme_date_fin = ?, organisme_motif_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE organisme_code = ?");
        $a->execute(array($date_fin, $motif, date('Y-m-d H:i:s', time()), $user, $code));
        if ($a->errorCode() == '00000') {
            return array(
                'success' => true,
                'code_organisme' => $code,
                'message' => 'Mise à jour effectuée avec succès.'
            );
        } else {
            return array(
                'success' => false,
                'code' => $a->errorCode(),
                'message' => $a->errorInfo()[2]
            );
        }
    }

    private function modifier($code, $code_rgb, $libelle, $adresse_postale, $adresse_geographique, $code_pays, $code_region, $code_departement, $code_commune, $latitude, $longitude, $user): array
    {
        $a = $this->getBdd()->prepare("UPDATE tb_organismes SET rgb_code = ?, organisme_libelle = ?, organisme_adresse_postale = ?, organisme_adresse_geographique = ?, pays_code = ?, region_code = ?, departement_code = ?, commune_code = ?, organisme_latitude = ?, organisme_longitude = ?, date_edition = ?, utilisateur_id_edition = ? WHERE organisme_code = ?");
        $a->execute(array($code_rgb, $libelle, $adresse_postale, $adresse_geographique, $code_pays, $code_region, $code_departement, $code_commune, $latitude, $longitude, date('Y-m-d H:i:s', time()), $user, $code));
        if ($a->errorCode() == '00000') {
            return array(
                'success' => true,
                'code_organisme' => $code,
                'message' => 'Mise à jour effectuée avec succès.'
            );
        } else {
            return array(
                'success' => false,
                'code' => $a->errorCode(),
                'message' => $a->errorInfo()[2]
            );
        }
    }

    private function ajouter($code_rgb, $libelle, $adresse_postale, $adresse_geographique, $code_pays, $code_region, $code_departement, $code_commune, $latitude, $longitude, $user): array
    {
        $organismes = $this->lister();
        $nb_organismes = count($organismes);
        $code = 'ORG'.str_pad(intval($nb_organismes + 1), 5,'0',STR_PAD_LEFT);
        $a = $this->getBdd()->prepare("INSERT INTO tb_organismes(organisme_code, rgb_code, organisme_libelle, organisme_adresse_postale, organisme_adresse_geographique, pays_code, region_code, departement_code, commune_code, organisme_latitude, organisme_longitude, organisme_date_debut, utilisateur_id_creation) 
        VALUES(:organisme_code, :rgb_code, :organisme_libelle, :organisme_adresse_postale, :organisme_adresse_geographique, :pays_code, :region_code, :departement_code, :commune_code, :organisme_latitude, :organisme_longitude, :organisme_date_debut, :utilisateur_id_creation)");
        $a->execute(array(
            'organisme_code' => $code,
            'rgb_code' => $code_rgb,
            'organisme_libelle' => $libelle,
            'organisme_adresse_postale' => $adresse_postale,
            'organisme_adresse_geographique' => $adresse_geographique,
            'pays_code' => $code_pays,
            'region_code' => $code_region,
            'departement_code' => $code_departement,
            'commune_code' => $code_commune,
            'organisme_latitude' => $latitude,
            'organisme_longitude' => $longitude,
            'organisme_date_debut' => date('Y-m-d', time()),
            'utilisateur_id_creation' => $user
        ));
        if ($a->errorCode() == '00000') {
            return array(
                'success' => true,
                'code_organisme' => $code,
                'message' => 'Enregistement effectué avec succès.'
            );
        } else {
            return array(
                'success' => false,
                'code' => $a->errorCode(),
                'message' => $a->errorInfo()[2]
            );
        }
    }

    public function lister()
    {
        $a = $this->getBdd()->prepare("
SELECT 
       A.organisme_code AS code, 
       A.rgb_code AS code_rgb, 
       A.organisme_libelle AS libelle, 
       A.organisme_adresse_postale AS adresse_postale, 
       A.organisme_adresse_geographique AS adresse_geographique, 
       A.organisme_date_debut AS date_debut, 
       B.pays_code AS code_pays, 
       B.pays_nom AS nom_pays,
       C.region_code AS code_region, 
       C.region_nom AS nom_region,
       D.departement_code AS code_departement, 
       D.departement_nom AS nom_departement,
       E.commune_code AS code_commune, 
       E.commune_nom AS nom_commune,
       A.date_creation, 
       A.utilisateur_id_creation, 
       A.date_edition, 
       A.utilisateur_id_edition 
FROM 
     tb_organismes A 
         JOIN tb_ref_geo_pays B 
             ON A.pays_code = B.pays_code 
         JOIN tb_ref_geo_regions C 
             ON A.region_code = C.region_code 
         JOIN tb_ref_geo_departements D 
             ON A.departement_code = D.departement_code 
         JOIN tb_ref_geo_communes E 
             ON A.commune_code = E.commune_code
                    AND B.pays_date_fin IS NULL 
                    AND C.region_date_fin IS NULL 
                    AND D.departement_date_fin IS NULL 
                    AND E.commune_date_fin IS NULL 
                    AND A.organisme_date_fin IS NULL 
ORDER BY 
         A.organisme_libelle
        ");
        $a->execute(array());
        return $a->fetchAll();
    }

    public function editer_utilisateur($id_user, $code, $user): array
    {
        $organisme = $this->trouver_utilisateur($code, $id_user);
        if ($organisme) {
            $date_fin = date('Y-m-d H:i:s', time());
            return $this->fermer_utilisateur($id_user, $code, $date_fin, $user);
        } else {
            return $this->ajouter_utilisateur($id_user, $code, $user);
        }
    }

    public function fermer_utilisateur($id_user, $code, $date_fin, $user): array
    {
        $a = $this->getBdd()->prepare("UPDATE tb_utilisateurs_organismes SET utilisateur_organisme_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE organisme_code = ? AND utilisateur_id = ? AND utilisateur_organisme_date_fin IS NULL");
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
        $a = $this->getBdd()->prepare("INSERT INTO tb_utilisateurs_organismes(utilisateur_id, organisme_code, utilisateur_organisme_date_debut, utilisateur_id_creation) 
        VALUES(:utilisateur_id, :organisme_code, :utilisateur_organisme_date_debut, :utilisateur_id_creation)");
        $a->execute(array(
            'utilisateur_id' => $id_user,
            'organisme_code' => $code,
            'utilisateur_organisme_date_debut' => date('Y-m-d H:i:s', time()),
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

    public function lister_utilisateurs($code_organisme)
    {
        $query = "
SELECT 
       A.utilisateur_id AS id_user, 
       A.utilisateur_email AS email, 
       A.utilisateur_num_secu AS num_secu, 
       A.civilite_code AS code, 
       A.utilisateur_prenoms AS prenoms, 
       A.utilisateur_nom AS nom, 
       A.utilisateur_nom_patronymique AS nom_patronymique, 
       A.utilisateur_date_naissance AS date_naissance, 
       A.sexe_code AS code_sexe, 
       A.situation_familiale_code AS code_situation_familiale,
       C.statut AS statut,       
       A.date_creation, 
       A.utilisateur_id_creation, 
       A.date_edition, 
       A.utilisateur_id_edition 
FROM 
     tb_utilisateurs A 
         JOIN tb_utilisateurs_organismes B 
             ON A.utilisateur_id = B.utilisateur_id 
         JOIN tb_utilisateurs_statuts C 
             ON A.utilisateur_id = C.utilisateur_id
                    AND B.utilisateur_organisme_date_fin IS NULL
                    AND C.statut_passe_date_fin IS NULL
                    AND B.organisme_code = ?
ORDER BY A.utilisateur_prenoms, A.utilisateur_nom
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code_organisme));
        return $a->fetchAll();
    }

    public function trouver_utilisateur($code, $id_user)
    {
        $query = "
SELECT 
       A.organisme_code AS code, 
       A.utilisateur_id AS id_user, 
       A.utilisateur_organisme_date_debut AS date_debut,
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
     tb_utilisateurs_organismes A 
         JOIN tb_utilisateurs B 
             ON A.utilisateur_id = B.utilisateur_id 
                    AND A.organisme_code = ? 
                    AND A.utilisateur_id = ? 
                    AND A.utilisateur_organisme_date_fin IS NULL
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code, $id_user));
        return $a->fetch();
    }

    public function moteur_recherche($code, $code_rgb, $libelle, $code_ays)
    {
        $a = $this->getBdd()->prepare("
SELECT 
       A.organisme_code AS code, 
       A.rgb_code AS code_rgb, 
       A.organisme_libelle AS libelle, 
       A.organisme_adresse_postale AS adresse_postale, 
       A.organisme_adresse_geographique AS adresse_geographique, 
       A.organisme_date_debut AS date_debut, 
       B.pays_code AS code_pays, 
       B.pays_nom AS nom_pays,
       C.region_code AS code_region, 
       C.region_nom AS nom_region,
       D.departement_code AS code_departement, 
       D.departement_nom AS nom_departement,
       E.commune_code AS code_commune, 
       E.commune_nom AS nom_commune,
       A.date_creation, 
       A.utilisateur_id_creation, 
       A.date_edition, 
       A.utilisateur_id_edition 
FROM 
     tb_organismes A 
         JOIN tb_ref_geo_pays B 
             ON A.pays_code = B.pays_code 
         JOIN tb_ref_geo_regions C 
             ON A.region_code = C.region_code 
         JOIN tb_ref_geo_departements D 
             ON A.departement_code = D.departement_code 
         JOIN tb_ref_geo_communes E 
             ON A.commune_code = E.commune_code
                    AND A.organisme_code LIKE ? 
                    AND A.rgb_code LIKE ? 
                    AND A.organisme_libelle LIKE ? 
                    AND B.pays_code LIKE ?
                    AND B.pays_date_fin IS NULL 
                    AND C.region_date_fin IS NULL 
                    AND D.departement_date_fin IS NULL 
                    AND E.commune_date_fin IS NULL 
                    AND A.organisme_date_fin IS NULL 
ORDER BY 
         A.organisme_libelle
        ");
        $a->execute(array('%'.$code.'%', '%'.$code_rgb.'%', '%'.$libelle.'%', '%'.$code_ays.'%'));
        return $a->fetchAll();
    }

    public function lister_pays()
    {
        $a = $this->getBdd()->prepare("SELECT A.pays_code AS code_pays, B.pays_nom AS nom_pays, COUNT(DISTINCT A.organisme_code) FROM tb_organismes A JOIN tb_ref_geo_pays B ON A.pays_code = B.pays_code AND A.organisme_date_fin IS NULL AND B.pays_date_fin IS NULL GROUP BY A.pays_code, B.pays_nom ORDER BY B.pays_nom");
        $a->execute(array());
        return $a->fetchAll();
    }

    public function editer_assure($code, $num_population, $user): array
    {
        $patient = $this->trouver_assure($code, $num_population);
        if ($patient) {
            $date_fin = date('Y-m-d', strtotime('-1 day', time()));
            if (strtotime($date_fin) > strtotime($patient['date_debut'])) {
                $edition = $this->fermer_assure($patient['code_ets'], $num_population, $date_fin, $user);
                if ($edition['success'] == true) {
                    $json = $this->ajouter_assure($code, $num_population, $user);
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
            $json = $this->ajouter_assure($code, $num_population, $user);
        }
        return $json;
    }

    public function trouver_assure($code, $num_population)
    {
        $query = "
SELECT 
       A.organisme_code AS code_ets,
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
       B.naissance_pays_code AS code_pays_naissance,
       B.naissance_region_code AS code_region_naissance,
       B.naissance_departement_code AS code_departement_naissance,
       B.naissance_commune_code AS code_commune_naissance,
       B.naissance_lieu AS lieu_naissance,
       B.nationalite_code AS code_nationalite,
       B.residence_pays_code AS code_pays_residence,
       B.residence_region_code AS code_region_residence,
       B.residence_departement_code AS code_departement_residence,
       B.residence_commune_code AS code_commune_residence,
       B.residence_adresse_postale AS adresse_postale,
       B.residence_adresse_geographique AS adresse_geographique,
       B.groupe_sanguin_code AS code_groupe_sanguin,
       B.rhesus_code AS code_rhesus,
       B.population_photo AS photo,
       A.organisme_assure_date_fin AS date_debut,
       B.population_date_deces AS date_deces
FROM 
     tb_organismes_assures A 
         JOIN tb_populations B 
             ON A.population_num = B.population_num 
                    AND A.organisme_assure_date_fin IS NULL 
                    AND A.organisme_code = ? 
                    AND A.population_num = ?";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code, $num_population));
        return $a->fetch();
    }

    private function fermer_assure($code, $num_population, $date_fin, $user): array
    {
        $a = $this->getBdd()->prepare("UPDATE tb_organismes_assures SET organisme_assure_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE organisme_code = ? AND population_num = ? AND organisme_assure_date_fin IS NULL");
        $a->execute(array($date_fin, date('Y-m-d H:i:s', time()), $user, $code, $num_population));

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

    private function ajouter_assure($code, $num_population, $user): array
    {
        $a = $this->getBdd()->prepare("INSERT INTO tb_organismes_assures(organisme_code, population_num, organisme_assure_date_debut, utilisateur_id_creation) 
        VALUES(:organisme_code, :population_num, :organisme_assure_date_debut, :utilisateur_id_creation)");
        $a->execute(array(
            'organisme_code' => $code,
            'population_num' => $num_population,
            'organisme_assure_date_debut' => date('Y-m-d', time()),
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

    public function moteur_recherche_assures($code, $num_population, $num_rgb, $nom_prenoms, $code_collectivite) {
        $a = $this->getBdd()->prepare("
SELECT 
       A.organisme_code AS code_organisme,
       C.collectivite_code AS code_collectivite,
       D.collectivite_raison_sociale AS raison_sociale,
       A.population_num AS num_population, 
       B.rgb_num AS num_rgb, 
       B.civilite_code AS code_civilite, 
       B.population_nom AS nom, 
       B.population_prenoms AS prenoms, 
       B.population_date_naissance AS date_naissance
FROM 
     tb_organismes_assures A 
         JOIN tb_populations B 
             ON A.population_num = B.population_num 
         JOIN tb_populations_collectivites C 
             ON B.population_num = C.population_num 
         JOIN tb_ref_collectivites D 
             ON C.collectivite_code = D.collectivite_code
                    AND A.organisme_code = ?
                    AND B.rgb_num LIKE ?
                    AND A.population_num LIKE ?
                    AND CONCAT(B.population_nom, ' ',B.population_prenoms) LIKE ?
                    AND C.collectivite_code LIKE ?
                    AND A.organisme_assure_date_fin IS NULL 
                    AND C.population_collectivite_date_fin IS NULL
ORDER BY 
         B.population_nom, 
         B.population_prenoms");
        $a->execute(array($code, '%'.$num_rgb.'%', '%'.$num_population.'%', '%'.$nom_prenoms.'%', '%'.$code_collectivite.'%'));
        return $a->fetchAll();
    }

    public function trouver_acte($code, $code_produit, $code_ets, $code_acte, $date_soins) {
        $a = $this->getBdd()->prepare("
SELECT 
       A.organisme_code AS code_organisme, 
       A.produit_code AS code_produit, 
       A.reseau_soins_code AS code_reseau_soins,
       B.etablissement_code AS code_etablissement,
       C.acte_code AS code_acte, 
       C.panier_soins_acte_tarif AS tarif
FROM 
     tb_organismes_produits A 
         JOIN tb_reseaux_soins_etablissements B 
             ON A.reseau_soins_code = B.reseau_soins_code 
         JOIN tb_paniers_soins_actes_medicaux C 
             ON A.panier_soins_code = C.panier_soins_code
                    AND A.organisme_code = ?
                    AND A.produit_code = ?
                    AND B.etablissement_code = ?
                    AND C.acte_code = ?
                    AND A.produit_date_debut <= ? 
                    AND (A.produit_date_fin IS NULL OR A.produit_date_fin >= ?) 
                    AND B.reseau_soins_etablissement_date_debut <= ? 
                    AND (B.reseau_soins_etablissement_date_fin IS NULL OR B.reseau_soins_etablissement_date_fin >= ?) 
                    AND C.panier_soins_acte_date_debut <= ? 
                    AND (C.panier_soins_acte_date_fin IS NULL OR C.panier_soins_acte_date_fin >= ?)");
        $a->execute(array($code, $code_produit, $code_ets, $code_acte, $date_soins, $date_soins, $date_soins, $date_soins, $date_soins, $date_soins));
        return $a->fetch();
    }
}
