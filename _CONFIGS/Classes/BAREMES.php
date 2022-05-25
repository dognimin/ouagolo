<?php

namespace App;

class BAREMES extends BDD
{
    public function lister() {
        $a = $this->getBdd()->prepare("
SELECT 
       bareme_code AS code, 
       bareme_libelle AS libelle,
       bareme_description AS description,
       bareme_date_debut AS date_debut,
       bareme_date_fin AS date_fin,
       date_creation,
       utilisateur_id_creation,
       date_edition,
       utilisateur_id_edition 
FROM 
     tb_organismes_baremes 
WHERE 
      bareme_date_fin IS NULL");
        $a->execute(array());
        return $a->fetchAll();
    }

    public function trouver($code) {
        $a = $this->getBdd()->prepare("
SELECT 
       bareme_code AS code, 
       bareme_libelle AS libelle,
       bareme_description AS description,
       bareme_date_debut AS date_debut,
       bareme_date_fin AS date_fin,
       date_creation,
       utilisateur_id_creation,
       date_edition,
       utilisateur_id_edition 
FROM 
     tb_organismes_baremes 
WHERE 
      bareme_code = ? 
  AND bareme_date_fin IS NULL");
        $a->execute(array($code));
        return $a->fetch();
    }

    private function ajouter($code, $libelle, $description, $user) {
        if(!$code) {
            $baremes = $this->lister();
            $nb_baremes = count($baremes);

            $code = 'BRM_'.str_pad((int)($nb_baremes + 1), 6, '0', STR_PAD_LEFT);
        }
        $a = $this->getBdd()->prepare("INSERT INTO tb_organismes_baremes(bareme_code, bareme_libelle, bareme_description, bareme_date_debut, utilisateur_id_creation)
        VALUES(:bareme_code, :bareme_libelle, :bareme_description, :bareme_date_debut, :utilisateur_id_creation)");
        $a->execute(array(
            'bareme_code' => $code,
            'bareme_libelle' => $libelle,
            'bareme_description' => $description,
            'bareme_date_debut' => date('Y-m-d', time()),
            'utilisateur_id_creation' => $user
        ));
        if($a->errorCode() == "00000"){
            return array(
                "success" => true,
                "code" => $code,
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
        $a = $this->getBdd()->prepare("UPDATE tb_organismes_baremes SET bareme_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE bareme_code = ? AND bareme_date_fin IS NULL");
        $a->execute(array($date_fin, date('Y-m-d H:i:s', time()), $user, $code));
        if($a->errorCode() == "00000"){
            return array(
                "success" => true,
                "code" => $code,
                "message" => 'Enregistrement effectué avec succès'
            );
        }else{
            return array(
                "success" => false,
                "message" => $a->errorInfo()
            );
        }
    }

    public function editer($code, $libelle, $description, $user) {
        $bareme = $this->trouver($code);
        if($bareme) {
            $date_fin = date('Y-m-d',strtotime('-1 day',time()));
            if(strtotime($date_fin) > strtotime($bareme['date_debut'])) {
                $fermer = $this->fermer($code, $date_fin, $user);
                if($fermer['success'] == true) {
                    return $this->ajouter($code, $libelle, $description, $user);

                }else {
                    return $fermer;
                }
            }else {
                return array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le ".date('d/m/Y',strtotime('+2 day',strtotime($bareme['date_debut'])))
                );
            }
        }else {
            return $this->ajouter($code, $libelle, $description, $user);
        }
    }
}