<?php
namespace App;

class POPULATIONS extends BDD {
    public function lister() {
        $a = $this->getBdd()->prepare("
SELECT 
       population_num AS num_population, 
       rgb_num AS num_secu, 
       civilite_code AS code_civilite, 
       population_nom AS nom, 
       population_nom_patronymique AS nom_patronymique, 
       population_prenoms AS prenoms, 
       sexe_code AS code_sexe, 
       qualite_civile_code AS code_qualite_civile, 
       population_date_naissance AS date_naissance, 
       nationalite_code AS code_nationalite, 
       situation_familiale_code AS code_situation_familiale, 
       categorie_socio_professionnelle_code AS code_csp, 
       profession_code AS code_profession, 
       naissance_pays_code AS code_pays_naissance, 
       naissance_region_code AS code_region_naissance, 
       naissance_departement_code AS code_departement_naissance, 
       naissance_commune_code AS code_commune_naissance, 
       naissance_lieu AS lieu_naissance, 
       residence_pays_code AS code_pays_residence, 
       residence_region_code AS code_region_residence, 
       residence_departement_code AS code_departement_residence, 
       residence_commune_code AS code_commune_residence, 
       residence_adresse_postale AS adresse_postale, 
       residence_adresse_geographique AS adresse_geographique, 
       date_creation, 
       utilisateur_id_creation, 
       date_edition, 
       utilisateur_id_edition 
FROM 
     tb_populations 
WHERE 
      population_date_deces IS NULL");
        $a->execute(array());
        return $a->fetchAll();
    }

    public function editer($code_pays_entite, $num_population, $num_rgb, $code_civilite, $nom, $nom_patronymique, $prenoms, $code_sexe, $code_qualite_civile, $date_naissance, $code_nationalite, $code_situation_familiale, $code_categorie_socio_professionnelle, $code_profession, $code_pays_naissance, $code_region_naissance, $code_departement_naissance, $code_commune_naissance, $lieu_naissance, $code_pays_residence, $code_region_residence, $code_departement_residence, $code_commune_residence, $adresse_postale, $adresse_geographique, $user): array
    {
        if($num_population || $num_rgb) {
            $population = $this->trouver($num_population, $num_rgb);
            if($population) {
                return $this->modifier($num_population, $num_rgb, $code_civilite, $nom, $nom_patronymique, $prenoms, $code_sexe, $code_qualite_civile, $date_naissance, $code_nationalite, $code_situation_familiale, $code_categorie_socio_professionnelle, $code_profession, $code_pays_naissance, $code_region_naissance, $code_departement_naissance, $code_commune_naissance, $lieu_naissance, $code_pays_residence, $code_region_residence, $code_departement_residence, $code_commune_residence, $adresse_postale, $adresse_geographique, $user);
            }else {
                $verification = $this->verifier($nom, $prenoms, $date_naissance, $code_sexe, $code_pays_naissance, $code_region_naissance, $code_departement_naissance, $code_commune_naissance);
                if($verification) {
                    return $this->modifier($num_population, $num_rgb, $code_civilite, $nom, $nom_patronymique, $prenoms, $code_sexe, $code_qualite_civile, $date_naissance, $code_nationalite, $code_situation_familiale, $code_categorie_socio_professionnelle, $code_profession, $code_pays_naissance, $code_region_naissance, $code_departement_naissance, $code_commune_naissance, $lieu_naissance, $code_pays_residence, $code_region_residence, $code_departement_residence, $code_commune_residence, $adresse_postale, $adresse_geographique, $user);
                }else {
                    return $this->ajouter($code_pays_entite, $num_population, $num_rgb, $code_civilite, $nom, $nom_patronymique, $prenoms, $code_sexe, $code_qualite_civile, $date_naissance, $code_nationalite, $code_situation_familiale, $code_categorie_socio_professionnelle, $code_profession, $code_pays_naissance, $code_region_naissance, $code_departement_naissance, $code_commune_naissance, $lieu_naissance, $code_pays_residence, $code_region_residence, $code_departement_residence, $code_commune_residence, $adresse_postale, $adresse_geographique, $user);
                }
            }
        }else {
            $verification = $this->verifier($nom, $prenoms, $date_naissance, $code_sexe, $code_pays_naissance, $code_region_naissance, $code_departement_naissance, $code_commune_naissance);
            if($verification) {
                return $this->modifier($num_population, $num_rgb, $code_civilite, $nom, $nom_patronymique, $prenoms, $code_sexe, $code_qualite_civile, $date_naissance, $code_nationalite, $code_situation_familiale, $code_categorie_socio_professionnelle, $code_profession, $code_pays_naissance, $code_region_naissance, $code_departement_naissance, $code_commune_naissance, $lieu_naissance, $code_pays_residence, $code_region_residence, $code_departement_residence, $code_commune_residence, $adresse_postale, $adresse_geographique, $user);
            }else {
                return $this->ajouter($code_pays_entite, $num_population, $num_rgb, $code_civilite, $nom, $nom_patronymique, $prenoms, $code_sexe, $code_qualite_civile, $date_naissance, $code_nationalite, $code_situation_familiale, $code_categorie_socio_professionnelle, $code_profession, $code_pays_naissance, $code_region_naissance, $code_departement_naissance, $code_commune_naissance, $lieu_naissance, $code_pays_residence, $code_region_residence, $code_departement_residence, $code_commune_residence, $adresse_postale, $adresse_geographique, $user);
            }
        }
    }

    public function trouver($num_population, $num_rgb) {
        $a = $this->getBdd()->prepare("
SELECT 
       population_num AS num_population, 
       rgb_num AS num_secu, 
       civilite_code AS code_civilite, 
       population_nom AS nom, 
       population_nom_patronymique AS nom_patronymique, 
       population_prenoms AS prenoms, 
       sexe_code AS code_sexe, 
       qualite_civile_code AS code_qualite_civile, 
       population_date_naissance AS date_naissance, 
       nationalite_code AS code_nationalite, 
       situation_familiale_code AS code_situation_familiale, 
       categorie_socio_professionnelle_code AS code_csp, 
       profession_code AS code_profession, 
       naissance_pays_code AS code_pays_naissance, 
       naissance_region_code AS code_region_naissance, 
       naissance_departement_code AS code_departement_naissance, 
       naissance_commune_code AS code_commune_naissance, 
       naissance_lieu AS lieu_naissance, 
       residence_pays_code AS code_pays_residence, 
       residence_region_code AS code_region_residence, 
       residence_departement_code AS code_departement_residence, 
       residence_commune_code AS code_commune_residence, 
       residence_adresse_postale AS adresse_postale, 
       residence_adresse_geographique AS adresse_geographique, 
       population_date_deces AS date_deces, 
       date_creation, 
       utilisateur_id_creation, 
       date_edition, 
       utilisateur_id_edition 
FROM 
     tb_populations 
WHERE 
      population_num LIKE ? 
  AND rgb_num LIKE ?");
        $a->execute(array('%'.$num_population.'%', '%'.$num_rgb.'%'));
        return $a->fetch();
    }

    private function modifier($num_population, $num_rgb, $code_civilite, $nom, $nom_patronymique, $prenoms, $code_sexe, $code_qualite_civile, $date_naissance, $code_nationalite, $code_situation_familiale, $code_categorie_socio_professionnelle, $code_profession, $code_pays_naissance, $code_region_naissance, $code_departement_naissance, $code_commune_naissance, $lieu_naissance, $code_pays_residence, $code_region_residence, $code_departement_residence, $code_commune_residence, $adresse_postale, $adresse_geographique, $user): array
    {
        $a = $this->getBdd()->prepare("UPDATE tb_populations SET rgb_num = ?, civilite_code = ?, population_nom = ?, population_nom_patronymique = ?, population_prenoms = ?, sexe_code = ?, qualite_civile_code = ?, population_date_naissance = ?, nationalite_code = ?, situation_familiale_code = ?, categorie_socio_professionnelle_code = ?, profession_code = ?, naissance_pays_code = ?, naissance_region_code = ?, naissance_departement_code = ?, naissance_commune_code = ?, naissance_lieu = ?, residence_pays_code = ?, residence_region_code = ?, residence_departement_code = ?, residence_commune_code = ?, residence_adresse_postale = ?, residence_adresse_geographique = ?, date_edition = ?, utilisateur_id_edition = ? WHERE population_num = ?");
        $a->execute(array($num_rgb, $code_civilite, $nom, $nom_patronymique, $prenoms, $code_sexe, $code_qualite_civile, $date_naissance, $code_nationalite, $code_situation_familiale, $code_categorie_socio_professionnelle, $code_profession, $code_pays_naissance, $code_region_naissance, $code_departement_naissance, $code_commune_naissance, $lieu_naissance, $code_pays_residence, $code_region_residence, $code_departement_residence, $code_commune_residence, $adresse_postale, $adresse_geographique, date('Y-m-d H:i:s',time()), $user, $num_population));
        if ($a->errorCode() == "00000"){
            return array(
                "success" => true,
                'num_population' => $num_population,
                "message" => 'Enregistrement effectué avec succès.'
            );
        }else{
            return array(
                "success" => false,
                "message" => $a->errorInfo()
            );
        }
    }

    public function verifier($nom, $prenoms, $date_naissance, $code_sexe, $code_pays_naissance, $code_region_naissance, $code_departement_naissance, $code_commune_naissance) {
        $a = $this->getBdd()->prepare("
SELECT 
       population_num AS num_population, 
       rgb_num AS num_secu, 
       civilite_code AS code_civilite, 
       population_nom AS nom, 
       population_nom_patronymique AS nom_patronymique, 
       population_prenoms AS prenoms, 
       sexe_code AS code_sexe, 
       qualite_civile_code AS code_qualite_civile, 
       population_date_naissance AS date_naissance, 
       nationalite_code AS code_nationalite, 
       situation_familiale_code AS code_situation_familiale, 
       categorie_socio_professionnelle_code AS code_csp, 
       profession_code AS code_profession, 
       naissance_pays_code AS code_pays_naissance, 
       naissance_region_code AS code_region_naissance, 
       naissance_departement_code AS code_departement_naissance, 
       naissance_commune_code AS code_commune_naissance, 
       naissance_lieu AS lieu_naissance, 
       residence_pays_code AS code_pays_residence, 
       residence_region_code AS code_region_residence, 
       residence_departement_code AS code_departement_residence, 
       residence_commune_code AS code_commune_residence, 
       residence_adresse_postale AS adresse_postale, 
       residence_adresse_geographique AS adresse_geographique, 
       population_date_deces AS date_deces, 
       date_creation, 
       utilisateur_id_creation, 
       date_edition, 
       utilisateur_id_edition 
FROM 
     tb_populations 
WHERE 
      tb_populations.population_nom = ? 
  AND population_prenoms = ?
  AND population_date_naissance = ?
  AND sexe_code = ?
  AND naissance_pays_code = ?
  AND naissance_region_code = ?
  AND naissance_departement_code = ?
  AND naissance_commune_code = ?");
        $a->execute(array($nom, $prenoms, $date_naissance, $code_sexe, $code_pays_naissance, $code_region_naissance, $code_departement_naissance, $code_commune_naissance));
        return $a->fetch();
    }

    private function ajouter($code_pays_entite, $num_population, $num_rgb, $code_civilite, $nom, $nom_patronymique, $prenoms, $code_sexe, $code_qualite_civile, $date_naissance, $code_nationalite, $code_situation_familiale, $code_categorie_socio_professionnelle, $code_profession, $code_pays_naissance, $code_region_naissance, $code_departement_naissance, $code_commune_naissance, $lieu_naissance, $code_pays_residence, $code_region_residence, $code_departement_residence, $code_commune_residence, $adresse_postale, $adresse_geographique, $user): array
    {
        if(!$num_population) {

            $num_pays = $this->numero_pays($code_pays_entite);
            if($code_pays_residence == $code_pays_entite) {
                $type_population = 1;
            }else {
                $type_population = 2;
            }
            $b = $this->getBdd()->prepare("SELECT * FROM tb_populations WHERE YEAR(date_creation) = ? AND MONTH(date_creation) = ?");
            $b->execute(array(date('Y',time()), date('m',time())));
            $enregistrements = $b->fetchAll();
            $nb_enregistrements = count($enregistrements);
            $num_population = $num_pays.str_replace('M', 1, str_replace('F', 2, $code_sexe)).$type_population.date('ymd',time()).str_pad(intval($nb_enregistrements + 1), 5,'0', STR_PAD_LEFT);
        }
        $a = $this->getBdd()->prepare("INSERT INTO tb_populations(population_num, rgb_num, civilite_code, population_nom, population_nom_patronymique, population_prenoms, sexe_code, qualite_civile_code, population_date_naissance, nationalite_code, situation_familiale_code, categorie_socio_professionnelle_code, profession_code, naissance_pays_code, naissance_region_code, naissance_departement_code, naissance_commune_code, naissance_lieu, residence_pays_code, residence_region_code, residence_departement_code, residence_commune_code, residence_adresse_postale, residence_adresse_geographique, utilisateur_id_creation)
        VALUES(:population_num, :rgb_num, :civilite_code, :population_nom, :population_nom_patronymique, :population_prenoms, :sexe_code, :qualite_civile_code, :population_date_naissance, :nationalite_code, :situation_familiale_code, :categorie_socio_professionnelle_code, :profession_code, :naissance_pays_code, :naissance_region_code, :naissance_departement_code, :naissance_commune_code, :naissance_lieu, :residence_pays_code, :residence_region_code, :residence_departement_code, :residence_commune_code, :residence_adresse_postale, :residence_adresse_geographique, :utilisateur_id_creation)");
        $a->execute(array(
            'population_num' => $num_population,
            'rgb_num' => $num_rgb,
            'civilite_code' => $code_civilite,
            'population_nom' => $nom,
            'population_nom_patronymique' => $nom_patronymique,
            'population_prenoms' => $prenoms,
            'sexe_code' => $code_sexe,
            'qualite_civile_code' => $code_qualite_civile,
            'population_date_naissance' => $date_naissance,
            'nationalite_code' => $code_nationalite,
            'situation_familiale_code' => $code_situation_familiale,
            'categorie_socio_professionnelle_code' => $code_categorie_socio_professionnelle,
            'profession_code' => $code_profession,
            'naissance_pays_code' => $code_pays_naissance,
            'naissance_region_code' => $code_region_naissance,
            'naissance_departement_code' => $code_departement_naissance,
            'naissance_commune_code' => $code_commune_naissance,
            'naissance_lieu' => $lieu_naissance,
            'residence_pays_code' => $code_pays_residence,
            'residence_region_code' => $code_region_residence,
            'residence_departement_code' => $code_departement_residence,
            'residence_commune_code' => $code_commune_residence,
            'residence_adresse_postale' => $adresse_postale,
            'residence_adresse_geographique' => $adresse_geographique,
            'utilisateur_id_creation' => $user
        ));
        if ($a->errorCode() == "00000"){
            return array(
                "success" => true,
                'num_population' => $num_population,
                "message" => 'Enregistrement effectué avec succès.'
            );
        }else{
            return array(
                "success" => false,
                "message" => $a->errorInfo()
            );
        }
    }

    private function numero_pays($code_pays) {
        $lettres = str_split($code_pays);
        $alphabet = array(
            'A' => 1,
            'B' => 2,
            'C' => 3,
            'D' => 4,
            'E' => 5,
            'F' => 6,
            'G' => 7,
            'H' => 8,
            'I' => 9,
            'J' => 10,
            'K' => 11,
            'L' => 12,
            'M' => 13,
            'N' => 14,
            '0' => 15,
            'P' => 16,
            'Q' => 17,
            'R' => 18,
            'S' => 19,
            'T' => 20,
            'U' => 21,
            'V' => 22,
            'W' => 23,
            'X' => 24,
            'Y' => 25,
            'Z' => 26
        );
        $tableau_chiffre = array();
        foreach ($lettres as $lettre) {
            $chiffre = array_sum(str_split($alphabet[$lettre]));
            if(strlen($chiffre) > 1) {
                while (strlen($chiffre) > 1) {
                    $chiffre = array_sum(str_split($chiffre));
                }
            }
            $tableau_chiffre[] = $chiffre;
        }
        $donnees = str_replace(',', '', implode(',', $tableau_chiffre));
        return intval($donnees);
    }

    public function editer_collectivite($num_population, $code_collectivite, $user): array
    {
        $collectivite = $this->trouver_collectivite($num_population);
        if($collectivite) {
            $date_fin = date('Y-m-d',strtotime('-1 day',time()));
            if(strtotime($date_fin) > strtotime($collectivite['date_debut'])) {
                $edition = $this->fermer_collectivite($num_population, $code_collectivite, $date_fin, $user);
                if($edition['success'] == true) {
                    return $this->ajouter_collectivite($num_population, $code_collectivite, $user);
                }else {
                    return $edition;
                }
            }else {
                return array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le ".date('d/m/Y',strtotime('+2 day',strtotime($collectivite['date_debut'])))
                );
            }
        }else {
            return $this->ajouter_collectivite($num_population, $code_collectivite, $user);
        }
    }

    public function trouver_collectivite($num_population) {
        $a = $this->getBdd()->prepare("SELECT A.population_num AS num_population, A.collectivite_code AS code_collectivite, B.collectivite_raison_sociale AS raison_sociale, A.population_collectivite_date_debut AS date_debut FROM tb_populations_collectivites A JOIN tb_ref_collectivites B ON A.collectivite_code = B.collectivite_code AND A.population_num = ? AND A.population_collectivite_date_fin IS NULL");
        $a->execute(array($num_population));
        return $a->fetch();
    }

    private function fermer_collectivite($num_population, $code_collectivite, $date_fin, $user): array
    {
        $a = $this->getBdd()->prepare("UPDATE tb_populations_collectivites SET population_collectivite_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE population_num = ? AND collectivite_code = ? AND population_collectivite_date_fin IS NULL");
        $a->execute(array($date_fin, date('Y-m-d H:i:s',time()), $user, $num_population, $code_collectivite));
        if ($a->errorCode() == "00000"){
            return array(
                "success" => true,
                "message" => 'Enregistrement effectué avec succès.'
            );
        }else{
            return array(
                "success" => false,
                "message" => $a->errorInfo()
            );
        }
    }

    private function ajouter_collectivite($num_population, $code_collectivite, $user): array
    {
        $a = $this->getBdd()->prepare("INSERT INTO tb_populations_collectivites(population_num, collectivite_code, population_collectivite_date_debut, utilisateur_id_creation) 
        VALUES(:population_num, :collectivite_code, :population_collectivite_date_debut, :utilisateur_id_creation)");
        $a->execute(array(
            'population_num' => $num_population,
            'collectivite_code' => $code_collectivite,
            'population_collectivite_date_debut' => date('Y-m-d',time()),
            'utilisateur_id_creation' => $user
        ));
        if ($a->errorCode() == "00000"){
            return array(
                "success" => true,
                "message" => 'Enregistrement effectué avec succès.'
            );
        }else{
            return array(
                "success" => false,
                "message" => $a->errorInfo()
            );
        }
    }

    public function lister_coordonnees($num_population)
    {
        $a = $this->getBdd()->prepare("SELECT population_num AS num_population, type_coordonnee_code AS code_type, coordonnee_valeur AS valeur, coordonnee_date_debut AS date_debut, utilisateur_id_creation, date_creation FROM tb_populations_coordonnees WHERE population_num = ? AND coordonnee_date_fin IS NULL");
        $a->execute(array($num_population));
        return $a->fetchAll();
    }

    public function editer_coordonnee($num_population, $type, $valeur, $user): array {
        $coordonnee = $this->trouver_coordonnee($num_population, $type);
        if($coordonnee) {
            $date_fin = date('Y-m-d H:i:s',strtotime('-10 second',time()));
            if(strtotime($date_fin) > strtotime($coordonnee['date_debut'])) {
                $edition = $this->fermer_coordonnee($num_population, $type, $date_fin, $user);
                if($edition['success'] == true) {
                    $json = $this->ajouter_coordonnee($num_population, $type, $valeur, $user);
                }else {
                    $json = $edition;
                }
            }else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le ".date('d/m/Y',strtotime('+2 day',strtotime($coordonnee['date_debut'])))
                );
            }
        }else {
            $json = $this->ajouter_coordonnee($num_population, $type, $valeur, $user);
        }
        return $json;
    }

    public function trouver_coordonnee($num_population, $type) {
        $a = $this->getBdd()->prepare("SELECT population_num AS num_population, type_coordonnee_code AS code_type, coordonnee_valeur AS valeur, coordonnee_date_debut AS date_debut, utilisateur_id_creation, date_creation FROM tb_populations_coordonnees WHERE population_num = ? AND type_coordonnee_code = ? AND coordonnee_date_fin IS NULL");
        $a->execute(array($num_population, $type));
        return $a->fetch();
    }

    private function fermer_coordonnee($num_population, $type, $date_fin, $user): array {
        $a = $this->getBdd()->prepare("UPDATE tb_populations_coordonnees SET coordonnee_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE population_num = ? AND type_coordonnee_code = ? AND coordonnee_date_fin IS NULL");
        $a->execute(array($date_fin, date('Y-m-d H:i:s',time()), $user, $num_population, $type));
        if ($a->errorCode() == "00000"){
            return array(
                "success" => true,
                "message" => 'Enregistrement effectué avec succès.'
            );
        }else{
            return array(
                "success" => false,
                "message" => $a->errorInfo()
            );
        }
    }

    private function ajouter_coordonnee($num_population, $type, $valeur, $user): array
    {
        $a = $this->getBdd()->prepare("INSERT INTO tb_populations_coordonnees(population_num, type_coordonnee_code, coordonnee_valeur, coordonnee_date_debut, utilisateur_id_creation) VALUES(:population_num, :type_coordonnee_code, :coordonnee_valeur, :coordonnee_date_debut, :utilisateur_id_creation)");
        $a->execute(array(
            'population_num' => $num_population,
            'type_coordonnee_code' => $type,
            'coordonnee_valeur' => $valeur,
            'coordonnee_date_debut' => date('Y-m-d H:i:s',time()),
            'utilisateur_id_creation' => $user
        ));
        if ($a->errorCode() == "00000"){
            return array(
                "success" => true,
                "message" => 'Enregistrement effectué avec succès.'
            );
        }else{
            return array(
                "success" => false,
                "message" => $a->errorInfo()
            );
        }
    }

    public function editer_photo($num_population, $nom_photo, $user): array
    {
        $a = $this->getBdd()->prepare("UPDATE tb_populations SET population_photo = ?, date_edition = ?, utilisateur_id_edition = ? WHERE population_num = ?");
        $a->execute(array($nom_photo, date('Y-m-d H:i:s',time()), $user, $num_population));
        if ($a->errorCode() == "00000"){
            return array(
                "success" => true,
                "message" => 'Enregistrement effectué avec succès.'
            );
        }else{
            return array(
                "success" => false,
                "message" => $a->errorInfo()
            );
        }
    }

    public function lister_ecu($num_population) {
        $a = $this->getBdd()->prepare("
SELECT 
       population_num AS num_population, 
       ecu_nom AS nom, 
       ecu_prenoms AS prenoms, 
       ecu_telephone AS num_telephone, 
       ecu_date_debut AS date_debut, 
       type_personne_code AS code_type_personne, 
       date_creation, 
       utilisateur_id_creation, 
       date_edition, 
       utilisateur_id_edition 
FROM 
     tb_populations_ecu 
WHERE 
      population_num = ? 
  AND ecu_date_fin IS NULL");
        $a->execute(array($num_population));
        return $a->fetchAll();
    }
}
