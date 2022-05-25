<?php
namespace App;

class DOSSIERS extends BDD
{
    public function lister_factures($code_dosssier)
    {
        $a = $this->getBdd()->prepare("SELECT organisme_code AS code_organisme, dossier_code AS code_dossier, type_facture_code AS code_type_facture, facture_medicale_num AS num_facture, facture_medicale_date_debut_soins AS date_debut_soins, facture_medicale_date_fin_soins AS date_fin_soins, professionnel_code AS code_professionnel, facture_medicale_montant_depense AS montant_depense, facture_medicale_taux_remise AS taux_remise, facture_medicale_montant_rgb AS montant_rgb, facture_medicale_montant_rc AS montant_rc, facture_medicale_montant_patient AS montant_patient, date_creation, utilisateur_id_creation, date_edition, utilisateur_id_edition FROM tb_factures_medicales WHERE dossier_code = ? ORDER BY date_creation");
        $a->execute(array($code_dosssier));
        return $a->fetchAll();
    }

    public function fermer($code, $date_fin_soins, $user)
    {
        $a = $this->getBdd()->prepare("UPDATE tb_patients_dossiers SET patient_dossier_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE dossier_code = ?");
        $a->execute(array($date_fin_soins, date('Y-m-d H:i:s',time()), $user, $code));
        if($a->errorCode() == "00000"){
            return array(
                "success" => true,
                "message" => 'Enregistrement effectué avec succès'
            );
        }else{
            return array(
                "success" => false,
                "message" => $a->errorInfo()[2]
            );
        }
    }

    public function editer($code_ets, $num_patient, $code, $date_soins, $user){
        $dossier = $this->trouver($code);
        if($dossier) {
            return $this->modifier($code, $date_soins, $user);
        }else {
            return $this->ajouter($code_ets, $num_patient, $code, $date_soins, $user);
        }
    }

