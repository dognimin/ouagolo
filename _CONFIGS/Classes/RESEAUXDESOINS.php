<?php
namespace App;

class RESEAUXDESOINS extends BDD
{

    public function editer($code_organisme, $code, $libelle, $user)
    {
        $reseau = $this->trouver($code_organisme, $code);
        if ($reseau) {
            $date_fin = date('Y-m-d', strtotime('-1 day', time()));
            if (strtotime($date_fin) > strtotime($reseau['date_debut'])) {
                $edition = $this->fermer($reseau['code'], $date_fin, $user);
                if ($edition['success'] == true) {
                    $json = $this->ajouter($code_organisme, $libelle, $user);
                } else {
                    $json = $edition;
                }
            } else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le " . date('d/m/Y', strtotime('+2 day', strtotime($reseau['date_debut'])))
                );
            }

        } else {
            $json = $this->ajouter($code_organisme, $libelle, $user);
        }
        return $json;
    }

    public function trouver($code_organisme, $code)
    {
        $query = "SELECT A.organisme_code AS code_organisme, B.organisme_libelle AS libelle_organisme, A.reseau_soins_code AS code, A.reseau_soins_libelle AS libelle, A.reseau_soins_date_debut AS date_debut, A.utilisateur_id_creation FROM tb_reseaux_soins A JOIN tb_organismes B ON A.organisme_code = B.organisme_code AND A.organisme_code LIKE ? AND A.reseau_soins_code = ? AND A.reseau_soins_date_fin IS NULL";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array('%'.$code_organisme.'%', $code));
        return $a->fetch();
    }

    private function fermer( $code, $date_fin, $user)
    {
        $a = $this->getBdd()->prepare("UPDATE tb_reseaux_soins SET reseau_soins_date_fin = ?, date_edition = ?, utilisation_id_edition = ? WHERE reseau_soins_code = ? AND reseau_soins_date_fin IS NULL");
        $a->execute(array($date_fin, date('Y-m-d', time()), $user, $code));
        if ($a->errorCode() == "00000") {
            return array(
                "success" => true,
                "messages" => 'Enregistrement effectué avec succès.'
            );
        } else {
            return array(
                "success" => false,
                "messages" => $a->errorInfo()
            );
        }
    }

    private function ajouter($code_organisme, $libelle, $user)
    {
        $reseaux = $this->lister(null);
        $nb_reseaux = count($reseaux);
        $code = 'RSS'.str_pad(intval($nb_reseaux + 1), 7,'0',STR_PAD_LEFT);

        $a = $this->getBdd()->prepare("INSERT INTO tb_reseaux_soins(organisme_code, reseau_soins_code,reseau_soins_libelle,reseau_soins_date_debut , utilisateur_id_creation)
        VALUES(:organisme_code, :reseau_soins_code, :reseau_soins_libelle, :reseau_soins_date_debut, :utilisateur_id_creation) 
        ");
        $a->execute(array(
            'organisme_code' => $code_organisme,
            'reseau_soins_code' => $code,
            'reseau_soins_libelle' => $libelle,
            'reseau_soins_date_debut' => date('Y-m-d', time()),
            'utilisateur_id_creation' => $user
        ));
        if ($a->errorCode() == "00000") {
            return array(
                "success" => true,
                "code" => $code,
                "message" => 'Enregistrement effectué avec succès'
            );
        } else {
            return array(
                "success" => false,
                "message" => $a->errorInfo()
            );
        }
    }

    public function lister($code_organisme)
    {
        $a = $this->getBdd()->prepare("SELECT A.organisme_code AS code_organisme, B.organisme_libelle AS libelle_organisme, A.reseau_soins_code AS code, A.reseau_soins_libelle AS libelle, A.reseau_soins_date_debut AS date_debut, A.utilisateur_id_creation FROM tb_reseaux_soins A JOIN tb_organismes B ON A.organisme_code = B.organisme_code AND A.organisme_code LIKE ? AND A.reseau_soins_date_fin IS NULL");
        $a->execute(array('%'.$code_organisme.'%'));
        return $a->fetchAll();
    }

    public function editer_reseau_etablissement($code_reseau, $code_etablissement, $user)
    {
        $reseau_etablisssement = $this->trouver_reseau_etablissement($code_reseau,$code_etablissement);
        if ($reseau_etablisssement) {
            $date_fin = date('Y-m-d', strtotime('-1 day', time()));
            if (strtotime($date_fin) > strtotime($reseau_etablisssement['date_debut'])) {
                $edition = $this->fermer_reseau_etablissement($reseau_etablisssement['code_reseau'],$reseau_etablisssement['code_etablissement'], $date_fin, $user);
                if ($edition['success'] == true) {
                    $json = $this->ajouter_reseau_etablissement($code_reseau,$code_etablissement,$user);
                } else {
                    $json = $edition;
                }
            } else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le " . date('d/m/Y', strtotime('+2 day', strtotime($reseau_etablisssement['date_debut'])))
                );
            }

        } else {
            $json = $this->ajouter_reseau_etablissement($code_reseau,$code_etablissement, $user);
        }
        return $json;
    }

    public function trouver_reseau_etablissement($code_reseau, $code_etablissement)
    {
        if($code_reseau) {
            $a = $this->getBdd()->prepare("
SELECT 
       reseau_soins_code AS code_reseau,
       etablissement_code AS code_etablissement,
       reseau_soins_etablissement_date_debut AS date_debut,
       utilisateur_id_creation
FROM
     tb_reseaux_soins_etablissements
WHERE
      reseau_soins_code LIKE ? AND 
      etablissement_code LIKE ? AND 
      reseau_soins_etablissement_date_fin IS NULL");
            $a->execute(array('%'.$code_reseau.'%','%'.$code_etablissement.'%'));
        }else {
            $a = $this->getBdd()->prepare("
SELECT 
       reseau_soins_code AS code_reseau,
       etablissement_code AS code_etablissement,
       reseau_soins_etablissement_date_debut AS date_debut,
       utilisateur_id_creation
FROM
     tb_reseaux_soins_etablissements
WHERE
      etablissement_code LIKE ? AND 
      reseau_soins_etablissement_date_fin IS NULL
        ");
            $a->execute(array($code_etablissement));
        }

        return $a->fetch();
    }

    private function fermer_reseau_etablissement( $code_reseau, $code_etablissement, $date_fin, $user)
    {
        $a = $this->getBdd()->prepare("UPDATE tb_reseaux_soins_etablissements  SET reseau_soins_etablissement_date_fin = ?, date_edition = ?, utilisation_id_edition = ? WHERE reseau_soins_code = ? AND etablissement_code = ?   AND reseau_soins_etablissement_date_fin IS NULL");
        $a->execute(array($date_fin, date('Y-m-d', time()), $user, $code_reseau, $code_etablissement));
        if ($a->errorCode() == "00000") {
            return array(
                "success" => true,
                "messages" => 'Enregistrement effectué avec succès.'
            );
        } else {
            return array(
                "success" => false,
                "messages" => $a->errorInfo()
            );
        }
    }

    private function ajouter_reseau_etablissement($code_reseau, $code_etablissement, $user)
    {
        $a = $this->getBdd()->prepare("INSERT INTO tb_reseaux_soins_etablissements(reseau_soins_code,etablissement_code,reseau_soins_etablissement_date_debut ,utilisateur_id_creation)
        VALUES(:reseau_soins_code,:etablissement_code,:reseau_soins_etablissement_date_debut, :utilisateur_id_creation) 
        ");
        $a->execute(array(
            'reseau_soins_code' => $code_reseau,
            'etablissement_code' => $code_etablissement,
            'reseau_soins_etablissement_date_debut' => date('Y-m-d H:i:s', time()),
            'utilisateur_id_creation' => $user
        ));
        if ($a->errorCode() == "00000") {
            return array(
                "success" => true,
                "message" => 'Enregistrement effectué avec succès'
            );
        } else {
            return array(
                "success" => false,
                "message" => $a->errorInfo()
            );
        }
    }

    public function lister_reseau_etablissements($code_reseau)
    {
        $query = "
SELECT 
       A.reseau_soins_code AS code_reseau,
       A.etablissement_code AS code_etablissement,
       B.raison_sociale AS raison_sociale,
       A.reseau_soins_etablissement_date_debut AS date_debut,
       A.utilisateur_id_creation
FROM 
    tb_reseaux_soins_etablissements A
JOIN 
        tb_etablissements B on 
            A.etablissement_code = B.etablissement_code 
                AND A.reseau_soins_code LIKE ? 
                AND A.reseau_soins_etablissement_date_fin IS NULL
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code_reseau));
        return $a->fetchAll();
    }

    public function lister_historique_reseau_etablissement($code_reseau, $code_etablissement)
    {
        $query = "
SELECT 
      A.reseau_soins_code AS code_reseau,
       A.etablissement_code AS code_medicament,
       A.utilisateur_id_creation,
       B.utilisateur_nom AS nom,
       B.utilisateur_prenoms AS prenoms, 
       A.reseau_soins_etablissement_date_debut AS date_debut, 
       A.reseau_soins_etablissement_date_fin AS date_fin,
       A.date_creation, 
       A.utilisateur_id_creation
FROM 
     tb_reseaux_soins_etablissements A JOIN tb_utilisateurs B 
         ON 
             A.utilisateur_id_creation = B.utilisateur_id AND A.etablissement_code  LIKE ? AND A.reseau_soins_code   LIKE ?
ORDER BY 
         A.date_creation DESC
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code_etablissement,$code_reseau));
        return $a->fetchAll();
    }

    public function lister_historique($code_reseau)
    {
        $query = "
SELECT 
     A.reseau_soins_code AS code,
       A.reseau_soins_libelle AS libelle,
       A.reseau_soins_date_debut AS date_debut,
       A.utilisateur_id_creation,
       B.utilisateur_nom AS nom,
       B.utilisateur_prenoms AS prenoms, 
       A.reseau_soins_date_debut AS date_debut, 
       A.reseau_soins_date_fin AS date_fin,
       A.date_creation
FROM 
     tb_reseaux_soins A JOIN tb_utilisateurs B 
         ON 
             A.utilisateur_id_creation = B.utilisateur_id  AND A.reseau_soins_code   LIKE ?
ORDER BY 
         A.date_creation DESC
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code_reseau));
        return $a->fetchAll();
    }
}