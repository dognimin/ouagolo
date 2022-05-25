<?php
namespace App;

class PANIERSDESOINS extends BDD
{

    public function editer($code_organisme, $code, $libelle, $user) {
        $panier = $this->trouver($code_organisme, $code);
        if ($panier) {
            $date_fin = date('Y-m-d', strtotime('-1 day', time()));
            if (strtotime($date_fin) > strtotime($panier['date_debut'])) {
                $edition = $this->fermer($panier['code'], $date_fin, $user);
                if ($edition['success'] == true) {
                    $json = $this->ajouter($code_organisme, $libelle, $user);
                } else {
                    $json = $edition;
                }
            } else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le " . date('d/m/Y', strtotime('+2 day', strtotime($panier['date_debut'])))
                );
            }

        } else {
            $json = $this->ajouter($code_organisme, $libelle, $user);
        }
        return $json;
    }

    public function trouver($code_organisme, $code)
    {
        $query = "SELECT A.organisme_code AS code_organisme, B.organisme_libelle AS libelle_organisme, A.panier_soins_code AS code, A.panier_soins_libelle AS libelle, A.panier_soins_date_debut AS date_debut, A.utilisateur_id_creation FROM tb_paniers_soins A JOIN tb_organismes B ON A.organisme_code = B.organisme_code AND A.organisme_code LIKE ? AND A.panier_soins_code = ? AND A.panier_soins_date_fin IS NULL";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array('%'.$code_organisme.'%', $code));
        return $a->fetch();
    }

    private function fermer( $code, $date_fin, $user)
    {
        $a = $this->getBdd()->prepare("UPDATE tb_paniers_soins SET panier_soins_date_fin = ?, date_edition = ?, utilisation_id_edition = ? WHERE panier_soins_code = ? AND panier_soins_date_fin IS NULL");
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
        $paniers = $this->lister(null);
        $nb_paniers = count($paniers);
        $code = 'PNS'.str_pad(intval($nb_paniers + 1), 7,'0',STR_PAD_LEFT);

        $a = $this->getBdd()->prepare("INSERT INTO tb_paniers_soins(organisme_code, panier_soins_code,panier_soins_libelle,panier_soins_date_debut , utilisateur_id_creation)
        VALUES(:organisme_code, :panier_soins_code, :panier_soins_libelle, :panier_soins_date_debut, :utilisateur_id_creation) 
        ");
        $a->execute(array(
            'organisme_code' => $code_organisme,
            'panier_soins_code' => $code,
            'panier_soins_libelle' => $libelle,
            'panier_soins_date_debut' => date('Y-m-d', time()),
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
        $a = $this->getBdd()->prepare("SELECT A.organisme_code AS code_organisme, B.organisme_libelle AS libelle_organisme, A.panier_soins_code AS code, A.panier_soins_libelle AS libelle, A.panier_soins_date_debut AS date_debut, A.utilisateur_id_creation FROM tb_paniers_soins A JOIN tb_organismes B ON A.organisme_code = B.organisme_code AND A.organisme_code LIKE ? AND A.panier_soins_date_fin IS NULL");
        $a->execute(array('%'.$code_organisme.'%'));
        return $a->fetchAll();
    }

    public function lister_historique($code_panier)
    {
        $query = "
SELECT 
     A.panier_soins_code AS code,
       A.panier_soins_libelle AS libelle,
       A.panier_soins_date_debut AS date_debut,
       A.utilisateur_id_creation,
       B.utilisateur_nom AS nom,
       B.utilisateur_prenoms AS prenoms, 
       A.panier_soins_date_debut AS date_debut, 
       A.panier_soins_date_fin AS date_fin,
       A.date_creation
FROM 
     tb_paniers_soins A JOIN tb_utilisateurs B 
         ON 
             A.utilisateur_id_creation = B.utilisateur_id  AND A.panier_soins_code   LIKE ?
ORDER BY 
         A.date_creation DESC
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code_panier));
        return $a->fetchAll();
    }

    public function lister_panier_actes_medicaux($code_panier)
    {
        $query = "
SELECT 
       A.panier_soins_code AS code_panier,
       A.acte_code AS code_acte,
       B.acte_libelle AS libelle_acte,
       A.panier_soins_acte_tarif AS tarif,
       A.panier_soins_acte_tarif_maximim AS tarif_plafond,
       A.panier_soins_statut_entente_prealable AS statut_ep,
       A.panier_soins_acte_date_debut AS date_debut,
       A.utilisateur_id_creation
FROM 
    tb_paniers_soins_actes_medicaux A 
        JOIN tb_ref_actes_medicaux B 
            ON A.acte_code = B.acte_code 
                   AND A.panier_soins_code LIKE ?
                   AND A.panier_soins_acte_date_fin IS NULL
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code_panier));
        return $a->fetchAll();
    }

    public function editer_panier_acte_medical($code_panier, $code_acte, $tarif, $tarif_plafond, $statut_entente_prealable, $date_debut, $user)
    {
        $reseau_acte_medical = $this->trouver_panier_acte_medical($code_panier, $code_acte);
        if ($reseau_acte_medical) {
            $date_fin = date('Y-m-d', strtotime('-1 day', time()));
            if (strtotime($date_fin) > strtotime($reseau_acte_medical['date_debut'])) {
                $edition = $this->fermer_panier_acte_medical($reseau_acte_medical['code_panier'],$reseau_acte_medical['code_acte'], $date_fin, $user);
                if ($edition['success'] == true) {
                    $json = $this->ajouter_panier_acte_medical($code_panier, $code_acte, $tarif, $tarif_plafond, $statut_entente_prealable, $date_debut, $user);
                } else {
                    $json = $edition;
                }
            } else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le " . date('d/m/Y', strtotime('+2 day', strtotime($reseau_acte_medical['date_debut'])))
                );
            }

        } else {
            $json = $this->ajouter_panier_acte_medical($code_panier, $code_acte, $tarif, $tarif_plafond, $statut_entente_prealable, $date_debut, $user);
        }
        return $json;
    }

    public function trouver_panier_acte_medical($code_panier, $code_acte)
    {
        $query = "SELECT panier_soins_code AS code_panier, acte_code AS code_acte, panier_soins_acte_date_debut  AS date_debut, utilisateur_id_creation FROM tb_paniers_soins_actes_medicaux WHERE panier_soins_code LIKE ? AND acte_code LIKE ? AND panier_soins_acte_date_fin IS NULL";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code_panier, $code_acte));
        return $a->fetch();
    }

    private function fermer_panier_acte_medical( $code_panier, $code_acte, $date_fin, $user)
    {
        $a = $this->getBdd()->prepare("UPDATE tb_paniers_soins_actes_medicaux  SET panier_soins_acte_date_fin = ?, date_edition = ?, utilisation_id_edition = ? WHERE panier_soins_code = ? AND acte_code = ?   AND panier_soins_acte_date_fin IS NULL");
        $a->execute(array($date_fin, date('Y-m-d', time()), $user, $code_panier, $code_acte));
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

    private function ajouter_panier_acte_medical($code_panier, $code_acte, $tarif, $tarif_plafond, $statut_entente_prealalble, $date_debut, $user)
    {
        $a = $this->getBdd()->prepare("INSERT INTO tb_paniers_soins_actes_medicaux(panier_soins_code, acte_code, panier_soins_acte_tarif, panier_soins_acte_tarif_maximim, panier_soins_statut_entente_prealable, panier_soins_acte_date_debut, utilisateur_id_creation)
        VALUES(:panier_soins_code, :acte_code, :panier_soins_acte_tarif, :panier_soins_acte_tarif_maximim, :panier_soins_statut_entente_prealable, :panier_soins_acte_date_debut, :utilisateur_id_creation) 
        ");
        $a->execute(array(
            'panier_soins_code' => $code_panier,
            'acte_code' => $code_acte,
            'panier_soins_acte_tarif' => $tarif,
            'panier_soins_acte_tarif_maximim' => $tarif_plafond,
            'panier_soins_statut_entente_prealable' => $statut_entente_prealalble,
            'panier_soins_acte_date_debut' => $date_debut,
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

    public function lister_panier_medicaments($code_panier)
    {
        $query = "
SELECT 
       A.panier_soins_code AS code_panier,
       A.medicament_code AS code_medicament,
       B.medicament_libelle AS libelle_medicament,
       A.panier_soins_medicament_tarif AS tarif,
       A.panier_soins_medicament_date_debut AS date_debut,
       A.utilisateur_id_creation
FROM 
    tb_paniers_soins_medicaments A 
        JOIN tb_ref_medicaments B 
            ON A.medicament_code = B.medicament_code 
                   AND A.panier_soins_code LIKE ? 
                   AND A.panier_soins_medicament_date_fin IS NULL
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code_panier));
        return $a->fetchAll();
    }

    public function lister_panier_pathologies($code_panier)
    {
        $query = "
SELECT 
       A.panier_soins_code AS code_panier,
       A.pathologie_code AS code_pathologie,
       B.pathologie_libelle AS libelle_pathologie,
       A.panier_soins_pathologie_date_debut AS date_debut,
       A.utilisateur_id_creation
FROM 
    tb_paniers_soins_pathologies A 
        JOIN tb_ref_pathologies B 
            ON A.pathologie_code = B.pathologie_code 
                   AND A.panier_soins_code LIKE ? 
                   AND A.panier_soins_pathologie_date_fin IS NULL
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code_panier));
        return $a->fetchAll();
    }

    public function editer_panier_pathologie($code_panier, $code_pathologie, $date_debut, $user): array
    {
        $reseau_pathologie = $this->trouver_panier_pathologie($code_panier, $code_pathologie);
        if ($reseau_pathologie) {
            $date_fin = date('Y-m-d', strtotime('-1 day', time()));
            if (strtotime($date_fin) > strtotime($reseau_pathologie['date_debut'])) {
                $edition = $this->fermer_panier_pathologie($reseau_pathologie['code_panier'],$reseau_pathologie['code_pathologie'], $date_fin, $user);
                if ($edition['success'] == true) {
                    $json = $this->ajouter_panier_pathologie($code_panier, $code_pathologie, $date_debut, $user);
                } else {
                    $json = $edition;
                }
            } else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le " . date('d/m/Y', strtotime('+2 day', strtotime($reseau_pathologie['date_debut'])))
                );
            }

        } else {
            $json = $this->ajouter_panier_pathologie($code_panier, $code_pathologie, $date_debut, $user);
        }
        return $json;
    }

    public function trouver_panier_pathologie($code_panier, $code_pathologie)
    {
        $query = "SELECT panier_soins_code AS code_panier, pathologie_code AS code_pathologie, panier_soins_pathologie_date_debut  AS date_debut, utilisateur_id_creation FROM tb_paniers_soins_pathologies WHERE panier_soins_code LIKE ? AND pathologie_code LIKE ? AND panier_soins_pathologie_date_fin IS NULL";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code_panier, $code_pathologie));
        return $a->fetch();
    }

    private function fermer_panier_pathologie( $code_panier, $code_pathologie, $date_fin, $user): array
    {
        $a = $this->getBdd()->prepare("UPDATE tb_paniers_soins_pathologies  SET panier_soins_pathologie_date_fin = ?, date_edition = ?, utilisation_id_edition = ? WHERE panier_soins_code = ? AND pathologie_code = ? AND panier_soins_pathologie_date_fin IS NULL");
        $a->execute(array($date_fin, date('Y-m-d', time()), $user, $code_panier, $code_pathologie));
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

    private function ajouter_panier_pathologie($code_panier, $code_pathologie, $date_debut, $user): array
    {
        $a = $this->getBdd()->prepare("INSERT INTO tb_paniers_soins_pathologies(panier_soins_code, pathologie_code, panier_soins_pathologie_date_debut, utilisateur_id_creation)
        VALUES(:panier_soins_code, :pathologie_code, :panier_soins_pathologie_date_debut, :utilisateur_id_creation) 
        ");
        $a->execute(array(
            'panier_soins_code' => $code_panier,
            'pathologie_code' => $code_pathologie,
            'panier_soins_pathologie_date_debut' => $date_debut,
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

    public function editer_panier_medicament($code_panier, $code_medicament, $tarif, $date_debut, $user): array
    {
        $reseau_medicament = $this->trouver_panier_medicament($code_panier, $code_medicament);
        if ($reseau_medicament) {
            $date_fin = date('Y-m-d', strtotime('-1 day', time()));
            if (strtotime($date_fin) > strtotime($reseau_medicament['date_debut'])) {
                $edition = $this->fermer_panier_medicament($reseau_medicament['code_panier'],$reseau_medicament['code_medicament'], $date_fin, $user);
                if ($edition['success'] == true) {
                    $json = $this->ajouter_panier_medicament($code_panier, $code_medicament, $tarif, $date_debut, $user);
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
            $json = $this->ajouter_panier_medicament($code_panier, $code_medicament, $tarif, $date_debut, $user);
        }
        return $json;
    }

    public function trouver_panier_medicament($code_panier, $code_medicament)
    {
        $query = "SELECT panier_soins_code AS code_panier, medicament_code AS code_acte, panier_soins_medicament_date_debut  AS date_debut, utilisateur_id_creation FROM tb_paniers_soins_medicaments WHERE panier_soins_code LIKE ? AND medicament_code LIKE ? AND panier_soins_medicament_date_fin IS NULL";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code_panier, $code_medicament));
        return $a->fetch();
    }

    private function fermer_panier_medicament( $code_panier, $code_medicament, $date_fin, $user): array
    {
        $a = $this->getBdd()->prepare("UPDATE tb_paniers_soins_medicaments SET panier_soins_medicament_date_fin = ?, date_edition = ?, utilisation_id_edition = ? WHERE panier_soins_code = ? AND medicament_code = ? AND panier_soins_medicament_date_fin IS NULL");
        $a->execute(array($date_fin, date('Y-m-d', time()), $user, $code_panier, $code_medicament));
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

    private function ajouter_panier_medicament($code_panier, $code_medicament, $tarif, $date_debut, $user): array
    {
        $a = $this->getBdd()->prepare("INSERT INTO tb_paniers_soins_medicaments(panier_soins_code, medicament_code, panier_soins_medicament_tarif, panier_soins_medicament_date_debut, utilisateur_id_creation)
        VALUES(:panier_soins_code, :medicament_code, :panier_soins_medicament_tarif, :panier_soins_medicament_date_debut, :utilisateur_id_creation) 
        ");
        $a->execute(array(
            'panier_soins_code' => $code_panier,
            'medicament_code' => $code_medicament,
            'panier_soins_medicament_tarif' => $tarif,
            'panier_soins_medicament_date_debut' => $date_debut,
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
}