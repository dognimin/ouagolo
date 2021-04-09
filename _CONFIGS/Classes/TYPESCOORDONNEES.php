<?php


class TYPESCOORDONNEES extends  BDD
{
    private function ajouter($code, $libelle, $user){
        $a = $this->bdd->prepare("INSERT INTO tb_ref_types_coordonnees(type_coordonnee_code, type_coordonnee_libelle, type_coordonnee_date_debut, utilisateur_id_creation)
        VALUES(:type_coordonnee_code, :type_coordonnee_libelle, :type_coordonnee_date_debut, :utilisateur_id_creation) 
        ");
        $a->execute(array(
            'type_coordonnee_code' => $code,
            'type_coordonnee_libelle' => $libelle,
            'type_coordonnee_date_debut' => date('Y-m-d H:i:s',time()),
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
        $a = $this->bdd->prepare("UPDATE tb_ref_types_coordonnees  SET type_coordonnee_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE type_coordonnee_code = ? AND type_coordonnee_date_fin IS NULL");
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
       type_coordonnee_code AS code,
       type_coordonnee_libelle AS libelle,
       type_coordonnee_date_debut AS date_debut,
       utilisateur_id_creation
FROM
     tb_ref_types_coordonnees
WHERE
      type_coordonnee_code LIKE ? AND 
      type_coordonnee_date_fin IS NULL
        ";
        $a = $this->bdd->prepare($query);
        $a->execute(array($code));
        return $a->fetch();
    }

    public function lister()
    {
        $query = "
SELECT 
       type_coordonnee_code AS code,
       type_coordonnee_libelle AS libelle,
       type_coordonnee_date_debut AS date_debut,
       utilisateur_id_creation
FROM
     tb_ref_types_coordonnees
WHERE
      type_coordonnee_date_fin IS NULL
        ";
        $a = $this->bdd->prepare($query);
        $a->execute(array());
        $json = $a->fetchAll();
        return $json;
    }

    public function editer($code, $libelle, $user){
        $typescoord = $this->trouver($code);
        if($typescoord) {
            $date_fin = date('Y-m-d',strtotime('-1 day',time()));
            if(strtotime($date_fin) > strtotime($typescoord['date_debut'])) {
                $edition = $this->fermer($typescoord['code'],$date_fin,$user);
                if($edition['success'] == true) {
                    $json = $this->ajouter($code, $libelle, $user);
                }else {
                    $json = $edition;
                }
            }else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le ".date('d/m/Y',strtotime('+2 day',strtotime($typescoord['date_debut'])))
                );
            }
        }else {
            $json = $this->ajouter($code, $libelle, $user);
        }
        return $json;
    }
}