<?php
namespace App;

class DASHBOARD extends BDD
{
    /**
     * Retourne le nombre de patients ayant consulté un centre de santé sur une période
     * @param $code_ets
     * @param $date_debut
     * @param $date_fin
     * @return mixed
     */
    public function etablissement_nombre_patients($code_ets, $date_debut, $date_fin)
    {
        $a = $this->getBdd()->prepare("SELECT COUNT(DISTINCT population_num) AS effectif FROM tb_patients_dossiers WHERE etablissement_code = ? AND date_creation BETWEEN ? AND ?");
        $a->execute(array($code_ets, $date_debut, $date_fin));
        return $a->fetch();
    }

    /**
     * retourne le nombre de medecins d'un centre de santé sur une période
     * @param $code_ets
     * @param $date_debut
     * @param $date_fin
     * @return mixed
     */
    public function etablissement_nombre_medecins($code_ets, $date_debut, $date_fin)
    {
        $a = $this->getBdd()->prepare("SELECT COUNT(DISTINCT professionnel_sante_code) AS effectif FROM tb_etablissements_professionnels WHERE etablissement_code = ? AND date_creation BETWEEN ? AND ? AND etablissement_professionnel_date_fin IS NULL");
        $a->execute(array($code_ets, $date_debut, $date_fin));
        return $a->fetch();
    }

    /**
     * retourne le nombre d'utilisateurs d'un centre de santé sur une période
     * @param $code_ets
     * @param $date_debut
     * @param $date_fin
     * @return mixed
     */
    public function etablissement_nombre_utilisateurs($code_ets, $date_debut, $date_fin)
    {
        $a = $this->getBdd()->prepare("SELECT COUNT(DISTINCT utilisateur_id) AS effectif FROM tb_utilisateurs_etablissements WHERE etablissement_code = ? AND date_creation BETWEEN ? AND ? AND utilisateur_etablissement_date_fin IS NULL");
        $a->execute(array($code_ets, $date_debut, $date_fin));
        return $a->fetch();
    }

    public function etablissement_nombre_factures($code_ets, $date_debut, $date_fin)
    {
        $a = $this->getBdd()->prepare("SELECT COUNT(DISTINCT A.facture_medicale_num) AS effectif FROM tb_factures_medicales A JOIN tb_patients_dossiers B ON A.dossier_code = B.dossier_code AND B.etablissement_code = ? AND A.date_creation BETWEEN ? AND ? AND A.statut_code != ?");
        $a->execute(array($code_ets, $date_debut, $date_fin, 'A'));
        return $a->fetch();
    }

    public function etablissement_nombre_dossiers($code_ets, $date_debut, $date_fin)
    {
        $a = $this->getBdd()->prepare("SELECT COUNT(DISTINCT dossier_code) AS effectif FROM tb_patients_dossiers WHERE etablissement_code = ? AND date_creation BETWEEN ? AND ?");
        $a->execute(array($code_ets, $date_debut, $date_fin));
        return $a->fetch();
    }

    public function etablissement_nombre_factures_par_type($code_ets, $date_debut, $date_fin)
    {
        $a = $this->getBdd()->prepare("
SELECT 
       A.type_facture_code AS code,
       C.type_facture_libelle AS libelle,
       COUNT(DISTINCT A.facture_medicale_num) AS effectif 
FROM tb_factures_medicales A 
    JOIN tb_patients_dossiers B 
        ON A.dossier_code = B.dossier_code 
    JOIN tb_ref_types_factures_medicales C 
        ON A.type_facture_code = C.type_facture_code 
               AND C.type_facture_date_fin IS NULL
               AND B.etablissement_code = ? 
               AND A.date_creation BETWEEN ? AND ? AND A.statut_code != ? 
GROUP BY 
         A.type_facture_code, C.type_facture_libelle");
        $a->execute(array($code_ets, $date_debut, $date_fin, 'A'));
        return $a->fetchAll();
    }

    public function etablissement_nombre_patients_par_sexe($code_ets, $date_debut, $date_fin)
    {
        $a = $this->getBdd()->prepare("
SELECT 
       B.sexe_code AS code,
       C.sexe_libelle AS libelle,
       COUNT(DISTINCT A.population_num) AS effectif 
FROM tb_patients_dossiers A 
    JOIN tb_populations B 
        ON A.population_num = B.population_num 
    JOIN tb_ref_sexes C 
        ON B.sexe_code = C.sexe_code 
               AND C.sexe_date_fin IS NULL
               AND A.etablissement_code = ? 
               AND A.date_creation BETWEEN ? AND ? 
GROUP BY 
         B.sexe_code, 
         C.sexe_libelle");
        $a->execute(array($code_ets, $date_debut, $date_fin));
        return $a->fetchAll();
    }

    public function etablissement_nombre_patients_par_organisme($code_ets, $date_debut, $date_fin)
    {
        $a = $this->getBdd()->prepare("
SELECT 
       A.organisme_code AS code,
       C.organisme_libelle AS libelle,
       COUNT(DISTINCT population_num) AS effectif
FROM 
     tb_factures_medicales A 
         JOIN tb_patients_dossiers B 
             ON A.dossier_code = B.dossier_code 
         JOIN tb_organismes C 
             ON A.organisme_code = C.organisme_code 
                    AND B.etablissement_code = ? 
                    AND B.date_creation BETWEEN ? AND ?
GROUP BY 
         A.organisme_code,
         C.organisme_libelle");
        $a->execute(array($code_ets, $date_debut, $date_fin));
        return $a->fetchAll();
    }

    public function etablissement_nombre_patients_par_jour($code_ets, $date_debut, $date_fin)
    {
        $a = $this->getBdd()->prepare("
SELECT 
       YEAR(A.date_creation) AS annee,
       MONTH(A.date_creation) AS mois,
       DAY(A.date_creation) AS jour,
       COUNT(DISTINCT population_num) AS effectif_patients,
       COUNT(DISTINCT facture_medicale_num) AS effectif_factures
FROM 
     tb_factures_medicales A 
         JOIN tb_patients_dossiers B 
             ON A.dossier_code = B.dossier_code  
                    AND B.etablissement_code = ? 
                    AND B.date_creation BETWEEN ? AND ?
GROUP BY 
         YEAR(A.date_creation),
         MONTH(A.date_creation),
         DAY(A.date_creation) 
ORDER BY 
         YEAR(A.date_creation),
         MONTH(A.date_creation),
         DAY(A.date_creation) DESC");
        $a->execute(array($code_ets, $date_debut, $date_fin));
        return $a->fetchAll();
    }
}
