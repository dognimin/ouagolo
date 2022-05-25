<?php
namespace App;

class COLLECTIVITES extends BDD
{
    public function editer($code_secteur, $code, $code_externe, $raison_sociale, $adresse_postale, $adresse_geographique, $code_pays, $code_region, $code_departement, $code_commune, $latitude, $longitude, $date_fin, $motif_fin, $user): array
    {
        if($code) {
            $collectivite = $this->trouver($code);
            if ($collectivite) {
                if ($date_fin) {
                    return $this->fermer($code, $date_fin, $motif_fin, $user);
                } else {
                    return $this->modifier($code_secteur, $code, $code_externe, $raison_sociale, $adresse_postale, $adresse_geographique, $code_pays, $code_region, $code_departement, $code_commune, $latitude, $longitude, $user);
                }
            } else {
                return $this->ajouter($code_secteur, $code_externe, $raison_sociale, $adresse_postale, $adresse_geographique, $code_pays, $code_region, $code_departement, $code_commune, $latitude, $longitude, $user);
            }
        }else {
            return $this->ajouter($code_secteur, $code_externe, $raison_sociale, $adresse_postale, $adresse_geographique, $code_pays, $code_region, $code_departement, $code_commune, $latitude, $longitude, $user);
        }
    }

    public function trouver($code)
    {
        $a = $this->getBdd()->prepare("
SELECT 
       A.collectivite_code_externe AS code_externe,
       A.collectivite_code AS code, 
       A.secteur_activite_code AS code_secteur_activite, 
       A.collectivite_raison_sociale AS raison_sociale, 
       A.collectivite_adresse_postale AS adresse_postale, 
       A.collectivite_adresse_geographique AS adresse_geographique, 
       A.collectivite_date_debut AS date_debut, 
       B.pays_code AS code_pays, 
       B.pays_nom AS nom_pays,
       C.region_code AS code_region, 
       C.region_nom AS nom_region,
       D.departement_code AS code_departement, 
       D.departement_nom AS nom_departement,
       E.commune_code AS code_commune, 
       E.commune_nom AS nom_commune,
       A.collectivite_latitude AS latitude, 
       A.collectivite_longitude AS longitude, 
       A.date_creation, 
       A.utilisateur_id_creation, 
       A.date_edition, 
       A.utilisateur_id_edition 
FROM 
     tb_ref_collectivites A 
         JOIN tb_ref_geo_pays B 
             ON A.pays_code = B.pays_code 
         JOIN tb_ref_geo_regions C 
             ON A.region_code = C.region_code 
         JOIN tb_ref_geo_departements D 
             ON A.departement_code = D.departement_code 
         JOIN tb_ref_geo_communes E 
             ON A.commune_code = E.commune_code
                    AND A.collectivite_code = ? 
                    AND B.pays_date_fin IS NULL 
                    AND C.region_date_fin IS NULL 
                    AND D.departement_date_fin IS NULL 
                    AND E.commune_date_fin IS NULL 
                    AND A.collectivite_date_fin IS NULL");
        $a->execute(array($code));
        return $a->fetch();
    }

    private function fermer($code, $date_fin, $motif, $user): array
    {
        $a = $this->getBdd()->prepare("UPDATE tb_ref_collectivites SET collectivite_date_fin = ?, collectivite_motif_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE collectivite_code = ?");
        $a->execute(array($date_fin, $motif, date('Y-m-d H:i:s', time()), $user, $code));
        if ($a->errorCode() == '00000') {
            return array(
                'success' => true,
                'code_collectivite' => $code,
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

    private function modifier($code_secteur, $code, $code_externe, $raison_sociale, $adresse_postale, $adresse_geographique, $code_pays, $code_region, $code_departement, $code_commune, $latitude, $longitude, $user): array
    {
        $a = $this->getBdd()->prepare("UPDATE tb_ref_collectivites SET collectivite_code_externe = ?, collectivite_raison_sociale = ?, secteur_activite_code = ?, collectivite_adresse_postale = ?, collectivite_adresse_geographique = ?, pays_code = ?, region_code = ?, departement_code = ?, commune_code = ?, collectivite_latitude = ?, collectivite_longitude = ?, date_edition = ?, utilisateur_id_edition = ? WHERE collectivite_code = ?");
        $a->execute(array($code_externe, $raison_sociale, $code_secteur, $adresse_postale, $adresse_geographique, $code_pays, $code_region, $code_departement, $code_commune, $latitude, $longitude, date('Y-m-d H:i:s', time()), $user, $code));
        if ($a->errorCode() == '00000') {
            return array(
                'success' => true,
                'code_collectivite' => $code,
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

    private function ajouter($code_secteur, $code_externe, $raison_sociale, $adresse_postale, $adresse_geographique, $code_pays, $code_region, $code_departement, $code_commune, $latitude, $longitude, $user): array
    {
        $collectivites = $this->lister(null, null);
        $nb_collectivites = count($collectivites);
        $code = 'COL'.str_pad(intval($nb_collectivites + 1), 6,'0',STR_PAD_LEFT);
        $a = $this->getBdd()->prepare("INSERT INTO tb_ref_collectivites(collectivite_code, collectivite_code_externe, collectivite_raison_sociale, secteur_activite_code, collectivite_adresse_postale, collectivite_adresse_geographique, pays_code, region_code, departement_code, commune_code, collectivite_latitude, collectivite_longitude, collectivite_date_debut, utilisateur_id_creation) 
        VALUES(:collectivite_code, :collectivite_code_externe, :collectivite_raison_sociale, :secteur_activite_code, :collectivite_adresse_postale, :collectivite_adresse_geographique, :pays_code, :region_code, :departement_code, :commune_code, :collectivite_latitude, :collectivite_longitude, :collectivite_date_debut, :utilisateur_id_creation)");
        $a->execute(array(
            'collectivite_code' => $code,
            'collectivite_code_externe' => $code_externe,
            'collectivite_raison_sociale' => $raison_sociale,
            'secteur_activite_code' => $code_secteur,
            'collectivite_adresse_postale' => $adresse_postale,
            'collectivite_adresse_geographique' => $adresse_geographique,
            'pays_code' => $code_pays,
            'region_code' => $code_region,
            'departement_code' => $code_departement,
            'commune_code' => $code_commune,
            'collectivite_latitude' => $latitude,
            'collectivite_longitude' => $longitude,
            'collectivite_date_debut' => date('Y-m-d', time()),
            'utilisateur_id_creation' => $user
        ));
        if ($a->errorCode() == '00000') {
            return array(
                'success' => true,
                'code_collectivite' => $code,
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

    public function lister($code, $raison_sociale) {
        $a = $this->getBdd()->prepare("
SELECT 
       A.collectivite_code_externe AS code_externe, 
       A.collectivite_code AS code, 
       A.secteur_activite_code AS code_secteur_activite, 
       A.collectivite_raison_sociale AS raison_sociale, 
       A.collectivite_adresse_postale AS adresse_postale, 
       A.collectivite_adresse_geographique AS adresse_geographique, 
       A.collectivite_date_debut AS date_debut, 
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
     tb_ref_collectivites A 
         JOIN tb_ref_geo_pays B 
             ON A.pays_code = B.pays_code 
         JOIN tb_ref_geo_regions C 
             ON A.region_code = C.region_code 
         JOIN tb_ref_geo_departements D 
             ON A.departement_code = D.departement_code 
         JOIN tb_ref_geo_communes E 
             ON A.commune_code = E.commune_code
                    AND A.collectivite_code LIKE ?
                    AND A.collectivite_raison_sociale LIKE ?
                    AND B.pays_date_fin IS NULL 
                    AND C.region_date_fin IS NULL 
                    AND D.departement_date_fin IS NULL 
                    AND E.commune_date_fin IS NULL 
                    AND A.collectivite_date_fin IS NULL 
ORDER BY 
         A.collectivite_raison_sociale
        ");
        $a->execute(array('%'.$code.'%','%'.$raison_sociale.'%'));
        return $a->fetchAll();
    }

    public function lister_secteurs_activites() {
        $a = $this->getBdd()->prepare("SELECT A.secteur_activite_code AS code, B.secteur_activite_libelle AS libelle, COUNT(DISTINCT A.collectivite_code) AS effectif FROM tb_ref_collectivites A JOIN tb_ref_secteurs_activites B ON A.secteur_activite_code = B.secteur_activite_code AND A.collectivite_date_fin IS NULL AND B.secteur_activite_date_fin IS NULL GROUP BY A.secteur_activite_code, B.secteur_activite_libelle ORDER BY B.secteur_activite_libelle");
        $a->execute(array());
        return $a->fetchAll();
    }

    public function moteur_recherche($code_secteur, $code, $raison_sociale) {
        $a = $this->getBdd()->prepare("
SELECT 
       A.secteur_activite_code AS code_secteur_activite, 
       B.secteur_activite_libelle AS libelle_secteur_activite, 
       A.collectivite_code AS code, 
       A.collectivite_raison_sociale AS raison_sociale, 
       A.pays_code AS code_pays, 
       C.pays_nom AS nom_pays, 
       A.region_code AS code_region, 
       D.region_nom AS nom_region,
       A.departement_code AS code_departement, 
       E.departement_nom AS nom_departement,
       A.commune_code AS code_commune, 
       F.commune_nom AS nom_commune, 
       A.collectivite_date_debut 
FROM 
     tb_ref_collectivites A 
         JOIN tb_ref_secteurs_activites B 
             ON A.secteur_activite_code = B.secteur_activite_code 
         JOIN tb_ref_geo_pays C 
             ON A.pays_code = C.pays_code 
         JOIN tb_ref_geo_regions D 
             ON A.region_code = D.region_code 
         JOIN tb_ref_geo_departements E 
             ON A.departement_code = E.departement_code
         JOIN tb_ref_geo_communes F 
             ON A.commune_code = F.commune_code 
                    AND A.secteur_activite_code LIKE ? 
                    AND A.collectivite_code LIKE ? 
                    AND collectivite_raison_sociale LIKE ? 
                    AND A.collectivite_date_fin IS NULL 
                    AND B.secteur_activite_date_fin IS NULL 
                    AND C.pays_date_fin IS NULL 
ORDER BY 
         A.collectivite_raison_sociale");
        $a->execute(array('%'.$code_secteur.'%', '%'.$code.'%', '%'.$raison_sociale.'%'));
        return $a->fetchAll();
    }
}