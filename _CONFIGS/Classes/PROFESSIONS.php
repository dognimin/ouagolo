<?php
namespace App;

class PROFESSIONS extends  BDD
{
    public function editer($code, $libelle, $user){
        $profession = $this->trouver($code);
        if($profession) {
            $date_fin = date('Y-m-d',strtotime('-1 day',time()));
            if(strtotime($date_fin) > strtotime($profession['date_debut'])) {
                $edition = $this->fermer($profession['code'],$date_fin,$user);
                if($edition['success'] == true) {
                    $json = $this->ajouter($libelle, $user);
                }else {
                    $json = $edition;
                }
            }else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le ".date('d/m/Y',strtotime('+2 day',strtotime($profession['date_debut'])))
                );
            }
        }else {
            $json = $this->ajouter($libelle, $user);
        }
        return $json;
    }

    public function trouver($code){
        $query = "
SELECT 
       profession_code AS code,
       profession_libelle AS libelle,
       profession_date_debut AS date_debut,
       utilisateur_id_creation
FROM
     tb_ref_professions
WHERE
      profession_code LIKE ? AND 
      profession_date_fin IS NULL
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        return $a->fetch();
    }

    private function fermer($code, $date_fin, $user) {
        $a = $this->getBdd()->prepare("UPDATE tb_ref_professions  SET profession_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE profession_code = ? AND profession_date_fin IS NULL");
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

    private function ajouter($libelle, $user){
        $professions = $this->lister();
        $nb_professions = count($professions);
        $code = 'P'.str_pad(intval($nb_professions + 1), 3,'0',STR_PAD_LEFT);
        $a = $this->getBdd()->prepare("INSERT INTO tb_ref_professions(profession_code,profession_libelle,profession_date_debut, utilisateur_id_creation)
        VALUES(:profession_code, :profession_libelle, :profession_date_debut, :utilisateur_id_creation) 
        ");
        $a->execute(array(
            'profession_code' => $code,
            'profession_libelle' => $libelle,
            'profession_date_debut' => date('Y-m-d H:i:s',time()),
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

    public function lister()
    {
        $query = "
SELECT 
       profession_code AS code,
       profession_libelle AS libelle,
       profession_date_debut AS date_debut,
       utilisateur_id_creation
FROM
     tb_ref_professions
WHERE
      profession_date_fin IS NULL
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array());
        $json = $a->fetchAll();
        return $json;
    }

    public function lister_historique($code)
    {
        $query = "
SELECT 
       A.profession_code AS code,
       A.profession_libelle AS libelle,
       A.profession_date_debut AS date_debut,
       A.profession_date_fin AS date_fin,
       A.utilisateur_id_creation,
       A.date_creation,
       B.utilisateur_nom AS nom,
       B.utilisateur_prenoms AS prenoms
FROM
     tb_ref_professions A JOIN tb_utilisateurs B 
         ON 
             A.utilisateur_id_creation = B.utilisateur_id AND A.profession_code LIKE ?
ORDER BY 
         A.date_creation DESC
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array('%'.$code.'%'));
        $json = $a->fetchAll();
        return $json;
    }
}