    public function trouver($code) {
        $a = $this->getBdd()->prepare("
SELECT 
       A.etablissement_code AS code_etablissement, 
       B.raison_sociale,
       A.population_num AS num_population, 
       C.rgb_num AS num_rgb, 
       C.civilite_code AS code_civilite, 
       C.population_nom AS nom, 
       C.population_prenoms AS prenom, 
       C.population_date_naissance AS date_naissance, 
       C.sexe_code AS code_sexe, 
       A.dossier_code AS code_dossier, 
       A.patient_dossier_date_debut AS date_debut, 
       A.patient_dossier_date_fin AS date_fin, 
       A.date_creation, 
       A.utilisateur_id_creation, 
       A.date_edition, 
       A.utilisateur_id_edition 
FROM 
     tb_patients_dossiers A 
         JOIN tb_etablissements B 
             ON A.etablissement_code = B.etablissement_code 
         JOIN tb_populations C 
             ON A.population_num = C.population_num
        AND A.dossier_code = ?");
        $a->execute(array($code));
        return $a->fetch();
    }

    private function modifier($code, $date_soins, $user)
    {
        $a = $this->getBdd()->prepare("UPDATE tb_patients_dossiers SET patient_dossier_date_debut = ?, date_edition = ?, utilisateur_id_edition = ? WHERE dossier_code = ?");
        $a->execute(array($date_soins, date('Y-m-d H:i:s',time()), $user, $code));
        if($a->errorCode() == "00000"){
            return array(
                "success" => true,
                "message" => 'Enregistrement effectué avec succès'
            );
        }else{
            return array(
                "success" => false,
                "message" => $a->errorInfo()[2]
            );
        }
    }

    private function ajouter($code_ets, $num_patient, $code, $date_soins, $user)
    {
        if(!$code) {
            $nb_dossiers = count($this->lister(null, $num_patient));
            $code = $num_patient.str_pad(intval($nb_dossiers + 1), 4,'0',STR_PAD_LEFT);
        }
        $a = $this->getBdd()->prepare("INSERT INTO tb_patients_dossiers(etablissement_code, population_num, dossier_code, patient_dossier_date_debut, utilisateur_id_creation)
        VALUES(:etablissement_code, :population_num, :dossier_code, :patient_dossier_date_debut, :utilisateur_id_creation)");
        $a->execute(array(
            'etablissement_code' => $code_ets,
            'population_num' => $num_patient,
            'dossier_code' => $code,
            'patient_dossier_date_debut' => $date_soins,
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
                "message" => $a->errorInfo()[2]
            );
        }
    }

    public function lister($code_ets, $num_patient)
    {
        $a = $this->getBdd()->prepare("
SELECT 
       A.etablissement_code AS code_etablissement, 
       B.raison_sociale,
       A.population_num AS num_population, 
       A.dossier_code AS code_dossier, 
       A.patient_dossier_date_debut AS date_debut, 
       A.patient_dossier_date_fin AS date_fin, 
       A.date_creation, 
       A.utilisateur_id_creation, 
       A.date_edition, 
       A.utilisateur_id_edition 
FROM 
     tb_patients_dossiers A 
         JOIN tb_etablissements B 
             ON A.etablissement_code = B.etablissement_code 
                    AND A.population_num = ? 
                    AND A.dossier_code LIKE ? ORDER BY A.date_creation DESC");
        $a->execute(array($num_patient, '%'.$code_ets.'%'));
        return $a->fetchAll();
    }

    public function lister_pathologies($code_dossier) {
        $a = $this->getBdd()->prepare("
SELECT 
       A.dossier_code AS code_dossier,
       A.pathologie_code AS code,
       B.pathologie_libelle AS libelle
FROM 
     tb_patients_dossiers_pathologies A 
         JOIN tb_ref_pathologies B 
             ON A.pathologie_code = B.pathologie_code 
                    AND A.dossier_code = ? 
                    AND A.pathologie_date_fin IS NULL 
ORDER BY A.date_creation");
        $a->execute(array($code_dossier));
        return $a->fetchAll();
    }

    public function editer_constantes($code_dossier, $poids, $temperature, $pouls, $user): array
    {
        $dossier = $this->trouver($code_dossier);
        if($dossier) {
            $constante = $this->trouver_constantes($dossier['num_population'], $dossier['code_dossier']);
            if($constante) {
                $fermer_constante = $this->fermer_constantes($dossier['num_population'], $dossier['code_dossier'], $user);
                if($fermer_constante['success'] == true) {
                    return $this->ajouter_constantes($dossier['num_population'], $dossier['code_dossier'], $poids, $temperature, $pouls, $user);
                }else {
                    return $fermer_constante;
                }
            }else {
                return $this->ajouter_constantes($dossier['num_population'], $dossier['code_dossier'], $poids, $temperature, $pouls, $user);
            }
        }else {
            return array(
                'success' => false,
                'message' => "Le dossier patient renseigné est incorrect."
            );
        }
    }

    public function editer_plaintes($code_dossier, $plaintes, $user) {
        $a = $this->getBdd()->prepare("UPDATE tb_patients_dossiers SET patient_dossier_plainte = ?, date_edition = ?, utilisateur_id_edition = ? WHERE dossier_code = ?");
        $a->execute(array($plaintes, date('Y-m-d H:i:s',time()), $user, $code_dossier));
        if($a->errorCode() == "00000"){
            return array(
                "success" => true,
                "message" => 'Enregistrement effectué avec succès'
            );
        }else{
            return array(
                "success" => false,
                "message" => $a->errorInfo()[2]
            );
        }
    }

    public function editer_diagnostic($code_dossier, $diagnostic, $user) {
        $a = $this->getBdd()->prepare("UPDATE tb_patients_dossiers SET patient_dossier_diagnostic = ?, date_edition = ?, utilisateur_id_edition = ? WHERE dossier_code = ?");
        $a->execute(array($diagnostic, date('Y-m-d H:i:s', time()), $user, $code_dossier));
        if ($a->errorCode() == "00000"){
            return array(
                "success" => true,
                "message" => 'Enregistrement effectué avec succès'
            );
        } else{
            return array(
                "success" => false,
                "message" => $a->errorInfo()[2]
            );
        }
    }

    public function editer_professionnel_sante($code_dossier, $code_professionnel, $code_specialite, $user) {
        $a = $this->getBdd()->prepare("UPDATE tb_patients_dossiers SET professionnel_sante_code = ?, specialite_medicale_code = ?, date_edition = ?, utilisateur_id_edition = ? WHERE dossier_code = ?");
        $a->execute(array($code_professionnel, $code_specialite, date('Y-m-d H:i:s',time()), $user, $code_dossier));
        if($a->errorCode() == "00000"){
            return array(
                "success" => true,
                "message" => 'Enregistrement effectué avec succès'
            );
        }else{
            return array(
                "success" => false,
                "message" => $a->errorInfo()[2]
            );
        }
    }

    public function trouver_pathologie($code_dossier, $code) {
        $a = $this->getBdd()->prepare("
SELECT 
       A.dossier_code AS code_dossier,
       A.pathologie_code AS code,
       B.pathologie_libelle AS libelle
FROM 
     tb_patients_dossiers_pathologies A 
         JOIN tb_ref_pathologies B 
             ON A.pathologie_code = B.pathologie_code 
                    AND A.dossier_code = ? 
                    AND A.pathologie_code = ?
                    AND A.pathologie_date_fin IS NULL");
        $a->execute(array($code_dossier, $code));
        return $a->fetch();
    }

    public function ajouter_pathologie($code_dossier, $code, $user) {
        $pathologie = $this->trouver_pathologie($code_dossier, $code);
        if($pathologie) {
            return array(
                "success" => false,
                "message" => "Cette pathologie a déjà été enregistrée pour ce dossier."
            );
        } else {
            $a = $this->getBdd()->prepare("INSERT INTO tb_patients_dossiers_pathologies(dossier_code, pathologie_code, pathologie_date_debut, utilisateur_id_creation)
        VALUES(:dossier_code, :pathologie_code, :pathologie_date_debut, :utilisateur_id_creation)");
            $a->execute(array(
                'dossier_code' => $code_dossier,
                'pathologie_code' => $code,
                'pathologie_date_debut' => date('Y-m-d',time()),
                'utilisateur_id_creation' => $user
            ));
            if($a->errorCode() == "00000"){
                return array(
                    "success" => true,
                    "message" => 'Enregistrement effectué avec succès'
                );
            }else{
                return array(
                    "success" => false,
                    "message" => $a->errorInfo()[2]
                );
            }
        }

    }

    public function trouver_constantes($num_population, $code_dossier) {
        $a = $this->getBdd()->prepare("SELECT population_num AS num_population, dossier_code AS code_dossier, constante_poids AS poids, constante_temperature AS temperature, constante_pouls AS pouls, date_creation, utilisateur_id_creation FROM tb_patients_constantes WHERE population_num = ? AND dossier_code = ? AND constante_date_fin IS NULL");
        $a->execute(array($num_population, $code_dossier));
        return $a->fetch();
    }

    public function lister_bulletins_examens($code_dossier) {
        $a = $this->getBdd()->prepare("
SELECT 
       dossier_code AS code_dossier, 
       examen_code AS code, 
       examen_renseignements AS renseignements, 
       date_creation, 
       utilisateur_id_creation, 
       date_edition, 
       utilisateur_id_edition 
FROM 
     tb_patients_dossiers_examens 
WHERE 
      dossier_code LIKE ? ORDER BY date_creation DESC");
        $a->execute(array('%'.$code_dossier.'%'));
        return $a->fetchAll();
    }

    public function trouver_bulletin_examens($code_dossier, $code) {
        $a = $this->getBdd()->prepare("
SELECT 
       dossier_code AS code_dossier, 
       examen_code AS code, 
       examen_renseignements AS renseignements, 
       date_creation, 
       utilisateur_id_creation, 
       date_edition, 
       utilisateur_id_edition 
FROM 
     tb_patients_dossiers_examens 
WHERE 
      dossier_code = ? 
  AND examen_code = ?");
        $a->execute(array($code_dossier, $code));
        return $a->fetch();
    }

    public function lister_bulletins_examens_actes($code_bulletin) {
        $a = $this->getBdd()->prepare("
SELECT 
       A.examen_code AS code_examens, 
       A.acte_code AS code,
       B.acte_libelle AS libelle,
       A.examen_acte_resultats AS resultat_acte, 
       A.date_creation, 
       A.utilisateur_id_creation 
FROM 
     tb_patients_dossiers_examens_actes A 
         JOIN tb_ref_actes_medicaux B 
             ON A.acte_code = B.acte_code 
                    AND A.examen_code = ? 
                    AND B.acte_date_fin IS NULL");
        $a->execute(array($code_bulletin));
        return $a->fetchAll();
    }

    public function editer_bulletin_examen($code_dossier, $renseignements_cliniques, $user) {
        $examens = $this->lister_bulletins_examens(null);
        $nb_examens = count($examens);
        $code = 'BE'.str_pad((int)($nb_examens + 1), 18, '0', STR_PAD_LEFT);

        $a = $this->getBdd()->prepare("INSERT INTO tb_patients_dossiers_examens(dossier_code, examen_code, examen_renseignements, utilisateur_id_creation)
        VALUES(:dossier_code, :examen_code, :examen_renseignements, :utilisateur_id_creation)");
        $a->execute(array(
            'dossier_code' => $code_dossier,
            'examen_code' => $code,
            'examen_renseignements' => $renseignements_cliniques,
            'utilisateur_id_creation' => $user
        ));
        if ($a->errorCode() == "00000"){
            return array(
                "success" => true,
                "code" => $code,
                "message" => 'Enregistrement effectué avec succès'
            );
        } else {
            return array(
                "success" => false,
                "message" => $a->errorInfo()[2]
            );
        }
    }

    public function editer_bulletin_examen_actes($code_bulletin, $code_acte, $user) {
        $a = $this->getBdd()->prepare("INSERT INTO tb_patients_dossiers_examens_actes(examen_code, acte_code, utilisateur_id_creation) 
        VALUES(:examen_code, :acte_code, :utilisateur_id_creation)");
        $a->execute(array(
            'examen_code' => $code_bulletin,
            'acte_code' => $code_acte,
            'utilisateur_id_creation' => $user
        ));
        if ($a->errorCode() == "00000"){
            return array(
                "success" => true,
                "message" => 'Enregistrement effectué avec succès'
            );
        } else {
            return array(
                "success" => false,
                "message" => $a->errorInfo()[2]
            );
        }
    }

    public function lister_ordonnances($code_dossier) {
        $a = $this->getBdd()->prepare("
SELECT 
       dossier_code AS code_dossier, 
       ordonnance_code AS code, 
       date_creation, 
       utilisateur_id_creation, 
       date_edition, 
       utilisateur_id_edition 
FROM 
     tb_patients_dossiers_ordonnances 
WHERE 
      dossier_code LIKE ? ORDER BY date_creation DESC");
        $a->execute(array('%'.$code_dossier.'%'));
        return $a->fetchAll();
    }

    public function trouver_ordonnance($code_dossier, $code) {
        $a = $this->getBdd()->prepare("
SELECT 
       dossier_code AS code_dossier, 
       ordonnance_code AS code, 
       date_creation, 
       utilisateur_id_creation, 
       date_edition, 
       utilisateur_id_edition 
FROM 
     tb_patients_dossiers_ordonnances 
WHERE 
      dossier_code = ? 
  AND ordonnance_code = ?");
        $a->execute(array($code_dossier, $code));
        return $a->fetch();
    }

    public function lister_ordonnance_medicaments($code_ordonnance) {
        $a = $this->getBdd()->prepare("
SELECT 
       A.ordonnance_code AS code_ordonnance, 
       A.medicament_code AS code,
       B.medicament_libelle AS libelle,
       A.medicament_posologie AS posologie,
       A.medicament_duree AS duree,
       A.medicament_unite_duree AS unite_duree,
       A.date_creation, 
       A.utilisateur_id_creation 
FROM 
     tb_patients_dossiers_ordonnances_medicaments A 
         JOIN tb_ref_medicaments B 
             ON A.medicament_code = B.medicament_code 
                    AND A.ordonnance_code = ? 
                    AND B.medicament_date_fin IS NULL");
        $a->execute(array($code_ordonnance));
        return $a->fetchAll();
    }

    public function editer_ordonnance($code_dossier, $user) {
        $ordonnances = $this->lister_ordonnances(null);
        $nb_ordonnances = count($ordonnances);
        $code = 'ORD'.str_pad((int)($nb_ordonnances + 1), 17, '0', STR_PAD_LEFT);

        $a = $this->getBdd()->prepare("INSERT INTO tb_patients_dossiers_ordonnances(dossier_code, ordonnance_code, utilisateur_id_creation)
        VALUES(:dossier_code, :ordonnance_code, :utilisateur_id_creation)");
        $a->execute(array(
            'dossier_code' => $code_dossier,
            'ordonnance_code' => $code,
            'utilisateur_id_creation' => $user
        ));
        if ($a->errorCode() == "00000"){
            return array(
                "success" => true,
                "code" => $code,
                "message" => 'Enregistrement effectué avec succès'
            );
        } else {
            return array(
                "success" => false,
                "message" => $a->errorInfo()[2]
            );
        }
    }

    public function editer_ordonnance_medicaments($code_ordonnance, $code_medicament, $posologie, $duree, $unite_duree, $user) {
        $a = $this->getBdd()->prepare("INSERT INTO tb_patients_dossiers_ordonnances_medicaments(ordonnance_code, medicament_code, medicament_posologie, medicament_duree, medicament_unite_duree, utilisateur_id_creation) 
        VALUES(:ordonnance_code, :medicament_code, :medicament_posologie, :medicament_duree, :medicament_unite_duree, :utilisateur_id_creation)");
        $a->execute(array(
            'ordonnance_code' => $code_ordonnance,
            'medicament_code' => $code_medicament,
            'medicament_posologie' => $posologie,
            'medicament_duree' => $duree,
            'medicament_unite_duree' => $unite_duree,
            'utilisateur_id_creation' => $user
        ));
        if ($a->errorCode() == "00000"){
            return array(
                "success" => true,
                "message" => 'Enregistrement effectué avec succès'
            );
        } else {
            return array(
                "success" => false,
                "message" => $a->errorInfo()[2]
            );
        }
    }

    private function fermer_constantes($num_population, $code_dossier, $user): array
    {
        $a = $this->getBdd()->prepare("UPDATE tb_patients_constantes SET constante_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE population_num = ? AND dossier_code = ? AND constante_date_fin IS NULL");
        $a->execute(array(date('Y-m-d H:i:s', time()), date('Y-m-d H:i:s', time()), $user, $num_population, $code_dossier));
        if ($a->errorCode() == "00000"){
            return array(
                "success" => true,
                "message" => 'Enregistrement effectué avec succès'
            );
        } else {
            return array(
                "success" => false,
                "message" => $a->errorInfo()[2]
            );
        }
    }

    private function ajouter_constantes($num_population, $code_dossier, $poids, $temperature, $pouls, $user): array
    {
        $a = $this->getBdd()->prepare("INSERT INTO tb_patients_constantes(population_num, dossier_code, constante_poids, constante_temperature, constante_pouls, utilisateur_id_creation)
        VALUES(:population_num, :dossier_code, :constante_poids, :constante_temperature, :constante_pouls, :utilisateur_id_creation)");
        $a->execute(array(
            'population_num' => $num_population,
            'dossier_code' => $code_dossier,
            'constante_poids' => $poids,
            'constante_temperature' => $temperature,
            'constante_pouls' => $pouls,
            'utilisateur_id_creation' => $user
        ));
        if ($a->errorCode() == "00000"){
            return array(
                "success" => true,
                "message" => 'Enregistrement effectué avec succès'
            );
        } else{
            return array(
                "success" => false,
                "message" => $a->errorInfo()[2]
            );
        }
    }

    public function fermer_dossier($code_dossier, $type, $date, $user) {
        $a = $this->getBdd()->prepare("UPDATE tb_patients_dossiers SET patient_dossier_date_fin = ?, sortie_medicale_code = ?, date_edition = ?, utilisateur_id_edition = ? WHERE dossier_code = ?");
        $a->execute(array($date, $type, date('Y-m-d H:i:s', time()), $user, $code_dossier));
        if ($a->errorCode() == "00000"){
            return array(
                "success" => true,
                "message" => 'Enregistrement effectué avec succès'
            );
        } else{
            return array(
                "success" => false,
                "message" => $a->errorInfo()[2]
            );
        }
    }

    public function lister_factures_initiales($code_dossier){
        $a = $this->getBdd()->prepare("SELECT dossier_code AS code_dossier, type_facture_code AS code_type_facture, facture_medicale_num AS num_facture, organisme_code AS code_organisme, organisme_contrat_collectivite_taux AS taux_organisme FROM tb_factures_medicales WHERE dossier_code = ? AND type_facture_code IN(?, ?) AND statut_code != ?");
        $a->execute(array($code_dossier, 'AMB', 'DEN', 'A'));
        return $a->fetchAll();
    }
}
