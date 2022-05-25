<?php

namespace App;

class PRODUITS extends BDD
{
    public function lister($code_organisme) {
        $a = $this->getBdd()->prepare("
SELECT 
       A.organisme_code AS code_organisme, 
       A.produit_code AS code, 
       A.produit_libelle AS libelle, 
       A.produit_description AS description, 
       A.panier_soins_code AS code_panier_soins,
       B.panier_soins_libelle AS libelle_panier_soins,
       A.reseau_soins_code AS code_reseau_soins,
       C.reseau_soins_libelle AS libelle_reseau_soins,
       A.produit_date_debut AS date_debut
FROM 
     tb_organismes_produits A 
         JOIN tb_paniers_soins B 
             ON A.panier_soins_code = B.panier_soins_code 
         JOIN tb_reseaux_soins C 
             ON A.reseau_soins_code = C.reseau_soins_code
                    AND A.organisme_code LIKE ? 
                    AND A.produit_date_fin IS NULL 
                    AND B.panier_soins_date_fin IS NULL 
                    AND C.reseau_soins_date_fin IS NULL");
        $a->execute(array('%'.$code_organisme.'%'));
        return $a->fetchAll();
    }

    public function trouver($code_organisme, $code) {
        $a = $this->getBdd()->prepare("
SELECT 
       A.organisme_code AS code_organisme, 
       A.produit_code AS code, 
       A.produit_libelle AS libelle, 
       A.produit_description AS description, 
       A.panier_soins_code AS code_panier_soins,
       B.panier_soins_libelle AS libelle_panier_soins,
       A.reseau_soins_code AS code_reseau_soins,
       C.reseau_soins_libelle AS libelle_reseau_soins,
       A.produit_date_debut AS date_debut
FROM 
     tb_organismes_produits A 
         JOIN tb_paniers_soins B 
             ON A.panier_soins_code = B.panier_soins_code 
         JOIN tb_reseaux_soins C 
             ON A.reseau_soins_code = C.reseau_soins_code
                    AND A.organisme_code LIKE ? 
                    AND A.produit_code = ? 
                    AND A.produit_date_fin IS NULL 
                    AND B.panier_soins_date_fin IS NULL 
                    AND C.reseau_soins_date_fin IS NULL");
        $a->execute(array('%'.$code_organisme.'%', $code));
        return $a->fetch();
    }

    private function ajouter($code_organisme, $code, $libelle, $description, $code_panier_soins, $code_reseau_soins, $user) {
        if(!$code) {
            $produits = $this->lister(null);
            $nb_produits = count($produits);

            $code = 'P_'.str_pad((int)($nb_produits + 1), 4, '0', STR_PAD_LEFT);
        }
        $a = $this->getBdd()->prepare("INSERT INTO tb_organismes_produits(organisme_code, produit_code, produit_libelle, produit_description, panier_soins_code, reseau_soins_code, produit_date_debut, utilisateur_id_creation)
        VALUES(:organisme_code, :produit_code, :produit_libelle, :produit_description, :panier_soins_code, :reseau_soins_code, :produit_date_debut, :utilisateur_id_creation)");
        $a->execute(array(
            'organisme_code' => $code_organisme,
            'produit_code' => $code,
            'produit_libelle' => $libelle,
            'produit_description' => $description,
            'panier_soins_code' => $code_panier_soins,
            'reseau_soins_code' => $code_reseau_soins,
            'produit_date_debut' => date('Y-m-d', time()),
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

    private function fermer($code_organisme, $code, $date_fin, $user) {
        $a = $this->getBdd()->prepare("UPDATE tb_organismes_produits SET produit_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE produit_code = ? AND organisme_code = ? AND produit_date_fin IS NULL");
        $a->execute(array($date_fin, date('Y-m-d H:i:s', time()), $user, $code, $code_organisme));
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

    public function editer($code_organisme, $code, $libelle, $description, $code_panier_soins, $code_reseau_soins, $user) {
        $produit = $this->trouver($code_organisme, $code);
        if($produit) {
            $date_fin = date('Y-m-d',strtotime('-1 day',time()));
            if(strtotime($date_fin) > strtotime($produit['date_debut'])) {
                $fermer = $this->fermer($code_organisme, $code, $date_fin, $user);
                if($fermer['success'] == true) {
                    return $this->ajouter($code_organisme, $code, $libelle, $description, $code_panier_soins, $code_reseau_soins, $user);

                }else {
                    return $fermer;
                }
            }else {
                return array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le ".date('d/m/Y',strtotime('+2 day',strtotime($produit['date_debut'])))
                );
            }
        }else {
            return $this->ajouter($code_organisme, $code, $libelle, $description, $code_panier_soins, $code_reseau_soins, $user);
        }
    }

    public function lister_contrats($code) {
        $a = $this->getBdd()->prepare("
SELECT 
       A.produit_code AS code,
       B.police_id AS id_police,
       A.police_college_code AS code_college,
       B.police_college_libelle AS libelle_college,
       C.collectivite_code AS code_collectivite,
       D.collectivite_raison_sociale AS raison_sociale
FROM 
     tb_organismes_colleges_produits A 
         JOIN tb_organismes_polices_colleges B 
             ON A.police_college_code = B.police_college_code 
         JOIN tb_organismes_polices C 
             ON B.police_id = C.police_id
         JOIN tb_ref_collectivites D 
             ON D.collectivite_code = C.collectivite_code
                    AND A.college_produit_date_fin IS NULL 
                    AND D.collectivite_date_fin IS NULL
                    AND A.produit_code = ? 
ORDER BY 
         A.date_creation DESC");
        $a->execute(array($code));
        return $a->fetchAll();
    }
}