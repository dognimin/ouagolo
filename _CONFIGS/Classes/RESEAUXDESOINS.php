<?php


class RESEAUXDESOINS extends BDD
{

    public function trouver($code)
    {
        $query = "
SELECT 
       reseau_soin_code AS code,
       reseau_soin_libelle AS libelle,
    reseau_soin_date_debut AS date_debut,
       utilisateur_id_creation
FROM
     tb_reseaux_soins
WHERE
      reseau_soin_code LIKE ? AND 
      reseau_soin_date_fin IS NULL
        ";
        $a = $this->bdd->prepare($query);
        $a->execute(array($code));
        return $a->fetch();
    }
    public function trouver_reseau_medicament($code_reseau,$code_medicament)
    {
        $query = "
SELECT 
       reseau_soin_code AS code_reseau,
       medicament_code AS code_medicament,
       reseau_soin_medicament_tarif AS tarif,
       reseau_soin_medicament_date_debut AS date_debut,
       utilisateur_id_creation
FROM
     tb_reseaux_soins_medicaments
WHERE
      reseau_soin_code LIKE ? AND 
      medicament_code LIKE ? AND 
      reseau_soin_medicament_date_fin IS NULL
        ";
        $a = $this->bdd->prepare($query);
        $a->execute(array($code_reseau,$code_medicament));
        return $a->fetch();
    }
    public function trouver_reseau_etablissement($code_reseau,$code_etablissement)
    {
        $query = "
SELECT 
       reseau_soin_code AS code_reseau,
       etablissement_code AS code_etablissement,
       reseau_soin_etablissement_date_debut AS date_debut,
       utilisateur_id_creation
FROM
     tb_reseaux_soins_etablissements
WHERE
      reseau_soin_code LIKE ? AND 
      etablissement_code LIKE ? AND 
      reseau_soin_etablissement_date_fin IS NULL
        ";
        $a = $this->bdd->prepare($query);
        $a->execute(array($code_reseau,$code_etablissement));
        return $a->fetch();
    }
    public function trouver_reseau_acte_medicale($code_reseau,$code_acte)
    {
        $query = "
SELECT 
       reseau_soin_code AS code_reseau,
        acte_code AS code_acte,
       reseau_soin_acte_date_debut  AS date_debut,
       utilisateur_id_creation
FROM
     tb_reseaux_soins_actes_medicaux
WHERE
      reseau_soin_code LIKE ? AND 
      acte_code LIKE ? AND 
      reseau_soin_acte_date_fin IS NULL
        ";
        $a = $this->bdd->prepare($query);
        $a->execute(array($code_reseau,$code_acte));
        return $a->fetch();
    }

