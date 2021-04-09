<?php


class TABLESDEVALEURS
{

    public function lister() {
        $json = array(
            array(
                'code' => "put",
                'libelle' => "Profils utilisateurs"
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
                'code' => "sex",
                'libelle' => "Sexes"
            ),
            array(
                'code' => "sif",
                'libelle' => "Situations familiales"
            ),
            array(
                'code' => "sct",
                'libelle' => "Secteurs d'activités"
            ),
            array(
                'code' => "prf",
                'libelle' => "Professions"
            ),
            array(
                'code' => "qtc",
                'libelle' => "Qualités civiles"
            ),
            array(
                'code' => "tco",
                'libelle' => "Types coordonnées"
            ),
            array(
                'code' => "tpi",
                'libelle' => "Types pièces d'identité"
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
            )
        );
        return $json;
    }
}