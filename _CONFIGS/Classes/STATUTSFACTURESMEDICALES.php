<?php
namespace App;

class STATUTSFACTURESMEDICALES extends BDD
{
    private function ajouter($code, $libelle, $user){
        $a = $this->getBdd()->prepare("INSERT INTO tb_factures_medicales_statuts(statut_code,statut_libelle,statut_date_debut,utilisateur_id_creation)
        VALUES(:statut_code,:statut_libelle,:statut_date_debut,:utilisateur_id_creation) 
        ");
        $a->execute(array(
            'statut_code' => $code,
            'statut_libelle' => $libelle,
            'statut_date_debut' => date('Y-m-d H:i:s',time()),
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
        $a = $this->getBdd()->prepare("UPDATE tb_factures_medicales_statuts  SET statut_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE statut_code = ? AND statut_date_fin IS NULL");
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
       statut_code AS code,
       statut_libelle AS libelle,
       statut_date_debut AS date_debut,
       utilisateur_id_creation
FROM
     tb_factures_medicales_statuts
WHERE
      statut_code LIKE ? AND 
      statut_date_fin IS NULL
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        return $a->fetch();
    }

    public function lister() {
        $query = "
SELECT 
       A.statut_code AS code, 
       A.statut_libelle AS libelle, 
       A.statut_date_debut AS date_debut, 
       A.date_creation, 
       A.utilisateur_id_creation
FROM 
     tb_factures_medicales_statuts A
WHERE 
      A.statut_date_fin IS NULL
ORDER BY A.statut_libelle
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array());
        return $a->fetchAll();
    }

    public function editer($code, $libelle, $user){
        $statut = $this->trouver($code);
        if($statut) {
            $date_fin = date('Y-m-d',strtotime('-1 day',time()));
            if(strtotime($date_fin) > strtotime($statut['date_debut'])) {
                $edition = $this->fermer($statut['code'],$date_fin,$user);
                if($edition['success'] == true) {
                    $json = $this->ajouter($code, $libelle, $user);
                }else {
                    $json = $edition;
                }
            }else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le ".date('d/m/Y',strtotime('+2 day',strtotime($statut['date_debut'])))
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
       A.statut_code AS code, 
       A.statut_libelle AS libelle, 
       B.utilisateur_nom AS nom,
       B.utilisateur_prenoms AS prenoms, 
       A.statut_date_debut AS date_debut, 
       A.statut_date_fin AS date_fin, 
       A.date_creation, 
       A.utilisateur_id_creation
FROM 
     tb_factures_medicales_statuts A JOIN tb_utilisateurs B 
         ON 
             A.utilisateur_id_creation = B.utilisateur_id AND A.statut_code LIKE ?
ORDER BY 
         A.date_creation DESC
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array('%'.$code.'%'));
        return $a->fetchAll();
    }
}