<?php
namespace App;

class ALLERGIES extends BDD
{

    public function editer($code, $libelle, $user){
        $allergie = $this->trouver($code);
        if($allergie) {
            $date_fin = date('Y-m-d',strtotime('-1 day',time()));
            if(strtotime($date_fin) > strtotime($allergie['date_debut'])) {
                $edition = $this->fermer($allergie['code'],$date_fin,$user);
                if($edition['success'] == true) {
                    $json = $this->ajouter($code, $libelle, $user);
                }else {
                    $json = $edition;
                }
            }else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le ".date('d/m/Y',strtotime('+2 day',strtotime($allergie['date_debut'])))
                );
            }
        }else {
            $json = $this->ajouter($code, $libelle, $user);
        }
        return $json;
    }

    public function trouver($code){
        $query = "
SELECT 
       allergie_code AS code,
       allergie_libelle AS libelle,
       allergie_date_debut AS date_debut,
       utilisateur_id_creation
FROM
     tb_ref_allergies
WHERE
      allergie_code LIKE ? AND 
      allergie_date_fin IS NULL
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        return $a->fetch();
    }

    private function fermer($code, $date_fin, $user) {
        $a = $this->getBdd()->prepare("UPDATE tb_ref_allergies  SET allergie_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE allergie_code = ? AND allergie_date_fin IS NULL");
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

    private function ajouter($code, $libelle, $user){
        if(!$code) {
            $nb_allergies = count($this->lister());
            $code = str_pad(intval($nb_allergies + 1), 4,'0',STR_PAD_LEFT);
        }
        $a = $this->getBdd()->prepare("INSERT INTO tb_ref_allergies(allergie_code, allergie_libelle, allergie_date_debut, utilisateur_id_creation)
        VALUES(:allergie_code, :allergie_libelle, :allergie_date_debut, :utilisateur_id_creation) 
        ");
        $a->execute(array(
            'allergie_code' => $code,
            'allergie_libelle' => $libelle,
            'allergie_date_debut' => date('Y-m-d H:i:s',time()),
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

    public function lister() {
        $query = "
SELECT 
       A.allergie_code AS code, 
       A.allergie_libelle AS libelle, 
       A.allergie_date_debut AS date_debut, 
       A.date_creation, 
       A.utilisateur_id_creation
FROM 
     tb_ref_allergies A
WHERE 
      A.allergie_date_fin IS NULL
ORDER BY A.allergie_libelle
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array());
        return $a->fetchAll();
    }

    public function lister_historique($code) {
        $query = "
SELECT 
       A.allergie_code AS code, 
       A.allergie_libelle AS libelle, 
       B.utilisateur_nom AS nom,
       B.utilisateur_prenoms AS prenoms,
       A.allergie_date_debut AS date_debut, 
       A.allergie_date_fin AS date_fin, 
       A.date_creation, 
       A.utilisateur_id_creation
FROM 
     tb_ref_allergies A JOIN tb_utilisateurs B 
         ON 
             A.utilisateur_id_creation = B.utilisateur_id AND A.allergie_code LIKE ?
ORDER BY 
         A.date_creation DESC";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array('%'.$code.'%'));
        return $a->fetchAll();
    }

}