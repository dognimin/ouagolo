<?php
namespace App;

class PATIENTS extends BDD
{
    public function trouver_dernieres_constantes($num_patient) {
        $a = $this->getBdd()->prepare("SELECT population_num AS num_population, dossier_code AS code_dossier, constante_poids AS poids, constante_temperature AS temperature, constante_pouls AS pouls, date_creation, utilisateur_id_creation FROM tb_patients_constantes WHERE population_num = ? ORDER BY date_creation DESC limit 1");
        $a->execute(array($num_patient));
        return $a->fetch();
    }

    public function lister_organismes($num_patient, $date_soins) {
        $a = $this->getBdd()->prepare("
SELECT 
       A.population_num AS num_population, 
       A.organisme_code AS code_organisme, 
       B.organisme_libelle AS libelle_organisme, 
       B.rgb_code AS code_rgb,
       C.collectivite_code AS code_collectivite, 
       E.collectivite_raison_sociale AS raison_sociale,       
       C.organisme_contrat_collectivite_code AS code_contrat,
       D.population_num_contractant AS num_payeur, 
       D.population_contrat_date_debut AS date_debut_contrat,
       C.organisme_contrat_collectivite_taux AS taux_couverture, 
       F.produit_code AS code_produit, 
       G.produit_libelle AS libelle_produit, 
       G.panier_soins_code AS code_panier_soins, 
       G.reseau_soins_code AS code_reseau_soins
FROM 
     tb_organismes_assures A 
         JOIN tb_organismes B 
             ON A.organisme_code = B.organisme_code 
         JOIN tb_organismes_contrats_collectivites C 
             ON B.organisme_code = C.organisme_code 
         JOIN tb_populations_contrats D 
             ON C.organisme_contrat_collectivite_code = D.organisme_contrat_collectivite_code 
         JOIN tb_ref_collectivites E 
             ON C.collectivite_code = E.collectivite_code 
         JOIN tb_organismes_contrats_produits F 
             ON C.organisme_contrat_collectivite_code = F.organisme_contrat_collectivite_code 
         JOIN tb_organismes_produits G 
             ON F.produit_code = G.produit_code
                    AND A.population_num = D.population_num
                    AND D.population_num = ?
                    AND A.organisme_assure_date_fin IS NULL 
                    AND C.organisme_contrat_collectivite_date_debut <= ?
                    AND C.organisme_contrat_collectivite_date_fin >= ?
                    AND D.population_contrat_date_debut <= ?
                    AND (D.population_contrat_date_fin IS NULL OR D.population_contrat_date_fin >= ?) 
                    AND F.contrat_produit_date_debut <= ? 
                    AND (F.contrat_produit_date_fin IS NULL OR F.contrat_produit_date_fin >= ?) 
                    AND G.produit_date_debut <= ? AND (G.produit_date_fin IS NULL OR G.produit_date_fin >= ?)");
        $a->execute(array($num_patient, $date_soins, $date_soins, $date_soins, $date_soins, $date_soins, $date_soins, $date_soins, $date_soins));
        return $a->fetchAll();
    }

    public function trouver_organisme($code_organisme, $num_patient, $date_soins) {
        $a = $this->getBdd()->prepare("
SELECT 
       A.population_num AS num_population, 
       A.organisme_code AS code_organisme, 
       B.organisme_libelle AS libelle_organisme, 
       B.rgb_code AS code_rgb,
       C.collectivite_code AS code_collectivite, 
       E.collectivite_raison_sociale AS raison_sociale,       
       C.organisme_contrat_collectivite_code AS code_contrat,
       D.population_num_contractant AS num_payeur, 
       D.population_contrat_date_debut AS date_debut_contrat,
       C.organisme_contrat_collectivite_taux AS taux_couverture, 
       F.produit_code AS code_produit, 
       G.produit_libelle AS libelle_produit, 
       G.panier_soins_code AS code_panier_soins, 
       G.reseau_soins_code AS code_reseau_soins
FROM 
     tb_organismes_assures A 
         JOIN tb_organismes B 
             ON A.organisme_code = B.organisme_code 
         JOIN tb_organismes_contrats_collectivites C 
             ON B.organisme_code = C.organisme_code 
         JOIN tb_populations_contrats D 
             ON C.organisme_contrat_collectivite_code = D.organisme_contrat_collectivite_code 
         JOIN tb_ref_collectivites E 
             ON C.collectivite_code = E.collectivite_code 
         JOIN tb_organismes_contrats_produits F 
             ON C.organisme_contrat_collectivite_code = F.organisme_contrat_collectivite_code 
         JOIN tb_organismes_produits G 
             ON F.produit_code = G.produit_code
                    AND A.population_num = D.population_num
                    AND D.population_num = ?
                    AND A.organisme_code = ?
                    AND A.organisme_assure_date_fin IS NULL 
                    AND C.organisme_contrat_collectivite_date_debut <= ?
                    AND C.organisme_contrat_collectivite_date_fin >= ?
                    AND D.population_contrat_date_debut <= ?
                    AND (D.population_contrat_date_fin IS NULL OR D.population_contrat_date_fin >= ?) 
                    AND F.contrat_produit_date_debut <= ? 
                    AND (F.contrat_produit_date_fin IS NULL OR F.contrat_produit_date_fin >= ?) 
                    AND G.produit_date_debut <= ? AND (G.produit_date_fin IS NULL OR G.produit_date_fin >= ?)");
        $a->execute(array($num_patient, $code_organisme, $date_soins, $date_soins, $date_soins, $date_soins, $date_soins, $date_soins, $date_soins, $date_soins));
        return $a->fetch();
    }




}