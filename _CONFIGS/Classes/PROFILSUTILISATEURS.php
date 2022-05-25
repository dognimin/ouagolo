<?php
namespace App;

class PROFILSUTILISATEURS extends  BDD
{
    private function ajouter($code, $libelle, $user){
        $a = $this->getBdd()->prepare("INSERT INTO tb_ref_profils_utilisateurs(profil_utilisateur_code, profil_utilisateur_libelle, profil_utilisateur_date_debut, utilisateur_id_creation)
        VALUES(:profil_utilisateur_code, :profil_utilisateur_libelle, :profil_utilisateur_date_debut, :utilisateur_id_creation) 
        ");
        $a->execute(array(
            'profil_utilisateur_code' => $code,
            'profil_utilisateur_libelle' => $libelle,
            'profil_utilisateur_date_debut' => date('Y-m-d H:i:s',time()),
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
        $a = $this->getBdd()->prepare("UPDATE tb_ref_profils_utilisateurs  SET profil_utilisateur_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE profil_utilisateur_code = ? AND profil_utilisateur_date_fin IS NULL");
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
       profil_utilisateur_code AS code,
       profil_utilisateur_libelle AS libelle,
       profil_utilisateur_date_debut AS date_debut,
       utilisateur_id_creation
FROM
     tb_ref_profils_utilisateurs
WHERE
      profil_utilisateur_code LIKE ? AND 
      profil_utilisateur_date_fin IS NULL
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        return $a->fetch();
    }

    public function lister()
    {
        $query = "
SELECT 
       profil_utilisateur_code AS code,
       profil_utilisateur_libelle AS libelle,
       profil_utilisateur_date_debut AS date_debut,
       utilisateur_id_creation
FROM
     tb_ref_profils_utilisateurs
WHERE
      profil_utilisateur_date_fin IS NULL
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array());
        $json = $a->fetchAll();
        return $json;
    }

    public function editer($code, $libelle, $user){
        $profil = $this->trouver($code);
        if($profil) {
            $date_fin = date('Y-m-d',strtotime('-1 day',time()));
            if(strtotime($date_fin) > strtotime($profil['date_debut'])) {
                $edition = $this->fermer($profil['code'],$date_fin,$user);
                if($edition['success'] == true) {
                    $json = $this->ajouter($code, $libelle, $user);
                }else {
                    $json = $edition;
                }
            }else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le ".date('d/m/Y',strtotime('+2 day',strtotime($profil['date_debut'])))
                );
            }
        }else {
            $json = $this->ajouter($code, $libelle, $user);
        }
        return $json;
    }

    public function lister_historique($code)
    {
        $query = "
SELECT 
       A.profil_utilisateur_code AS code,
       A.profil_utilisateur_libelle AS libelle,
       B.utilisateur_nom AS nom,
       B.utilisateur_prenoms AS prenoms,
       A.profil_utilisateur_date_debut AS date_debut,
       A.profil_utilisateur_date_fin AS date_fin,
       A.utilisateur_id_creation,
       A.date_creation
FROM
     tb_ref_profils_utilisateurs A JOIN tb_utilisateurs B 
      ON 
      A.utilisateur_id_creation = B.utilisateur_id AND A.profil_utilisateur_code LIKE ?
ORDER BY 
         A.date_creation DESC
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        $json = $a->fetchAll();
        return $json;
    }

}