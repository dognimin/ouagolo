<?php
namespace App;

class COLLEGES extends BDD
{
    public function lister_annees($code_organisme){
        $a = $this->getBdd()->prepare("
SELECT 
       YEAR(police_college_date_debut) AS annee, 
       COUNT(police_college_code) AS nombre 
FROM tb_organismes_polices_colleges A 
    JOIN tb_organismes_polices B 
        ON A.police_id = B.police_id 
               AND organisme_code = ? 
GROUP BY 
         YEAR(police_college_date_debut) 
ORDER BY 
         YEAR(police_college_date_debut) DESC");
        $a->execute(array($code_organisme));
        return $a->fetchAll();
    }

    public function editer($code_organisme, $code_collectivite, $id_police, $code, $libelle, $description, $date_debut, $date_fin, $user): array
    {
        if($code) {
            $college = $this->trouver($id_police, $code);
            if($college) {
                return $this->modifier($college['id_police'], $code, $libelle, $description, $date_debut, $date_fin, $user);
            }else {
                return array(
                    'success' => false,
                    'message' => "Le code ne correspond à aucun contrat de votre organisme."
                );
            }
        }else {
            return $this->ajouter($code_organisme, $code_collectivite, $id_police, $libelle, $description, $date_debut, $user);
        }
    }

    public function trouver($id_police, $code) {
        $a = $this->getBdd()->prepare("
SELECT 
       A.police_id AS id_police,
       B.police_nom AS nom_police,
       A.police_college_code AS code,
       A.police_college_libelle AS libelle,
       A.police_college_description AS description,
       A.police_college_date_debut AS date_debut,
       A.police_college_date_fin AS date_fin,
       A.date_creation,
       A.utilisateur_id_creation,
       A.date_edition,
       A.utilisateur_id_edition
FROM 
     tb_organismes_polices_colleges A 
         JOIN tb_organismes_polices B 
             ON A.police_id = B.police_id 
                    AND A.police_id = ? 
                    AND A.police_college_code = ?
ORDER BY B.police_nom");
        $a->execute(array($id_police, $code));
        return $a->fetch();
    }

    private function modifier($id_police, $code, $libelle, $description, $date_debut, $date_fin, $user): array
    {
        $a = $this->getBdd()->prepare("UPDATE tb_organismes_polices_colleges SET police_college_libelle = ?, police_college_description = ?, police_college_date_debut = ?, police_college_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE police_college_code = ? AND police_id = ?");
        $a->execute(array($libelle, $description, $date_debut, $date_fin, date('Y-m-d H:i:s',time()), $user, $code, $id_police));
        if($a->errorCode() == "00000"){
            return array(
                "success" => true,
                "code" => $code,
                "message" => 'Enregistrement effectué avec succès'
            );
        }else{
            return array(
                "success" => false,
                "message" => $a->errorInfo()[2]
            );
        }
    }

    private function ajouter($code_organisme, $code_collectivite, $id_police, $libelle, $description, $date_debut, $user): array
    {
        $colleges = $this->lister($id_police);
        $nb_colleges = count($colleges);
        $code = date('Ym',time()).str_replace('ORG', '', $code_organisme).str_replace('COL', '', $code_collectivite).str_pad(intval($nb_colleges + 1), 5, '0', STR_PAD_LEFT);

        $a = $this->getBdd()->prepare("INSERT INTO tb_organismes_polices_colleges(police_id, police_college_code, police_college_libelle, police_college_description, police_college_date_debut, utilisateur_id_creation)
        VALUES(:police_id, :police_college_code, :police_college_libelle, :police_college_description, :police_college_date_debut, :utilisateur_id_creation)");
        $a->execute(array(
            'police_id' => $id_police,
            'police_college_code' => $code,
            'police_college_libelle' => $libelle,
            'police_college_description' => $description,
            'police_college_date_debut' => $date_debut,
            'utilisateur_id_creation' => $user
        ));
        if($a->errorCode() == "00000"){
            return array(
                "success" => true,
                "code" => $code,
                "message" => 'Enregistrement effectué avec succès'
            );
        }else{
            return array(
                "success" => false,
                "message" => $a->errorInfo()[2]
            );
        }
    }

    public function lister($id_police)
    {
        $a = $this->getBdd()->prepare("
SELECT 
       A.police_id AS id_police,
       A.police_college_code AS code,
       A.police_college_libelle AS libelle,
       A.police_college_description AS description,
       A.police_college_date_debut AS date_debut,
       A.police_college_date_fin AS date_fin,
       B.collectivite_code AS code_collectivite,
       B.police_nom AS nom_police,
       B.police_date_debut AS date_debut_police,
       A.date_creation,
       A.utilisateur_id_creation,
       A.date_edition,
       A.utilisateur_id_edition
FROM 
     tb_organismes_polices_colleges A 
         JOIN tb_organismes_polices B 
             ON A.police_id = B.police_id 
                    AND A.police_id = ? 
ORDER BY A.police_college_libelle");
        $a->execute(array($id_police));
        return $a->fetchAll();
    }

    public function trouver_statut($code) {
        $a = $this->getBdd()->prepare("
SELECT 
       police_college_code AS code, 
       police_college_statut AS statut, 
       police_college_motif AS motif, 
       police_college_date_debut AS date_debut 
FROM 
     tb_organismes_polices_colleges_statuts 
WHERE 
      police_college_code = ? 
  AND police_college_date_fin IS NULL");
        $a->execute(array($code));
        return $a->fetch();
    }

    private function ajouter_statut($code, $statut, $motif, $date_debut, $user) {
        $a = $this->getBdd()->prepare("INSERT INTO tb_organismes_polices_colleges_statuts(police_college_code, police_college_statut, police_college_motif, police_college_date_debut, utilisateur_id_creation) 
        VALUES(:police_college_code, :police_college_statut, :police_college_motif, :police_college_date_debut, :utilisateur_id_creation)");
        $a->execute(array(
            'police_college_code' => $code,
            'police_college_statut' => $statut,
            'police_college_motif' => $motif,
            'police_college_date_debut' => $date_debut,
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
                "message" => $a->errorInfo()[2]
            );
        }
    }

    private function fermer_statut($code, $statut, $date_fin, $user) {
        $a = $this->getBdd()->prepare("UPDATE tb_organismes_polices_colleges_statuts SET police_college_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE police_college_code = ? AND police_college_statut = ? AND police_college_date_fin IS NULL");
        $a->execute(array($date_fin, date('Y-m-d H:i:s', time()), $user, $code, $statut));
        if($a->errorCode() == "00000"){
            return array(
                "success" => true,
                "message" => 'Enregistrement effectué avec succès'
            );
        }else{
            return array(
                "success" => false,
                "message" => $a->errorInfo()[2]
            );
        }
    }

    public function editer_statut($code, $statut, $motif, $date_debut, $user) {
        $contrat_statut = $this->trouver_statut($code);
        if($contrat_statut) {
            $date_fin = date('Y-m-d',strtotime('-1 day',time()));
            if(strtotime($date_fin) > strtotime($contrat_statut['date_debut'])) {
                $fermer = $this->fermer_statut($code, $contrat_statut['statut'], $date_fin, $user);
                if($fermer['success'] == true) {
                    return $this->ajouter_statut($code, $statut, $motif, $date_debut, $user);

                }else {
                    return $fermer;
                }
            }else {
                return array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le ".date('d/m/Y',strtotime('+2 day',strtotime($contrat_statut['date_debut'])))
                );
            }
        }else {
            return $this->ajouter_statut($code, $statut, $motif, $date_debut, $user);
        }
    }

    public function lister_assure_colleges($id_police, $num_population) {
        $a = $this->getBdd()->prepare("
SELECT 
       A.police_college_code AS code,
       C.police_id AS id_police,
       C.organisme_code AS code_organisme,
       C.collectivite_code AS code_collectivite,
       D.collectivite_raison_sociale AS raison_sociale,
       A.population_num AS num_population, 
       A.population_num_contractant AS num_population_contractant, 
       A.qualite_civile_code AS code_qualite_civile, 
       A.population_college_date_debut AS date_debut, 
       A.population_college_date_fin AS date_fin,
       B.police_college_date_fin AS date_fin_college
FROM 
     tb_populations_colleges A 
         JOIN tb_organismes_polices_colleges B 
             ON A.police_college_code = B.police_college_code 
         JOIN tb_organismes_polices C 
             ON B.police_id = C.police_id 
         JOIN tb_ref_collectivites D 
             ON C.collectivite_code = D.collectivite_code 
                    AND C.police_id = ?
                    AND A.population_num = ? 
ORDER BY 
         A.date_creation DESC");
        $a->execute(array($id_police, $num_population));
        return $a->fetchAll();
    }

    public function lister_assures($id_police, $code)
    {
        $a = $this->getBdd()->prepare("
SELECT 
       B.police_id AS id_police, 
       A.police_college_code AS code, 
       A.population_num_contractant AS contractant_num_population, 
       A.population_num As num_population, 
       A.population_college_date_debut AS date_debut,
       C.rgb_num AS num_rgb,
       C.civilite_code AS code_civilite,
       C.population_prenoms AS prenoms,
       C.population_nom AS nom,
       C.population_date_naissance AS date_naissance
FROM 
     tb_populations_colleges A 
         JOIN tb_organismes_polices_colleges B 
             ON A.police_college_code = B.police_college_code 
         JOIN tb_populations C 
             ON A.population_num = C.population_num
                    AND B.police_id = ? 
                    AND A.police_college_code = ? 
ORDER BY 
         A.population_num_contractant, 
         A.population_num");
        $a->execute(array($id_police, $code));
        return $a->fetchAll();
    }

    public function lister_assures_payeurs($id_police, $code) {
        $a = $this->getBdd()->prepare("
SELECT 
       B.police_id AS id_police, 
       A.police_college_code AS code, 
       A.population_num_contractant AS contractant_num_population, 
       A.population_num As num_population, 
       A.population_college_date_debut AS date_debut,
       C.rgb_num AS num_rgb,
       C.civilite_code AS code_civilite,
       C.population_prenoms AS prenoms,
       C.population_nom AS nom,
       C.population_date_naissance AS date_naissance
FROM 
     tb_populations_colleges A 
         JOIN tb_organismes_polices_colleges B 
             ON A.police_college_code = B.police_college_code 
         JOIN tb_populations C 
             ON A.population_num = C.population_num
                    AND A.population_num_contractant = A.population_num
                    AND A.qualite_civile_code = ?
                    AND B.police_id = ? 
                    AND A.police_college_code = ?");
        $a->execute(array('PAY', $id_police, $code));
        return $a->fetchAll();
    }

    public function lister_assures_couverts($id_police, $code, $num_population) {
        $a = $this->getBdd()->prepare("
SELECT 
       B.police_id AS id_police, 
       A.police_college_code AS code, 
       A.population_num_contractant AS contractant_num_population, 
       A.population_num As num_population, 
       A.population_college_date_debut AS date_debut,
       C.rgb_num AS num_rgb,
       C.civilite_code AS code_civilite,
       C.population_prenoms AS prenoms,
       C.population_nom AS nom,
       C.population_date_naissance AS date_naissance
FROM 
     tb_populations_colleges A 
         JOIN tb_organismes_polices_colleges B 
             ON A.police_college_code = B.police_college_code 
         JOIN tb_populations C 
             ON A.population_num = C.population_num
                    AND A.population_num_contractant != A.population_num
                    AND A.qualite_civile_code != ?
                    AND B.police_id = ? 
                    AND A.police_college_code = ? 
                    AND A.population_num_contractant = ?");
        $a->execute(array('PAY', $id_police, $code, $num_population));
        return $a->fetchAll();
    }

    public function ajouter_assure($code, $code_qualite_civile, $num_population_payeur, $num_population, $date_debut, $user) {
        $a = $this->getBdd()->prepare("INSERT INTO tb_populations_colleges(police_college_code, qualite_civile_code, population_num_contractant, population_num, population_college_date_debut, utilisateur_id_creation)
        VALUES(:police_college_code, :qualite_civile_code, :population_num_contractant, :population_num, :population_college_date_debut, :utilisateur_id_creation)");
        $a->execute(array(
            'police_college_code' => $code,
            'qualite_civile_code' => $code_qualite_civile,
            'population_num_contractant' => $num_population_payeur,
            'population_num' => $num_population,
            'population_college_date_debut' => $date_debut,
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

    public function trouver_assure($id_police, $code, $num_population) {
        $a = $this->getBdd()->prepare("
SELECT 
       B.police_id AS id_police,
       B.police_college_libelle AS libelle,
       B.police_college_date_debut AS date_debut,
       B.police_college_date_fin AS date_fin,
       A.police_college_code AS code, 
       A.population_num_contractant AS contractant_num_population, 
       A.population_num As num_population, 
       C.rgb_num AS num_rgb,
       C.population_nom AS nom,
       C.population_prenoms AS prenoms,
       C.population_date_naissance AS date_naissance,
       A.population_college_date_debut AS date_debut 
FROM 
     tb_populations_colleges A 
         JOIN tb_organismes_polices_colleges B 
             ON A.police_college_code = B.police_college_code 
         JOIN tb_populations C 
             ON A.population_num = C.population_num
                    AND B.police_id = ? 
                    AND A.police_college_code = ?
                    AND A.population_num = ?");
        $a->execute(array($id_police, $code, $num_population));
        return $a->fetch();
    }

    public function moteur_recherche($code_organisme, $annee, $raison_sociale){
        $a = $this->getBdd()->prepare("
SELECT 
       B.organisme_code AS code_organisme, 
       B.collectivite_code AS code_collectivite, 
       A.police_college_code AS code, 
       A.police_college_libelle AS libelle, 
       B.police_id AS id_police, 
       B.police_nom AS libelle_police, 
       B.police_description AS description, 
       B.police_date_debut AS date_debut, 
       B.police_date_fin AS date_fin 
FROM 
     tb_organismes_polices_colleges A 
         JOIN tb_organismes_polices B 
             ON A.police_id = B.police_id 
         JOIN tb_ref_collectivites C 
             ON B.collectivite_code = C.collectivite_code
                    AND B.organisme_code LIKE ? 
                    AND YEAR(B.police_date_debut) LIKE ? 
                    AND B.police_nom LIKE ?");
        $a->execute(array($code_organisme, '%'.$annee.'%', '%'.$raison_sociale.'%'));
        return $a->fetchAll();
    }

    public function trouver_produit($code) {
        $a = $this->getBdd()->prepare("
SELECT 
       A.police_college_code AS code, 
       A.produit_code AS code_produit,
       B.produit_libelle AS libelle_produit,
       A.college_produit_date_debut AS date_debut
FROM 
     tb_organismes_colleges_produits A 
         JOIN tb_organismes_produits B 
             ON A.produit_code = B.produit_code 
                    AND A.police_college_code = ? 
                    AND A.college_produit_date_fin IS NULL 
                    AND B.produit_date_fin IS NULL");
        $a->execute(array($code));
        return $a->fetch();
    }

    private function ajouter_produit($code, $code_produit, $user) {
        $a = $this->getBdd()->prepare("INSERT INTO tb_organismes_colleges_produits(police_college_code, produit_code, college_produit_date_debut, utilisateur_id_creation) 
        VALUES(:police_college_code, :produit_code, :college_produit_date_debut, :utilisateur_id_creation)");
        $a->execute(array(
            'police_college_code' => $code,
            'produit_code' => $code_produit,
            'college_produit_date_debut' => date('Y-m-d', time()),
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

    private function fermer_produit($code, $code_produit, $date_fin, $user) {
        $a = $this->getBdd()->prepare("UPDATE tb_organismes_colleges_produits SET college_produit_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE produit_code = ? AND police_college_code = ? AND college_produit_date_fin IS NULL");
        $a->execute(array($date_fin, date('Y-m-d H:i:s', time()), $user, $code_produit, $code));
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

    public function editer_produit($code, $code_produit, $user) {
        $produit = $this->trouver_produit($code);
        if($produit) {
            $date_fin = date('Y-m-d',strtotime('-1 day',time()));
            if(strtotime($date_fin) > strtotime($produit['date_debut'])) {
                $fermer = $this->fermer_produit($code, $code_produit, $date_fin, $user);
                if($fermer['success'] == true) {
                    return $this->ajouter_produit($code, $code_produit, $user);

                }else {
                    return $fermer;
                }
            }else {
                return array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le ".date('d/m/Y',strtotime('+2 day',strtotime($produit['date_debut'])))
                );
            }
        }else {
            return $this->ajouter_produit($code, $code_produit, $user);
        }
    }

}