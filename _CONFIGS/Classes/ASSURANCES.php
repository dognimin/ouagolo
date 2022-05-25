<?php
namespace App;

class ASSURANCES extends BDD
{

    private function ajouter($code, $libelle, $user){
        $a = $this->getBdd()->prepare("INSERT INTO tb_ref_assurances(assurance_code, assurance_libelle, assurance_date_debut, utilisateur_id_creation)
        VALUES(:assurance_code, :assurance_libelle, :assurance_date_debut, :utilisateur_id_creation) 
        ");
        $a->execute(array(
            'assurance_code' => $code,
            'assurance_libelle' => $libelle,
            'assurance_date_debut' => date('Y-m-d H:i:s',time()),
            'utilisateur_id_creation' => $user
        ));
        if($a->errorCode() == "00000"){
            return array(
                "success" => true,
                "message" => 'Enregistrement effectué avec succès'
            );
        }
        else{
            return array(
                "success" => false,
                "message" => $a->errorInfo()
            );
        }
    }

    private function fermer($code, $date_fin, $user) {
        $a = $this->getBdd()->prepare("UPDATE tb_ref_assurances  SET assurance_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE assurance_code = ? AND assurance_date_fin IS NULL");
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
       assurance_code AS code,
      assurance_libelle AS libelle,
       assurance_date_debut AS date_debut,
       utilisateur_id_creation
FROM
     tb_ref_assurances
WHERE
      assurance_code LIKE ? AND 
      assurance_date_fin IS NULL
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        return $a->fetch();
    }
    public function lister() {
        $query = "
SELECT 
       A.assurance_code AS code, 
       A.assurance_libelle AS libelle, 
       A.assurance_date_debut AS date_debut, 
       A.date_creation, 
       A.utilisateur_id_creation
FROM 
     tb_ref_assurances A
WHERE 
      A.assurance_date_fin IS NULL
ORDER BY A.assurance_libelle
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array());
        return $a->fetchAll();
    }
    public function editer($code, $libelle, $user){
        $assurance = $this->trouver($code);
        if($assurance) {
            $date_fin = date('Y-m-d',strtotime('-1 day',time()));
            if(strtotime($date_fin) > strtotime($assurance['date_debut'])) {
                $edition = $this->fermer($assurance['code'],$date_fin,$user);
                if($edition['success'] == true) {
                    $json = $this->ajouter($code, $libelle, $user);
                }else {
                    $json = $edition;
                }
            }else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le ".date('d/m/Y',strtotime('+2 day',strtotime($assurance['date_debut'])))
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
       A.assurance_code AS code, 
       A.assurance_libelle AS libelle, 
       B.utilisateur_nom AS nom,
       B.utilisateur_prenoms AS prenoms,
       A.assurance_date_debut AS date_debut, 
       A.assurance_date_fin AS date_fin, 
       A.date_creation, 
       A.utilisateur_id_creation
FROM 
     tb_ref_assurances A JOIN tb_utilisateurs B 
         ON 
             A.utilisateur_id_creation = B.utilisateur_id AND A.assurance_code LIKE ?
ORDER BY 
         A.date_creation DESC";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array('%'.$code.'%'));
        return $a->fetchAll();
    }

}