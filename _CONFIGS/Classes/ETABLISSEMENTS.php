<?php


class ETABLISSEMENTS extends BDD
{


    public function monteur_recherche($niveau, $code, $type_etablissement, $raison_sociale): array
    {
        $query = "
SELECT 
       A.etablissement_code AS code, 
       A.type_etablissement_code AS type_code, 
       A.raison_sociale  AS raison_sociale, 
       A.niveau_code AS niveau_sanitaire, 
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
       A.utilisation_id_creation , 
       A.date_edition, 
       A.utilisation_id_edition  
FROM 
     tb_etablissements A 
WHERE
      A.niveau_code LIKE ? 
  AND A.etablissement_code LIKE ? 
  AND A.type_etablissement_code LIKE ? 
  AND A.raison_sociale LIKE ? 

ORDER BY A.raison_sociale, A.etablissement_code
";
        $a = $this->bdd->prepare($query);
        $a->execute(array('%' . $niveau . '%', '%' . $code . '%', '%' . $type_etablissement . '%', '%' . $raison_sociale . '%'));
        return $a->fetchAll();
    }


    private function ajouter_type_ets($code_niveau, $code, $libelle, $user)
    {
        $a = $this->bdd->prepare("INSERT INTO tb_etablissements_types(niveau_sanitaire_code,type_etablissement_code,type_etablissement_libelle,type_etablissement_date_debut,utilisateur_id_creation)
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

    private function ajouter_etablissement($code_etablissement, $type_etab, $raison_sociale, $niveau, $pays_code, $region_code, $departement_code, $commune_code, $latitude, $longitude, $secteur_activte, $adresse_geo, $adresse_post, $user)
    {
        $a = $this->bdd->prepare("INSERT INTO tb_etablissements(etablissement_code,type_etablissement_code,raison_sociale,niveau_code,pays_code,region_code,departement_code,commune_code,latitude,longitude,secteur_activite_code,adresse_geographique,adresse_postale,etablissement_date_debut,utilisation_id_creation)
        VALUES(:etablissement_code,:type_etablissement_code,:raison_sociale,:niveau_code,:pays_code,:region_code,:departement_code,:commune_code,:latitude,:longitude,:secteur_activite_code,:adresse_geographique,:adresse_postale,:etablissement_date_debut,:utilisateur_id_creation) 
        ");
        $a->execute(array(
            'etablissement_code' => $code_etablissement,
            'type_etablissement_code' => $type_etab,
            'raison_sociale' => $raison_sociale,
            'niveau_code' => $niveau,
            'pays_code' => $pays_code,
            'region_code' => $region_code,
            'departement_code' => $departement_code,
            'commune_code' => $commune_code,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'secteur_activite_code' => $secteur_activte,
            'adresse_geographique' => $adresse_geo,
            'adresse_postale' => $adresse_post,
            'etablissement_date_debut' => date('Y-m-d H:i:s', time()),
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

    private function ajouter_niveau_sanitaire($code, $libelle, $niveau, $user)
    {
        $a = $this->bdd->prepare("INSERT INTO tb_etablissements_niveaux_sanitaires(niveau_sanitaire_code,niveau_sanitaire_libelle,niveau,niveau_sanitaire_date_debut,utilisateur_id_creation)
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

    private function ajouter_coordonnee($code, $type, $valeur, $user)
    {
        $a = $this->bdd->prepare("INSERT INTO tb_etablissements_coordonnees(etablissement_code,type_coordonnee_code,coordonnee_valeur,coordonnee_date_debut,utilisateur_id_creation)
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

    private function ajouter_ets_service($code_etablissement, $service, $user)
    {
        $a = $this->bdd->prepare("INSERT INTO tb_services_hospitaliers(etablissement_code,etablissement_service_code,service_hospitalier_date_debut,utilisateur_id_creation)
        VALUES(:etablissement_code,:etablissement_service_code,:service_hospitalier_date_debut, :utilisateur_id_creation) 
        ");
        $a->execute(array(
            'etablissement_code' => $code_etablissement,
            'etablissement_service_code' => $service,
            'service_hospitalier_date_debut' => date('Y-m-d H:i:s', time()),
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

    private function ajouter_professionnel_sante($id_user, $code_professionnel, $code_categorie_professionnel_sante, $immatriculation, $code_odre, $numero_code, $user)
    {
        $a = $this->bdd->prepare("INSERT INTO tb_utilisateurs_professionnels_sante(utilisateur_id,professionnel_sante_code,categorie_professionnelle_sante_code,numero_immatriculation,orde_nationnal_code,ordre_national_numero,professionnel_sante_date_debut,utilisateur_id_creation)
        VALUES(:utilisateur_id,:professionnel_sante_code,:categorie_professionnelle_sante_code,:numero_immatriculation,:orde_nationnal_code,:ordre_national_numero,:professionnel_sante_date_debut, :utilisateur_id_creation) 
        ");
        $a->execute(array(
            'utilisateur_id' => $id_user,
            'professionnel_sante_code' => $code_professionnel,
            'categorie_professionnelle_sante_code' => $code_categorie_professionnel_sante,
            'numero_immatriculation' => $immatriculation,
            'orde_nationnal_code' => $code_odre,
            'ordre_national_numero' => $numero_code,
            'professionnel_sante_date_debut' => date('Y-m-d H:i:s', time()),
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

    private function fermer_type_ets($code, $date_fin, $user)
    {
        $a = $this->bdd->prepare("UPDATE tb_etablissements_types  SET type_etablissement_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE type_etablissement_code = ? AND type_etablissement_date_fin IS NULL");
        $a->execute(array($date_fin, date('Y-m-d H:i:s', time()), $user, $code));
        if ($a->errorCode() == "00000") {
            return array(
                "success" => true,
                "messages" => 'Enregistrement effectué avec succès.'
            );
        } else {
            return array(
                "success" => false,
                "messages" => $a->errorInfo()
            );
        }
    }

    private function fermer_etablissement($code, $date_fin, $user)
    {
        $a = $this->bdd->prepare("UPDATE tb_etablissements  SET etablissement_date_fin = ?, date_edition = ?, utilisation_id_edition = ? WHERE etablissement_code = ? AND etablissement_date_fin IS NULL");
        $a->execute(array($date_fin, date('Y-m-d H:i:s', time()), $user, $code));
        if ($a->errorCode() == "00000") {
            return array(
                "success" => true,
                "messages" => 'Enregistrement effectué avec succès.'
            );
        } else {
            return array(
                "success" => false,
                "messages" => $a->errorInfo()
            );
        }
    }

    private function fermer_niveau_sanitaire($code, $date_fin, $user)
    {
        $a = $this->bdd->prepare("UPDATE tb_etablissements_niveaux_sanitaires SET niveau_sanitaire_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE niveau_sanitaire_code = ? AND niveau_sanitaire_date_fin IS NULL");
        $a->execute(array($date_fin, date('Y-m-d H:i:s', time()), $user, $code));
        if ($a->errorCode() == "00000") {
            return array(
                "success" => true,
                "messages" => 'Enregistrement effectué avec succès.'
            );
        } else {
            return array(
                "success" => false,
                "messages" => $a->errorInfo()
            );
        }
    }

    private function fermer_coordonnee($code, $date_fin, $user)
    {
        $a = $this->bdd->prepare("UPDATE tb_etablissements_coordonnees SET coordonnee_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE etablissement_code = ? AND coordonnee_date_fin IS NULL");
        $a->execute(array($date_fin, date('Y-m-d H:i:s', time()), $user, $code));
        if ($a->errorCode() == "00000") {
            return array(
                "success" => true,
                "messages" => 'Enregistrement effectué avec succès.'
            );
        } else {
            return array(
                "success" => false,
                "messages" => $a->errorInfo()
            );
        }
    }

    private function fermer_ets_service($code, $date_fin, $user)
    {
        $a = $this->bdd->prepare("UPDATE tb_services_hospitaliers SET service_hospitalier_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE etablissement_code = ? AND service_hospitalier_date_fin IS NULL");
        $a->execute(array($date_fin, date('Y-m-d H:i:s', time()), $user, $code));
        if ($a->errorCode() == "00000") {
            return array(
                "success" => true,
                "messages" => 'Enregistrement effectué avec succès.'
            );
        } else {
            return array(
                "success" => false,
                "messages" => $a->errorInfo()
            );
        }
    }

    private function fermer_professionnel_sante($code, $date_fin, $user)
    {
        $a = $this->bdd->prepare("UPDATE tb_utilisateurs_professionnels_sante SET professionnel_sante_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE professionnel_sante_code = ? AND professionnel_sante_date_fin IS NULL");
        $a->execute(array($date_fin, date('Y-m-d H:i:s', time()), $user, $code));
        if ($a->errorCode() == "00000") {
            return array(
                "success" => true,
                "messages" => 'Enregistrement effectué avec succès.'
            );
        } else {
            return array(
                "success" => false,
                "messages" => $a->errorInfo()
            );
        }
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
        $a = $this->bdd->prepare($query);
        $a->execute(array($code));
        return $a->fetch();
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
        $a = $this->bdd->prepare($query);
        $a->execute(array($code, $type));
        return $a->fetch();
    }

    public function trouver_ets_service($code_etablissement, $code_service)
    {
        $query = "
SELECT 
       etablissement_service_code AS code_service,
       etablissement_service_code AS code_etablissement,
       service_hospitalier_date_debut AS date_debut,
       utilisateur_id_creation
FROM
     tb_services_hospitaliers
WHERE
      etablissement_code LIKE ? AND 
      etablissement_service_code LIKE ? AND 
      service_hospitalier_date_fin IS NULL
        ";
        $a = $this->bdd->prepare($query);
        $a->execute(array($code_etablissement, $code_service));
        return $a->fetch();
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
        $a = $this->bdd->prepare($query);
        $a->execute(array($code));
        return $a->fetch();
    }

    public function trouver_professionnel_sante($code)
    {
        $query = "
SELECT 
        	utilisateur_id AS id_user,
       professionnel_sante_code AS code,
       categorie_professionnelle_sante_code  AS code_categorie,
       numero_immatriculation  AS immatriculation,
       orde_nationnal_code  AS code_ordre,
       ordre_national_numero  AS numero_ordre,
       professionnel_sante_date_debut AS date_debut,
       utilisateur_id_creation
FROM
     tb_utilisateurs_professionnels_sante
WHERE
      professionnel_sante_code LIKE ? AND 
      professionnel_sante_date_fin IS NULL
        ";
        $a = $this->bdd->prepare($query);
        $a->execute(array($code));
        return $a->fetch();
    }

    public function trouver_etablissement($code)
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
       A.latitude  AS latitude , 
       A.longitude  AS longitude , 
       A.site_web AS site_web, 
       A.secteur_activite_code AS code_secteur_activite, 
       A.adresse_geographique AS adresse_geographique, 
       A.adresse_postale AS adresse_postale, 
       A.date_creation, 
       A.etablissement_date_debut AS date_debut, 
       A.utilisation_id_creation, 
       A.date_edition, 
       A.utilisation_id_edition 
FROM
     tb_etablissements A JOIN tb_etablissements_types B
 ON  A.type_etablissement_code = B.type_etablissement_code
 JOIN tb_ref_geo_pays C 
ON A.pays_code = C.pays_code JOIN tb_ref_geo_regions D
ON A.region_code = D.region_code JOIN tb_ref_geo_departements E 
ON A.departement_code = E.departement_code JOIN tb_ref_geo_communes F
ON A.commune_code = F.commune_code
         
WHERE
      A.etablissement_code LIKE ? AND 
      A.etablissement_date_fin IS NULL
        ";
        $a = $this->bdd->prepare($query);
        $a->execute(array($code));
        return $a->fetch();
    }
    public function trouver_responsable_etablissement($code)
    {
        $query = "
SELECT 
        A.etablissement_code AS code, 
        A.utilisateur_id AS id_user, 
       B.utilisateur_nom AS nom ,
       B.utilisateur_prenoms AS prenoms
FROM
     tb_etablissements_responsables A JOIN tb_utilisateurs B
ON A.utilisateur_id = B.utilisateur_id

WHERE
      A.etablissement_code LIKE ? 
        ";
        $a = $this->bdd->prepare($query);
        $a->execute(array($code));
        return $a->fetch();
    }


    public function lister_types_ets()
    {
        $query = "
SELECT 
       A.niveau_sanitaire_code AS code_niveau,
       A.type_etablissement_code AS code, 
       A.type_etablissement_libelle AS libelle, 
       A.type_etablissement_date_debut AS date_debut, 
       A.date_creation, 
       A.utilisateur_id_creation
FROM 
     tb_etablissements_types A
WHERE 
      A.type_etablissement_date_fin IS NULL
ORDER BY A.type_etablissement_libelle
";
        $a = $this->bdd->prepare($query);
        $a->execute(array());
        return $a->fetchAll();
    }

    public function lister_etablissements()
    {
        $query = "
SELECT 
        A.etablissement_code AS code_etablissement, 
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
       A.utilisation_id_creation, 
       A.date_edition, 
       A.utilisation_id_edition 
FROM 
     tb_etablissements A
WHERE 
      A.etablissement_date_fin IS NULL
ORDER BY A.raison_sociale
";
        $a = $this->bdd->prepare($query);
        $a->execute(array());
        return $a->fetchAll();
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
        $a = $this->bdd->prepare($query);
        $a->execute(array());
        $json = $a->fetchAll();
        return $json;
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
        $a = $this->bdd->prepare($query);
        $a->execute(array($code_etablissemnt));
        $json = $a->fetchAll();
        return $json;
    }

    public function lister_ets_servies($code_etablissemnt)
    {
        $query = "
SELECT 
       A.etablissement_code AS code_ets,
       A.etablissement_service_code AS code_service,
       B.etablissement_service_libelle AS libelle,
       A.service_hospitalier_date_debut AS date_debut,
       A.utilisateur_id_creation
FROM
     tb_services_hospitaliers A JOIN tb_ref_etablissements_services B
     ON A.etablissement_service_code = B.etablissement_service_code
WHERE etablissement_code LIKE ? AND
      service_hospitalier_date_fin IS NULL
        ";
        $a = $this->bdd->prepare($query);
        $a->execute(array($code_etablissemnt));
        $json = $a->fetchAll();
        return $json;
    }

    public function lister_professionnels_sante()
    {
        $query = "
SELECT 
    utilisateur_id AS id_user,
       professionnel_sante_code AS code,
       categorie_professionnelle_sante_code  AS code_categorie,
       numero_immatriculation  AS immatriculation,
       orde_nationnal_code  AS code_ordre,
       ordre_national_numero  AS numero_ordre,
       professionnel_sante_date_debut AS date_debut,
       utilisateur_id_creation
FROM
     tb_utilisateurs_professionnels_sante
WHERE 
      professionnel_sante_date_fin IS NULL
        ";
        $a = $this->bdd->prepare($query);
        $a->execute(array());
        $json = $a->fetchAll();
        return $json;
    }

    public function lister_ets_responsables_libres()
    {
        $a = $this->bdd->prepare("SELECT A.utilisateur_id AS id_user, A.utilisateur_nom AS nom, A.utilisateur_prenoms AS prenoms FROM tb_utilisateurs A WHERE A.profil_utilisateur_code = ?");
        $a->execute(array('CSRESP'));
        return $a->fetchAll();
    }


    public function editer_type_ets($code_niveau, $code, $libelle, $user)
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

    public function editer_etablissement($code_etablissement, $type_etab, $raison_sociale, $niveau, $pays_code, $region_code, $departement_code, $commune_code, $latitude, $longitude, $secteur_activte, $adresse_geo, $adresse_post, $user)
    {
        $etablissement = $this->trouver_etablissement($code_etablissement);
        if ($etablissement) {
            $date_fin = date('Y-m-d', strtotime('-1 day', time()));
            if (strtotime($date_fin) > strtotime($etablissement['date_debut'])) {
                $edition = $this->fermer_etablissement($etablissement['code_etablissement'], $date_fin, $user);
                if ($edition['success'] == true) {
                    $json = $this->ajouter_etablissement($code_etablissement, $type_etab, $raison_sociale, $niveau, $pays_code, $region_code, $departement_code, $commune_code, $latitude, $longitude, $secteur_activte, $adresse_geo, $adresse_post, $user);
                } else {
                    $json = $edition;
                }
            } else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le " . date('d/m/Y', strtotime('+2 day', strtotime($etablissement['date_debut'])))
                );
            }

        } else {
            $json = $this->ajouter_etablissement($code_etablissement, $type_etab, $raison_sociale, $niveau, $pays_code, $region_code, $departement_code, $commune_code, $latitude, $longitude, $secteur_activte, $adresse_geo, $adresse_post, $user);
        }
        return $json;
    }

    public function editer_professionnel_sante($id_user, $code_professionnel, $code_categorie_professionnel_sante, $immatriculation, $code_odre, $numero_code, $user)
    {
        $professionnel = $this->trouver_professionnel_sante($code_professionnel);
        if ($professionnel) {
            $date_fin = date('Y-m-d', strtotime('-1 day', time()));
            if (strtotime($date_fin) > strtotime($professionnel['date_debut'])) {
                $edition = $this->fermer_professionnel_sante($professionnel['code_etablissement'], $date_fin, $user);
                if ($edition['success'] == true) {
                    $json = $this->ajouter_professionnel_sante($id_user, $code_professionnel, $code_categorie_professionnel_sante, $immatriculation, $code_odre, $numero_code, $user);
                } else {
                    $json = $edition;
                }
            } else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le " . date('d/m/Y', strtotime('+2 day', strtotime($professionnel['date_debut'])))
                );
            }

        } else {
            $json = $this->ajouter_professionnel_sante($id_user, $code_professionnel, $code_categorie_professionnel_sante, $immatriculation, $code_odre, $numero_code, $user);
        }
        return $json;
    }

    public function editer_niveau_sanitaire($code, $libelle, $niveau, $user)
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

    public function editer_coordonnee($code, $type, $valeur, $user)
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

    public function editer_ets_service($code_etablissement, $code_service, $user)
    {
        $service = $this->trouver_ets_service($code_etablissement, $code_service);
        if ($service) {
            $date_fin = date('Y-m-d', strtotime('-1 day', time()));
            if (strtotime($date_fin) > strtotime($service['date_debut'])) {
                $edition = $this->fermer_ets_service($service['code'], $date_fin, $user);
                if ($edition['success'] == true) {
                    $json = $this->ajouter_ets_service($code_etablissement, $code_service, $user);
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
            $json = $this->ajouter_ets_service($code_etablissement, $code_service, $user);
        }
        return $json;
    }

    public function editer_type_etablissement($code_etablissement, $code_type, $user)
    {
        $etablissement = $this->trouver_etablissement($code_etablissement);
        if ($etablissement) {
            $a = $this->bdd->prepare("UPDATE tb_etablissements SET type_etablissement_code  = ?, date_edition = ?, utilisation_id_edition = ? WHERE etablissement_code = ?");
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
                'message' => "Utilisateur inconnu"
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
        $a = $this->bdd->prepare($query);
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
        $a = $this->bdd->prepare($query);
        $a->execute(array('%' . $code . '%'));
        return $a->fetchAll();
    }


    private function ajouter_responsable($id_user, $code_etablissement, $user)
    {
        $a = $this->bdd->prepare("INSERT INTO tb_etablissements_responsables(utilisateur_id,etablissement_code,etablissement_responsable_date_debut , utilisateur_id_creation)
        VALUES(:utilisateur_id, :etablissement_code, :etablissement_responsable_date_debut, :utilisateur_id_creation) 
        ");
        $a->execute(array(
            'utilisateur_id' => $id_user,
            'etablissement_code' => $code_etablissement,
            'etablissement_responsable_date_debut' => date('Y-m-d H:i:s', time()),
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

    private function ajouter_agent($id_user, $code_etablissement, $user)
    {
        $a = $this->bdd->prepare("INSERT INTO tb_etablissements_agents(utilisateur_id,etablissement_code,etablissement_agent_date_debut , utilisateur_id_creation)
        VALUES(:utilisateur_id, :etablissement_code, :etablissement_agent_date_debut, :utilisateur_id_creation) 
        ");
        $a->execute(array(
            'utilisateur_id' => $id_user,
            'etablissement_code' => $code_etablissement,
            'etablissement_agent_date_debut' => date('Y-m-d', time()),
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

    private function fermer_responsable($id_user, $code_etablissement, $date_fin, $user)
    {
        $a = $this->bdd->prepare("UPDATE tb_etablissements_responsables  SET etablissement_responsable_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE etablissement_code = ? AND utilisateur_id = ? AND etablissement_responsable_date_fin IS NULL");
        $a->execute(array($date_fin, date('Y-m-d', time()), $user, $code_etablissement, $id_user));
        if ($a->errorCode() == "00000") {
            return array(
                "success" => true,
                "messages" => 'Enregistrement effectué avec succès.'
            );
        } else {
            return array(
                "success" => false,
                "messages" => $a->errorInfo()
            );
        }
    }

    private function fermer_agent($id_user, $code_etablissement, $date_fin, $user)
    {
        $a = $this->bdd->prepare("UPDATE tb_etablissements_agents  SET etablissement_agent_date_fin = ?, date_edition = ?, utilisation_id_edition = ? WHERE etablissement_code = ? AND utilisateur_id = ? AND etablissement_agent_date_fin IS NULL");
        $a->execute(array($date_fin, date('Y-m-d', time()), $user, $code_etablissement, $id_user));
        if ($a->errorCode() == "00000") {
            return array(
                "success" => true,
                "messages" => 'Enregistrement effectué avec succès.'
            );
        } else {
            return array(
                "success" => false,
                "messages" => $a->errorInfo()
            );
        }
    }

    public function trouver_responsable($code)
    {
        $query = "
SELECT 
    
       A.etablissement_code AS code_etablissement,
       A.etablissement_responsable_date_debut AS date_debut,
       A.utilisateur_id_creation,
       A.utilisateur_id as id_user ,
       B.utilisateur_nom  AS nom,
       B.utilisateur_prenoms AS prenoms,
       B.utilisateur_email AS email,
       C.raison_sociale AS raison_sociale
       
FROM
     tb_etablissements_responsables A JOIN tb_utilisateurs B 
ON A.utilisateur_id = B.utilisateur_id JOIN tb_etablissements C
ON A.etablissement_code = C.etablissement_code

WHERE
       A.etablissement_code LIKE ? AND 
      A.etablissement_responsable_date_fin IS NULL 
        ";
        $a = $this->bdd->prepare($query);
        $a->execute(array($code));
        return $a->fetch();
    }

    public function trouver_agent($id_user)
    {
        $query = "
SELECT 
    
       A.etablissement_code AS code_etablissement,
       A.etablissement_agent_date_debut AS date_debut,
       A.utilisateur_id_creation,
       A.utilisateur_id ,
       B.utilisateur_nom  AS nom,
     C.raison_sociale AS raison_sociale,
       B.utilisateur_prenoms AS prenoms,
       B.utilisateur_email AS email
FROM
     tb_etablissements_agents A JOIN tb_utilisateurs B 
ON A.utilisateur_id = B.utilisateur_id JOIN tb_etablissements C
ON A.etablissement_code = C.etablissement_code


WHERE
      A.utilisateur_id LIKE ? AND 
      etablissement_agent_date_fin IS NULL 
        ";
        $a = $this->bdd->prepare($query);
        $a->execute(array($id_user));
        return $a->fetch();
    }

    public function lister_responsables()
    {
        $query = "
SELECT 
      utilisateur_id AS id_user,
       etablissement_code AS code_etablissement,
       etablissement_responsable_date_debut AS date_debut,
       utilisateur_id_creation
FROM 
    tb_etablissements_responsables
WHERE 
      etablissement_responsable_date_fin IS NULL

";
        $a = $this->bdd->prepare($query);
        $a->execute(array());
        return $a->fetchAll();
    }

    public function lister_agents_libres()
    {
        $query = "
SELECT 
      A.utilisateur_id  AS id_user,
      A.utilisateur_nom  AS nom,
       A.utilisateur_prenoms  AS prenoms,
       A.utilisateur_id ,
       B.profil_utilisateur_libelle  AS profil_libelle
      
FROM
     tb_utilisateurs A JOIN tb_ref_profils_utilisateurs B 
ON A.profil_utilisateur_code = B.profil_utilisateur_code

WHERE B.profil_utilisateur_code LIKE ? AND
      profil_utilisateur_date_fin  IS NULL

";
        $a = $this->bdd->prepare($query);
        $a->execute(array('CSAGNT'));
        return $a->fetchAll();
    }

    public function lister_agents_etablissement($code_etablissement)
    {
        $query = "
SELECT 
      A.etablissement_code AS code_etablissement,
       A.etablissement_agent_date_debut AS date_debut,
       A.utilisateur_id_creation,
       A.date_creation,
       A.utilisateur_id ,
       B.utilisateur_nom  AS nom,
       B.utilisateur_prenoms AS prenoms,
       B.utilisateur_email AS email
FROM
     tb_etablissements_agents A JOIN tb_utilisateurs B 
ON A.utilisateur_id = B.utilisateur_id

WHERE etablissement_code LIKE ? AND
      etablissement_agent_date_fin  IS NULL

";
        $a = $this->bdd->prepare($query);
        $a->execute(array($code_etablissement));
        return $a->fetchAll();
    }

    public function editer_responsable($id_user, $code_etablissement, $user)
    {
        $etablissementrespnsable = $this->trouver_responsable($code_etablissement);
        if ($etablissementrespnsable) {
            $date_fin = date('Y-m-d H:i:s', strtotime('-1 day', time()));
            if (strtotime($date_fin) > strtotime($etablissementrespnsable['date_debut'])) {
                $edition = $this->fermer_responsable($id_user,$etablissementrespnsable['code_etablissement'], $date_fin, $user);
                if ($edition['success'] == true) {
                    $json = array(
                        'success' => true,
                        'message' => "La mise à jour éffectué avec succes!"
                    );
                } else {
                    $json = array(
                        'success' => false,
                        'message' => "erreur!"
                    );
                }
            } else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le " . date('d/m/Y', strtotime('+2 day', strtotime($etablissementrespnsable['date_debut'])))
                );
            }
        } else {

             $json = $this->ajouter_responsable($id_user, $code_etablissement, $user);
        }
        return $json;
    }

    public function editer_agent($id_user, $code_etablissement, $user)
    {
        $etablissementagent = $this->trouver_agent($code_etablissement, $id_user);
        if ($etablissementagent) {
            $date_fin = date('Y-m-d', strtotime('-1 day', time()));
            if (strtotime($date_fin) > strtotime($etablissementagent['date_debut'])) {
                $edition = $this->fermer_agent($id_user, $etablissementagent['code_etablissement'], $date_fin, $user);
                if ($edition['success'] == true){
                    $json = array(
                        'success' => true,
                        'message' => "La mise à jour éffectué avec succes!"
                    );
                }else{
                    $json = $edition;
                }
            } else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le " . date('d/m/Y', strtotime('+2 day', strtotime($etablissementagent['date_debut'])))
                );
            }
        } else {
            $json = $this->ajouter_agent($id_user, $code_etablissement, $user);
        }
        return $json;
    }

    public function lister_historique_responsable($code)
    {
        $query = "
SELECT 
       A.sexe_code AS code, 
       A.sexe_libelle AS libelle, 
       B.utilisateur_nom AS nom,
       B.utilisateur_prenoms AS prenoms,
       A.sexe_date_debut AS date_debut, 
       A.sexe_date_fin AS date_fin, 
       A.date_creation, 
       A.utilisateur_id_creation
FROM 
     tb_ref_sexes A JOIN tb_utilisateurs B 
         ON 
             A.utilisateur_id_creation = B.utilisateur_id AND A.sexe_code LIKE ?
ORDER BY 
         A.date_creation DESC";
        $a = $this->bdd->prepare($query);
        $a->execute(array('%' . $code . '%'));
        return $a->fetchAll();
    }


}