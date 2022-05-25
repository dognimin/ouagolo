<?php
namespace App;

class GROUPESSANGUINS extends BDD
{

    private function ajouter($code, $libelle, $user){
        $a = $this->getBdd()->prepare("INSERT INTO tb_ref_groupes_sanguins(groupe_sanguin_code, groupe_sanguin_libelle, groupe_sanguin_date_debut, utilisateur_id_creation)
        VALUES(:groupe_sanguin_code, :groupe_sanguin_libelle, :groupe_sanguin_date_debut, :utilisateur_id_creation) 
        ");
        $a->execute(array(
            'groupe_sanguin_code' => $code,
            'groupe_sanguin_libelle' => $libelle,
            'groupe_sanguin_date_debut' => date('Y-m-d H:i:s',time()),
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
        $a = $this->getBdd()->prepare("UPDATE tb_ref_groupes_sanguins  SET groupe_sanguin_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE groupe_sanguin_code = ? AND groupe_sanguin_date_fin IS NULL");
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
       A.groupe_sanguin_code AS code, 
       A.groupe_sanguin_libelle AS libelle, 
       A.groupe_sanguin_date_debut AS date_debut, 
       utilisateur_id_creation
FROM
     tb_ref_groupes_sanguins A
WHERE
      A.groupe_sanguin_code LIKE ? AND 
      A.groupe_sanguin_date_fin IS NULL
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        return $a->fetch();
    }

    public function lister() {
        $query = "
SELECT 
       A.groupe_sanguin_code AS code, 
       A.groupe_sanguin_libelle AS libelle, 
       A.groupe_sanguin_date_debut AS date_debut, 
       A.date_creation, 
       A.utilisateur_id_creation
FROM 
     tb_ref_groupes_sanguins A
WHERE 
      A.groupe_sanguin_date_fin IS NULL
ORDER BY A.groupe_sanguin_libelle
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array());
        return $a->fetchAll();
    }

    public function editer($code, $libelle, $user){
        $groupesanguins = $this->trouver($code);
        if($groupesanguins) {
            $date_fin = date('Y-m-d',strtotime('-1 day',time()));
            if(strtotime($date_fin) > strtotime($groupesanguins['date_debut'])) {
                $edition = $this->fermer($groupesanguins['code'],$date_fin,$user);
                if($edition['success'] == true) {
                    $json = $this->ajouter($code, $libelle, $user);
                }else {
                    $json = $edition;
                }
            }else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le ".date('d/m/Y',strtotime('+2 day',strtotime($groupesanguins['date_debut'])))
                );
            }
        }else {
            $json = $this->ajouter($code, $libelle, $user);
        }
        return $json;
    }

    public function lister_historique_groupe_sanguin($code) {
        $query = "
SELECT 
       A.groupe_sanguin_code AS code, 
       A.groupe_sanguin_libelle AS libelle, 
       A.groupe_sanguin_date_debut AS date_debut, 
       A.groupe_sanguin_date_fin AS date_fin, 
       A.date_creation, 
       A.utilisateur_id_creation,
       B.utilisateur_nom AS nom,
       B.utilisateur_prenoms AS prenoms
       
FROM 
     tb_ref_groupes_sanguins A JOIN tb_utilisateurs B 
         ON 
             A.utilisateur_id_creation = B.utilisateur_id AND A.groupe_sanguin_code LIKE ?
ORDER BY 
         A.date_creation DESC
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array('%'.$code.'%'));
        $json = $a->fetchAll();
        return $json;
    }




    private function ajouter_rhesus($code, $libelle, $user){
        $a = $this->getBdd()->prepare("INSERT INTO tb_ref_rhesus(rhesus_code, rhesus_libelle, rhesus_date_debut, utilisateur_id_creation)
        VALUES(:rhesus_code, :rhesus_libelle, :rhesus_date_debut, :utilisateur_id_creation) 
        ");
        $a->execute(array(
            'rhesus_code' => $code,
            'rhesus_libelle' => $libelle,
            'rhesus_date_debut' => date('Y-m-d H:i:s',time()),
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

    private function fermer_rhesus($code, $date_fin, $user) {
        $a = $this->getBdd()->prepare("UPDATE tb_ref_rhesus SET rhesus_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE rhesus_code = ? AND rhesus_date_fin IS NULL");
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

    public function trouver_rhesus($code){
        $query = "
SELECT 
       A.rhesus_code AS code, 
       A.rhesus_libelle AS libelle, 
       A.rhesus_date_debut AS date_debut, 
       A.utilisateur_id_creation
FROM
     tb_ref_rhesus A
WHERE
      A.rhesus_code LIKE ? AND 
      A.rhesus_date_fin IS NULL
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        return $a->fetch();
    }

    public function lister_rhesus() {
        $query = "
SELECT 
       A.rhesus_code AS code, 
       A.rhesus_libelle AS libelle, 
       A.rhesus_date_debut AS date_debut, 
       A.utilisateur_id_creation
FROM 
     tb_ref_rhesus A
WHERE 
      A.rhesus_date_fin IS NULL
ORDER BY A.rhesus_libelle
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array());
        return $a->fetchAll();
    }

    public function editer_rhesus($code, $libelle, $user){
        $rhesus = $this->trouver_rhesus($code);
        if($rhesus) {
            $date_fin = date('Y-m-d',strtotime('-1 day',time()));
            if(strtotime($date_fin) > strtotime($rhesus['date_debut'])) {
                $edition = $this->fermer_rhesus($rhesus['code'],$date_fin,$user);
                if($edition['success'] == true) {
                    $json = $this->ajouter_rhesus($code, $libelle, $user);
                }else {
                    $json = $edition;
                }
            }else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le ".date('d/m/Y',strtotime('+2 day',strtotime($rhesus['date_debut'])))
                );
            }
        }else {
            $json = $this->ajouter_rhesus($code, $libelle, $user);
        }
        return $json;
    }

    public function lister_historique_rhesus($code) {
        $query = "
SELECT 
       A.rhesus_code AS code, 
       A.rhesus_libelle AS libelle, 
       A.rhesus_date_debut AS date_debut, 
       A.rhesus_date_fin AS date_fin, 
       A.utilisateur_id_creation,
       A.date_creation,
       B.utilisateur_nom AS nom,
       B.utilisateur_prenoms AS prenoms
FROM 
     tb_ref_rhesus A JOIN tb_utilisateurs B 
         ON 
             A.utilisateur_id_creation = B.utilisateur_id AND A.rhesus_code LIKE ?
ORDER BY 
         A.date_creation DESC
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array('%'.$code.'%'));
        $json = $a->fetchAll();
        return $json;
    }

}