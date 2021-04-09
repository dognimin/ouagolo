<?php

class GROUPESSANGUINS extends BDD
{

    private function ajouter($code, $libelle, $user){
        $a = $this->bdd->prepare("INSERT INTO tb_ref_groupes_sanguins(groupe_sanguin_code, groupe_sanguin_libelle, groupe_sanguin_date_debut, utilisateur_id_creation)
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
                "message" => 'Enregistrement effectue avec succès'
            );
        }else{
            return array(
                "success" => false,
                "message" => $a->errorInfo()
            );
        }
    }

    private function fermer($code, $date_fin, $user) {
        $a = $this->bdd->prepare("UPDATE tb_ref_groupes_sanguins  SET groupe_sanguin_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE groupe_sanguin_code = ? AND groupe_sanguin_date_fin IS NULL");
        $a->execute(array($date_fin,date('Y-m-d H:i:s',time()),$user,$code));
        if ($a->errorCode() == "00000"){
            return array(
                "success" => true,
                "messages" => 'Enregistrement effectue avec succès.'
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
        $a = $this->bdd->prepare($query);
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
        $a = $this->bdd->prepare($query);
        $a->execute(array());
        return $a->fetchAll();
    }

    public function editer($code, $libelle, $user){
        $sexe = $this->trouver($code);
        if($sexe) {
            $date_fin = date('Y-m-d',strtotime('-1 day',time()));
            if(strtotime($date_fin) > strtotime($sexe['date_debut'])) {
                $edition = $this->fermer($sexe['code'],$date_fin,$user);
                if($edition['success'] == true) {
                    $json = $this->ajouter($code, $libelle, $user);
                }else {
                    $json = $edition;
                }
            }else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le ".date('d/m/Y',strtotime('+2 day',strtotime($sexe['date_debut'])))
                );
            }
        }else {
            $json = $this->ajouter($code, $libelle, $user);
        }
        return $json;
    }




    private function ajouter_rhesus($code, $libelle, $user){
        $a = $this->bdd->prepare("INSERT INTO tb_ref_rhesus(rhesus_code, rhesus_libelle, rhesus_date_debut, utilisateur_id_creation)
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
                "message" => 'Enregistrement effectue avec succès'
            );
        }else{
            return array(
                "success" => false,
                "message" => $a->errorInfo()
            );
        }
    }

    private function fermer_rhesus($code, $date_fin, $user) {
        $a = $this->bdd->prepare("UPDATE tb_ref_rhesus SET rhesus_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE rhesus_code = ? AND rhesus_date_fin IS NULL");
        $a->execute(array($date_fin,date('Y-m-d H:i:s',time()),$user,$code));
        if ($a->errorCode() == "00000"){
            return array(
                "success" => true,
                "messages" => 'Enregistrement effectue avec succès.'
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
        $a = $this->bdd->prepare($query);
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
        $a = $this->bdd->prepare($query);
        $a->execute(array());
        return $a->fetchAll();
    }

    public function editer_rhesus($code, $libelle, $user){
        $sexe = $this->trouver_rhesus($code);
        if($sexe) {
            $date_fin = date('Y-m-d',strtotime('-1 day',time()));
            if(strtotime($date_fin) > strtotime($sexe['date_debut'])) {
                $edition = $this->fermer_rhesus($sexe['code'],$date_fin,$user);
                if($edition['success'] == true) {
                    $json = $this->ajouter_rhesus($code, $libelle, $user);
                }else {
                    $json = $edition;
                }
            }else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le ".date('d/m/Y',strtotime('+2 day',strtotime($sexe['date_debut'])))
                );
            }
        }else {
            $json = $this->ajouter_rhesus($code, $libelle, $user);
        }
        return $json;
    }
}