<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

require "../_CONFIGS/Classes/UTILISATEURS.php";
require "../_CONFIGS/Functions/Functions.php";
$parametres = array(
    'type' => clean_data($_GET['type']),
    'data' => clean_data($_GET['data'])
);

if (isset($_SESSION['nouvelle_session'])) {
    $UTILISATEURS = new UTILISATEURS();
    $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
    if ($session) {
        $utilisateur = $UTILISATEURS->trouver($session['id_user'], null);
        if ($utilisateur) {
            $type = $parametres['type'];
            $data = $parametres['data'];
            if($type == 'csv') {
                if($data == 'put') {
                    require "../_CONFIGS/Classes/PROFILSUTILISATEURS.php";
                    $PROFILSUTILISATEURS = new PROFILSUTILISATEURS();
                    $profils = $PROFILSUTILISATEURS->lister();
                    $nb_profils = count($profils);
                    if($nb_profils != 0) {
                        $file_name = "EXPORT_TABLE_VALEURS_PROFIL_UTILISATEURS_".date('dmYhis',time()).".csv";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename='.$file_name);

                        $fp = fopen('php://output', 'wb');
                        fputcsv($fp, array('CODE', 'LIBELLE', 'DATE EFFET'),';');
                        foreach ($profils as $profil) {
                            fputcsv($fp, array($profil['code'], $profil['libelle'], date('d/m/Y',strtotime($profil['date_debut']))),';');
                        }
                        fclose($fp);
                    }
                }
                elseif($data == 'csp') {
                    require "../_CONFIGS/Classes/CATEGORIESSOCIOPROFESSIONNELLES.php";
                    $CATEGORIESSOCIOPROFESSIONNELLES = new CATEGORIESSOCIOPROFESSIONNELLES();
                    $categories = $CATEGORIESSOCIOPROFESSIONNELLES->lister();
                    $nb_categories = count($categories);
                    if($nb_categories != 0) {
                        $file_name = "EXPORT_TABLE_VALEURS_CATEGORIES_SOCIO_PROFESSIONNELLES_".date('dmYhis',time()).".csv";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename='.$file_name);

                        $fp = fopen('php://output', 'wb');
                        fputcsv($fp, array('CODE', 'LIBELLE', 'DATE EFFET'),';');
                        foreach ($categories as $categorie) {
                            fputcsv($fp, array($categorie['code'], $categorie['libelle'], date('d/m/Y',strtotime($categorie['date_debut']))),';');
                        }
                        fclose($fp);
                    }
                }
                elseif($data == 'cps') {
                    require "../_CONFIGS/Classes/CATEGORIESPROFESSIONNELSANTES.php";
                    $CATEGORIESPROFESSIONNELSANTES = new CATEGORIESPROFESSIONNELSANTES();
                    $categories = $CATEGORIESPROFESSIONNELSANTES->lister();
                    $nb_categories = count($categories);
                    if($nb_categories != 0) {
                        $file_name = "EXPORT_TABLE_VALEURS_CATEGORIES_PROFESSIONNELS_SANTE_".date('dmYhis',time()).".csv";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename='.$file_name);

                        $fp = fopen('php://output', 'wb');
                        fputcsv($fp, array('CODE', 'LIBELLE', 'DATE EFFET'),';');
                        foreach ($categories as $categorie) {
                            fputcsv($fp, array($categorie['code'], $categorie['libelle'], date('d/m/Y',strtotime($categorie['date_debut']))),';');
                        }
                        fclose($fp);
                    }
                }
                elseif($data == 'ordre') {
                    require "../_CONFIGS/Classes/ORDESNATIONAUX.php";
                    $ORDESNATIONAUX = new ORDESNATIONAUX();
                    $ordres = $ORDESNATIONAUX->lister();
                    $nb_ordres = count($ordres);
                    if($nb_ordres != 0) {
                        $file_name = "EXPORT_TABLE_VALEURS_ORDRES_NATIONAUX_".date('dmYhis',time()).".csv";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename='.$file_name);

                        $fp = fopen('php://output', 'wb');
                        fputcsv($fp, array('CODE', 'LIBELLE', 'DATE EFFET'),';');
                        foreach ($ordres as $ordre) {
                            fputcsv($fp, array($ordre['code'], $ordre['libelle'], date('d/m/Y',strtotime($ordre['date_debut']))),';');
                        }
                        fclose($fp);
                    }
                }
                elseif($data == 'civ') {
                    require "../_CONFIGS/Classes/CIVILITES.php";
                    $CIVILITES = new CIVILITES();
                    $civilites = $CIVILITES->lister();
                    $nb_civilites = count($civilites);
                    if($nb_civilites != 0) {
                        $file_name = "EXPORT_TABLE_VALEURS_CIVILITES_".date('dmYhis',time()).".csv";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename='.$file_name);

                        $fp = fopen('php://output', 'wb');
                        fputcsv($fp, array('CODE', 'LIBELLE', 'DATE EFFET'), ';');
                        foreach ($civilites as $civilite) {
                            fputcsv($fp, array($civilite['code'], $civilite['libelle'], date('d/m/Y', strtotime($civilite['date_debut']))), ';');
                        }
                        fclose($fp);
                    }
                }
                elseif($data == 'sex') {
                    require "../_CONFIGS/Classes/SEXES.php";
                    $SEXES = new SEXES();
                    $sexes = $SEXES->lister();
                    $nb_sexes = count($sexes);
                    if($nb_sexes != 0) {
                        $file_name = "EXPORT_TABLE_VALEURS_SEXES_".date('dmYhis',time()).".csv";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename='.$file_name);

                        $fp = fopen('php://output', 'wb');
                        fputcsv($fp, array('CODE', 'LIBELLE', 'DATE EFFET'), ';');
                        foreach ($sexes as $sexe) {
                            fputcsv($fp, array($sexe['code'], $sexe['libelle'], date('d/m/Y', strtotime($sexe['date_debut']))), ';');
                        }
                        fclose($fp);
                    }
                }
                elseif($data == 'typ_pers') {
                    require "../_CONFIGS/Classes/TYPESPERSONNES.php";
                    $TYPESPERSONNES = new TYPESPERSONNES();
                    $types_personnes = $TYPESPERSONNES->lister();
                    $nb_types_personnes_ecu = count($types_personnes);
                    if($nb_types_personnes_ecu != 0) {
                        $file_name = "EXPORT_TABLE_VALEURS_TYPES_PERSONNES_".date('dmYhis',time()).".csv";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename='.$file_name);

                        $fp = fopen('php://output', 'wb');
                        fputcsv($fp, array('CODE', 'LIBELLE', 'DATE EFFET'), ';');
                        foreach ($types_personnes as $type_personne) {
                            fputcsv($fp, array($type_personne['code'], $type_personne['libelle'], date('d/m/Y', strtotime($type_personne['date_debut']))), ';');
                        }
                        fclose($fp);
                    }
                }
                elseif($data == 'tac') {
                    require "../_CONFIGS/Classes/TYPESACCIDENTS.php";
                    $TYPESACCIDENTS = new TYPESACCIDENTS();
                    $typesaccidents = $TYPESACCIDENTS->lister();
                    $nb_typesaccidents = count($typesaccidents);
                    if($nb_typesaccidents != 0) {
                        $file_name = "EXPORT_TABLE_VALEURS_TYPES_ACCIDENTS_".date('dmYhis',time()).".csv";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename='.$file_name);

                        $fp = fopen('php://output', 'wb');
                        fputcsv($fp, array('CODE', 'LIBELLE', 'DATE EFFET'), ';');
                        foreach ($typesaccidents as $typesaccident) {
                            fputcsv($fp, array($typesaccident['code'], $typesaccident['libelle'], date('d/m/Y', strtotime($typesaccident['date_debut']))), ';');
                        }
                        fclose($fp);
                    }
                }
                elseif($data == 'sif') {
                    require "../_CONFIGS/Classes/SEXES.php";
                    $SITUATIONFAMILLES = new SEXES();
                    $situationfamilles = $SITUATIONFAMILLES->lister();
                    $nb_situationfamilles = count($situationfamilles);
                    if($nb_situationfamilles != 0) {
                        $file_name = "EXPORT_TABLE_VALEURS_SITUATIONS_FAMILIALES_".date('dmYhis',time()).".csv";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename='.$file_name);

                        $fp = fopen('php://output', 'wb');
                        fputcsv($fp, array('CODE', 'LIBELLE', 'DATE EFFET'), ';');
                        foreach ($situationfamilles as $situationfamille) {
                            fputcsv($fp, array($situationfamille['code'], $situationfamille['libelle'], date('d/m/Y', strtotime($situationfamille['date_debut']))), ';');
                        }
                        fclose($fp);
                    }
                }
                elseif($data == 'sct') {
                    require "../_CONFIGS/Classes/SECTEURSACTIVITES.php";
                    $SECTEURSACTVITES = new SECTEURSACTIVITES();
                    $secteursactivites = $SECTEURSACTVITES->lister();
                    $nb_secteursactivites = count($secteursactivites);
                    if($nb_secteursactivites != 0) {
                        $file_name = "EXPORT_TABLE_VALEURS_SECTEURS_ACTIVITES_".date('dmYhis',time()).".csv";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename='.$file_name);

                        $fp = fopen('php://output', 'wb');
                        fputcsv($fp, array('CODE', 'LIBELLE', 'DATE EFFET'), ';');
                        foreach ($secteursactivites as $secteursactivite) {
                            fputcsv($fp, array($secteursactivite['code'], $secteursactivite['libelle'], date('d/m/Y', strtotime($secteursactivite['date_debut']))), ';');
                        }
                        fclose($fp);
                    }
                }
                elseif($data == 'prf') {
                    require "../_CONFIGS/Classes/PROFESSIONS.php";
                    $PROFESSIONS = new PROFESSIONS();
                    $professions = $PROFESSIONS->lister();
                    $nb_professions = count($professions);
                    if($nb_professions != 0) {
                        $file_name = "EXPORT_TABLE_VALEURS_PROFESSIONS_".date('dmYhis',time()).".csv";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename='.$file_name);

                        $fp = fopen('php://output', 'wb');
                        fputcsv($fp, array('CODE', 'LIBELLE', 'DATE EFFET'), ';');
                        foreach ($professions as $profession) {
                            fputcsv($fp, array($profession['code'], $profession['libelle'], date('d/m/Y', strtotime($profession['date_debut']))), ';');
                        }
                        fclose($fp);
                    }
                }
                elseif($data == 'qtc') {
                    require "../_CONFIGS/Classes/QUALITESCIVILES.php";
                    $QUALITESCIVILTES = new QUALITESCIVILES();
                    $qualitesciviles = $QUALITESCIVILTES->lister();
                    $nb_qualitesciviles = count($qualitesciviles);
                    if($nb_qualitesciviles != 0) {
                        $file_name = "EXPORT_TABLE_VALEURS_QUALITES_CIVILES_".date('dmYhis',time()).".csv";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename='.$file_name);

                        $fp = fopen('php://output', 'wb');
                        fputcsv($fp, array('CODE', 'LIBELLE', 'DATE EFFET'), ';');
                        foreach ($qualitesciviles as $qualitescivile) {
                            fputcsv($fp, array($qualitescivile['code'], $qualitescivile['libelle'], date('d/m/Y', strtotime($qualitescivile['date_debut']))), ';');
                        }
                        fclose($fp);
                    }
                }
                elseif($data == 'tco') {
                    require "../_CONFIGS/Classes/TYPESCOORDONNEES.php";
                    $TYPESCOORDONNEES = new TYPESCOORDONNEES();
                    $typescoordonnees = $TYPESCOORDONNEES->lister();
                    $nb_typescoordonnees = count($typescoordonnees);
                    if($nb_typescoordonnees != 0) {
                        $file_name = "EXPORT_TABLE_VALEURS_TYPES_COORDONNEES_".date('dmYhis',time()).".csv";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename='.$file_name);

                        $fp = fopen('php://output', 'wb');
                        fputcsv($fp, array('CODE', 'LIBELLE', 'DATE EFFET'), ';');
                        foreach ($typescoordonnees as $typescoordonnee) {
                            fputcsv($fp, array($typescoordonnee['code'], $typescoordonnee['libelle'], date('d/m/Y', strtotime($typescoordonnee['date_debut']))), ';');
                        }
                        fclose($fp);
                    }
                }
                elseif($data == 'tpi') {
                    require "../_CONFIGS/Classes/TYPESPIECESIDENTITES.php";
                    $TYPESPIECESIDENTITES = new TYPESPIECESIDENTITES();
                    $typespiecesidentites = $TYPESPIECESIDENTITES->lister();
                    $nb_typespiecesidentites = count($typespiecesidentites);
                    if($nb_typespiecesidentites != 0) {
                        $file_name = "EXPORT_TABLE_VALEURS_TYPES_PIECES_IDENTITES_".date('dmYhis',time()).".csv";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename='.$file_name);

                        $fp = fopen('php://output', 'wb');
                        fputcsv($fp, array('CODE', 'LIBELLE', 'DATE EFFET'), ';');
                        foreach ($typespiecesidentites as $typespiecesidentite) {
                            fputcsv($fp, array($typespiecesidentite['code'], $typespiecesidentite['libelle'], date('d/m/Y', strtotime($typespiecesidentite['date_debut']))), ';');
                        }
                        fclose($fp);
                    }
                }
                elseif($data == 'dev') {
                    require "../_CONFIGS/Classes/DEVISESMONETAIRES.php";
                    $DEVISES = new DEVISESMONETAIRES();
                    $devises = $DEVISES->lister();
                    $nb_devises = count($devises);
                    if($nb_devises != 0) {
                        $file_name = "EXPORT_TABLE_VALEURS_DEVISES_MONETAIRES_".date('dmYhis',time()).".csv";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename='.$file_name);

                        $fp = fopen('php://output', 'wb');
                        fputcsv($fp, array('CODE', 'LIBELLE', 'DATE EFFET'), ';');
                        foreach ($devises as $devise) {
                            fputcsv($fp, array($devise['code'], $devise['libelle'], date('d/m/Y', strtotime($devise['date_debut']))), ';');
                        }
                        fclose($fp);
                    }
                }
                elseif($data == 'gsa') {
                    require "../_CONFIGS/Classes/GROUPESSANGUINS.php";
                    $GROUPESSANGUINS = new GROUPESSANGUINS();
                    $groupesanguins = $GROUPESSANGUINS->lister();
                    $nb_groupesanguins = count($groupesanguins);
                    if($nb_groupesanguins != 0) {
                        $file_name = "EXPORT_TABLE_VALEURS_GROUPES_SANGUINS_".date('dmYhis',time()).".csv";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename='.$file_name);

                        $fp = fopen('php://output', 'wb');
                        fputcsv($fp, array('CODE', 'LIBELLE', 'DATE EFFET'), ';');
                        foreach ($groupesanguins as $groupesanguin) {
                            fputcsv($fp, array($groupesanguin['code'], $groupesanguin['libelle'], date('d/m/Y', strtotime($groupesanguin['date_debut']))), ';');
                        }
                        fclose($fp);
                    }
                }
                elseif($data == 'rhs') {
                    require "../_CONFIGS/Classes/GROUPESSANGUINS.php";
                    $GROUPESSANGUINS = new GROUPESSANGUINS();
                    $groupesanguins = $GROUPESSANGUINS->lister_rhesus();
                    $nb_groupesanguins = count($groupesanguins);
                    if($nb_groupesanguins != 0) {
                        $file_name = "EXPORT_TABLE_VALEURS_RHESUS_SANGUINS_".date('dmYhis',time()).".csv";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename='.$file_name);

                        $fp = fopen('php://output', 'wb');
                        fputcsv($fp, array('CODE', 'LIBELLE', 'DATE EFFET'), ';');
                        foreach ($groupesanguins as $groupesanguin) {
                            fputcsv($fp, array($groupesanguin['code'], $groupesanguin['libelle'], date('d/m/Y', strtotime($groupesanguin['date_debut']))), ';');
                        }
                        fclose($fp);
                    }
                }
                elseif($data == 'lge') {
                    require "../_CONFIGS/Classes/LOCALISATIONSGEOGRAPHIQUES.php";
                    $LOCALISATIONSGEOGRAPHIQUES = new LOCALISATIONSGEOGRAPHIQUES();
                    $pays = $LOCALISATIONSGEOGRAPHIQUES->lister_pays();
                    $nb_pays = count($pays);
                    if($nb_pays != 0) {
                        $file_name = "EXPORT_TABLE_VALEURS_PAYS_".date('dmYhis',time()).".csv";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename='.$file_name);

                        $fp = fopen('php://output', 'wb');
                        fputcsv($fp, array('CODE', 'LIBELLE', 'GENTILE','INDICATIF TELEPHONIQUE', 'DEVISE', 'COORDONNEES', 'DATE EFFET'), ';');
                        foreach ($pays as $datapays) {
                            fputcsv($fp, array($datapays['code'], $datapays['nom'],$datapays['gentile'], $datapays['indicatif_telephonique'],$datapays['devise'], $datapays['latitude'].''.$datapays['longitude'], date('d/m/Y', strtotime($datapays['date_debut']))), ';');
                        }
                        fclose($fp);
                    }
                }
                elseif($data == 'reg') {
                    require "../_CONFIGS/Classes/LOCALISATIONSGEOGRAPHIQUES.php";
                    $LOCALISATIONSGEOGRAPHIQUES = new LOCALISATIONSGEOGRAPHIQUES();
                    $regions = $LOCALISATIONSGEOGRAPHIQUES->lister_regions(null);
                    $nb_regions = count($regions);
                    if($nb_regions != 0) {
                        $file_name = "EXPORT_TABLE_VALEURS_REGIONS_".date('dmYhis',time()).".csv";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename='.$file_name);

                        $fp = fopen('php://output', 'wb');
                        fputcsv($fp, array('CODE','PAYS', 'LIBELLE', 'COORDONNEES', 'DATE EFFET'), ';');
                        foreach ($regions as $region) {
                            fputcsv($fp, array($region['code'], $region['pays_nom'],$region['nom'], $region['latitude'].''.$region['longitude'], date('d/m/Y', strtotime($region['date_debut']))), ';');
                        }
                        fclose($fp);
                    }
                }
                elseif($data == 'dep') {
                    require "../_CONFIGS/Classes/LOCALISATIONSGEOGRAPHIQUES.php";
                    $LOCALISATIONSGEOGRAPHIQUES = new LOCALISATIONSGEOGRAPHIQUES();
                    $departemements = $LOCALISATIONSGEOGRAPHIQUES->lister_departements(null);
                    $nb_departemements = count($departemements);
                    if($nb_departemements != 0) {
                        $file_name = "EXPORT_TABLE_VALEURS_DEPARTEMENTS_".date('dmYhis',time()).".csv";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename='.$file_name);

                        $fp = fopen('php://output', 'wb');
                        fputcsv($fp, array('CODE','PAYS','REGION', 'LIBELLE', 'COORDONNEES', 'DATE EFFET'), ';');
                        foreach ($departemements as $departemement) {
                            fputcsv($fp, array($departemement['code'], $departemement['nom_pays'], $departemement['nom_region'],$departemement['nom'], $departemement['latitude'].''.$departemement['longitude'], date('d/m/Y', strtotime($departemement['date_debut']))), ';');
                        }
                        fclose($fp);
                    }
                }
                elseif($data == 'com') {
                    require "../_CONFIGS/Classes/LOCALISATIONSGEOGRAPHIQUES.php";
                    $LOCALISATIONSGEOGRAPHIQUES = new LOCALISATIONSGEOGRAPHIQUES();
                    $communes = $LOCALISATIONSGEOGRAPHIQUES->lister_communes(null);
                    $nb_communes = count($communes);
                    if($nb_communes != 0) {
                        $file_name = "EXPORT_TABLE_VALEURS_COMMUNES_".date('dmYhis',time()).".csv";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename='.$file_name);

                        $fp = fopen('php://output', 'wb');
                        fputcsv($fp, array('CODE','PAYS','REGION','DEPARTEMENT', 'LIBELLE', 'COORDONNEES', 'DATE EFFET'), ';');
                        foreach ($communes as $commune) {
                            fputcsv($fp, array($commune['code'],$commune['nom_pays'],$commune['nom_region'],$commune['nom_departement'],$commune['nom'], $commune['latitude'].''.$commune['longitude'], date('d/m/Y', strtotime($commune['date_debut']))), ';');
                        }
                        fclose($fp);
                    }
                }
                elseif($data == 'tfa') {
                    require "../_CONFIGS/Classes/TYPESFACTURESMEDICALES.php";
                    $FACTURESMEDICALES = new TYPESFACTURESMEDICALES();
                    $types_factures = $FACTURESMEDICALES->lister();
                    $nb_types_factures = count($types_factures);
                    if($nb_types_factures != 0) {
                        $file_name = "EXPORT_TABLE_VALEURS_TYPES_FACTURES_MEDICALES_".date('dmYhis',time()).".csv";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename='.$file_name);

                        $fp = fopen('php://output', 'wb');
                        fputcsv($fp, array('CODE', 'LIBELLE', 'DATE EFFET'), ';');
                        foreach ($types_factures as $type_facture) {
                            fputcsv($fp, array($type_facture['code'], $type_facture['libelle'], date('d/m/Y', strtotime($type_facture['date_debut']))), ';');
                        }
                        fclose($fp);
                    }
                }
                else{
                    echo "<script>window.close();</script>";
                }
            }
            elseif($type == 'xls') {
                require_once '../vendor/autoload.php';
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                $row = 1;
                $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                $drawing->setName('Logo');
                $drawing->setDescription('Logo Ouagolo');
                $drawing->setPath(IMAGES_DIR.'logos/logo-ouagolo.png');
                $drawing->setCoordinates('A'.$row);
                $sheet->mergeCells('A'.$row.':C'.($row = $row+2));
                $drawing->setHeight(50);
                $drawing->setOffsetX(0);
                $drawing->setRotation(0);
                $drawing->getShadow()->setVisible(true);
                $drawing->getShadow()->setDirection(45);
                $drawing->setWorksheet($spreadsheet->getActiveSheet());

                $style_titre = [
                    'font' => [
                        'bold' => true,
                        'size' => 15
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'color' => [
                            'argb' => 'CCCCCC',
                        ],
                    ],
                ];
                $style_entete = [
                    'font' => [
                        'bold' => true,
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'color' => [
                            'argb' => '1E90FF',
                        ],
                    ],
                ];
                $style_tableau = [
                    'font' => [
                        'bold' => false,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'color' => [
                            'argb' => 'FFFFFF',
                        ],
                    ],
                ];
                if ($data == 'put') {
                    $file_name = "EXPORT_TABLE_VALEURS_PROFIL_UTILISATEURS_".date('dmYhis',time()).".xls";
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment; filename="'.$file_name.'"');

                    require "../_CONFIGS/Classes/PROFILSUTILISATEURS.php";
                    $PROFILSUTILISATEURS = new PROFILSUTILISATEURS();
                    $profils = $PROFILSUTILISATEURS->lister();
                    $nb_profils = count($profils);
                    if($nb_profils != 0) {

                        $row = 1;
                        $sheet->getStyle('D'.$row.':L'.$row)->applyFromArray($style_titre);
                        $sheet->setCellValue('D'.$row, 'TABLE DE VALEURS: PROFILS UTILISATEURS');
                        $sheet->mergeCells('D'.$row.':L'.($row = $row+2));
                        $sheet->getStyle('D1'.':L'.$row)
                            ->getBorders()
                            ->getAllBorders()
                            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

                        $row++;
                        $sheet->getStyle('A'.$row.':L'.$row)->applyFromArray($style_entete);
                        $sheet->mergeCells('C'.$row.':J'.$row);
                        $sheet->mergeCells('K'.$row.':L'.$row);
                        $sheet->setCellValue('A'.$row, 'N°');
                        $sheet->setCellValue('B'.$row, 'CODE');
                        $sheet->setCellValue('C'.$row, 'LIBELLE');
                        $sheet->setCellValue('K'.$row, 'DATE EFFET');
                        $ligne = 1;
                        foreach ($profils as $profil) {
                            $row++;
                            $sheet->getStyle('A'.$row.':L'.$row)->applyFromArray($style_tableau);
                            $sheet->mergeCells('C'.$row.':J'.$row);
                            $sheet->mergeCells('K'.$row.':L'.$row);
                            $sheet->setCellValue('A'.$row, $ligne);
                            $sheet->setCellValue('B'.$row, $profil['code']);
                            $sheet->setCellValue('C'.$row, $profil['libelle']);
                            $spreadsheet->getActiveSheet()->getStyle('K'.$row)
                                ->getNumberFormat()
                                ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                            $sheet->setCellValue('K'.$row, date('d/m/Y',strtotime($profil['date_debut'])));
                            $ligne++;
                        }

                        $writer = new Xlsx($spreadsheet);
                        $writer->save("php://output");
                    }
                }
                elseif ($data == 'csp') {
                    $file_name = "EXPORT_TABLE_VALEURS_CATEGORIES_SOCIO_PROFESSIONNELLES_".date('dmYhis',time()).".xls";
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment; filename="'.$file_name.'"');

                    require "../_CONFIGS/Classes/CATEGORIESSOCIOPROFESSIONNELLES.php";
                    $CATEGORIESSOCIOPROFESSIONNELLES = new CATEGORIESSOCIOPROFESSIONNELLES();
                    $categories = $CATEGORIESSOCIOPROFESSIONNELLES->lister();
                    $nb_categories = count($categories);
                    if($nb_categories != 0) {

                        $row = 1;
                        $sheet->getStyle('D'.$row.':L'.$row)->applyFromArray($style_titre);
                        $sheet->setCellValue('D'.$row, 'TABLE DE VALEURS: CATEGORIES SOCIO-PROFESSIONNELLES');
                        $sheet->mergeCells('D'.$row.':L'.($row = $row+2));
                        $sheet->getStyle('D1'.':L'.$row)
                            ->getBorders()
                            ->getAllBorders()
                            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

                        $row++;
                        $sheet->getStyle('A'.$row.':L'.$row)->applyFromArray($style_entete);
                        $sheet->mergeCells('C'.$row.':J'.$row);
                        $sheet->mergeCells('K'.$row.':L'.$row);
                        $sheet->setCellValue('A'.$row, 'N°');
                        $sheet->setCellValue('B'.$row, 'CODE');
                        $sheet->setCellValue('C'.$row, 'LIBELLE');
                        $sheet->setCellValue('K'.$row, 'DATE EFFET');
                        $ligne = 1;
                        foreach ($categories as $categorie) {
                            $row++;
                            $sheet->getStyle('A'.$row.':L'.$row)->applyFromArray($style_tableau);
                            $sheet->mergeCells('C'.$row.':J'.$row);
                            $sheet->mergeCells('K'.$row.':L'.$row);
                            $sheet->setCellValue('A'.$row, $ligne);
                            $sheet->setCellValue('B'.$row, $categorie['code']);
                            $sheet->setCellValue('C'.$row, $categorie['libelle']);
                            $spreadsheet->getActiveSheet()->getStyle('K'.$row)
                                ->getNumberFormat()
                                ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                            $sheet->setCellValue('K'.$row, date('d/m/Y',strtotime($categorie['date_debut'])));
                            $ligne++;
                        }

                        $writer = new Xlsx($spreadsheet);
                        $writer->save("php://output");
                    }
                }
                elseif ($data == 'cps') {
                    $file_name = "EXPORT_TABLE_VALEURS_CATEGORIES_PROFESSIONNELS_SANTE_".date('dmYhis',time()).".xls";
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment; filename="'.$file_name.'"');

                    require "../_CONFIGS/Classes/CATEGORIESPROFESSIONNELSANTES.php";
                    $CATEGORIESPROFESSIONNELSANTES = new CATEGORIESPROFESSIONNELSANTES();
                    $categories = $CATEGORIESPROFESSIONNELSANTES->lister();
                    $nb_categories = count($categories);
                    if($nb_categories != 0) {

                        $row = 1;
                        $sheet->getStyle('D'.$row.':L'.$row)->applyFromArray($style_titre);
                        $sheet->setCellValue('D'.$row, 'TABLE DE VALEURS: CATEGORIES PROFESSIONNELS SANTE');
                        $sheet->mergeCells('D'.$row.':L'.($row = $row+2));
                        $sheet->getStyle('D1'.':L'.$row)
                            ->getBorders()
                            ->getAllBorders()
                            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

                        $row++;
                        $sheet->getStyle('A'.$row.':L'.$row)->applyFromArray($style_entete);
                        $sheet->mergeCells('C'.$row.':J'.$row);
                        $sheet->mergeCells('K'.$row.':L'.$row);
                        $sheet->setCellValue('A'.$row, 'N°');
                        $sheet->setCellValue('B'.$row, 'CODE');
                        $sheet->setCellValue('C'.$row, 'LIBELLE');
                        $sheet->setCellValue('K'.$row, 'DATE EFFET');
                        $ligne = 1;
                        foreach ($categories as $categorie) {
                            $row++;
                            $sheet->getStyle('A'.$row.':L'.$row)->applyFromArray($style_tableau);
                            $sheet->mergeCells('C'.$row.':J'.$row);
                            $sheet->mergeCells('K'.$row.':L'.$row);
                            $sheet->setCellValue('A'.$row, $ligne);
                            $sheet->setCellValue('B'.$row, $categorie['code']);
                            $sheet->setCellValue('C'.$row, $categorie['libelle']);
                            $spreadsheet->getActiveSheet()->getStyle('K'.$row)
                                ->getNumberFormat()
                                ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                            $sheet->setCellValue('K'.$row, date('d/m/Y',strtotime($categorie['date_debut'])));
                            $ligne++;
                        }

                        $writer = new Xlsx($spreadsheet);
                        $writer->save("php://output");
                    }
                }
                elseif ($data == 'ordre') {
                    $file_name = "EXPORT_TABLE_VALEURS_ORDRES_NATIONAUX_".date('dmYhis',time()).".xls";
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment; filename="'.$file_name.'"');

                    require "../_CONFIGS/Classes/ORDESNATIONAUX.php";
                    $ORDESNATIONAUX = new ORDESNATIONAUX();
                    $ordres = $ORDESNATIONAUX->lister();
                    $nb_ordres = count($ordres);
                    if($nb_ordres != 0) {

                        $row = 1;
                        $sheet->getStyle('D'.$row.':L'.$row)->applyFromArray($style_titre);
                        $sheet->setCellValue('D'.$row, 'TABLE DE VALEURS: ORDRES NATIONAUX');
                        $sheet->mergeCells('D'.$row.':L'.($row = $row+2));
                        $sheet->getStyle('D1'.':L'.$row)
                            ->getBorders()
                            ->getAllBorders()
                            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

                        $row++;
                        $sheet->getStyle('A'.$row.':L'.$row)->applyFromArray($style_entete);
                        $sheet->mergeCells('C'.$row.':J'.$row);
                        $sheet->mergeCells('K'.$row.':L'.$row);
                        $sheet->setCellValue('A'.$row, 'N°');
                        $sheet->setCellValue('B'.$row, 'CODE');
                        $sheet->setCellValue('C'.$row, 'LIBELLE');
                        $sheet->setCellValue('K'.$row, 'DATE EFFET');
                        $ligne = 1;
                        foreach ($ordres as $ordre) {
                            $row++;
                            $sheet->getStyle('A'.$row.':L'.$row)->applyFromArray($style_tableau);
                            $sheet->mergeCells('C'.$row.':J'.$row);
                            $sheet->mergeCells('K'.$row.':L'.$row);
                            $sheet->setCellValue('A'.$row, $ligne);
                            $sheet->setCellValue('B'.$row, $ordre['code']);
                            $sheet->setCellValue('C'.$row, $ordre['libelle']);
                            $spreadsheet->getActiveSheet()->getStyle('K'.$row)
                                ->getNumberFormat()
                                ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                            $sheet->setCellValue('K'.$row, date('d/m/Y',strtotime($ordre['date_debut'])));
                            $ligne++;
                        }

                        $writer = new Xlsx($spreadsheet);
                        $writer->save("php://output");
                    }
                }
                elseif ($data == 'civ') {
                    $file_name = "EXPORT_TABLE_VALEURS_CIVILITES_".date('dmYhis',time()).".xls";
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment; filename="'.$file_name.'"');

                    require "../_CONFIGS/Classes/CIVILITES.php";
                    $CIVILITES = new CIVILITES();
                    $civilites = $CIVILITES->lister();
                    $nb_civilites = count($civilites);
                    if($nb_civilites != 0) {

                        $row = 1;
                        $sheet->getStyle('D'.$row.':L'.$row)->applyFromArray($style_titre);
                        $sheet->setCellValue('D'.$row, 'TABLE DE VALEURS: CIVILITES');
                        $sheet->mergeCells('D'.$row.':L'.($row = $row+2));
                        $sheet->getStyle('D1'.':L'.$row)
                            ->getBorders()
                            ->getAllBorders()
                            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

                        $row++;
                        $sheet->getStyle('A'.$row.':L'.$row)->applyFromArray($style_entete);
                        $sheet->mergeCells('C'.$row.':J'.$row);
                        $sheet->mergeCells('K'.$row.':L'.$row);
                        $sheet->setCellValue('A'.$row, 'N°');
                        $sheet->setCellValue('B'.$row, 'CODE');
                        $sheet->setCellValue('C'.$row, 'LIBELLE');
                        $sheet->setCellValue('K'.$row, 'DATE EFFET');
                        $ligne = 1;
                        foreach ($civilites as $civilite) {
                            $row++;
                            $sheet->getStyle('A'.$row.':L'.$row)->applyFromArray($style_tableau);
                            $sheet->mergeCells('C'.$row.':J'.$row);
                            $sheet->mergeCells('K'.$row.':L'.$row);
                            $sheet->setCellValue('A'.$row, $ligne);
                            $sheet->setCellValue('B'.$row, $civilite['code']);
                            $sheet->setCellValue('C'.$row, $civilite['libelle']);
                            $spreadsheet->getActiveSheet()->getStyle('K'.$row)
                                ->getNumberFormat()
                                ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                            $sheet->setCellValue('K'.$row, date('d/m/Y',strtotime($civilite['date_debut'])));
                            $ligne++;
                        }

                        $writer = new Xlsx($spreadsheet);
                        $writer->save("php://output");
                    }
                }
                elseif ($data == 'sex') {
                    $file_name = "EXPORT_TABLE_VALEURS_SEXES_".date('dmYhis',time()).".xls";
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment; filename="'.$file_name.'"');

                    require "../_CONFIGS/Classes/SEXES.php";
                    $SEXES = new SEXES();
                    $sexes = $SEXES->lister();
                    $nb_sexes = count($sexes);
                    if($nb_sexes != 0) {

                        $row = 1;
                        $sheet->getStyle('D'.$row.':L'.$row)->applyFromArray($style_titre);
                        $sheet->setCellValue('D'.$row, 'TABLE DE VALEURS: SEXES');
                        $sheet->mergeCells('D'.$row.':L'.($row = $row+2));
                        $sheet->getStyle('D1'.':L'.$row)
                            ->getBorders()
                            ->getAllBorders()
                            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

                        $row++;
                        $sheet->getStyle('A'.$row.':L'.$row)->applyFromArray($style_entete);
                        $sheet->mergeCells('C'.$row.':J'.$row);
                        $sheet->mergeCells('K'.$row.':L'.$row);
                        $sheet->setCellValue('A'.$row, 'N°');
                        $sheet->setCellValue('B'.$row, 'CODE');
                        $sheet->setCellValue('C'.$row, 'LIBELLE');
                        $sheet->setCellValue('K'.$row, 'DATE EFFET');
                        $ligne = 1;
                        foreach ($sexes as $sexe) {
                            $row++;
                            $sheet->getStyle('A'.$row.':L'.$row)->applyFromArray($style_tableau);
                            $sheet->mergeCells('C'.$row.':J'.$row);
                            $sheet->mergeCells('K'.$row.':L'.$row);
                            $sheet->setCellValue('A'.$row, $ligne);
                            $sheet->setCellValue('B'.$row, $sexe['code']);
                            $sheet->setCellValue('C'.$row, $sexe['libelle']);
                            $spreadsheet->getActiveSheet()->getStyle('K'.$row)
                                ->getNumberFormat()
                                ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                            $sheet->setCellValue('K'.$row, date('d/m/Y',strtotime($sexe['date_debut'])));
                            $ligne++;
                        }

                        $writer = new Xlsx($spreadsheet);
                        $writer->save("php://output");
                    }
                }
                elseif ($data == 'typ_pers') {
                    $file_name = "EXPORT_TABLE_VALEURS_TYPES_PERSONNES_".date('dmYhis',time()).".xls";
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment; filename="'.$file_name.'"');

                    require "../_CONFIGS/Classes/TYPESPERSONNES.php";
                    $TYPESPERSONNES = new TYPESPERSONNES();
                    $types_personnes = $TYPESPERSONNES->lister();
                    $nb_types_personnes_ecu = count($types_personnes);
                    if($nb_types_personnes_ecu != 0) {

                        $row = 1;
                        $sheet->getStyle('D'.$row.':L'.$row)->applyFromArray($style_titre);
                        $sheet->setCellValue('D'.$row, 'TABLE DE VALEURS: TYPES PERSONNES ECU');
                        $sheet->mergeCells('D'.$row.':L'.($row = $row+2));
                        $sheet->getStyle('D1'.':L'.$row)
                            ->getBorders()
                            ->getAllBorders()
                            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

                        $row++;
                        $sheet->getStyle('A'.$row.':L'.$row)->applyFromArray($style_entete);
                        $sheet->mergeCells('C'.$row.':J'.$row);
                        $sheet->mergeCells('K'.$row.':L'.$row);
                        $sheet->setCellValue('A'.$row, 'N°');
                        $sheet->setCellValue('B'.$row, 'CODE');
                        $sheet->setCellValue('C'.$row, 'LIBELLE');
                        $sheet->setCellValue('K'.$row, 'DATE EFFET');
                        $ligne = 1;
                        foreach ($types_personnes as $types_personne) {
                            $row++;
                            $sheet->getStyle('A'.$row.':L'.$row)->applyFromArray($style_tableau);
                            $sheet->mergeCells('C'.$row.':J'.$row);
                            $sheet->mergeCells('K'.$row.':L'.$row);
                            $sheet->setCellValue('A'.$row, $ligne);
                            $sheet->setCellValue('B'.$row, $types_personne['code']);
                            $sheet->setCellValue('C'.$row, $types_personne['libelle']);
                            $spreadsheet->getActiveSheet()->getStyle('K'.$row)
                                ->getNumberFormat()
                                ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                            $sheet->setCellValue('K'.$row, date('d/m/Y',strtotime($types_personne['date_debut'])));
                            $ligne++;
                        }

                        $writer = new Xlsx($spreadsheet);
                        $writer->save("php://output");
                    }
                }
                elseif ($data == 'tac') {
                    $file_name = "EXPORT_TABLE_VALEURS_TYPES_ACCIDENTS_".date('dmYhis',time()).".xls";
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment; filename="'.$file_name.'"');

                    require "../_CONFIGS/Classes/TYPESACCIDENTS.php";
                    $TYPESACCIDENTS = new TYPESACCIDENTS();
                    $typesaccidents = $TYPESACCIDENTS->lister();
                    $nb_typesaccidents = count($typesaccidents);
                    if($nb_typesaccidents != 0) {

                        $row = 1;
                        $sheet->getStyle('D'.$row.':L'.$row)->applyFromArray($style_titre);
                        $sheet->setCellValue('D'.$row, 'TABLE DE VALEURS: TYPES ACCIDENTS');
                        $sheet->mergeCells('D'.$row.':L'.($row = $row+2));
                        $sheet->getStyle('D1'.':L'.$row)
                            ->getBorders()
                            ->getAllBorders()
                            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

                        $row++;
                        $sheet->getStyle('A'.$row.':L'.$row)->applyFromArray($style_entete);
                        $sheet->mergeCells('C'.$row.':J'.$row);
                        $sheet->mergeCells('K'.$row.':L'.$row);
                        $sheet->setCellValue('A'.$row, 'N°');
                        $sheet->setCellValue('B'.$row, 'CODE');
                        $sheet->setCellValue('C'.$row, 'LIBELLE');
                        $sheet->setCellValue('K'.$row, 'DATE EFFET');
                        $ligne = 1;
                        foreach ($typesaccidents as $typesaccident) {
                            $row++;
                            $sheet->getStyle('A'.$row.':L'.$row)->applyFromArray($style_tableau);
                            $sheet->mergeCells('C'.$row.':J'.$row);
                            $sheet->mergeCells('K'.$row.':L'.$row);
                            $sheet->setCellValue('A'.$row, $ligne);
                            $sheet->setCellValue('B'.$row, $typesaccident['code']);
                            $sheet->setCellValue('C'.$row, $typesaccident['libelle']);
                            $spreadsheet->getActiveSheet()->getStyle('K'.$row)
                                ->getNumberFormat()
                                ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                            $sheet->setCellValue('K'.$row, date('d/m/Y',strtotime($typesaccident['date_debut'])));
                            $ligne++;
                        }

                        $writer = new Xlsx($spreadsheet);
                        $writer->save("php://output");
                    }
                }
                elseif ($data == 'sif') {
                    $file_name = "EXPORT_TABLE_VALEURS_SITUATIONS_FAMILIALES_".date('dmYhis',time()).".xls";
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment; filename="'.$file_name.'"');

                    require "../_CONFIGS/Classes/SITUATIONSFAMILIALES.php";
                    $SITUATIONFAMILLES = new SITUATIONSFAMILIALES();
                    $situationfamilles = $SITUATIONFAMILLES->lister();
                    $nb_situationfamilles = count($situationfamilles);
                    if($nb_situationfamilles != 0) {

                        $row = 1;
                        $sheet->getStyle('D'.$row.':L'.$row)->applyFromArray($style_titre);
                        $sheet->setCellValue('D'.$row, 'TABLE DE VALEURS: SITUATIONS FAMILIALES');
                        $sheet->mergeCells('D'.$row.':L'.($row = $row+2));
                        $sheet->getStyle('D1'.':L'.$row)
                            ->getBorders()
                            ->getAllBorders()
                            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

                        $row++;
                        $sheet->getStyle('A'.$row.':L'.$row)->applyFromArray($style_entete);
                        $sheet->mergeCells('C'.$row.':J'.$row);
                        $sheet->mergeCells('K'.$row.':L'.$row);
                        $sheet->setCellValue('A'.$row, 'N°');
                        $sheet->setCellValue('B'.$row, 'CODE');
                        $sheet->setCellValue('C'.$row, 'LIBELLE');
                        $sheet->setCellValue('K'.$row, 'DATE EFFET');
                        $ligne = 1;
                        foreach ($situationfamilles as $situationfamille) {
                            $row++;
                            $sheet->getStyle('A'.$row.':L'.$row)->applyFromArray($style_tableau);
                            $sheet->mergeCells('C'.$row.':J'.$row);
                            $sheet->mergeCells('K'.$row.':L'.$row);
                            $sheet->setCellValue('A'.$row, $ligne);
                            $sheet->setCellValue('B'.$row, $situationfamille['code']);
                            $sheet->setCellValue('C'.$row, $situationfamille['libelle']);
                            $spreadsheet->getActiveSheet()->getStyle('K'.$row)
                                ->getNumberFormat()
                                ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                            $sheet->setCellValue('K'.$row, date('d/m/Y',strtotime($situationfamille['date_debut'])));
                            $ligne++;
                        }

                        $writer = new Xlsx($spreadsheet);
                        $writer->save("php://output");
                    }
                }
                elseif ($data == 'sct') {
                    $file_name = "EXPORT_TABLE_VALEURS_SECTEURS_ACTIVTES_".date('dmYhis',time()).".xls";
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment; filename="'.$file_name.'"');

                    require "../_CONFIGS/Classes/SECTEURSACTIVITES.php";
                    $SECTEURSACTVITES = new SECTEURSACTIVITES();
                    $secteursactivites = $SECTEURSACTVITES->lister();
                    $nb_secteursactivites = count($secteursactivites);
                    if($nb_secteursactivites != 0) {

                        $row = 1;
                        $sheet->getStyle('D'.$row.':L'.$row)->applyFromArray($style_titre);
                        $sheet->setCellValue('D'.$row, 'TABLE DE VALEURS: SECTEURS ACTIVITES');
                        $sheet->mergeCells('D'.$row.':L'.($row = $row+2));
                        $sheet->getStyle('D1'.':L'.$row)
                            ->getBorders()
                            ->getAllBorders()
                            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

                        $row++;
                        $sheet->getStyle('A'.$row.':L'.$row)->applyFromArray($style_entete);
                        $sheet->mergeCells('C'.$row.':J'.$row);
                        $sheet->mergeCells('K'.$row.':L'.$row);
                        $sheet->setCellValue('A'.$row, 'N°');
                        $sheet->setCellValue('B'.$row, 'CODE');
                        $sheet->setCellValue('C'.$row, 'LIBELLE');
                        $sheet->setCellValue('K'.$row, 'DATE EFFET');
                        $ligne = 1;
                        foreach ($secteursactivites as $secteursactivite) {
                            $row++;
                            $sheet->getStyle('A'.$row.':L'.$row)->applyFromArray($style_tableau);
                            $sheet->mergeCells('C'.$row.':J'.$row);
                            $sheet->mergeCells('K'.$row.':L'.$row);
                            $sheet->setCellValue('A'.$row, $ligne);
                            $sheet->setCellValue('B'.$row, $secteursactivite['code']);
                            $sheet->setCellValue('C'.$row, $secteursactivite['libelle']);
                            $spreadsheet->getActiveSheet()->getStyle('K'.$row)
                                ->getNumberFormat()
                                ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                            $sheet->setCellValue('K'.$row, date('d/m/Y',strtotime($secteursactivite['date_debut'])));
                            $ligne++;
                        }

                        $writer = new Xlsx($spreadsheet);
                        $writer->save("php://output");
                    }
                }
                elseif ($data == 'prf') {
                    $file_name = "EXPORT_TABLE_VALEURS_PROFESSIONS_".date('dmYhis',time()).".xls";
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment; filename="'.$file_name.'"');

                    require "../_CONFIGS/Classes/PROFESSIONS.php";
                    $PROFESSIONS = new PROFESSIONS();
                    $professions = $PROFESSIONS->lister();
                    $nb_professions = count($professions);
                    if($nb_professions != 0) {

                        $row = 1;
                        $sheet->getStyle('D'.$row.':L'.$row)->applyFromArray($style_titre);
                        $sheet->setCellValue('D'.$row, 'TABLE DE VALEURS: PROFESSIONS');
                        $sheet->mergeCells('D'.$row.':L'.($row = $row+2));
                        $sheet->getStyle('D1'.':L'.$row)
                            ->getBorders()
                            ->getAllBorders()
                            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

                        $row++;
                        $sheet->getStyle('A'.$row.':L'.$row)->applyFromArray($style_entete);
                        $sheet->mergeCells('C'.$row.':J'.$row);
                        $sheet->mergeCells('K'.$row.':L'.$row);
                        $sheet->setCellValue('A'.$row, 'N°');
                        $sheet->setCellValue('B'.$row, 'CODE');
                        $sheet->setCellValue('C'.$row, 'LIBELLE');
                        $sheet->setCellValue('K'.$row, 'DATE EFFET');
                        $ligne = 1;
                        foreach ($professions as $profession) {
                            $row++;
                            $sheet->getStyle('A'.$row.':L'.$row)->applyFromArray($style_tableau);
                            $sheet->mergeCells('C'.$row.':J'.$row);
                            $sheet->mergeCells('K'.$row.':L'.$row);
                            $sheet->setCellValue('A'.$row, $ligne);
                            $sheet->setCellValue('B'.$row, $profession['code']);
                            $sheet->setCellValue('C'.$row, $profession['libelle']);
                            $spreadsheet->getActiveSheet()->getStyle('K'.$row)
                                ->getNumberFormat()
                                ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                            $sheet->setCellValue('K'.$row, date('d/m/Y',strtotime($profession['date_debut'])));
                            $ligne++;
                        }

                        $writer = new Xlsx($spreadsheet);
                        $writer->save("php://output");
                    }
                }
                elseif ($data == 'qtc') {
                    $file_name = "EXPORT_TABLE_VALEURS_QUALITES_CIVILITES_".date('dmYhis',time()).".xls";
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment; filename="'.$file_name.'"');

                    require "../_CONFIGS/Classes/QUALITESCIVILES.php";
                    $QUALITESCIVILTES = new QUALITESCIVILES();
                    $qualitesciviles = $QUALITESCIVILTES->lister();
                    $nb_qualitesciviles = count($qualitesciviles);
                    if($nb_qualitesciviles != 0) {

                        $row = 1;
                        $sheet->getStyle('D'.$row.':L'.$row)->applyFromArray($style_titre);
                        $sheet->setCellValue('D'.$row, 'TABLE DE VALEURS: QUALITES CIVILITES');
                        $sheet->mergeCells('D'.$row.':L'.($row = $row+2));
                        $sheet->getStyle('D1'.':L'.$row)
                            ->getBorders()
                            ->getAllBorders()
                            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

                        $row++;
                        $sheet->getStyle('A'.$row.':L'.$row)->applyFromArray($style_entete);
                        $sheet->mergeCells('C'.$row.':J'.$row);
                        $sheet->mergeCells('K'.$row.':L'.$row);
                        $sheet->setCellValue('A'.$row, 'N°');
                        $sheet->setCellValue('B'.$row, 'CODE');
                        $sheet->setCellValue('C'.$row, 'LIBELLE');
                        $sheet->setCellValue('K'.$row, 'DATE EFFET');
                        $ligne = 1;
                        foreach ($qualitesciviles as $qualitescivile) {
                            $row++;
                            $sheet->getStyle('A'.$row.':L'.$row)->applyFromArray($style_tableau);
                            $sheet->mergeCells('C'.$row.':J'.$row);
                            $sheet->mergeCells('K'.$row.':L'.$row);
                            $sheet->setCellValue('A'.$row, $ligne);
                            $sheet->setCellValue('B'.$row, $qualitescivile['code']);
                            $sheet->setCellValue('C'.$row, $qualitescivile['libelle']);
                            $spreadsheet->getActiveSheet()->getStyle('K'.$row)
                                ->getNumberFormat()
                                ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                            $sheet->setCellValue('K'.$row, date('d/m/Y',strtotime($qualitescivile['date_debut'])));
                            $ligne++;
                        }

                        $writer = new Xlsx($spreadsheet);
                        $writer->save("php://output");
                    }
                }
                elseif ($data == 'tco') {
                    $file_name = "EXPORT_TABLE_VALEURS_TYPES_COORDONNEES_".date('dmYhis',time()).".xls";
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment; filename="'.$file_name.'"');

                    require "../_CONFIGS/Classes/TYPESCOORDONNEES.php";
                    $TYPESCOORDONNEES = new QUALITESCIVILES();
                    $typescoordonnees = $TYPESCOORDONNEES->lister();
                    $nb_typescoordonnees = count($typescoordonnees);
                    if($nb_typescoordonnees != 0) {

                        $row = 1;
                        $sheet->getStyle('D'.$row.':L'.$row)->applyFromArray($style_titre);
                        $sheet->setCellValue('D'.$row, 'TABLE DE VALEURS: TYPES COORDONNEES');
                        $sheet->mergeCells('D'.$row.':L'.($row = $row+2));
                        $sheet->getStyle('D1'.':L'.$row)
                            ->getBorders()
                            ->getAllBorders()
                            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

                        $row++;
                        $sheet->getStyle('A'.$row.':L'.$row)->applyFromArray($style_entete);
                        $sheet->mergeCells('C'.$row.':J'.$row);
                        $sheet->mergeCells('K'.$row.':L'.$row);
                        $sheet->setCellValue('A'.$row, 'N°');
                        $sheet->setCellValue('B'.$row, 'CODE');
                        $sheet->setCellValue('C'.$row, 'LIBELLE');
                        $sheet->setCellValue('K'.$row, 'DATE EFFET');
                        $ligne = 1;
                        foreach ($typescoordonnees as $typescoordonnee) {
                            $row++;
                            $sheet->getStyle('A'.$row.':L'.$row)->applyFromArray($style_tableau);
                            $sheet->mergeCells('C'.$row.':J'.$row);
                            $sheet->mergeCells('K'.$row.':L'.$row);
                            $sheet->setCellValue('A'.$row, $ligne);
                            $sheet->setCellValue('B'.$row, $typescoordonnee['code']);
                            $sheet->setCellValue('C'.$row, $typescoordonnee['libelle']);
                            $spreadsheet->getActiveSheet()->getStyle('K'.$row)
                                ->getNumberFormat()
                                ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                            $sheet->setCellValue('K'.$row, date('d/m/Y',strtotime($typescoordonnee['date_debut'])));
                            $ligne++;
                        }

                        $writer = new Xlsx($spreadsheet);
                        $writer->save("php://output");
                    }
                }
                elseif ($data == 'tpi') {
                    $file_name = "EXPORT_TABLE_VALEURS_TYPES_PIECES_INDENTITES_".date('dmYhis',time()).".xls";
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment; filename="'.$file_name.'"');

                    require "../_CONFIGS/Classes/TYPESPIECESIDENTITES.php";
                    $TYPESPIECESIDENTITES = new TYPESPIECESIDENTITES();
                    $typespiecesidentites = $TYPESPIECESIDENTITES->lister();
                    $nb_typespiecesidentites = count($typespiecesidentites);
                    if($nb_typespiecesidentites != 0) {

                        $row = 1;
                        $sheet->getStyle('D'.$row.':L'.$row)->applyFromArray($style_titre);
                        $sheet->setCellValue('D'.$row, 'TABLE DE VALEURS: TYPES PIECES IDENTITES');
                        $sheet->mergeCells('D'.$row.':L'.($row = $row+2));
                        $sheet->getStyle('D1'.':L'.$row)
                            ->getBorders()
                            ->getAllBorders()
                            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

                        $row++;
                        $sheet->getStyle('A'.$row.':L'.$row)->applyFromArray($style_entete);
                        $sheet->mergeCells('C'.$row.':J'.$row);
                        $sheet->mergeCells('K'.$row.':L'.$row);
                        $sheet->setCellValue('A'.$row, 'N°');
                        $sheet->setCellValue('B'.$row, 'CODE');
                        $sheet->setCellValue('C'.$row, 'LIBELLE');
                        $sheet->setCellValue('K'.$row, 'DATE EFFET');
                        $ligne = 1;
                        foreach ($typespiecesidentites as $typespiecesidentite) {
                            $row++;
                            $sheet->getStyle('A'.$row.':L'.$row)->applyFromArray($style_tableau);
                            $sheet->mergeCells('C'.$row.':J'.$row);
                            $sheet->mergeCells('K'.$row.':L'.$row);
                            $sheet->setCellValue('A'.$row, $ligne);
                            $sheet->setCellValue('B'.$row, $typespiecesidentite['code']);
                            $sheet->setCellValue('C'.$row, $typespiecesidentite['libelle']);
                            $spreadsheet->getActiveSheet()->getStyle('K'.$row)
                                ->getNumberFormat()
                                ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                            $sheet->setCellValue('K'.$row, date('d/m/Y',strtotime($typespiecesidentite['date_debut'])));
                            $ligne++;
                        }

                        $writer = new Xlsx($spreadsheet);
                        $writer->save("php://output");
                    }
                }
                elseif ($data == 'dev') {
                    $file_name = "EXPORT_TABLE_VALEURS_DEVISES_MONETAIRES_".date('dmYhis',time()).".xls";
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment; filename="'.$file_name.'"');

                    require "../_CONFIGS/Classes/DEVISESMONETAIRES.php";
                    $DEVISES = new DEVISESMONETAIRES();
                    $devises = $DEVISES->lister();
                    $nb_devises = count($devises);
                    if($nb_devises != 0) {

                        $row = 1;
                        $sheet->getStyle('D'.$row.':L'.$row)->applyFromArray($style_titre);
                        $sheet->setCellValue('D'.$row, 'TABLE DE VALEURS: DEVISES MONETAIRES');
                        $sheet->mergeCells('D'.$row.':L'.($row = $row+2));
                        $sheet->getStyle('D1'.':L'.$row)
                            ->getBorders()
                            ->getAllBorders()
                            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

                        $row++;
                        $sheet->getStyle('A'.$row.':L'.$row)->applyFromArray($style_entete);
                        $sheet->mergeCells('C'.$row.':J'.$row);
                        $sheet->mergeCells('K'.$row.':L'.$row);
                        $sheet->setCellValue('A'.$row, 'N°');
                        $sheet->setCellValue('B'.$row, 'CODE');
                        $sheet->setCellValue('C'.$row, 'LIBELLE');
                        $sheet->setCellValue('K'.$row, 'DATE EFFET');
                        $ligne = 1;
                        foreach ($devises as $devise) {
                            $row++;
                            $sheet->getStyle('A'.$row.':L'.$row)->applyFromArray($style_tableau);
                            $sheet->mergeCells('C'.$row.':J'.$row);
                            $sheet->mergeCells('K'.$row.':L'.$row);
                            $sheet->setCellValue('A'.$row, $ligne);
                            $sheet->setCellValue('B'.$row, $devise['code']);
                            $sheet->setCellValue('C'.$row, $devise['libelle']);
                            $spreadsheet->getActiveSheet()->getStyle('K'.$row)
                                ->getNumberFormat()
                                ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                            $sheet->setCellValue('K'.$row, date('d/m/Y',strtotime($devise['date_debut'])));
                            $ligne++;
                        }

                        $writer = new Xlsx($spreadsheet);
                        $writer->save("php://output");
                    }
                }
                elseif ($data == 'gsa') {
                    $file_name = "EXPORT_TABLE_VALEURS_GROUPES_SANGUINS_".date('dmYhis',time()).".xls";
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment; filename="'.$file_name.'"');

                    require "../_CONFIGS/Classes/GROUPESSANGUINS.php";
                    $GROUPESSANGUINS = new GROUPESSANGUINS();
                    $groupesanguins = $GROUPESSANGUINS->lister();
                    $nb_groupesanguins = count($groupesanguins);
                    if($nb_groupesanguins != 0) {

                        $row = 1;
                        $sheet->getStyle('D'.$row.':L'.$row)->applyFromArray($style_titre);
                        $sheet->setCellValue('D'.$row, 'TABLE DE VALEURS: GROUPES SANGUINS');
                        $sheet->mergeCells('D'.$row.':L'.($row = $row+2));
                        $sheet->getStyle('D1'.':L'.$row)
                            ->getBorders()
                            ->getAllBorders()
                            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

                        $row++;
                        $sheet->getStyle('A'.$row.':L'.$row)->applyFromArray($style_entete);
                        $sheet->mergeCells('C'.$row.':J'.$row);
                        $sheet->mergeCells('K'.$row.':L'.$row);
                        $sheet->setCellValue('A'.$row, 'N°');
                        $sheet->setCellValue('B'.$row, 'CODE');
                        $sheet->setCellValue('C'.$row, 'LIBELLE');
                        $sheet->setCellValue('K'.$row, 'DATE EFFET');
                        $ligne = 1;
                        foreach ($groupesanguins as $groupesanguin) {
                            $row++;
                            $sheet->getStyle('A'.$row.':L'.$row)->applyFromArray($style_tableau);
                            $sheet->mergeCells('C'.$row.':J'.$row);
                            $sheet->mergeCells('K'.$row.':L'.$row);
                            $sheet->setCellValue('A'.$row, $ligne);
                            $sheet->setCellValue('B'.$row, $groupesanguin['code']);
                            $sheet->setCellValue('C'.$row, $groupesanguin['libelle']);
                            $spreadsheet->getActiveSheet()->getStyle('K'.$row)
                                ->getNumberFormat()
                                ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                            $sheet->setCellValue('K'.$row, date('d/m/Y',strtotime($groupesanguin['date_debut'])));
                            $ligne++;
                        }

                        $writer = new Xlsx($spreadsheet);
                        $writer->save("php://output");
                    }
                }
                elseif ($data == 'rhs') {
                    $file_name = "EXPORT_TABLE_VALEURS_RHESUS_SANGUINS_".date('dmYhis',time()).".xls";
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment; filename="'.$file_name.'"');

                    require "../_CONFIGS/Classes/GROUPESSANGUINS.php";
                    $RHESUS = new GROUPESSANGUINS();
                    $groupesanguins = $RHESUS->lister();
                    $nb_rhesus = count($groupesanguins);
                    if($nb_rhesus != 0) {
                        $row = 1;
                        $sheet->getStyle('D'.$row.':L'.$row)->applyFromArray($style_titre);
                        $sheet->setCellValue('D'.$row, 'TABLE DE VALEURS: RHESUS SANGUINS');
                        $sheet->mergeCells('D'.$row.':L'.($row = $row+2));
                        $sheet->getStyle('D1'.':L'.$row)
                            ->getBorders()
                            ->getAllBorders()
                            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

                        $row++;
                        $sheet->getStyle('A'.$row.':L'.$row)->applyFromArray($style_entete);
                        $sheet->mergeCells('C'.$row.':J'.$row);
                        $sheet->mergeCells('K'.$row.':L'.$row);
                        $sheet->setCellValue('A'.$row, 'N°');
                        $sheet->setCellValue('B'.$row, 'CODE');
                        $sheet->setCellValue('C'.$row, 'LIBELLE');
                        $sheet->setCellValue('K'.$row, 'DATE EFFET');
                        $ligne = 1;
                        foreach ($groupesanguins as $rhesus) {
                            $row++;
                            $sheet->getStyle('A'.$row.':L'.$row)->applyFromArray($style_tableau);
                            $sheet->mergeCells('C'.$row.':J'.$row);
                            $sheet->mergeCells('K'.$row.':L'.$row);
                            $sheet->setCellValue('A'.$row, $ligne);
                            $sheet->setCellValue('B'.$row, $rhesus['code']);
                            $sheet->setCellValue('C'.$row, $rhesus['libelle']);
                            $spreadsheet->getActiveSheet()->getStyle('K'.$row)
                                ->getNumberFormat()
                                ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                            $sheet->setCellValue('K'.$row, date('d/m/Y',strtotime($rhesus['date_debut'])));
                            $ligne++;
                        }

                        $writer = new Xlsx($spreadsheet);
                        $writer->save("php://output");
                    }
                }
                elseif ($data == 'lge') {
                    $file_name = "EXPORT_TABLE_VALEURS_PAYS_".date('dmYhis',time()).".xls";
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment; filename="'.$file_name.'"');

                    require "../_CONFIGS/Classes/LOCALISATIONSGEOGRAPHIQUES.php";
                    $LOCALISATIONSGEOGRAPHIQUES = new LOCALISATIONSGEOGRAPHIQUES();
                    $pays = $LOCALISATIONSGEOGRAPHIQUES->lister_pays();
                    $nb_pays = count($pays);
                    if($nb_pays != 0) {
                        $row = 1;
                        $sheet->getStyle('D'.$row.':O'.$row)->applyFromArray($style_titre);
                        $sheet->setCellValue('D'.$row, 'TABLE DE VALEURS: PAYS');
                        $sheet->mergeCells('D'.$row.':O'.($row = $row+2));
                        $sheet->getStyle('D1'.':O'.$row)
                            ->getBorders()
                            ->getAllBorders()
                            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

                        $row++;
                        $sheet->getStyle('A'.$row.':O'.$row)->applyFromArray($style_entete);
                        $sheet->mergeCells('C'.$row.':E'.$row);
                        $sheet->mergeCells('F'.$row.':G'.$row);
                        $sheet->mergeCells('H'.$row.':I'.$row);
                        $sheet->mergeCells('J'.$row.':K'.$row);
                        $sheet->mergeCells('L'.$row.':M'.$row);
                        $sheet->mergeCells('M'.$row.':N'.$row);
                        $sheet->setCellValue('A'.$row, 'N°');
                        $sheet->setCellValue('B'.$row, 'CODE');
                        $sheet->setCellValue('C'.$row, 'NOM');
                        $sheet->setCellValue('F'.$row, 'GENTILE');
                        $sheet->setCellValue('H'.$row, 'INDICATIF MONETAIRE');
                        $sheet->setCellValue('J'.$row, 'DEVISE MONETAIRE');
                        $sheet->setCellValue('L'.$row, 'COORDONNEES');
                        $sheet->setCellValue('N'.$row, 'DATE EFFET');
                        $ligne = 1;
                        foreach ($pays as $tbpays) {
                            $row++;
                            $sheet->getStyle('A'.$row.':O'.$row)->applyFromArray($style_tableau);
                            $sheet->mergeCells('C'.$row.':E'.$row);
                            $sheet->mergeCells('F'.$row.':G'.$row);
                            $sheet->mergeCells('H'.$row.':I'.$row);
                            $sheet->mergeCells('J'.$row.':K'.$row);
                            $sheet->mergeCells('L'.$row.':M'.$row);
                            $sheet->mergeCells('N'.$row.':O'.$row);
                            $sheet->setCellValue('A'.$row, $ligne);
                            $sheet->setCellValue('B'.$row, $tbpays['code']);
                            $sheet->setCellValue('C'.$row, $tbpays['nom']);
                            $sheet->setCellValue('F'.$row, $tbpays['gentile']);
                            $sheet->setCellValue('H'.$row, $tbpays['indicatif_telephonique']);
                            $sheet->setCellValue('J'.$row, $tbpays['devise']);
                            $sheet->setCellValue('L'.$row, $tbpays['latitude'].';'.$tbpays['longitude']);
                            $spreadsheet->getActiveSheet()->getStyle('N'.$row)
                                ->getNumberFormat()
                                ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                            $sheet->setCellValue('N'.$row, date('d/m/Y',strtotime($tbpays['date_debut'])));
                            $ligne++;
                        }

                        $writer = new Xlsx($spreadsheet);
                        $writer->save("php://output");
                    }
                }
                elseif ($data == 'reg') {
                    $file_name = "EXPORT_TABLE_VALEURS_REGIONS_".date('dmYhis',time()).".xls";
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment; filename="'.$file_name.'"');

                    require "../_CONFIGS/Classes/LOCALISATIONSGEOGRAPHIQUES.php";
                    $LOCALISATIONSGEOGRAPHIQUES = new LOCALISATIONSGEOGRAPHIQUES();
                    $regions = $LOCALISATIONSGEOGRAPHIQUES->lister_regions(null);
                    $nb_regions = count($regions);
                    if($nb_regions != 0) {
                        $row = 1;
                        $sheet->getStyle('D'.$row.':M'.$row)->applyFromArray($style_titre);
                        $sheet->setCellValue('D'.$row, 'TABLE DE VALEURS: REGIONS');
                        $sheet->mergeCells('D'.$row.':M'.($row = $row+2));
                        $sheet->getStyle('D1'.':M'.$row)
                            ->getBorders()
                            ->getAllBorders()
                            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

                        $row++;
                        $sheet->getStyle('A'.$row.':M'.$row)->applyFromArray($style_entete);
                        $sheet->mergeCells('C'.$row.':E'.$row);
                        $sheet->mergeCells('F'.$row.':G'.$row);
                        $sheet->mergeCells('H'.$row.':J'.$row);
                        $sheet->mergeCells('K'.$row.':M'.$row);
                        $sheet->setCellValue('A'.$row, 'N°');
                        $sheet->setCellValue('B'.$row, 'CODE');
                        $sheet->setCellValue('C'.$row, 'NOM');
                        $sheet->setCellValue('F'.$row, 'PAYS');
                        $sheet->setCellValue('H'.$row, 'COORDONNEES');
                        $sheet->setCellValue('K'.$row, 'DATE EFFET');
                        $ligne = 1;
                        foreach ($regions as $region) {
                            $row++;
                            $sheet->getStyle('A'.$row.':M'.$row)->applyFromArray($style_tableau);
                            $sheet->mergeCells('C'.$row.':E'.$row);
                            $sheet->mergeCells('F'.$row.':G'.$row);
                            $sheet->mergeCells('H'.$row.':J'.$row);
                            $sheet->mergeCells('K'.$row.':M'.$row);
                            $sheet->setCellValue('A'.$row, $ligne);
                            $sheet->setCellValue('B'.$row, $region['code']);
                            $sheet->setCellValue('C'.$row, $region['nom']);
                            $sheet->setCellValue('F'.$row, $region['pays_nom']);
                            $sheet->setCellValue('H'.$row, $region['latitude'].';'.$region['longitude']);
                            $spreadsheet->getActiveSheet()->getStyle('K'.$row)
                                ->getNumberFormat()
                                ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                            $sheet->setCellValue('K'.$row, date('d/m/Y',strtotime($region['date_debut'])));
                            $ligne++;
                        }

                        $writer = new Xlsx($spreadsheet);
                        $writer->save("php://output");
                    }
                }
                elseif ($data == 'dep') {
                    $file_name = "EXPORT_TABLE_VALEURS_DEPARTEMENTS_".date('dmYhis',time()).".xls";
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment; filename="'.$file_name.'"');

                    require "../_CONFIGS/Classes/LOCALISATIONSGEOGRAPHIQUES.php";
                    $LOCALISATIONSGEOGRAPHIQUES = new LOCALISATIONSGEOGRAPHIQUES();
                    $regions = $LOCALISATIONSGEOGRAPHIQUES->lister_departements(null);
                    $nb_regions = count($regions);
                    if($nb_regions != 0) {
                        $row = 1;
                        $sheet->getStyle('D'.$row.':O'.$row)->applyFromArray($style_titre);
                        $sheet->setCellValue('D'.$row, 'TABLE DE VALEURS: DEPARTEMENT');
                        $sheet->mergeCells('D'.$row.':O'.($row = $row+2));
                        $sheet->getStyle('D1'.':O'.$row)
                            ->getBorders()
                            ->getAllBorders()
                            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

                        $row++;
                        $sheet->getStyle('A'.$row.':O'.$row)->applyFromArray($style_entete);
                        $sheet->mergeCells('C'.$row.':E'.$row);
                        $sheet->mergeCells('F'.$row.':G'.$row);
                        $sheet->mergeCells('H'.$row.':J'.$row);
                        $sheet->mergeCells('K'.$row.':M'.$row);
                        $sheet->mergeCells('N'.$row.':O'.$row);
                        $sheet->setCellValue('A'.$row, 'N°');
                        $sheet->setCellValue('B'.$row, 'CODE');
                        $sheet->setCellValue('C'.$row, 'NOM');
                        $sheet->setCellValue('F'.$row, 'PAYS');
                        $sheet->setCellValue('H'.$row, 'REGION');
                        $sheet->setCellValue('K'.$row, 'COORDONNEES');
                        $sheet->setCellValue('N'.$row, 'DATE EFFET');
                        $ligne = 1;
                        foreach ($regions as $region) {
                            $row++;
                            $sheet->getStyle('A'.$row.':O'.$row)->applyFromArray($style_tableau);
                            $sheet->mergeCells('C'.$row.':E'.$row);
                            $sheet->mergeCells('F'.$row.':G'.$row);
                            $sheet->mergeCells('H'.$row.':J'.$row);
                            $sheet->mergeCells('K'.$row.':M'.$row);
                            $sheet->mergeCells('N'.$row.':O'.$row);
                            $sheet->setCellValue('A'.$row, $ligne);
                            $sheet->setCellValue('B'.$row, $region['code']);
                            $sheet->setCellValue('C'.$row, $region['nom']);
                            $sheet->setCellValue('F'.$row, $region['nom_pays']);
                            $sheet->setCellValue('H'.$row, $region['nom_region']);
                            $sheet->setCellValue('K'.$row, $region['latitude'].';'.$region['longitude']);
                            $spreadsheet->getActiveSheet()->getStyle('O'.$row)
                                ->getNumberFormat()
                                ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                            $sheet->setCellValue('N'.$row, date('d/m/Y',strtotime($region['date_debut'])));
                            $ligne++;
                        }

                        $writer = new Xlsx($spreadsheet);
                        $writer->save("php://output");
                    }
                }
                elseif ($data == 'com') {
                    $file_name = "EXPORT_TABLE_VALEURS_COMMUNES_".date('dmYhis',time()).".xls";
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment; filename="'.$file_name.'"');

                    require "../_CONFIGS/Classes/LOCALISATIONSGEOGRAPHIQUES.php";
                    $LOCALISATIONSGEOGRAPHIQUES = new LOCALISATIONSGEOGRAPHIQUES();
                    $regions = $LOCALISATIONSGEOGRAPHIQUES->lister_communes(null);
                    $nb_regions = count($regions);
                    if($nb_regions != 0) {
                        $row = 1;
                        $sheet->getStyle('D'.$row.':Q'.$row)->applyFromArray($style_titre);
                        $sheet->setCellValue('D'.$row, 'TABLE DE VALEURS: COMMUNES');
                        $sheet->mergeCells('D'.$row.':Q'.($row = $row+2));
                        $sheet->getStyle('D1'.':Q'.$row)
                            ->getBorders()
                            ->getAllBorders()
                            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

                        $row++;
                        $sheet->getStyle('A'.$row.':Q'.$row)->applyFromArray($style_entete);
                        $sheet->mergeCells('C'.$row.':E'.$row);
                        $sheet->mergeCells('F'.$row.':G'.$row);
                        $sheet->mergeCells('H'.$row.':J'.$row);
                        $sheet->mergeCells('K'.$row.':M'.$row);
                        $sheet->mergeCells('N'.$row.':O'.$row);
                        $sheet->mergeCells('p'.$row.':Q'.$row);
                        $sheet->setCellValue('A'.$row, 'N°');
                        $sheet->setCellValue('B'.$row, 'CODE');
                        $sheet->setCellValue('C'.$row, 'NOM');
                        $sheet->setCellValue('F'.$row, 'PAYS');
                        $sheet->setCellValue('H'.$row, 'REGION');
                        $sheet->setCellValue('K'.$row, 'DEPARTEMENT');
                        $sheet->setCellValue('N'.$row, 'COORDONNEES');
                        $sheet->setCellValue('P'.$row, 'DATE EFFET');
                        $ligne = 1;
                        foreach ($regions as $region) {
                            $row++;
                            $sheet->getStyle('A'.$row.':Q'.$row)->applyFromArray($style_tableau);
                            $sheet->mergeCells('C'.$row.':E'.$row);
                            $sheet->mergeCells('F'.$row.':G'.$row);
                            $sheet->mergeCells('H'.$row.':J'.$row);
                            $sheet->mergeCells('K'.$row.':M'.$row);
                            $sheet->mergeCells('N'.$row.':O'.$row);
                            $sheet->mergeCells('P'.$row.':Q'.$row);
                            $sheet->setCellValue('A'.$row, $ligne);
                            $sheet->setCellValue('B'.$row, $region['code']);
                            $sheet->setCellValue('C'.$row, $region['nom']);
                            $sheet->setCellValue('F'.$row, $region['nom_pays']);
                            $sheet->setCellValue('H'.$row, $region['nom_region']);
                            $sheet->setCellValue('K'.$row, $region['nom_departement']);
                            $sheet->setCellValue('N'.$row, $region['latitude'].';'.$region['longitude']);
                            $spreadsheet->getActiveSheet()->getStyle('Q'.$row)
                                ->getNumberFormat()
                                ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                            $sheet->setCellValue('P'.$row, date('d/m/Y',strtotime($region['date_debut'])));
                            $ligne++;
                        }

                        $writer = new Xlsx($spreadsheet);
                        $writer->save("php://output");
                    }
                }
                elseif ($data == 'tfa') {
                    $file_name = "EXPORT_TABLE_VALEURS_TYPES_FACTURES_MEDICALES_".date('dmYhis',time()).".xls";
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment; filename="'.$file_name.'"');

                    require "../_CONFIGS/Classes/TYPESFACTURESMEDICALES.php";
                    $FACTURESMEDICALES = new TYPESFACTURESMEDICALES();
                    $types_factures = $FACTURESMEDICALES->lister();
                    $nb_types_factures = count($types_factures);
                    if($nb_types_factures != 0) {

                        $row = 1;
                        $sheet->getStyle('D'.$row.':L'.$row)->applyFromArray($style_titre);
                        $sheet->setCellValue('D'.$row, 'TABLE DE VALEURS: TYPES FACTURES MEDICALES');
                        $sheet->mergeCells('D'.$row.':L'.($row = $row+2));
                        $sheet->getStyle('D1'.':L'.$row)
                            ->getBorders()
                            ->getAllBorders()
                            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

                        $row++;
                        $sheet->getStyle('A'.$row.':L'.$row)->applyFromArray($style_entete);
                        $sheet->mergeCells('C'.$row.':J'.$row);
                        $sheet->mergeCells('K'.$row.':L'.$row);
                        $sheet->setCellValue('A'.$row, 'N°');
                        $sheet->setCellValue('B'.$row, 'CODE');
                        $sheet->setCellValue('C'.$row, 'LIBELLE');
                        $sheet->setCellValue('K'.$row, 'DATE EFFET');
                        $ligne = 1;
                        foreach ($types_factures as $type_facture) {
                            $row++;
                            $sheet->getStyle('A'.$row.':L'.$row)->applyFromArray($style_tableau);
                            $sheet->mergeCells('C'.$row.':J'.$row);
                            $sheet->mergeCells('K'.$row.':L'.$row);
                            $sheet->setCellValue('A'.$row, $ligne);
                            $sheet->setCellValue('B'.$row, $type_facture['code']);
                            $sheet->setCellValue('C'.$row, $type_facture['libelle']);
                            $spreadsheet->getActiveSheet()->getStyle('K'.$row)
                                ->getNumberFormat()
                                ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                            $sheet->setCellValue('K'.$row, date('d/m/Y',strtotime($type_facture['date_debut'])));
                            $ligne++;
                        }

                        $writer = new Xlsx($spreadsheet);
                        $writer->save("php://output");
                    }
                }
                else {
                    echo "<script>window.close();</script>";
                }
            }
            elseif ($type == 'pdf') {

                require_once "../vendor/autoload.php";
                require_once "../vendor/tecnick.com/tcpdf/tcpdf.php";

                // create new PDF document
                $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
                $pdf->SetCreator(PDF_CREATOR);
                $pdf->SetAuthor(AUTHOR);
                $pdf->SetSubject('TABLES DE VALEURS');

                // set default header data
                $pdf->setPrintHeader(false);
                $pdf->setPrintFooter(true);


                // set text shadow effect
                $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

                // Set some content to print
                $pdf->Image(IMAGES.'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);

                if ($data == 'put') {
                    $file_name = "EXPORT_TABLE_VALEURS_PROFIL_UTILISATEURS_".date('dmYhis',time()).".pdf";
                    $pdf->SetTitle($file_name);
                    require "../_CONFIGS/Classes/PROFILSUTILISATEURS.php";
                    $PROFILSUTILISATEURS = new PROFILSUTILISATEURS();
                    $profils = $PROFILSUTILISATEURS->lister();
                    $nb_profils = count($profils);
                    if($nb_profils != 0) {
                        $pdf->AddPage('L');
                        $pdf->Image(IMAGES.'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);

                        $pdf->writeHTMLCell(0, 0, 50, 15, '<h1>TABLE DE VALEURS:<br />PROFILS UTILISATEURS</h1>', 0, 1, 0, true, 'C', true);
                        $pdf->setCellPaddings(1, 1, 1, 1);
                        $pdf->MultiCell(10, 15, NULL, 0, 'L', 1, 1, '', '', true);

                        $pdf->SetFillColor(128, 128, 128);
                        $pdf->SetFont('helvetica', 'B', 8, '', true);
                        $pdf->MultiCell(10, 5, 'N°', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(100, 5, 'CODE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(150, 5, 'LIBELLE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(20, 5, 'DATE EFFET', 1, 'L', 1, 1, '', '', true);
                        $pdf->SetFont('helvetica', '', 8, '', true);
                        $pdf->SetFillColor(255, 255, 255);
                        $ligne = 1;
                        foreach ($profils as $profil) {
                            $pdf->SetFont('helvetica', 'B', 8, '', true);
                            $pdf->MultiCell(10, 5, $ligne, 1, 'R', 1, 0, '', '', true);
                            $pdf->MultiCell(100, 5, $profil['code'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(150, 5, $profil['libelle'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(20, 5, date('d/m/Y',strtotime($profil['date_debut'])), 1, 'C', 1, 1, '', '', true);
                            $ligne++;
                        }

                    }

                    $pdf->Output($file_name, 'I');
                }
                elseif ($data == 'csp') {
                    $file_name = "EXPORT_TABLE_VALEURS_CATEGORIES_SOCIO_PROFESSIONNELLES_".date('dmYhis',time()).".pdf";
                    $pdf->SetTitle($file_name);

                    require "../_CONFIGS/Classes/CATEGORIESSOCIOPROFESSIONNELLES.php";
                    $CATEGORIESSOCIOPROFESSIONNELLES = new CATEGORIESSOCIOPROFESSIONNELLES();
                    $categories = $CATEGORIESSOCIOPROFESSIONNELLES->lister();
                    $nb_categories = count($categories);
                    if($nb_categories != 0) {
                        $pdf->AddPage('L');
                        $pdf->Image(IMAGES.'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);

                        $pdf->writeHTMLCell(0, 0, 50, 15, '<h1>TABLE DE VALEURS:<br />CATEGORIES SOCIO-PROFESSIONNELLES</h1>', 0, 1, 0, true, 'C', true);
                        $pdf->setCellPaddings(1, 1, 1, 1);
                        $pdf->MultiCell(10, 15, NULL, 0, 'L', 1, 1, '', '', true);


                        $pdf->SetFillColor(128, 128, 128);
                        $pdf->SetFont('helvetica', 'B', 8, '', true);
                        $pdf->MultiCell(10, 5, 'N°', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(100, 5, 'CODE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(150, 5, 'LIBELLE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(20, 5, 'DATE EFFET', 1, 'L', 1, 1, '', '', true);
                        $pdf->SetFont('helvetica', '', 8, '', true);
                        $pdf->SetFillColor(255, 255, 255);
                        $ligne = 1;
                        foreach ($categories as $categorie) {
                            $pdf->SetFont('helvetica', 'B', 8, '', true);
                            $pdf->MultiCell(10, 5, $ligne, 1, 'R', 1, 0, '', '', true);
                            $pdf->MultiCell(100, 5, $categorie['code'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(150, 5, $categorie['libelle'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(20, 5, date('d/m/Y',strtotime($categorie['date_debut'])), 1, 'C', 1, 1, '', '', true);
                            $ligne++;
                        }

                    }
                    $pdf->Output($file_name, 'I');
                }
                elseif ($data == 'cps') {
                    $file_name = "EXPORT_TABLE_VALEURS_CATEGORIES_PROFESSIONNELS_SANTE_".date('dmYhis',time()).".pdf";
                    $pdf->SetTitle($file_name);

                    require "../_CONFIGS/Classes/CATEGORIESPROFESSIONNELSANTES.php";
                    $CATEGORIESPROFESSIONNELSANTES = new CATEGORIESPROFESSIONNELSANTES();
                    $categories = $CATEGORIESPROFESSIONNELSANTES->lister();
                    $nb_categories = count($categories);
                    if($nb_categories != 0) {
                        $pdf->AddPage('L');
                        $pdf->Image(IMAGES.'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);

                        $pdf->writeHTMLCell(0, 0, 50, 15, '<h1>TABLE DE VALEURS:<br />CATEGORIES PROFESSIONNELS DE SANTE</h1>', 0, 1, 0, true, 'C', true);
                        $pdf->setCellPaddings(1, 1, 1, 1);
                        $pdf->MultiCell(10, 15, NULL, 0, 'L', 1, 1, '', '', true);


                        $pdf->SetFillColor(128, 128, 128);
                        $pdf->SetFont('helvetica', 'B', 8, '', true);
                        $pdf->MultiCell(10, 5, 'N°', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(100, 5, 'CODE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(150, 5, 'LIBELLE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(20, 5, 'DATE EFFET', 1, 'L', 1, 1, '', '', true);
                        $pdf->SetFont('helvetica', '', 8, '', true);
                        $pdf->SetFillColor(255, 255, 255);
                        $ligne = 1;
                        foreach ($categories as $categorie) {
                            $pdf->SetFont('helvetica', 'B', 8, '', true);
                            $pdf->MultiCell(10, 5, $ligne, 1, 'R', 1, 0, '', '', true);
                            $pdf->MultiCell(100, 5, $categorie['code'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(150, 5, $categorie['libelle'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(20, 5, date('d/m/Y',strtotime($categorie['date_debut'])), 1, 'C', 1, 1, '', '', true);
                            $ligne++;
                        }

                    }
                    $pdf->Output($file_name, 'I');
                }
                elseif ($data == 'ordre') {
                    $file_name = "EXPORT_TABLE_VALEURS_ORDRES_NATIONAUX_".date('dmYhis',time()).".pdf";
                    $pdf->SetTitle($file_name);

                    require "../_CONFIGS/Classes/ORDESNATIONAUX.php";
                    $ORDESNATIONAUX = new ORDESNATIONAUX();
                    $ordres = $ORDESNATIONAUX->lister();
                    $nb_ordres = count($ordres);
                    if($nb_ordres != 0) {
                        $pdf->AddPage('L');
                        $pdf->Image(IMAGES.'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);

                        $pdf->writeHTMLCell(0, 0, 50, 15, '<h1>TABLE DE VALEURS:<br />ORDRES NATIONAUX</h1>', 0, 1, 0, true, 'C', true);
                        $pdf->setCellPaddings(1, 1, 1, 1);
                        $pdf->MultiCell(10, 15, NULL, 0, 'L', 1, 1, '', '', true);


                        $pdf->SetFillColor(128, 128, 128);
                        $pdf->SetFont('helvetica', 'B', 8, '', true);
                        $pdf->MultiCell(10, 5, 'N°', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(100, 5, 'CODE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(150, 5, 'LIBELLE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(20, 5, 'DATE EFFET', 1, 'L', 1, 1, '', '', true);
                        $pdf->SetFont('helvetica', '', 8, '', true);
                        $pdf->SetFillColor(255, 255, 255);
                        $ligne = 1;
                        foreach ($ordres as $ordre) {
                            $pdf->SetFont('helvetica', 'B', 8, '', true);
                            $pdf->MultiCell(10, 5, $ligne, 1, 'R', 1, 0, '', '', true);
                            $pdf->MultiCell(100, 5, $ordre['code'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(150, 5, $ordre['libelle'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(20, 5, date('d/m/Y',strtotime($ordre['date_debut'])), 1, 'C', 1, 1, '', '', true);
                            $ligne++;
                        }

                    }
                    $pdf->Output($file_name, 'I');
                }
                elseif ($data == 'civ') {
                    $file_name = "EXPORT_TABLE_VALEURS_CIVILITES_".date('dmYhis',time()).".csv";
                    $pdf->SetTitle($file_name);
                    require "../_CONFIGS/Classes/CIVILITES.php";
                    $CIVILITES = new CIVILITES();
                    $civilites = $CIVILITES->lister();
                    $nb_civilites = count($civilites);
                    if($nb_civilites != 0) {
                        $pdf->AddPage('L');
                        $pdf->Image(IMAGES.'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);

                        $pdf->writeHTMLCell(0, 0, 50, 15, '<h1>TABLE DE VALEURS:<br />CIVILITES</h1>', 0, 1, 0, true, 'C', true);
                        $pdf->setCellPaddings(1, 1, 1, 1);
                        $pdf->MultiCell(10, 15, NULL, 0, 'L', 1, 1, '', '', true);

                        $pdf->SetFillColor(128, 128, 128);
                        $pdf->SetFont('helvetica', 'B', 8, '', true);
                        $pdf->MultiCell(10, 5, 'N°', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(100, 5, 'CODE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(150, 5, 'LIBELLE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(20, 5, 'DATE EFFET', 1, 'L', 1, 1, '', '', true);
                        $pdf->SetFont('helvetica', '', 8, '', true);
                        $pdf->SetFillColor(255, 255, 255);
                        $ligne = 1;
                        foreach ($civilites as $civilite) {
                            $pdf->SetFont('helvetica', 'B', 8, '', true);
                            $pdf->MultiCell(10, 5, $ligne, 1, 'R', 1, 0, '', '', true);
                            $pdf->MultiCell(100, 5, $civilite['code'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(150, 5, $civilite['libelle'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(20, 5, date('d/m/Y',strtotime($civilite['date_debut'])), 1, 'C', 1, 1, '', '', true);
                            $ligne++;
                        }

                    }


                    $pdf->Output($file_name, 'I');
                }
                elseif ($data == 'sex') {
                    $file_name = "EXPORT_TABLE_VALEURS_SEXES_".date('dmYhis',time()).".csv";
                    $pdf->SetTitle($file_name);
                    require "../_CONFIGS/Classes/SEXES.php";
                    $SEXES = new SEXES();
                    $sexes = $SEXES->lister();
                    $nb_sexes = count($sexes);
                    if($nb_sexes != 0) {
                        $pdf->AddPage('L');
                        $pdf->Image(IMAGES.'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);

                        $pdf->writeHTMLCell(0, 0, 50, 15, '<h1>TABLE DE VALEURS:<br />SEXES</h1>', 0, 1, 0, true, 'C', true);
                        $pdf->setCellPaddings(1, 1, 1, 1);
                        $pdf->MultiCell(10, 15, NULL, 0, 'L', 1, 1, '', '', true);

                        $pdf->SetFillColor(128, 128, 128);
                        $pdf->SetFont('helvetica', 'B', 8, '', true);
                        $pdf->MultiCell(10, 5, 'N°', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(100, 5, 'CODE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(150, 5, 'LIBELLE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(20, 5, 'DATE EFFET', 1, 'L', 1, 1, '', '', true);
                        $pdf->SetFont('helvetica', '', 8, '', true);
                        $pdf->SetFillColor(255, 255, 255);
                        $ligne = 1;
                        foreach ($sexes as $sexe) {
                            $pdf->SetFont('helvetica', 'B', 8, '', true);
                            $pdf->MultiCell(10, 5, $ligne, 1, 'R', 1, 0, '', '', true);
                            $pdf->MultiCell(100, 5, $sexe['code'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(150, 5, $sexe['libelle'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(20, 5, date('d/m/Y',strtotime($sexe['date_debut'])), 1, 'C', 1, 1, '', '', true);
                            $ligne++;
                        }

                    }


                    $pdf->Output($file_name, 'I');
                }
                elseif ($data == 'typ_pers') {
                    $file_name = "EXPORT_TABLE_VALEURS_TYPES_PERSONNES_ECU_".date('dmYhis',time()).".csv";
                    $pdf->SetTitle($file_name);
                    require "../_CONFIGS/Classes/TYPESPERSONNES.php";
                    $TYPESPERSONNES = new TYPESPERSONNES();
                    $types_personnes = $TYPESPERSONNES->lister();
                    $nb_types_personnes_ecu = count($types_personnes);
                    if($nb_types_personnes_ecu != 0) {
                        $pdf->AddPage('L');
                        $pdf->Image(IMAGES.'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);

                        $pdf->writeHTMLCell(0, 0, 50, 15, '<h1>TABLE DE VALEURS:<br />TYPES PERSONNES ECU</h1>', 0, 1, 0, true, 'C', true);
                        $pdf->setCellPaddings(1, 1, 1, 1);
                        $pdf->MultiCell(10, 15, NULL, 0, 'L', 1, 1, '', '', true);

                        $pdf->SetFillColor(128, 128, 128);
                        $pdf->SetFont('helvetica', 'B', 8, '', true);
                        $pdf->MultiCell(10, 5, 'N°', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(100, 5, 'CODE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(150, 5, 'LIBELLE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(20, 5, 'DATE EFFET', 1, 'L', 1, 1, '', '', true);
                        $pdf->SetFont('helvetica', '', 8, '', true);
                        $pdf->SetFillColor(255, 255, 255);
                        $ligne = 1;
                        foreach ($types_personnes as $type_personne) {
                            $pdf->SetFont('helvetica', 'B', 8, '', true);
                            $pdf->MultiCell(10, 5, $ligne, 1, 'R', 1, 0, '', '', true);
                            $pdf->MultiCell(100, 5, $type_personne['code'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(150, 5, $type_personne['libelle'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(20, 5, date('d/m/Y',strtotime($type_personne['date_debut'])), 1, 'C', 1, 1, '', '', true);
                            $ligne++;
                        }

                    }


                    $pdf->Output($file_name, 'I');
                }
                elseif ($data == 'tac') {
                    $file_name = "EXPORT_TABLE_VALEURS_TYPES_ACCIDENTS_".date('dmYhis',time()).".csv";
                    $pdf->SetTitle($file_name);
                    require "../_CONFIGS/Classes/TYPESACCIDENTS.php";
                    $TYPESACCIDENTS = new TYPESACCIDENTS();
                    $typesaccidents = $TYPESACCIDENTS->lister();
                    $nb_typesaccidents = count($typesaccidents);
                    if($nb_typesaccidents != 0) {
                        $pdf->AddPage('L');
                        $pdf->Image(IMAGES.'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);

                        $pdf->writeHTMLCell(0, 0, 50, 15, '<h1>TABLE DE VALEURS:<br />TYPES ACCIDENTS</h1>', 0, 1, 0, true, 'C', true);
                        $pdf->setCellPaddings(1, 1, 1, 1);
                        $pdf->MultiCell(10, 15, NULL, 0, 'L', 1, 1, '', '', true);

                        $pdf->SetFillColor(128, 128, 128);
                        $pdf->SetFont('helvetica', 'B', 8, '', true);
                        $pdf->MultiCell(10, 5, 'N°', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(100, 5, 'CODE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(150, 5, 'LIBELLE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(20, 5, 'DATE EFFET', 1, 'L', 1, 1, '', '', true);
                        $pdf->SetFont('helvetica', '', 8, '', true);
                        $pdf->SetFillColor(255, 255, 255);
                        $ligne = 1;
                        foreach ($typesaccidents as $typesaccident) {
                            $pdf->SetFont('helvetica', 'B', 8, '', true);
                            $pdf->MultiCell(10, 5, $ligne, 1, 'R', 1, 0, '', '', true);
                            $pdf->MultiCell(100, 5, $typesaccident['code'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(150, 5, $typesaccident['libelle'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(20, 5, date('d/m/Y',strtotime($typesaccident['date_debut'])), 1, 'C', 1, 1, '', '', true);
                            $ligne++;
                        }

                    }


                    $pdf->Output($file_name, 'I');
                }
                elseif ($data == 'sif') {
                    $file_name = "EXPORT_TABLE_VALEURS_SITUATIONS_FAMILIALES_".date('dmYhis',time()).".csv";
                    $pdf->SetTitle($file_name);
                    require "../_CONFIGS/Classes/SITUATIONSFAMILIALES.php";
                    $SITUATIONFAMILLES = new SITUATIONSFAMILIALES();
                    $situationfamilles = $SITUATIONFAMILLES->lister();
                    $nb_situationfamilles = count($situationfamilles);
                    if($nb_situationfamilles != 0) {
                        $pdf->AddPage('L');
                        $pdf->Image(IMAGES.'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);

                        $pdf->writeHTMLCell(0, 0, 50, 15, '<h1>TABLE DE VALEURS:<br />SITUATIONS FAMILIALES</h1>', 0, 1, 0, true, 'C', true);
                        $pdf->setCellPaddings(1, 1, 1, 1);
                        $pdf->MultiCell(10, 15, NULL, 0, 'L', 1, 1, '', '', true);

                        $pdf->SetFillColor(128, 128, 128);
                        $pdf->SetFont('helvetica', 'B', 8, '', true);
                        $pdf->MultiCell(10, 5, 'N°', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(100, 5, 'CODE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(150, 5, 'LIBELLE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(20, 5, 'DATE EFFET', 1, 'L', 1, 1, '', '', true);
                        $pdf->SetFont('helvetica', '', 8, '', true);
                        $pdf->SetFillColor(255, 255, 255);
                        $ligne = 1;
                        foreach ($situationfamilles as $situationfamille) {
                            $pdf->SetFont('helvetica', 'B', 8, '', true);
                            $pdf->MultiCell(10, 5, $ligne, 1, 'R', 1, 0, '', '', true);
                            $pdf->MultiCell(100, 5, $situationfamille['code'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(150, 5, $situationfamille['libelle'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(20, 5, date('d/m/Y',strtotime($situationfamille['date_debut'])), 1, 'C', 1, 1, '', '', true);
                            $ligne++;
                        }

                    }
                    $pdf->Output($file_name, 'I');
                }
                elseif ($data == 'sct') {
                    $file_name = "EXPORT_TABLE_VALEURS_SECTEURS_ACTIVITES_".date('dmYhis',time()).".csv";
                    $pdf->SetTitle($file_name);
                    require "../_CONFIGS/Classes/SECTEURSACTIVITES.php";
                    $SECTEURSACTVITES = new SECTEURSACTIVITES();
                    $secteursactivites = $SECTEURSACTVITES->lister();
                    $nb_secteursactivites = count($secteursactivites);
                    if($nb_secteursactivites != 0) {
                        $pdf->AddPage('L');
                        $pdf->Image(IMAGES.'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);

                        $pdf->writeHTMLCell(0, 0, 50, 15, '<h1>TABLE DE VALEURS:<br />SECTEURS ACTIVITES</h1>', 0, 1, 0, true, 'C', true);
                        $pdf->setCellPaddings(1, 1, 1, 1);
                        $pdf->MultiCell(10, 15, NULL, 0, 'L', 1, 1, '', '', true);

                        $pdf->SetFillColor(128, 128, 128);
                        $pdf->SetFont('helvetica', 'B', 8, '', true);
                        $pdf->MultiCell(10, 5, 'N°', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(100, 5, 'CODE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(150, 5, 'LIBELLE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(20, 5, 'DATE EFFET', 1, 'L', 1, 1, '', '', true);
                        $pdf->SetFont('helvetica', '', 8, '', true);
                        $pdf->SetFillColor(255, 255, 255);
                        $ligne = 1;
                        foreach ($secteursactivites as $secteursactivite) {
                            $pdf->SetFont('helvetica', 'B', 8, '', true);
                            $pdf->MultiCell(10, 5, $ligne, 1, 'R', 1, 0, '', '', true);
                            $pdf->MultiCell(100, 5, $secteursactivite['code'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(150, 5, $secteursactivite['libelle'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(20, 5, date('d/m/Y',strtotime($secteursactivite['date_debut'])), 1, 'C', 1, 1, '', '', true);
                            $ligne++;
                        }

                    }
                    $pdf->Output($file_name, 'I');
                }
                elseif ($data == 'prf') {
                    $file_name = "EXPORT_TABLE_VALEURS_PROFESSIONS_".date('dmYhis',time()).".csv";
                    $pdf->SetTitle($file_name);
                    require "../_CONFIGS/Classes/PROFESSIONS.php";
                    $PROFESSIONS = new PROFESSIONS();
                    $professions = $PROFESSIONS->lister();
                    $nb_professions = count($professions);
                    if($nb_professions != 0) {
                        $pdf->AddPage('L');
                        $pdf->Image(IMAGES.'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);
                        ;
                        $pdf->writeHTMLCell(0, 0, 50, 15, '<h1>TABLE DE VALEURS:<br />PROFESSIONS</h1>', 0, 1, 0, true, 'C', true);
                        $pdf->setCellPaddings(1, 1, 1, 1);
                        $pdf->MultiCell(10, 15, NULL, 0, 'L', 1, 1, '', '', true);

                        $pdf->SetFillColor(128, 128, 128);
                        $pdf->SetFont('helvetica', 'B', 8, '', true);
                        $pdf->MultiCell(10, 5, 'N°', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(15, 5, 'CODE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(235, 5, 'LIBELLE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(20, 5, 'DATE EFFET', 1, 'L', 1, 1, '', '', true);
                        $pdf->SetFont('helvetica', '', 8, '', true);
                        $pdf->SetFillColor(255, 255, 255);
                        $ligne = 1;
                        foreach ($professions as $profession) {
                            $pdf->SetFont('helvetica', 'B', 8, '', true);
                            $pdf->MultiCell(10, 5, $ligne, 1, 'R', 1, 0, '', '', true);
                            $pdf->MultiCell(15, 5, $profession['code'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(235, 5, $profession['libelle'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(20, 5, date('d/m/Y',strtotime($profession['date_debut'])), 1, 'C', 1, 1, '', '', true);
                            $ligne++;
                        }

                    }
                    $pdf->Output($file_name, 'I');
                }
                elseif ($data == 'qtc') {
                    $file_name = "EXPORT_TABLE_VALEURS_QUELITES_CIVILES_".date('dmYhis',time()).".csv";
                    $pdf->SetTitle($file_name);
                    require "../_CONFIGS/Classes/QUALITESCIVILES.php";
                    $QUALITESCIVILTES = new QUALITESCIVILES();
                    $qualitesciviles = $QUALITESCIVILTES->lister();
                    $nb_qualitesciviles = count($qualitesciviles);
                    if($nb_qualitesciviles != 0) {
                        $pdf->AddPage('L');
                        $pdf->Image(IMAGES.'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);

                        $pdf->writeHTMLCell(0, 0, 50, 15, '<h1>TABLE DE VALEURS:<br />QUALITES CIVILITES</h1>', 0, 1, 0, true, 'C', true);
                        $pdf->setCellPaddings(1, 1, 1, 1);
                        $pdf->MultiCell(10, 15, NULL, 0, 'L', 1, 1, '', '', true);

                        $pdf->SetFillColor(128, 128, 128);
                        $pdf->SetFont('helvetica', 'B', 8, '', true);
                        $pdf->MultiCell(10, 5, 'N°', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(100, 5, 'CODE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(150, 5, 'LIBELLE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(20, 5, 'DATE EFFET', 1, 'L', 1, 1, '', '', true);
                        $pdf->SetFont('helvetica', '', 8, '', true);
                        $pdf->SetFillColor(255, 255, 255);
                        $ligne = 1;
                        foreach ($qualitesciviles as $qualitescivile) {
                            $pdf->SetFont('helvetica', 'B', 8, '', true);
                            $pdf->MultiCell(10, 5, $ligne, 1, 'R', 1, 0, '', '', true);
                            $pdf->MultiCell(100, 5, $qualitescivile['code'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(150, 5, $qualitescivile['libelle'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(20, 5, date('d/m/Y',strtotime($qualitescivile['date_debut'])), 1, 'C', 1, 1, '', '', true);
                            $ligne++;
                        }

                    }
                    $pdf->Output($file_name, 'I');
                }
                elseif ($data == 'tco') {
                    $file_name = "EXPORT_TABLE_VALEURS_TYPES_COORDONNEES_".date('dmYhis',time()).".csv";
                    $pdf->SetTitle($file_name);
                    require "../_CONFIGS/Classes/TYPESCOORDONNEES.php";
                    $TYPESCOORDONNEES = new TYPESCOORDONNEES();
                    $typescoordonnees = $TYPESCOORDONNEES->lister();
                    $nb_typescoordonnees = count($typescoordonnees);
                    if($nb_typescoordonnees != 0) {
                        $pdf->AddPage('L');
                        $pdf->Image(IMAGES.'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);

                        $pdf->writeHTMLCell(0, 0, 50, 15, '<h1>TABLE DE VALEURS:<br />TYPES COORDONNEES</h1>', 0, 1, 0, true, 'C', true);
                        $pdf->setCellPaddings(1, 1, 1, 1);
                        $pdf->MultiCell(10, 15, NULL, 0, 'L', 1, 1, '', '', true);

                        $pdf->SetFillColor(128, 128, 128);
                        $pdf->SetFont('helvetica', 'B', 8, '', true);
                        $pdf->MultiCell(10, 5, 'N°', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(100, 5, 'CODE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(150, 5, 'LIBELLE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(20, 5, 'DATE EFFET', 1, 'L', 1, 1, '', '', true);
                        $pdf->SetFont('helvetica', '', 8, '', true);
                        $pdf->SetFillColor(255, 255, 255);
                        $ligne = 1;
                        foreach ($typescoordonnees as $typescoordonnee) {
                            $pdf->SetFont('helvetica', 'B', 8, '', true);
                            $pdf->MultiCell(10, 5, $ligne, 1, 'R', 1, 0, '', '', true);
                            $pdf->MultiCell(100, 5, $typescoordonnee['code'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(150, 5, $typescoordonnee['libelle'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(20, 5, date('d/m/Y',strtotime($typescoordonnee['date_debut'])), 1, 'C', 1, 1, '', '', true);
                            $ligne++;
                        }

                    }
                    $pdf->Output($file_name, 'I');
                }
                elseif ($data == 'tpi') {
                    $file_name = "EXPORT_TABLE_VALEURS_TYPES_PIECES_IDENTITES_".date('dmYhis',time()).".csv";
                    $pdf->SetTitle($file_name);
                    require "../_CONFIGS/Classes/TYPESPIECESIDENTITES.php";
                    $TYPESPIECESIDENTITES = new TYPESPIECESIDENTITES();
                    $typespiecesidentites = $TYPESPIECESIDENTITES->lister();
                    $nb_typespiecesidentites = count($typespiecesidentites);
                    if($nb_typespiecesidentites != 0) {
                        $pdf->AddPage('L');
                        $pdf->Image(IMAGES.'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);

                        $pdf->writeHTMLCell(0, 0, 50, 15, '<h1>TABLE DE VALEURS:<br />TYPES PIECES IDENTITES</h1>', 0, 1, 0, true, 'C', true);
                        $pdf->setCellPaddings(1, 1, 1, 1);
                        $pdf->MultiCell(10, 15, NULL, 0, 'L', 1, 1, '', '', true);

                        $pdf->SetFillColor(128, 128, 128);
                        $pdf->SetFont('helvetica', 'B', 8, '', true);
                        $pdf->MultiCell(10, 5, 'N°', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(100, 5, 'CODE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(150, 5, 'LIBELLE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(20, 5, 'DATE EFFET', 1, 'L', 1, 1, '', '', true);
                        $pdf->SetFont('helvetica', '', 8, '', true);
                        $pdf->SetFillColor(255, 255, 255);
                        $ligne = 1;
                        foreach ($typespiecesidentites as $typespiecesidentite) {
                            $pdf->SetFont('helvetica', 'B', 8, '', true);
                            $pdf->MultiCell(10, 5, $ligne, 1, 'R', 1, 0, '', '', true);
                            $pdf->MultiCell(100, 5, $typespiecesidentite['code'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(150, 5, $typespiecesidentite['libelle'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(20, 5, date('d/m/Y',strtotime($typespiecesidentite['date_debut'])), 1, 'C', 1, 1, '', '', true);
                            $ligne++;
                        }

                    }
                    $pdf->Output($file_name, 'I');
                }
                elseif ($data == 'dev') {
                    $file_name = "EXPORT_TABLE_VALEURS_DEVISES_".date('dmYhis',time()).".csv";
                    $pdf->SetTitle($file_name);
                    require "../_CONFIGS/Classes/DEVISESMONETAIRES.php";
                    $DEVISES = new DEVISESMONETAIRES();
                    $devises = $DEVISES->lister();
                    $nb_devises = count($devises);
                    if($nb_devises != 0) {
                        $pdf->AddPage('L');
                        $pdf->Image(IMAGES.'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);

                        $pdf->writeHTMLCell(0, 0, 50, 15, '<h1>TABLE DE VALEURS:<br />DEVISES</h1>', 0, 1, 0, true, 'C', true);
                        $pdf->setCellPaddings(1, 1, 1, 1);
                        $pdf->MultiCell(10, 15, NULL, 0, 'L', 1, 1, '', '', true);

                        $pdf->SetFillColor(128, 128, 128);
                        $pdf->SetFont('helvetica', 'B', 8, '', true);
                        $pdf->MultiCell(10, 5, 'N°', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(100, 5, 'CODE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(150, 5, 'LIBELLE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(20, 5, 'DATE EFFET', 1, 'L', 1, 1, '', '', true);
                        $pdf->SetFont('helvetica', '', 8, '', true);
                        $pdf->SetFillColor(255, 255, 255);
                        $ligne = 1;
                        foreach ($devises as $devise) {
                            $pdf->SetFont('helvetica', 'B', 8, '', true);
                            $pdf->MultiCell(10, 5, $ligne, 1, 'R', 1, 0, '', '', true);
                            $pdf->MultiCell(100, 5, $devise['code'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(150, 5, $devise['libelle'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(20, 5, date('d/m/Y',strtotime($devise['date_debut'])), 1, 'C', 1, 1, '', '', true);
                            $ligne++;
                        }

                    }
                    $pdf->Output($file_name, 'I');
                }
                elseif ($data == 'gsa') {
                    $file_name = "EXPORT_TABLE_VALEURS_GROUPES_SANGUINS_".date('dmYhis',time()).".csv";
                    $pdf->SetTitle($file_name);
                    require "../_CONFIGS/Classes/GROUPESSANGUINS.php";
                    $GROUPESSANGUINS = new GROUPESSANGUINS();
                    $groupesanguins = $GROUPESSANGUINS->lister();
                    $nb_groupesanguins = count($groupesanguins);
                    if($nb_groupesanguins != 0) {
                        $pdf->AddPage('L');
                        $pdf->Image(IMAGES.'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);

                        $pdf->writeHTMLCell(0, 0, 50, 15, '<h1>TABLE DE VALEURS:<br />GROUPES SANGUINS</h1>', 0, 1, 0, true, 'C', true);
                        $pdf->setCellPaddings(1, 1, 1, 1);
                        $pdf->MultiCell(10, 15, NULL, 0, 'L', 1, 1, '', '', true);

                        $pdf->SetFillColor(128, 128, 128);
                        $pdf->SetFont('helvetica', 'B', 8, '', true);
                        $pdf->MultiCell(10, 5, 'N°', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(100, 5, 'CODE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(150, 5, 'LIBELLE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(20, 5, 'DATE EFFET', 1, 'L', 1, 1, '', '', true);
                        $pdf->SetFont('helvetica', '', 8, '', true);
                        $pdf->SetFillColor(255, 255, 255);
                        $ligne = 1;
                        foreach ($groupesanguins as $groupesanguin) {
                            $pdf->SetFont('helvetica', 'B', 8, '', true);
                            $pdf->MultiCell(10, 5, $ligne, 1, 'R', 1, 0, '', '', true);
                            $pdf->MultiCell(100, 5, $groupesanguin['code'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(150, 5, $groupesanguin['libelle'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(20, 5, date('d/m/Y',strtotime($groupesanguin['date_debut'])), 1, 'C', 1, 1, '', '', true);
                            $ligne++;
                        }

                    }
                    $pdf->Output($file_name, 'I');
                }
                elseif ($data == 'rhs') {
                    $file_name = "EXPORT_TABLE_VALEURS_RHESUS_SANGUINS_".date('dmYhis',time()).".pdf";
                    $pdf->SetTitle($file_name);
                    require "../_CONFIGS/Classes/GROUPESSANGUINS.php";
                    $RHESUS = new GROUPESSANGUINS();
                    $groupesanguins = $RHESUS->lister_rhesus();
                    $nb_rhesus = count($groupesanguins);
                    if($nb_rhesus != 0) {
                        $pdf->AddPage('L');
                        $pdf->Image(IMAGES.'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);

                        $pdf->writeHTMLCell(0, 0, 50, 15, '<h1>TABLE DE VALEURS:<br />RHESUS SANGUINS</h1>', 0, 1, 0, true, 'C', true);
                        $pdf->setCellPaddings(1, 1, 1, 1);
                        $pdf->MultiCell(10, 15, NULL, 0, 'L', 1, 1, '', '', true);

                        $pdf->SetFillColor(128, 128, 128);
                        $pdf->SetFont('helvetica', 'B', 8, '', true);
                        $pdf->MultiCell(10, 5, 'N°', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(100, 5, 'CODE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(150, 5, 'LIBELLE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(20, 5, 'DATE EFFET', 1, 'L', 1, 1, '', '', true);
                        $pdf->SetFont('helvetica', '', 8, '', true);
                        $pdf->SetFillColor(255, 255, 255);
                        $ligne = 1;
                        foreach ($groupesanguins as $rhesus) {
                            $pdf->SetFont('helvetica', 'B', 8, '', true);
                            $pdf->MultiCell(10, 5, $ligne, 1, 'R', 1, 0, '', '', true);
                            $pdf->MultiCell(100, 5, $rhesus['code'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(150, 5, $rhesus['libelle'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(20, 5, date('d/m/Y',strtotime($rhesus['date_debut'])), 1, 'C', 1, 1, '', '', true);
                            $ligne++;
                        }

                    }
                    $pdf->Output($file_name, 'I');
                }
                elseif ($data == 'lge') {
                    $file_name = "EXPORT_TABLE_VALEURS_PAYS_".date('dmYhis',time()).".pdf";
                    $pdf->SetTitle($file_name);
                    require "../_CONFIGS/Classes/LOCALISATIONSGEOGRAPHIQUES.php";
                    $LOCALISATIONSGEOGRAPHIQUES = new LOCALISATIONSGEOGRAPHIQUES();
                    $pays = $LOCALISATIONSGEOGRAPHIQUES->lister_pays();
                    $nb_pays = count($pays);
                    if($nb_pays != 0) {
                        $pdf->AddPage('L');
                        $pdf->Image(IMAGES.'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);
                        $pdf->writeHTMLCell(0, 0, 50, 15, '<h1>TABLE DE VALEURS:<br />PAYS</h1>', 0, 1, 0, true, 'C', true);
                        $pdf->setCellPaddings(1, 1, 1, 1);
                        $pdf->MultiCell(10, 15, NULL, 0, 'L', 1, 1, '', '', true);

                        $pdf->SetFillColor(128, 128, 128);
                        $pdf->SetFont('helvetica', 'B', 8, '', true);
                        $pdf->MultiCell(10, 5, 'N°', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(15, 5, 'CODE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(100, 5, 'NOM', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(25, 5, 'DEVISE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(45, 5, 'GENTILE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(20, 5, 'INDICATIF', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(45, 5, 'COORDONNEES', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(20, 5, 'DATE EFFET', 1, 'L', 1, 1, '', '', true);
                        $pdf->SetFont('helvetica', '', 8, '', true);
                        $pdf->SetFillColor(255, 255, 255);
                        $ligne = 1;
                        foreach ($pays as $tbpays) {
                            $pdf->SetFont('helvetica', 'B', 8, '', true);
                            $pdf->MultiCell(10, 5, $ligne, 1, 'R', 1, 0, '', '', true);
                            $pdf->MultiCell(15, 5, $tbpays['code'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(100, 5, $tbpays['nom'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(25, 5, $tbpays['devise'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(45, 5, $tbpays['gentile'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(20, 5, $tbpays['indicatif_telephonique'], 1, 'R', 1, 0, '', '', true);
                            $pdf->MultiCell(45, 5, $tbpays['latitude'].$tbpays['longitude'], 1, 'C', 1, 0, '', '', true);
                            $pdf->MultiCell(20, 5, date('d/m/Y',strtotime($tbpays['date_debut'])), 1, 'C', 1, 1, '', '', true);
                            $ligne++;
                        }

                    }
                    $pdf->Output($file_name, 'I');
                }
                elseif ($data == 'reg') {
                    $file_name = "EXPORT_TABLE_VALEURS_REGIONS_".date('dmYhis',time()).".pdf";
                    $pdf->SetTitle($file_name);
                    require "../_CONFIGS/Classes/LOCALISATIONSGEOGRAPHIQUES.php";
                    $LOCALISATIONSGEOGRAPHIQUES = new LOCALISATIONSGEOGRAPHIQUES();
                    $regions = $LOCALISATIONSGEOGRAPHIQUES->lister_regions(null);
                    $nb_regions = count($regions);
                    if($nb_regions != 0) {
                        $pdf->AddPage('L');
                        $pdf->Image(IMAGES.'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);
                        $pdf->writeHTMLCell(0, 0, 50, 15, '<h1>TABLE DE VALEURS:<br />REGIONS</h1>', 0, 1, 0, true, 'C', true);
                        $pdf->setCellPaddings(1, 1, 1, 1);
                        $pdf->MultiCell(10, 15, NULL, 0, 'L', 1, 1, '', '', true);

                        $pdf->SetFillColor(128, 128, 128);
                        $pdf->SetFont('helvetica', 'B', 8, '', true);
                        $pdf->MultiCell(10, 5, 'N°', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(25, 5, 'CODE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(70, 5, 'NOM', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(70, 5, 'PAYS', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(70, 5, 'COORDONNEES', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(30, 5, 'DATE EFFET', 1, 'L', 1, 1, '', '', true);
                        $pdf->SetFont('helvetica', '', 8, '', true);
                        $pdf->SetFillColor(255, 255, 255);
                        $ligne = 1;
                        foreach ($regions as $region) {
                            $pdf->SetFont('helvetica', 'B', 8, '', true);
                            $pdf->MultiCell(10, 5, $ligne, 1, 'R', 1, 0, '', '', true);
                            $pdf->MultiCell(25, 5, $region['code'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(70, 5, $region['pays_nom'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(70, 5, $region['nom'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(70, 5, $region['latitude'].' l - '.$region['longitude'].' L', 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(30, 5, date('d/m/Y',strtotime($region['date_debut'])), 1, 'C', 1, 1, '', '', true);
                            $ligne++;
                        }

                    }
                    $pdf->Output($file_name, 'I');
                }
                elseif ($data == 'dep') {
                    $file_name = "EXPORT_TABLE_VALEURS_DEPARTEMENTS_".date('dmYhis',time()).".pdf";
                    $pdf->SetTitle($file_name);
                    require "../_CONFIGS/Classes/LOCALISATIONSGEOGRAPHIQUES.php";
                    $LOCALISATIONSGEOGRAPHIQUES = new LOCALISATIONSGEOGRAPHIQUES();
                    $departemements = $LOCALISATIONSGEOGRAPHIQUES->lister_departements(null);
                    $nb_departemements = count($departemements);
                    if($nb_departemements != 0) {
                        $pdf->AddPage('L');
                        $pdf->Image(IMAGES.'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);
                        $pdf->writeHTMLCell(0, 0, 50, 15, '<h1>TABLE DE VALEURS:<br />DEPARTEMENTS</h1>', 0, 1, 0, true, 'C', true);
                        $pdf->setCellPaddings(1, 1, 1, 1);
                        $pdf->MultiCell(10, 15, NULL, 0, 'L', 1, 1, '', '', true);

                        $pdf->SetFillColor(128, 128, 128);
                        $pdf->SetFont('helvetica', 'B', 8, '', true);
                        $pdf->MultiCell(10, 5, 'N°', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(20, 5, 'CODE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(60, 5, 'PAYS', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(60, 5, 'REGION', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(60, 5, 'NOM', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(45, 5, 'COORDONNEES', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(20, 5, 'DATE EFFET', 1, 'L', 1, 1, '', '', true);
                        $pdf->SetFont('helvetica', '', 8, '', true);
                        $pdf->SetFillColor(255, 255, 255);
                        $ligne = 1;
                        foreach ($departemements as $departemement) {
                            $pdf->SetFont('helvetica', 'B', 8, '', true);
                            $pdf->MultiCell(10, 5, $ligne, 1, 'R', 1, 0, '', '', true);
                            $pdf->MultiCell(20, 5, $departemement['code'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(60, 5, $departemement['nom_pays'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(60, 5, $departemement['nom_region'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(60, 5, $departemement['nom'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(45, 5, $departemement['latitude'].' l - '.$departemement['longitude'].' L', 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(20, 5, date('d/m/Y',strtotime($departemement['date_debut'])), 1, 'C', 1, 1, '', '', true);
                            $ligne++;
                        }

                    }
                    $pdf->Output($file_name, 'I');
                }
                elseif ($data == 'com') {
                    $file_name = "EXPORT_TABLE_VALEURS_COMMUNES_".date('dmYhis',time()).".pdf";
                    $pdf->SetTitle($file_name);
                    require "../_CONFIGS/Classes/LOCALISATIONSGEOGRAPHIQUES.php";
                    $LOCALISATIONSGEOGRAPHIQUES = new LOCALISATIONSGEOGRAPHIQUES();
                    $communes = $LOCALISATIONSGEOGRAPHIQUES->lister_communes(null);
                    $nb_communes = count($communes);
                    if($nb_communes != 0) {
                        $pdf->AddPage('L');
                        $pdf->Image(IMAGES.'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);
                        $pdf->writeHTMLCell(0, 0, 50, 15, '<h1>TABLE DE VALEURS:<br />COMMUNES</h1>', 0, 1, 0, true, 'C', true);
                        $pdf->setCellPaddings(1, 1, 1, 1);
                        $pdf->MultiCell(10, 15, NULL, 0, 'L', 1, 1, '', '', true);

                        $pdf->SetFillColor(128, 128, 128);
                        $pdf->SetFont('helvetica', 'B', 8, '', true);
                        $pdf->MultiCell(10, 5, 'N°', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(15, 5, 'CODE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(50, 5, 'PAYS', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(50, 5, 'REGION', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(50, 5, 'DEPARTEMENT', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(40, 5, 'NOM', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(40, 5, 'COORDONNEES', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(20, 5, 'DATE EFFET', 1, 'L', 1, 1, '', '', true);
                        $pdf->SetFont('helvetica', '', 8, '', true);
                        $pdf->SetFillColor(255, 255, 255);
                        $ligne = 1;
                        foreach ($communes as $commune) {
                            $pdf->SetFont('helvetica', 'B', 8, '', true);
                            $pdf->MultiCell(10, 5, $ligne, 1, 'R', 1, 0, '', '', true);
                            $pdf->MultiCell(15, 5, $commune['code'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(50, 5, $commune['nom_pays'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(50, 5, $commune['nom_region'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(50, 5, $commune['nom_departement'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(40, 5, $commune['nom'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(40, 5, $commune['latitude'].' l - '.$commune['longitude'].' L', 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(20, 5, date('d/m/Y',strtotime($commune['date_debut'])), 1, 'C', 1, 1, '', '', true);
                            $ligne++;
                        }

                    }
                    $pdf->Output($file_name, 'I');
                }
                elseif ($data == 'tfa') {
                    $file_name = "EXPORT_TABLE_VALEURS_TYPES_FACTURES_MEDICALES_".date('dmYhis',time()).".csv";
                    $pdf->SetTitle($file_name);
                    require "../_CONFIGS/Classes/TYPESFACTURESMEDICALES.php";
                    $FACTURESMEDICALES = new TYPESFACTURESMEDICALES();
                    $types_factures = $FACTURESMEDICALES->lister();
                    $nb_types_factures = count($types_factures);
                    if($nb_types_factures != 0) {
                        $pdf->AddPage('L');
                        $pdf->Image(IMAGES.'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);

                        $pdf->writeHTMLCell(0, 0, 50, 15, '<h1>TABLE DE VALEURS:<br />TYPES FACTURES MEDICALES</h1>', 0, 1, 0, true, 'C', true);
                        $pdf->setCellPaddings(1, 1, 1, 1);
                        $pdf->MultiCell(10, 15, NULL, 0, 'L', 1, 1, '', '', true);

                        $pdf->SetFillColor(128, 128, 128);
                        $pdf->SetFont('helvetica', 'B', 8, '', true);
                        $pdf->MultiCell(10, 5, 'N°', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(15, 5, 'CODE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(235, 5, 'LIBELLE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(20, 5, 'DATE EFFET', 1, 'L', 1, 1, '', '', true);
                        $pdf->SetFont('helvetica', '', 8, '', true);
                        $pdf->SetFillColor(255, 255, 255);
                        $ligne = 1;
                        foreach ($types_factures as $type_facture) {
                            $pdf->SetFont('helvetica', 'B', 8, '', true);
                            $pdf->MultiCell(10, 5, $ligne, 1, 'R', 1, 0, '', '', true);
                            $pdf->MultiCell(15, 5, $type_facture['code'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(235, 5, $type_facture['libelle'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(20, 5, date('d/m/Y',strtotime($type_facture['date_debut'])), 1, 'C', 1, 1, '', '', true);
                            $ligne++;
                        }

                    }
                    $pdf->Output($file_name, 'I');
                }
                else {
                    echo "<script>window.close();</script>";
                }
            }
            elseif($type == 'txt') {
                if($data == 'put') {
                    require "../_CONFIGS/Classes/PROFILSUTILISATEURS.php";
                    $PROFILSUTILISATEURS = new PROFILSUTILISATEURS();
                    $profils = $PROFILSUTILISATEURS->lister();
                    $nb_profils = count($profils);
                    if ($nb_profils != 0) {
                        $file_name = "EXPORT_TABLE_VALEURS_PROFIL_UTILISATEURS_".date('dmYhis',time()).".txt";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename='.$file_name);

                        $fp = fopen('php://output', 'wb');
                        fwrite($fp, str_pad("CODE", 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad("LIBELLE", 45, ' ', STR_PAD_RIGHT) . "\t" . str_pad("DATE EFFET", 10, ' ', STR_PAD_RIGHT) . "\n");
                        foreach ($profils as $profil) {
                            fwrite($fp, str_pad($profil['code'], 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad($profil['libelle'], 45, ' ', STR_PAD_RIGHT) . "\t" . str_pad(date('d/m/Y', strtotime($profil['date_debut'])), 10, ' ', STR_PAD_RIGHT) . "\n");
                        }
                        fclose($fp);
                    }
                }
                elseif($data == 'csp') {
                    require "../_CONFIGS/Classes/CATEGORIESSOCIOPROFESSIONNELLES.php";
                    $CATEGORIESSOCIOPROFESSIONNELLES = new CATEGORIESSOCIOPROFESSIONNELLES();
                    $categories = $CATEGORIESSOCIOPROFESSIONNELLES->lister();
                    $nb_categories = count($categories);
                    if($nb_categories != 0) {
                        $file_name = "EXPORT_TABLE_VALEURS_CATEGORIES_SOCIO_PROFESSIONNELLES_".date('dmYhis',time()).".txt";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename='.$file_name);

                        $fp = fopen('php://output', 'wb');
                        fwrite($fp, str_pad("CODE",10,' ',STR_PAD_RIGHT)."\t".str_pad("LIBELLE",45,' ',STR_PAD_RIGHT)."\t".str_pad("DATE EFFET",10,' ',STR_PAD_RIGHT)."\n");
                        foreach ($categories as $categorie) {
                            fwrite($fp, str_pad($categorie['code'],10,' ',STR_PAD_RIGHT)."\t".str_pad($categorie['libelle'],45,' ',STR_PAD_RIGHT)."\t".str_pad(date('d/m/Y',strtotime($categorie['date_debut'])),10,' ',STR_PAD_RIGHT)."\n");
                        }
                        fclose($fp);
                    }
                }
                elseif($data == 'cps') {
                    require "../_CONFIGS/Classes/CATEGORIESPROFESSIONNELSANTES.php";
                    $CATEGORIESPROFESSIONNELSANTES = new CATEGORIESPROFESSIONNELSANTES();
                    $categories = $CATEGORIESPROFESSIONNELSANTES->lister();
                    $nb_categories = count($categories);
                    if($nb_categories != 0) {
                        $file_name = "EXPORT_TABLE_VALEURS_CATEGORIES_PROFESSIONNELS_SANTE_".date('dmYhis',time()).".txt";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename='.$file_name);

                        $fp = fopen('php://output', 'wb');
                        fwrite($fp, str_pad("CODE",10,' ',STR_PAD_RIGHT)."\t".str_pad("LIBELLE",45,' ',STR_PAD_RIGHT)."\t".str_pad("DATE EFFET",10,' ',STR_PAD_RIGHT)."\n");
                        foreach ($categories as $categorie) {
                            fwrite($fp, str_pad($categorie['code'],10,' ',STR_PAD_RIGHT)."\t".str_pad($categorie['libelle'],45,' ',STR_PAD_RIGHT)."\t".str_pad(date('d/m/Y',strtotime($categorie['date_debut'])),10,' ',STR_PAD_RIGHT)."\n");
                        }
                        fclose($fp);
                    }
                }
                elseif($data == 'ordre') {
                    require "../_CONFIGS/Classes/ORDESNATIONAUX.php";
                    $ORDESNATIONAUX = new ORDESNATIONAUX();
                    $ordres = $ORDESNATIONAUX->lister();
                    $nb_ordres = count($ordres);
                    if($nb_ordres != 0) {
                        $file_name = "EXPORT_TABLE_VALEURS_ORDRES_NATIONAUX_".date('dmYhis',time()).".txt";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename='.$file_name);

                        $fp = fopen('php://output', 'wb');
                        fwrite($fp, str_pad("CODE",10,' ',STR_PAD_RIGHT)."\t".str_pad("LIBELLE",45,' ',STR_PAD_RIGHT)."\t".str_pad("DATE EFFET",10,' ',STR_PAD_RIGHT)."\n");
                        foreach ($ordres as $ordre) {
                            fwrite($fp, str_pad($ordre['code'],10,' ',STR_PAD_RIGHT)."\t".str_pad($ordre['libelle'],45,' ',STR_PAD_RIGHT)."\t".str_pad(date('d/m/Y',strtotime($ordre['date_debut'])),10,' ',STR_PAD_RIGHT)."\n");
                        }
                        fclose($fp);
                    }
                }
                elseif($data == 'civ') {
                    require "../_CONFIGS/Classes/CIVILITES.php";
                    $CIVILITES = new CIVILITES();
                    $civilites = $CIVILITES->lister();
                    $nb_profils = count($civilites);
                    if($nb_profils != 0) {
                        $file_name = "EXPORT_TABLE_VALEURS_CIVILITES_".date('dmYhis',time()).".txt";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename='.$file_name);

                        $fp = fopen('php://output', 'wb');
                        fwrite($fp, str_pad("CODE", 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad("LIBELLE", 45, ' ', STR_PAD_RIGHT) . "\t" . str_pad("DATE EFFET", 10, ' ', STR_PAD_RIGHT) . "\n");
                        foreach ($civilites as $civilite) {
                            fwrite($fp, str_pad($civilite['code'], 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad($civilite['libelle'], 45, ' ', STR_PAD_RIGHT) . "\t" . str_pad(date('d/m/Y', strtotime($civilite['date_debut'])), 10, ' ', STR_PAD_RIGHT) . "\n");
                        }
                        fclose($fp);
                    }
                }
                elseif($data == 'sex') {
                    require "../_CONFIGS/Classes/SEXES.php";
                    $SEXES = new SEXES();
                    $sexes = $SEXES->lister();
                    $nb_sexes = count($sexes);
                    if ($nb_sexes != 0) {
                        $file_name = "EXPORT_TABLE_VALEURS_SEXES_".date('dmYhis',time()).".txt";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename='.$file_name);

                        $fp = fopen('php://output', 'wb');
                        fwrite($fp, str_pad("CODE", 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad("LIBELLE", 45, ' ', STR_PAD_RIGHT) . "\t" . str_pad("DATE EFFET", 10, ' ', STR_PAD_RIGHT) . "\n");
                        foreach ($sexes as $sexe) {
                            fwrite($fp, str_pad($sexe['code'], 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad($sexe['libelle'], 45, ' ', STR_PAD_RIGHT) . "\t" . str_pad(date('d/m/Y', strtotime($sexe['date_debut'])), 10, ' ', STR_PAD_RIGHT) . "\n");
                        }
                        fclose($fp);
                    }
                }
                elseif($data == 'typ_pers') {
                    require "../_CONFIGS/Classes/TYPESPERSONNES.php";
                    $TYPESPERSONNES = new TYPESPERSONNES();
                    $types_personnes = $TYPESPERSONNES->lister();
                    $nb_types_personnes_ecu = count($types_personnes);
                    if ($nb_types_personnes_ecu != 0) {
                        $file_name = "EXPORT_TABLE_VALEURS_TYPES_PERSONNES_".date('dmYhis',time()).".txt";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename='.$file_name);

                        $fp = fopen('php://output', 'wb');
                        fwrite($fp, str_pad("CODE", 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad("LIBELLE", 45, ' ', STR_PAD_RIGHT) . "\t" . str_pad("DATE EFFET", 10, ' ', STR_PAD_RIGHT) . "\n");
                        foreach ($types_personnes as $type_personne) {
                            fwrite($fp, str_pad($type_personne['code'], 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad($type_personne['libelle'], 45, ' ', STR_PAD_RIGHT) . "\t" . str_pad(date('d/m/Y', strtotime($type_personne['date_debut'])), 10, ' ', STR_PAD_RIGHT) . "\n");
                        }
                        fclose($fp);
                    }
                }
                elseif($data == 'tac') {
                    require "../_CONFIGS/Classes/TYPESACCIDENTS.php";
                    $TYPESACCIDENTS = new TYPESACCIDENTS();
                    $typesaccidents = $TYPESACCIDENTS->lister();
                    $nb_typesaccidents = count($typesaccidents);
                    if ($nb_typesaccidents != 0) {
                        $file_name = "EXPORT_TABLE_VALEURS_TYPES_ACCIDENTS_".date('dmYhis',time()).".txt";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename='.$file_name);

                        $fp = fopen('php://output', 'wb');
                        fwrite($fp, str_pad("CODE", 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad("LIBELLE", 45, ' ', STR_PAD_RIGHT) . "\t" . str_pad("DATE EFFET", 10, ' ', STR_PAD_RIGHT) . "\n");
                        foreach ($typesaccidents as $typesaccident) {
                            fwrite($fp, str_pad($typesaccident['code'], 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad($typesaccident['libelle'], 45, ' ', STR_PAD_RIGHT) . "\t" . str_pad(date('d/m/Y', strtotime($typesaccident['date_debut'])), 10, ' ', STR_PAD_RIGHT) . "\n");
                        }
                        fclose($fp);
                    }
                }
                elseif($data == 'sif') {
                    require "../_CONFIGS/Classes/SITUATIONSFAMILIALES.php";
                    $SITUATIONFAMILLES = new SITUATIONSFAMILIALES();
                    $situationfamilles = $SITUATIONFAMILLES->lister();
                    $nb_situationfamilles = count($situationfamilles);
                    if ($nb_situationfamilles != 0) {
                        $file_name = "EXPORT_TABLE_VALEURS_SITUATIONS_FAMILIALES_".date('dmYhis',time()).".txt";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename='.$file_name);

                        $fp = fopen('php://output', 'wb');
                        fwrite($fp, str_pad("CODE", 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad("LIBELLE", 45, ' ', STR_PAD_RIGHT) . "\t" . str_pad("DATE EFFET", 10, ' ', STR_PAD_RIGHT) . "\n");
                        foreach ($situationfamilles as $situationfamille) {
                            fwrite($fp, str_pad($situationfamille['code'], 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad($situationfamille['libelle'], 45, ' ', STR_PAD_RIGHT) . "\t" . str_pad(date('d/m/Y', strtotime($situationfamille['date_debut'])), 10, ' ', STR_PAD_RIGHT) . "\n");
                        }
                        fclose($fp);
                    }
                }
                elseif($data == 'sct') {
                    require "../_CONFIGS/Classes/SECTEURSACTIVITES.php";
                    $SECTEURSACTVITES = new SECTEURSACTIVITES();
                    $secteursactivites = $SECTEURSACTVITES->lister();
                    $nb_secteursactivites = count($secteursactivites);
                    if ($nb_secteursactivites != 0) {
                        $file_name = "EXPORT_TABLE_VALEURS_SECTEURS_ACTIVITES_".date('dmYhis',time()).".txt";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename='.$file_name);

                        $fp = fopen('php://output', 'wb');
                        fwrite($fp, str_pad("CODE", 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad("LIBELLE", 45, ' ', STR_PAD_RIGHT) . "\t" . str_pad("DATE EFFET", 10, ' ', STR_PAD_RIGHT) . "\n");
                        foreach ($secteursactivites as $secteursactivite) {
                            fwrite($fp, str_pad($secteursactivite['code'], 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad($secteursactivite['libelle'], 45, ' ', STR_PAD_RIGHT) . "\t" . str_pad(date('d/m/Y', strtotime($secteursactivite['date_debut'])), 10, ' ', STR_PAD_RIGHT) . "\n");
                        }
                        fclose($fp);
                    }
                }
                elseif($data == 'prf') {
                    require "../_CONFIGS/Classes/PROFESSIONS.php";
                    $PROFESSIONS = new PROFESSIONS();
                    $professions = $PROFESSIONS->lister();
                    $nb_professions = count($professions);
                    if ($nb_professions != 0) {
                        $file_name = "EXPORT_TABLE_VALEURS_PROFESSIONS_".date('dmYhis',time()).".txt";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename='.$file_name);

                        $fp = fopen('php://output', 'wb');
                        fwrite($fp, str_pad("CODE", 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad("LIBELLE", 45, ' ', STR_PAD_RIGHT) . "\t" . str_pad("DATE EFFET", 10, ' ', STR_PAD_RIGHT) . "\n");
                        foreach ($professions as $profession) {
                            fwrite($fp, str_pad($profession['code'], 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad($profession['libelle'], 45, ' ', STR_PAD_RIGHT) . "\t" . str_pad(date('d/m/Y', strtotime($profession['date_debut'])), 10, ' ', STR_PAD_RIGHT) . "\n");
                        }
                        fclose($fp);
                    }
                }
                elseif($data == 'qtc') {
                    require "../_CONFIGS/Classes/QUALITESCIVILES.php";
                    $QUALITESCIVILTES = new QUALITESCIVILES();
                    $qualitesciviles = $QUALITESCIVILTES->lister();
                    $nb_qualitesciviles = count($qualitesciviles);
                    if ($nb_qualitesciviles != 0) {
                        $file_name = "EXPORT_TABLE_VALEURS_QUALITES_CIVILITES_".date('dmYhis',time()).".txt";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename='.$file_name);

                        $fp = fopen('php://output', 'wb');
                        fwrite($fp, str_pad("CODE", 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad("LIBELLE", 45, ' ', STR_PAD_RIGHT) . "\t" . str_pad("DATE EFFET", 10, ' ', STR_PAD_RIGHT) . "\n");
                        foreach ($qualitesciviles as $qualitescivile) {
                            fwrite($fp, str_pad($qualitescivile['code'], 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad($qualitescivile['libelle'], 45, ' ', STR_PAD_RIGHT) . "\t" . str_pad(date('d/m/Y', strtotime($qualitescivile['date_debut'])), 10, ' ', STR_PAD_RIGHT) . "\n");
                        }
                        fclose($fp);
                    }
                }
                elseif($data == 'tco') {
                    require "../_CONFIGS/Classes/TYPESCOORDONNEES.php";
                    $TYPESCOORDONNEES = new TYPESCOORDONNEES();
                    $typescoordonnees = $TYPESCOORDONNEES->lister();
                    $nb_typescoordonnees = count($typescoordonnees);
                    if ($nb_typescoordonnees != 0) {
                        $file_name = "EXPORT_TABLE_VALEURS_TYPES_COORDONNEES_".date('dmYhis',time()).".txt";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename='.$file_name);

                        $fp = fopen('php://output', 'wb');
                        fwrite($fp, str_pad("CODE", 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad("LIBELLE", 45, ' ', STR_PAD_RIGHT) . "\t" . str_pad("DATE EFFET", 10, ' ', STR_PAD_RIGHT) . "\n");
                        foreach ($typescoordonnees as $typescoordonnee) {
                            fwrite($fp, str_pad($typescoordonnee['code'], 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad($typescoordonnee['libelle'], 45, ' ', STR_PAD_RIGHT) . "\t" . str_pad(date('d/m/Y', strtotime($typescoordonnee['date_debut'])), 10, ' ', STR_PAD_RIGHT) . "\n");
                        }
                        fclose($fp);
                    }
                }
                elseif($data == 'tpi') {
                    require "../_CONFIGS/Classes/TYPESPIECESIDENTITES.php";
                    $TYPESPIECESIDENTITES = new TYPESPIECESIDENTITES();
                    $typespiecesidentites = $TYPESPIECESIDENTITES->lister();
                    $nb_typespiecesidentites = count($typespiecesidentites);
                    if ($nb_typespiecesidentites != 0) {
                        $file_name = "EXPORT_TABLE_VALEURS_TYPES_PIECES_".date('dmYhis',time()).".txt";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename='.$file_name);

                        $fp = fopen('php://output', 'wb');
                        fwrite($fp, str_pad("CODE", 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad("LIBELLE", 45, ' ', STR_PAD_RIGHT) . "\t" . str_pad("DATE EFFET", 10, ' ', STR_PAD_RIGHT) . "\n");
                        foreach ($typespiecesidentites as $typespiecesidentite) {
                            fwrite($fp, str_pad($typespiecesidentite['code'], 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad($typespiecesidentite['libelle'], 45, ' ', STR_PAD_RIGHT) . "\t" . str_pad(date('d/m/Y', strtotime($typespiecesidentite['date_debut'])), 10, ' ', STR_PAD_RIGHT) . "\n");
                        }
                        fclose($fp);
                    }
                }
                elseif($data == 'dev') {
                    require "../_CONFIGS/Classes/DEVISESMONETAIRES.php";
                    $DEVISES = new DEVISESMONETAIRES();
                    $devises = $DEVISES->lister();
                    $nb_devises = count($devises);
                    if ($nb_devises != 0) {
                        $file_name = "EXPORT_TABLE_VALEURS_DEVISES_MONETAIRES_".date('dmYhis',time()).".txt";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename='.$file_name);

                        $fp = fopen('php://output', 'wb');
                        fwrite($fp, str_pad("CODE", 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad("LIBELLE", 45, ' ', STR_PAD_RIGHT) . "\t" . str_pad("DATE EFFET", 10, ' ', STR_PAD_RIGHT) . "\n");
                        foreach ($devises as $devise) {
                            fwrite($fp, str_pad($devise['code'], 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad($devise['libelle'], 45, ' ', STR_PAD_RIGHT) . "\t" . str_pad(date('d/m/Y', strtotime($devise['date_debut'])), 10, ' ', STR_PAD_RIGHT) . "\n");
                        }
                        fclose($fp);
                    }
                }
                elseif($data == 'gsa') {
                    require "../_CONFIGS/Classes/GROUPESSANGUINS.php";
                    $GROUPESSANGUINS = new GROUPESSANGUINS();
                    $groupesanguins = $GROUPESSANGUINS->lister();
                    $nb_groupesanguins = count($groupesanguins);
                    if ($nb_groupesanguins != 0) {
                        $file_name = "EXPORT_TABLE_VALEURS_GROUPES_SANGUINS_".date('dmYhis',time()).".txt";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename='.$file_name);

                        $fp = fopen('php://output', 'wb');
                        fwrite($fp, str_pad("CODE", 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad("LIBELLE", 45, ' ', STR_PAD_RIGHT) . "\t" . str_pad("DATE EFFET", 10, ' ', STR_PAD_RIGHT) . "\n");
                        foreach ($groupesanguins as $groupesanguin) {
                            fwrite($fp, str_pad($groupesanguin['code'], 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad($groupesanguin['libelle'], 45, ' ', STR_PAD_RIGHT) . "\t" . str_pad(date('d/m/Y', strtotime($groupesanguin['date_debut'])), 10, ' ', STR_PAD_RIGHT) . "\n");
                        }
                        fclose($fp);
                    }
                }
                elseif($data == 'rhs') {
                    require "../_CONFIGS/Classes/GROUPESSANGUINS.php";
                    $GROUPESSANGUINS = new GROUPESSANGUINS();
                    $groupesanguins = $GROUPESSANGUINS->lister_rhesus();
                    $nb_groupesanguins = count($groupesanguins);
                    if ($nb_groupesanguins != 0) {
                        $file_name = "EXPORT_TABLE_VALEURS_RHESUS_SANGUINS_".date('dmYhis',time()).".txt";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename='.$file_name);

                        $fp = fopen('php://output', 'wb');
                        fwrite($fp, str_pad("CODE", 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad("LIBELLE", 45, ' ', STR_PAD_RIGHT) . "\t" . str_pad("DATE EFFET", 10, ' ', STR_PAD_RIGHT) . "\n");
                        foreach ($groupesanguins as $groupesanguin) {
                            fwrite($fp, str_pad($groupesanguin['code'], 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad($groupesanguin['libelle'], 45, ' ', STR_PAD_RIGHT) . "\t" . str_pad(date('d/m/Y', strtotime($groupesanguin['date_debut'])), 10, ' ', STR_PAD_RIGHT) . "\n");
                        }
                        fclose($fp);
                    }
                }
                elseif($data == 'lge') {
                    require "../_CONFIGS/Classes/LOCALISATIONSGEOGRAPHIQUES.php";
                    $LOCALISATIONSGEOGRAPHIQUES = new LOCALISATIONSGEOGRAPHIQUES();
                    $payss = $LOCALISATIONSGEOGRAPHIQUES->lister_pays();
                    $nb_pays = count($payss);
                    if ($nb_pays != 0) {
                        $file_name = "EXPORT_TABLE_VALEURS_PAYS_".date('dmYhis',time()).".txt";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename='.$file_name);

                        $fp = fopen('php://output', 'wb');
                        fwrite($fp, str_pad("CODE", 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad("NOM", 45, ' ', STR_PAD_RIGHT) . "\t" . str_pad("GENTILE", 45, ' ', STR_PAD_RIGHT) . "\t" . str_pad("DEVISE MONNETAIRE", 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad("LATITUDE", 15, ' ', STR_PAD_RIGHT) . "\t" . str_pad("LONGITUDE", 15, ' ', STR_PAD_RIGHT) . "\t" . str_pad("DATE EFFET", 10, ' ', STR_PAD_RIGHT) . "\n");
                        foreach ($payss as $pays) {
                            fwrite($fp, str_pad($pays['code'], 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad($pays['nom'], 45, ' ', STR_PAD_RIGHT). "\t" . str_pad($pays['gentile'], 45, ' ', STR_PAD_RIGHT). "\t" . str_pad($pays['devise'], 10, ' ', STR_PAD_RIGHT). "\t" . str_pad($pays['latitude'], 15, ' ', STR_PAD_RIGHT). "\t" . str_pad($pays['longitude'], 15, ' ', STR_PAD_RIGHT) . "\t" . str_pad(date('d/m/Y', strtotime($pays['date_debut'])), 10, ' ', STR_PAD_RIGHT) . "\n");
                        }
                        fclose($fp);
                    }
                }
                elseif($data == 'reg') {
                    require "../_CONFIGS/Classes/LOCALISATIONSGEOGRAPHIQUES.php";
                    $LOCALISATIONSGEOGRAPHIQUES = new LOCALISATIONSGEOGRAPHIQUES();
                    $regions = $LOCALISATIONSGEOGRAPHIQUES->lister_regions(null);
                    $nb_regions = count($regions);
                    if ($nb_regions != 0) {
                        $file_name = "EXPORT_TABLE_VALEURS_REGIONS_".date('dmYhis',time()).".txt";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename='.$file_name);

                        $fp = fopen('php://output', 'wb');
                        fwrite($fp, str_pad("CODE", 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad("PAYS", 45, ' ', STR_PAD_RIGHT) . "\t" . str_pad("NOM", 45, ' ', STR_PAD_RIGHT). "\t" . str_pad("LATITUDE", 15, ' ', STR_PAD_RIGHT) . "\t" . str_pad("LONGITUDE", 15, ' ', STR_PAD_RIGHT) . "\t" . str_pad("DATE EFFET", 10, ' ', STR_PAD_RIGHT) . "\n");
                        foreach ($regions as $region) {
                            fwrite($fp, str_pad($region['code'], 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad($region['nom_pays'], 45, ' ', STR_PAD_RIGHT). "\t" . str_pad($region['nom'], 45, ' ', STR_PAD_RIGHT). "\t" . str_pad($region['latitude'], 15, ' ', STR_PAD_RIGHT). "\t" . str_pad($region['longitude'], 15, ' ', STR_PAD_RIGHT) . "\t" . str_pad(date('d/m/Y', strtotime($region['date_debut'])), 10, ' ', STR_PAD_RIGHT) . "\n");
                        }
                        fclose($fp);
                    }
                }
                elseif($data == 'dep') {
                    require "../_CONFIGS/Classes/LOCALISATIONSGEOGRAPHIQUES.php";
                    $LOCALISATIONSGEOGRAPHIQUES = new LOCALISATIONSGEOGRAPHIQUES();
                    $departemements = $LOCALISATIONSGEOGRAPHIQUES->lister_departements(null);
                    $nb_departemements = count($departemements);
                    if ($nb_departemements != 0) {
                        $file_name = "EXPORT_TABLE_VALEURS_DEPARTEMENTS_".date('dmYhis',time()).".txt";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename='.$file_name);

                        $fp = fopen('php://output', 'wb');
                        fwrite($fp, str_pad("CODE", 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad("PAYS", 45, ' ', STR_PAD_RIGHT) . "\t" . str_pad("REGION", 45, ' ', STR_PAD_RIGHT) . "\t" . str_pad("NOM", 45, ' ', STR_PAD_RIGHT). "\t" . str_pad("LATITUDE", 15, ' ', STR_PAD_RIGHT) . "\t" . str_pad("LONGITUDE", 15, ' ', STR_PAD_RIGHT) . "\t" . str_pad("DATE EFFET", 10, ' ', STR_PAD_RIGHT) . "\n");
                        foreach ($departemements as $departemement) {
                            fwrite($fp, str_pad($departemement['code'], 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad($departemement['nom_pays'], 45, ' ', STR_PAD_RIGHT). "\t" . str_pad($departemement['nom_region'], 45, ' ', STR_PAD_RIGHT). "\t" . str_pad($departemement['nom'], 45, ' ', STR_PAD_RIGHT). "\t" . str_pad($departemement['latitude'], 15, ' ', STR_PAD_RIGHT). "\t" . str_pad($departemement['longitude'], 15, ' ', STR_PAD_RIGHT) . "\t" . str_pad(date('d/m/Y', strtotime($departemement['date_debut'])), 10, ' ', STR_PAD_RIGHT) . "\n");
                        }
                        fclose($fp);
                    }
                }
                elseif($data == 'com') {
                    require "../_CONFIGS/Classes/LOCALISATIONSGEOGRAPHIQUES.php";
                    $LOCALISATIONSGEOGRAPHIQUES = new LOCALISATIONSGEOGRAPHIQUES();
                    $communes = $LOCALISATIONSGEOGRAPHIQUES->lister_communes(null);
                    $nb_departemements = count($communes);
                    if ($nb_departemements != 0) {
                        $file_name = "EXPORT_TABLE_VALEURS_COMMUNES_".date('dmYhis',time()).".txt";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename='.$file_name);

                        $fp = fopen('php://output', 'wb');
                        fwrite($fp, str_pad("CODE", 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad("PAYS", 45, ' ', STR_PAD_RIGHT) . "\t" . str_pad("REGION", 45, ' ', STR_PAD_RIGHT). "\t" . str_pad("DEPARTEMENT", 45, ' ', STR_PAD_RIGHT) . "\t" . str_pad("NOM", 45, ' ', STR_PAD_RIGHT). "\t" . str_pad("LATITUDE", 15, ' ', STR_PAD_RIGHT) . "\t" . str_pad("LONGITUDE", 15, ' ', STR_PAD_RIGHT) . "\t" . str_pad("DATE EFFET", 10, ' ', STR_PAD_RIGHT) . "\n");
                        foreach ($communes as $commune) {
                            fwrite($fp, str_pad($commune['code'], 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad($commune['nom_pays'], 45, ' ', STR_PAD_RIGHT). "\t" . str_pad($commune['nom_region'], 45, ' ', STR_PAD_RIGHT). "\t" . str_pad($commune['nom_departement'], 45, ' ', STR_PAD_RIGHT). "\t" . str_pad($commune['nom'], 45, ' ', STR_PAD_RIGHT). "\t" . str_pad($commune['latitude'], 15, ' ', STR_PAD_RIGHT). "\t" . str_pad($commune['longitude'], 15, ' ', STR_PAD_RIGHT) . "\t" . str_pad(date('d/m/Y', strtotime($commune['date_debut'])), 10, ' ', STR_PAD_RIGHT) . "\n");
                        }
                        fclose($fp);
                    }
                }
                elseif($data == 'tfa') {
                    require "../_CONFIGS/Classes/TYPESFACTURESMEDICALES.php";
                    $FACTURESMEDICALES = new TYPESFACTURESMEDICALES();
                    $types_factures = $FACTURESMEDICALES->lister();
                    $nb_types_factures = count($types_factures);
                    if ($nb_types_factures != 0) {
                        $file_name = "EXPORT_TABLE_VALEURS_TYPES_FACTURES_MEDICALES_".date('dmYhis',time()).".txt";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename='.$file_name);

                        $fp = fopen('php://output', 'wb');
                        fwrite($fp, str_pad("CODE", 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad("LIBELLE", 45, ' ', STR_PAD_RIGHT) . "\t" . str_pad("DATE EFFET", 10, ' ', STR_PAD_RIGHT) . "\n");
                        foreach ($types_factures as $type_facture) {
                            fwrite($fp, str_pad($type_facture['code'], 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad($type_facture['libelle'], 45, ' ', STR_PAD_RIGHT) . "\t" . str_pad(date('d/m/Y', strtotime($type_facture['date_debut'])), 10, ' ', STR_PAD_RIGHT) . "\n");
                        }
                        fclose($fp);
                    }
                }
                else{
                    echo "<script>window.close();</script>";
                }
            }
            else{
                echo "<script>window.close();</script>";
            }
            $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, "EXPORT DE TABLE DE VALEURS AU FORMAT " . strtoupper($type), $file_name);
        } else {
            echo "<script>window.close();</script>";
        }
    } else {
        echo "<script>window.close();</script>";
    }
} else {
    echo "<script>window.close();</script>";
}