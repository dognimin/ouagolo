<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

define('AUTHOR', 'TECHOUSE');
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
            if ($type == 'csv') {

                //Pathologies
                if ($data == 'pat_chap') {
                    require "../_CONFIGS/Classes/PATHOLOGIES.php";
                    $PATHOLOGIES = new PATHOLOGIES();
                    $chapitres = $PATHOLOGIES->lister_chapitres();
                    $nb_chapitres = count($chapitres);
                    if ($nb_chapitres != 0) {
                        $file_name = "EXPORT_PATHOLOGIES_CHAPITRES_" . date('dmYhis', time()) . ".csv";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename=' . $file_name);

                        $fp = fopen('php://output', 'wb');
                        fputcsv($fp, array('CODE', 'LIBELLE', 'DATE EFFET'), ';');
                        foreach ($chapitres as $chapitre) {
                            fputcsv($fp, array($chapitre['code'], $chapitre['libelle'], date('d/m/Y', strtotime($chapitre['date_debut']))), ';');
                        }
                        fclose($fp);
                    }
                }
                elseif ($data == 'pat_sch') {
                    require "../_CONFIGS/Classes/PATHOLOGIES.php";
                    $PATHOLOGIES = new PATHOLOGIES();
                    $sous_chapitres = $PATHOLOGIES->lister_sous_chapitres(null);
                    $nb_sous_chapitres = count($sous_chapitres);
                    if ($nb_sous_chapitres != 0) {
                        $file_name = "EXPORT_PATHOLOGIES_SOUS_CHAPITRES_" . date('dmYhis', time()) . ".csv";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename=' . $file_name);

                        $fp = fopen('php://output', 'wb');
                        fputcsv($fp, array('CODE', 'CHAPITRE', 'LIBELLE', 'DATE EFFET'), ';');
                        foreach ($sous_chapitres as $sous_chapitre) {
                            fputcsv($fp, array($sous_chapitre['code'], $sous_chapitre['code_chapitre'], $sous_chapitre['libelle'], date('d/m/Y', strtotime($sous_chapitre['date_debut']))), ';');
                        }
                        fclose($fp);
                    }
                }
                elseif ($data == 'pat') {
                    require "../_CONFIGS/Classes/PATHOLOGIES.php";
                    $PATHOLOGIES = new PATHOLOGIES();
                    $pathologies = $PATHOLOGIES->lister_pathologies(null,null);
                    $nb_pathologies = count($pathologies);
                    if ($nb_pathologies != 0) {
                        $file_name = "EXPORT_PATHOLOGIES_" . date('dmYhis', time()) . ".csv";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename=' . $file_name);

                        $fp = fopen('php://output', 'wb');
                        fputcsv($fp, array('CODE', 'CHAPITRE', 'SOUS CHAPITRE', 'LIBELLE', 'DATE EFFET'), ';');
                        foreach ($pathologies as $pathologie) {
                            fputcsv($fp, array($pathologie['code'], $pathologie['code_chapitre'], $pathologie['code_sous_chapitre'], $pathologie['libelle'], date('d/m/Y', strtotime($pathologie['date_debut']))), ';');
                        }
                        fclose($fp);
                    }
                }

                //Actes medicaux
                elseif ($data == 'let_cle') {
                    require "../_CONFIGS/Classes/ACTESMEDICAUX.php";
                    $PATHOLOGIES = new ACTESMEDICAUX();
                    $lettres_cles = $PATHOLOGIES->lister_lettres_cles();
                    $nb_lettres_cles = count($lettres_cles);
                    if ($nb_lettres_cles != 0) {
                        $file_name = "EXPORT_ACTES_MEDICAUX_LETTRES_CLES_" . date('dmYhis', time()) . ".csv";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename=' . $file_name);

                        $fp = fopen('php://output', 'wb');
                        fputcsv($fp, array('CODE', 'LIBELLE', 'PRIX UNITAIRE', 'DATE EFFET'), ';');
                        foreach ($lettres_cles as $lettre_cle) {
                            fputcsv($fp, array($lettre_cle['code'], $lettre_cle['libelle'], $lettre_cle['prix_unitaire'] . ' FCFA', date('d/m/Y', strtotime($lettre_cle['date_debut']))), ';');
                        }
                        fclose($fp);
                    }
                }
                elseif ($data == 'act_tit') {
                    require "../_CONFIGS/Classes/ACTESMEDICAUX.php";
                    $PATHOLOGIES = new ACTESMEDICAUX();
                    $titres = $PATHOLOGIES->lister_titres();
                    $nb_titres = count($titres);
                    if ($nb_titres != 0) {
                        $file_name = "EXPORT_ACTES_MEDICAUX_TITRES_" . date('dmYhis', time()) . ".csv";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename=' . $file_name);

                        $fp = fopen('php://output', 'wb');
                        fputcsv($fp, array('CODE', 'LIBELLE', 'DATE EFFET'), ';');
                        foreach ($titres as $titre) {
                            fputcsv($fp, array($titre['code'], $titre['libelle'], date('d/m/Y', strtotime($titre['date_debut']))), ';');
                        }
                        fclose($fp);
                    }
                }
                elseif ($data == 'act_cha') {
                    require "../_CONFIGS/Classes/ACTESMEDICAUX.php";
                    $ACTESMEDICAUX = new ACTESMEDICAUX();
                    $chapitres = $ACTESMEDICAUX->lister_chapitres(null);
                    $nb_chapitres = count($chapitres);
                    if ($nb_chapitres != 0) {
                        $file_name = "EXPORT_ACTES_MEDICAUX_CHAPITRES_" . date('dmYhis', time()) . ".csv";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename=' . $file_name);

                        $fp = fopen('php://output', 'wb');
                        fputcsv($fp, array('CODE', 'LIBELLE', 'DATE EFFET'), ';');
                        foreach ($chapitres as $chapitre) {
                            fputcsv($fp, array($chapitre['code'], $chapitre['libelle'], date('d/m/Y', strtotime($chapitre['date_debut']))), ';');
                        }
                        fclose($fp);
                    }
                }
                elseif ($data == 'act_sec') {
                    require "../_CONFIGS/Classes/ACTESMEDICAUX.php";
                    $ACTESMEDICAUX = new ACTESMEDICAUX();
                    $sections = $ACTESMEDICAUX->lister_sections(null);
                    $nb_sections = count($sections);
                    if ($nb_sections != 0) {
                        $file_name = "EXPORT_PATHOLOGIES_SECTIONS_" . date('dmYhis', time()) . ".csv";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename=' . $file_name);

                        $fp = fopen('php://output', 'wb');
                        fputcsv($fp, array('CODE', 'TITRE', 'CHAPITRE', 'LIBELLE', 'DATE EFFET'), ';');
                        foreach ($sections as $section) {
                            fputcsv($fp, array($section['code'], $section['code_titre'], $section['code_chapitre'], $section['libelle'], date('d/m/Y', strtotime($section['date_debut']))), ';');
                        }
                        fclose($fp);
                    }
                }
                elseif ($data == 'act_art') {
                    require "../_CONFIGS/Classes/ACTESMEDICAUX.php";
                    $ACTESMEDICAUX = new ACTESMEDICAUX();
                    $articles = $ACTESMEDICAUX->lister_articles(null);
                    $nb_articles = count($articles);
                    if ($nb_articles != 0) {
                        $file_name = "EXPORT_ACTES_MEDICAUX_ARTICLES_" . date('dmYhis', time()) . ".csv";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename=' . $file_name);

                        $fp = fopen('php://output', 'wb');
                        fputcsv($fp, array('CODE', 'TITRE', 'CHAPITRE', 'SECTION', 'LIBELLE', 'DATE EFFET'), ';');
                        foreach ($articles as $article) {
                            fputcsv($fp, array($article['code'], $article['code_titre'], $article['code_chapitre'], $article['code_section'], $article['libelle'], date('d/m/Y', strtotime($article['date_debut']))), ';');
                        }
                        fclose($fp);
                    }
                }
                elseif ($data == 'act_med') {
                    require "../_CONFIGS/Classes/ACTESMEDICAUX.php";
                    $ACTESMEDICAUX = new ACTESMEDICAUX();
                    $actes_medicaux = $ACTESMEDICAUX->lister_actes_medicaux(null);
                    $nb_actes_medicaux = count($actes_medicaux);
                    if ($nb_actes_medicaux != 0) {
                        $file_name = "EXPORT_ACTES_MEDICAUX_" . date('dmYhis', time()) . ".csv";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename=' . $file_name);

                        $fp = fopen('php://output', 'wb');
                        fputcsv($fp, array('CODE', 'TITRE', 'CHAPITRE', 'SECTION', 'ARTICLE', 'LIBELLE', 'DATE EFFET'), ';');
                        foreach ($actes_medicaux as $acte_medical) {
                            fputcsv($fp, array($acte_medical['code'], $acte_medical['code_titre'], $acte_medical['code_chapitre'], $acte_medical['code_section'], $acte_medical['code_article'], $acte_medical['libelle'], date('d/m/Y', strtotime($acte_medical['date_debut']))), ';');
                        }
                        fclose($fp);
                    }
                }

                //Medicaments
                elseif ($data == 'med_lab') {
                    require "../_CONFIGS/Classes/MEDICAMENTS.php";
                    $MEDICAMENTS = new MEDICAMENTS();
                    $laboratoires = $MEDICAMENTS->lister_laboratoires_pharmaceutiques();
                    $nb_laboratoires = count($laboratoires);
                    if ($nb_laboratoires != 0) {
                        $file_name = "EXPORT_MEDICAMENTS_LABORATOIRES_PHARMACEUTIQUES_" . date('dmYhis', time()) . ".csv";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename=' . $file_name);

                        $fp = fopen('php://output', 'wb');
                        fputcsv($fp, array('CODE', 'LIBELLE', 'DATE EFFET'), ';');
                        foreach ($laboratoires as $laboratoire) {
                            fputcsv($fp, array($laboratoire['code'], $laboratoire['libelle'], date('d/m/Y', strtotime($laboratoire['date_debut']))), ';');
                        }
                        fclose($fp);
                    }
                }
                elseif ($data == 'med') {
                    require "../_CONFIGS/Classes/MEDICAMENTS.php";
                    $MEDICAMENTS = new MEDICAMENTS();
                    $medicaments = $MEDICAMENTS->lister_medicaments();
                    $nb_medicaments = count($medicaments);
                    if ($nb_medicaments != 0) {
                        $file_name = "EXPORT_MEDICAMENTS_" . date('dmYhis', time()) . ".csv";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename=' . $file_name);

                        $fp = fopen('php://output', 'wb');
                        fputcsv($fp, array('CODE', 'LIBELLE', 'FORME', 'DCI', 'EAN13', 'DOSAGE', 'UNITE', 'DATE EFFET'), ';');
                        foreach ($medicaments as $medicament) {
                            fputcsv($fp, array($medicament['code'], $medicament['libelle'], $medicament['code_forme'], $medicament['code_dci'], $medicament['code_ean13'], $medicament['dosage'], $medicament['code_unite_dosage'], date('d/m/Y', strtotime($medicament['date_debut']))), ';');
                        }
                        fclose($fp);
                    }
                }
                elseif ($data == 'med_pre') {
                    require "../_CONFIGS/Classes/MEDICAMENTS.php";
                    $MEDICAMENTS = new MEDICAMENTS();
                    $presentations = $MEDICAMENTS->lister_presentations();
                    $nb_presentations = count($presentations);
                    if ($nb_presentations != 0) {
                        $file_name = "EXPORT_MEDICAMENTS_PRESENSATIONS_" . date('dmYhis', time()) . ".csv";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename=' . $file_name);

                        $fp = fopen('php://output', 'wb');
                        fputcsv($fp, array('CODE', 'LIBELLE', 'DATE EFFET'), ';');
                        foreach ($presentations as $presentation) {
                            fputcsv($fp, array($presentation['code'], $presentation['libelle'], date('d/m/Y', strtotime($presentation['date_debut']))), ';');
                        }
                        fclose($fp);
                    }
                }
                elseif ($data == 'med_ffm') {
                    require "../_CONFIGS/Classes/MEDICAMENTS.php";
                    $MEDICAMENTS = new MEDICAMENTS();
                    $famillesformes = $MEDICAMENTS->lister_familles_formes();
                    $nb_famillesformes = count($famillesformes);
                    if ($nb_famillesformes != 0) {
                        $file_name = "EXPORT_MEDICAMENTS_FAMILLES_FORMES_" . date('dmYhis', time()) . ".csv";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename=' . $file_name);

                        $fp = fopen('php://output', 'wb');
                        fputcsv($fp, array('CODE', 'LIBELLE', 'DATE EFFET'), ';');
                        foreach ($famillesformes as $familleforme) {
                            fputcsv($fp, array($familleforme['code'], $familleforme['libelle'], date('d/m/Y', strtotime($familleforme['date_debut']))), ';');
                        }
                        fclose($fp);
                    }
                }
                elseif ($data == 'med_frm') {
                    require "../_CONFIGS/Classes/MEDICAMENTS.php";
                    $MEDICAMENTS = new MEDICAMENTS();
                    $formes = $MEDICAMENTS->lister_formes();
                    $nb_formes = count($formes);
                    if ($nb_formes != 0) {
                        $file_name = "EXPORT_MEDICAMENTS_FORMES_" . date('dmYhis', time()) . ".csv";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename=' . $file_name);

                        $fp = fopen('php://output', 'wb');
                        fputcsv($fp, array('CODE', 'LIBELLE', 'DATE EFFET'), ';');
                        foreach ($formes as $forme) {
                            fputcsv($fp, array($forme['code'], $forme['libelle'], date('d/m/Y', strtotime($forme['date_debut']))), ';');
                        }
                        fclose($fp);
                    }
                }
                elseif ($data == 'med_typ') {
                    require "../_CONFIGS/Classes/MEDICAMENTS.php";
                    $MEDICAMENTS = new MEDICAMENTS();
                    $types_medicaments = $MEDICAMENTS->lister_types_medicaments();
                    $nb_types_medicaments = count($types_medicaments);
                    if ($nb_types_medicaments != 0) {
                        $file_name = "EXPORT_MEDICAMENTS_TYPES_MEDICAMENTS_" . date('dmYhis', time()) . ".csv";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename=' . $file_name);

                        $fp = fopen('php://output', 'wb');
                        fputcsv($fp, array('CODE', 'LIBELLE', 'DATE EFFET'), ';');
                        foreach ($types_medicaments as $type_medicament) {
                            fputcsv($fp, array($type_medicament['code'], $type_medicament['libelle'], date('d/m/Y', strtotime($type_medicament['date_debut']))), ';');
                        }
                        fclose($fp);
                    }
                }
                elseif ($data == 'med_cth') {
                    require "../_CONFIGS/Classes/MEDICAMENTS.php";
                    $MEDICAMENTS = new MEDICAMENTS();
                    $classes_therapeuthiques = $MEDICAMENTS->lister_classes_therapeutiques();
                    $nb_classes_therapeutiques = count($classes_therapeuthiques);
                    if ($nb_classes_therapeutiques != 0) {
                        $file_name = "EXPORT_MEDICAMENTS_CLASSES_THERAPEUTIQUES_" . date('dmYhis', time()) . ".csv";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename=' . $file_name);

                        $fp = fopen('php://output', 'wb');
                        fputcsv($fp, array('CODE', 'LIBELLE', 'DATE EFFET'), ';');
                        foreach ($classes_therapeuthiques as $classe_therapeuthique) {
                            fputcsv($fp, array($classe_therapeuthique['code'], $classe_therapeuthique['libelle'], date('d/m/Y', strtotime($classe_therapeuthique['date_debut']))), ';');
                        }
                        fclose($fp);
                    }
                }
                elseif ($data == 'med_fra') {
                    require "../_CONFIGS/Classes/MEDICAMENTS.php";
                    $MEDICAMENTS = new MEDICAMENTS();
                    $formes_administrations = $MEDICAMENTS->lister_formes_administrations();
                    $nb_formes_administrations = count($formes_administrations);
                    if ($nb_formes_administrations != 0) {
                        $file_name = "EXPORT_MEDICAMENTS_FORMES_ADMINISTRATION_" . date('dmYhis', time()) . ".csv";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename=' . $file_name);

                        $fp = fopen('php://output', 'wb');
                        fputcsv($fp, array('CODE', 'LIBELLE', 'DATE EFFET'), ';');
                        foreach ($formes_administrations as $forme_administration) {
                            fputcsv($fp, array($forme_administration['code'], $forme_administration['libelle'], date('d/m/Y', strtotime($forme_administration['date_debut']))), ';');
                        }
                        fclose($fp);
                    }
                }
                elseif ($data == 'med_unt') {
                    require "../_CONFIGS/Classes/MEDICAMENTS.php";
                    $MEDICAMENTS = new MEDICAMENTS();
                    $unites_dosages = $MEDICAMENTS->lister_unites_dosages();
                    $nb_unites_dosages = count($unites_dosages);
                    if ($nb_unites_dosages != 0) {
                        $file_name = "EXPORT_MEDICAMENTS_UNITES_DOSAGES_" . date('dmYhis', time()) . ".csv";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename=' . $file_name);

                        $fp = fopen('php://output', 'wb');
                        fputcsv($fp, array('CODE', 'LIBELLE', 'DATE EFFET'), ';');
                        foreach ($unites_dosages as $unite_dosage) {
                            fputcsv($fp, array($unite_dosage['code'], $unite_dosage['libelle'], date('d/m/Y', strtotime($unite_dosage['date_debut']))), ';');
                        }
                        fclose($fp);
                    }
                }
                elseif ($data == 'med_dci') {
                    require "../_CONFIGS/Classes/MEDICAMENTS.php";
                    $MEDICAMENTS = new MEDICAMENTS();
                    $denominations_communes_internationales = $MEDICAMENTS->lister_dci(null);
                    $nb_dci = count($denominations_communes_internationales);
                    if ($nb_dci != 0) {
                        $file_name = "EXPORT_MEDICAMENTS_DCI_" . date('dmYhis', time()) . ".csv";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename=' . $file_name);

                        $fp = fopen('php://output', 'wb');
                        fputcsv($fp, array('CODE', 'LIBELLE', 'UNITE DE DOSAGE', 'FORME', 'DATE EFFET'), ';');
                        foreach ($denominations_communes_internationales as $dci) {
                            fputcsv($fp, array($dci['code'], $dci['libelle'], $dci['dosage'] . $dci['code_unite'], $dci['code_forme'], date('d/m/Y', strtotime($dci['date_debut']))), ';');
                        }
                        fclose($fp);
                    }
                }

                //ETABLISSEMENTS
                elseif ($data == 'etab_niveau') {
                    require "../_CONFIGS/Classes/ETABLISSEMENTS.php";
                    $ETABLISSEMENTS = new ETABLISSEMENTS();
                    $niveaux = $ETABLISSEMENTS->lister_niveau_sanitaire();
                    $nb_niveaux = count($niveaux);
                    if ($nb_niveaux != 0) {
                        $file_name = "EXPORT_ETABLISSEMENTS_NIVEAUX_SANITAIRES_" . date('dmYhis', time()) . ".csv";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename=' . $file_name);

                        $fp = fopen('php://output', 'wb');
                        fputcsv($fp, array('CODE', 'LIBELLE', 'NIVEAU', 'DATE EFFET'), ';');
                        foreach ($niveaux as $niveau) {
                            fputcsv($fp, array($niveau['code'], $niveau['libelle'], $niveau['niveau'], date('d/m/Y', strtotime($niveau['date_debut']))), ';');
                        }
                        fclose($fp);
                    }
                }
                else {
                    echo "<script>window.close();</script>";
                }
            }
            elseif ($type == 'xls') {
                require_once '../vendor/autoload.php';
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                $row = 1;
                $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                $drawing->setName('Logo');
                $drawing->setDescription('Logo Ouagolo');
                $drawing->setPath(IMAGES_DIR . 'logos/logo-ouagolo.png');
                $drawing->setCoordinates('A' . $row);
                $sheet->mergeCells('A' . $row . ':C' . ($row = $row + 2));
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

                //PATHOLOGIES
                if ($data == 'pat_chap') {
                    $file_name = "EXPORT_PHATOLOGIES_CHAPITRES_" . date('dmYhis', time()) . ".xls";
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment; filename="' . $file_name . '"');

                    require "../_CONFIGS/Classes/PATHOLOGIES.php";
                    $PATHOLOGIES = new PATHOLOGIES();
                    $chapitres = $PATHOLOGIES->lister_chapitres();
                    $nb_chapitres = count($chapitres);
                    if ($nb_chapitres != 0) {

                        $row = 1;
                        $sheet->getStyle('D' . $row . ':T' . $row)->applyFromArray($style_titre);
                        $sheet->setCellValue('D' . $row, 'REFERENTIEL : PATHOLOGIES CHAPITRES');
                        $sheet->mergeCells('D' . $row . ':T' . ($row = $row + 2));
                        $sheet->getStyle('D1' . ':T' . $row)
                            ->getBorders()
                            ->getAllBorders()
                            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

                        $row++;
                        $sheet->getStyle('A' . $row . ':T' . $row)->applyFromArray($style_entete);
                        $sheet->mergeCells('C' . $row . ':R' . $row);
                        $sheet->mergeCells('S' . $row . ':T' . $row);
                        $sheet->setCellValue('A' . $row, 'N°');
                        $sheet->setCellValue('B' . $row, 'CODE');
                        $sheet->setCellValue('C' . $row, 'LIBELLE');
                        $sheet->setCellValue('S' . $row, 'DATE EFFET');
                        $ligne = 1;
                        foreach ($chapitres as $chapitre) {
                            $row++;
                            $sheet->getStyle('A' . $row . ':T' . $row)->applyFromArray($style_tableau);
                            $sheet->mergeCells('C' . $row . ':R' . $row);
                            $sheet->mergeCells('S' . $row . ':T' . $row);
                            $sheet->setCellValue('A' . $row, $ligne);
                            $sheet->setCellValue('B' . $row, $chapitre['code']);
                            $sheet->setCellValue('C' . $row, $chapitre['libelle']);
                            $spreadsheet->getActiveSheet()->getStyle('S' . $row)
                                ->getNumberFormat()
                                ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                            $sheet->setCellValue('S' . $row, date('d/m/Y', strtotime($chapitre['date_debut'])));
                            $ligne++;
                        }

                        $writer = new Xlsx($spreadsheet);
                        $writer->save("php://output");
                    }
                }
                elseif ($data == 'pat_sch') {
                    $file_name = "EXPORT_PHATOLOGIES_SOUS_CHAPITRES_" . date('dmYhis', time()) . ".xls";
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment; filename="' . $file_name . '"');

                    require "../_CONFIGS/Classes/PATHOLOGIES.php";
                    $PATHOLOGIES = new PATHOLOGIES();
                    $sous_chapitres = $PATHOLOGIES->lister_sous_chapitres(null);
                    $nb_sous_chapitres = count($sous_chapitres);
                    if ($nb_sous_chapitres != 0) {

                        $row = 1;
                        $sheet->getStyle('D' . $row . ':L' . $row)->applyFromArray($style_titre);
                        $sheet->setCellValue('D' . $row, 'PATHOLOGIES :  SOUS CHAPITRES');
                        $sheet->mergeCells('D' . $row . ':L' . ($row = $row + 2));
                        $sheet->getStyle('D1' . ':L' . $row)
                            ->getBorders()
                            ->getAllBorders()
                            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

                        $row++;
                        $sheet->getStyle('A' . $row . ':L' . $row)->applyFromArray($style_entete);
                        $sheet->mergeCells('C' . $row . ':D' . $row);
                        $sheet->mergeCells('E' . $row . ':J' . $row);
                        $sheet->mergeCells('K' . $row . ':L' . $row);
                        $sheet->setCellValue('A' . $row, 'N°');
                        $sheet->setCellValue('B' . $row, 'CODE');
                        $sheet->setCellValue('C' . $row, 'CHAPITRE');
                        $sheet->setCellValue('E' . $row, 'LIBELLE');
                        $sheet->setCellValue('K' . $row, 'DATE EFFET');
                        $ligne = 1;
                        foreach ($sous_chapitres as $sous_chapitre) {
                            $row++;
                            $sheet->getStyle('A' . $row . ':L' . $row)->applyFromArray($style_tableau);
                            $sheet->mergeCells('C' . $row . ':D' . $row);
                            $sheet->mergeCells('E' . $row . ':J' . $row);
                            $sheet->mergeCells('K' . $row . ':L' . $row);
                            $sheet->setCellValue('A' . $row, $ligne);
                            $sheet->setCellValue('B' . $row, $sous_chapitre['code']);
                            $sheet->setCellValue('C' . $row, $sous_chapitre['code_chapitre']);
                            $sheet->setCellValue('E' . $row, $sous_chapitre['libelle']);
                            $spreadsheet->getActiveSheet()->getStyle('K' . $row)
                                ->getNumberFormat()
                                ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                            $sheet->setCellValue('K' . $row, date('d/m/Y', strtotime($sous_chapitre['date_debut'])));
                            $ligne++;
                        }

                        $writer = new Xlsx($spreadsheet);
                        $writer->save("php://output");
                    }
                }
                elseif ($data == 'pat') {
                    $file_name = "EXPORT_PATHOLOGIES_" . date('dmYhis', time()) . ".xls";
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment; filename="' . $file_name . '"');

                    require "../_CONFIGS/Classes/PATHOLOGIES.php";
                    $PATHOLOGIES = new PATHOLOGIES();
                    $pathologies = $PATHOLOGIES->lister_pathologies(null,null);
                    $nb_pathologies = count($pathologies);
                    if ($nb_pathologies != 0) {

                        $row = 1;
                        $sheet->getStyle('D' . $row . ':Z' . $row)->applyFromArray($style_titre);
                        $sheet->setCellValue('D' . $row, 'REFERENTIEL : PATHOLOGIES');
                        $sheet->mergeCells('D' . $row . ':Z' . ($row = $row + 2));
                        $sheet->getStyle('D1' . ':Z' . $row)
                            ->getBorders()
                            ->getAllBorders()
                            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

                        $row++;
                        $sheet->getStyle('A' . $row . ':Z' . $row)->applyFromArray($style_entete);
                        $sheet->mergeCells('C' . $row . ':D' . $row);
                        $sheet->mergeCells('E' . $row . ':F' . $row);
                        $sheet->mergeCells('G' . $row . ':X' . $row);
                        $sheet->mergeCells('Y' . $row . ':Z' . $row);
                        $sheet->setCellValue('A' . $row, 'N°');
                        $sheet->setCellValue('B' . $row, 'CODE');
                        $sheet->setCellValue('C' . $row, 'CHAPITRE');
                        $sheet->setCellValue('E' . $row, 'SOUS_CHAPITRE');
                        $sheet->setCellValue('G' . $row, 'LIBELLE');
                        $sheet->setCellValue('Y' . $row, 'DATE EFFET');
                        $ligne = 1;
                        foreach ($pathologies as $pathologie) {
                            $row++;
                            $sheet->getStyle('A' . $row . ':Z' . $row)->applyFromArray($style_tableau);
                            $sheet->mergeCells('C' . $row . ':D' . $row);
                            $sheet->mergeCells('E' . $row . ':F' . $row);
                            $sheet->mergeCells('G' . $row . ':X' . $row);
                            $sheet->mergeCells('Y' . $row . ':Z' . $row);
                            $sheet->setCellValue('A' . $row, $ligne);
                            $sheet->setCellValue('B' . $row, $pathologie['code_chapitre']);
                            $sheet->setCellValue('C' . $row, $pathologie['code_chapitre']);
                            $sheet->setCellValue('E' . $row, $pathologie['code_sous_chapitre']);
                            $sheet->setCellValue('G' . $row, $pathologie['libelle']);
                            $spreadsheet->getActiveSheet()->getStyle('Y' . $row)
                                ->getNumberFormat()
                                ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                            $sheet->setCellValue('Y' . $row, date('d/m/Y', strtotime($pathologie['date_debut'])));
                            $ligne++;
                        }

                        $writer = new Xlsx($spreadsheet);
                        $writer->save("php://output");
                    }
                }

                //ACTES MEDICAUX
                elseif ($data == 'let_cle') {
                    $file_name = "EXPORT_ACTES_MEDICAUX_LETTRES_CLES_" . date('dmYhis', time()) . ".xls";
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment; filename="' . $file_name . '"');

                    require "../_CONFIGS/Classes/ACTESMEDICAUX.php";
                    $ACTESMEDICAUX = new ACTESMEDICAUX();
                    $actesmedicaux = $ACTESMEDICAUX->lister_lettres_cles();
                    $nb_pathologies = count($actesmedicaux);
                    if ($nb_pathologies != 0) {

                        $row = 1;
                        $sheet->getStyle('D' . $row . ':O' . $row)->applyFromArray($style_titre);
                        $sheet->setCellValue('D' . $row, 'REFERENTIEL : LETTRES CLES');
                        $sheet->mergeCells('D' . $row . ':O' . ($row = $row + 2));
                        $sheet->getStyle('D1' . ':O' . $row)
                            ->getBorders()
                            ->getAllBorders()
                            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

                        $row++;
                        $sheet->getStyle('A' . $row . ':O' . $row)->applyFromArray($style_entete);
                        $sheet->mergeCells('C' . $row . ':J' . $row);
                        $sheet->mergeCells('K' . $row . ':M' . $row);
                        $sheet->mergeCells('N' . $row . ':O' . $row);
                        $sheet->setCellValue('A' . $row, 'N°');
                        $sheet->setCellValue('B' . $row, 'CODE');
                        $sheet->setCellValue('C' . $row, 'LIBELLE');
                        $sheet->setCellValue('k' . $row, 'PRIX UNITAIRE');
                        $sheet->setCellValue('N' . $row, 'DATE EFFET');
                        $ligne = 1;
                        foreach ($actesmedicaux as $actemedical) {
                            $row++;
                            $sheet->getStyle('A' . $row . ':O' . $row)->applyFromArray($style_tableau);
                            $sheet->mergeCells('C' . $row . ':J' . $row);
                            $sheet->mergeCells('K' . $row . ':M' . $row);
                            $sheet->mergeCells('N' . $row . ':O' . $row);
                            $sheet->setCellValue('A' . $row, $ligne);
                            $sheet->setCellValue('B' . $row, $actemedical['code']);
                            $sheet->setCellValue('C' . $row, $actemedical['libelle']);
                            $sheet->setCellValue('K' . $row, $actemedical['prix_unitaire'] . 'FCFA');
                            $spreadsheet->getActiveSheet()->getStyle('N' . $row)
                                ->getNumberFormat()
                                ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                            $sheet->setCellValue('N' . $row, date('d/m/Y', strtotime($actemedical['date_debut'])));
                            $ligne++;
                        }

                        $writer = new Xlsx($spreadsheet);
                        $writer->save("php://output");
                    }
                }
                elseif ($data == 'act_tit') {
                    $file_name = "EXPORT_ACTES_MEDICAUX_TITRES_" . date('dmYhis', time()) . ".xls";
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment; filename="' . $file_name . '"');

                    require "../_CONFIGS/Classes/ACTESMEDICAUX.php";
                    $ACTESMEDICAUX = new ACTESMEDICAUX();
                    $titres = $ACTESMEDICAUX->lister_titres();
                    $nb_titres = count($titres);
                    if ($nb_titres != 0) {

                        $row = 1;
                        $sheet->getStyle('D' . $row . ':L' . $row)->applyFromArray($style_titre);
                        $sheet->setCellValue('D' . $row, 'REFERENTIEL : TITRES');
                        $sheet->mergeCells('D' . $row . ':L' . ($row = $row + 2));
                        $sheet->getStyle('D1' . ':L' . $row)
                            ->getBorders()
                            ->getAllBorders()
                            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

                        $row++;
                        $sheet->getStyle('A' . $row . ':L' . $row)->applyFromArray($style_entete);
                        $sheet->mergeCells('C' . $row . ':J' . $row);
                        $sheet->mergeCells('K' . $row . ':L' . $row);
                        $sheet->setCellValue('A' . $row, 'N°');
                        $sheet->setCellValue('B' . $row, 'CODE');
                        $sheet->setCellValue('C' . $row, 'LIBELLE');
                        $sheet->setCellValue('K' . $row, 'DATE EFFET');
                        $ligne = 1;
                        foreach ($titres as $titre) {
                            $row++;
                            $sheet->getStyle('A' . $row . ':L' . $row)->applyFromArray($style_tableau);
                            $sheet->mergeCells('C' . $row . ':J' . $row);
                            $sheet->mergeCells('K' . $row . ':L' . $row);
                            $sheet->setCellValue('A' . $row, $ligne);
                            $sheet->setCellValue('B' . $row, $titre['code']);
                            $sheet->setCellValue('C' . $row, $titre['libelle']);
                            $spreadsheet->getActiveSheet()->getStyle('K' . $row)
                                ->getNumberFormat()
                                ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                            $sheet->setCellValue('K' . $row, date('d/m/Y', strtotime($titre['date_debut'])));
                            $ligne++;
                        }

                        $writer = new Xlsx($spreadsheet);
                        $writer->save("php://output");
                    }
                }
                elseif ($data == 'act_cha') {
                    $file_name = "EXPORT_ACTES_MEDICAUX_CHAPITRES_" . date('dmYhis', time()) . ".xls";
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment; filename="' . $file_name . '"');

                    require "../_CONFIGS/Classes/ACTESMEDICAUX.php";
                    $ACTESMEDICAUX = new ACTESMEDICAUX();
                    $chapitres = $ACTESMEDICAUX->lister_chapitres(null);
                    $nb_chapitres = count($chapitres);
                    if ($nb_chapitres != 0) {

                        $row = 1;
                        $sheet->getStyle('D' . $row . ':L' . $row)->applyFromArray($style_titre);
                        $sheet->setCellValue('D' . $row, 'REFERENTIEL :   CHAPITRES');
                        $sheet->mergeCells('D' . $row . ':L' . ($row = $row + 2));
                        $sheet->getStyle('D1' . ':L' . $row)
                            ->getBorders()
                            ->getAllBorders()
                            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

                        $row++;
                        $sheet->getStyle('A' . $row . ':L' . $row)->applyFromArray($style_entete);
                        $sheet->mergeCells('D' . $row . ':J' . $row);
                        $sheet->mergeCells('K' . $row . ':L' . $row);
                        $sheet->setCellValue('A' . $row, 'N°');
                        $sheet->setCellValue('B' . $row, 'CODE');
                        $sheet->setCellValue('C' . $row, 'TITRE');
                        $sheet->setCellValue('D' . $row, 'LIBELLE');
                        $sheet->setCellValue('K' . $row, 'DATE EFFET');
                        $ligne = 1;
                        foreach ($chapitres as $chapitre) {
                            $row++;
                            $sheet->getStyle('A' . $row . ':L' . $row)->applyFromArray($style_tableau);
                            $sheet->mergeCells('D' . $row . ':J' . $row);
                            $sheet->mergeCells('K' . $row . ':L' . $row);
                            $sheet->setCellValue('A' . $row, $ligne);
                            $sheet->setCellValue('B' . $row, $chapitre['code']);
                            $sheet->setCellValue('C' . $row, $chapitre['code_titre']);
                            $sheet->setCellValue('D' . $row, $chapitre['libelle']);
                            $spreadsheet->getActiveSheet()->getStyle('K' . $row)
                                ->getNumberFormat()
                                ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                            $sheet->setCellValue('K' . $row, date('d/m/Y', strtotime($chapitre['date_debut'])));
                            $ligne++;
                        }

                        $writer = new Xlsx($spreadsheet);
                        $writer->save("php://output");
                    }
                }
                elseif ($data == 'act_sec') {
                    $file_name = "EXPORT_ACTES_MEDICAUX_SECTIONS_" . date('dmYhis', time()) . ".xls";
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment; filename="' . $file_name . '"');

                    require "../_CONFIGS/Classes/ACTESMEDICAUX.php";
                    $ACTESMEDICAUX = new ACTESMEDICAUX();
                    $sections = $ACTESMEDICAUX->lister_sections(null);
                    $nb_sections = count($sections);
                    if ($nb_sections != 0) {

                        $row = 1;
                        $sheet->getStyle('D' . $row . ':L' . $row)->applyFromArray($style_titre);
                        $sheet->setCellValue('D' . $row, 'REFERENTIEL : ACTE MEDICAL SECTION');
                        $sheet->mergeCells('D' . $row . ':L' . ($row = $row + 2));
                        $sheet->getStyle('D1' . ':L' . $row)
                            ->getBorders()
                            ->getAllBorders()
                            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

                        $row++;
                        $sheet->getStyle('A' . $row . ':L' . $row)->applyFromArray($style_entete);
                        $sheet->mergeCells('E' . $row . ':J' . $row);
                        $sheet->mergeCells('K' . $row . ':L' . $row);
                        $sheet->setCellValue('A' . $row, 'N°');
                        $sheet->setCellValue('B' . $row, 'CODE');
                        $sheet->setCellValue('C' . $row, 'TITRE');
                        $sheet->setCellValue('D' . $row, 'CHAPITRE');
                        $sheet->setCellValue('E' . $row, 'LIBELLE');
                        $sheet->setCellValue('K' . $row, 'DATE EFFET');
                        $ligne = 1;
                        foreach ($sections as $section) {
                            $row++;
                            $sheet->getStyle('A' . $row . ':L' . $row)->applyFromArray($style_tableau);
                            $sheet->mergeCells('E' . $row . ':J' . $row);
                            $sheet->mergeCells('K' . $row . ':L' . $row);
                            $sheet->setCellValue('A' . $row, $ligne);
                            $sheet->setCellValue('B' . $row, $section['code']);
                            $sheet->setCellValue('C' . $row, $section['code_titre']);
                            $sheet->setCellValue('D' . $row, $section['code_chapitre']);
                            $sheet->setCellValue('E' . $row, $section['libelle']);
                            $spreadsheet->getActiveSheet()->getStyle('K' . $row)
                                ->getNumberFormat()
                                ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                            $sheet->setCellValue('K' . $row, date('d/m/Y', strtotime($section['date_debut'])));
                            $ligne++;
                        }


                        $writer = new Xlsx($spreadsheet);
                        $writer->save("php://output");
                    }
                }
                elseif ($data == 'act_art') {
                    $file_name = "EXPORT_ACTES_MEDICAUX_ARTICLE" . date('dmYhis', time()) . ".xls";
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment; filename="' . $file_name . '"');

                    require "../_CONFIGS/Classes/ACTESMEDICAUX.php";
                    $ACTESMEDICAUX = new ACTESMEDICAUX();
                    $articles = $ACTESMEDICAUX->lister_articles(null);
                    $nb_articles = count($articles);
                    if ($nb_articles != 0) {
                        $row = 1;
                        $sheet->getStyle('D' . $row . ':Q' . $row)->applyFromArray($style_titre);
                        $sheet->setCellValue('D' . $row, 'REFERENTIEL: ARTICLES');
                        $sheet->mergeCells('D' . $row . ':Q' . ($row = $row + 2));
                        $sheet->getStyle('D1' . ':Q' . $row)
                            ->getBorders()
                            ->getAllBorders()
                            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

                        $row++;
                        $sheet->getStyle('A' . $row . ':Q' . $row)->applyFromArray($style_entete);
                        $sheet->mergeCells('F' . $row . ':O' . $row);
                        $sheet->mergeCells('p' . $row . ':Q' . $row);
                        $sheet->setCellValue('A' . $row, 'N°');
                        $sheet->setCellValue('B' . $row, 'CODE');
                        $sheet->setCellValue('C' . $row, 'TITRE');
                        $sheet->setCellValue('D' . $row, 'CHAPITRE');
                        $sheet->setCellValue('E' . $row, 'SECTION');
                        $sheet->setCellValue('F' . $row, 'LIBELLE');
                        $sheet->setCellValue('P' . $row, 'DATE EFFET');
                        $ligne = 1;
                        foreach ($articles as $article) {
                            $row++;
                            $sheet->getStyle('A' . $row . ':Q' . $row)->applyFromArray($style_tableau);
                            $sheet->mergeCells('F' . $row . ':O' . $row);
                            $sheet->mergeCells('p' . $row . ':Q' . $row);
                            $sheet->setCellValue('A' . $row, $ligne);
                            $sheet->setCellValue('B' . $row, $article['code']);
                            $sheet->setCellValue('C' . $row, $article['code_titre']);
                            $sheet->setCellValue('D' . $row, $article['code_chapitre']);
                            $sheet->setCellValue('E' . $row, $article['code_section']);
                            $sheet->setCellValue('F' . $row, $article['libelle']);
                            $spreadsheet->getActiveSheet()->getStyle('Q' . $row)
                                ->getNumberFormat()
                                ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                            $sheet->setCellValue('P' . $row, date('d/m/Y', strtotime($article['date_debut'])));
                            $ligne++;
                        }

                        $writer = new Xlsx($spreadsheet);
                        $writer->save("php://output");
                    }
                }
                elseif ($data == 'act_med') {
                    $file_name = "EXPORT_ACTES_MEDICAUX_" . date('dmYhis', time()) . ".xls";
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment; filename="' . $file_name . '"');

                    require "../_CONFIGS/Classes/ACTESMEDICAUX.php";
                    $ACTESMEDICAUX = new ACTESMEDICAUX();
                    $actesmedicaux = $ACTESMEDICAUX->lister_actes_medicaux(null);
                    $nb_regions = count($actesmedicaux);
                    if ($nb_regions != 0) {
                        $row = 1;
                        $sheet->getStyle('D' . $row . ':S' . $row)->applyFromArray($style_titre);
                        $sheet->setCellValue('D' . $row, 'REFERENTIEL: ACTES MEDICAUX');
                        $sheet->mergeCells('D' . $row . ':S' . ($row = $row + 2));
                        $sheet->getStyle('D1' . ':S' . $row)
                            ->getBorders()
                            ->getAllBorders()
                            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

                        $row++;
                        $sheet->getStyle('A' . $row . ':S' . $row)->applyFromArray($style_entete);
                        $sheet->mergeCells('G' . $row . ':Q' . $row);
                        $sheet->mergeCells('R' . $row . ':S' . $row);
                        $sheet->setCellValue('A' . $row, 'N°');
                        $sheet->setCellValue('B' . $row, 'CODE');
                        $sheet->setCellValue('C' . $row, 'TITRE');
                        $sheet->setCellValue('D' . $row, 'CHAPITRE');
                        $sheet->setCellValue('E' . $row, 'SECTION');
                        $sheet->setCellValue('F' . $row, 'ARTICLES');
                        $sheet->setCellValue('G' . $row, 'LIBELLE');
                        $sheet->setCellValue('R' . $row, 'DATE EFFET');
                        $ligne = 1;
                        foreach ($actesmedicaux as $actemedical) {
                            $row++;
                            $sheet->getStyle('A' . $row . ':S' . $row)->applyFromArray($style_tableau);
                            $sheet->mergeCells('G' . $row . ':Q' . $row);
                            $sheet->mergeCells('R' . $row . ':S' . $row);
                            $sheet->setCellValue('A' . $row, $ligne);
                            $sheet->setCellValue('B' . $row, $actemedical['code']);
                            $sheet->setCellValue('C' . $row, $actemedical['code_titre']);
                            $sheet->setCellValue('D' . $row, $actemedical['code_chapitre']);
                            $sheet->setCellValue('E' . $row, $actemedical['code_section']);
                            $sheet->setCellValue('F' . $row, $actemedical['code_article']);
                            $sheet->setCellValue('G' . $row, $actemedical['libelle']);
                            $spreadsheet->getActiveSheet()->getStyle('R' . $row)
                                ->getNumberFormat()
                                ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                            $sheet->setCellValue('R' . $row, date('d/m/Y', strtotime($actemedical['date_debut'])));
                            $ligne++;
                        }

                        $writer = new Xlsx($spreadsheet);
                        $writer->save("php://output");
                    }
                }

                //MEDICAMENTS
                elseif ($data == 'med_lab') {
                    $file_name = "EXPORT_MEDICAMENTS_LABORATOIRES_PHARMACEUTIQUES_" . date('dmYhis', time()) . ".xls";
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment; filename="' . $file_name . '"');

                    require "../_CONFIGS/Classes/MEDICAMENTS.php";
                    $MEDICAMENTS = new MEDICAMENTS();
                    $laboratoires = $MEDICAMENTS->lister_laboratoires_pharmaceutiques();
                    $nb_laboratoires = count($laboratoires);
                    if ($nb_laboratoires != 0) {

                        $row = 1;
                        $sheet->getStyle('D' . $row . ':T' . $row)->applyFromArray($style_titre);
                        $sheet->setCellValue('D' . $row, 'REFERENTIEL : MEDICAMENTS  LABORATOIRES PHARMACEUTIQUES ');
                        $sheet->mergeCells('D' . $row . ':T' . ($row = $row + 2));
                        $sheet->getStyle('D1' . ':T' . $row)
                            ->getBorders()
                            ->getAllBorders()
                            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

                        $row++;
                        $sheet->getStyle('A' . $row . ':T' . $row)->applyFromArray($style_entete);
                        $sheet->mergeCells('C' . $row . ':R' . $row);
                        $sheet->mergeCells('S' . $row . ':T' . $row);
                        $sheet->setCellValue('A' . $row, 'N°');
                        $sheet->setCellValue('B' . $row, 'CODE');
                        $sheet->setCellValue('C' . $row, 'LIBELLE');
                        $sheet->setCellValue('S' . $row, 'DATE EFFET');
                        $ligne = 1;
                        foreach ($laboratoires as $laboratoire) {
                            $row++;
                            $sheet->getStyle('A' . $row . ':T' . $row)->applyFromArray($style_tableau);
                            $sheet->mergeCells('C' . $row . ':R' . $row);
                            $sheet->mergeCells('S' . $row . ':T' . $row);
                            $sheet->setCellValue('A' . $row, $ligne);
                            $sheet->setCellValue('B' . $row, $laboratoire['code']);
                            $sheet->setCellValue('C' . $row, $laboratoire['libelle']);
                            $spreadsheet->getActiveSheet()->getStyle('S' . $row)
                                ->getNumberFormat()
                                ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                            $sheet->setCellValue('S' . $row, date('d/m/Y', strtotime($laboratoire['date_debut'])));
                            $ligne++;
                        }

                        $writer = new Xlsx($spreadsheet);
                        $writer->save("php://output");
                    }
                }
                elseif ($data == 'med_pre') {
                    $file_name = "EXPORT_MEDICAMENTS_PRESENTATIONS_" . date('dmYhis', time()) . ".xls";
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment; filename="' . $file_name . '"');

                    require "../_CONFIGS/Classes/MEDICAMENTS.php";
                    $MEDICAMENTS = new MEDICAMENTS();
                    $presentations = $MEDICAMENTS->lister_presentations();
                    $nb_presentations = count($presentations);
                    if ($nb_presentations != 0) {

                        $row = 1;
                        $sheet->getStyle('D' . $row . ':T' . $row)->applyFromArray($style_titre);
                        $sheet->setCellValue('D' . $row, 'REFERENTIEL : MEDICAMENTS PRESENTATIONS');
                        $sheet->mergeCells('D' . $row . ':T' . ($row = $row + 2));
                        $sheet->getStyle('D1' . ':T' . $row)
                            ->getBorders()
                            ->getAllBorders()
                            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

                        $row++;
                        $sheet->getStyle('A' . $row . ':T' . $row)->applyFromArray($style_entete);
                        $sheet->mergeCells('C' . $row . ':R' . $row);
                        $sheet->mergeCells('S' . $row . ':T' . $row);
                        $sheet->setCellValue('A' . $row, 'N°');
                        $sheet->setCellValue('B' . $row, 'CODE');
                        $sheet->setCellValue('C' . $row, 'LIBELLE');
                        $sheet->setCellValue('S' . $row, 'DATE EFFET');
                        $ligne = 1;
                        foreach ($presentations as $presentation) {
                            $row++;
                            $sheet->getStyle('A' . $row . ':T' . $row)->applyFromArray($style_tableau);
                            $sheet->mergeCells('C' . $row . ':R' . $row);
                            $sheet->mergeCells('S' . $row . ':T' . $row);
                            $sheet->setCellValue('A' . $row, $ligne);
                            $sheet->setCellValue('B' . $row, $presentation['code']);
                            $sheet->setCellValue('C' . $row, $presentation['libelle']);
                            $spreadsheet->getActiveSheet()->getStyle('S' . $row)
                                ->getNumberFormat()
                                ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                            $sheet->setCellValue('S' . $row, date('d/m/Y', strtotime($presentation['date_debut'])));
                            $ligne++;
                        }

                        $writer = new Xlsx($spreadsheet);
                        $writer->save("php://output");
                    }
                }
                elseif ($data == 'med_ffm') {
                    $file_name = "EXPORT_MEDICAMENTS_FAMILLES_DE_FORMES_" . date('dmYhis', time()) . ".xls";
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment; filename="' . $file_name . '"');

                    require "../_CONFIGS/Classes/MEDICAMENTS.php";
                    $MEDICAMENTS = new MEDICAMENTS();
                    $famillesformes = $MEDICAMENTS->lister_familles_formes();
                    $nb_famillesformes = count($famillesformes);
                    if ($nb_famillesformes != 0) {

                        $row = 1;
                        $sheet->getStyle('D' . $row . ':T' . $row)->applyFromArray($style_titre);
                        $sheet->setCellValue('D' . $row, 'REFERENTIEL : MEDICAMENTS FAMILLES FORMES');
                        $sheet->mergeCells('D' . $row . ':T' . ($row = $row + 2));
                        $sheet->getStyle('D1' . ':T' . $row)
                            ->getBorders()
                            ->getAllBorders()
                            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

                        $row++;
                        $sheet->getStyle('A' . $row . ':T' . $row)->applyFromArray($style_entete);
                        $sheet->mergeCells('C' . $row . ':R' . $row);
                        $sheet->mergeCells('S' . $row . ':T' . $row);
                        $sheet->setCellValue('A' . $row, 'N°');
                        $sheet->setCellValue('B' . $row, 'CODE');
                        $sheet->setCellValue('C' . $row, 'LIBELLE');
                        $sheet->setCellValue('S' . $row, 'DATE EFFET');
                        $ligne = 1;
                        foreach ($famillesformes as $familleforme) {
                            $row++;
                            $sheet->getStyle('A' . $row . ':T' . $row)->applyFromArray($style_tableau);
                            $sheet->mergeCells('C' . $row . ':R' . $row);
                            $sheet->mergeCells('S' . $row . ':T' . $row);
                            $sheet->setCellValue('A' . $row, $ligne);
                            $sheet->setCellValue('B' . $row, $familleforme['code']);
                            $sheet->setCellValue('C' . $row, $familleforme['libelle']);
                            $spreadsheet->getActiveSheet()->getStyle('S' . $row)
                                ->getNumberFormat()
                                ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                            $sheet->setCellValue('S' . $row, date('d/m/Y', strtotime($familleforme['date_debut'])));
                            $ligne++;
                        }

                        $writer = new Xlsx($spreadsheet);
                        $writer->save("php://output");
                    }
                }
                elseif ($data == 'med_cth') {
                    $file_name = "EXPORT_MEDICAMENTS_CLASSES_THERAPEUTHIQUE_" . date('dmYhis', time()) . ".xls";
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment; filename="' . $file_name . '"');

                    require "../_CONFIGS/Classes/MEDICAMENTS.php";
                    $MEDICAMENTS = new MEDICAMENTS();
                    $classestherapeuthiques = $MEDICAMENTS->lister_classes_therapeutiques();
                    $nb_classestherapeutiques = count($classestherapeuthiques);
                    if ($nb_classestherapeutiques != 0) {

                        $row = 1;
                        $sheet->getStyle('D' . $row . ':T' . $row)->applyFromArray($style_titre);
                        $sheet->setCellValue('D' . $row, 'REFERENTIEL : MEDICAMENTS  CLASSES THERAPEUTHIQUES');
                        $sheet->mergeCells('D' . $row . ':T' . ($row = $row + 2));
                        $sheet->getStyle('D1' . ':T' . $row)
                            ->getBorders()
                            ->getAllBorders()
                            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

                        $row++;
                        $sheet->getStyle('A' . $row . ':T' . $row)->applyFromArray($style_entete);
                        $sheet->mergeCells('C' . $row . ':R' . $row);
                        $sheet->mergeCells('S' . $row . ':T' . $row);
                        $sheet->setCellValue('A' . $row, 'N°');
                        $sheet->setCellValue('B' . $row, 'CODE');
                        $sheet->setCellValue('C' . $row, 'LIBELLE');
                        $sheet->setCellValue('S' . $row, 'DATE EFFET');
                        $ligne = 1;
                        foreach ($classestherapeuthiques as $classetherapeuthique) {
                            $row++;
                            $sheet->getStyle('A' . $row . ':T' . $row)->applyFromArray($style_tableau);
                            $sheet->mergeCells('C' . $row . ':R' . $row);
                            $sheet->mergeCells('S' . $row . ':T' . $row);
                            $sheet->setCellValue('A' . $row, $ligne);
                            $sheet->setCellValue('B' . $row, $classetherapeuthique['code']);
                            $sheet->setCellValue('C' . $row, $classetherapeuthique['libelle']);
                            $spreadsheet->getActiveSheet()->getStyle('S' . $row)
                                ->getNumberFormat()
                                ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                            $sheet->setCellValue('S' . $row, date('d/m/Y', strtotime($classetherapeuthique['date_debut'])));
                            $ligne++;
                        }

                        $writer = new Xlsx($spreadsheet);
                        $writer->save("php://output");
                    }
                }
                elseif ($data == 'med_frm') {
                    $file_name = "EXPORT_MEDICAMENTS_FORMES_" . date('dmYhis', time()) . ".xls";
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment; filename="' . $file_name . '"');

                    require "../_CONFIGS/Classes/MEDICAMENTS.php";
                    $MEDICAMENTS = new MEDICAMENTS();
                    $formes = $MEDICAMENTS->lister_formes();
                    $nb_formes = count($formes);
                    if ($nb_formes != 0) {

                        $row = 1;
                        $sheet->getStyle('D' . $row . ':T' . $row)->applyFromArray($style_titre);
                        $sheet->setCellValue('D' . $row, 'REFERENTIEL : MEDICAMENTS  FORMES');
                        $sheet->mergeCells('D' . $row . ':T' . ($row = $row + 2));
                        $sheet->getStyle('D1' . ':T' . $row)
                            ->getBorders()
                            ->getAllBorders()
                            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

                        $row++;
                        $sheet->getStyle('A' . $row . ':T' . $row)->applyFromArray($style_entete);
                        $sheet->mergeCells('C' . $row . ':R' . $row);
                        $sheet->mergeCells('S' . $row . ':T' . $row);
                        $sheet->setCellValue('A' . $row, 'N°');
                        $sheet->setCellValue('B' . $row, 'CODE');
                        $sheet->setCellValue('C' . $row, 'LIBELLE');
                        $sheet->setCellValue('S' . $row, 'DATE EFFET');
                        $ligne = 1;
                        foreach ($formes as $forme) {
                            $row++;
                            $sheet->getStyle('A' . $row . ':T' . $row)->applyFromArray($style_tableau);
                            $sheet->mergeCells('C' . $row . ':R' . $row);
                            $sheet->mergeCells('S' . $row . ':T' . $row);
                            $sheet->setCellValue('A' . $row, $ligne);
                            $sheet->setCellValue('B' . $row, $forme['code']);
                            $sheet->setCellValue('C' . $row, $forme['libelle']);
                            $spreadsheet->getActiveSheet()->getStyle('S' . $row)
                                ->getNumberFormat()
                                ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                            $sheet->setCellValue('S' . $row, date('d/m/Y', strtotime($forme['date_debut'])));
                            $ligne++;
                        }

                        $writer = new Xlsx($spreadsheet);
                        $writer->save("php://output");
                    }
                }
                elseif ($data == 'med_typ') {
                    $file_name = "EXPORT_MEDICAMENTS_TYPES_DE_MEDICAMENTS_" . date('dmYhis', time()) . ".xls";
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment; filename="' . $file_name . '"');

                    require "../_CONFIGS/Classes/MEDICAMENTS.php";
                    $MEDICAMENTS = new MEDICAMENTS();
                    $typesmedicaments = $MEDICAMENTS->lister_types_medicaments();
                    $nb_typesmedicaments = count($typesmedicaments);
                    if ($nb_typesmedicaments != 0) {

                        $row = 1;
                        $sheet->getStyle('D' . $row . ':T' . $row)->applyFromArray($style_titre);
                        $sheet->setCellValue('D' . $row, 'REFERENTIEL : MEDICAMENTS  TYPES DE MEDICAMENTS');
                        $sheet->mergeCells('D' . $row . ':T' . ($row = $row + 2));
                        $sheet->getStyle('D1' . ':T' . $row)
                            ->getBorders()
                            ->getAllBorders()
                            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

                        $row++;
                        $sheet->getStyle('A' . $row . ':T' . $row)->applyFromArray($style_entete);
                        $sheet->mergeCells('C' . $row . ':R' . $row);
                        $sheet->mergeCells('S' . $row . ':T' . $row);
                        $sheet->setCellValue('A' . $row, 'N°');
                        $sheet->setCellValue('B' . $row, 'CODE');
                        $sheet->setCellValue('C' . $row, 'LIBELLE');
                        $sheet->setCellValue('S' . $row, 'DATE EFFET');
                        $ligne = 1;
                        foreach ($typesmedicaments as $typemedicament) {
                            $row++;
                            $sheet->getStyle('A' . $row . ':T' . $row)->applyFromArray($style_tableau);
                            $sheet->mergeCells('C' . $row . ':R' . $row);
                            $sheet->mergeCells('S' . $row . ':T' . $row);
                            $sheet->setCellValue('A' . $row, $ligne);
                            $sheet->setCellValue('B' . $row, $typemedicament['code']);
                            $sheet->setCellValue('C' . $row, $typemedicament['libelle']);
                            $spreadsheet->getActiveSheet()->getStyle('S' . $row)
                                ->getNumberFormat()
                                ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                            $sheet->setCellValue('S' . $row, date('d/m/Y', strtotime($typemedicament['date_debut'])));
                            $ligne++;
                        }

                        $writer = new Xlsx($spreadsheet);
                        $writer->save("php://output");
                    }
                }
                elseif ($data == 'med_fra') {
                    $file_name = "EXPORT_MEDICAMENTS_FORMES_ADMINISTRATION_" . date('dmYhis', time()) . ".xls";
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment; filename="' . $file_name . '"');

                    require "../_CONFIGS/Classes/MEDICAMENTS.php";
                    $MEDICAMENTS = new MEDICAMENTS();
                    $formesadministrations = $MEDICAMENTS->lister_formes_administrations();
                    $nb_formesadministrations = count($formesadministrations);
                    if ($nb_formesadministrations != 0) {

                        $row = 1;
                        $sheet->getStyle('D' . $row . ':T' . $row)->applyFromArray($style_titre);
                        $sheet->setCellValue('D' . $row, 'REFERENTIEL : MEDICAMENTS  FORMES ADMINISTRATIONS ');
                        $sheet->mergeCells('D' . $row . ':T' . ($row = $row + 2));
                        $sheet->getStyle('D1' . ':T' . $row)
                            ->getBorders()
                            ->getAllBorders()
                            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

                        $row++;
                        $sheet->getStyle('A' . $row . ':T' . $row)->applyFromArray($style_entete);
                        $sheet->mergeCells('C' . $row . ':R' . $row);
                        $sheet->mergeCells('S' . $row . ':T' . $row);
                        $sheet->setCellValue('A' . $row, 'N°');
                        $sheet->setCellValue('B' . $row, 'CODE');
                        $sheet->setCellValue('C' . $row, 'LIBELLE');
                        $sheet->setCellValue('S' . $row, 'DATE EFFET');
                        $ligne = 1;
                        foreach ($formesadministrations as $formeadministration) {
                            $row++;
                            $sheet->getStyle('A' . $row . ':T' . $row)->applyFromArray($style_tableau);
                            $sheet->mergeCells('C' . $row . ':R' . $row);
                            $sheet->mergeCells('S' . $row . ':T' . $row);
                            $sheet->setCellValue('A' . $row, $ligne);
                            $sheet->setCellValue('B' . $row, $formeadministration['code']);
                            $sheet->setCellValue('C' . $row, $formeadministration['libelle']);
                            $spreadsheet->getActiveSheet()->getStyle('S' . $row)
                                ->getNumberFormat()
                                ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                            $sheet->setCellValue('S' . $row, date('d/m/Y', strtotime($formeadministration['date_debut'])));
                            $ligne++;
                        }

                        $writer = new Xlsx($spreadsheet);
                        $writer->save("php://output");
                    }
                }
                elseif ($data == 'med_unt') {
                    $file_name = "EXPORT_MEDICAMENTS_UNITES_DE_DOSAGES_" . date('dmYhis', time()) . ".xls";
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment; filename="' . $file_name . '"');

                    require "../_CONFIGS/Classes/MEDICAMENTS.php";
                    $MEDICAMENTS = new MEDICAMENTS();
                    $unitesdosages = $MEDICAMENTS->lister_unites_dosages();
                    $nb_unitesdosages = count($unitesdosages);
                    if ($nb_unitesdosages != 0) {

                        $row = 1;
                        $sheet->getStyle('D' . $row . ':T' . $row)->applyFromArray($style_titre);
                        $sheet->setCellValue('D' . $row, 'REFERENTIEL : MEDICAMENTS  UNITES DE DOSAGES ');
                        $sheet->mergeCells('D' . $row . ':T' . ($row = $row + 2));
                        $sheet->getStyle('D1' . ':T' . $row)
                            ->getBorders()
                            ->getAllBorders()
                            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

                        $row++;
                        $sheet->getStyle('A' . $row . ':T' . $row)->applyFromArray($style_entete);
                        $sheet->mergeCells('C' . $row . ':R' . $row);
                        $sheet->mergeCells('S' . $row . ':T' . $row);
                        $sheet->setCellValue('A' . $row, 'N°');
                        $sheet->setCellValue('B' . $row, 'CODE');
                        $sheet->setCellValue('C' . $row, 'LIBELLE');
                        $sheet->setCellValue('S' . $row, 'DATE EFFET');
                        $ligne = 1;
                        foreach ($unitesdosages as $unitedosage) {
                            $row++;
                            $sheet->getStyle('A' . $row . ':T' . $row)->applyFromArray($style_tableau);
                            $sheet->mergeCells('C' . $row . ':R' . $row);
                            $sheet->mergeCells('S' . $row . ':T' . $row);
                            $sheet->setCellValue('A' . $row, $ligne);
                            $sheet->setCellValue('B' . $row, $unitedosage['code']);
                            $sheet->setCellValue('C' . $row, $unitedosage['libelle']);
                            $spreadsheet->getActiveSheet()->getStyle('S' . $row)
                                ->getNumberFormat()
                                ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                            $sheet->setCellValue('S' . $row, date('d/m/Y', strtotime($unitedosage['date_debut'])));
                            $ligne++;
                        }

                        $writer = new Xlsx($spreadsheet);
                        $writer->save("php://output");
                    }
                }
                elseif ($data == 'med_dci') {
                    $file_name = "EXPORT_MEDICAMENTS_DCI_" . date('dmYhis', time()) . ".xls";
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment; filename="' . $file_name . '"');

                    require "../_CONFIGS/Classes/MEDICAMENTS.php";
                    $MEDICAMENTS = new MEDICAMENTS();
                    $denominations_communes_internationales = $MEDICAMENTS->lister_dci(null);
                    $nb_dci = count($denominations_communes_internationales);
                    if ($nb_dci != 0) {

                        $row = 1;
                        $sheet->getStyle('D' . $row . ':T' . $row)->applyFromArray($style_titre);
                        $sheet->setCellValue('D' . $row, 'REFERENTIEL : MEDICAMENTS DCI ');
                        $sheet->mergeCells('D' . $row . ':T' . ($row = $row + 2));
                        $sheet->getStyle('D1' . ':T' . $row)
                            ->getBorders()
                            ->getAllBorders()
                            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

                        $row++;
                        $sheet->getStyle('A' . $row . ':T' . $row)->applyFromArray($style_entete);
                        $sheet->mergeCells('C' . $row . ':G' . $row);
                        $sheet->mergeCells('H' . $row . ':L' . $row);
                        $sheet->mergeCells('M' . $row . ':R' . $row);
                        $sheet->mergeCells('S' . $row . ':T' . $row);
                        $sheet->setCellValue('A' . $row, 'N°');
                        $sheet->setCellValue('B' . $row, 'CODE');
                        $sheet->setCellValue('C' . $row, 'FORME');
                        $sheet->setCellValue('H' . $row, 'UNITE DOSAGE');
                        $sheet->setCellValue('M' . $row, 'LIBELLE');
                        $sheet->setCellValue('S' . $row, 'DATE EFFET');
                        $ligne = 1;
                        foreach ($denominations_communes_internationales as $denomination_commune_internationale) {
                            $row++;
                            $sheet->getStyle('A' . $row . ':T' . $row)->applyFromArray($style_tableau);
                            $sheet->mergeCells('C' . $row . ':G' . $row);
                            $sheet->mergeCells('H' . $row . ':L' . $row);
                            $sheet->mergeCells('M' . $row . ':R' . $row);
                            $sheet->mergeCells('S' . $row . ':T' . $row);
                            $sheet->setCellValue('A' . $row, $ligne);
                            $sheet->setCellValue('B' . $row, $denomination_commune_internationale['code']);
                            $sheet->setCellValue('C' . $row, $denomination_commune_internationale['code_forme']);
                            $sheet->setCellValue('H' . $row, $denomination_commune_internationale['dosage'] . $denomination_commune_internationale['code_unite']);
                            $sheet->setCellValue('M' . $row, $denomination_commune_internationale['libelle']);
                            $spreadsheet->getActiveSheet()->getStyle('S' . $row)
                                ->getNumberFormat()
                                ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                            $sheet->setCellValue('S' . $row, date('d/m/Y', strtotime($denomination_commune_internationale['date_debut'])));
                            $ligne++;
                        }

                        $writer = new Xlsx($spreadsheet);
                        $writer->save("php://output");
                    }
                }
                elseif ($data == 'med') {
                    $file_name = "EXPORT_MEDICAMENTS_" . date('dmYhis', time()) . ".xls";
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment; filename="' . $file_name . '"');

                    require "../_CONFIGS/Classes/MEDICAMENTS.php";
                    $MEDICAMENTS = new MEDICAMENTS();
                    $medicaments = $MEDICAMENTS->lister_medicaments();
                    $nb_medicaments = count($medicaments);
                    if ($nb_medicaments != 0) {
                        $row = 1;
                        $sheet->getStyle('D' . $row . ':Q' . $row)->applyFromArray($style_titre);
                        $sheet->setCellValue('D' . $row, 'REFERENTIEL: MEDICAMENTS');
                        $sheet->mergeCells('D' . $row . ':Q' . ($row = $row + 2));
                        $sheet->getStyle('D1' . ':Q' . $row)
                            ->getBorders()
                            ->getAllBorders()
                            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

                        $row++;
                        $sheet->getStyle('A' . $row . ':Q' . $row)->applyFromArray($style_entete);
                        $sheet->mergeCells('C' . $row . ':E' . $row);
                        $sheet->mergeCells('F' . $row . ':G' . $row);
                        $sheet->mergeCells('H' . $row . ':J' . $row);
                        $sheet->mergeCells('K' . $row . ':M' . $row);
                        $sheet->mergeCells('N' . $row . ':O' . $row);
                        $sheet->mergeCells('p' . $row . ':Q' . $row);
                        $sheet->setCellValue('A' . $row, 'N°');
                        $sheet->setCellValue('B' . $row, 'CODE');
                        $sheet->setCellValue('C' . $row, 'LIBELLE');
                        $sheet->setCellValue('F' . $row, 'FORME');
                        $sheet->setCellValue('H' . $row, 'DCI');
                        $sheet->setCellValue('K' . $row, 'EAN13');
                        $sheet->setCellValue('N' . $row, 'DOSAGE');
                        $sheet->setCellValue('P' . $row, 'DATE EFFET');
                        $ligne = 1;
                        foreach ($medicaments as $medicament) {
                            $row++;
                            $sheet->getStyle('A' . $row . ':Q' . $row)->applyFromArray($style_tableau);
                            $sheet->mergeCells('C' . $row . ':E' . $row);
                            $sheet->mergeCells('F' . $row . ':G' . $row);
                            $sheet->mergeCells('H' . $row . ':J' . $row);
                            $sheet->mergeCells('K' . $row . ':M' . $row);
                            $sheet->mergeCells('N' . $row . ':O' . $row);
                            $sheet->mergeCells('P' . $row . ':Q' . $row);
                            $sheet->setCellValue('A' . $row, $ligne);
                            $sheet->setCellValue('B' . $row, $medicament['code']);
                            $sheet->setCellValue('C' . $row, $medicament['libelle']);
                            $sheet->setCellValue('F' . $row, $medicament['code_forme']);
                            $sheet->setCellValue('H' . $row, $medicament['code_dci']);
                            $sheet->setCellValue('K' . $row, $medicament['code_ean13']);
                            $sheet->setCellValue('N' . $row, $medicament['dosage'] . $medicament['code_unite_dosage']);
                            $spreadsheet->getActiveSheet()->getStyle('Q' . $row)
                                ->getNumberFormat()
                                ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                            $sheet->setCellValue('P' . $row, date('d/m/Y', strtotime($medicament['date_debut'])));
                            $ligne++;
                        }

                        $writer = new Xlsx($spreadsheet);
                        $writer->save("php://output");
                    }
                }

                //ETABLISSEMENTS
                elseif ($data == 'etab_niveau') {
                    $file_name = "EXPORT_ETABLISSEMENTS_NIVEAUX_SANITAIRES_" . date('dmYhis', time()) . ".xls";
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment; filename="' . $file_name . '"');

                    require "../_CONFIGS/Classes/ETABLISSEMENTS.php";
                    $ETABLISSEMENTS = new ACTESMEDICAUX();
                    $niveaux = $ETABLISSEMENTS->lister_lettres_cles();
                    $nb_niveaux = count($niveaux);
                    if ($nb_niveaux != 0) {

                        $row = 1;
                        $sheet->getStyle('D' . $row . ':O' . $row)->applyFromArray($style_titre);
                        $sheet->setCellValue('D' . $row, 'ETABLISSEMENTS : NIVEAUX SANITAIRES');
                        $sheet->mergeCells('D' . $row . ':O' . ($row = $row + 2));
                        $sheet->getStyle('D1' . ':O' . $row)
                            ->getBorders()
                            ->getAllBorders()
                            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

                        $row++;
                        $sheet->getStyle('A' . $row . ':O' . $row)->applyFromArray($style_entete);
                        $sheet->mergeCells('C' . $row . ':J' . $row);
                        $sheet->mergeCells('K' . $row . ':M' . $row);
                        $sheet->mergeCells('N' . $row . ':O' . $row);
                        $sheet->setCellValue('A' . $row, 'N°');
                        $sheet->setCellValue('B' . $row, 'CODE');
                        $sheet->setCellValue('C' . $row, 'LIBELLE');
                        $sheet->setCellValue('k' . $row, 'NIVEAU');
                        $sheet->setCellValue('N' . $row, 'DATE EFFET');
                        $ligne = 1;
                        foreach ($niveaux as $niveau) {
                            $row++;
                            $sheet->getStyle('A' . $row . ':O' . $row)->applyFromArray($style_tableau);
                            $sheet->mergeCells('C' . $row . ':J' . $row);
                            $sheet->mergeCells('K' . $row . ':M' . $row);
                            $sheet->mergeCells('N' . $row . ':O' . $row);
                            $sheet->setCellValue('A' . $row, $ligne);
                            $sheet->setCellValue('B' . $row, $niveau['code']);
                            $sheet->setCellValue('C' . $row, $niveau['libelle']);
                            $sheet->setCellValue('K' . $row, $niveau['niveau']);
                            $spreadsheet->getActiveSheet()->getStyle('N' . $row)
                                ->getNumberFormat()
                                ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                            $sheet->setCellValue('N' . $row, date('d/m/Y', strtotime($niveau['date_debut'])));
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
                $pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));

                // Set some content to print
                $pdf->Image(IMAGES . 'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io/', 'L', true, 150, '', false, false, 0, false, false, false);


                //PATHOLOGIES
                if ($data == 'pat_chap') {
                    $file_name = "EXPORT_PATHOLOGIES_CHAPITRES_" . date('dmYhis', time()) . ".pdf";
                    $pdf->SetTitle($file_name);

                    require "../_CONFIGS/Classes/PATHOLOGIES.php";
                    $PATHOLOGIES = new PATHOLOGIES();
                    $chapitres = $PATHOLOGIES->lister_chapitres();
                    $nb_chapitres = count($chapitres);
                    if ($nb_chapitres != 0) {
                        $pdf->AddPage('L');
                        $pdf->Image(IMAGES . 'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io/', 'L', true, 150, '', false, false, 0, false, false, false);

                        $pdf->writeHTMLCell(0, 0, 50, 15, '<h1>REFERENTIEL :<br />PATHOLOGIES CHAPITRES</h1>', 0, 1, 0, true, 'C', true);
                        $pdf->setCellPaddings(1, 1, 1, 1);
                        $pdf->MultiCell(10, 15, NULL, 0, 'L', 1, 1, '', '', true);


                        $pdf->SetFillColor(128, 128, 128);
                        $pdf->SetFont('helvetica', 'B', 8, '', true);
                        $pdf->MultiCell(10, 5, 'N°', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(20, 5, 'CODE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(230, 5, 'LIBELLE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(20, 5, 'DATE EFFET', 1, 'L', 1, 1, '', '', true);
                        $pdf->SetFont('helvetica', '', 8, '', true);
                        $pdf->SetFillColor(255, 255, 255);
                        $ligne = 1;
                        foreach ($chapitres as $chapitre) {
                            $pdf->SetFont('helvetica', 'B', 8, '', true);
                            $pdf->MultiCell(10, 5, $ligne, 1, 'R', 1, 0, '', '', true);
                            $pdf->MultiCell(20, 5, $chapitre['code'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(230, 5, $chapitre['libelle'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(20, 5, date('d/m/Y', strtotime($chapitre['date_debut'])), 1, 'C', 1, 1, '', '', true);
                            $ligne++;
                        }

                    }
                    $pdf->Output($file_name, 'I');
                }
                elseif ($data == 'pat_sch') {
                    $file_name = "EXPORT_PATHOLOGIES_SOUS_CHAPITRES_" . date('dmYhis', time()) . ".pdf";
                    $pdf->SetTitle($file_name);

                    require "../_CONFIGS/Classes/PATHOLOGIES.php";
                    $PATHOLOGIES = new PATHOLOGIES();
                    $sous_chapitres = $PATHOLOGIES->lister_sous_chapitres(null);
                    $nb_sous_chapitres = count($sous_chapitres);
                    if ($nb_sous_chapitres != 0) {
                        $pdf->AddPage('L');
                        $pdf->Image(IMAGES . 'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);

                        $pdf->writeHTMLCell(0, 0, 50, 15, '<h1>REFERENTIEL :<br /> PATHOLOGIES SOUS-CHAPITRES</h1>', 0, 1, 0, true, 'C', true);
                        $pdf->setCellPaddings(1, 1, 1, 1);
                        $pdf->MultiCell(10, 15, NULL, 0, 'L', 1, 1, '', '', true);


                        $pdf->SetFillColor(128, 128, 128);
                        $pdf->SetFont('helvetica', 'B', 8, '', true);
                        $pdf->MultiCell(10, 5, 'N°', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(20, 5, 'CODE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(20, 5, 'CHAPITRE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(210, 5, 'LIBELLE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(20, 5, 'DATE EFFET', 1, 'L', 1, 1, '', '', true);
                        $pdf->SetFont('helvetica', '', 8, '', true);
                        $pdf->SetFillColor(255, 255, 255);
                        $ligne = 1;
                        foreach ($sous_chapitres as $sous_chapitre) {
                            $pdf->SetFont('helvetica', 'B', 8, '', true);
                            $pdf->MultiCell(10, 5, $ligne, 1, 'R', 1, 0, '', '', true);
                            $pdf->MultiCell(20, 5, $sous_chapitre['code'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(20, 5, $sous_chapitre['code_chapitre'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(210, 5, $sous_chapitre['libelle'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(20, 5, date('d/m/Y', strtotime($sous_chapitre['date_debut'])), 1, 'C', 1, 1, '', '', true);
                            $ligne++;
                        }

                    }
                    $pdf->Output($file_name, 'I');
                }
                elseif ($data == 'pat') {
                    $file_name = "EXPORT_PATHOLOGIES_" . date('dmYhis', time()) . ".pdf";
                    $pdf->SetTitle($file_name);

                    require "../_CONFIGS/Classes/PATHOLOGIES.php";
                    $PATHOLOGIES = new PATHOLOGIES();
                    $pathologies = $PATHOLOGIES->lister_pathologies(null,null);
                    $nb_pathologies = count($pathologies);
                    if ($nb_pathologies != 0) {
                        $pdf->AddPage('L');
                        $pdf->Image(IMAGES . 'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);

                        $pdf->writeHTMLCell(0, 0, 50, 15, '<h1>REFERENTIEL :<br />PATHOLOGIES</h1>', 0, 1, 0, true, 'C', true);
                        $pdf->setCellPaddings(1, 1, 1, 1);
                        $pdf->MultiCell(10, 15, NULL, 0, 'L', 1, 1, '', '', true);


                        $pdf->SetFillColor(128, 128, 128);
                        $pdf->SetFont('helvetica', 'B', 8, '', true);
                        $pdf->MultiCell(10, 5, 'N°', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(15, 5, 'CODE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(30, 5, 'CHAPITRE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(30, 5, 'SOUS CHAPITRE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(175, 5, 'LIBELLE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(20, 5, 'DATE EFFET', 1, 'L', 1, 1, '', '', true);
                        $pdf->SetFont('helvetica', '', 8, '', true);
                        $pdf->SetFillColor(255, 255, 255);
                        $ligne = 1;
                        foreach ($pathologies as $pathologie) {
                            $pdf->SetFont('helvetica', 'B', 8, '', true);
                            $pdf->MultiCell(10, 5, $ligne, 1, 'R', 1, 0, '', '', true);
                            $pdf->MultiCell(15, 5, $pathologie['code'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(30, 5, $pathologie['code_chapitre'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(30, 5, $pathologie['code_sous_chapitre'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(175, 5, $pathologie['libelle'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(20, 5, date('d/m/Y', strtotime($pathologie['date_debut'])), 1, 'C', 1, 1, '', '', true);
                            $ligne++;
                        }

                    }
                    $pdf->Output($file_name, 'I');
                }

                //ACTES MEDICAUX
                elseif ($data == 'let_cle') {
                    $file_name = "EXPORT_ACTES_MEDICAUX_LETTRES_CLES_" . date('dmYhis', time()) . ".pdf";
                    $pdf->SetTitle($file_name);

                    require "../_CONFIGS/Classes/ACTESMEDICAUX.php";
                    $ACTESMEDICAUX = new ACTESMEDICAUX();
                    $lettres_cles = $ACTESMEDICAUX->lister_lettres_cles();
                    $nb_lettres_cles = count($lettres_cles);
                    if ($nb_lettres_cles != 0) {
                        $pdf->AddPage('L');
                        $pdf->Image(IMAGES . 'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);

                        $pdf->writeHTMLCell(0, 0, 50, 15, '<h1>REFERENTIEL :<br />LETTRES CLES</h1>', 0, 1, 0, true, 'C', true);
                        $pdf->setCellPaddings(1, 1, 1, 1);
                        $pdf->MultiCell(10, 15, NULL, 0, 'L', 1, 1, '', '', true);


                        $pdf->SetFillColor(128, 128, 128);
                        $pdf->SetFont('helvetica', 'B', 8, '', true);
                        $pdf->MultiCell(10, 5, 'N°', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(15, 5, 'CODE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(185, 5, 'LIBELLE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(50, 5, 'PRIX UNITAIRE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(20, 5, 'DATE EFFET', 1, 'L', 1, 1, '', '', true);
                        $pdf->SetFont('helvetica', '', 8, '', true);
                        $pdf->SetFillColor(255, 255, 255);
                        $ligne = 1;
                        foreach ($lettres_cles as $lettre_cle) {
                            $pdf->SetFont('helvetica', 'B', 8, '', true);
                            $pdf->MultiCell(10, 5, $ligne, 1, 'R', 1, 0, '', '', true);
                            $pdf->MultiCell(15, 5, $lettre_cle['code'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(185, 5, $lettre_cle['libelle'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(50, 5, number_format($lettre_cle['prix_unitaire'], '0', '', ' ') . ' FCFA', 1, 'R', 1, 0, '', '', true);
                            $pdf->MultiCell(20, 5, date('d/m/Y', strtotime($lettre_cle['date_debut'])), 1, 'C', 1, 1, '', '', true);
                            $ligne++;
                        }

                    }
                    $pdf->Output($file_name, 'I');
                }
                elseif ($data == 'act_tit') {
                    $file_name = "EXPORT_ACTES_MEDICAUX_TITRES_" . date('dmYhis', time()) . ".pdf";
                    $pdf->SetTitle($file_name);

                    require "../_CONFIGS/Classes/ACTESMEDICAUX.php";
                    $ACTESMEDICAUX = new ACTESMEDICAUX();
                    $titres = $ACTESMEDICAUX->lister_titres();
                    $nb_titres = count($titres);
                    if ($nb_titres != 0) {
                        $pdf->AddPage('L');
                        $pdf->Image(IMAGES . 'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);

                        $pdf->writeHTMLCell(0, 0, 50, 15, '<h1>REFERENTIEL :<br />TITRES D\'ACTES MEDICAUX</h1>', 0, 1, 0, true, 'C', true);
                        $pdf->setCellPaddings(1, 1, 1, 1);
                        $pdf->MultiCell(10, 15, NULL, 0, 'L', 1, 1, '', '', true);


                        $pdf->SetFillColor(128, 128, 128);
                        $pdf->SetFont('helvetica', 'B', 8, '', true);
                        $pdf->MultiCell(10, 5, 'N°', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(15, 5, 'CODE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(230, 5, 'LIBELLE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(20, 5, 'DATE EFFET', 1, 'L', 1, 1, '', '', true);
                        $pdf->SetFont('helvetica', '', 8, '', true);
                        $pdf->SetFillColor(255, 255, 255);
                        $ligne = 1;
                        foreach ($titres as $titre) {
                            $pdf->SetFont('helvetica', 'B', 8, '', true);
                            $pdf->MultiCell(10, 5, $ligne, 1, 'R', 1, 0, '', '', true);
                            $pdf->MultiCell(15, 5, $titre['code'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(230, 5, $titre['libelle'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(20, 5, date('d/m/Y', strtotime($titre['date_debut'])), 1, 'C', 1, 1, '', '', true);
                            $ligne++;
                        }

                    }
                    $pdf->Output($file_name, 'I');
                }
                elseif ($data == 'act_cha') {
                    $file_name = "EXPORT_ACTES_MEDICAUX_CHAPITRES_" . date('dmYhis', time()) . ".pdf";
                    $pdf->SetTitle($file_name);

                    require "../_CONFIGS/Classes/ACTESMEDICAUX.php";
                    $ACTESMEDICAUX = new ACTESMEDICAUX();
                    $actesmedicaux = $ACTESMEDICAUX->lister_chapitres(null);
                    $nb_pathologies = count($actesmedicaux);
                    if ($nb_pathologies != 0) {
                        $pdf->AddPage('L');
                        $pdf->Image(IMAGES . 'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);

                        $pdf->writeHTMLCell(0, 0, 50, 15, '<h1>REFERENTIEL :<br />  CHAPITRES D\'ACTES MEDICAUX</h1>', 0, 1, 0, true, 'C', true);
                        $pdf->setCellPaddings(1, 1, 1, 1);
                        $pdf->MultiCell(10, 15, NULL, 0, 'L', 1, 1, '', '', true);


                        $pdf->SetFillColor(128, 128, 128);
                        $pdf->SetFont('helvetica', 'B', 8, '', true);
                        $pdf->MultiCell(10, 5, 'N°', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(15, 5, 'CODE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(15, 5, 'TITRE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(220, 5, 'LIBELLE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(20, 5, 'DATE EFFET', 1, 'L', 1, 1, '', '', true);
                        $pdf->SetFont('helvetica', '', 8, '', true);
                        $pdf->SetFillColor(255, 255, 255);
                        $ligne = 1;
                        foreach ($actesmedicaux as $actemedical) {
                            $pdf->SetFont('helvetica', 'B', 8, '', true);
                            $pdf->MultiCell(10, 5, $ligne, 1, 'R', 1, 0, '', '', true);
                            $pdf->MultiCell(15, 5, $actemedical['code'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(15, 5, $actemedical['code_titre'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(220, 5, $actemedical['libelle'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(20, 5, date('d/m/Y', strtotime($actemedical['date_debut'])), 1, 'C', 1, 1, '', '', true);
                            $ligne++;
                        }

                    }
                    $pdf->Output($file_name, 'I');
                }
                elseif ($data == 'act_sec') {
                    $file_name = "EXPORT_ACTES_MEDICAUX_SECTIONS_" . date('dmYhis', time()) . ".csv";
                    $pdf->SetTitle($file_name);

                    require "../_CONFIGS/Classes/ACTESMEDICAUX.php";
                    $ACTESMEDICAUX = new ACTESMEDICAUX();
                    $sections = $ACTESMEDICAUX->lister_sections(null);
                    $nb_sections = count($sections);
                    if ($nb_sections != 0) {
                        $pdf->AddPage('L');
                        $pdf->Image(IMAGES . 'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);

                        $pdf->writeHTMLCell(0, 0, 50, 15, '<h1>REFERENTIEL :<br />SECTIONS D\'ACTES MEDICAUX</h1>', 0, 1, 0, true, 'C', true);
                        $pdf->setCellPaddings(1, 1, 1, 1);
                        $pdf->MultiCell(10, 15, NULL, 0, 'L', 1, 1, '', '', true);


                        $pdf->SetFillColor(128, 128, 128);
                        $pdf->SetFont('helvetica', 'B', 8, '', true);
                        $pdf->MultiCell(10, 5, 'N°', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(15, 5, 'CODE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(15, 5, 'TITRE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(20, 5, 'CHAPITRE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(200, 5, 'LIBELLE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(20, 5, 'DATE EFFET', 1, 'L', 1, 1, '', '', true);
                        $pdf->SetFont('helvetica', '', 8, '', true);
                        $pdf->SetFillColor(255, 255, 255);
                        $ligne = 1;
                        foreach ($sections as $section) {
                            $pdf->SetFont('helvetica', 'B', 8, '', true);
                            $pdf->MultiCell(10, 5, $ligne, 1, 'R', 1, 0, '', '', true);
                            $pdf->MultiCell(15, 5, $section['code'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(15, 5, $section['code_titre'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(20, 5, $section['code_chapitre'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(200, 5, $section['libelle'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(20, 5, date('d/m/Y', strtotime($section['date_debut'])), 1, 'C', 1, 1, '', '', true);
                            $ligne++;
                        }
                    }
                    $pdf->Output($file_name, 'I');
                }
                elseif ($data == 'act_art') {
                    $pdf->AddPage('L');
                    $pdf->Image(IMAGES . 'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);

                    $file_name = "EXPORT_ACTES_MEDICAUX_ARTICLES_" . date('dmYhis', time()) . ".pdf";
                    $pdf->SetTitle($file_name);
                    require "../_CONFIGS/Classes/ACTESMEDICAUX.php";
                    $ACTESMEDICAUX = new ACTESMEDICAUX();
                    $articles = $ACTESMEDICAUX->lister_articles(null);
                    $nb_articles = count($articles);
                    if ($nb_articles != 0) {
                        $pdf->writeHTMLCell(0, 0, 50, 15, '<h1>TABLE DE VALEUR:<br />ARTICLES</h1>', 0, 1, 0, true, 'C', true);
                        $pdf->setCellPaddings(1, 1, 1, 1);
                        $pdf->MultiCell(10, 15, NULL, 0, 'L', 1, 1, '', '', true);

                        $pdf->SetFillColor(128, 128, 128);
                        $pdf->SetFont('helvetica', 'B', 8, '', true);
                        $pdf->MultiCell(10, 5, 'N°', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(15, 5, 'CODE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(15, 5, 'TITRE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(20, 5, 'CHAPITRE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(20, 5, 'SECTIONS', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(170, 5, 'LIBELLE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(30, 5, 'DATE EFFET', 1, 'L', 1, 1, '', '', true);
                        $pdf->SetFont('helvetica', '', 8, '', true);
                        $pdf->SetFillColor(255, 255, 255);
                        $ligne = 1;
                        foreach ($articles as $article) {
                            $pdf->SetFont('helvetica', 'B', 8, '', true);
                            $pdf->MultiCell(10, 5, $ligne, 1, 'R', 1, 0, '', '', true);
                            $pdf->MultiCell(15, 5, $article['code'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(15, 5, $article['code_titre'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(20, 5, $article['code_chapitre'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(20, 5, $article['code_section'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(170, 5, $article['libelle'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(30, 5, date('d/m/Y', strtotime($article['date_debut'])), 1, 'C', 1, 1, '', '', true);
                            $ligne++;
                        }

                    }
                    $pdf->Output($file_name, 'I');
                }
                elseif ($data == 'act_med') {
                    $pdf->AddPage('L');
                    $pdf->Image(IMAGES . 'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);

                    $file_name = "EXPORT_ACTES_MEDICAUX" . date('dmYhis', time()) . ".pdf";
                    $pdf->SetTitle($file_name);
                    require "../_CONFIGS/Classes/ACTESMEDICAUX.php";
                    $ACTESMEDICAUX = new ACTESMEDICAUX();
                    $actes_medicaux = $ACTESMEDICAUX->lister_actes_medicaux(null);
                    $nb_actes_medicaux = count($actes_medicaux);
                    if ($nb_actes_medicaux != 0) {
                        $pdf->writeHTMLCell(0, 0, 50, 15, '<h1>TABLE DE VALEUR:<br />ACTES MEDICAUX</h1>', 0, 1, 0, true, 'C', true);
                        $pdf->setCellPaddings(1, 1, 1, 1);
                        $pdf->MultiCell(10, 15, NULL, 0, 'L', 1, 1, '', '', true);

                        $pdf->SetFillColor(128, 128, 128);
                        $pdf->SetFont('helvetica', 'B', 8, '', true);
                        $pdf->MultiCell(10, 5, 'N°', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(15, 5, 'CODE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(15, 5, 'TITRE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(20, 5, 'CHAPITRE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(20, 5, 'SECTION', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(20, 5, 'ARTICLE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(160, 5, 'LIBELLE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(20, 5, 'DATE EFFET', 1, 'L', 1, 1, '', '', true);
                        $pdf->SetFont('helvetica', '', 8, '', true);
                        $pdf->SetFillColor(255, 255, 255);
                        $ligne = 1;
                        foreach ($actes_medicaux as $acte_medical) {
                            $pdf->SetFont('helvetica', 'B', 8, '', true);
                            $pdf->MultiCell(10, 5, $ligne, 1, 'R', 1, 0, '', '', true);
                            $pdf->MultiCell(15, 5, $acte_medical['code'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(15, 5, $acte_medical['code_titre'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(20, 5, $acte_medical['code_chapitre'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(20, 5, $acte_medical['code_section'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(20, 5, $acte_medical['code_article'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(160, 5, $acte_medical['libelle'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(20, 5, date('d/m/Y', strtotime($acte_medical['date_debut'])), 1, 'C', 1, 1, '', '', true);
                            $ligne++;
                        }

                    }
                    $pdf->Output($file_name, 'I');
                }

                //MEDICAMENTS
                elseif ($data == 'med_lab') {
                    $file_name = "EXPORT_MEDICAMENTS_LABORATOIRES_PHARMACEUTIQUES_" . date('dmYhis', time()) . ".pdf";
                    $pdf->SetTitle($file_name);

                    require "../_CONFIGS/Classes/MEDICAMENTS.php";
                    $MEDICAMENTS = new MEDICAMENTS();
                    $laboratoires = $MEDICAMENTS->lister_laboratoires_pharmaceutiques();
                    $nb_laboratoires = count($laboratoires);
                    if ($nb_laboratoires != 0) {
                        $pdf->AddPage('L');
                        $pdf->Image(IMAGES . 'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);

                        $pdf->writeHTMLCell(0, 0, 50, 15, '<h1>REFERENTIEL :<br />LABORATOIRES PHARMACEUTIQUES DE MEDICAMENTS</h1>', 0, 1, 0, true, 'C', true);
                        $pdf->setCellPaddings(1, 1, 1, 1);
                        $pdf->MultiCell(10, 15, NULL, 0, 'L', 1, 1, '', '', true);


                        $pdf->SetFillColor(128, 128, 128);
                        $pdf->SetFont('helvetica', 'B', 8, '', true);
                        $pdf->MultiCell(10, 5, 'N°', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(15, 5, 'CODE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(230, 5, 'LIBELLE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(20, 5, 'DATE EFFET', 1, 'L', 1, 1, '', '', true);
                        $pdf->SetFont('helvetica', '', 8, '', true);
                        $pdf->SetFillColor(255, 255, 255);
                        $ligne = 1;
                        foreach ($laboratoires as $laboratoire) {
                            $pdf->SetFont('helvetica', 'B', 8, '', true);
                            $pdf->MultiCell(10, 5, $ligne, 1, 'R', 1, 0, '', '', true);
                            $pdf->MultiCell(15, 5, $laboratoire['code'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(230, 5, $laboratoire['libelle'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(20, 5, date('d/m/Y', strtotime($laboratoire['date_debut'])), 1, 'C', 1, 1, '', '', true);
                            $ligne++;
                        }

                    }
                    $pdf->Output($file_name, 'I');
                }
                elseif ($data == 'med_pre') {
                    $file_name = "EXPORT_MEDICAMENTS_PRESENTATIONS_" . date('dmYhis', time()) . ".pdf";
                    $pdf->SetTitle($file_name);

                    require "../_CONFIGS/Classes/MEDICAMENTS.php";
                    $MEDICAMENTS = new MEDICAMENTS();
                    $presentations = $MEDICAMENTS->lister_presentations();
                    $nb_presentations = count($presentations);
                    if ($nb_presentations != 0) {
                        $pdf->AddPage('L');
                        $pdf->Image(IMAGES . 'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);

                        $pdf->writeHTMLCell(0, 0, 50, 15, '<h1>REFERENTIEL :<br />PRESENTATIONS DE MEDICAMENTS</h1>', 0, 1, 0, true, 'C', true);
                        $pdf->setCellPaddings(1, 1, 1, 1);
                        $pdf->MultiCell(10, 15, NULL, 0, 'L', 1, 1, '', '', true);


                        $pdf->SetFillColor(128, 128, 128);
                        $pdf->SetFont('helvetica', 'B', 8, '', true);
                        $pdf->MultiCell(10, 5, 'N°', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(15, 5, 'CODE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(230, 5, 'LIBELLE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(20, 5, 'DATE EFFET', 1, 'L', 1, 1, '', '', true);
                        $pdf->SetFont('helvetica', '', 8, '', true);
                        $pdf->SetFillColor(255, 255, 255);
                        $ligne = 1;
                        foreach ($presentations as $presentation) {
                            $pdf->SetFont('helvetica', 'B', 8, '', true);
                            $pdf->MultiCell(10, 5, $ligne, 1, 'R', 1, 0, '', '', true);
                            $pdf->MultiCell(15, 5, $presentation['code'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(230, 5, $presentation['libelle'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(20, 5, date('d/m/Y', strtotime($presentation['date_debut'])), 1, 'C', 1, 1, '', '', true);
                            $ligne++;
                        }

                    }
                    $pdf->Output($file_name, 'I');
                }
                elseif ($data == 'med_ffm') {
                    $file_name = "EXPORT_MEDICAMENTS_FAMILLES_DE_FORMES_" . date('dmYhis', time()) . ".pdf";
                    $pdf->SetTitle($file_name);

                    require "../_CONFIGS/Classes/MEDICAMENTS.php";
                    $MEDICAMENTS = new MEDICAMENTS();
                    $familles_formes = $MEDICAMENTS->lister_familles_formes();
                    $nb_familles_formes = count($familles_formes);
                    if ($nb_familles_formes != 0) {
                        $pdf->AddPage('L');
                        $pdf->Image(IMAGES . 'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);

                        $pdf->writeHTMLCell(0, 0, 50, 15, '<h1>REFERENTIEL :<br />FAMILLES DE FORMES DE MEDICAMENTS</h1>', 0, 1, 0, true, 'C', true);
                        $pdf->setCellPaddings(1, 1, 1, 1);
                        $pdf->MultiCell(10, 15, NULL, 0, 'L', 1, 1, '', '', true);


                        $pdf->SetFillColor(128, 128, 128);
                        $pdf->SetFont('helvetica', 'B', 8, '', true);
                        $pdf->MultiCell(10, 5, 'N°', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(15, 5, 'CODE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(230, 5, 'LIBELLE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(20, 5, 'DATE EFFET', 1, 'L', 1, 1, '', '', true);
                        $pdf->SetFont('helvetica', '', 8, '', true);
                        $pdf->SetFillColor(255, 255, 255);
                        $ligne = 1;
                        foreach ($familles_formes as $famille_forme) {
                            $pdf->SetFont('helvetica', 'B', 8, '', true);
                            $pdf->MultiCell(10, 5, $ligne, 1, 'R', 1, 0, '', '', true);
                            $pdf->MultiCell(15, 5, $famille_forme['code'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(230, 5, $famille_forme['libelle'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(20, 5, date('d/m/Y', strtotime($famille_forme['date_debut'])), 1, 'C', 1, 1, '', '', true);
                            $ligne++;
                        }

                    }
                    $pdf->Output($file_name, 'I');
                }
                elseif ($data == 'med_frm') {
                    $file_name = "EXPORT_MEDICAMENTS__FORMES_" . date('dmYhis', time()) . ".pdf";
                    $pdf->SetTitle($file_name);

                    require "../_CONFIGS/Classes/MEDICAMENTS.php";
                    $MEDICAMENTS = new MEDICAMENTS();
                    $formes = $MEDICAMENTS->lister_formes();
                    $nb_formes = count($formes);
                    if ($nb_formes != 0) {
                        $pdf->AddPage('L');
                        $pdf->Image(IMAGES . 'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);

                        $pdf->writeHTMLCell(0, 0, 50, 15, '<h1>REFERENTIEL :<br /> FORMES DE MEDICAMENTS</h1>', 0, 1, 0, true, 'C', true);
                        $pdf->setCellPaddings(1, 1, 1, 1);
                        $pdf->MultiCell(10, 15, NULL, 0, 'L', 1, 1, '', '', true);


                        $pdf->SetFillColor(128, 128, 128);
                        $pdf->SetFont('helvetica', 'B', 8, '', true);
                        $pdf->MultiCell(10, 5, 'N°', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(15, 5, 'CODE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(230, 5, 'LIBELLE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(20, 5, 'DATE EFFET', 1, 'L', 1, 1, '', '', true);
                        $pdf->SetFont('helvetica', '', 8, '', true);
                        $pdf->SetFillColor(255, 255, 255);
                        $ligne = 1;
                        foreach ($formes as $forme) {
                            $pdf->SetFont('helvetica', 'B', 8, '', true);
                            $pdf->MultiCell(10, 5, $ligne, 1, 'R', 1, 0, '', '', true);
                            $pdf->MultiCell(15, 5, $forme['code'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(230, 5, $forme['libelle'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(20, 5, date('d/m/Y', strtotime($forme['date_debut'])), 1, 'C', 1, 1, '', '', true);
                            $ligne++;
                        }

                    }
                    $pdf->Output($file_name, 'I');
                }
                elseif ($data == 'med_typ') {
                    $file_name = "EXPORT_MEDICAMENTS_TYPES_DE_MEDICAMENTS_" . date('dmYhis', time()) . ".pdf";
                    $pdf->SetTitle($file_name);

                    require "../_CONFIGS/Classes/MEDICAMENTS.php";
                    $MEDICAMENTS = new MEDICAMENTS();
                    $typesmedicaments = $MEDICAMENTS->lister_types_medicaments();
                    $nb_typesmedicaments = count($typesmedicaments);
                    if ($nb_typesmedicaments != 0) {
                        $pdf->AddPage('L');
                        $pdf->Image(IMAGES . 'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);

                        $pdf->writeHTMLCell(0, 0, 50, 15, '<h1>REFERENTIEL :<br />TYPES DE MEDICAMENTS</h1>', 0, 1, 0, true, 'C', true);
                        $pdf->setCellPaddings(1, 1, 1, 1);
                        $pdf->MultiCell(10, 15, NULL, 0, 'L', 1, 1, '', '', true);


                        $pdf->SetFillColor(128, 128, 128);
                        $pdf->SetFont('helvetica', 'B', 8, '', true);
                        $pdf->MultiCell(10, 5, 'N°', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(15, 5, 'CODE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(230, 5, 'LIBELLE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(20, 5, 'DATE EFFET', 1, 'L', 1, 1, '', '', true);
                        $pdf->SetFont('helvetica', '', 8, '', true);
                        $pdf->SetFillColor(255, 255, 255);
                        $ligne = 1;
                        foreach ($typesmedicaments as $typemedicament) {
                            $pdf->SetFont('helvetica', 'B', 8, '', true);
                            $pdf->MultiCell(10, 5, $ligne, 1, 'R', 1, 0, '', '', true);
                            $pdf->MultiCell(15, 5, $typemedicament['code'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(230, 5, $typemedicament['libelle'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(20, 5, date('d/m/Y', strtotime($typemedicament['date_debut'])), 1, 'C', 1, 1, '', '', true);
                            $ligne++;
                        }

                    }
                    $pdf->Output($file_name, 'I');
                }
                elseif ($data == 'med_cth') {
                    $file_name = "EXPORT_MEDICAMENTS_CLASSES_THERAPEUTHIQUES_" . date('dmYhis', time()) . ".pdf";
                    $pdf->SetTitle($file_name);

                    require "../_CONFIGS/Classes/MEDICAMENTS.php";
                    $MEDICAMENTS = new MEDICAMENTS();
                    $classes_therapeuthiques = $MEDICAMENTS->lister_classes_therapeutiques();
                    $nb_classes_therapeutiques = count($classes_therapeuthiques);
                    if ($nb_classes_therapeutiques != 0) {
                        $pdf->AddPage('L');
                        $pdf->Image(IMAGES . 'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);

                        $pdf->writeHTMLCell(0, 0, 50, 15, '<h1>REFERENTIEL :<br />CLASSES THERAPEUTHIQUES</h1>', 0, 1, 0, true, 'C', true);
                        $pdf->setCellPaddings(1, 1, 1, 1);
                        $pdf->MultiCell(10, 15, NULL, 0, 'L', 1, 1, '', '', true);


                        $pdf->SetFillColor(128, 128, 128);
                        $pdf->SetFont('helvetica', 'B', 8, '', true);
                        $pdf->MultiCell(10, 5, 'N°', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(15, 5, 'CODE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(230, 5, 'LIBELLE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(20, 5, 'DATE EFFET', 1, 'L', 1, 1, '', '', true);
                        $pdf->SetFont('helvetica', '', 8, '', true);
                        $pdf->SetFillColor(255, 255, 255);
                        $ligne = 1;
                        foreach ($classes_therapeuthiques as $classe_therapeuthique) {
                            $pdf->SetFont('helvetica', 'B', 8, '', true);
                            $pdf->MultiCell(10, 5, $ligne, 1, 'R', 1, 0, '', '', true);
                            $pdf->MultiCell(15, 5, $classe_therapeuthique['code'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(230, 5, $classe_therapeuthique['libelle'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(20, 5, date('d/m/Y', strtotime($classe_therapeuthique['date_debut'])), 1, 'C', 1, 1, '', '', true);
                            $ligne++;
                        }

                    }
                    $pdf->Output($file_name, 'I');
                }
                elseif ($data == 'med_fra') {
                    $file_name = "EXPORT_MEDICAMENTS_FORMES_ADMINISTRATIONS_" . date('dmYhis', time()) . ".pdf";
                    $pdf->SetTitle($file_name);

                    require "../_CONFIGS/Classes/MEDICAMENTS.php";
                    $MEDICAMENTS = new MEDICAMENTS();
                    $formesadministrations = $MEDICAMENTS->lister_formes_administrations();
                    $nb_formesadministrations = count($formesadministrations);
                    if ($nb_formesadministrations != 0) {
                        $pdf->AddPage('L');
                        $pdf->Image(IMAGES . 'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);

                        $pdf->writeHTMLCell(0, 0, 50, 15, '<h1>REFERENTIEL :<br />FORMES D\'ADMINISTRATIONS</h1>', 0, 1, 0, true, 'C', true);
                        $pdf->setCellPaddings(1, 1, 1, 1);
                        $pdf->MultiCell(10, 15, NULL, 0, 'L', 1, 1, '', '', true);


                        $pdf->SetFillColor(128, 128, 128);
                        $pdf->SetFont('helvetica', 'B', 8, '', true);
                        $pdf->MultiCell(10, 5, 'N°', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(15, 5, 'CODE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(230, 5, 'LIBELLE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(20, 5, 'DATE EFFET', 1, 'L', 1, 1, '', '', true);
                        $pdf->SetFont('helvetica', '', 8, '', true);
                        $pdf->SetFillColor(255, 255, 255);
                        $ligne = 1;
                        foreach ($formesadministrations as $formeadministration) {
                            $pdf->SetFont('helvetica', 'B', 8, '', true);
                            $pdf->MultiCell(10, 5, $ligne, 1, 'R', 1, 0, '', '', true);
                            $pdf->MultiCell(15, 5, $formeadministration['code'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(230, 5, $formeadministration['libelle'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(20, 5, date('d/m/Y', strtotime($formeadministration['date_debut'])), 1, 'C', 1, 1, '', '', true);
                            $ligne++;
                        }

                    }
                    $pdf->Output($file_name, 'I');
                }
                elseif ($data == 'med_unt') {
                    $file_name = "EXPORT_MEDICAMENTS_UNITES_DE_DOSAGES_" . date('dmYhis', time()) . ".pdf";
                    $pdf->SetTitle($file_name);

                    require "../_CONFIGS/Classes/MEDICAMENTS.php";
                    $MEDICAMENTS = new MEDICAMENTS();
                    $unitesdosages = $MEDICAMENTS->lister_unites_dosages();
                    $nb_unitesdosages = count($unitesdosages);
                    if ($nb_unitesdosages != 0) {
                        $pdf->AddPage('L');
                        $pdf->Image(IMAGES . 'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);

                        $pdf->writeHTMLCell(0, 0, 50, 15, '<h1>REFERENTIEL :<br />UNITES DE DOSGAES</h1>', 0, 1, 0, true, 'C', true);
                        $pdf->setCellPaddings(1, 1, 1, 1);
                        $pdf->MultiCell(10, 15, NULL, 0, 'L', 1, 1, '', '', true);


                        $pdf->SetFillColor(128, 128, 128);
                        $pdf->SetFont('helvetica', 'B', 8, '', true);
                        $pdf->MultiCell(10, 5, 'N°', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(15, 5, 'CODE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(230, 5, 'LIBELLE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(20, 5, 'DATE EFFET', 1, 'L', 1, 1, '', '', true);
                        $pdf->SetFont('helvetica', '', 8, '', true);
                        $pdf->SetFillColor(255, 255, 255);
                        $ligne = 1;
                        foreach ($unitesdosages as $unitedosage) {
                            $pdf->SetFont('helvetica', 'B', 8, '', true);
                            $pdf->MultiCell(10, 5, $ligne, 1, 'R', 1, 0, '', '', true);
                            $pdf->MultiCell(15, 5, $unitedosage['code'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(230, 5, $unitedosage['libelle'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(20, 5, date('d/m/Y', strtotime($unitedosage['date_debut'])), 1, 'C', 1, 1, '', '', true);
                            $ligne++;
                        }

                    }
                    $pdf->Output($file_name, 'I');
                }
                elseif ($data == 'med_dci') {
                    $file_name = "EXPORT_MEDICAMENTS_DCI_" . date('dmYhis', time()) . ".pdf";
                    $pdf->SetTitle($file_name);

                    require "../_CONFIGS/Classes/MEDICAMENTS.php";
                    $MEDICAMENTS = new MEDICAMENTS();
                    $denominations_communes_internationales = $MEDICAMENTS->lister_dci(null);
                    $nb_dci = count($denominations_communes_internationales);
                    if ($nb_dci != 0) {
                        $pdf->AddPage('L');
                        $pdf->Image(IMAGES . 'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);

                        $pdf->writeHTMLCell(0, 0, 50, 15, '<h1>REFERENTIEL :<br />DCI</h1>', 0, 1, 0, true, 'C', true);
                        $pdf->setCellPaddings(1, 1, 1, 1);
                        $pdf->MultiCell(10, 15, NULL, 0, 'L', 1, 1, '', '', true);


                        $pdf->SetFillColor(128, 128, 128);
                        $pdf->SetFont('helvetica', 'B', 8, '', true);
                        $pdf->MultiCell(10, 5, 'N°', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(50, 5, 'CODE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(50, 5, 'UNITE DE DOSAGE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(50, 5, 'FORME', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(100, 5, 'LIBELLE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(20, 5, 'DATE EFFET', 1, 'L', 1, 1, '', '', true);
                        $pdf->SetFont('helvetica', '', 8, '', true);
                        $pdf->SetFillColor(255, 255, 255);
                        $ligne = 1;
                        foreach ($denominations_communes_internationales as $dci) {
                            $pdf->SetFont('helvetica', 'B', 8, '', true);
                            $pdf->MultiCell(10, 5, $ligne, 1, 'R', 1, 0, '', '', true);
                            $pdf->MultiCell(50, 5, $dci['code'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(50, 5, $dci['dosage'] . $dci['code_unite'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(50, 5, $dci['code_forme'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(100, 5, $dci['libelle'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(20, 5, date('d/m/Y', strtotime($dci['date_debut'])), 1, 'C', 1, 1, '', '', true);
                            $ligne++;
                        }

                    }
                    $pdf->Output($file_name, 'I');
                }
                elseif ($data == 'med') {
                    $pdf->AddPage('L');
                    $pdf->Image(IMAGES . 'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);

                    $file_name = "EXPORT_MEDICAMENTS_" . date('dmYhis', time()) . ".pdf";
                    $pdf->SetTitle($file_name);
                    require "../_CONFIGS/Classes/MEDICAMENTS.php";
                    $MEDICAMENTS = new MEDICAMENTS();
                    $medicaments = $MEDICAMENTS->lister_medicaments();
                    $nb_medicaments = count($medicaments);
                    if ($nb_medicaments != 0) {
                        $pdf->writeHTMLCell(0, 0, 50, 15, '<h1>REFERENTIEL:<br />MEDICAMENTS</h1>', 0, 1, 0, true, 'C', true);
                        $pdf->setCellPaddings(1, 1, 1, 1);
                        $pdf->MultiCell(10, 15, NULL, 0, 'L', 1, 1, '', '', true);

                        $pdf->SetFillColor(128, 128, 128);
                        $pdf->SetFont('helvetica', 'B', 8, '', true);
                        $pdf->MultiCell(10, 5, 'N°', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(15, 5, 'CODE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(50, 5, 'LIBELLE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(40, 5, 'FORME', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(40, 5, 'DCI', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(40, 5, 'EAN13', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(40, 5, 'DOSAGE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(40, 5, 'DATE EFFET', 1, 'L', 1, 1, '', '', true);
                        $pdf->SetFont('helvetica', '', 8, '', true);
                        $pdf->SetFillColor(255, 255, 255);
                        $ligne = 1;
                        foreach ($medicaments as $medicament) {
                            $pdf->SetFont('helvetica', 'B', 8, '', true);
                            $pdf->MultiCell(10, 5, $ligne, 1, 'R', 1, 0, '', '', true);
                            $pdf->MultiCell(15, 5, $medicament['code'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(50, 5, $medicament['libelle'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(40, 5, $medicament['code_forme'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(40, 5, $medicament['code_dci'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(40, 5, $medicament['code_ean13'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(40, 5, $medicament['dosage'] . ' ' . $medicament['code_unite_dosage'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(40, 5, date('d/m/Y', strtotime($medicament['date_debut'])), 1, 'C', 1, 1, '', '', true);
                            $ligne++;
                        }

                    }
                    $pdf->Output($file_name, 'I');
                }

                //ETABLISSEMENTS
                elseif ($data == 'etab_niveau') {
                    $file_name = "EXPORT_ETABLISSEMENTS_NIVEAUX_SANITAIRES_" . date('dmYhis', time()) . ".pdf";
                    $pdf->SetTitle($file_name);

                    require "../_CONFIGS/Classes/ETABLISSEMENTS.php";
                    $ETABLISSEMENTS = new ETABLISSEMENTS();
                    $niveaux = $ETABLISSEMENTS->lister_lettres_cles();
                    $nb_niveaux = count($niveaux);
                    if ($nb_niveaux != 0) {
                        $pdf->AddPage('L');
                        $pdf->Image(IMAGES . 'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);

                        $pdf->writeHTMLCell(0, 0, 50, 15, '<h1>ETABLISSEMENTS :<br />NIVEAUX SANITAIRES</h1>', 0, 1, 0, true, 'C', true);
                        $pdf->setCellPaddings(1, 1, 1, 1);
                        $pdf->MultiCell(10, 15, NULL, 0, 'L', 1, 1, '', '', true);


                        $pdf->SetFillColor(128, 128, 128);
                        $pdf->SetFont('helvetica', 'B', 8, '', true);
                        $pdf->MultiCell(10, 5, 'N°', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(100, 5, 'CODE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(100, 5, 'LIBELLE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(50, 5, 'NIVEAU', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(20, 5, 'DATE EFFET', 1, 'L', 1, 1, '', '', true);
                        $pdf->SetFont('helvetica', '', 8, '', true);
                        $pdf->SetFillColor(255, 255, 255);
                        $ligne = 1;
                        foreach ($niveaux as $niveau) {
                            $pdf->SetFont('helvetica', 'B', 8, '', true);
                            $pdf->MultiCell(10, 5, $ligne, 1, 'R', 1, 0, '', '', true);
                            $pdf->MultiCell(100, 5, $niveau['code'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(100, 5, $niveau['libelle'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(50, 5, $niveau['niveau'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(20, 5, date('d/m/Y', strtotime($niveau['date_debut'])), 1, 'C', 1, 1, '', '', true);
                            $ligne++;
                        }

                    }
                    $pdf->Output($file_name, 'I');
                }
                else {
                    echo "<script>window.close();</script>";
                }
            }
            elseif ($type == 'txt') {

                //PATHOLOGIES
                if ($data == 'pat_chap') {
                    require "../_CONFIGS/Classes/PATHOLOGIES.php";
                    $PATHOLOGIES = new PATHOLOGIES();
                    $chapitres = $PATHOLOGIES->lister_chapitres();
                    $nb_chapitres = count($chapitres);
                    if ($nb_chapitres != 0) {
                        $file_name = "EXPORT_PATHOLOGIES_CHAPITRES_" . date('dmYhis', time()) . ".txt";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename=' . $file_name);

                        $fp = fopen('php://output', 'wb');
                        fwrite($fp, str_pad("CODE", 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad("LIBELLE", 100, ' ', STR_PAD_RIGHT) . "\t" . str_pad("DATE EFFET", 10, ' ', STR_PAD_RIGHT) . "\n");
                        foreach ($chapitres as $chapitre) {
                            fwrite($fp, str_pad($chapitre['code'], 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad($chapitre['libelle'], 100, ' ', STR_PAD_RIGHT) . "\t" . str_pad(date('d/m/Y', strtotime($chapitre['date_debut'])), 10, ' ', STR_PAD_RIGHT) . "\n");
                        }
                        fclose($fp);
                    }
                }
                elseif ($data == 'pat_sch') {
                    require "../_CONFIGS/Classes/PATHOLOGIES.php";
                    $PATHOLOGIES = new PATHOLOGIES();
                    $sous_chapitres = $PATHOLOGIES->lister_sous_chapitres(null);
                    $nb_sous_chapitres = count($sous_chapitres);
                    if ($nb_sous_chapitres != 0) {
                        $file_name = "EXPORT_PATHOLOGIES_SOUS_CHAPITRES_" . date('dmYhis', time()) . ".txt";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename=' . $file_name);

                        $fp = fopen('php://output', 'wb');
                        fwrite($fp, str_pad("CODE", 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad("CHAPITRE", 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad("LIBELLE", 100, ' ', STR_PAD_RIGHT) . "\t" . str_pad("DATE EFFET", 10, ' ', STR_PAD_RIGHT) . "\n");
                        foreach ($sous_chapitres as $sous_chapitre) {
                            fwrite($fp, str_pad($sous_chapitre['code'], 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad($sous_chapitre['code_chapitre'], 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad($sous_chapitre['libelle'], 100, ' ', STR_PAD_RIGHT) . "\t" . str_pad(date('d/m/Y', strtotime($sous_chapitre['date_debut'])), 10, ' ', STR_PAD_RIGHT) . "\n");
                        }
                        fclose($fp);
                    }
                }
                elseif ($data == 'pat') {
                    require "../_CONFIGS/Classes/PATHOLOGIES.php";
                    $PATHOLOGIES = new PATHOLOGIES();
                    $pathologies = $PATHOLOGIES->lister_pathologies(null, null);
                    $nb_pathologies = count($pathologies);
                    if ($nb_pathologies != 0) {
                        $file_name = "EXPORT_PATHOLOGIES_" . date('dmYhis', time()) . ".txt";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename=' . $file_name);

                        $fp = fopen('php://output', 'wb');
                        fwrite($fp, str_pad("CODE", 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad("CHAPITRE", 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad("SOUS-CHAPITRE", 14, ' ', STR_PAD_RIGHT) . "\t" . str_pad("LIBELLE", 100, ' ', STR_PAD_RIGHT) . "\t" . str_pad("DATE EFFET", 10, ' ', STR_PAD_RIGHT) . "\n");
                        foreach ($pathologies as $pathologie) {
                            fwrite($fp, str_pad($pathologie['code'], 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad($pathologie['code_chapitre'], 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad($pathologie['code_sous_chapitre'], 14, ' ', STR_PAD_RIGHT) . "\t" . str_pad($pathologie['libelle'], 100, ' ', STR_PAD_RIGHT) . "\t" . str_pad(date('d/m/Y', strtotime($pathologie['date_debut'])), 10, ' ', STR_PAD_RIGHT) . "\n");
                        }
                        fclose($fp);
                    }
                }

                //ACTES MEDICAUX
                elseif ($data == 'let_cle') {
                    require "../_CONFIGS/Classes/ACTESMEDICAUX.php";
                    $ACTESMEDICAUX = new ACTESMEDICAUX();
                    $lettres_cles = $ACTESMEDICAUX->lister_lettres_cles();
                    $nb_lettres_cles = count($lettres_cles);
                    if ($nb_lettres_cles != 0) {
                        $file_name = "EXPORT_ACTES_MEDICAUX_LETTRES_CLES_" . date('dmYhis', time()) . ".txt";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename=' . $file_name);

                        $fp = fopen('php://output', 'wb');
                        fwrite($fp, str_pad("CODE", 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad("LIBELLE", 100, ' ', STR_PAD_RIGHT) . "\t" . str_pad("PRIX UNITAIRE", 13, ' ', STR_PAD_RIGHT) . "\t" . str_pad("DATE EFFET", 10, ' ', STR_PAD_RIGHT) . "\n");
                        foreach ($lettres_cles as $lettre_cle) {
                            fwrite($fp, str_pad($lettre_cle['code'], 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad($lettre_cle['libelle'], 100, ' ', STR_PAD_RIGHT) . "\t" . str_pad($lettre_cle['prix_unitaire'], 13, ' ', STR_PAD_LEFT) . "\t" . str_pad(date('d/m/Y', strtotime($lettre_cle['date_debut'])), 10, ' ', STR_PAD_RIGHT) . "\n");
                        }
                        fclose($fp);
                    }
                }
                elseif ($data == 'act_tit') {
                    require "../_CONFIGS/Classes/ACTESMEDICAUX.php";
                    $ACTESMEDICAUX = new ACTESMEDICAUX();
                    $titres = $ACTESMEDICAUX->lister_titres();
                    $nb_titres = count($titres);
                    if ($nb_titres != 0) {
                        $file_name = "EXPORT_ACTES_MEDICAUX_TITRES_" . date('dmYhis', time()) . ".txt";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename=' . $file_name);

                        $fp = fopen('php://output', 'wb');
                        fwrite($fp, str_pad("CODE", 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad("LIBELLE", 100, ' ', STR_PAD_RIGHT) . "\t" . str_pad("DATE EFFET", 10, ' ', STR_PAD_RIGHT) . "\n");
                        foreach ($titres as $titre) {
                            fwrite($fp, str_pad($titre['code'], 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad($titre['libelle'], 100, ' ', STR_PAD_RIGHT) . "\t" . str_pad(date('d/m/Y', strtotime($titre['date_debut'])), 10, ' ', STR_PAD_RIGHT) . "\n");
                        }
                        fclose($fp);
                    }
                }
                elseif ($data == 'act_cha') {
                    require "../_CONFIGS/Classes/ACTESMEDICAUX.php";
                    $ACTESMEDICAUX = new ACTESMEDICAUX();
                    $chapitres = $ACTESMEDICAUX->lister_chapitres(null);
                    $nb_chapitres = count($chapitres);
                    if ($nb_chapitres != 0) {
                        $file_name = "EXPORT_ACTES_MEDICAUX_CHAPITRES_" . date('dmYhis', time()) . ".txt";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename=' . $file_name);

                        $fp = fopen('php://output', 'wb');
                        fwrite($fp, str_pad("CODE", 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad("LIBELLE", 100, ' ', STR_PAD_RIGHT) . "\t" . str_pad("DATE EFFET", 10, ' ', STR_PAD_RIGHT) . "\n");
                        foreach ($chapitres as $chapitre) {
                            fwrite($fp, str_pad($chapitre['code'], 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad($chapitre['libelle'], 100, ' ', STR_PAD_RIGHT) . "\t" . str_pad(date('d/m/Y', strtotime($chapitre['date_debut'])), 10, ' ', STR_PAD_RIGHT) . "\n");
                        }
                        fclose($fp);
                    }
                }
                elseif ($data == 'act_sec') {
                    require "../_CONFIGS/Classes/ACTESMEDICAUX.php";
                    $ACTESMEDICAUX = new ACTESMEDICAUX();
                    $sections = $ACTESMEDICAUX->lister_sections(null);
                    $nb_sections = count($sections);
                    if ($nb_sections != 0) {
                        $file_name = "EXPORT_ACTES_MEDICAUX_SECTION_" . date('dmYhis', time()) . ".txt";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename=' . $file_name);

                        $fp = fopen('php://output', 'wb');
                        fwrite($fp, str_pad("CODE", 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad("TITRE", 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad("CHAPITRE", 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad("LIBELLE", 100, ' ', STR_PAD_RIGHT) . "\t" . str_pad("DATE EFFET", 10, ' ', STR_PAD_RIGHT) . "\n");
                        foreach ($sections as $section) {
                            fwrite($fp, str_pad($section['code'], 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad($section['code_titre'], 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad($section['code_chapitre'], 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad($section['libelle'], 100, ' ', STR_PAD_RIGHT) . "\t" . str_pad(date('d/m/Y', strtotime($section['date_debut'])), 10, ' ', STR_PAD_RIGHT) . "\n");
                        }
                        fclose($fp);
                    }
                }
                elseif ($data == 'act_art') {
                    require "../_CONFIGS/Classes/ACTESMEDICAUX.php";
                    $ACTESMEDICAUX = new ACTESMEDICAUX();
                    $articles = $ACTESMEDICAUX->lister_articles(null);
                    $nb_articles = count($articles);
                    if ($nb_articles != 0) {
                        $file_name = "EXPORT_ARTICLES_" . date('dmYhis', time()) . ".txt";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename=' . $file_name);

                        $fp = fopen('php://output', 'wb');
                        fwrite($fp, str_pad("CODE", 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad("TITRE", 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad("CHAPITRE", 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad("SECTION", 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad("LIBELLE", 100, ' ', STR_PAD_RIGHT) . "\t" . str_pad("DATE EFFET", 10, ' ', STR_PAD_RIGHT) . "\n");
                        foreach ($articles as $article) {
                            fwrite($fp, str_pad($article['code'], 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad($article['code_titre'], 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad($article['code_chapitre'], 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad($article['code_section'], 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad($article['libelle'], 100, ' ', STR_PAD_RIGHT) . "\t" . str_pad(date('d/m/Y', strtotime($article['date_debut'])), 10, ' ', STR_PAD_RIGHT) . "\n");
                        }
                        fclose($fp);
                    }
                }
                elseif ($data == 'act_med') {
                    require "../_CONFIGS/Classes/ACTESMEDICAUX.php";
                    $ACTESMEDICAUX = new ACTESMEDICAUX();
                    $actes_medicaux = $ACTESMEDICAUX->lister_actes_medicaux(null);
                    $nb_actes_medicaux = count($actes_medicaux);
                    if ($nb_actes_medicaux != 0) {
                        $file_name = "EXPORT_ACTES_MEDICAUX_" . date('dmYhis', time()) . ".txt";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename=' . $file_name);

                        $fp = fopen('php://output', 'wb');
                        fwrite($fp, str_pad("CODE", 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad("TITRE", 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad("CHAPITRE", 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad("SECTION", 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad("ARTICLE", 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad("LIBELLE", 100, ' ', STR_PAD_RIGHT) . "\t" . str_pad("DATE EFFET", 10, ' ', STR_PAD_RIGHT) . "\n");
                        foreach ($actes_medicaux as $acte_medical) {
                            fwrite($fp, str_pad($acte_medical['code'], 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad($acte_medical['code_titre'], 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad($acte_medical['code_chapitre'], 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad($acte_medical['code_section'], 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad($acte_medical['code_article'], 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad($acte_medical['libelle'], 100, ' ', STR_PAD_RIGHT) . "\t" . str_pad(date('d/m/Y', strtotime($acte_medical['date_debut'])), 10, ' ', STR_PAD_RIGHT) . "\n");
                        }
                        fclose($fp);
                    }
                }

                //MEDICAMENTS
                elseif ($data == 'med_lab') {
                    require "../_CONFIGS/Classes/MEDICAMENTS.php";
                    $MEDICAMENTS = new MEDICAMENTS();
                    $laboratoires = $MEDICAMENTS->lister_laboratoires_pharmaceutiques();
                    $nb_laboratoires = count($laboratoires);
                    if ($nb_laboratoires != 0) {
                        $file_name = "EXPORT_MEDICAMENTS_LABORATOIRES_PHARMACEUTIQUE_" . date('dmYhis', time()) . ".txt";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename=' . $file_name);

                        $fp = fopen('php://output', 'wb');
                        fwrite($fp, str_pad("CODE", 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad("LIBELLE", 100, ' ', STR_PAD_RIGHT) . "\t" . str_pad("DATE EFFET", 10, ' ', STR_PAD_RIGHT) . "\n");
                        foreach ($laboratoires as $laboratoire) {
                            fwrite($fp, str_pad($laboratoire['code'], 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad($laboratoire['libelle'], 100, ' ', STR_PAD_RIGHT) . "\t" . str_pad(date('d/m/Y', strtotime($laboratoire['date_debut'])), 10, ' ', STR_PAD_RIGHT) . "\n");
                        }
                        fclose($fp);
                    }
                }
                elseif ($data == 'med_pre') {
                    require "../_CONFIGS/Classes/MEDICAMENTS.php";
                    $MEDICAMENTS = new MEDICAMENTS();
                    $presentations = $MEDICAMENTS->lister_presentations();
                    $nb_presentations = count($presentations);
                    if ($nb_presentations != 0) {
                        $file_name = "EXPORT_MEDICAMENTS_PRESENTATIONS_" . date('dmYhis', time()) . ".txt";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename=' . $file_name);

                        $fp = fopen('php://output', 'wb');
                        fwrite($fp, str_pad("CODE", 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad("LIBELLE", 100, ' ', STR_PAD_RIGHT) . "\t" . str_pad("DATE EFFET", 10, ' ', STR_PAD_RIGHT) . "\n");
                        foreach ($presentations as $presentation) {
                            fwrite($fp, str_pad($presentation['code'], 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad($presentation['libelle'], 100, ' ', STR_PAD_RIGHT) . "\t" . str_pad(date('d/m/Y', strtotime($presentation['date_debut'])), 10, ' ', STR_PAD_RIGHT) . "\n");
                        }
                        fclose($fp);
                    }
                }
                elseif ($data == 'med_ffm') {
                    require "../_CONFIGS/Classes/MEDICAMENTS.php";
                    $MEDICAMENTS = new MEDICAMENTS();
                    $familles_formes = $MEDICAMENTS->lister_familles_formes();
                    $nb_familles_formes = count($familles_formes);
                    if ($nb_familles_formes != 0) {
                        $file_name = "EXPORT_FAMILLES_DE_FORMES_" . date('dmYhis', time()) . ".txt";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename=' . $file_name);

                        $fp = fopen('php://output', 'wb');
                        fwrite($fp, str_pad("CODE", 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad("LIBELLE", 100, ' ', STR_PAD_RIGHT) . "\t" . str_pad("DATE EFFET", 10, ' ', STR_PAD_RIGHT) . "\n");
                        foreach ($familles_formes as $famille_forme) {
                            fwrite($fp, str_pad($famille_forme['code'], 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad($famille_forme['libelle'], 100, ' ', STR_PAD_RIGHT) . "\t" . str_pad(date('d/m/Y', strtotime($famille_forme['date_debut'])), 10, ' ', STR_PAD_RIGHT) . "\n");
                        }
                        fclose($fp);
                    }
                }
                elseif ($data == 'med_frm') {
                    require "../_CONFIGS/Classes/MEDICAMENTS.php";
                    $MEDICAMENTS = new MEDICAMENTS();
                    $formes = $MEDICAMENTS->lister_familles_formes();
                    $nb_formes = count($formes);
                    if ($nb_formes != 0) {
                        $file_name = "EXPORT_FORMES_" . date('dmYhis', time()) . ".txt";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename=' . $file_name);

                        $fp = fopen('php://output', 'wb');
                        fwrite($fp, str_pad("CODE", 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad("LIBELLE", 100, ' ', STR_PAD_RIGHT) . "\t" . str_pad("DATE EFFET", 10, ' ', STR_PAD_RIGHT) . "\n");
                        foreach ($formes as $forme) {
                            fwrite($fp, str_pad($forme['code'], 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad($forme['libelle'], 100, ' ', STR_PAD_RIGHT) . "\t" . str_pad(date('d/m/Y', strtotime($forme['date_debut'])), 10, ' ', STR_PAD_RIGHT) . "\n");
                        }
                        fclose($fp);
                    }
                }
                elseif ($data == 'med_typ') {
                    require "../_CONFIGS/Classes/MEDICAMENTS.php";
                    $MEDICAMENTS = new MEDICAMENTS();
                    $typesmedicaments = $MEDICAMENTS->lister_types_medicaments();
                    $nb_typesmedicaments = count($typesmedicaments);
                    if ($nb_typesmedicaments != 0) {
                        $file_name = "EXPORT_TYPES_DE_MEDICAMENTS_" . date('dmYhis', time()) . ".txt";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename=' . $file_name);

                        $fp = fopen('php://output', 'wb');
                        fwrite($fp, str_pad("CODE", 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad("LIBELLE", 100, ' ', STR_PAD_RIGHT) . "\t" . str_pad("DATE EFFET", 10, ' ', STR_PAD_RIGHT) . "\n");
                        foreach ($typesmedicaments as $typemedicament) {
                            fwrite($fp, str_pad($typemedicament['code'], 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad($typemedicament['libelle'], 100, ' ', STR_PAD_RIGHT) . "\t" . str_pad(date('d/m/Y', strtotime($typemedicament['date_debut'])), 10, ' ', STR_PAD_RIGHT) . "\n");
                        }
                        fclose($fp);
                    }
                }
                elseif ($data == 'med_cth') {
                    require "../_CONFIGS/Classes/MEDICAMENTS.php";
                    $MEDICAMENTS = new MEDICAMENTS();
                    $classestherapeuthiques = $MEDICAMENTS->lister_classes_therapeutiques();
                    $nb_classestherapeutiques = count($classestherapeuthiques);
                    if ($nb_classestherapeutiques != 0) {
                        $file_name = "EXPORT_CLASSES_THERAPEUTIQUES_" . date('dmYhis', time()) . ".txt";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename=' . $file_name);

                        $fp = fopen('php://output', 'wb');
                        fwrite($fp, str_pad("CODE", 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad("LIBELLE", 100, ' ', STR_PAD_RIGHT) . "\t" . str_pad("DATE EFFET", 10, ' ', STR_PAD_RIGHT) . "\n");
                        foreach ($classestherapeuthiques as $classetherapeuthique) {
                            fwrite($fp, str_pad($classetherapeuthique['code'], 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad($classetherapeuthique['libelle'], 100, ' ', STR_PAD_RIGHT) . "\t" . str_pad(date('d/m/Y', strtotime($classetherapeuthique['date_debut'])), 10, ' ', STR_PAD_RIGHT) . "\n");
                        }
                        fclose($fp);
                    }
                }
                elseif ($data == 'med_fra') {
                    require "../_CONFIGS/Classes/MEDICAMENTS.php";
                    $MEDICAMENTS = new MEDICAMENTS();
                    $formesadministrations = $MEDICAMENTS->lister_formes_administrations();
                    $nb_formesadministrations = count($formesadministrations);
                    if ($nb_formesadministrations != 0) {
                        $file_name = "EXPORT_FORMES_ADMINISTRATIONS_" . date('dmYhis', time()) . ".txt";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename=' . $file_name);

                        $fp = fopen('php://output', 'wb');
                        fwrite($fp, str_pad("CODE", 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad("LIBELLE", 100, ' ', STR_PAD_RIGHT) . "\t" . str_pad("DATE EFFET", 10, ' ', STR_PAD_RIGHT) . "\n");
                        foreach ($formesadministrations as $formeadministration) {
                            fwrite($fp, str_pad($formeadministration['code'], 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad($formeadministration['libelle'], 100, ' ', STR_PAD_RIGHT) . "\t" . str_pad(date('d/m/Y', strtotime($formeadministration['date_debut'])), 10, ' ', STR_PAD_RIGHT) . "\n");
                        }
                        fclose($fp);
                    }
                }
                elseif ($data == 'med_unt') {
                    require "../_CONFIGS/Classes/MEDICAMENTS.php";
                    $MEDICAMENTS = new MEDICAMENTS();
                    $unitesdosages = $MEDICAMENTS->lister_unites_dosages();
                    $nb_unitesdosages = count($unitesdosages);
                    if ($nb_unitesdosages != 0) {
                        $file_name = "EXPORT_UNITES_DE_DOSAGES_" . date('dmYhis', time()) . ".txt";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename=' . $file_name);

                        $fp = fopen('php://output', 'wb');
                        fwrite($fp, str_pad("CODE", 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad("LIBELLE", 100, ' ', STR_PAD_RIGHT) . "\t" . str_pad("DATE EFFET", 10, ' ', STR_PAD_RIGHT) . "\n");
                        foreach ($unitesdosages as $unitedosage) {
                            fwrite($fp, str_pad($unitedosage['code'], 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad($unitedosage['libelle'], 100, ' ', STR_PAD_RIGHT) . "\t" . str_pad(date('d/m/Y', strtotime($unitedosage['date_debut'])), 10, ' ', STR_PAD_RIGHT) . "\n");
                        }
                        fclose($fp);
                    }
                }
                elseif ($data == 'med_dci') {
                    require "../_CONFIGS/Classes/MEDICAMENTS.php";
                    $MEDICAMENTS = new MEDICAMENTS();
                    $denominations_communes_internationales = $MEDICAMENTS->lister_dci(null);
                    $nb_dci = count($denominations_communes_internationales);
                    if ($nb_dci != 0) {
                        $file_name = "EXPORT_DCI_" . date('dmYhis', time()) . ".txt";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename=' . $file_name);

                        $fp = fopen('php://output', 'wb');
                        fwrite($fp, str_pad("CODE", 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad("UNITE DE DOSAGE", 15, ' ', STR_PAD_RIGHT) . "\t" . str_pad("FORME", 7, ' ', STR_PAD_RIGHT) . "\t" . str_pad("LIBELLE", 100, ' ', STR_PAD_RIGHT) . "\t" . str_pad("DATE EFFET", 10, ' ', STR_PAD_RIGHT) . "\n");
                        foreach ($denominations_communes_internationales as $dci) {
                            fwrite($fp, str_pad($dci['code'], 10, ' ', STR_PAD_RIGHT) . "\t" . str_pad($dci['dosage'] . $dci['code_unite'], 15, ' ', STR_PAD_RIGHT) . "\t" . str_pad($dci['code_forme'], 7, ' ', STR_PAD_RIGHT) . "\t" . str_pad($dci['libelle'], 100, ' ', STR_PAD_RIGHT) . "\t" . str_pad(date('d/m/Y', strtotime($dci['date_debut'])), 10, ' ', STR_PAD_RIGHT) . "\n");
                        }
                        fclose($fp);
                    }
                }
                elseif ($data == 'med') {
                    require "../_CONFIGS/Classes/MEDICAMENTS.php";
                    $MEDICAMENTS = new MEDICAMENTS();
                    $medicaments = $MEDICAMENTS->lister_medicaments();
                    $nb_medicaments = count($medicaments);
                    if ($nb_medicaments != 0) {
                        $file_name = "EXPORT_MEDICAMENTS_" . date('dmYhis', time()) . ".txt";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename=' . $file_name);

                        $fp = fopen('php://output', 'wb');
                        fwrite($fp, str_pad("CODE", 7, ' ', STR_PAD_RIGHT) . "\t" . str_pad("LIBELLE", 45, ' ', STR_PAD_RIGHT) . "\t" . str_pad("FORME", 100, ' ', STR_PAD_RIGHT) . "\t" . str_pad("DCI", 45, ' ', STR_PAD_RIGHT) . "\t" . str_pad("EAN13", 45, ' ', STR_PAD_RIGHT) . "\t" . str_pad("DOSAGE", 15, ' ', STR_PAD_RIGHT) . "\t" . str_pad("DATE EFFET", 10, ' ', STR_PAD_RIGHT) . "\n");
                        foreach ($medicaments as $medicament) {
                            fwrite($fp, str_pad($medicament['code'], 7, ' ', STR_PAD_RIGHT) . "\t" . str_pad($medicament['libelle'], 45, ' ', STR_PAD_RIGHT) . "\t" . str_pad($medicament['code_forme'], 100, ' ', STR_PAD_RIGHT) . "\t" . str_pad($medicament['code_dci'], 45, ' ', STR_PAD_RIGHT) . "\t" . str_pad($medicament['code_ean13'], 45, ' ', STR_PAD_RIGHT) . "\t" . str_pad($medicament['dosage'] . $medicament['code_unite_dosage'], 15, ' ', STR_PAD_RIGHT) . "\t" . str_pad(date('d/m/Y', strtotime($medicament['date_debut'])), 10, ' ', STR_PAD_RIGHT) . "\n");
                        }
                        fclose($fp);
                    }
                }

                //ETABLISSEMENTS
                elseif ($data == 'etab_niveau') {
                    require "../_CONFIGS/Classes/ETABLISSEMENTS.php";
                    $ETABLISSEMENTS = new ETABLISSEMENTS();
                    $niveaux = $ETABLISSEMENTS->lister_niveau_sanitaire();
                    $nb_niveaux = count($niveaux);
                    if ($nb_niveaux != 0) {
                        $file_name = "EXPORT_ETABLISSEMENTS_NIVEAUX_SANITAIRES_" . date('dmYhis', time()) . ".txt";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename=' . $file_name);

                        $fp = fopen('php://output', 'wb');
                        fwrite($fp, str_pad("CODE", 5, ' ', STR_PAD_RIGHT) . "\t" . str_pad("LIBELLE", 100, ' ', STR_PAD_RIGHT) . "\t" . str_pad("PRIX UNITAIRE", 100, ' ', STR_PAD_RIGHT) . "\t" . str_pad("DATE EFFET", 10, ' ', STR_PAD_RIGHT) . "\n");
                        foreach ($niveaux as $niveau) {
                            fwrite($fp, str_pad($niveau['code'], 5, ' ', STR_PAD_RIGHT) . "\t" . str_pad($niveau['libelle'], 100, ' ', STR_PAD_RIGHT) . "\t" . str_pad($niveau['niveau'], 100, ' ', STR_PAD_RIGHT) . "\t" . str_pad(date('d/m/Y', strtotime($niveau['date_debut'])), 10, ' ', STR_PAD_RIGHT) . "\n");
                        }
                        fclose($fp);
                    }
                }
                else {
                    echo "<script>window.close();</script>";
                }
            }
            else {
                echo "<script>window.close();</script>";
            }
            $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, "EXPORT DE REFERENTIELS AU FORMAT " . strtoupper($type), $file_name);
        } else {
            echo "<script>window.close();</script>";
        }
    } else {
        echo "<script>window.close();</script>";
    }
} else {
    echo "<script>window.close();</script>";
}