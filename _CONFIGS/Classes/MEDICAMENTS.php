<?php
namespace App;

class MEDICAMENTS extends BDD
{
    public function lister_referentiels()
    {
        $json = array(
            array(
                'code' => "med_lab",
                'libelle' => "Laboratoires pharmaceutiques"
            ),
            array(
                'code' => "med_pre",
                'libelle' => "Présentations / Conditionnements"
            ),
            array(
                'code' => "med_ffm",
                'libelle' => "Familles de forme"
            ),
            array(
                'code' => "med_frm",
                'libelle' => "Formes galéniques"
            ),
            array(
                'code' => "med_typ",
                'libelle' => "Types"
            ),
            array(
                'code' => "med_cth",
                'libelle' => "Classes thérapeutiques"
            ),
            array(
                'code' => "med_fra",
                'libelle' => "Formes d'administration"
            ),
            array(
                'code' => "med_unt",
                'libelle' => "Unités de dosage"
            ),
            array(
                'code' => "med_group",
                'libelle' => "Groupes de médicaments"
            ),
            array(
                'code' => "med_dci",
                'libelle' => "Dénominations communes internationales"
            ),
            array(
                'code' => "med",
                'libelle' => "Médicaments"
            )
        );
        return $json;
    }

    public function editer_laboratoire_pharmaceutique($code, $libelle, $user)
    {
        $laboratoires = $this->trouver_laboratoire_pharmaceutique($code);
        if ($laboratoires) {
            $date_fin = date('Y-m-d', strtotime('-1 day', time()));
            if (strtotime($date_fin) > strtotime($laboratoires['date_debut'])) {
                $edition = $this->fermer_laboratoire_pharmaceutique($laboratoires['code'], $date_fin, $user);
                if ($edition['success'] == true) {
                    $json = $this->ajouter_laboratoire_pharmaceutique($code, $libelle, $user);
                } else {
                    $json = $edition;
                }
            } else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le " . date('d/m/Y', strtotime('+2 day', strtotime($laboratoires['date_debut'])))
                );
            }
        } else {
            $json = $this->ajouter_laboratoire_pharmaceutique($code, $libelle, $user);
        }
        return $json;
    }

    public function trouver_laboratoire_pharmaceutique($code)
    {
        $query = "
SELECT 
       laboratoire_code  AS code,
       laboratoire_libelle AS libelle,
       laboratoire_date_debut AS date_debut,
       utilisateur_id_creation
FROM
     tb_ref_medicaments_laboratoires_pharmaceutiques
WHERE
      laboratoire_code LIKE ? AND 
      laboratoire_date_fin IS NULL
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        return $a->fetch();
    }

    private function fermer_laboratoire_pharmaceutique($code, $date_fin, $user)
    {
        $a = $this->getBdd()->prepare("UPDATE tb_ref_medicaments_laboratoires_pharmaceutiques  SET 	laboratoire_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE 	laboratoire_code  = ? AND 	laboratoire_date_fin IS NULL");
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

    private function ajouter_laboratoire_pharmaceutique($code, $libelle, $user)
    {
        if(!$code) {
            $laboratoires = $this->lister_laboratoires_pharmaceutiques();
            $nb_laboratoires = count($laboratoires);
            $code = 'LAB'.str_pad(intval($nb_laboratoires + 1), 4,'0',STR_PAD_LEFT);
        }

        $a = $this->getBdd()->prepare("INSERT INTO tb_ref_medicaments_laboratoires_pharmaceutiques(laboratoire_code,laboratoire_libelle,laboratoire_date_debut,utilisateur_id_creation)
        VALUES(:laboratoire_code,:laboratoire_libelle,:laboratoire_date_debut,:utilisateur_id_creation) 
        ");
        $a->execute(array(
            'laboratoire_code' => $code,
            'laboratoire_libelle' => $libelle,
            'laboratoire_date_debut' => date('Y-m-d H:i:s', time()),
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

    public function lister_laboratoires_pharmaceutiques()
    {
        $query = "
SELECT 
       laboratoire_code  AS code,
       laboratoire_libelle AS libelle,
       laboratoire_date_debut AS date_debut,
       utilisateur_id_creation
FROM
     tb_ref_medicaments_laboratoires_pharmaceutiques
WHERE 
      laboratoire_date_fin IS NULL
ORDER BY laboratoire_libelle
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array());
        return $a->fetchAll();
    }

    public function editer_presentation($code, $libelle, $user)
    {
        $presentations = $this->trouver_presentation($code);
        if ($presentations) {
            $date_fin = date('Y-m-d', strtotime('-1 day', time()));
            if (strtotime($date_fin) > strtotime($presentations['date_debut'])) {
                $edition = $this->fermer_presentation($presentations['code'], $date_fin, $user);
                if ($edition['success'] == true) {
                    $json = $this->ajouter_presentation($code, $libelle, $user);
                } else {
                    $json = $edition;
                }
            } else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le " . date('d/m/Y', strtotime('+2 day', strtotime($presentations['date_debut'])))
                );
            }
        } else {
            $json = $this->ajouter_presentation($code, $libelle, $user);
        }
        return $json;
    }

    public function trouver_presentation($code)
    {
        $query = "
SELECT 
       	presentation_code  AS code,
       	presentation_libelle AS libelle,
       	presentation_date_debut AS date_debut,
       utilisateur_id_creation
FROM
     tb_ref_medicaments_presentations
WHERE
      	presentation_code LIKE ? AND 
      	presentation_date_fin IS NULL
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        return $a->fetch();
    }

    private function fermer_presentation($code, $date_fin, $user)
    {
        $a = $this->getBdd()->prepare("UPDATE tb_ref_medicaments_presentations  SET presentation_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE 	presentation_code = ? AND 	presentation_date_fin IS NULL");
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

    private function ajouter_presentation($code, $libelle, $user)
    {
        if(!$code) {
            $presentations = $this->lister_presentations();
            $nb_presentations = count($presentations);
            $code = 'PRS'.str_pad(intval($nb_presentations + 1), 4,'0',STR_PAD_LEFT);
        }

        $a = $this->getBdd()->prepare("INSERT INTO tb_ref_medicaments_presentations(presentation_code ,presentation_libelle,presentation_date_debut,utilisateur_id_creation)
        VALUES(:presentation_code,:presentation_libelle,:presentation_date_debut,:utilisateur_id_creation) 
        ");
        $a->execute(array(
            'presentation_code' => $code,
            'presentation_libelle' => $libelle,
            'presentation_date_debut' => date('Y-m-d H:i:s', time()),
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

    public function lister_presentations()
    {
        $query = "
SELECT 
        	presentation_code  AS code,
       	presentation_libelle AS libelle,
       	presentation_date_debut AS date_debut,
       utilisateur_id_creation
FROM
     tb_ref_medicaments_presentations
WHERE 
      presentation_date_fin IS NULL
ORDER BY presentation_libelle
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array());
        return $a->fetchAll();
    }

    public function editer_famille_forme($code, $libelle, $user)
    {
        $famille_formes = $this->trouver_famille_forme($code);
        if ($famille_formes) {
            $date_fin = date('Y-m-d', strtotime('-1 day', time()));
            if (strtotime($date_fin) > strtotime($famille_formes['date_debut'])) {
                $edition = $this->fermer_famille_forme($famille_formes['code'], $date_fin, $user);
                if ($edition['success'] == true) {
                    $json = $this->ajouter_famille_forme($code, $libelle, $user);
                } else {
                    $json = $edition;
                }
            } else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le " . date('d/m/Y', strtotime('+2 day', strtotime($famille_formes['date_debut'])))
                );
            }
        } else {
            $json = $this->ajouter_famille_forme($code, $libelle, $user);
        }
        return $json;
    }

    public function trouver_famille_forme($code)
    {
        $query = "
SELECT 
       	famille_code  AS code,
       	famille_libelle AS libelle,
       	famille_date_debut AS date_debut,
       utilisateur_id_creation
FROM
     tb_ref_medicaments_familles_formes
WHERE
      	famille_code LIKE ? AND 
      	famille_date_fin IS NULL
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        return $a->fetch();
    }

    private function fermer_famille_forme($code, $date_fin, $user)
    {
        $a = $this->getBdd()->prepare("UPDATE tb_ref_medicaments_familles_formes  SET 	famille_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE 		famille_code = ? AND 		famille_date_fin IS NULL");
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

    private function ajouter_famille_forme($code, $libelle, $user)
    {
        if(!$code) {

        }
        $a = $this->getBdd()->prepare("INSERT INTO tb_ref_medicaments_familles_formes(famille_code,famille_libelle,famille_date_debut,utilisateur_id_creation)
        VALUES(:famille_code,:famille_libelle,:famille_date_debut,:utilisateur_id_creation) 
        ");
        $a->execute(array(
            'famille_code' => $code,
            'famille_libelle' => $libelle,
            'famille_date_debut' => date('Y-m-d H:i:s', time()),
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

    public function editer_forme($code, $libelle, $user)
    {
        $formes = $this->trouver_forme($code);
        if ($formes) {
            $date_fin = date('Y-m-d', strtotime('-1 day', time()));
            if (strtotime($date_fin) > strtotime($formes['date_debut'])) {
                $edition = $this->fermer_forme($formes['code'], $date_fin, $user);
                if ($edition['success'] == true) {
                    $json = $this->ajouter_forme($code, $libelle, $user);
                } else {
                    $json = $edition;
                }
            } else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le " . date('d/m/Y', strtotime('+2 day', strtotime($formes['date_debut'])))
                );
            }
        } else {
            $json = $this->ajouter_forme($code, $libelle, $user);
        }
        return $json;
    }

    public function trouver_forme($code)
    {
        $query = "
SELECT 
       		forme_code  AS code,
       		forme_libelle AS libelle,
       		forme_date_debut AS date_debut,
       utilisateur_id_creation
FROM
     tb_ref_medicaments_formes
WHERE
      		forme_code LIKE ? AND 
      		forme_date_fin IS NULL
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        return $a->fetch();
    }

    private function fermer_forme($code, $date_fin, $user)
    {
        $a = $this->getBdd()->prepare("UPDATE tb_ref_medicaments_formes  SET 	forme_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE 		forme_code = ? AND 		forme_date_fin IS NULL");
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

    private function ajouter_forme($code, $libelle, $user)
    {
        if(!$code) {
            $formes = $this->lister_formes();
            $nb_formes = count($formes);
            $code = 'FRM'.str_pad(intval($nb_formes + 1), 4,'0',STR_PAD_LEFT);
        }
        $a = $this->getBdd()->prepare("INSERT INTO tb_ref_medicaments_formes(forme_code,forme_libelle,forme_date_debut,utilisateur_id_creation)
        VALUES(:forme_code,:forme_libelle,:forme_date_debut,:utilisateur_id_creation) 
        ");
        $a->execute(array(
            'forme_code' => $code,
            'forme_libelle' => $libelle,
            'forme_date_debut' => date('Y-m-d H:i:s', time()),
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

    public function lister_formes()
    {
        $query = "
SELECT 
        	forme_code  AS code,
       		forme_libelle AS libelle,
       		forme_date_debut AS date_debut,
       utilisateur_id_creation
FROM
     tb_ref_medicaments_formes
WHERE 
      forme_date_fin IS NULL
ORDER BY forme_libelle
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array());
        return $a->fetchAll();
    }

    public function editer_type($code, $libelle, $user)
    {
        $types_medicaments = $this->trouver_type($code);
        if ($types_medicaments) {
            $date_fin = date('Y-m-d', strtotime('-1 day', time()));
            if (strtotime($date_fin) > strtotime($types_medicaments['date_debut'])) {
                $edition = $this->fermer_type($types_medicaments['code'], $date_fin, $user);
                if ($edition['success'] == true) {
                    $json = $this->ajouter_type($code, $libelle, $user);
                } else {
                    $json = $edition;
                }
            } else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le " . date('d/m/Y', strtotime('+2 day', strtotime($types_medicaments['date_debut'])))
                );
            }
        } else {
            $json = $this->ajouter_type($code, $libelle, $user);
        }
        return $json;
    }

    public function trouver_type($code)
    {
        $query = "
SELECT 
       			type_medicament_code  AS code,
       			type_medicament_libelle AS libelle,
       			type_medicament_date_debut AS date_debut,
       utilisateur_id_creation
FROM
     tb_ref_medicaments_types
WHERE
      			type_medicament_code LIKE ? AND 
      			type_medicament_date_fin IS NULL
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        return $a->fetch();
    }

    private function fermer_type($code, $date_fin, $user)
    {
        $a = $this->getBdd()->prepare("UPDATE tb_ref_medicaments_types SET type_medicament_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE 		type_medicament_code = ? AND 		type_medicament_date_fin IS NULL");
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

    private function ajouter_type($code, $libelle, $user)
    {
        if(!$code) {
            $types = $this->lister_types();
            $nb_types = count($types);
            $code = 'TYP'.str_pad(intval($nb_types + 1), 4,'0',STR_PAD_LEFT);
        }

        $a = $this->getBdd()->prepare("INSERT INTO tb_ref_medicaments_types(type_medicament_code,type_medicament_libelle,type_medicament_date_debut,utilisateur_id_creation)
        VALUES(:type_medicament_code,:type_medicament_libelle,:type_medicament_date_debut,:utilisateur_id_creation) 
        ");
        $a->execute(array(
            'type_medicament_code' => $code,
            'type_medicament_libelle' => $libelle,
            'type_medicament_date_debut' => date('Y-m-d H:i:s', time()),
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

    public function lister_types()
    {
        $query = "
SELECT 
        	type_medicament_code  AS code,
       			type_medicament_libelle AS libelle,
       			type_medicament_date_debut AS date_debut,
       utilisateur_id_creation
FROM
     tb_ref_medicaments_types
WHERE 
      type_medicament_date_fin IS NULL
ORDER BY type_medicament_libelle
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array());
        return $a->fetchAll();
    }

    public function editer_classe_therapeutique($code, $libelle, $user)
    {
        $classes_therapeutiques = $this->trouver_classe_therapeutique($code);
        if ($classes_therapeutiques) {
            $date_fin = date('Y-m-d', strtotime('-1 day', time()));
            if (strtotime($date_fin) > strtotime($classes_therapeutiques['date_debut'])) {
                $edition = $this->fermer_classe_therapeutique($classes_therapeutiques['code'], $date_fin, $user);
                if ($edition['success'] == true) {
                    $json = $this->ajouter_classe_therapeutique($code, $libelle, $user);
                } else {
                    $json = $edition;
                }
            } else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le " . date('d/m/Y', strtotime('+2 day', strtotime($classes_therapeutiques['date_debut'])))
                );
            }
        } else {
            $json = $this->ajouter_classe_therapeutique($code, $libelle, $user);
        }
        return $json;
    }

    public function trouver_classe_therapeutique($code)
    {
        $query = "
SELECT 
       			classe_therapeutique_code  AS code,
       			classe_therapeutique_libelle AS libelle,
       			classe_therapeutique_date_debut AS date_debut,
       utilisateur_id_creation
FROM
     tb_ref_medicaments_classes_therapeutiques
WHERE
      			classe_therapeutique_code LIKE ? AND 
      			classe_therapeutique_date_fin IS NULL
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        return $a->fetch();
    }

    private function fermer_classe_therapeutique($code, $date_fin, $user)
    {
        $a = $this->getBdd()->prepare("UPDATE tb_ref_medicaments_classes_therapeutiques  SET classe_therapeutique_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE 	classe_therapeutique_code = ? AND 		classe_therapeutique_date_fin IS NULL");
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

    private function ajouter_classe_therapeutique($code, $libelle, $user)
    {
        if(!$code) {
            $classes_therapeutiques = $this->lister_classes_therapeutiques();
            $nb_classes_therapeutiques = count($classes_therapeutiques);
            $code = 'CLT'.str_pad(intval($nb_classes_therapeutiques + 1), 4,'0',STR_PAD_LEFT);
        }
        $a = $this->getBdd()->prepare("INSERT INTO tb_ref_medicaments_classes_therapeutiques(classe_therapeutique_code,classe_therapeutique_libelle,classe_therapeutique_date_debut,utilisateur_id_creation)
        VALUES(:classe_therapeutique_code,:classe_therapeutique_libelle,:classe_therapeutique_date_debut,:utilisateur_id_creation) 
        ");
        $a->execute(array(
            'classe_therapeutique_code' => $code,
            'classe_therapeutique_libelle' => $libelle,
            'classe_therapeutique_date_debut' => date('Y-m-d H:i:s', time()),
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

    public function lister_classes_therapeutiques()
    {
        $query = "
SELECT 
       classe_therapeutique_code  AS code,
       classe_therapeutique_libelle AS libelle,
       classe_therapeutique_date_debut AS date_debut,
       utilisateur_id_creation
FROM
     tb_ref_medicaments_classes_therapeutiques
WHERE 
      classe_therapeutique_date_fin IS NULL
ORDER BY classe_therapeutique_libelle
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array());
        return $a->fetchAll();
    }

    public function editer_sous_classe_therapeutique($code_classe, $code, $libelle, $user)
    {
        $classes_therapeutiques = $this->trouver_sous_classe_therapeutique($code);
        if ($classes_therapeutiques) {
            $date_fin = date('Y-m-d', strtotime('-1 day', time()));
            if (strtotime($date_fin) > strtotime($classes_therapeutiques['date_debut'])) {
                $edition = $this->fermer_sous_classe_therapeutique($classes_therapeutiques['code'], $date_fin, $user);
                if ($edition['success'] == true) {
                    $json = $this->ajouter_sous_classe_therapeutique($code, $code_classe, $libelle, $user);
                } else {
                    $json = $edition;
                }
            } else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le " . date('d/m/Y', strtotime('+2 day', strtotime($classes_therapeutiques['date_debut'])))
                );
            }
        } else {
            $json = $this->ajouter_sous_classe_therapeutique($code, $code_classe, $libelle, $user);
        }
        return $json;
    }

    public function trouver_sous_classe_therapeutique($code)
    {
        $query = "
SELECT 
       classe_therapeutique_code  AS code_classe_therapeutique,
       sous_classe_therapeutique_code  AS code,
       sous_classe_therapeutique_libelle AS libelle,
       sous_classe_therapeutique_date_debut AS date_debut,
       utilisateur_id_creation
FROM
     tb_ref_medicaments_sous_classes_therapeutiques
WHERE
      			sous_classe_therapeutique_code LIKE ? AND 
      			sous_classe_therapeutique_date_fin IS NULL
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        return $a->fetch();
    }

    private function fermer_sous_classe_therapeutique($code, $date_fin, $user)
    {
        $a = $this->getBdd()->prepare("UPDATE tb_ref_medicaments_sous_classes_therapeutiques  SET classe_therapeutique_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE 	classe_therapeutique_code = ? AND 		classe_therapeutique_date_fin IS NULL");
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

    private function ajouter_sous_classe_therapeutique($code, $code_classe, $libelle, $user)
    {
        if(!$code) {
            $sous_classes_therapeutiques = $this->lister_sous_classes_therapeutiques(null);
            $nb_sous_classes_therapeutiques = count($sous_classes_therapeutiques);
            $code = 'SCL'.str_pad(intval($nb_sous_classes_therapeutiques + 1), 4,'0',STR_PAD_LEFT);
        }

        $a = $this->getBdd()->prepare("INSERT INTO tb_ref_medicaments_sous_classes_therapeutiques(classe_therapeutique_code,sous_classe_therapeutique_code, sous_classe_therapeutique_libelle, sous_classe_therapeutique_date_debut, utilisateur_id_creation)
        VALUES(:classe_therapeutique_code, :sous_classe_therapeutique_code, :sous_classe_therapeutique_libelle, :sous_classe_therapeutique_date_debut, :utilisateur_id_creation) 
        ");
        $a->execute(array(
            'classe_therapeutique_code' => $code_classe,
            'sous_classe_therapeutique_code' => $code,
            'sous_classe_therapeutique_libelle' => $libelle,
            'sous_classe_therapeutique_date_debut' => date('Y-m-d H:i:s', time()),
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

    public function lister_sous_classes_therapeutiques($code_classe)
    {
        $query = "
SELECT 
       classe_therapeutique_code  AS code_classe,
       sous_classe_therapeutique_code  AS code,
       sous_classe_therapeutique_libelle AS libelle,
       sous_classe_therapeutique_date_debut AS date_debut,
       utilisateur_id_creation
FROM
     tb_ref_medicaments_sous_classes_therapeutiques
WHERE 
      classe_therapeutique_code LIKE ?
      AND sous_classe_therapeutique_date_fin IS NULL
ORDER BY sous_classe_therapeutique_libelle
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array('%'.$code_classe.'%'));
        return $a->fetchAll();
    }

    public function editer_forme_administration($code, $libelle, $user)
    {
        $forme_administrations = $this->trouver_forme_administration($code);
        if ($forme_administrations) {
            $date_fin = date('Y-m-d', strtotime('-1 day', time()));
            if (strtotime($date_fin) > strtotime($forme_administrations['date_debut'])) {
                $edition = $this->fermer_forme_administration($forme_administrations['code'], $date_fin, $user);
                if ($edition['success'] == true) {
                    $json = $this->ajouter_forme_administration($code, $libelle, $user);
                } else {
                    $json = $edition;
                }
            } else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le " . date('d/m/Y', strtotime('+2 day', strtotime($forme_administrations['date_debut'])))
                );
            }
        } else {
            $json = $this->ajouter_forme_administration($code, $libelle, $user);
        }
        return $json;
    }

    public function trouver_forme_administration($code)
    {
        $query = "
SELECT 
       			forme_administration_code  AS code,
       			forme_administration_libelle AS libelle,
       			forme_administration_date_debut AS date_debut,
       utilisateur_id_creation
FROM
     tb_ref_medicaments_formes_administrations
WHERE
      			forme_administration_code LIKE ? AND 
      			forme_administration_date_fin IS NULL
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        return $a->fetch();
    }

    private function fermer_forme_administration($code, $date_fin, $user)
    {
        $a = $this->getBdd()->prepare("UPDATE tb_ref_medicaments_formes_administrations  SET forme_administration_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE 	forme_administration_code = ? AND 		forme_administration_date_fin IS NULL");
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

    private function ajouter_forme_administration($code, $libelle, $user)
    {
        if (!$code) {
            $formes_administrations = $this->lister_formes_administrations();
            $nb_formes_administrations = count($formes_administrations);
            $code = 'FAD'.str_pad(intval($nb_formes_administrations + 1), 4,'0',STR_PAD_LEFT);
        }

        $a = $this->getBdd()->prepare("INSERT INTO tb_ref_medicaments_formes_administrations(forme_administration_code,forme_administration_libelle,forme_administration_date_debut,utilisateur_id_creation)
        VALUES(:forme_administration_code,:forme_administration_libelle,:forme_administration_date_debut,:utilisateur_id_creation) 
        ");
        $a->execute(array(
            'forme_administration_code' => $code,
            'forme_administration_libelle' => $libelle,
            'forme_administration_date_debut' => date('Y-m-d H:i:s', time()),
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

    public function lister_formes_administrations()
    {
        $query = "
SELECT 
        	
       			forme_administration_code  AS code,
       			forme_administration_libelle AS libelle,
       			forme_administration_date_debut AS date_debut,
                utilisateur_id_creation
FROM
     tb_ref_medicaments_formes_administrations
WHERE 
      forme_administration_date_fin IS NULL
ORDER BY forme_administration_libelle
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array());
        return $a->fetchAll();
    }

    public function editer_unite_dosage($code, $libelle, $user)
    {
        $unite_dosage = $this->trouver_unite_dosage($code);
        if ($unite_dosage) {
            $date_fin = date('Y-m-d', strtotime('-1 day', time()));
            if (strtotime($date_fin) > strtotime($unite_dosage['date_debut'])) {
                $edition = $this->fermer_unite_dosage($unite_dosage['code'], $date_fin, $user);
                if ($edition['success'] == true) {
                    $json = $this->ajouter_unite_dosage($code, $libelle, $user);
                } else {
                    $json = $edition;
                }
            } else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le " . date('d/m/Y', strtotime('+2 day', strtotime($unite_dosage['date_debut'])))
                );
            }
        } else {
            $json = $this->ajouter_unite_dosage($code, $libelle, $user);
        }
        return $json;
    }

    public function trouver_unite_dosage($code)
    {
        $query = "
SELECT 
       			unite_dosage_code  AS code,
       			unite_dosage_libelle AS libelle,
       			unite_dosage_date_debut AS date_debut,
       utilisateur_id_creation
FROM
     tb_ref_medicaments_unites_de_dosage
WHERE
      			unite_dosage_code LIKE ? AND 
      			unite_dosage_date_fin IS NULL
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        return $a->fetch();
    }

    private function fermer_unite_dosage($code, $date_fin, $user)
    {
        $a = $this->getBdd()->prepare("UPDATE tb_ref_medicaments_unites_de_dosage  SET 	unite_dosage_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE 		unite_dosage_code = ? AND 	unite_dosage_date_fin IS NULL");
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

    private function ajouter_unite_dosage($code, $libelle, $user)
    {
        $a = $this->getBdd()->prepare("INSERT INTO tb_ref_medicaments_unites_de_dosage(unite_dosage_code,unite_dosage_libelle,unite_dosage_date_debut,utilisateur_id_creation)
        VALUES(:unite_dosage_code,:unite_dosage_libelle,:unite_dosage_date_debut,:utilisateur_id_creation) 
        ");
        $a->execute(array(
            'unite_dosage_code' => $code,
            'unite_dosage_libelle' => $libelle,
            'unite_dosage_date_debut' => date('Y-m-d H:i:s', time()),
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

    public function editer_dci($code_sous_groupe, $code_sous_classe, $code, $libelle, $code_forme, $user)
    {
        $dci = $this->trouver_dci($code);
        if ($dci) {
            $date_fin = date('Y-m-d', strtotime('-1 day', time()));
            if (strtotime($date_fin) > strtotime($dci['date_debut'])) {
                $edition = $this->fermer_dci($dci['code'], $date_fin, $user);
                if ($edition['success'] == true) {
                    $json = $this->ajouter_dci($code_sous_groupe, $code_sous_classe, $code, $libelle, $code_forme, $user);
                } else {
                    $json = $edition;
                }
            } else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le " . date('d/m/Y', strtotime('+2 day', strtotime($dci['date_debut'])))
                );
            }
        } else {
            $json = $this->ajouter_dci($code_sous_groupe, $code_sous_classe, $code, $libelle, $code_forme, $user);
        }
        return $json;
    }

    public function trouver_dci($code)
    {
        $query = "
SELECT
       A.dci_code  AS code,
       B.groupe_code  AS code_groupe,
       C.groupe_libelle  AS libelle_groupe,
       A.sous_groupe_code  AS code_sous_groupe,
       B.sous_groupe_libelle  AS libelle_sous_groupe,
       D.classe_therapeutique_code AS code_classe,
       E.classe_therapeutique_libelle AS libelle_classe,
       A.sous_classe_therapeutique_code AS code_sous_classe,
       D.sous_classe_therapeutique_libelle AS libelle_sous_classe,
       A.forme_code  AS code_forme,
       F.forme_libelle  AS libelle_forme,
       A.dci_libelle AS libelle,
       A.dci_date_debut AS date_debut,
       A.utilisateur_id_creation
FROM
     tb_ref_medicaments_dci A 
         JOIN tb_ref_medicaments_sous_groupes B 
             ON A.sous_groupe_code = B.sous_groupe_code 
         JOIN tb_ref_medicaments_groupes C 
             ON B.groupe_code = C.groupe_code 
         JOIN tb_ref_medicaments_sous_classes_therapeutiques D 
             ON A.sous_classe_therapeutique_code = D.sous_classe_therapeutique_code 
         JOIN tb_ref_medicaments_classes_therapeutiques E 
             ON D.classe_therapeutique_code = E.classe_therapeutique_code 
         JOIN tb_ref_medicaments_formes F 
             ON F.forme_code = A.forme_code
                    AND A.dci_code LIKE ? 
                    AND A.dci_date_fin IS NULL
                    AND B.sous_groupe_date_fin IS NULL
                    AND C.groupe_date_fin IS NULL
                    AND D.sous_classe_therapeutique_date_fin IS NULL
                    AND E.classe_therapeutique_date_fin IS NULL
                    AND F.forme_date_fin IS NULL
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        return $a->fetch();
    }

    private function fermer_dci($code, $date_fin, $user)
    {
        $a = $this->getBdd()->prepare("UPDATE tb_ref_medicaments_dci SET dci_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE dci_code = ? AND dci_date_fin IS NULL");
        $a->execute(array($date_fin, date('Y-m-d H:i:s', time()), $user, $code));
        if ($a->errorCode() == "00000") {
            $b = $this->getBdd()->prepare("UPDATE tb_ref_medicaments_dci_dosages SET dci_dosage_date_fin = ? date_edition = ?, utilisateur_id_edition = ? WHERE dci_code = ? AND dci_dosage_date_fin IS NULL");
            $b->execute(array($date_fin, date('Y-m-d H:i:s', time()), $user, $code));
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

    private function ajouter_dci($code_sous_groupe, $code_sous_classe, $code, $libelle, $code_forme, $user)
    {
        if(!$code) {
            $dcis = $this->lister_dci();
            $nb_dcis = count($dcis);
            $code = substr($code_sous_groupe, 3, 4).substr($code_sous_classe, 3, 4).substr($code_forme, 3, 4).str_pad(intval($nb_dcis + 1), 4,'0',STR_PAD_LEFT);
        }
        $a = $this->getBdd()->prepare("INSERT INTO tb_ref_medicaments_dci(dci_code, sous_groupe_code, sous_classe_therapeutique_code, forme_code, dci_libelle, dci_date_debut, utilisateur_id_creation)
        VALUES(:dci_code, :sous_groupe_code, :sous_classe_therapeutique_code, :forme_code, :dci_libelle, :dci_date_debut, :utilisateur_id_creation) 
        ");
        $a->execute(array(
            'dci_code' => $code,
            'sous_groupe_code' => $code_sous_groupe,
            'sous_classe_therapeutique_code' => $code_sous_classe,
            'forme_code' => $code_forme,
            'dci_libelle' => $libelle,
            'dci_date_debut' => date('Y-m-d H:i:s', time()),
            'utilisateur_id_creation' => $user
        ));
        if ($a->errorCode() == "00000") {
            return array(
                "success" => true,
                'code' => $code,
                "message" => 'Enregistrement effectué avec succès'
            );
        } else {
            return array(
                "success" => false,
                "message" => $a->errorInfo()
            );
        }
    }

    public function lister_dci()
    {
        $query = "
SELECT 
       sous_groupe_code  AS code_sous_groupe,
       sous_classe_therapeutique_code  AS code_sous_classe_therapeutique,
       dci_code  AS code,
       forme_code  AS code_forme,
       dci_libelle AS libelle,
       dci_date_debut AS date_debut,
       utilisateur_id_creation
FROM
     tb_ref_medicaments_dci
WHERE dci_date_fin IS NULL
ORDER BY dci_libelle
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array());
        return $a->fetchAll();
    }

    public function lister_dci_dosages($code_dci) {
        $a = $this->getBdd()->prepare("SELECT dci_code AS code_dci, dci_dosage AS dosage, unite_dosage_code AS unite, dci_dosage_date_debut AS date_debut, date_creation, utilisateur_id_creation FROM tb_ref_medicaments_dci_dosages WHERE dci_code = ? AND dci_dosage_date_fin IS NULL");
        $a->execute(array($code_dci));
        return $a->fetchAll();
    }

    public function editer_dci_dosage($code_dci, $dosage, $code_unite, $user): array
    {
        $a = $this->getBdd()->prepare("INSERT INTO tb_ref_medicaments_dci_dosages(dci_code, dci_dosage, unite_dosage_code, dci_dosage_date_debut, utilisateur_id_creation) VALUES(:dci_code, :dci_dosage, :unite_dosage_code, :dci_dosage_date_debut, :utilisateur_id_creation)");
        $a->execute(array(
            'dci_code' => $code_dci,
            'dci_dosage' => $dosage,
            'unite_dosage_code' => $code_unite,
            'dci_dosage_date_debut' => date('Y-m-d',time()),
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

    public function editer($code_dci, $code, $code_ean13, $code_presentation_primaire, $code_presentation_secondaire, $code_laboratoire, $code_type, $libelle, $user): array
    {
        $medicament = $this->trouver($code);
        if ($medicament) {
            $date_fin = date('Y-m-d', strtotime('-1 day', time()));
            if (strtotime($date_fin) > strtotime($medicament['date_debut'])) {
                $edition = $this->fermer($medicament['code'], $date_fin, $user);
                if ($edition['success'] == true) {
                    $json = $this->ajouter($code_dci, $code, $code_ean13, $code_presentation_primaire, $code_presentation_secondaire, $code_laboratoire, $code_type, $libelle, $user);
                } else {
                    $json = $edition;
                }
            } else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le " . date('d/m/Y', strtotime('+2 day', strtotime($medicament['date_debut'])))
                );
            }
        } else {
            $json = $this->ajouter($code_dci, $code, $code_ean13, $code_presentation_primaire, $code_presentation_secondaire, $code_laboratoire, $code_type, $libelle, $user);
        }
        return $json;
    }

    public function trouver($code)
    {
        $query = "
SELECT 
       A.dci_code AS code_dci,
       B.dci_libelle AS libelle_dci,
       A.medicament_code  AS code,
       A.medicament_code_ean_13 AS code_ean13,
       A.primaire_presentation_code AS code_presentation_primaire,
       C.presentation_libelle AS libelle_presentation_primaire,
       A.secondaire_presentation_code AS code_presentation_secondaire,
       D.presentation_libelle AS libelle_presentation_secondaire,
       A.laboratoire_code AS code_laboratoire,
       E.laboratoire_libelle AS libelle_laboratoire,
       A.type_medicament_code AS code_type,
       F.type_medicament_libelle AS libelle_type,
       A.medicament_libelle AS libelle,
       A.medicament_date_debut AS date_debut,
       A.date_creation,
       A.utilisateur_id_creation
FROM
     tb_ref_medicaments A 
         JOIN tb_ref_medicaments_dci B 
             ON A.dci_code = B.dci_code 
         JOIN tb_ref_medicaments_presentations C 
             ON A.primaire_presentation_code = C.presentation_code 
         JOIN tb_ref_medicaments_presentations D 
             ON A.secondaire_presentation_code = D.presentation_code 
         JOIN tb_ref_medicaments_laboratoires_pharmaceutiques E 
             ON A.laboratoire_code = E.laboratoire_code 
         JOIN tb_ref_medicaments_types F 
             ON A.type_medicament_code = F.type_medicament_code
                    AND A.medicament_date_fin IS NULL
                    AND B.dci_date_fin IS NULL
                    AND C.presentation_date_fin IS NULL
                    AND D.presentation_date_fin IS NULL
                    AND E.laboratoire_date_fin IS NULL
                    AND F.type_medicament_date_fin IS NULL
                    AND A.medicament_code = ?
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        return $a->fetch();
    }

    private function fermer($code, $date_fin, $user): array
    {
        $a = $this->getBdd()->prepare("UPDATE tb_ref_medicaments SET medicament_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE medicament_code = ? AND medicament_date_fin IS NULL");
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

    private function ajouter($code_dci, $code, $code_ean13, $code_presentation_primaire, $code_presentation_secondaire, $code_laboratoire, $code_type, $libelle, $user): array
    {
        if(!$code) {
            $dcis = $this->lister($code_dci, null);
            $nb_dcis = count($dcis);
            $code = $code_dci.str_pad(intval($nb_dcis + 1), 4,'0',STR_PAD_LEFT);
        }
        $a = $this->getBdd()->prepare("INSERT INTO tb_ref_medicaments(dci_code, medicament_code, medicament_code_ean_13, primaire_presentation_code, secondaire_presentation_code, laboratoire_code, type_medicament_code, medicament_libelle, medicament_date_debut, utilisateur_id_creation)
        VALUES(:dci_code, :medicament_code, :medicament_code_ean_13, :primaire_presentation_code, :secondaire_presentation_code, :laboratoire_code, :type_medicament_code, :medicament_libelle, :medicament_date_debut, :utilisateur_id_creation) 
        ");
        $a->execute(array(
            'dci_code' => $code_dci,
            'medicament_code' => $code,
            'medicament_code_ean_13' => $code_ean13,
            'primaire_presentation_code' => $code_presentation_primaire,
            'secondaire_presentation_code' => $code_presentation_secondaire,
            'laboratoire_code' => $code_laboratoire,
            'type_medicament_code' => $code_type,
            'medicament_libelle' => $libelle,
            'medicament_date_debut' => date('Y-m-d',time()),
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

    public function lister($code_dci, $libelle)
    {
        $query = "
SELECT 
       A.dci_code AS code_dci,
       B.dci_libelle AS libelle_dci,
       A.medicament_code  AS code,
       A.medicament_code_ean_13 AS code_ean13,
       A.primaire_presentation_code AS code_presentation_primaire,
       C.presentation_libelle AS libelle_presentation_primaire,
       A.secondaire_presentation_code AS code_presentation_secondaire,
       D.presentation_libelle AS libelle_presentation_secondaire,
       A.laboratoire_code AS code_laboratoire,
       E.laboratoire_libelle AS libelle_laboratoire,
       A.type_medicament_code AS code_type,
       F.type_medicament_libelle AS libelle_type,
       A.medicament_libelle AS libelle,
       A.medicament_date_debut AS date_debut,
       A.date_creation,
       A.utilisateur_id_creation
FROM
     tb_ref_medicaments A 
         JOIN tb_ref_medicaments_dci B 
             ON A.dci_code = B.dci_code 
         JOIN tb_ref_medicaments_presentations C 
             ON A.primaire_presentation_code = C.presentation_code 
         JOIN tb_ref_medicaments_presentations D 
             ON A.secondaire_presentation_code = D.presentation_code 
         JOIN tb_ref_medicaments_laboratoires_pharmaceutiques E 
             ON A.laboratoire_code = E.laboratoire_code 
         JOIN tb_ref_medicaments_types F 
             ON A.type_medicament_code = F.type_medicament_code
                    AND A.medicament_date_fin IS NULL
                    AND B.dci_date_fin IS NULL
                    AND C.presentation_date_fin IS NULL
                    AND D.presentation_date_fin IS NULL
                    AND E.laboratoire_date_fin IS NULL
                    AND F.type_medicament_date_fin IS NULL
                    AND A.dci_code LIKE ?
                    AND (A.medicament_libelle LIKE ? OR B.dci_libelle LIKE ?)
ORDER BY A.medicament_libelle
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array('%'.$code_dci.'%', '%'.$libelle.'%', '%'.$libelle.'%'));
        return $a->fetchAll();
    }

    public function trouver_notice($code) {
        $a = $this->getBdd()->prepare("SELECT medicament_code AS code, medicament_indications AS indications, medicament_comment_prendre AS comment_prendre, medicament_effets_indesirables AS effets_indesirables, medicament_contre_indications AS contre_indications, medicament_precautions_emploi AS precautions_emploi, medicament_interactions_medicamenteuses AS interactions_medicamenteuses, medicament_surdosage AS surdosage, medicament_grossesse_allaitement AS grossesse_allaitement, medicament_aspect_forme AS aspect_forme, medicament_composition AS composition, medicament_mecanisme_action AS mecanisme_action, medicament_autres_informations AS autres_informations, medicament_date_debut AS date_debut, date_creation, utilisateur_id_creation FROM tb_ref_medicaments_notices WHERE medicament_code = ? AND medicament_date_fin IS NULL");
        $a->execute(array($code));
        return $a->fetch();
    }

    public function lister_familles_formes()
    {
        $query = "
SELECT 
        	famille_code  AS code,
       	famille_libelle AS libelle,
       	famille_date_debut AS date_debut,
       utilisateur_id_creation
FROM
     tb_ref_medicaments_familles_formes
WHERE 
      famille_date_fin IS NULL
ORDER BY famille_libelle
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array());
        return $a->fetchAll();
    }

    public function lister_unites_dosages()
    {
        $query = "
SELECT 
        	
       			unite_dosage_code  AS code,
       			unite_dosage_libelle AS libelle,
       			unite_dosage_date_debut AS date_debut,
                utilisateur_id_creation
FROM
     tb_ref_medicaments_unites_de_dosage
WHERE 
      unite_dosage_date_fin IS NULL
ORDER BY unite_dosage_libelle
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array());
        return $a->fetchAll();
    }

    public function lister_historique_dci($code)
    {
        $query = "
SELECT 
       A.dci_code    AS code, 
       A.unite_dosage_code    AS code_unite, 
       A.forme_code    AS code_forme, 
       A.dci_libelle AS libelle, 
       B.utilisateur_nom AS nom,
       B.utilisateur_prenoms AS prenoms, 
       A.dci_date_debut AS date_debut, 
       A.dci_date_fin AS date_fin, 
       A.date_creation, 
       A.utilisateur_id_creation
FROM 
     tb_ref_medicaments_dci A JOIN tb_utilisateurs B 
         ON 
             A.utilisateur_id_creation = B.utilisateur_id AND A.dci_code  LIKE ?
ORDER BY 
         A.date_creation DESC
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        return $a->fetchAll();
    }

    public function lister_historique_laboratoires_pharmaceutiques($code)
    {
        $query = "
SELECT 
       A.laboratoire_code AS code, 
       A.laboratoire_libelle AS libelle, 
       B.utilisateur_nom AS nom,
       B.utilisateur_prenoms AS prenoms, 
       A.laboratoire_date_debut AS date_debut, 
       A.laboratoire_date_fin AS date_fin, 
       A.date_creation, 
       A.utilisateur_id_creation
FROM 
     tb_ref_medicaments_laboratoires_pharmaceutiques A JOIN tb_utilisateurs B 
         ON 
             A.utilisateur_id_creation = B.utilisateur_id AND A.laboratoire_code LIKE ?
ORDER BY 
         A.date_creation DESC
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        return $a->fetchAll();
    }

    public function lister_historique_presentation($code)
    {
        $query = "
SELECT 
       A.presentation_code  AS code, 
       A.presentation_libelle AS libelle, 
       B.utilisateur_nom AS nom,
       B.utilisateur_prenoms AS prenoms, 
       A.presentation_date_debut AS date_debut, 
       A.presentation_date_fin AS date_fin, 
       A.date_creation, 
       A.utilisateur_id_creation
FROM 
     tb_ref_medicaments_presentations A JOIN tb_utilisateurs B 
         ON 
             A.utilisateur_id_creation = B.utilisateur_id AND A.presentation_code LIKE ?
ORDER BY 
         A.date_creation DESC
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        return $a->fetchAll();
    }

    public function lister_historique_famille_forme($code)
    {
        $query = "
SELECT 
       A.famille_code   AS code, 
       A.famille_libelle AS libelle, 
       B.utilisateur_nom AS nom,
       B.utilisateur_prenoms AS prenoms, 
       A.famille_date_debut AS date_debut, 
       A.famille_date_fin AS date_fin, 
       A.date_creation, 
       A.utilisateur_id_creation
FROM 
     tb_ref_medicaments_familles_formes A JOIN tb_utilisateurs B 
         ON 
             A.utilisateur_id_creation = B.utilisateur_id AND A.famille_code LIKE ?
ORDER BY 
         A.date_creation DESC
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        return $a->fetchAll();
    }

    public function lister_historique_medicament($code)
    {
        $query = "
SELECT 
                A.medicament_code  AS code,
       			A.medicament_libelle  AS libelle,
       			A.medicament_date_debut AS date_debut,
               B.utilisateur_nom AS nom,
               B.utilisateur_prenoms AS prenoms,  
               A.medicament_date_fin AS date_fin, 
               A.date_creation, 
               A.utilisateur_id_creation
FROM 
     tb_ref_medicaments A JOIN tb_utilisateurs B 
         ON 
             A.utilisateur_id_creation = B.utilisateur_id AND A.medicament_code LIKE ?
ORDER BY 
         A.date_creation DESC
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        return $a->fetchAll();
    }

    public function lister_historique_forme($code)
    {
        $query = "
SELECT 
       A.forme_code   AS code, 
       A.forme_libelle AS libelle, 
       B.utilisateur_nom AS nom,
       B.utilisateur_prenoms AS prenoms, 
       A.forme_date_debut AS date_debut, 
       A.forme_date_fin AS date_fin, 
       A.date_creation, 
       A.utilisateur_id_creation
FROM 
     tb_ref_medicaments_formes A JOIN tb_utilisateurs B 
         ON 
             A.utilisateur_id_creation = B.utilisateur_id AND A.forme_code LIKE ?
ORDER BY 
         A.date_creation DESC
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        return $a->fetchAll();
    }

    public function lister_historique_type($code)
    {
        $query = "
SELECT 
       A.type_medicament_code   AS code, 
       A.type_medicament_libelle AS libelle, 
       B.utilisateur_nom AS nom,
       B.utilisateur_prenoms AS prenoms, 
       A.type_medicament_date_debut AS date_debut, 
       A.type_medicament_date_fin AS date_fin, 
       A.date_creation, 
       A.utilisateur_id_creation
FROM 
     tb_ref_medicaments_types A JOIN tb_utilisateurs B 
         ON 
             A.utilisateur_id_creation = B.utilisateur_id AND A.type_medicament_code LIKE ?
ORDER BY 
         A.date_creation DESC
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        return $a->fetchAll();
    }

    public function lister_historique_sous_classe_therapeutique($code)
    {
        $query = "
SELECT 
       A.classe_therapeutique_code   AS code, 
       A.classe_therapeutique_libelle AS libelle, 
       B.utilisateur_nom AS nom,
       B.utilisateur_prenoms AS prenoms, 
       A.classe_therapeutique_date_debut AS date_debut, 
       A.classe_therapeutique_date_fin AS date_fin, 
       A.date_creation, 
       A.utilisateur_id_creation
FROM 
     tb_ref_medicaments_classes_therapeutiques A JOIN tb_utilisateurs B 
         ON 
             A.utilisateur_id_creation = B.utilisateur_id AND A.classe_therapeutique_code LIKE ?
ORDER BY 
         A.date_creation DESC
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        return $a->fetchAll();
    }

    public function lister_historique_forme_administration($code)
    {
        $query = "
SELECT 
       A.forme_administration_code    AS code, 
       A.forme_administration_libelle AS libelle, 
       B.utilisateur_nom AS nom,
       B.utilisateur_prenoms AS prenoms, 
       A.forme_administration_date_debut AS date_debut, 
       A.forme_administration_date_fin AS date_fin, 
       A.date_creation, 
       A.utilisateur_id_creation
FROM 
     tb_ref_medicaments_formes_administrations A JOIN tb_utilisateurs B 
         ON 
             A.utilisateur_id_creation = B.utilisateur_id AND A.forme_administration_code  LIKE ?
ORDER BY 
         A.date_creation DESC
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        return $a->fetchAll();
    }

    public function lister_historique_unite_dosage($code)
    {
        $query = "
SELECT 
       A.unite_dosage_code    AS code, 
       A.unite_dosage_libelle AS libelle, 
       B.utilisateur_nom AS nom,
       B.utilisateur_prenoms AS prenoms, 
       A.unite_dosage_date_debut AS date_debut, 
       A.unite_dosage_date_fin AS date_fin, 
       A.date_creation, 
       A.utilisateur_id_creation
FROM 
     tb_ref_medicaments_unites_de_dosage A JOIN tb_utilisateurs B 
         ON 
             A.utilisateur_id_creation = B.utilisateur_id AND A.unite_dosage_code  LIKE ?
ORDER BY 
         A.date_creation DESC
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        return $a->fetchAll();
    }

    public function editer_groupe($code, $libelle, $user)
    {
        $groupes = $this->trouver_groupe($code);
        if ($groupes) {
            $date_fin = date('Y-m-d', strtotime('-1 day', time()));
            if (strtotime($date_fin) > strtotime($groupes['date_debut'])) {
                $edition = $this->fermer_groupe($groupes['code'], $date_fin, $user);
                if ($edition['success'] == true) {
                    $json = $this->ajouter_groupe($code, $libelle, $user);
                } else {
                    $json = $edition;
                }
            } else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le " . date('d/m/Y', strtotime('+2 day', strtotime($groupes['date_debut'])))
                );
            }
        } else {
            $json = $this->ajouter_groupe($code, $libelle, $user);
        }
        return $json;
    }

    public function trouver_groupe($code)
    {
        $query = "
SELECT 
       		groupe_code  AS code,
       		groupe_libelle AS libelle,
       		groupe_date_debut AS date_debut,
       utilisateur_id_creation
FROM
     tb_ref_medicaments_groupes
WHERE
      		groupe_code LIKE ? AND 
      		groupe_date_fin IS NULL
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        return $a->fetch();
    }

    private function fermer_groupe($code, $date_fin, $user)
    {
        $a = $this->getBdd()->prepare("UPDATE tb_ref_medicaments_groupes  SET 	groupe_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE 		groupe_code = ? AND 		groupe_date_fin IS NULL");
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

    private function ajouter_groupe($code, $libelle, $user)
    {
        if(!$code) {
            $groupes = $this->lister_groupes();
            $nb_groupes = count($groupes);
            $code = 'GRP'.str_pad(intval($nb_groupes + 1), 4,'0',STR_PAD_LEFT);
        }

        $a = $this->getBdd()->prepare("INSERT INTO tb_ref_medicaments_groupes(groupe_code,groupe_libelle,groupe_date_debut,utilisateur_id_creation)
        VALUES(:groupe_code,:groupe_libelle,:groupe_date_debut,:utilisateur_id_creation) 
        ");
        $a->execute(array(
            'groupe_code' => $code,
            'groupe_libelle' => $libelle,
            'groupe_date_debut' => date('Y-m-d H:i:s', time()),
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

    public function lister_groupes()
    {
        $query = "
SELECT 
        	groupe_code  AS code,
       		groupe_libelle AS libelle,
       		groupe_date_debut AS date_debut,
       utilisateur_id_creation
FROM
     tb_ref_medicaments_groupes
WHERE 
      groupe_date_fin IS NULL
ORDER BY groupe_libelle
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array());
        return $a->fetchAll();
    }

    public function editer_sous_groupe($code_groupe, $code, $libelle, $user)
    {
        $sous_groupes = $this->trouver_sous_groupe($code);
        if ($sous_groupes) {
            $date_fin = date('Y-m-d', strtotime('-1 day', time()));
            if (strtotime($date_fin) > strtotime($sous_groupes['date_debut'])) {
                $edition = $this->fermer_sous_groupe($sous_groupes['code'], $date_fin, $user);
                if ($edition['success'] == true) {
                    $json = $this->ajouter_sous_groupe($code, $code_groupe, $libelle, $user);
                } else {
                    $json = $edition;
                }
            } else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le " . date('d/m/Y', strtotime('+2 day', strtotime($sous_groupes['date_debut'])))
                );
            }
        } else {
            $json = $this->ajouter_sous_groupe($code, $code_groupe, $libelle, $user);
        }
        return $json;
    }

    public function trouver_sous_groupe($code)
    {
        $query = "
SELECT
       groupe_code  AS code_groupe,
       sous_groupe_code  AS code,
       sous_groupe_libelle AS libelle,
       sous_groupe_date_debut AS date_debut,
       utilisateur_id_creation
FROM
     tb_ref_medicaments_sous_groupes
WHERE
      		sous_groupe_code LIKE ? AND 
      		sous_groupe_date_fin IS NULL
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        return $a->fetch();
    }

    private function fermer_sous_groupe($code, $date_fin, $user)
    {
        $a = $this->getBdd()->prepare("UPDATE tb_ref_medicaments_sous_groupes  SET 	sous_groupe_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE 		sous_groupe_code = ? AND 		sous_groupe_date_fin IS NULL");
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

    private function ajouter_sous_groupe($code, $code_groupe, $libelle, $user)
    {
        if(!$code) {
            $sous_groupes = $this->lister_sous_groupes(null);
            $nb_sous_groupes = count($sous_groupes);
            $code = 'SGR'.str_pad(intval($nb_sous_groupes + 1), 4,'0',STR_PAD_LEFT);
        }
        $a = $this->getBdd()->prepare("INSERT INTO tb_ref_medicaments_sous_groupes(groupe_code, sous_groupe_code, sous_groupe_libelle, sous_groupe_date_debut, utilisateur_id_creation)
        VALUES(:groupe_code, :sous_groupe_code, :sous_groupe_libelle, :sous_groupe_date_debut, :utilisateur_id_creation) 
        ");
        $a->execute(array(
            'groupe_code' => $code_groupe,
            'sous_groupe_code' => $code,
            'sous_groupe_libelle' => $libelle,
            'sous_groupe_date_debut' => date('Y-m-d H:i:s', time()),
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

    public function lister_sous_groupes($code_groupe)
    {
        $query = "
SELECT 
       groupe_code  AS code_groupe,
       sous_groupe_code  AS code,
       sous_groupe_libelle AS libelle,
       sous_groupe_date_debut AS date_debut,
       utilisateur_id_creation
FROM
     tb_ref_medicaments_sous_groupes
WHERE 
      groupe_code LIKE ?
      AND sous_groupe_date_fin IS NULL
ORDER BY sous_groupe_libelle
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array('%'.$code_groupe.'%'));
        return $a->fetchAll();
    }

}