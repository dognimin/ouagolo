<?php
namespace App;

class DEVISESMONETAIRES extends  BDD
{
    private function ajouter($code, $libelle, $user){
        $a = $this->getBdd()->prepare("INSERT INTO tb_ref_monnaies(monnaie_code,monnaie_libelle,monnaie_date_debut, utilisateur_id_creation)
        VALUES(:monnaie_code, :monnaie_libelle, :monnaie_date_debut, :utilisateur_id_creation) 
        ");
        $a->execute(array(
            'monnaie_code' => $code,
            'monnaie_libelle' => $libelle,
            'monnaie_date_debut' => date('Y-m-d H:i:s',time()),
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
        $a = $this->getBdd()->prepare("UPDATE tb_ref_monnaies SET monnaie_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE monnaie_code = ? AND monnaie_date_fin IS NULL");
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
       monnaie_code AS code,
       monnaie_libelle AS libelle,
       monnaie_date_debut AS date_debut,
       utilisateur_id_creation
FROM
     tb_ref_monnaies
WHERE
      monnaie_code LIKE ? AND 
      monnaie_date_fin IS NULL
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        return $a->fetch();
    }

    public function lister()
    {
        $query = "
SELECT 
       monnaie_code AS code,
       monnaie_libelle AS libelle,
       monnaie_date_debut AS date_debut,
       utilisateur_id_creation
FROM
     tb_ref_monnaies
WHERE
      monnaie_date_fin IS NULL
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array());
        $json = $a->fetchAll();
        return $json;
    }

    public function editer($code, $libelle, $user){
        $devise = $this->trouver($code);
        if($devise) {
            $date_fin = date('Y-m-d',strtotime('-1 day',time()));
            if(strtotime($date_fin) > strtotime($devise['date_debut'])) {
                $edition = $this->fermer($devise['code'],$date_fin,$user);
                if($edition['success'] == true) {
                    $json = $this->ajouter($code, $libelle, $user);
                }else {
                    $json = $edition;
                }
            }else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le ".date('d/m/Y',strtotime('+2 day',strtotime($devise['date_debut'])))
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
       A.monnaie_code AS code,
       A.monnaie_libelle AS libelle,
       A.monnaie_date_debut AS date_debut,
       A.monnaie_date_fin AS date_fin,
       A.utilisateur_id_creation,
       A.date_creation,
       B.utilisateur_nom AS nom,
       B.utilisateur_prenoms AS prenoms
FROM
     tb_ref_monnaies A JOIN tb_utilisateurs B 
         ON 
             A.utilisateur_id_creation = B.utilisateur_id AND A.monnaie_code LIKE ?
ORDER BY 
         A.date_creation DESC
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array('%'.$code.'%'));
        $json = $a->fetchAll();
        return $json;
    }

}