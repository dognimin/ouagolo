<?php
namespace App;

class TYPESPERSONNES extends BDD
{

    private function ajouter($code, $libelle, $user){
        $a = $this->getBdd()->prepare("INSERT INTO tb_ref_types_personnes(type_personne_code,type_personne_libelle,type_personne_date_debut, utilisateur_id_creation)
        VALUES(:type_personne_code, :type_personne_libelle, :type_personne_date_debut, :utilisateur_id_creation) 
        ");
        $a->execute(array(
            'type_personne_code' => $code,
            'type_personne_libelle' => $libelle,
            'type_personne_date_debut' => date('Y-m-d H:i:s',time()),
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
        $a = $this->getBdd()->prepare("UPDATE tb_ref_types_personnes  SET type_personne_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE type_personne_code = ? AND type_personne_date_fin IS NULL");
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
        type_personne_code AS code,
       type_personne_libelle AS libelle,
       type_personne_date_debut AS date_debut,
       utilisateur_id_creation
FROM
     tb_ref_types_personnes
WHERE
      type_personne_code LIKE ? AND 
      type_personne_date_fin IS NULL
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        return $a->fetch();
    }
    public function lister() {
        $query = "
SELECT 
       A.type_personne_code AS code, 
       A.type_personne_libelle AS libelle, 
       A.type_personne_date_debut AS date_debut, 
       A.date_creation, 
       A.utilisateur_id_creation
FROM 
     tb_ref_types_personnes A
WHERE 
      A.type_personne_date_fin IS NULL
ORDER BY A.type_personne_libelle
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array());
        return $a->fetchAll();
    }
    public function editer($code, $libelle, $user){
        $typepersonne = $this->trouver($code);
        if($typepersonne) {
            $date_fin = date('Y-m-d',strtotime('-1 day',time()));
            if(strtotime($date_fin) > strtotime($typepersonne['date_debut'])) {
                $edition = $this->fermer($typepersonne['code'],$date_fin,$user);
                if($edition['success'] == true) {
                    $json = $this->ajouter($code, $libelle, $user);
                }else {
                    $json = $edition;
                }
            }else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le ".date('d/m/Y',strtotime('+2 day',strtotime($typepersonne['date_debut'])))
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
       A.type_personne_code AS code, 
       A.type_personne_libelle AS libelle, 
       B.utilisateur_nom AS nom,
       B.utilisateur_prenoms AS prenoms,
       A.type_personne_date_debut AS date_debut, 
       A.type_personne_date_fin AS date_fin, 
       A.date_creation, 
       A.utilisateur_id_creation
FROM 
     tb_ref_types_personnes A JOIN tb_utilisateurs B 
         ON 
             A.utilisateur_id_creation = B.utilisateur_id AND A.type_personne_code LIKE ?
ORDER BY 
         A.date_creation DESC";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array('%'.$code.'%'));
        return $a->fetchAll();
    }

}