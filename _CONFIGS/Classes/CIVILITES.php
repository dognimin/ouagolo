<?php

class CIVILITES extends BDD
{
    private function ajouter($code, $libelle, $user){
        $a = $this->bdd->prepare("INSERT INTO tb_ref_civilites(civilite_code,civilite_libelle,civilite_date_debut,utilisateur_id_creation)
        VALUES(:civilite_code,:civilite_libelle,:civilite_date_debut,:utilisateur_id_creation) 
        ");
        $a->execute(array(
            'civilite_code' => $code,
            'civilite_libelle' => $libelle,
            'civilite_date_debut' => date('Y-m-d H:i:s',time()),
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
        $a = $this->bdd->prepare("UPDATE tb_ref_civilites  SET civilite_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE civilite_code = ? AND civilite_date_fin IS NULL");
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
       civilite_code AS code,
       civilite_libelle AS libelle,
       civilite_date_debut AS date_debut,
       utilisateur_id_creation
FROM
     tb_ref_civilites
WHERE
      civilite_code LIKE ? AND 
      civilite_date_fin IS NULL
        ";
        $a = $this->bdd->prepare($query);
        $a->execute(array($code));
        return $a->fetch();
    }
    public function lister() {
        $query = "
SELECT 
       A.civilite_code AS code, 
       A.civilite_libelle AS libelle, 
       A.civilite_date_debut AS date_debut, 
       A.date_creation, 
       A.utilisateur_id_creation
FROM 
     tb_ref_civilites A
WHERE 
      A.civilite_date_fin IS NULL
ORDER BY A.civilite_libelle
";
        $a = $this->bdd->prepare($query);
        $a->execute(array());
        return $a->fetchAll();
    }

    public function editer($code, $libelle, $user){
        $civilite = $this->trouver($code);
        if($civilite) {
            $date_fin = date('Y-m-d',strtotime('-1 day',time()));
            if(strtotime($date_fin) > strtotime($civilite['date_debut'])) {
                $edition = $this->fermer($civilite['code'],$date_fin,$user);
                if($edition['success'] == true) {
                    $json = $this->ajouter($code, $libelle, $user);
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
            $json = $this->ajouter($code, $libelle, $user);
        }
        return $json;
    }

}