    private function ajouter($code,$libelle, $user)
    {
        $a = $this->bdd->prepare("INSERT INTO tb_reseaux_soins(reseau_soin_code,reseau_soin_libelle,reseau_soin_date_debut , utilisateur_id_creation)
        VALUES(:reseau_soin_code, :reseau_soin_libelle, :reseau_soin_date_debut, :utilisateur_id_creation) 
        ");
        $a->execute(array(
            'reseau_soin_code' => $code,
            'reseau_soin_libelle' => $libelle,
            'reseau_soin_date_debut' => date('Y-m-d H:i:s', time()),
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
    private function ajouter_reseau_medicament($code_reseau,$code_medicament,$tarif, $user)
    {
        $a = $this->bdd->prepare("INSERT INTO tb_reseaux_soins_medicaments(reseau_soin_code,medicament_code,reseau_soin_medicament_tarif,reseau_soin_medicament_date_debut , utilisateur_id_creation)
        VALUES(:reseau_soin_code,:medicament_code,:reseau_soin_medicament_tarif,:reseau_soin_medicament_date_debut, :utilisateur_id_creation) 
        ");
        $a->execute(array(
            'reseau_soin_code' => $code_reseau,
            'medicament_code' => $code_medicament,
            'reseau_soin_medicament_tarif' => $tarif,
            'reseau_soin_medicament_date_debut' => date('Y-m-d H:i:s', time()),
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
    private function ajouter_reseau_etablissement($code_reseau,$code_etablissement, $user)
    {
        $a = $this->bdd->prepare("INSERT INTO tb_reseaux_soins_etablissements(reseau_soin_code,etablissement_code,reseau_soin_etablissement_date_debut ,utilisateur_id_creation)
        VALUES(:reseau_soin_code,:etablissement_code,:reseau_soin_etablissement_date_debut, :utilisateur_id_creation) 
        ");
        $a->execute(array(
            'reseau_soin_code' => $code_reseau,
            'etablissement_code' => $code_etablissement,
            'reseau_soin_etablissement_date_debut' => date('Y-m-d H:i:s', time()),
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
    private function ajouter_reseau_acte($code_reseau,$code_acte, $user)
    {
        $a = $this->bdd->prepare("INSERT INTO tb_reseaux_soins_actes_medicaux(reseau_soin_code,acte_code,reseau_soin_acte_date_debut ,utilisateur_id_creation)
        VALUES(:reseau_soin_code,:acte_code,:reseau_soin_acte_date_debut, :utilisateur_id_creation) 
        ");
        $a->execute(array(
            'reseau_soin_code' => $code_reseau,
            'acte_code' => $code_acte,
            'reseau_soin_acte_date_debut' => date('Y-m-d H:i:s', time()),
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

    private function fermer( $code, $date_fin, $user)
    {
        $a = $this->bdd->prepare("UPDATE tb_reseaux_soins  SET reseau_soin_date_fin = ?, date_edition = ?, utilisation_id_edition = ? WHERE reseau_soin_code = ?  AND reseau_soin_date_fin IS NULL");
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
    private function fermer_reseau_medicament( $code_reseau,$code_medicament, $date_fin, $user)
    {
        $a = $this->bdd->prepare("UPDATE tb_reseaux_soins_medicaments  SET reseau_soin_medicament_date_fin = ?, date_edition = ?, utilisation_id_edition = ? WHERE reseau_soin_code = ? AND medicament_code = ?   AND reseau_soin_medicament_date_fin IS NULL");
        $a->execute(array($date_fin, date('Y-m-d', time()), $user, $code_reseau, $code_medicament));
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
    private function fermer_reseau_etablissement( $code_reseau,$code_etablissement, $date_fin, $user)
    {
        $a = $this->bdd->prepare("UPDATE tb_reseaux_soins_etablissements  SET reseau_soin_etablissement_date_fin = ?, date_edition = ?, utilisation_id_edition = ? WHERE reseau_soin_code = ? AND etablissement_code = ?   AND reseau_soin_etablissement_date_fin IS NULL");
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
    private function fermer_reseau_acte( $code_reseau,$code_acte, $date_fin, $user)
    {
        $a = $this->bdd->prepare("UPDATE tb_reseaux_soins_actes_medicaux  SET reseau_soin_acte_date_fin = ?, date_edition = ?, utilisation_id_edition = ? WHERE reseau_soin_code = ? AND acte_code = ?   AND reseau_soin_acte_date_fin IS NULL");
        $a->execute(array($date_fin, date('Y-m-d', time()), $user, $code_reseau, $code_acte));
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

    public function editer($code,$libelle,$user)
    {
        $reseau = $this->trouver($code);
        if ($reseau) {
            $date_fin = date('Y-m-d', strtotime('-1 day', time()));
            if (strtotime($date_fin) > strtotime($reseau['date_debut'])) {
                $edition = $this->fermer($reseau['code'], $date_fin, $user);
                if ($edition['success'] == true) {
                    $json = $this->ajouter($code, $libelle, $user);
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
            $json = $this->ajouter($code, $libelle, $user);
        }
        return $json;
    }
    public function editer_reseau_medicament($code_reseau,$code_medicament,$tarif,$user)
    {
        $reseau_medicament = $this->trouver_reseau_medicament($code_reseau,$code_medicament);
        if ($reseau_medicament) {
            $date_fin = date('Y-m-d', strtotime('-1 day', time()));
            if (strtotime($date_fin) > strtotime($reseau_medicament['date_debut'])) {
                $edition = $this->fermer_reseau_medicament($reseau_medicament['code_reseau'],$reseau_medicament['code_medicament'], $date_fin, $user);
                if ($edition['success'] == true) {
                    $json = $this->ajouter_reseau_medicament($code_reseau,$code_medicament, $tarif, $user);
                } else {
                    $json = $edition;
                }
            } else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le " . date('d/m/Y', strtotime('+2 day', strtotime($reseau_medicament['date_debut'])))
                );
            }

        } else {
            $json = $this->ajouter_reseau_medicament($code_reseau,$code_medicament, $tarif, $user);
        }
        return $json;
    }
    public function editer_reseau_etablissement($code_reseau,$code_etablissement,$user)
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
    public function editer_reseau_acte_medicale($code_reseau,$code_acte,$user)
    {
        $reseau_acte_medicale = $this->trouver_reseau_acte_medicale($code_reseau,$code_acte);
        if ($reseau_acte_medicale) {
            $date_fin = date('Y-m-d', strtotime('-1 day', time()));
            if (strtotime($date_fin) > strtotime($reseau_acte_medicale['date_debut'])) {
                $edition = $this->fermer_reseau_acte($reseau_acte_medicale['code_reseau'],$reseau_acte_medicale['code_acte'], $date_fin, $user);
                if ($edition['success'] == true) {
                    $json = $this->ajouter_reseau_acte($code_reseau,$code_acte,$user);
                } else {
                    $json = $edition;
                }
            } else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le " . date('d/m/Y', strtotime('+2 day', strtotime($reseau_acte_medicale['date_debut'])))
                );
            }

        } else {
            $json = $this->ajouter_reseau_acte($code_reseau,$code_acte,$user);
        }
        return $json;
    }


    public function lister()
    {
        $query = "
SELECT 
       reseau_soin_code AS code,
       reseau_soin_libelle AS libelle,
       reseau_soin_date_debut AS date_debut,
       utilisateur_id_creation
FROM 
    tb_reseaux_soins
WHERE 
      reseau_soin_date_fin IS NULL

";
        $a = $this->bdd->prepare($query);
        $a->execute(array());
        return $a->fetchAll();
    }
    public function lister_reseau_medicaments($code_reseau)
    {
        $query = "
SELECT 
       A.reseau_soin_code AS code_reseau,
       A.medicament_code AS code_medicament,
       A.reseau_soin_medicament_tarif AS tarif,
       A.reseau_soin_medicament_date_debut AS date_debut,
       A.utilisateur_id_creation
FROM 
    tb_reseaux_soins_medicaments A
WHERE A.reseau_soin_code LIKE ? AND
      A.reseau_soin_medicament_date_fin IS NULL

";
        $a = $this->bdd->prepare($query);
        $a->execute(array($code_reseau));
        return $a->fetchAll();
    }
    public function lister_reseau_etablissements($code_reseau)
    {
        $query = "
SELECT 
       A.reseau_soin_code AS code_reseau,
       A.etablissement_code AS code_etablissement,
       A.reseau_soin_etablissement_date_debut AS date_debut,
       A.utilisateur_id_creation
FROM 
    tb_reseaux_soins_etablissements A
WHERE A.reseau_soin_code LIKE ? AND
      A.reseau_soin_etablissement_date_fin IS NULL

";
        $a = $this->bdd->prepare($query);
        $a->execute(array($code_reseau));
        return $a->fetchAll();
    }
    public function lister_reseau_actes_medicaux($code_reseau)
    {
        $query = "
SELECT 
       A.reseau_soin_code AS code_reseau,
       A.acte_code AS code_acte,
       A.reseau_soin_acte_date_debut AS date_debut,
       A.utilisateur_id_creation
FROM 
    tb_reseaux_soins_actes_medicaux A
WHERE A.reseau_soin_code LIKE ? AND
      A.reseau_soin_acte_date_fin IS NULL

";
        $a = $this->bdd->prepare($query);
        $a->execute(array($code_reseau));
        return $a->fetchAll();
    }

    public function lister_historique_reseau_medicament($code_reseau,$code_medicament)
    {
        $query = "
SELECT 
      A.reseau_soin_code AS code_reseau,
       A.medicament_code AS code_medicament,
       A.reseau_soin_medicament_tarif AS tarif,
       A.utilisateur_id_creation,
       B.utilisateur_nom AS nom,
       B.utilisateur_prenoms AS prenoms, 
       A.reseau_soin_medicament_date_debut AS date_debut, 
       A.reseau_soin_medicament_date_fin AS date_fin,
       A.date_creation, 
       A.utilisateur_id_creation
FROM 
     tb_reseaux_soins_medicaments A JOIN tb_utilisateurs B 
         ON 
             A.utilisateur_id_creation = B.utilisateur_id AND A.medicament_code  LIKE ? AND A.reseau_soin_code   LIKE ?
ORDER BY 
         A.date_creation DESC
";
        $a = $this->bdd->prepare($query);
        $a->execute(array($code_medicament,$code_reseau));
        return $a->fetchAll();
    }
    public function lister_historique_reseau_etablissement($code_reseau,$code_etablissement)
    {
        $query = "
SELECT 
      A.reseau_soin_code AS code_reseau,
       A.etablissement_code AS code_medicament,
       A.utilisateur_id_creation,
       B.utilisateur_nom AS nom,
       B.utilisateur_prenoms AS prenoms, 
       A.reseau_soin_etablissement_date_debut AS date_debut, 
       A.reseau_soin_etablissement_date_fin AS date_fin,
       A.date_creation, 
       A.utilisateur_id_creation
FROM 
     tb_reseaux_soins_etablissements A JOIN tb_utilisateurs B 
         ON 
             A.utilisateur_id_creation = B.utilisateur_id AND A.etablissement_code  LIKE ? AND A.reseau_soin_code   LIKE ?
ORDER BY 
         A.date_creation DESC
";
        $a = $this->bdd->prepare($query);
        $a->execute(array($code_etablissement,$code_reseau));
        return $a->fetchAll();
    }
    public function lister_historique_reseau_acte_medicale($code_reseau,$code_acte)
    {
        $query = "
SELECT 
     A.reseau_soin_code AS code_reseau,
       A.acte_code AS code_acte,
       A.reseau_soin_acte_date_debut AS date_debut,
       A.utilisateur_id_creation,
       B.utilisateur_nom AS nom,
       B.utilisateur_prenoms AS prenoms, 
       A.reseau_soin_acte_date_debut AS date_debut, 
       A.reseau_soin_acte_date_fin AS date_fin,
       A.date_creation
FROM 
     tb_reseaux_soins_actes_medicaux A JOIN tb_utilisateurs B 
         ON 
             A.utilisateur_id_creation = B.utilisateur_id AND A.acte_code  LIKE ? AND A.reseau_soin_code   LIKE ?
ORDER BY 
         A.date_creation DESC
";
        $a = $this->bdd->prepare($query);
        $a->execute(array($code_acte,$code_reseau));
        return $a->fetchAll();
    }
    public function lister_historique($code_reseau)
    {
        $query = "
SELECT 
     A.reseau_soin_code AS code,
       A.reseau_soin_libelle AS libelle,
       A.reseau_soin_date_debut AS date_debut,
       A.utilisateur_id_creation,
       B.utilisateur_nom AS nom,
       B.utilisateur_prenoms AS prenoms, 
       A.reseau_soin_date_debut AS date_debut, 
       A.reseau_soin_date_fin AS date_fin,
       A.date_creation
FROM 
     tb_reseaux_soins A JOIN tb_utilisateurs B 
         ON 
             A.utilisateur_id_creation = B.utilisateur_id  AND A.reseau_soin_code   LIKE ?
ORDER BY 
         A.date_creation DESC
";
        $a = $this->bdd->prepare($query);
        $a->execute(array($code_reseau));
        return $a->fetchAll();
    }




}