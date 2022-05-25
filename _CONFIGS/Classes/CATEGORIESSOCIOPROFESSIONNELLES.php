<?php
namespace App;

class CATEGORIESSOCIOPROFESSIONNELLES extends  BDD
{
    private function ajouter($code, $libelle, $user){
        $a = $this->getBdd()->prepare("INSERT INTO tb_ref_categories_socio_professionnelles(categorie_socio_professionnelle_code, categorie_socio_professionnelle_libelle, categorie_socio_professionnelle_date_debut, utilisateur_id_creation)
        VALUES(:categorie_socio_professionnelle_code, :categorie_socio_professionnelle_libelle, :categorie_socio_professionnelle_date_debut, :utilisateur_id_creation) 
        ");
        $a->execute(array(
            'categorie_socio_professionnelle_code' => $code,
            'categorie_socio_professionnelle_libelle' => $libelle,
            'categorie_socio_professionnelle_date_debut' => date('Y-m-d H:i:s',time()),
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
        $a = $this->getBdd()->prepare("UPDATE tb_ref_categories_socio_professionnelles  SET categorie_socio_professionnelle_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE categorie_socio_professionnelle_code = ? AND categorie_socio_professionnelle_date_fin IS NULL");
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
       categorie_socio_professionnelle_code AS code,
       categorie_socio_professionnelle_libelle AS libelle,
       categorie_socio_professionnelle_date_debut AS date_debut,
       utilisateur_id_creation
FROM
     tb_ref_categories_socio_professionnelles
WHERE
      categorie_socio_professionnelle_code LIKE ? AND 
      categorie_socio_professionnelle_date_fin IS NULL
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        return $a->fetch();
    }

    public function lister()
    {
        $query = "
SELECT 
       categorie_socio_professionnelle_code AS code,
       categorie_socio_professionnelle_libelle AS libelle,
       categorie_socio_professionnelle_date_debut AS date_debut,
       utilisateur_id_creation
FROM
     tb_ref_categories_socio_professionnelles
WHERE
      categorie_socio_professionnelle_date_fin IS NULL
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array());
        $json = $a->fetchAll();
        return $json;
    }

    public function editer($code, $libelle, $user){
        $categories_socio_pro = $this->trouver($code);
        if($categories_socio_pro) {
            $date_fin = date('Y-m-d',strtotime('-1 day',time()));
            if(strtotime($date_fin) > strtotime($categories_socio_pro['date_debut'])) {
                $edition = $this->fermer($categories_socio_pro['code'],$date_fin,$user);
                if($edition['success'] == true) {
                    $json = $this->ajouter($code, $libelle, $user);
                }else {
                    $json = $edition;
                }
            }else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le ".date('d/m/Y',strtotime('+2 day',strtotime($categories_socio_pro['date_debut'])))
                );
            }
        }else {
            $json = $this->ajouter($code, $libelle, $user);
        }
        return $json;
    }

    public function lister_historique($code){
        $query = "
SELECT 
       A.categorie_socio_professionnelle_code AS code,
       A.categorie_socio_professionnelle_libelle AS libelle,
       A.categorie_socio_professionnelle_date_debut AS date_debut,
       A.categorie_socio_professionnelle_date_fin AS date_fin,
       A.utilisateur_id_creation,
       A.date_creation,
       B.utilisateur_nom AS nom,
       B.utilisateur_prenoms AS prenoms
       
FROM
     tb_ref_categories_socio_professionnelles A JOIN tb_utilisateurs B 
         ON 
             A.utilisateur_id_creation = B.utilisateur_id AND A.categorie_socio_professionnelle_code LIKE ?
ORDER BY 
         A.date_creation DESC
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        $json = $a->fetchAll();
        return $json;
    }
}