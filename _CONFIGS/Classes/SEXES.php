<?php
namespace App;

class SEXES extends BDD
{

    public function lister() {
        $query = "
SELECT 
       A.sexe_code AS code, 
       A.sexe_libelle AS libelle, 
       A.sexe_date_debut AS date_debut, 
       A.date_creation, 
       A.utilisateur_id_creation
FROM 
     tb_ref_sexes A
WHERE 
      A.sexe_date_fin IS NULL
ORDER BY A.sexe_libelle
";
        $a = $this->getBdd()->prepare($query);
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

    public function trouver($code){
        $query = "
SELECT 
       sexe_code AS code,
       sexe_libelle AS libelle,
       sexe_date_debut AS date_debut,
       utilisateur_id_creation
FROM
     tb_ref_sexes
WHERE
      sexe_code LIKE ? AND 
      sexe_date_fin IS NULL
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        return $a->fetch();
    }

    private function fermer($code, $date_fin, $user) {
        $a = $this->getBdd()->prepare("UPDATE tb_ref_sexes  SET sexe_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE sexe_code = ? AND sexe_date_fin IS NULL");
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
        $a = $this->getBdd()->prepare("INSERT INTO tb_ref_sexes(sexe_code, sexe_libelle, sexe_date_debut, utilisateur_id_creation)
        VALUES(:sexe_code, :sexe_libelle, :sexe_date_debut, :utilisateur_id_creation) 
        ");
        $a->execute(array(
            'sexe_code' => $code,
            'sexe_libelle' => $libelle,
            'sexe_date_debut' => date('Y-m-d H:i:s',time()),
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

    public function lister_historique($code) {
        $query = "
SELECT 
       A.sexe_code AS code, 
       A.sexe_libelle AS libelle, 
       B.utilisateur_nom AS nom,
       B.utilisateur_prenoms AS prenoms,
       A.sexe_date_debut AS date_debut, 
       A.sexe_date_fin AS date_fin, 
       A.date_creation, 
       A.utilisateur_id_creation
FROM 
     tb_ref_sexes A JOIN tb_utilisateurs B 
         ON 
             A.utilisateur_id_creation = B.utilisateur_id AND A.sexe_code LIKE ?
ORDER BY 
         A.date_creation DESC";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array('%'.$code.'%'));
        return $a->fetchAll();
    }

}