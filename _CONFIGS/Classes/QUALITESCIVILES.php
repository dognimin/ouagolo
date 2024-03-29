<?php
namespace App;

class QUALITESCIVILES extends  BDD
{
    public function lister()
    {
        $query = "
SELECT 
       qualite_civile_code AS code,
       qualite_civile_libelle AS libelle,
       qualite_civile_date_debut AS date_debut,
       utilisateur_id_creation
FROM
     tb_ref_qualites_civiles
WHERE
      qualite_civile_date_fin IS NULL
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array());
        $json = $a->fetchAll();
        return $json;
    }

    public function editer($code, $libelle, $user){
        $qualitecivilite = $this->trouver($code);
        if($qualitecivilite) {

            $date_fin = date('Y-m-d',strtotime('-1 day',time()));
            if(strtotime($date_fin) > strtotime($qualitecivilite['date_debut'])) {
                $edition = $this->fermer($qualitecivilite['code'],$date_fin,$user);
                if($edition['success'] == true) {
                    $json = $this->ajouter($code, $libelle, $user);

                }else {
                    $json = $edition;
                }
            }else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le ".date('d/m/Y',strtotime('+2 day',strtotime($qualitecivilite['date_debut'])))
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
       qualite_civile_code AS code,
       qualite_civile_libelle AS libelle,
       qualite_civile_date_debut AS date_debut,
       utilisateur_id_creation
FROM
     tb_ref_qualites_civiles
WHERE
      qualite_civile_code LIKE ? AND 
      qualite_civile_date_fin IS NULL
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        return $a->fetch();
    }

    private function fermer($code, $date_fin, $user) {
        $a = $this->getBdd()->prepare("UPDATE tb_ref_qualites_civiles  SET qualite_civile_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE qualite_civile_code = ? AND qualite_civile_date_fin IS NULL");
        $a->execute(array($date_fin,date('Y-m-d H:i:s',time()),$user,$code));
        if ($a->errorCode() == "00000"){
            return array(
                "success" => true,
                "messages" => 'Enregistrement effectué avec succès.',

            );
        }else{
            return array(
                "success" => false,
                "messages" => $a->errorInfo()
            );
        }
    }

    private function ajouter($code, $libelle, $user){
        $a = $this->getBdd()->prepare("INSERT INTO tb_ref_qualites_civiles(qualite_civile_code, qualite_civile_libelle, qualite_civile_date_debut, utilisateur_id_creation)
        VALUES(:qualite_civile_code, :qualite_civile_libelle, :qualite_civile_date_debut, :utilisateur_id_creation) 
        ");
        $a->execute(array(
            'qualite_civile_code' => $code,
            'qualite_civile_libelle' => $libelle,
            'qualite_civile_date_debut' => date('Y-m-d H:i:s',time()),
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

    public function lister_historique($code)
    {
        $query = "
SELECT 
       A.qualite_civile_code AS code,
       A.qualite_civile_libelle AS libelle,
       A.qualite_civile_date_debut AS date_debut,
       A.qualite_civile_date_fin AS date_fin,
       A.utilisateur_id_creation,
       A.date_creation,
        B.utilisateur_nom AS nom,
       B.utilisateur_prenoms AS prenoms
FROM
     tb_ref_qualites_civiles A JOIN tb_utilisateurs B 
         ON 
             A.utilisateur_id_creation = B.utilisateur_id AND A.qualite_civile_code LIKE ?
ORDER BY 
         A.date_creation DESC
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array('%'.$code.'%'));
        $json = $a->fetchAll();
        return $json;
    }

}