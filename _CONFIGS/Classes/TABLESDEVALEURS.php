<?php
namespace App;

class TABLESDEVALEURS extends BDD
{

    public function lister() {
        $json = array(
            array(
                'code' => "allerg",
                'libelle' => "Allergies"
            ),
            array(
                'code' => "cps",
                'libelle' => "Categories professionnels de santé"
            ),
            array(
                'code' => "csp",
                'libelle' => "Catégories socio-profésionnelles"
            ),
            array(
                'code' => "civ",
                'libelle' => "Civilités"
            ),
            array(
                'code' => "dev",
                'libelle' => "Devises monetaires"
            ),
            array(
                'code' => "gsa",
                'libelle' => "Groupes sanguins"
            ),
            array(
                'code' => "lge",
                'libelle' => "Localisations géographiques"
            ),
            array(
                'code' => "nsa",
                'libelle' => "Niveaux sanitaires"
            ),
            array(
                'code' => "ordre",
                'libelle' => "Ordres nationnaux"
            ),
            array(
                'code' => "prf",
                'libelle' => "Professions"
            ),
            array(
                'code' => "put",
                'libelle' => "Profils utilisateurs"
            ),
            array(
                'code' => "qtc",
                'libelle' => "Qualités civiles"
            ),
            array(
                'code' => "sct",
                'libelle' => "Secteurs d'activités"
            ),
            array(
                'code' => "etab_service",
                'libelle' => "Services de centres de santé"
            ),
            array(
                'code' => "sex",
                'libelle' => "Sexes"
            ),
            array(
                'code' => "sif",
                'libelle' => "Situations familiales"
            ),
            array(
                'code' => "sme",
                'libelle' => "Spécialités médicales"
            ),
            array(
                'code' => "stfm",
                'libelle' => "Statuts factures médicales"
            ),
            array(
                'code' => "tac",
                'libelle' => "Types accidents"
            ),
            array(
                'code' => "tco",
                'libelle' => "Types coordonnées"
            ),
            array(
                'code' => "tets",
                'libelle' => "Types étalissements"
            ),
            array(
                'code' => "tfa",
                'libelle' => "Types factures médicales"
            ),
            array(
                'code' => "typ_pers",
                'libelle' => "Types personnes"
            ),
            array(
                'code' => "tpi",
                'libelle' => "Types pièces d'identité"
            ),
            array(
                'code' => "typ_reg",
                'libelle' => "Types règlements"
            )
        );
        return $json;
    }
}