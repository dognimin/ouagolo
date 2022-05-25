<?php
namespace App;

class PATHOLOGIES extends BDD
{
    public function lister_referentiels()
    {
        $json = array(
            array(
                'code' => "pat_chap",
                'libelle' => "Chapitres"
            ),
            array(
                'code' => "pat_sch",
                'libelle' => "Sous chapitres"
            ),
            array(
                'code' => "pat",
                'libelle' => "Pathologies"
            )
        );
        return $json;
    }

    public function lister_chapitres()
    {
        $query = "
SELECT 
       A.chapitre_code AS code, 
       A.chapitre_libelle AS libelle, 
       A.chapitre_date_debut AS date_debut, 
       A.date_creation, 
       A.utilisateur_id_creation
FROM 
     tb_ref_pathologies_chapitres A
WHERE 
      A.chapitre_date_fin IS NULL
ORDER BY A.chapitre_code
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array());
        return $a->fetchAll();
    }

    public function lister_sous_chapitres($code)
    {
        $query = "
SELECT 
       A.chapitre_code AS code_chapitre,
       B.chapitre_libelle AS libelle_chapitre, 
       B.chapitre_code AS chapitre, 
       A.sous_chapitre_code AS code, 
       A.sous_chapitre_libelle AS libelle, 
       A.sous_chapitre_date_debut AS date_debut, 
       A.date_creation, 
       A.utilisateur_id_creation
FROM 
     tb_ref_pathologies_sous_chapitres A JOIN tb_ref_pathologies_chapitres B
     ON A.chapitre_code = B.chapitre_code
WHERE 
      A.sous_chapitre_date_fin IS NULL AND B.chapitre_date_fin IS NULL AND  A.chapitre_code LIKE ?
ORDER BY A.sous_chapitre_code
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array('%' . $code . '%'));
        return $a->fetchAll();
    }

    public function lister_pathologies($code, $libelle)
    {
        if($libelle) {
            $query = "
SELECT 
       A.pathologie_code  AS code, 
       B.chapitre_code AS code_chapitre,
       B.sous_chapitre_code AS sous_chapitre,
       C.chapitre_libelle AS libelle_chapitre,
       C.chapitre_code AS chapitre,
       A.sous_chapitre_code  AS code_sous_chapitre,
       B.sous_chapitre_libelle AS libelle_sous_chapitre, 
       A.pathologie_libelle AS libelle, 
       A.pathologie_date_debut AS date_debut, 
       A.date_creation, 
       A.utilisateur_id_creation
FROM 
     tb_ref_pathologies A JOIN tb_ref_pathologies_sous_chapitres B
     ON A.sous_chapitre_code = B.sous_chapitre_code JOIN tb_ref_pathologies_chapitres C
     ON B.chapitre_code = C.chapitre_code 
            AND A.pathologie_date_fin IS NULL 
            AND B.sous_chapitre_date_fin IS NULL 
            AND C.chapitre_date_fin IS NULL 
            AND A.sous_chapitre_code LIKE ?
            AND A.pathologie_libelle LIKE ?
ORDER BY A.pathologie_code
";
            $a = $this->getBdd()->prepare($query);
            $a->execute(array('%' . $code . '%', '%' . $libelle . '%'));
        }
        else {
            $query = "
SELECT 
       A.pathologie_code  AS code, 
       B.chapitre_code AS code_chapitre,
       B.sous_chapitre_code AS sous_chapitre,
       C.chapitre_libelle AS libelle_chapitre,
       C.chapitre_code AS chapitre,
       A.sous_chapitre_code  AS code_sous_chapitre,
       B.sous_chapitre_libelle AS libelle_sous_chapitre, 
       A.pathologie_libelle AS libelle, 
       A.pathologie_date_debut AS date_debut, 
       A.date_creation, 
       A.utilisateur_id_creation
FROM 
     tb_ref_pathologies A JOIN tb_ref_pathologies_sous_chapitres B
     ON A.sous_chapitre_code = B.sous_chapitre_code JOIN tb_ref_pathologies_chapitres C
     ON B.chapitre_code = C.chapitre_code 
            AND A.pathologie_date_fin IS NULL 
            AND B.sous_chapitre_date_fin IS NULL 
            AND C.chapitre_date_fin IS NULL 
            AND A.sous_chapitre_code LIKE ?
ORDER BY A.pathologie_code ASC
";
            $a = $this->getBdd()->prepare($query);
            $a->execute(array('%' . $code . '%'));
        }
        return $a->fetchAll();
    }

    public function editer_chapitre($code, $libelle, $user)
    {
        $chapitre = $this->trouver_chapitre($code);
        if ($chapitre) {
            $date_fin = date('Y-m-d', strtotime('-1 day', time()));
            if (strtotime($date_fin) > strtotime($chapitre['date_debut'])) {
                $edition = $this->fermer_chapitre($chapitre['code'], $date_fin, $user);
                if ($edition['success'] == true) {
                    $json = $this->ajouter_chapitre($code, $libelle, $user);
                } else {
                    $json = $edition;
                }
            } else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le " . date('d/m/Y', strtotime('+2 day', strtotime($chapitre['date_debut'])))
                );
            }
        } else {
            $json = $this->ajouter_chapitre($code, $libelle, $user);
        }
        return $json;
    }

    public function trouver_chapitre($code)
    {
        $query = "
SELECT 
       chapitre_code AS code,
       chapitre_libelle AS libelle,
       chapitre_date_debut AS date_debut,
       utilisateur_id_creation
FROM
     tb_ref_pathologies_chapitres
WHERE
      chapitre_code LIKE ? AND 
      chapitre_date_fin IS NULL
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        return $a->fetch();
    }

    private function fermer_chapitre($code, $date_fin, $user)
    {
        $a = $this->getBdd()->prepare("UPDATE tb_ref_pathologies_chapitres  SET chapitre_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE chapitre_code = ? AND chapitre_date_fin IS NULL");
        $a->execute(array($date_fin, date('Y-m-d H:i:s', time()), $user, $code));
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

    private function ajouter_chapitre($code, $libelle, $user)
    {
        $a = $this->getBdd()->prepare("INSERT INTO tb_ref_pathologies_chapitres(chapitre_code,chapitre_libelle,chapitre_date_debut,utilisateur_id_creation)
        VALUES(:chapitre_code,:chapitre_libelle,:chapitre_date_debut,:utilisateur_id_creation) 
        ");
        $a->execute(array(
            'chapitre_code' => $code,
            'chapitre_libelle' => $libelle,
            'chapitre_date_debut' => date('Y-m-d H:i:s', time()),
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

    public function editer_sous_chapitre($code_chapitre, $code, $libelle, $user)
    {
        $sous_chapitre = $this->trouver_sous_chapitre($code);
        if ($sous_chapitre) {
            $date_fin = date('Y-m-d', strtotime('-1 day', time()));
            if (strtotime($date_fin) > strtotime($sous_chapitre['date_debut'])) {
                $edition = $this->fermer_sous_chapitre($sous_chapitre['code'], $date_fin, $user);
                if ($edition['success'] == true) {
                    $json = $this->ajouter_sous_chapitre($code_chapitre, $code, $libelle, $user);
                } else {
                    $json = $edition;
                }
            } else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le " . date('d/m/Y', strtotime('+2 day', strtotime($sous_chapitre['date_debut'])))
                );
            }
        } else {
            $json = $this->ajouter_sous_chapitre($code_chapitre, $code, $libelle, $user);
        }
        return $json;
    }

    public function trouver_sous_chapitre($code)
    {
        $query = "
SELECT 
       sous_chapitre_code AS code,
       sous_chapitre_libelle AS libelle,
       sous_chapitre_date_debut AS date_debut,
       utilisateur_id_creation
FROM
     tb_ref_pathologies_sous_chapitres
WHERE
      sous_chapitre_code LIKE ? AND 
      sous_chapitre_date_fin IS NULL
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        return $a->fetch();
    }

    private function fermer_sous_chapitre($code, $date_fin, $user)
    {
        $a = $this->getBdd()->prepare("UPDATE tb_ref_pathologies_sous_chapitres  SET sous_chapitre_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE sous_chapitre_code = ? AND sous_chapitre_date_fin IS NULL");
        $a->execute(array($date_fin, date('Y-m-d H:i:s', time()), $user, $code));
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

    private function ajouter_sous_chapitre($code_chapitre, $code, $libelle, $user)
    {
        $a = $this->getBdd()->prepare("INSERT INTO tb_ref_pathologies_sous_chapitres(sous_chapitre_code,chapitre_code,sous_chapitre_libelle,sous_chapitre_date_debut,utilisateur_id_creation)
        VALUES(:sous_chapitre_code,:chapitre_code,:sous_chapitre_libelle,:sous_chapitre_date_debut,:utilisateur_id_creation) 
        ");
        $a->execute(array(
            'sous_chapitre_code' => $code,
            'chapitre_code' => $code_chapitre,
            'sous_chapitre_libelle' => $libelle,
            'sous_chapitre_date_debut' => date('Y-m-d', time()),
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

    public function editer_pathologie($sous_chapitre, $code, $libelle, $user)
    {
        $pathologie = $this->trouver_pathologie($code);
        if ($pathologie) {
            $date_fin = date('Y-m-d', strtotime('-1 day', time()));
            if (strtotime($date_fin) > strtotime($pathologie['date_debut'])) {
                $edition = $this->fermer_pathologie($pathologie['code'], $date_fin, $user);
                if ($edition['success'] == true) {
                    $json = $this->ajouter_pathologie($sous_chapitre, $code, $libelle, $user);

                } else {
                    $json = $edition;
                }
            } else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le " . date('d/m/Y', strtotime('+2 day', strtotime($pathologie['date_debut'])))
                );
            }
        } else {
            $json = $this->ajouter_pathologie($sous_chapitre, $code, $libelle, $user);
        }
        return $json;
    }

    public function trouver_pathologie($code)
    {
        $query = "
SELECT 
       	pathologie_code AS code,
       	pathologie_libelle AS libelle,
       	pathologie_date_debut AS date_debut,
        utilisateur_id_creation
FROM
     tb_ref_pathologies
WHERE
      pathologie_code LIKE ? AND 
      pathologie_date_fin IS NULL
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        return $a->fetch();
    }

    private function fermer_pathologie($code, $date_fin, $user)
    {
        $a = $this->getBdd()->prepare("UPDATE tb_ref_pathologies  SET 	pathologie_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE pathologie_code = ? AND pathologie_date_fin IS NULL");
        $a->execute(array($date_fin, date('Y-m-d H:i:s', time()), $user, $code));
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

    private function ajouter_pathologie($code_sous_chapitre, $code, $libelle, $user)
    {
        $a = $this->getBdd()->prepare("INSERT INTO tb_ref_pathologies(pathologie_code,sous_chapitre_code,pathologie_libelle,pathologie_date_debut ,utilisateur_id_creation)
        VALUES(:pathologie_code,:sous_chapitre_code,:pathologie_libelle,:pathologie_date_debut,:utilisateur_id_creation) 
        ");
        $a->execute(array(
            'pathologie_code' => $code,
            'sous_chapitre_code' => $code_sous_chapitre,
            'pathologie_libelle' => $libelle,
            'pathologie_date_debut' => date('Y-m-d H:i:s', time()),
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

    public function lister_historique_chapitre($code)
    {
        $query = "
SELECT 
       A.chapitre_code AS code, 
       A.chapitre_libelle AS libelle, 
       B.utilisateur_nom AS nom,
       B.utilisateur_prenoms AS prenoms, 
       A.chapitre_date_debut AS date_debut, 
       A.chapitre_date_fin AS date_fin, 
       A.date_creation, 
       A.utilisateur_id_creation
FROM 
     tb_ref_pathologies_chapitres A JOIN tb_utilisateurs B 
         ON 
             A.utilisateur_id_creation = B.utilisateur_id AND A.chapitre_code LIKE ?
ORDER BY 
         A.date_creation DESC
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array('%' . $code . '%'));
        return $a->fetchAll();
    }

    public function lister_historique_sous_chapitre($code)
    {
        $query = "
SELECT 
       A.sous_chapitre_code AS code, 
       A.sous_chapitre_libelle AS libelle, 
       B.utilisateur_nom AS nom,
       B.utilisateur_prenoms AS prenoms, 
       A.sous_chapitre_date_debut AS date_debut, 
       A.sous_chapitre_date_fin AS date_fin, 
       A.date_creation, 
       A.utilisateur_id_creation
FROM 
     tb_ref_pathologies_sous_chapitres A JOIN tb_utilisateurs B 
         ON 
             A.utilisateur_id_creation = B.utilisateur_id AND A.sous_chapitre_code LIKE ?
ORDER BY 
         A.date_creation DESC
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array('%' . $code . '%'));
        return $a->fetchAll();
    }

    public function lister_historique_pathologie($code)
    {
        $query = "
SELECT 
       A.pathologie_code AS code, 
       A.pathologie_libelle AS libelle, 
       B.utilisateur_nom AS nom,
       B.utilisateur_prenoms AS prenoms, 
       A.pathologie_date_debut AS date_debut, 
       A.pathologie_date_fin AS date_fin, 
       A.date_creation, 
       A.utilisateur_id_creation
FROM 
     tb_ref_pathologies A JOIN tb_utilisateurs B 
         ON 
             A.utilisateur_id_creation = B.utilisateur_id AND  A.pathologie_code LIKE ?
ORDER BY 
         A.date_creation DESC
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array('%' . $code . '%'));
        return $a->fetchAll();
    }

}