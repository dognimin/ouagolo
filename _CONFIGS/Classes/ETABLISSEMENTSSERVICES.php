<?php
namespace App;

class ETABLISSEMENTSSERVICES extends BDD
{

    public function lister() {
        $query = "
SELECT 
       A.etablissement_service_code AS code, 
       A.etablissement_service_libelle AS libelle, 
       A.etablissement_service_date_debut AS date_debut, 
       A.date_creation, 
       A.utilisateur_id_creation
FROM 
     tb_ref_etablissements_services A
WHERE 
      A.etablissement_service_date_fin IS NULL
ORDER BY A.etablissement_service_libelle
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array());
        return $a->fetchAll();
    }

    public function editer($code, $libelle, $user){
        $service = $this->trouver($code);
        if($service) {

            $date_fin = date('Y-m-d',strtotime('-1 day',time()));
            if(strtotime($date_fin) > strtotime($service['date_debut'])) {
                $edition = $this->fermer($service['code'],$date_fin,$user);
                if($edition['success'] == true) {
                    $json = $this->ajouter($code, $libelle, $user);
                }else {
                    $json = $edition;
                }
            }else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le ".date('d/m/Y',strtotime('+2 day',strtotime($service['date_debut'])))
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
       etablissement_service_code AS code,
       etablissement_service_libelle AS libelle,
       etablissement_service_date_debut AS date_debut,
       utilisateur_id_creation
FROM
     tb_ref_etablissements_services
WHERE
      etablissement_service_code LIKE ? AND 
      etablissement_service_date_fin IS NULL
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        return $a->fetch();
    }

    private function fermer($code, $date_fin, $user) {
        $a = $this->getBdd()->prepare("
UPDATE tb_ref_etablissements_services  SET etablissement_service_date_fin = ?, date_edition = ?, utilisation_id_edition = ? WHERE etablissement_service_code = ? AND etablissement_service_date_fin IS NULL");
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
        $a = $this->getBdd()->prepare("INSERT INTO tb_ref_etablissements_services(etablissement_service_code,etablissement_service_libelle, etablissement_service_date_debut, utilisateur_id_creation)
        VALUES(:etablissement_service_code, :etablissement_service_libelle, :etablissement_service_date_debut, :utilisateur_id_creation) 
        ");
        $a->execute(array(
            'etablissement_service_code' => $code,
            'etablissement_service_libelle' => $libelle,
            'etablissement_service_date_debut' => date('Y-m-d H:i:s',time()),
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
       A.etablissement_service_code AS code, 
       A.etablissement_service_libelle AS libelle, 
       B.utilisateur_nom AS nom,
       B.utilisateur_prenoms AS prenoms,
       A.etablissement_service_date_debut AS date_debut, 
       A.etablissement_service_date_fin AS date_fin, 
       A.date_creation, 
       A.utilisateur_id_creation
FROM 
     tb_ref_etablissements_services A JOIN tb_utilisateurs B 
         ON 
             A.utilisateur_id_creation = B.utilisateur_id AND A.etablissement_service_code LIKE ?
ORDER BY 
         A.date_creation DESC";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        return $a->fetchAll();
    }

}