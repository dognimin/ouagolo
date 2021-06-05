<?php


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
                'libelle' => "Présentations"
            ),
            array(
                'code' => "med_ffm",
                'libelle' => "Familles de forme"
            ),
            array(
                'code' => "med_frm",
                'libelle' => "Formes"
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

    private function ajouter_laboratoire_pharmaceutique($code, $libelle, $user)
    {
        $a = $this->bdd->prepare("INSERT INTO tb_ref_medicaments_laboratoires_pharmaceutiques(laboratoire_code,laboratoire_libelle,laboratoire_date_debut,utilisateur_id_creation)
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
    private function ajouter_presentation($code, $libelle, $user)
    {
        $a = $this->bdd->prepare("INSERT INTO tb_ref_medicaments_presentations(presentation_code ,presentation_libelle,presentation_date_debut,utilisateur_id_creation)
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
    private function ajouter_famille_forme($code, $libelle, $user)
    {
        $a = $this->bdd->prepare("INSERT INTO tb_ref_medicaments_familles_formes(famille_code,famille_libelle,famille_date_debut,utilisateur_id_creation)
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
    private function ajouter_forme($code, $libelle, $user)
    {
        $a = $this->bdd->prepare("INSERT INTO tb_ref_medicaments_formes(forme_code,forme_libelle,forme_date_debut,utilisateur_id_creation)
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
    private function ajouter_type_medicament($code, $libelle, $user)
    {
        $a = $this->bdd->prepare("INSERT INTO tb_ref_medicaments_types_medicaments(type_medicament_code,type_medicament_libelle,type_medicament_date_debut,utilisateur_id_creation)
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
    private function ajouter_classe_therapeutique($code, $libelle, $user)
    {
        $a = $this->bdd->prepare("INSERT INTO tb_ref_medicaments_classes_therapeutiques(classe_therapeutique_code,classe_therapeutique_libelle,classe_therapeutique_date_debut,utilisateur_id_creation)
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
    private function ajouter_forme_administration($code, $libelle, $user)
    {
        $a = $this->bdd->prepare("INSERT INTO tb_ref_medicaments_formes_administrations(forme_administration_code,forme_administration_libelle,forme_administration_date_debut,utilisateur_id_creation)
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
    private function ajouter_unite_dosage($code, $libelle, $user)
    {
        $a = $this->bdd->prepare("INSERT INTO tb_ref_medicaments_unites_de_dosage(unite_dosage_code,unite_dosage_libelle,unite_dosage_date_debut,utilisateur_id_creation)
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
    private function ajouter_medicament($code,$code_ean,$dci,$forme,$dosage,$unite_dosage,$presentation,$classe,$famille,$forme_administration,$laboratoire,$type_medicament,$libelle,$user)
    {
        $a = $this->bdd->prepare("INSERT INTO tb_ref_medicaments(medicament_code,medicament_code_ean_13,dci_code,forme_code,medicament_dosage,unite_dosage_code,presentation_code,classe_therapeutique_code,famille_code,forme_administration_code,laboratoire_code,type_medicament_code,medicament_libelle,medicament_date_debut,utilisateur_id_creation)
        VALUES(:medicament_code,:medicament_code_ean_13,:dci_code,:forme_code,:medicament_dosage,:unite_dosage_code,:presentation_code,:classe_therapeutique_code,:famille_code,:forme_administration_code,:laboratoire_code,:type_medicament_code,:medicament_libelle,:medicament_date_debut,:utilisateur_id_creation) 
        ");
        $a->execute(array(
            'medicament_code' => $code,
            'medicament_code_ean_13' => $code_ean,
            'dci_code' => $dci,
            'forme_code' => $forme,
            'medicament_dosage' => $dosage,
            'unite_dosage_code' => $unite_dosage,
            'presentation_code' => $presentation,
            'classe_therapeutique_code' => $classe,
            'famille_code' => $famille,
            'forme_administration_code' => $forme_administration,
            'laboratoire_code' => $laboratoire,
            'type_medicament_code' => $type_medicament,
            'medicament_libelle' => $libelle,
            'medicament_date_debut' => date('Y-m-d H:i:s', time()),
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
    private function ajouter_dci($code, $libelle,$forme,$dosage,$unite, $user)
    {
        $a = $this->bdd->prepare("INSERT INTO tb_ref_medicaments_dci(dci_code,forme_code,dci_dosage,unite_dosage_code,dci_libelle,dci_date_debut,utilisateur_id_creation)
        VALUES(:dci_code,:forme_code,:dci_dosage,:unite_dosage_code,:dci_libelle,:dci_date_debut,:utilisateur_id_creation) 
        ");
        $a->execute(array(
            'dci_code' => $code,
            'forme_code' => $forme,
            'dci_dosage' => $dosage,
            'unite_dosage_code' => $unite,
            'dci_libelle' => $libelle,
            'dci_date_debut' => date('Y-m-d H:i:s', time()),
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

    private function fermer_laboratoire_pharmaceutique($code, $date_fin, $user)
    {
        $a = $this->bdd->prepare("UPDATE tb_ref_medicaments_laboratoires_pharmaceutiques  SET 	laboratoire_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE 	laboratoire_code  = ? AND 	laboratoire_date_fin IS NULL");
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
    private function fermer_presentation($code, $date_fin, $user)
    {
        $a = $this->bdd->prepare("UPDATE tb_ref_medicaments_presentations  SET presentation_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE 	presentation_code = ? AND 	presentation_date_fin IS NULL");
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
    private function fermer_famille_forme($code, $date_fin, $user)
    {
        $a = $this->bdd->prepare("UPDATE tb_ref_medicaments_familles_formes  SET 	famille_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE 		famille_code = ? AND 		famille_date_fin IS NULL");
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
    private function fermer_forme($code, $date_fin, $user)
    {
        $a = $this->bdd->prepare("UPDATE tb_ref_medicaments_formes  SET 	forme_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE 		forme_code = ? AND 		forme_date_fin IS NULL");
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
    private function fermer_type_medicament($code, $date_fin, $user)
    {
        $a = $this->bdd->prepare("UPDATE tb_ref_medicaments_types_medicaments  SET 	type_medicament_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE 		type_medicament_code = ? AND 		type_medicament_date_fin IS NULL");
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
    private function fermer_classe_therapeutique($code, $date_fin, $user)
    {
        $a = $this->bdd->prepare("UPDATE tb_ref_medicaments_classes_therapeutiques  SET classe_therapeutique_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE 	classe_therapeutique_code = ? AND 		classe_therapeutique_date_fin IS NULL");
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
    private function fermer_medicaments($code, $date_fin, $user)
    {
        $a = $this->bdd->prepare("UPDATE tb_ref_medicaments  SET medicament_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE 	medicament_code = ? AND 		medicament_date_fin IS NULL");
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
    private function fermer_forme_administration($code, $date_fin, $user)
    {
        $a = $this->bdd->prepare("UPDATE tb_ref_medicaments_formes_administrations  SET forme_administration_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE 	forme_administration_code = ? AND 		forme_administration_date_fin IS NULL");
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
    private function fermer_unite_dosage($code, $date_fin, $user)
    {
        $a = $this->bdd->prepare("UPDATE tb_ref_medicaments_unites_de_dosage  SET 	unite_dosage_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE 		unite_dosage_code = ? AND 	unite_dosage_date_fin IS NULL");
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
    private function fermer_dci($code, $date_fin, $user)
    {
        $a = $this->bdd->prepare("UPDATE tb_ref_medicaments_dci  SET 	dci_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE 		dci_code = ? AND 	dci_date_fin IS NULL");
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
        $a = $this->bdd->prepare($query);
        $a->execute(array($code));
        return $a->fetch();
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
        $a = $this->bdd->prepare($query);
        $a->execute(array($code));
        return $a->fetch();
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
        $a = $this->bdd->prepare($query);
        $a->execute(array($code));
        return $a->fetch();
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
        $a = $this->bdd->prepare($query);
        $a->execute(array($code));
        return $a->fetch();
    }
    public function trouver_type_medicament($code)
    {
        $query = "
SELECT 
       			type_medicament_code  AS code,
       			type_medicament_libelle AS libelle,
       			type_medicament_date_debut AS date_debut,
       utilisateur_id_creation
FROM
     tb_ref_medicaments_types_medicaments
WHERE
      			type_medicament_code LIKE ? AND 
      			type_medicament_date_fin IS NULL
        ";
        $a = $this->bdd->prepare($query);
        $a->execute(array($code));
        return $a->fetch();
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
        $a = $this->bdd->prepare($query);
        $a->execute(array($code));
        return $a->fetch();
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
        $a = $this->bdd->prepare($query);
        $a->execute(array($code));
        return $a->fetch();
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
        $a = $this->bdd->prepare($query);
        $a->execute(array($code));
        return $a->fetch();
    }
    public function trouver_dci($code)
    {
        $query = "
SELECT 
       			dci_code  AS code,
       			forme_code  AS code_forme,
       			unite_dosage_code  AS code_unite,
       			dci_libelle AS libelle,
       			dci_date_debut AS date_debut,
                utilisateur_id_creation
FROM
     tb_ref_medicaments_dci
WHERE
      			dci_code LIKE ? AND 
      			dci_date_fin IS NULL
        ";
        $a = $this->bdd->prepare($query);
        $a->execute(array($code));
        return $a->fetch();
    }
    public function trouver_mediacment($code)
    {
        $query = "
SELECT 
       			medicament_code  AS code,
       			medicament_code_ean_13  AS code_ean13,
       			dci_code  AS code_dci,
       			forme_code  AS code_forme,
       			unite_dosage_code  AS code_unite_dosage,
       			presentation_code  AS code_presentation,
       			classe_therapeutique_code  AS code_classe_therapeutique,
       			classe_therapeutique_code  AS code_classe_therapeutique,
       			famille_code  AS code_famille,
       			forme_administration_code  AS code_forme_administration,
       			laboratoire_code  AS code_laboratoire,
       			type_medicament_code  AS code_type_medicament,
       			medicament_libelle  AS libelle,
       			medicament_date_debut AS date_debut,
                utilisateur_id_creation
FROM
     tb_ref_medicaments
WHERE
      			medicament_code LIKE ? AND 
      			medicament_date_fin IS NULL
        ";
        $a = $this->bdd->prepare($query);
        $a->execute(array($code));
        return $a->fetch();
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
    public function editer_type_medicament($code, $libelle, $user)
    {
        $types_medicaments = $this->trouver_type_medicament($code);
        if ($types_medicaments) {
            $date_fin = date('Y-m-d', strtotime('-1 day', time()));
            if (strtotime($date_fin) > strtotime($types_medicaments['date_debut'])) {
                $edition = $this->fermer_type_medicament($types_medicaments['code'], $date_fin, $user);
                if ($edition['success'] == true) {
                    $json = $this->ajouter_type_medicament($code, $libelle, $user);
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
            $json = $this->ajouter_type_medicament($code, $libelle, $user);
        }
        return $json;
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
    public function editer_dci($code,$libelle,$forme,$dosage,$unite, $user)
    {
        $dci = $this->trouver_dci($code);
        if ($dci) {
            $date_fin = date('Y-m-d', strtotime('-1 day', time()));
            if (strtotime($date_fin) > strtotime($dci['date_debut'])) {
                $edition = $this->fermer_dci($dci['code'], $date_fin, $user);
                if ($edition['success'] == true) {
                    $json = $this->ajouter_dci($code, $libelle,$forme,$dosage,$unite, $user);
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
            $json = $this->ajouter_dci($code, $libelle,$forme,$dosage,$unite, $user);
        }
        return $json;
    }
    public function editer_medicaments($code,$code_ean,$dci,$forme,$dosage,$unite_dosage,$presentation,$classe,$famille,$forme_administration,$laboratoire,$type_medicament,$libelle,$user)
    {
        $medicament = $this->trouver_mediacment($code);
        if ($medicament) {
            $date_fin = date('Y-m-d', strtotime('-1 day', time()));
            if (strtotime($date_fin) > strtotime($medicament['date_debut'])) {
                $edition = $this->fermer_medicaments($medicament['code'], $date_fin, $user);
                if ($edition['success'] == true) {
                    $json = $this->ajouter_medicament($code,$code_ean,$dci,$forme,$dosage,$unite_dosage,$presentation,$classe,$famille,$forme_administration,$laboratoire,$type_medicament,$libelle,$user);
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
            $json = $this->ajouter_medicament($code,$code_ean,$dci,$forme,$dosage,$unite_dosage,$presentation,$classe,$famille,$forme_administration,$laboratoire,$type_medicament,$libelle,$user);
        }
        return $json;
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
        $a = $this->bdd->prepare($query);
        $a->execute(array());
        return $a->fetchAll();
    }
    public function lister_medicaments()
    {
        $query = "
SELECT 
     medicament_code  AS code,
       			medicament_code_ean_13  AS code_ean13,
       			dci_code  AS code_dci,
       			forme_code  AS code_forme,
       			medicament_dosage  AS dosage,
       			unite_dosage_code  AS code_unite_dosage,
       			presentation_code  AS code_presentation,
       			classe_therapeutique_code  AS code_classe_therapeutique,
       			famille_code  AS code_famille,
       			forme_administration_code  AS code_forme_administration,
       			laboratoire_code  AS code_laboratoire,
       			type_medicament_code  AS code_type_medicament,
       			medicament_libelle  AS libelle,
       			medicament_date_debut AS date_debut,
                utilisateur_id_creation
FROM
     tb_ref_medicaments
WHERE 
      medicament_date_fin IS NULL
ORDER BY medicament_libelle
";
        $a = $this->bdd->prepare($query);
        $a->execute(array());
        return $a->fetchAll();
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
        $a = $this->bdd->prepare($query);
        $a->execute(array());
        return $a->fetchAll();
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
        $a = $this->bdd->prepare($query);
        $a->execute(array());
        return $a->fetchAll();
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
        $a = $this->bdd->prepare($query);
        $a->execute(array());
        return $a->fetchAll();
    }
    public function lister_types_medicaments()
    {
        $query = "
SELECT 
        	type_medicament_code  AS code,
       			type_medicament_libelle AS libelle,
       			type_medicament_date_debut AS date_debut,
       utilisateur_id_creation
FROM
     tb_ref_medicaments_types_medicaments
WHERE 
      type_medicament_date_fin IS NULL
ORDER BY type_medicament_libelle
";
        $a = $this->bdd->prepare($query);
        $a->execute(array());
        return $a->fetchAll();
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
        $a = $this->bdd->prepare($query);
        $a->execute(array());
        return $a->fetchAll();
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
        $a = $this->bdd->prepare($query);
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
        $a = $this->bdd->prepare($query);
        $a->execute(array());
        return $a->fetchAll();
    }
    public function lister_dci($forme)
    {
        $query = "
SELECT 
        	
       			dci_code  AS code,
       			dci_dosage  AS dosage,
       			forme_code  AS code_forme,
       			unite_dosage_code  AS code_unite,
       			dci_libelle AS libelle,
       			dci_date_debut AS date_debut,
                utilisateur_id_creation
FROM
     tb_ref_medicaments_dci
WHERE forme_code LIKE ? AND
      dci_date_fin IS NULL
ORDER BY dci_libelle
";
        $a = $this->bdd->prepare($query);
        $a->execute(array($forme));
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
        $a = $this->bdd->prepare($query);
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
        $a = $this->bdd->prepare($query);
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
        $a = $this->bdd->prepare($query);
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
        $a = $this->bdd->prepare($query);
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
        $a = $this->bdd->prepare($query);
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
        $a = $this->bdd->prepare($query);
        $a->execute(array($code));
        return $a->fetchAll();
    }
    public function lister_historique_type_medicament($code)
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
     tb_ref_medicaments_types_medicaments A JOIN tb_utilisateurs B 
         ON 
             A.utilisateur_id_creation = B.utilisateur_id AND A.type_medicament_code LIKE ?
ORDER BY 
         A.date_creation DESC
";
        $a = $this->bdd->prepare($query);
        $a->execute(array($code));
        return $a->fetchAll();
    }
    public function lister_historique_classe_therapeutique($code)
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
        $a = $this->bdd->prepare($query);
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
        $a = $this->bdd->prepare($query);
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
        $a = $this->bdd->prepare($query);
        $a->execute(array($code));
        return $a->fetchAll();
    }


}