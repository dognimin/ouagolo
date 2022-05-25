<?php
namespace App;

class LOCALISATIONSGEOGRAPHIQUES extends BDD
{
    public function lister_pays() {
        $query = "
SELECT 
       A.pays_code AS code,
       A.pays_nom AS nom,
       A.pays_date_debut AS date_debut,
       A.pays_gentile AS gentile,
       A.monnaie_code AS code_monnaie,
       A.pays_indicatif_telephonique AS indicatif_telephonique,
       A.pays_drapeau_image AS drapeau,
       A.pays_latitude AS latitude,
       A.pays_longitude AS longitude,
       B.monnaie_libelle AS devise,
       A.date_creation, 
       A.utilisateur_id_creation
FROM 
     tb_ref_geo_pays A JOIN tb_ref_monnaies B
     ON A.monnaie_code = B.monnaie_code
     AND A.pays_date_fin IS NULL 
     AND monnaie_date_fin IS NULL
ORDER BY A.pays_nom
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array());
        return $a->fetchAll();
    }

    public function lister_historique_pays($code) {
        $query = "
SELECT 
       A.pays_code AS code,
       A.pays_nom AS libelle,
       A.pays_date_debut AS date_debut,
       A.pays_gentile AS gentile,
       A.monnaie_code AS code_monnaie,
       C.monnaie_libelle AS devise,
       A.pays_indicatif_telephonique AS indicatif_telephonique,
       A.pays_drapeau_image AS drapeau,
       A.pays_latitude AS latitude,
       A.pays_longitude AS longitude,
       A.pays_date_debut AS date_debut,
       A.pays_date_fin AS date_fin,
       A.date_creation, 
       A.utilisateur_id_creation,
        B.utilisateur_nom AS nom,
       B.utilisateur_prenoms AS prenoms
FROM 
     tb_ref_geo_pays A 
       
          JOIN tb_utilisateurs B 
             ON 
                 A.utilisateur_id_creation = B.utilisateur_id
                 JOIN tb_ref_monnaies C ON A.monnaie_code = C.monnaie_code
            
            AND A.pays_code LIKE ? AND C.monnaie_date_fin IS NULL
ORDER BY 
         A.date_creation DESC
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array('%'.$code.'%'));
        $json = $a->fetchAll();
        return $json;
    }

    public function lister_historique_region($code){
        $query = "
SELECT 
       A.pays_code AS code_pays,
       A.region_code AS code,
       A.region_nom AS nom_region,
       A.region_latitude AS latitude,
       A.region_longitude AS longitude,
       A.region_date_debut AS date_debut,
       A.region_date_fin AS date_fin,
       A.date_creation, 
       A.utilisateur_id_creation,
       C.utilisateur_nom AS nom,
       C.utilisateur_prenoms AS prenoms
FROM
     tb_ref_geo_regions A 
         JOIN tb_utilisateurs C 
             ON 
                 A.utilisateur_id_creation = C.utilisateur_id
            
            AND A.region_code LIKE ?
ORDER BY 
         A.date_creation DESC
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array('%'.$code.'%'));
        $json = $a->fetchAll();
        return $json;
    }

    public function lister_historique_departement($code){
        $query = "
SELECT 
       C.pays_code AS code_pays,
       C.pays_nom AS nom_pays,
       A.region_code AS code_region,
       B.region_nom AS nom_region,
       A.departement_code AS code,
       A.departement_nom AS nom,
       A.departement_latitude AS latitude,
       A.departement_longitude AS longitude,
       A.departement_date_debut AS date_debut,
       A.departement_date_fin AS date_fin,
       A.date_creation, 
       A.utilisateur_id_creation,
       D.utilisateur_nom AS nom,
       D.utilisateur_prenoms AS prenoms
FROM
     tb_ref_geo_departements A 
         JOIN tb_ref_geo_regions B 
             ON A.region_code = B.region_code 
         JOIN tb_ref_geo_pays C 
             ON B.pays_code = C.pays_code JOIN tb_utilisateurs D 
             ON 
                 A.utilisateur_id_creation = D.utilisateur_id
            
            AND A.departement_code LIKE ?  AND 
               B.region_date_fin IS NULL AND C.pays_date_fin IS NULL
            
ORDER BY 
         A.date_creation DESC
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array('%'.$code.'%'));
        $json = $a->fetchAll();
        return $json;
    }

    public function lister_historique_commune($code){
        $query = "
SELECT 
       A.departement_code AS code_departement,
       A.commune_code AS code,
       A.commune_nom AS nom_commune,
       A.commune_latitude AS latitude,
       A.commune_longitude AS longitude,
       A.commune_date_debut AS date_debut,
       A.commune_date_fin AS date_fin,
       A.date_creation, 
       A.utilisateur_id_creation,
       B.utilisateur_nom AS nom,
       B.utilisateur_prenoms AS prenoms,
       C.departement_nom AS departement,
       D.region_nom AS region,
       E.pays_nom AS pays_nom
FROM
     tb_ref_geo_communes A 
         JOIN tb_utilisateurs B 
             ON A.utilisateur_id_creation = B.utilisateur_id
             
             JOIN tb_ref_geo_departements C
             ON A.departement_code = C.departement_code
             
             JOIN tb_ref_geo_regions D 
             ON D.region_code = C.region_code
             
              JOIN tb_ref_geo_pays E
             ON E.pays_code = D.pays_code
            
             
            AND A.commune_code LIKE ? AND C.departement_date_fin IS null AND  D.region_date_fin IS null AND  E.pays_date_fin IS NULL 
ORDER BY 
         A.date_creation DESC
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array('%'.$code.'%'));
        $json = $a->fetchAll();
        return $json;
    }

    public function editer_pays($code, $nom, $gentile, $indicatif_telephonique, $latitude, $longitude, $code_monnaie, $user){
        $pays = $this->trouver_pays($code, null);
        if($pays) {
            $date_fin = date('Y-m-d',strtotime('-1 day',time()));
            if(strtotime($date_fin) > strtotime($pays['date_debut'])) {
                $edition = $this->fermer_pays($pays['code'],$date_fin,$user);
                if($edition['success'] == true) {
                    $json = $this->ajouter_pays($code, $nom, $gentile, $indicatif_telephonique, $latitude, $longitude, $code_monnaie, $user);
                }else {
                    $json = $edition;
                }
            }else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le ".date('d/m/Y',strtotime('+2 day',strtotime($civilite['date_debut'])))
                );
            }
        }else {
            $json = $this->ajouter_pays($code, $nom, $gentile, $indicatif_telephonique, $latitude, $longitude, $code_monnaie, $user);
        }
        return $json;
    }

    public function trouver_pays($code,$gentile){
        $query = "
SELECT 
       A.pays_code AS code,
       A.pays_nom AS nom,
       A.pays_date_debut AS date_debut,
       A.pays_gentile AS gentile,
       A.monnaie_code AS code_monnaie,
       A.pays_indicatif_telephonique AS indicatif_telephonique,
       A.pays_drapeau_image AS drapeau,
       A.pays_latitude AS latitude,
       A.pays_longitude AS longitude,
       A.date_creation, 
       A.utilisateur_id_creation
FROM
     tb_ref_geo_pays A
WHERE
      A.pays_code LIKE ? AND 
      A.pays_gentile LIKE ? AND 
      A.pays_date_fin IS NULL
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code,'%'.$gentile.'%'));
        return $a->fetch();
    }

    private function fermer_pays($code, $date_fin, $user) {
        $a = $this->getBdd()->prepare("UPDATE tb_ref_geo_pays  SET pays_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE pays_code = ? AND pays_date_fin IS NULL");
        $a->execute(array($date_fin,date('Y-m-d H:i:s',time()),$user,$code));
        if ($a->errorCode() == "00000"){
            return array(
                "success" => true,
                "messages" => 'Enregistrement effectué avec succès.'
            );
        }else{
            return array(
                "success" => false,
                "messages" => $a->errorInfo()
            );
        }
    }

    private function ajouter_pays($code, $nom, $gentile, $indicatif_telephonique, $latitude, $longitude, $code_monnaie, $user){
        $a = $this->getBdd()->prepare("INSERT INTO tb_ref_geo_pays(pays_code,pays_nom,pays_gentile,pays_indicatif_telephonique,pays_latitude,pays_longitude,monnaie_code,pays_date_debut,utilisateur_id_creation)
        VALUES(:pays_code,:pays_nom,:pays_gentile,:pays_indicatif_telephonique,:pays_latitude,:pays_longitude,:monnaie_code,:pays_date_debut,:utilisateur_id_creation) 
        ");
        $a->execute(array(
            'pays_code' => $code,
            'pays_nom' => $nom,
            'pays_gentile' => $gentile,
            'pays_indicatif_telephonique' => $indicatif_telephonique,
            'pays_latitude' => $latitude,
            'pays_longitude' => $longitude,
            'monnaie_code' => $code_monnaie,
            'pays_date_debut' => date('Y-m-d H:i:s',time()),
            'utilisateur_id_creation' => $user
        ));
        if($a->errorCode() == "00000"){
            return array(
                "success" => true,
                "message" => 'Enregistrement effectué avec succès'
            );
        }else{
            return array(
                "success" => false,
                "message" => $a->errorInfo()
            );
        }
    }

    public function editer_region($code_pays, $code, $nom, $latitude, $longitude, $user){
        $regions = $this->trouver_region($code);
        if($regions) {
            $date_fin = date('Y-m-d',strtotime('-1 day',time()));
            if(strtotime($date_fin) > strtotime($regions['date_debut'])) {
                $edition = $this->fermer_region($regions['code'],$date_fin,$user);
                if($edition['success'] == true) {
                    $json = $this->ajouter_region($code_pays, $nom, $latitude, $longitude, $user);
                }else {
                    $json = $edition;
                }
            }else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le ".date('d/m/Y',strtotime('+2 day',strtotime($regions['date_debut'])))
                );
            }
        }else {
            $json = $this->ajouter_region($code_pays, $nom, $latitude, $longitude, $user);
        }
        return $json;
    }

    public function trouver_region($code){
        $query = "
SELECT 
       A.pays_code AS code_pays,
       B.pays_nom AS nom_pays,
       A.region_code AS code,
       A.region_nom AS nom,
       A.region_latitude AS latitude,
       A.region_longitude AS longitude,
       A.region_date_debut AS date_debut,
       A.date_creation, 
       A.utilisateur_id_creation
FROM
     tb_ref_geo_regions A 
         JOIN 
         tb_ref_geo_pays B 
             ON A.pays_code = B.pays_code AND
      A.region_code LIKE ? AND 
      A.region_date_fin IS NULL
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        return $a->fetch();
    }

    private function fermer_region($code, $date_fin, $user) {
        $a = $this->getBdd()->prepare("UPDATE tb_ref_geo_regions SET region_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE region_code = ? AND region_date_fin IS NULL");
        $a->execute(array($date_fin,date('Y-m-d H:i:s',time()),$user,$code));
        if ($a->errorCode() == "00000"){
            return array(
                "success" => true,
                "messages" => 'Enregistrement effectué avec succès.'
            );
        }else{
            return array(
                "success" => false,
                "messages" => $a->errorInfo()
            );
        }
    }

    private function ajouter_region($code_pays, $nom, $latitude, $longitude, $user){
        $regions = $this->lister_regions(null);
        $nb_regions = count($regions);
        $code = 'R'.str_pad(intval($nb_regions + 1), 3,'0',STR_PAD_LEFT);
        $a = $this->getBdd()->prepare("INSERT INTO tb_ref_geo_regions(pays_code,region_code,region_nom,region_latitude, region_longitude,region_date_debut,utilisateur_id_creation)
        VALUES(:pays_code,:region_code,:region_nom,:region_latitude,:region_longitude,:region_date_debut,:utilisateur_id_creation) 
        ");
        $a->execute(array(
            'pays_code' => $code_pays,
            'region_code' => $code,
            'region_nom' => $nom,
            'region_latitude' => $latitude,
            'region_longitude' => $longitude,
            'region_date_debut' => date('Y-m-d',time()),
            'utilisateur_id_creation' => $user
        ));
        if($a->errorCode() == "00000"){
            return array(
                "success" => true,
                "message" => 'Enregistrement effectué avec succès'
            );
        }else{
            return array(
                "success" => false,
                "message" => $a->errorInfo()
            );
        }
    }

    public function lister_regions($code_pays){
        $query = "
SELECT 
       A.pays_code AS code_pays,
       A.region_code AS code,
       A.region_nom AS nom,
       A.region_latitude AS latitude,
       A.region_longitude AS longitude,
       A.region_date_debut AS date_debut,
       A.date_creation, 
       A.utilisateur_id_creation,
       B.pays_nom
FROM
     tb_ref_geo_regions A JOIN tb_ref_geo_pays B ON B.pays_code = A.pays_code
        WHERE
      A.region_date_fin IS NULL AND B.pays_date_fin IS NULL AND A.pays_code LIKE ?
ORDER BY A.pays_code, A.region_nom
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array('%'.$code_pays.'%'));
        return $a->fetchAll();
    }

    public function editer_departement($code_region, $code, $nom, $latitude, $longitude, $user){
        $departement = $this->trouver_departement($code);
        if($departement) {
            $date_fin = date('Y-m-d',strtotime('-1 day',time()));
            if(strtotime($date_fin) > strtotime($departement['date_debut'])) {
                $edition = $this->fermer_departement($departement['code'],$date_fin,$user);
                if($edition['success'] == true) {
                    $json = $this->ajouter_departement($code_region, $nom, $latitude, $longitude, $user);
                }else {
                    $json = $edition;
                }
            }else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le ".date('d/m/Y',strtotime('+2 day',strtotime($departement['date_debut'])))
                );
            }
        }else {
            $json = $this->ajouter_departement($code_region, $nom, $latitude, $longitude, $user);
        }
        return $json;
    }

    public function trouver_departement($code){
        $query = "
SELECT 
       C.pays_code AS code_pays,
       C.pays_nom AS nom_pays,
       A.region_code AS code_region,
       B.region_nom AS nom_region,
       A.departement_code AS code,
       A.departement_nom AS nom,
       A.departement_latitude AS latitude,
       A.departement_longitude AS longitude,
       A.departement_date_debut AS date_debut,
       A.date_creation, 
       A.utilisateur_id_creation, 
       A.utilisateur_id_creation
FROM
     tb_ref_geo_departements A 
         JOIN tb_ref_geo_regions B 
             ON A.region_code = B.region_code 
         JOIN tb_ref_geo_pays C 
             ON B.pays_code = C.pays_code AND
                A.departement_code LIKE ? AND 
                A.departement_date_fin IS NULL
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        return $a->fetch();
    }

    private function fermer_departement($code, $date_fin, $user) {
        $a = $this->getBdd()->prepare("UPDATE tb_ref_geo_departements SET departement_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE departement_code = ? AND departement_date_fin IS NULL");
        $a->execute(array($date_fin,date('Y-m-d H:i:s',time()),$user,$code));
        if ($a->errorCode() == "00000"){
            return array(
                "success" => true,
                "messages" => 'Enregistrement effectué avec succès.'
            );
        }else{
            return array(
                "success" => false,
                "messages" => $a->errorInfo()
            );
        }
    }

    private function ajouter_departement($code_region, $nom, $latitude, $longitude, $user){
        $departements = $this->lister_departements(null);
        $nb_departements = count($departements);
        $code = 'D'.str_pad(intval($nb_departements + 1), 4,'0',STR_PAD_LEFT);
        $a = $this->getBdd()->prepare("INSERT INTO tb_ref_geo_departements(region_code,departement_code ,departement_nom,departement_latitude,departement_longitude,departement_date_debut ,utilisateur_id_creation)
        VALUES(:region_code,:departement_code,:departement_nom,:departement_latitude,:departement_longitude,:departement_date_debut,:utilisateur_id_creation) 
        ");
        $a->execute(array(
            'region_code' => $code_region,
            'departement_code' => $code,
            'departement_nom' => $nom,
            'departement_latitude' => $latitude,
            'departement_longitude' => $longitude,
            'departement_date_debut' => date('Y-m-d H:i:s',time()),
            'utilisateur_id_creation' => $user
        ));
        if($a->errorCode() == "00000"){
            return array(
                "success" => true,
                "message" => 'Enregistrement effectué avec succès'
            );
        }else{
            return array(
                "success" => false,
                "message" => $a->errorInfo()
            );
        }
    }

    public function lister_departements($code_region){
        $query = "
SELECT 
       C.pays_code AS code_pays,
       C.pays_nom AS nom_pays,
       A.region_code AS code_region,
       B.region_nom AS nom_region,
       B.region_code AS region,
       A.departement_code AS code,
       A.departement_nom AS nom,
       A.departement_latitude AS latitude,
       A.departement_longitude AS longitude,
       A.departement_date_debut AS date_debut,
       A.departement_date_fin AS date_fin,
       A.date_creation, 
       A.utilisateur_id_creation
FROM
     tb_ref_geo_departements A 
         JOIN tb_ref_geo_regions B 
             ON A.region_code = B.region_code 
         JOIN tb_ref_geo_pays C 
             ON B.pays_code = C.pays_code AND
                A.departement_date_fin IS NULL AND 
                A.region_code LIKE ? AND B.region_date_fin IS NULL AND C.pays_date_fin IS NULL
ORDER BY A.region_code, A.departement_nom
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array('%'.$code_region.'%'));
        return $a->fetchAll();
    }

    public function editer_commune($code_departement, $code, $nom, $latitude, $longitude, $user){
        $commune = $this->trouver_commune($code);
        if($commune) {
            $date_fin = date('Y-m-d',strtotime('-1 day',time()));
            if(strtotime($date_fin) > strtotime($commune['date_debut'])) {
                $edition = $this->fermer_commune($commune['code'],$date_fin,$user);
                if($edition['success'] == true) {
                    $json = $this->ajouter_commune($code_departement, $nom, $latitude, $longitude, $user);
                }else {
                    $json = $edition;
                }
            }else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le ".date('d/m/Y',strtotime('+2 day',strtotime($commune['date_debut'])))
                );
            }
        }else {
            $json = $this->ajouter_commune($code_departement, $nom, $latitude, $longitude, $user);
        }
        return $json;
    }

    public function trouver_commune($code){
        $query = "
SELECT 
       C.pays_code AS code_pays,
       D.pays_nom AS nom_pays,
       B.region_code AS code_region,
       C.region_nom AS nom_region,
       A.departement_code AS code_departement,
       B.departement_nom AS nom_departement,
       A.commune_code AS code,
       A.commune_nom AS nom,
       A.commune_latitude AS latitude,
       A.commune_longitude AS longitude,
       A.commune_date_debut AS date_debut,
       A.date_creation, 
       A.utilisateur_id_creation
FROM
     tb_ref_geo_communes A 
         JOIN tb_ref_geo_departements B 
             ON A.departement_code = B.departement_code 
         JOIN tb_ref_geo_regions C 
             ON B.region_code = C.region_code 
         JOIN tb_ref_geo_pays D 
             ON C.pays_code = D.pays_code AND
                A.commune_code LIKE ? AND 
                A.commune_date_fin IS NULL
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        return $a->fetch();
    }

    private function fermer_commune($code, $date_fin, $user) {
        $a = $this->getBdd()->prepare("UPDATE tb_ref_geo_communes SET commune_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE commune_code = ? AND commune_date_fin IS NULL");
        $a->execute(array($date_fin,date('Y-m-d H:i:s',time()),$user,$code));
        if ($a->errorCode() == "00000"){
            return array(
                "success" => true,
                "messages" => 'Enregistrement effectué avec succès.'
            );
        }else{
            return array(
                "success" => false,
                "messages" => $a->errorInfo()
            );
        }
    }

    private function ajouter_commune($code_departement, $nom, $latitude, $longitude, $user){
        $communes = $this->lister_communes(null);
        $nb_communes = count($communes);
        $code = 'C'.str_pad(intval($nb_communes + 1), 4,'0',STR_PAD_LEFT);
        $a = $this->getBdd()->prepare("INSERT INTO tb_ref_geo_communes(departement_code,commune_code,commune_nom,commune_latitude,commune_longitude,commune_date_debut ,utilisateur_id_creation)
        VALUES(:departement_code,:commune_code,:commune_nom,:commune_latitude,:commune_longitude,:commune_date_debut,:utilisateur_id_creation) 
        ");
        $a->execute(array(
            'departement_code' => $code_departement,
            'commune_code' => $code,
            'commune_nom' => $nom,
            'commune_latitude' => $latitude,
            'commune_longitude' => $longitude,
            'commune_date_debut' => date('Y-m-d H:i:s',time()),
            'utilisateur_id_creation' => $user
        ));
        if($a->errorCode() == "00000"){
            return array(
                "success" => true,
                "message" => 'Enregistrement effectué avec succès'
            );
        }else{
            return array(
                "success" => false,
                "message" => $a->errorInfo()
            );
        }
    }

    public function lister_communes($code_departement){
        $query = "
SELECT 
       C.pays_code AS code_pays,
       D.pays_nom AS nom_pays,
       B.region_code AS code_region,
       C.region_nom AS nom_region,
       A.departement_code AS code_departement,
       B.departement_nom AS nom_departement,
       A.commune_code AS code,
       A.commune_nom AS nom,
       A.commune_latitude AS latitude,
       A.commune_longitude AS longitude,
       A.commune_date_debut AS date_debut,
       A.date_creation, 
       A.utilisateur_id_creation
FROM
     tb_ref_geo_communes A 
        JOIN tb_ref_geo_departements B
             ON A.departement_code = B.departement_code
             
             JOIN tb_ref_geo_regions C
             ON C.region_code = B.region_code 
              
              JOIN tb_ref_geo_pays D
             ON D.pays_code = C.pays_code
             
             AND B.departement_date_fin IS null
              AND  C.region_date_fin IS null 
              AND
             D.pays_date_fin IS NULL 
             AND A.commune_date_fin IS NULL
              AND 
                A.departement_code LIKE ?
ORDER BY  A.commune_nom
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array('%'.$code_departement.'%'));
        return $a->fetchAll();
    }



}