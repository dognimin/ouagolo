<?php
namespace App;

class SECTEURSACTIVITES extends BDD
{
    private function ajouter($code, $libelle, $user){
        $a = $this->getBdd()->prepare("INSERT INTO tb_ref_secteurs_activites(secteur_activite_code,secteur_activite_libelle,secteur_activite_date_debut,utilisateur_id_creation)
        VALUES(:secteur_activite_code,:secteur_activite_libelle,:secteur_activite_date_debut,:utilisateur_id_creation) 
        ");
        $a->execute(array(
            'secteur_activite_code' => $code,
            'secteur_activite_libelle' => $libelle,
            'secteur_activite_date_debut' => date('Y-m-d H:i:s',time()),
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

    private function fermer($code, $date_fin, $user) {
        $a = $this->getBdd()->prepare("UPDATE tb_ref_secteurs_activites  SET secteur_activite_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE secteur_activite_code = ? AND secteur_activite_date_fin IS NULL");
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

    public function trouver($code){
        $query = "
SELECT 
       secteur_activite_code AS code,
       secteur_activite_libelle AS libelle,
       secteur_activite_date_debut AS date_debut,
       utilisateur_id_creation
FROM
     tb_ref_secteurs_activites
WHERE
      secteur_activite_code LIKE ? AND 
      secteur_activite_date_fin IS NULL
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        return $a->fetch();
    }


    public function lister() {
        $query = "
SELECT 
       A.secteur_activite_code AS code, 
       A.secteur_activite_libelle AS libelle, 
       A.secteur_activite_date_debut AS date_debut, 
       A.date_creation, 
       A.utilisateur_id_creation
FROM 
     tb_ref_secteurs_activites A
WHERE 
      A.secteur_activite_date_fin IS NULL
ORDER BY A.secteur_activite_libelle
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array());
        return $a->fetchAll();
    }

    public function editer($code, $libelle, $user){
        $secteursactivites = $this->trouver($code);
        if($secteursactivites) {
            $date_fin = date('Y-m-d',strtotime('-1 day',time()));
            if(strtotime($date_fin) > strtotime($secteursactivites['date_debut'])) {
                $edition = $this->fermer($secteursactivites['code'],$date_fin,$user);
                if($edition['success'] == true) {
                    $json = $this->ajouter($code, $libelle, $user);
                }else {
                    $json = $edition;
                }
            }else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le ".date('d/m/Y',strtotime('+2 day',strtotime($secteursactivites['date_debut'])))
                );
            }
        }else {
            $json = $this->ajouter($code, $libelle, $user);
        }
        return $json;
    }

    public function lister_historique($code) {
        $query = "
SELECT 
       A.secteur_activite_code AS code, 
       A.secteur_activite_libelle AS libelle, 
       A.secteur_activite_date_debut AS date_debut, 
       A.secteur_activite_date_fin AS date_fin, 
       A.date_creation, 
       A.utilisateur_id_creation,
       B.utilisateur_nom AS nom,
       B.utilisateur_prenoms AS prenoms
       
FROM 
     tb_ref_secteurs_activites A JOIN tb_utilisateurs B 
         ON 
             A.utilisateur_id_creation = B.utilisateur_id AND A.secteur_activite_code LIKE ?
ORDER BY 
         A.date_creation DESC
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array('%'.$code.'%'));
        $json = $a->fetchAll();
        return $json;
    }




}