<?php
namespace App;

class PROFESSIONNELSDESANTE extends BDD
{
    public function lister() {
        $a = $this->getBdd()->prepare("
SELECT 
       B.professionnel_sante_code AS code,
       A.utilisateur_id AS id_user, 
       B.specialite_medicale_code AS code_specialite_medicale,
       D.specialite_medicale_libelle AS libelle_specialite_medicale,
       A.civilite_code AS code_civilite, 
       A.utilisateur_nom AS nom, 
       A.utilisateur_prenoms AS prenom,
       A.utilisateur_date_naissance AS date_naissance,
       A.sexe_code AS code_sexe,
       B.professionnel_date_debut AS date_debut
FROM 
     tb_utilisateurs A 
         JOIN tb_professionnels_sante B 
             ON A.utilisateur_id = B.utilisateur_id 
         JOIN tb_ref_specialites_medicales D 
             ON B.specialite_medicale_code = D.specialite_medicale_code
                    AND B.professionnel_date_fin IS NULL 
                    AND D.specialite_medicale_date_fin IS NULL ORDER BY A.utilisateur_nom");
        $a->execute(array());
        return $a->fetchAll();
    }

    public function trouver($code, $id_user) {
        $a = $this->getBdd()->prepare("
SELECT 
       B.professionnel_sante_code AS code,
       A.utilisateur_id AS id_user, 
       B.specialite_medicale_code AS code_specialite_medicale,
       D.specialite_medicale_libelle AS libelle_specialite_medicale,
       A.civilite_code AS code_civilite, 
       A.utilisateur_nom AS nom, 
       A.utilisateur_prenoms AS prenom,
       A.utilisateur_date_naissance AS date_naissance,
       A.sexe_code AS code_sexe,
       B.professionnel_date_debut AS date_debut
FROM 
     tb_utilisateurs A 
         JOIN tb_professionnels_sante B 
             ON A.utilisateur_id = B.utilisateur_id 
         JOIN tb_ref_specialites_medicales D 
             ON B.specialite_medicale_code = D.specialite_medicale_code
                    AND B.professionnel_date_fin IS NULL 
                    AND D.specialite_medicale_date_fin IS NULL 
                    AND B.professionnel_sante_code LIKE ? 
                    AND A.utilisateur_id LIKE ?");
        $a->execute(array('%'.$code.'%', '%'.$id_user.'%'));
        return $a->fetch();
    }

    private function ajouter($id_user, $code, $code_rgb, $code_specialite_medicale, $user) {
        if(!$code) {
            $professionnels = $this->lister();
            $nb_professionnels = count($professionnels);
            $code = 'PS'.str_pad(($nb_professionnels + 1),7,'0',STR_PAD_LEFT);
        }
        $a = $this->getBdd()->prepare("INSERT INTO tb_professionnels_sante(utilisateur_id, professionnel_sante_code, specialite_medicale_code, professionnel_sante_rgb_code, professionnel_date_debut, utilisateur_id_creation)
        VALUES(:utilisateur_id, :professionnel_sante_code, :specialite_medicale_code, :professionnel_sante_rgb_code, :professionnel_date_debut, :utilisateur_id_creation)");
        $a->execute(array(
            'utilisateur_id' => $id_user,
            'professionnel_sante_code' => $code,
            'specialite_medicale_code' => $code_specialite_medicale,
            'professionnel_sante_rgb_code' => $code_rgb,
            'professionnel_date_debut' => date('Y-m-d',time()),
            'utilisateur_id_creation' => $user
        ));
        if ($a->errorCode() == "00000") {
            return array(
                "success" => true,
                "code" => $code,
                "message" => 'Enregistrement effectué avec succès.'
            );
        } else {
            return array(
                "success" => false,
                "message" => $a->errorInfo()[2]
            );
        }
    }

    private function fermer($id_user, $date_fin, $user) {
        $a = $this->getBdd()->prepare("UPDATE tb_professionnels_sante SET professionnel_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE utilisateur_id = ? AND professionnel_date_fin IS NULL");
        $a->execute(array($date_fin, date('Y-m-d H:i:s',time()), $user, $id_user));
        if ($a->errorCode() == "00000") {
            return array(
                "success" => true,
                "message" => 'Enregistrement effectué avec succès.'
            );
        } else {
            return array(
                "success" => false,
                "message" => $a->errorInfo()[2]
            );
        }
    }

    public function editer($id_user, $code, $code_rgb, $code_specialite_medicale, $user) {
        $professionnel = $this->trouver($code,$id_user);
        if($professionnel) {
            $date_fin = date('Y-m-d',strtotime('-1 day',time()));
            if(strtotime($date_fin) > strtotime($professionnel['date_debut'])) {
                $edition = $this->fermer($professionnel['code'],$date_fin,$user);
                if($edition['success'] == true) {
                    $json = $this->ajouter($id_user, $code, $code_rgb, $code_specialite_medicale, $user);
                }else {
                    $json = $edition;
                }
            }else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le ".date('d/m/Y',strtotime('+2 day',strtotime($professionnel['date_debut'])))
                );
            }
        }else {
            $json = $this->ajouter($id_user, $code, $code_rgb, $code_specialite_medicale, $user);
        }
        return $json;
    }
}