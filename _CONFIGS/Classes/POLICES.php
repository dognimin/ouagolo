<?php
namespace App;

class POLICES extends BDD
{
    public function moteur_recherche($code_organisme, $id_police, $nom_police, $date_debut, $date_fin) {
        $a = $this->getBdd()->prepare("
SELECT 
       A.organisme_code AS code_organisme, 
       A.collectivite_code AS code_collectivite,
       B.collectivite_raison_sociale AS raison_sociale,
       A.police_id AS id_police, 
       A.police_nom AS nom, 
       A.police_description AS description, 
       A.police_date_debut AS date_debut, 
       A.police_date_fin AS date_fin, 
       A.date_creation, 
       A.utilisateur_id_creation, 
       A.date_edition, 
       A.utilisateur_id_edition 
FROM 
     tb_organismes_polices A 
         JOIN tb_ref_collectivites B 
             ON A.collectivite_code = B.collectivite_code 
                    AND A.organisme_code = ? 
                    AND A.police_id LIKE ? 
                    AND (A.police_nom LIKE ? OR B.collectivite_raison_sociale LIKE ?)
                    AND A.date_creation BETWEEN ? AND ?
ORDER BY 
         B.collectivite_raison_sociale,
         A.police_nom");
        $a->execute(array($code_organisme, '%'.$id_police.'%', '%'.$nom_police.'%', '%'.$nom_police.'%', $date_debut, $date_fin));
        return $a->fetchAll();
    }

    public function lister($code_organisme) {
        $a = $this->getBdd()->prepare("
SELECT 
       A.organisme_code AS code_organisme, 
       A.collectivite_code AS code_collectivite,
       B.collectivite_raison_sociale AS raison_sociale,
       A.police_id AS id_police, 
       A.police_nom AS nom, 
       A.police_description AS description, 
       A.police_date_debut AS date_debut, 
       A.police_date_fin AS date_fin, 
       A.date_creation, 
       A.utilisateur_id_creation, 
       A.date_edition, 
       A.utilisateur_id_edition 
FROM 
     tb_organismes_polices A 
         JOIN tb_ref_collectivites B 
             ON A.collectivite_code = B.collectivite_code 
                    AND A.organisme_code = ?
ORDER BY 
         B.collectivite_raison_sociale,
         A.police_nom");
        $a->execute(array($code_organisme));
        return $a->fetchAll();
    }

    public function trouver($code_organisme, $id_police) {
        $a = $this->getBdd()->prepare("
SELECT 
       A.organisme_code AS code_organisme, 
       A.collectivite_code AS code_collectivite,
       B.collectivite_raison_sociale AS raison_sociale,
       B.secteur_activite_code AS code_secteur_activite,
       A.police_id AS id_police, 
       A.police_nom AS nom, 
       A.police_description AS description, 
       A.police_date_debut AS date_debut, 
       A.police_date_fin AS date_fin, 
       A.date_creation, 
       A.utilisateur_id_creation, 
       A.date_edition, 
       A.utilisateur_id_edition 
FROM 
     tb_organismes_polices A 
         JOIN tb_ref_collectivites B 
             ON A.collectivite_code = B.collectivite_code 
                    AND A.organisme_code = ?
                    AND A.police_id = ?");
        $a->execute(array($code_organisme, $id_police));
        return $a->fetch();
    }

    private function ajouter($code_organisme, $code_collectivite, $nom, $description, $date_debut, $date_fin, $user) {
        $polices = $this->lister($code_organisme);
        $nb_polices = count($polices);
        $id_police = $code_organisme.date('Y', time()).str_pad(($nb_polices + 1), 8, '0', STR_PAD_LEFT);

        $a = $this->getBdd()->prepare("INSERT INTO tb_organismes_polices(organisme_code, collectivite_code, police_id, police_nom, police_description, police_date_debut, police_date_fin, utilisateur_id_creation)
        VALUES(:organisme_code, :collectivite_code, :police_id, :police_nom, :police_description, :police_date_debut, :police_date_fin, :utilisateur_id_creation)");
        $a->execute(array(
            'organisme_code' => $code_organisme,
            'collectivite_code' => $code_collectivite,
            'police_id' => $id_police,
            'police_nom' => $nom,
            'police_description' => $description,
            'police_date_debut' => $date_debut,
            'police_date_fin' => $date_fin,
            'utilisateur_id_creation' => $user
        ));
        if ($a->errorCode() == "00000") {
            return array(
                "success" => true,
                "id_police" => $id_police,
                "message" => 'Enregistrement effectué avec succès'
            );
        } else {
            return array(
                "success" => false,
                "message" => $a->errorInfo()
            );
        }
    }

    private function modifier($code_organisme, $code_collectivite, $id_police, $nom, $description, $date_debut, $date_fin, $user) {
        $a = $this->getBdd()->prepare("UPDATE tb_organismes_polices SET collectivite_code = ?, police_nom = ?, police_description = ?, police_date_debut = ?, police_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE organisme_code = ? AND police_id = ?");
        $a->execute(array($code_collectivite, $nom, $description, $date_debut, $date_fin, date('Y-m-d H:i:s', time()), $user, $code_organisme, $id_police));
        if ($a->errorCode() == "00000") {
            return array(
                "success" => true,
                "id_police" => $id_police,
                "message" => 'Enregistrement effectué avec succès'
            );
        } else {
            return array(
                "success" => false,
                "message" => $a->errorInfo()
            );
        }
    }

    public function editer($code_organisme, $code_collectivite, $id_police, $nom, $description, $date_debut, $date_fin, $user) {
        if($id_police) {
            $police = $this->trouver($code_organisme, $id_police);
            if($police) {
                return $this->modifier($code_organisme, $code_collectivite, $id_police, $nom, $description, $date_debut, $date_fin, $user);
            }else {
                return array(
                    'success' => false,
                    'message' => "Le numéro de police renseigné est érroné."
                );
            }
        }else {
            return $this->ajouter($code_organisme, $code_collectivite, $nom, $description, $date_debut, $date_fin, $user);
        }
    }

    public function lister_colleges($id_police) {
        $a = $this->getBdd()->prepare("
SELECT 
       police_college_code AS code, 
       police_college_libelle AS libelle, 
       police_college_date_debut AS date_debut, 
       police_college_date_fin AS date_fin 
FROM 
     tb_organismes_polices_colleges 
WHERE 
      police_id = ? 
ORDER BY date_creation DESC");
        $a->execute(array($id_police));
        return $a->fetchAll();
    }
}