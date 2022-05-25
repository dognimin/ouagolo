<?php
namespace App;

class SPECIALITESMEDICALES extends BDD
{
    private function ajouter($code, $libelle, $user){
        if(!$code) {
            $specialites_medicales = $this->lister();
            $nb_specialites_medicales = count($specialites_medicales);
            $code = 'SM'.str_pad(($nb_specialites_medicales + 1),2,'0',STR_PAD_LEFT);
        }
        $a = $this->getBdd()->prepare("INSERT INTO tb_ref_specialites_medicales(specialite_medicale_code,specialite_medicale_libelle,specialite_medicale_date_debut,utilisateur_id_creation)
        VALUES(:specialite_medicale_code,:specialite_medicale_libelle,:specialite_medicale_date_debut,:utilisateur_id_creation) 
        ");
        $a->execute(array(
            'specialite_medicale_code' => $code,
            'specialite_medicale_libelle' => $libelle,
            'specialite_medicale_date_debut' => date('Y-m-d H:i:s',time()),
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
        $a = $this->getBdd()->prepare("UPDATE tb_ref_specialites_medicales SET specialite_medicale_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE specialite_medicale_code = ? AND specialite_medicale_date_fin IS NULL");
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
       specialite_medicale_code AS code,
       specialite_medicale_libelle AS libelle,
       specialite_medicale_date_debut AS date_debut,
       utilisateur_id_creation
FROM
     tb_ref_specialites_medicales
WHERE
      specialite_medicale_code LIKE ? AND 
      specialite_medicale_date_fin IS NULL
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        return $a->fetch();
    }

    public function lister() {
        $query = "
SELECT 
       A.specialite_medicale_code AS code, 
       A.specialite_medicale_libelle AS libelle, 
       A.specialite_medicale_date_debut AS date_debut, 
       A.date_creation, 
       A.utilisateur_id_creation
FROM 
     tb_ref_specialites_medicales A
WHERE 
      A.specialite_medicale_date_fin IS NULL
ORDER BY A.specialite_medicale_libelle
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array());
        return $a->fetchAll();
    }

    public function editer($code, $libelle, $user){
        $specialite_medicale = $this->trouver($code);
        if($specialite_medicale) {
            $date_fin = date('Y-m-d',strtotime('-1 day',time()));
            if(strtotime($date_fin) > strtotime($specialite_medicale['date_debut'])) {
                $edition = $this->fermer($specialite_medicale['code'],$date_fin,$user);
                if($edition['success'] == true) {
                    $json = $this->ajouter($code, $libelle, $user);
                }else {
                    $json = $edition;
                }
            }else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le ".date('d/m/Y',strtotime('+2 day',strtotime($specialite_medicale['date_debut'])))
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
       A.specialite_medicale_code AS code, 
       A.specialite_medicale_libelle AS libelle, 
       A.specialite_medicale_date_debut AS date_debut, 
       A.specialite_medicale_date_fin AS date_fin, 
       A.date_creation, 
       A.utilisateur_id_creation       
FROM 
     tb_ref_specialites_medicales A 
WHERE 
      A.specialite_medicale_code LIKE ?
ORDER BY 
         A.date_creation DESC
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array('%'.$code.'%'));
        $json = $a->fetchAll();
        return $json;
    }




}