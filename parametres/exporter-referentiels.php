<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

define('AUTHOR','TECHOUSE');

$type = trim($_GET['type']);
$data = trim($_GET['data']);
require "../_CONFIGS/Classes/UTILISATEURS.php";
if($type == 'csv') {

    //Pathologies
    if($data == 'pat_chap') {
    require "../_CONFIGS/Classes/PATHOLOGIES.php";
    $PATHOLOGIES = new PATHOLOGIES();
    $chapitres = $PATHOLOGIES->lister_chapitres();
    $nb_chapitres = count($chapitres);
    if($nb_chapitres != 0) {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="EXPORT_PATHOLOGIES_CHAPITRES_'.date('dmYhis',time()).'.csv"');
        //$donnees = array('CODE', 'LIBELLE', 'DATE EFFET');

        $fp = fopen('php://output', 'wb');
        fputcsv($fp, array('CODE', 'LIBELLE', 'DATE EFFET'),';');
        foreach ($chapitres as $chapitre) {
            fputcsv($fp, array($chapitre['code'], $chapitre['libelle'], date('d/m/Y',strtotime($chapitre['date_debut']))),';');
        }
        fclose($fp);
    }
}
    elseif($data == 'pat_sch') {
        require "../_CONFIGS/Classes/PATHOLOGIES.php";
        $PATHOLOGIES = new PATHOLOGIES();
        $sous_chapitres = $PATHOLOGIES->lister_sous_chapitres(null);
        $nb_sous_chapitres = count($sous_chapitres);
        if($nb_sous_chapitres != 0) {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="EXPORT_PATHOLOGIES_SOUS_CHAPITRES_'.date('dmYhis',time()).'.csv"');

            $fp = fopen('php://output', 'wb');
            fputcsv($fp, array('CODE', 'CHAPITRE', 'LIBELLE', 'DATE EFFET'),';');
            foreach ($sous_chapitres as $sous_chapitre) {
                fputcsv($fp, array($sous_chapitre['code'], $sous_chapitre['code_chapitre'], $sous_chapitre['libelle'], date('d/m/Y',strtotime($sous_chapitre['date_debut']))),';');
            }
            fclose($fp);
        }
    }
    elseif($data == 'pat') {
        require "../_CONFIGS/Classes/PATHOLOGIES.php";
        $PATHOLOGIES = new PATHOLOGIES();
        $pathologies = $PATHOLOGIES->lister_pathologies(null);
        $nb_pathologies = count($pathologies);
        if($nb_pathologies != 0) {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="EXPORT_PATHOLOGIES_'.date('dmYhis',time()).'.csv"');
            //$donnees = array('CODE', 'LIBELLE', 'DATE EFFET');

            $fp = fopen('php://output', 'wb');
            fputcsv($fp, array('CODE', 'LIBELLE', 'CHAPITRE', 'SOUS CHAPITRE', 'DATE EFFET'),';');
            foreach ($pathologies as $pathologie) {
                fputcsv($fp, array($pathologie['code'], $pathologie['code_chapitre'], $pathologie['code_sous_chapitre'], $pathologie['libelle'], date('d/m/Y',strtotime($pathologie['date_debut']))),';');
            }
            fclose($fp);
        }
    }

    //Actes medicaux
    elseif($data == 'let_cle') {
        require "../_CONFIGS/Classes/ACTESMEDICAUX.php";
        $PATHOLOGIES = new ACTESMEDICAUX();
        $actesmedicaux = $PATHOLOGIES->lister_lettres_cles();
        $nb_pathologies = count($actesmedicaux);
        if($nb_pathologies != 0) {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="EXPORT_ACTES_MEDICAUX_LETTRES_CLES_'.date('dmYhis',time()).'.csv"');
            //$donnees = array('CODE', 'LIBELLE', 'DATE EFFET');

            $fp = fopen('php://output', 'wb');
            fputcsv($fp, array('CODE', 'LIBELLE', 'PRIX UNITAIRE', 'DATE EFFET'),';');
            foreach ($actesmedicaux as $actemedical) {
                fputcsv($fp, array($actemedical['code'], $actemedical['libelle'], $actemedical['prix_unitaire'] .' FCFA', date('d/m/Y',strtotime($actemedical['date_debut']))),';');
            }
            fclose($fp);
        }
    }
    elseif($data == 'act_tit') {
        require "../_CONFIGS/Classes/ACTESMEDICAUX.php";
        $PATHOLOGIES = new ACTESMEDICAUX();
        $actesmedicaux = $PATHOLOGIES->lister_titres();
        $nb_pathologies = count($actesmedicaux);
        if($nb_pathologies != 0) {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="EXPORT_ACTES_MEDICAUX_TITRES_'.date('dmYhis',time()).'.csv"');
            //$donnees = array('CODE', 'LIBELLE', 'DATE EFFET');

            $fp = fopen('php://output', 'wb');
            fputcsv($fp, array('CODE', 'LIBELLE', 'DATE EFFET'),';');
            foreach ($actesmedicaux as $actemedical) {
                fputcsv($fp, array($actemedical['code_titre'], $actemedical['libelle'], date('d/m/Y',strtotime($actemedical['date_debut']))),';');
            }
            fclose($fp);
        }
    }
    elseif($data == 'act_cha') {
        require "../_CONFIGS/Classes/ACTESMEDICAUX.php";
        $ACTESMEDICAUX = new ACTESMEDICAUX();
        $actesmedicaux = $ACTESMEDICAUX->lister_chapitres(null);
        $nb_categories = count($actesmedicaux);
        if($nb_categories != 0) {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="EXPORT_ACTES_MEDICAUX_CHAPITRES_'.date('dmYhis',time()).'.csv"');
            //$donnees = array('CODE', 'LIBELLE', 'DATE EFFET');

            $fp = fopen('php://output', 'wb');
            fputcsv($fp, array('CODE', 'LIBELLE', 'DATE EFFET'),';');
            foreach ($actesmedicaux as $actemedical) {
                fputcsv($fp, array($actemedical['code'], $actemedical['libelle'], date('d/m/Y',strtotime($actemedical['date_debut']))),';');
            }
            fclose($fp);
        }
    }
    elseif($data == 'act_art') {
        require "../_CONFIGS/Classes/ACTESMEDICAUX.php";
        $ACTESMEDICAUX = new ACTESMEDICAUX();
        $sections = $ACTESMEDICAUX->lister_sections(null);
        $nb_sections = count($sections);
        if($nb_sections != 0) {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="EXPORT_PATHOLOGIES_SECTIONS_'.date('dmYhis',time()).'.csv"');
            //$donnees = array('CODE', 'LIBELLE', 'DATE EFFET');

            $fp = fopen('php://output', 'wb');
            fputcsv($fp, array('CODE', 'LIBELLE', 'TITRE', 'CHAPITRE', 'DATE EFFET'),';');
            foreach ($sections as $section) {
                fputcsv($fp, array($section['code'], $section['libelle'], $section['titre_code'], $section['code_chapitre'], date('d/m/Y',strtotime($section['date_debut']))),';');
            }
            fclose($fp);
        }
    }
    elseif($data == 'act_sec') {
        require "../_CONFIGS/Classes/ACTESMEDICAUX.php";
        $ACTESMEDICAUX = new ACTESMEDICAUX();
        $articles = $ACTESMEDICAUX->lister_articles(null);
        $nb_articles = count($articles);
        if($nb_articles != 0) {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="EXPORT_ACTES_MEDICAUX_ARTICLES_' . date('dmYhis', time()) . '.csv"');
            //$donnees = array('CODE', 'LIBELLE', 'DATE EFFET');

            $fp = fopen('php://output', 'wb');
            fputcsv($fp, array('CODE','LIBELLES','TITRES','CHAPITRES', 'SECTIONS', 'DATE EFFET'), ';');
            foreach ($articles as $article) {
                fputcsv($fp, array($article['code'],$article['libelle'],$article['titre_libelle'],$article['chapitre_libelle'],$article['section_libelle'], date('d/m/Y', strtotime($article['date_debut']))), ';');
            }
            fclose($fp);
        }
    }
    elseif($data == 'act_med') {
        require "../_CONFIGS/Classes/ACTESMEDICAUX.php";
        $ACTESMEDICAUX = new ACTESMEDICAUX();
        $actesmedicaux = $ACTESMEDICAUX->lister_actes_medicaux(null);
        $nb_communes = count($actesmedicaux);
        if($nb_communes != 0) {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="EXPORT_ACTES_MEDICAUX_' . date('dmYhis', time()) . '.csv"');
            //$donnees = array('CODE', 'LIBELLE', 'DATE EFFET');

            $fp = fopen('php://output', 'wb');
            fputcsv($fp, array('CODE','LIBELLES','TITRES','CHAPITRES', 'SECTIONS', 'ARTICLES', 'DATE EFFET'), ';');
            foreach ($actesmedicaux as $actemedical) {
                fputcsv($fp, array($actemedical['code'],$actemedical['libelle'],$actemedical['titre_code'],$actemedical['chapitre_code'],$actemedical['section_code'],$actemedical['article_code'], date('d/m/Y', strtotime($actemedical['date_debut']))), ';');
            }
            fclose($fp);
        }
    }


    //Medicaments

    elseif($data == 'med') {
        require "../_CONFIGS/Classes/MEDICAMENTS.php";
        $MEDICAMENTS = new MEDICAMENTS();
        $medicaments = $MEDICAMENTS->lister_medicaments();
        $nb_medicaments = count($medicaments);
        if ($nb_medicaments != 0) {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="EXPORT_MEDICAMENTS_' . date('dmYhis', time()) . '.txt"');

            $fp = fopen('php://output', 'wb');
            fwrite($fp, str_pad("CODE", 7, ' ', STR_PAD_RIGHT) . "\t\t\t" . str_pad("LIBELLE", 45, ' ', STR_PAD_RIGHT) . "\t\t\t" . str_pad("FORME", 100, ' ', STR_PAD_RIGHT) . "\t\t\t" . str_pad("DCI", 45, ' ', STR_PAD_RIGHT). "\t\t\t" . str_pad("EAN13", 45, ' ', STR_PAD_RIGHT). "\t\t\t" . str_pad("DOSAGE", 15, ' ', STR_PAD_RIGHT) . "\t\t\t" . str_pad("DATE EFFET", 10, ' ', STR_PAD_RIGHT) . "\n");
            foreach ($medicaments as $medicament) {
                fwrite($fp, str_pad($medicament['code'], 7, ' ', STR_PAD_RIGHT). "\t\t\t" . str_pad($medicament['libelle'], 45, ' ', STR_PAD_RIGHT) . "\t\t\t" . str_pad($medicament['code_forme'], 100, ' ', STR_PAD_RIGHT). "\t\t\t" . str_pad($medicament['code_dci'], 45, ' ', STR_PAD_RIGHT). "\t\t\t" . str_pad($medicament['code_ean13'], 45, ' ', STR_PAD_RIGHT). "\t\t\t" . str_pad($medicament['dosage'].$medicament['code_unite_dosage'], 15, ' ', STR_PAD_RIGHT). "\t\t\t" . str_pad(date('d/m/Y', strtotime($medicament['date_debut'])), 10, ' ', STR_PAD_RIGHT) . "\n");
            }
            fclose($fp);
        }
    }

    elseif($data == 'med_lab') {
        require "../_CONFIGS/Classes/MEDICAMENTS.php";
        $LABORATOIRES = new MEDICAMENTS();
        $laboratoires = $LABORATOIRES->lister_laboratoires_pharmaceutiques();
        $nb_laboratoires = count($laboratoires);
        if($nb_laboratoires != 0) {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="EXPORT_MEDICAMENTS_LABORATOIRES_PHARMACEUTIQUE_'.date('dmYhis',time()).'.csv"');
            //$donnees = array('CODE', 'LIBELLE', 'DATE EFFET');

            $fp = fopen('php://output', 'wb');
            fputcsv($fp, array('CODE', 'LIBELLE', 'DATE EFFET'),';');
            foreach ($laboratoires as $laboratoire) {
                fputcsv($fp, array($laboratoire['code'], $laboratoire['libelle'], date('d/m/Y',strtotime($laboratoire['date_debut']))),';');
            }
            fclose($fp);
        }
    }
    elseif($data == 'med_pre') {
        require "../_CONFIGS/Classes/MEDICAMENTS.php";
        $PRESENTAIONS = new MEDICAMENTS();
        $presentations = $PRESENTAIONS->lister_presentations();
        $nb_presentations = count($presentations);
        if($nb_presentations != 0) {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="EXPORT_MEDICAMENTS_PRESENSATIONS_'.date('dmYhis',time()).'.csv"');
            //$donnees = array('CODE', 'LIBELLE', 'DATE EFFET');

            $fp = fopen('php://output', 'wb');
            fputcsv($fp, array('CODE', 'LIBELLE', 'DATE EFFET'),';');
            foreach ($presentations as $presentation) {
                fputcsv($fp, array($presentation['code'], $presentation['libelle'], date('d/m/Y',strtotime($presentation['date_debut']))),';');
            }
            fclose($fp);
        }
    }
    elseif($data == 'med_ffm') {
        require "../_CONFIGS/Classes/MEDICAMENTS.php";
        $FAMILLESFORMES = new MEDICAMENTS();
        $famillesformes = $FAMILLESFORMES->lister_familles_formes();
        $nb_famillesformes = count($famillesformes);
        if($nb_famillesformes != 0) {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="EXPORT_MEDICAMENTS_FAMILLES_FORMES_'.date('dmYhis',time()).'.csv"');
            //$donnees = array('CODE', 'LIBELLE', 'DATE EFFET');

            $fp = fopen('php://output', 'wb');
            fputcsv($fp, array('CODE', 'LIBELLE', 'DATE EFFET'),';');
            foreach ($famillesformes as $familleforme) {
                fputcsv($fp, array($familleforme['code'], $familleforme['libelle'], date('d/m/Y',strtotime($familleforme['date_debut']))),';');
            }
            fclose($fp);
        }
    }
    elseif($data == 'med_frm') {
        require "../_CONFIGS/Classes/MEDICAMENTS.php";
        $FORMES = new MEDICAMENTS();
        $formes = $FORMES->lister_formes();
        $nb_formes = count($formes);
        if($nb_formes != 0) {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="EXPORT_MEDICAMENTS_FORMES_'.date('dmYhis',time()).'.csv"');
            //$donnees = array('CODE', 'LIBELLE', 'DATE EFFET');

            $fp = fopen('php://output', 'wb');
            fputcsv($fp, array('CODE', 'LIBELLE', 'DATE EFFET'),';');
            foreach ($formes as $forme) {
                fputcsv($fp, array($forme['code'], $forme['libelle'], date('d/m/Y',strtotime($forme['date_debut']))),';');
            }
            fclose($fp);
        }
    }
    elseif($data == 'med_typ') {
        require "../_CONFIGS/Classes/MEDICAMENTS.php";
        $TYPESMEDICAMENTS = new MEDICAMENTS();
        $typesmedicaments = $TYPESMEDICAMENTS->lister_types_medicaments();
        $nb_typesmedicaments = count($typesmedicaments);
        if($nb_typesmedicaments != 0) {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="EXPORT_MEDICAMENTS_TYPES_MEDICAMENTS_'.date('dmYhis',time()).'.csv"');
            //$donnees = array('CODE', 'LIBELLE', 'DATE EFFET');

            $fp = fopen('php://output', 'wb');
            fputcsv($fp, array('CODE', 'LIBELLE', 'DATE EFFET'),';');
            foreach ($typesmedicaments as $typemedicament) {
                fputcsv($fp, array($typemedicament['code'], $typemedicament['libelle'], date('d/m/Y',strtotime($typemedicament['date_debut']))),';');
            }
            fclose($fp);
        }
    }
    elseif($data == 'med_cth') {
        require "../_CONFIGS/Classes/MEDICAMENTS.php";
        $CLASSESTHERAPEUTHIUE = new MEDICAMENTS();
        $classestherapeuthiques = $CLASSESTHERAPEUTHIUE->lister_classes_therapeutiques();
        $nb_classestherapeutiques = count($classestherapeuthiques);
        if($nb_classestherapeutiques != 0) {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="EXPORT_MEDICAMENTS_CLASSES_THERAPEUTIQUES_'.date('dmYhis',time()).'.csv"');
            //$donnees = array('CODE', 'LIBELLE', 'DATE EFFET');

            $fp = fopen('php://output', 'wb');
            fputcsv($fp, array('CODE', 'LIBELLE', 'DATE EFFET'),';');
            foreach ($classestherapeuthiques as $classetherapeuthique) {
                fputcsv($fp, array($classetherapeuthique['code'], $classetherapeuthique['libelle'], date('d/m/Y',strtotime($classetherapeuthique['date_debut']))),';');
            }
            fclose($fp);
        }
    }
    elseif($data == 'med_fra') {
        require "../_CONFIGS/Classes/MEDICAMENTS.php";
        $FORMESADMINISTRATIONS = new MEDICAMENTS();
        $formesadministrations = $FORMESADMINISTRATIONS->lister_formes_administrations();
        $nb_formesadministrations = count($formesadministrations);
        if($nb_formesadministrations != 0) {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="EXPORT_MEDICAMENTS_FORMES_ADMINISTRATION_'.date('dmYhis',time()).'.csv"');
            //$donnees = array('CODE', 'LIBELLE', 'DATE EFFET');

            $fp = fopen('php://output', 'wb');
            fputcsv($fp, array('CODE', 'LIBELLE', 'DATE EFFET'),';');
            foreach ($formesadministrations as $formeadministration) {
                fputcsv($fp, array($formeadministration['code'], $formeadministration['libelle'], date('d/m/Y',strtotime($formeadministration['date_debut']))),';');
            }
            fclose($fp);
        }
    }
    elseif($data == 'med_unt') {
        require "../_CONFIGS/Classes/MEDICAMENTS.php";
        $UNITESDOSAGES = new MEDICAMENTS();
        $unitesdosages = $UNITESDOSAGES->lister_unites_dosages();
        $nb_unitesdosages = count($unitesdosages);
        if($nb_unitesdosages != 0) {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="EXPORT_MEDICAMENTS_UNITES_DOSAGES'.date('dmYhis',time()).'.csv"');
            //$donnees = array('CODE', 'LIBELLE', 'DATE EFFET');

            $fp = fopen('php://output', 'wb');
            fputcsv($fp, array('CODE', 'LIBELLE', 'DATE EFFET'),';');
            foreach ($unitesdosages as $unitedosage) {
                fputcsv($fp, array($unitedosage['code'], $unitedosage['libelle'], date('d/m/Y',strtotime($unitedosage['date_debut']))),';');
            }
            fclose($fp);
        }
    }
    elseif($data == 'med_dci') {
        require "../_CONFIGS/Classes/MEDICAMENTS.php";
        $DCI = new MEDICAMENTS();
        $denominations_communes_internationales = $DCI->lister_dci();
        $nb_dci = count($denominations_communes_internationales);
        if($nb_dci != 0) {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="EXPORT_MEDICAMENTS_DCI_'.date('dmYhis',time()).'.csv"');
            //$donnees = array('CODE', 'LIBELLE', 'DATE EFFET');

            $fp = fopen('php://output', 'wb');
            fputcsv($fp, array('CODE', 'LIBELLE', 'UNITE DE DOSAGE', 'FORME', 'DATE EFFET'),';');
            foreach ($denominations_communes_internationales as $denomination_commune_internationale) {
                fputcsv($fp, array($denomination_commune_internationale['code'], $denomination_commune_internationale['libelle'], $denomination_commune_internationale['dosage'].$denomination_commune_internationale['code_unite'], $denomination_commune_internationale['code_forme'], date('d/m/Y',strtotime($denomination_commune_internationale['date_debut']))),';');
            }
            fclose($fp);
        }
    }


    //ETABLISSEMENTS
    elseif($data == 'etab_niveau') {
        require "../_CONFIGS/Classes/ETABLISSEMENTS.php";
        $ETABLISSEMENTS = new ETABLISSEMENTS();
        $niveaux = $ETABLISSEMENTS->lister_niveau_sanitaire();
        $nb_niveaux = count($niveaux);
        if($nb_niveaux != 0) {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="EXPORT_ETABLISSEMENTS_NIVEAUX_SANITAIRES_'.date('dmYhis',time()).'.csv"');
            //$donnees = array('CODE', 'LIBELLE', 'DATE EFFET');

            $fp = fopen('php://output', 'wb');
            fputcsv($fp, array('CODE', 'LIBELLE', 'NIVEAU', 'DATE EFFET'),';');
            foreach ($niveaux as $niveau) {
                fputcsv($fp, array($niveau['code'], $niveau['libelle'], $niveau['niveau'], date('d/m/Y',strtotime($niveau['date_debut']))),';');
            }
            fclose($fp);
        }
    }

    else{
        echo '<p align="center">Cette donnée n\'est pas prise en charge pour l\'export.</p>';
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
    if ($data == 'pat_chap') {
        $file_name = "EXPORT_PHATOLOGIES_CHAPITRES_".date('dmYhis',time()).".xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="'.$file_name.'"');

        require "../_CONFIGS/Classes/PATHOLOGIES.php";
        $PATHOLOGIES = new PATHOLOGIES();
        $chapitres = $PATHOLOGIES->lister_chapitres();
        $nb_chapitres = count($chapitres);
        if($nb_chapitres != 0) {

            $row = 1;
            $sheet->getStyle('D'.$row.':T'.$row)->applyFromArray($style_titre);
                $sheet->setCellValue('D'.$row, 'REFERENTIEL : PATHOLOGIES CHAPITRES');
            $sheet->mergeCells('D'.$row.':T'.($row = $row+2));
            $sheet->getStyle('D1'.':T'.$row)
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

            $row++;
            $sheet->getStyle('A'.$row.':T'.$row)->applyFromArray($style_entete);
            $sheet->mergeCells('C'.$row.':R'.$row);
            $sheet->mergeCells('S'.$row.':T'.$row);
            $sheet->setCellValue('A'.$row, 'N°');
            $sheet->setCellValue('B'.$row, 'CODE');
            $sheet->setCellValue('C'.$row, 'LIBELLE');
            $sheet->setCellValue('S'.$row, 'DATE EFFET');
            $ligne = 1;
            foreach ($chapitres as $chapitre) {
                $row++;
                $sheet->getStyle('A'.$row.':T'.$row)->applyFromArray($style_tableau);
                $sheet->mergeCells('C'.$row.':R'.$row);
                $sheet->mergeCells('S'.$row.':T'.$row);
                $sheet->setCellValue('A'.$row, $ligne);
                $sheet->setCellValue('B'.$row, $chapitre['code']);
                $sheet->setCellValue('C'.$row, $chapitre['libelle']);
                $spreadsheet->getActiveSheet()->getStyle('S'.$row)
                    ->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                $sheet->setCellValue('S'.$row, date('d/m/Y',strtotime($chapitre['date_debut'])));
                $ligne++;
            }

            $writer = new Xlsx($spreadsheet);
            $writer->save("php://output");
        }
    }



    //MEDICAMENTS
    elseif ($data == 'med_lab') {
        $file_name = "EXPORT_MEDICAMENTS_LABORATOIRES_PHARMACEUTIQUES_".date('dmYhis',time()).".xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="'.$file_name.'"');

        require "../_CONFIGS/Classes/MEDICAMENTS.php";
        $LABORATOIRES = new MEDICAMENTS();
        $laboratoires = $LABORATOIRES->lister_laboratoires_pharmaceutiques();
        $nb_laboratoires = count($laboratoires);
        if($nb_laboratoires != 0) {

            $row = 1;
            $sheet->getStyle('D'.$row.':T'.$row)->applyFromArray($style_titre);
            $sheet->setCellValue('D'.$row, 'REFERENTIEL : MEDICAMENTS  LABORATOIRES PHARMACEUTIQUES ');
            $sheet->mergeCells('D'.$row.':T'.($row = $row+2));
            $sheet->getStyle('D1'.':T'.$row)
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

            $row++;
            $sheet->getStyle('A'.$row.':T'.$row)->applyFromArray($style_entete);
            $sheet->mergeCells('C'.$row.':R'.$row);
            $sheet->mergeCells('S'.$row.':T'.$row);
            $sheet->setCellValue('A'.$row, 'N°');
            $sheet->setCellValue('B'.$row, 'CODE');
            $sheet->setCellValue('C'.$row, 'LIBELLE');
            $sheet->setCellValue('S'.$row, 'DATE EFFET');
            $ligne = 1;
            foreach ($laboratoires as $laboratoire) {
                $row++;
                $sheet->getStyle('A'.$row.':T'.$row)->applyFromArray($style_tableau);
                $sheet->mergeCells('C'.$row.':R'.$row);
                $sheet->mergeCells('S'.$row.':T'.$row);
                $sheet->setCellValue('A'.$row, $ligne);
                $sheet->setCellValue('B'.$row, $laboratoire['code']);
                $sheet->setCellValue('C'.$row, $laboratoire['libelle']);
                $spreadsheet->getActiveSheet()->getStyle('S'.$row)
                    ->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                $sheet->setCellValue('S'.$row, date('d/m/Y',strtotime($laboratoire['date_debut'])));
                $ligne++;
            }

            $writer = new Xlsx($spreadsheet);
            $writer->save("php://output");
        }
    }
    elseif ($data == 'med_cth') {
        $file_name = "EXPORT_MEDICAMENTS_CLASSES_THERAPEUTHIQUE_".date('dmYhis',time()).".xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="'.$file_name.'"');

        require "../_CONFIGS/Classes/MEDICAMENTS.php";
        $CLASSESTHERAPEUTHIUE = new MEDICAMENTS();
        $classestherapeuthiques = $CLASSESTHERAPEUTHIUE->lister_classes_therapeutiques();
        $nb_classestherapeutiques = count($classestherapeuthiques);
        if($nb_classestherapeutiques != 0) {

            $row = 1;
            $sheet->getStyle('D'.$row.':T'.$row)->applyFromArray($style_titre);
            $sheet->setCellValue('D'.$row, 'REFERENTIEL : MEDICAMENTS  CLASSES THERAPEUTHIQUES');
            $sheet->mergeCells('D'.$row.':T'.($row = $row+2));
            $sheet->getStyle('D1'.':T'.$row)
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

            $row++;
            $sheet->getStyle('A'.$row.':T'.$row)->applyFromArray($style_entete);
            $sheet->mergeCells('C'.$row.':R'.$row);
            $sheet->mergeCells('S'.$row.':T'.$row);
            $sheet->setCellValue('A'.$row, 'N°');
            $sheet->setCellValue('B'.$row, 'CODE');
            $sheet->setCellValue('C'.$row, 'LIBELLE');
            $sheet->setCellValue('S'.$row, 'DATE EFFET');
            $ligne = 1;
            foreach ($classestherapeuthiques as $classetherapeuthique) {
                $row++;
                $sheet->getStyle('A'.$row.':T'.$row)->applyFromArray($style_tableau);
                $sheet->mergeCells('C'.$row.':R'.$row);
                $sheet->mergeCells('S'.$row.':T'.$row);
                $sheet->setCellValue('A'.$row, $ligne);
                $sheet->setCellValue('B'.$row, $classetherapeuthique['code']);
                $sheet->setCellValue('C'.$row, $classetherapeuthique['libelle']);
                $spreadsheet->getActiveSheet()->getStyle('S'.$row)
                    ->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                $sheet->setCellValue('S'.$row, date('d/m/Y',strtotime($classetherapeuthique['date_debut'])));
                $ligne++;
            }

            $writer = new Xlsx($spreadsheet);
            $writer->save("php://output");
        }
    }
    elseif ($data == 'med_pre') {
        $file_name = "EXPORT_MEDICAMENTS_PRESENTATIONS_".date('dmYhis',time()).".xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="'.$file_name.'"');

        require "../_CONFIGS/Classes/MEDICAMENTS.php";
        $PRESENTAIONS = new MEDICAMENTS();
        $presentations = $PRESENTAIONS->lister_presentations();
        $nb_presentations = count($presentations);
        if($nb_presentations != 0) {

            $row = 1;
            $sheet->getStyle('D'.$row.':T'.$row)->applyFromArray($style_titre);
                $sheet->setCellValue('D'.$row, 'REFERENTIEL : MEDICAMENTS PRESENTATIONS');
            $sheet->mergeCells('D'.$row.':T'.($row = $row+2));
            $sheet->getStyle('D1'.':T'.$row)
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

            $row++;
            $sheet->getStyle('A'.$row.':T'.$row)->applyFromArray($style_entete);
            $sheet->mergeCells('C'.$row.':R'.$row);
            $sheet->mergeCells('S'.$row.':T'.$row);
            $sheet->setCellValue('A'.$row, 'N°');
            $sheet->setCellValue('B'.$row, 'CODE');
            $sheet->setCellValue('C'.$row, 'LIBELLE');
            $sheet->setCellValue('S'.$row, 'DATE EFFET');
            $ligne = 1;
            foreach ($presentations as $presentation) {
                $row++;
                $sheet->getStyle('A'.$row.':T'.$row)->applyFromArray($style_tableau);
                $sheet->mergeCells('C'.$row.':R'.$row);
                $sheet->mergeCells('S'.$row.':T'.$row);
                $sheet->setCellValue('A'.$row, $ligne);
                $sheet->setCellValue('B'.$row, $presentation['code']);
                $sheet->setCellValue('C'.$row, $presentation['libelle']);
                $spreadsheet->getActiveSheet()->getStyle('S'.$row)
                    ->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                $sheet->setCellValue('S'.$row, date('d/m/Y',strtotime($presentation['date_debut'])));
                $ligne++;
            }

            $writer = new Xlsx($spreadsheet);
            $writer->save("php://output");
        }
    }
    elseif ($data == 'med_ffm') {
        $file_name = "EXPORT_MEDICAMENTS_FAMILLES_DE_FORMES_".date('dmYhis',time()).".xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="'.$file_name.'"');

        require "../_CONFIGS/Classes/MEDICAMENTS.php";
        $FAMILLESFORMES = new MEDICAMENTS();
        $famillesformes = $FAMILLESFORMES->lister_familles_formes();
        $nb_famillesformes = count($famillesformes);
        if($nb_famillesformes != 0) {

            $row = 1;
            $sheet->getStyle('D'.$row.':T'.$row)->applyFromArray($style_titre);
                $sheet->setCellValue('D'.$row, 'REFERENTIEL : MEDICAMENTS FAMILLES FORMES');
            $sheet->mergeCells('D'.$row.':T'.($row = $row+2));
            $sheet->getStyle('D1'.':T'.$row)
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

            $row++;
            $sheet->getStyle('A'.$row.':T'.$row)->applyFromArray($style_entete);
            $sheet->mergeCells('C'.$row.':R'.$row);
            $sheet->mergeCells('S'.$row.':T'.$row);
            $sheet->setCellValue('A'.$row, 'N°');
            $sheet->setCellValue('B'.$row, 'CODE');
            $sheet->setCellValue('C'.$row, 'LIBELLE');
            $sheet->setCellValue('S'.$row, 'DATE EFFET');
            $ligne = 1;
            foreach ($famillesformes as $familleforme) {
                $row++;
                $sheet->getStyle('A'.$row.':T'.$row)->applyFromArray($style_tableau);
                $sheet->mergeCells('C'.$row.':R'.$row);
                $sheet->mergeCells('S'.$row.':T'.$row);
                $sheet->setCellValue('A'.$row, $ligne);
                $sheet->setCellValue('B'.$row, $familleforme['code']);
                $sheet->setCellValue('C'.$row, $familleforme['libelle']);
                $spreadsheet->getActiveSheet()->getStyle('S'.$row)
                    ->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                $sheet->setCellValue('S'.$row, date('d/m/Y',strtotime($familleforme['date_debut'])));
                $ligne++;
            }

            $writer = new Xlsx($spreadsheet);
            $writer->save("php://output");
        }
    }
    elseif ($data == 'med_frm') {
        $file_name = "EXPORT_MEDICAMENTS_FORMES_".date('dmYhis',time()).".xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="'.$file_name.'"');

        require "../_CONFIGS/Classes/MEDICAMENTS.php";
        $FORMES = new MEDICAMENTS();
        $formes = $FORMES->lister_formes();
        $nb_formes = count($formes);
        if($nb_formes != 0) {

            $row = 1;
            $sheet->getStyle('D'.$row.':T'.$row)->applyFromArray($style_titre);
                $sheet->setCellValue('D'.$row, 'REFERENTIEL : MEDICAMENTS  FORMES');
            $sheet->mergeCells('D'.$row.':T'.($row = $row+2));
            $sheet->getStyle('D1'.':T'.$row)
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

            $row++;
            $sheet->getStyle('A'.$row.':T'.$row)->applyFromArray($style_entete);
            $sheet->mergeCells('C'.$row.':R'.$row);
            $sheet->mergeCells('S'.$row.':T'.$row);
            $sheet->setCellValue('A'.$row, 'N°');
            $sheet->setCellValue('B'.$row, 'CODE');
            $sheet->setCellValue('C'.$row, 'LIBELLE');
            $sheet->setCellValue('S'.$row, 'DATE EFFET');
            $ligne = 1;
            foreach ($formes as $forme) {
                $row++;
                $sheet->getStyle('A'.$row.':T'.$row)->applyFromArray($style_tableau);
                $sheet->mergeCells('C'.$row.':R'.$row);
                $sheet->mergeCells('S'.$row.':T'.$row);
                $sheet->setCellValue('A'.$row, $ligne);
                $sheet->setCellValue('B'.$row, $forme['code']);
                $sheet->setCellValue('C'.$row, $forme['libelle']);
                $spreadsheet->getActiveSheet()->getStyle('S'.$row)
                    ->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                $sheet->setCellValue('S'.$row, date('d/m/Y',strtotime($forme['date_debut'])));
                $ligne++;
            }

            $writer = new Xlsx($spreadsheet);
            $writer->save("php://output");
        }
    }
    elseif ($data == 'med') {
        $file_name = "EXPORT_MEDICAMENTS_".date('dmYhis',time()).".xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="'.$file_name.'"');

        require "../_CONFIGS/Classes/MEDICAMENTS.php";
        $MEDICAMENTS = new MEDICAMENTS();
        $medicaments = $MEDICAMENTS->lister_medicaments();
        $nb_medicaments = count($medicaments);
        if($nb_medicaments != 0) {
            $row = 1;
            $sheet->getStyle('D'.$row.':Q'.$row)->applyFromArray($style_titre);
            $sheet->setCellValue('D'.$row, 'REFERENTIEL: MEDICAMENTS');
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
            $sheet->setCellValue('C'.$row, 'LIBELLE');
            $sheet->setCellValue('F'.$row, 'FORME');
            $sheet->setCellValue('H'.$row, 'DCI');
            $sheet->setCellValue('K'.$row, 'EAN13');
            $sheet->setCellValue('N'.$row, 'DOSAGE');
            $sheet->setCellValue('P'.$row, 'DATE EFFET');
            $ligne = 1;
            foreach ($medicaments as $medicament) {
                $row++;
                $sheet->getStyle('A'.$row.':Q'.$row)->applyFromArray($style_tableau);
                $sheet->mergeCells('C'.$row.':E'.$row);
                $sheet->mergeCells('F'.$row.':G'.$row);
                $sheet->mergeCells('H'.$row.':J'.$row);
                $sheet->mergeCells('K'.$row.':M'.$row);
                $sheet->mergeCells('N'.$row.':O'.$row);
                $sheet->mergeCells('P'.$row.':Q'.$row);
                $sheet->setCellValue('A'.$row, $ligne);
                $sheet->setCellValue('B'.$row, $medicament['code']);
                $sheet->setCellValue('C'.$row, $medicament['libelle']);
                $sheet->setCellValue('F'.$row, $medicament['code_forme']);
                $sheet->setCellValue('H'.$row, $medicament['code_dci']);
                $sheet->setCellValue('K'.$row, $medicament['code_ean13']);
                $sheet->setCellValue('N'.$row, $medicament['dosage'].$medicament['code_unite_dosage']);
                $spreadsheet->getActiveSheet()->getStyle('Q'.$row)
                    ->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                $sheet->setCellValue('P'.$row, date('d/m/Y',strtotime($medicament['date_debut'])));
                $ligne++;
            }

            $writer = new Xlsx($spreadsheet);
            $writer->save("php://output");
        }
    }
    elseif ($data == 'med_typ') {
        $file_name = "EXPORT_MEDICAMENTS_TYPES_DE_MEDICAMENTS_".date('dmYhis',time()).".xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="'.$file_name.'"');

        require "../_CONFIGS/Classes/MEDICAMENTS.php";
        $TYPESMEDICAMENTS = new MEDICAMENTS();
        $typesmedicaments = $TYPESMEDICAMENTS->lister_types_medicaments();
        $nb_typesmedicaments = count($typesmedicaments);
        if($nb_typesmedicaments != 0) {

            $row = 1;
            $sheet->getStyle('D'.$row.':T'.$row)->applyFromArray($style_titre);
                $sheet->setCellValue('D'.$row, 'REFERENTIEL : MEDICAMENTS  TYPES DE MEDICAMENTS');
            $sheet->mergeCells('D'.$row.':T'.($row = $row+2));
            $sheet->getStyle('D1'.':T'.$row)
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

            $row++;
            $sheet->getStyle('A'.$row.':T'.$row)->applyFromArray($style_entete);
            $sheet->mergeCells('C'.$row.':R'.$row);
            $sheet->mergeCells('S'.$row.':T'.$row);
            $sheet->setCellValue('A'.$row, 'N°');
            $sheet->setCellValue('B'.$row, 'CODE');
            $sheet->setCellValue('C'.$row, 'LIBELLE');
            $sheet->setCellValue('S'.$row, 'DATE EFFET');
            $ligne = 1;
            foreach ($typesmedicaments as $typemedicament) {
                $row++;
                $sheet->getStyle('A'.$row.':T'.$row)->applyFromArray($style_tableau);
                $sheet->mergeCells('C'.$row.':R'.$row);
                $sheet->mergeCells('S'.$row.':T'.$row);
                $sheet->setCellValue('A'.$row, $ligne);
                $sheet->setCellValue('B'.$row, $typemedicament['code']);
                $sheet->setCellValue('C'.$row, $typemedicament['libelle']);
                $spreadsheet->getActiveSheet()->getStyle('S'.$row)
                    ->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                $sheet->setCellValue('S'.$row, date('d/m/Y',strtotime($typemedicament['date_debut'])));
                $ligne++;
            }

            $writer = new Xlsx($spreadsheet);
            $writer->save("php://output");
        }
    }
    elseif ($data == 'med_fra') {
        $file_name = "EXPORT_MEDICAMENTS_FORMES_ADMINISTRATION_".date('dmYhis',time()).".xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="'.$file_name.'"');

        require "../_CONFIGS/Classes/MEDICAMENTS.php";
        $FORMESADMINISTRATIONS = new MEDICAMENTS();
        $formesadministrations = $FORMESADMINISTRATIONS->lister_formes_administrations();
        $nb_formesadministrations = count($formesadministrations);
        if($nb_formesadministrations != 0) {

            $row = 1;
            $sheet->getStyle('D'.$row.':T'.$row)->applyFromArray($style_titre);
            $sheet->setCellValue('D'.$row, 'REFERENTIEL : MEDICAMENTS  FORMES ADMINISTRATIONS ');
            $sheet->mergeCells('D'.$row.':T'.($row = $row+2));
            $sheet->getStyle('D1'.':T'.$row)
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

            $row++;
            $sheet->getStyle('A'.$row.':T'.$row)->applyFromArray($style_entete);
            $sheet->mergeCells('C'.$row.':R'.$row);
            $sheet->mergeCells('S'.$row.':T'.$row);
            $sheet->setCellValue('A'.$row, 'N°');
            $sheet->setCellValue('B'.$row, 'CODE');
            $sheet->setCellValue('C'.$row, 'LIBELLE');
            $sheet->setCellValue('S'.$row, 'DATE EFFET');
            $ligne = 1;
            foreach ($formesadministrations as $formeadministration) {
                $row++;
                $sheet->getStyle('A'.$row.':T'.$row)->applyFromArray($style_tableau);
                $sheet->mergeCells('C'.$row.':R'.$row);
                $sheet->mergeCells('S'.$row.':T'.$row);
                $sheet->setCellValue('A'.$row, $ligne);
                $sheet->setCellValue('B'.$row, $formeadministration['code']);
                $sheet->setCellValue('C'.$row, $formeadministration['libelle']);
                $spreadsheet->getActiveSheet()->getStyle('S'.$row)
                    ->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                $sheet->setCellValue('S'.$row, date('d/m/Y',strtotime($formeadministration['date_debut'])));
                $ligne++;
            }

            $writer = new Xlsx($spreadsheet);
            $writer->save("php://output");
        }
    }
    elseif ($data == 'med_unt') {
        $file_name = "EXPORT_MEDICAMENTS_UNITES_DE_DOSAGES_".date('dmYhis',time()).".xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="'.$file_name.'"');

        require "../_CONFIGS/Classes/MEDICAMENTS.php";
        $UNITESDOSAGES = new MEDICAMENTS();
        $unitesdosages = $UNITESDOSAGES->lister_unites_dosages();
        $nb_unitesdosages = count($unitesdosages);
        if($nb_unitesdosages != 0) {

            $row = 1;
            $sheet->getStyle('D'.$row.':T'.$row)->applyFromArray($style_titre);
                $sheet->setCellValue('D'.$row, 'REFERENTIEL : MEDICAMENTS  UNITES DE DOSAGES ');
            $sheet->mergeCells('D'.$row.':T'.($row = $row+2));
            $sheet->getStyle('D1'.':T'.$row)
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

            $row++;
            $sheet->getStyle('A'.$row.':T'.$row)->applyFromArray($style_entete);
            $sheet->mergeCells('C'.$row.':R'.$row);
            $sheet->mergeCells('S'.$row.':T'.$row);
            $sheet->setCellValue('A'.$row, 'N°');
            $sheet->setCellValue('B'.$row, 'CODE');
            $sheet->setCellValue('C'.$row, 'LIBELLE');
            $sheet->setCellValue('S'.$row, 'DATE EFFET');
            $ligne = 1;
            foreach ($unitesdosages as $unitedosage) {
                $row++;
                $sheet->getStyle('A'.$row.':T'.$row)->applyFromArray($style_tableau);
                $sheet->mergeCells('C'.$row.':R'.$row);
                $sheet->mergeCells('S'.$row.':T'.$row);
                $sheet->setCellValue('A'.$row, $ligne);
                $sheet->setCellValue('B'.$row, $unitedosage['code']);
                $sheet->setCellValue('C'.$row, $unitedosage['libelle']);
                $spreadsheet->getActiveSheet()->getStyle('S'.$row)
                    ->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                $sheet->setCellValue('S'.$row, date('d/m/Y',strtotime($unitedosage['date_debut'])));
                $ligne++;
            }

            $writer = new Xlsx($spreadsheet);
            $writer->save("php://output");
        }
    }
    elseif ($data == 'med_dci') {
        $file_name = "EXPORT_MEDICAMENTS_DCI_".date('dmYhis',time()).".xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="'.$file_name.'"');

        require "../_CONFIGS/Classes/MEDICAMENTS.php";
        $DCI = new MEDICAMENTS();
        $denominations_communes_internationales = $DCI->lister_dci();
        $nb_dci = count($denominations_communes_internationales);
        if($nb_dci != 0) {

            $row = 1;
            $sheet->getStyle('D'.$row.':T'.$row)->applyFromArray($style_titre);
            $sheet->setCellValue('D'.$row, 'REFERENTIEL : MEDICAMENTS DCI ');
            $sheet->mergeCells('D'.$row.':T'.($row = $row+2));
            $sheet->getStyle('D1'.':T'.$row)
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

            $row++;
            $sheet->getStyle('A'.$row.':T'.$row)->applyFromArray($style_entete);
            $sheet->mergeCells('C'.$row.':G'.$row);
            $sheet->mergeCells('H'.$row.':L'.$row);
            $sheet->mergeCells('M'.$row.':R'.$row);
            $sheet->mergeCells('S'.$row.':T'.$row);
            $sheet->setCellValue('A'.$row, 'N°');
            $sheet->setCellValue('B'.$row, 'CODE');
            $sheet->setCellValue('C'.$row, 'FORME');
            $sheet->setCellValue('H'.$row, 'UNITE DOSAGE');
            $sheet->setCellValue('M'.$row, 'LIBELLE');
            $sheet->setCellValue('S'.$row, 'DATE EFFET');
            $ligne = 1;
            foreach ($denominations_communes_internationales as $denomination_commune_internationale) {
                $row++;
                $sheet->getStyle('A'.$row.':T'.$row)->applyFromArray($style_tableau);
                $sheet->mergeCells('C'.$row.':G'.$row);
                $sheet->mergeCells('H'.$row.':L'.$row);
                $sheet->mergeCells('M'.$row.':R'.$row);
                $sheet->mergeCells('S'.$row.':T'.$row);
                $sheet->setCellValue('A'.$row, $ligne);
                $sheet->setCellValue('B'.$row, $denomination_commune_internationale['code']);
                $sheet->setCellValue('C'.$row, $denomination_commune_internationale['code_forme']);
                $sheet->setCellValue('H'.$row, $denomination_commune_internationale['dosage'].$denomination_commune_internationale['code_unite']);
                $sheet->setCellValue('M'.$row, $denomination_commune_internationale['libelle']);
                $spreadsheet->getActiveSheet()->getStyle('S'.$row)
                    ->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                $sheet->setCellValue('S'.$row, date('d/m/Y',strtotime($denomination_commune_internationale['date_debut'])));
                $ligne++;
            }

            $writer = new Xlsx($spreadsheet);
            $writer->save("php://output");
        }
    }

    //ACTES MEDICAUX
    elseif ($data == 'act_cha') {
        $file_name = "EXPORT_ACTES_MEDICAUX_CHAPITRES_".date('dmYhis',time()).".xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="'.$file_name.'"');

        require "../_CONFIGS/Classes/ACTESMEDICAUX.php";
        $ACTESMEDICAUX = new ACTESMEDICAUX();
        $actesmedicaux = $ACTESMEDICAUX->lister_chapitres(null);
        $nb_pathologies = count($actesmedicaux);
        if($nb_pathologies != 0) {

            $row = 1;
            $sheet->getStyle('D'.$row.':L'.$row)->applyFromArray($style_titre);
            $sheet->setCellValue('D'.$row, 'REFERENTIEL :   CHAPITRES');
            $sheet->mergeCells('D'.$row.':L'.($row = $row+2));
            $sheet->getStyle('D1'.':L'.$row)
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

            $row++;
            $sheet->getStyle('A'.$row.':L'.$row)->applyFromArray($style_entete);
            $sheet->mergeCells('C'.$row.':G'.$row);
            $sheet->mergeCells('H'.$row.':J'.$row);
            $sheet->mergeCells('K'.$row.':L'.$row);
            $sheet->setCellValue('A'.$row, 'N°');
            $sheet->setCellValue('B'.$row, 'CODE');
            $sheet->setCellValue('C'.$row, 'TITRE');
            $sheet->setCellValue('H'.$row, 'LIBELLE');
            $sheet->setCellValue('K'.$row, 'DATE EFFET');
            $ligne = 1;
            foreach ($actesmedicaux as $actemedical) {
                $row++;
                $sheet->getStyle('A'.$row.':L'.$row)->applyFromArray($style_tableau);
                $sheet->mergeCells('C'.$row.':G'.$row);
                $sheet->mergeCells('H'.$row.':J'.$row);
                $sheet->mergeCells('K'.$row.':L'.$row);
                $sheet->setCellValue('A'.$row, $ligne);
                $sheet->setCellValue('B'.$row, $actemedical['code']);
                $sheet->setCellValue('C'.$row, $actemedical['nom_titre']);
                $sheet->setCellValue('H'.$row, $actemedical['libelle']);
                $spreadsheet->getActiveSheet()->getStyle('K'.$row)
                    ->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                $sheet->setCellValue('K'.$row, date('d/m/Y',strtotime($actemedical['date_debut'])));
                $ligne++;
            }

            $writer = new Xlsx($spreadsheet);
            $writer->save("php://output");
        }
    }
    elseif ($data == 'act_med') {
        $file_name = "EXPORT_ACTES_MEDICAUX_".date('dmYhis',time()).".xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="'.$file_name.'"');

        require "../_CONFIGS/Classes/ACTESMEDICAUX.php";
        $ACTESMEDICAUX = new ACTESMEDICAUX();
        $actesmedicaux = $ACTESMEDICAUX->lister_actes_medicaux(null);
        $nb_regions = count($actesmedicaux);
        if($nb_regions != 0) {
            $row = 1;
            $sheet->getStyle('D'.$row.':Q'.$row)->applyFromArray($style_titre);
            $sheet->setCellValue('D'.$row, 'REFERENTIEL: ACTES MEDICAUX');
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
            $sheet->setCellValue('F'.$row, 'TITRE');
            $sheet->setCellValue('H'.$row, 'CHAPITRE');
            $sheet->setCellValue('K'.$row, 'SECTIONS');
            $sheet->setCellValue('N'.$row, 'ARTICLES');
            $sheet->setCellValue('P'.$row, 'DATE EFFET');
            $ligne = 1;
            foreach ($actesmedicaux as $actemedical) {
                $row++;
                $sheet->getStyle('A'.$row.':Q'.$row)->applyFromArray($style_tableau);
                $sheet->mergeCells('C'.$row.':E'.$row);
                $sheet->mergeCells('F'.$row.':G'.$row);
                $sheet->mergeCells('H'.$row.':J'.$row);
                $sheet->mergeCells('K'.$row.':M'.$row);
                $sheet->mergeCells('N'.$row.':O'.$row);
                $sheet->mergeCells('P'.$row.':Q'.$row);
                $sheet->setCellValue('A'.$row, $ligne);
                $sheet->setCellValue('B'.$row, $actemedical['code']);
                $sheet->setCellValue('C'.$row, $actemedical['libelle']);
                $sheet->setCellValue('F'.$row, $actemedical['titre_code']);
                $sheet->setCellValue('H'.$row, $actemedical['chapitre_code']);
                $sheet->setCellValue('K'.$row, $actemedical['section_code']);
                $sheet->setCellValue('N'.$row, $actemedical['article_code']);
                $spreadsheet->getActiveSheet()->getStyle('Q'.$row)
                    ->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                $sheet->setCellValue('P'.$row, date('d/m/Y',strtotime($actemedical['date_debut'])));
                $ligne++;
            }

            $writer = new Xlsx($spreadsheet);
            $writer->save("php://output");
        }
    }
    elseif ($data == 'act_art') {
        $file_name = "EXPORT_ACTES_MEDICAUX_ARTICLE".date('dmYhis',time()).".xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="'.$file_name.'"');

        require "../_CONFIGS/Classes/ACTESMEDICAUX.php";
        $ACTESMEDICAUX = new ACTESMEDICAUX();
        $articles = $ACTESMEDICAUX->lister_articles(null);
        $nb_articles = count($articles);
        if($nb_articles != 0) {
            $row = 1;
            $sheet->getStyle('D'.$row.':Q'.$row)->applyFromArray($style_titre);
            $sheet->setCellValue('D'.$row, 'REFERENTIEL: ARTICLES');
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
            $sheet->mergeCells('K'.$row.':O'.$row);
            $sheet->mergeCells('p'.$row.':Q'.$row);
            $sheet->setCellValue('A'.$row, 'N°');
            $sheet->setCellValue('B'.$row, 'CODE');
            $sheet->setCellValue('C'.$row, 'NOM');
            $sheet->setCellValue('F'.$row, 'TITRE');
            $sheet->setCellValue('H'.$row, 'CHAPITRES');
            $sheet->setCellValue('K'.$row, 'SECTIONS');
            $sheet->setCellValue('P'.$row, 'DATE EFFET');
            $ligne = 1;
            foreach ($articles as $article) {
                $row++;
                $sheet->getStyle('A'.$row.':Q'.$row)->applyFromArray($style_tableau);
                $sheet->mergeCells('C'.$row.':E'.$row);
                $sheet->mergeCells('F'.$row.':G'.$row);
                $sheet->mergeCells('H'.$row.':J'.$row);
                $sheet->mergeCells('K'.$row.':O'.$row);
                $sheet->mergeCells('p'.$row.':Q'.$row);
                $sheet->setCellValue('A'.$row, $ligne);
                $sheet->setCellValue('B'.$row, $article['code']);
                $sheet->setCellValue('C'.$row, $article['libelle']);
                $sheet->setCellValue('F'.$row, $article['titre_libelle']);
                $sheet->setCellValue('H'.$row, $article['chapitre_libelle']);
                $sheet->setCellValue('K'.$row, $article['section_libelle']);
                $spreadsheet->getActiveSheet()->getStyle('Q'.$row)
                    ->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                $sheet->setCellValue('P'.$row, date('d/m/Y',strtotime($article['date_debut'])));
                $ligne++;
            }

            $writer = new Xlsx($spreadsheet);
            $writer->save("php://output");
        }
    }
    elseif ($data == 'let_cle') {
        $file_name = "EXPORT_ACTES_MEDICAUX_LETTRES_CLES_".date('dmYhis',time()).".xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="'.$file_name.'"');

        require "../_CONFIGS/Classes/ACTESMEDICAUX.php";
        $ACTESMEDICAUX = new ACTESMEDICAUX();
        $actesmedicaux = $ACTESMEDICAUX->lister_lettres_cles();
        $nb_pathologies = count($actesmedicaux);
        if($nb_pathologies != 0) {

            $row = 1;
            $sheet->getStyle('D'.$row.':O'.$row)->applyFromArray($style_titre);
            $sheet->setCellValue('D'.$row, 'REFERENTIEL : LETTRES CLES');
            $sheet->mergeCells('D'.$row.':O'.($row = $row+2));
            $sheet->getStyle('D1'.':O'.$row)
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

            $row++;
            $sheet->getStyle('A'.$row.':O'.$row)->applyFromArray($style_entete);
            $sheet->mergeCells('C'.$row.':J'.$row);
            $sheet->mergeCells('K'.$row.':M'.$row);
            $sheet->mergeCells('N'.$row.':O'.$row);
            $sheet->setCellValue('A'.$row, 'N°');
            $sheet->setCellValue('B'.$row, 'CODE');
            $sheet->setCellValue('C'.$row, 'LIBELLE');
            $sheet->setCellValue('k'.$row, 'PRIX UNITAIRE');
            $sheet->setCellValue('N'.$row, 'DATE EFFET');
            $ligne = 1;
            foreach ($actesmedicaux as $actemedical) {
                $row++;
                $sheet->getStyle('A'.$row.':O'.$row)->applyFromArray($style_tableau);
                $sheet->mergeCells('C'.$row.':J'.$row);
                $sheet->mergeCells('K'.$row.':M'.$row);
                $sheet->mergeCells('N'.$row.':O'.$row);
                $sheet->setCellValue('A'.$row, $ligne);
                $sheet->setCellValue('B'.$row, $actemedical['code']);
                $sheet->setCellValue('C'.$row, $actemedical['libelle']);
                $sheet->setCellValue('K'.$row, $actemedical['prix_unitaire'] .'FCFA');
                $spreadsheet->getActiveSheet()->getStyle('N'.$row)
                    ->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                $sheet->setCellValue('N'.$row, date('d/m/Y',strtotime($actemedical['date_debut'])));
                $ligne++;
            }

            $writer = new Xlsx($spreadsheet);
            $writer->save("php://output");
        }
    }
    elseif ($data == 'act_tit') {
        $file_name = "EXPORT_ACTES_MEDICAUX_TITRES_".date('dmYhis',time()).".xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="'.$file_name.'"');

        require "../_CONFIGS/Classes/ACTESMEDICAUX.php";
        $ACTESMEDICAUX = new ACTESMEDICAUX();
        $actesmedicaux = $ACTESMEDICAUX->lister_lettres_cles();
        $nb_pathologies = count($actesmedicaux);
        if($nb_pathologies != 0) {

            $row = 1;
            $sheet->getStyle('D'.$row.':L'.$row)->applyFromArray($style_titre);
            $sheet->setCellValue('D'.$row, 'REFERENTIEL : TITRES');
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
            foreach ($actesmedicaux as $actemedical) {
                $row++;
                $sheet->getStyle('A'.$row.':L'.$row)->applyFromArray($style_tableau);
                $sheet->mergeCells('C'.$row.':J'.$row);
                $sheet->mergeCells('K'.$row.':L'.$row);
                $sheet->setCellValue('A'.$row, $ligne);
                $sheet->setCellValue('B'.$row, $actemedical['code']);
                $sheet->setCellValue('C'.$row, $actemedical['libelle']);
                $spreadsheet->getActiveSheet()->getStyle('K'.$row)
                    ->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                $sheet->setCellValue('K'.$row, date('d/m/Y',strtotime($actemedical['date_debut'])));
                $ligne++;
            }

            $writer = new Xlsx($spreadsheet);
            $writer->save("php://output");
        }
    }
    elseif ($data == 'act_sec') {
        $file_name = "EXPORT_ACTES_MEDICAUX_SECTIONS_".date('dmYhis',time()).".xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="'.$file_name.'"');

        require "../_CONFIGS/Classes/ACTESMEDICAUX.php";
        $ACTESMEDICAUX = new ACTESMEDICAUX();
        $sections = $ACTESMEDICAUX->lister_sections(null);
        $nb_sections = count($sections);
        if($nb_sections != 0) {

            $row = 1;
            $sheet->getStyle('D'.$row.':L'.$row)->applyFromArray($style_titre);
            $sheet->setCellValue('D'.$row, 'REFERENTIEL : ACTE MEDICAL SECTION');
            $sheet->mergeCells('D'.$row.':L'.($row = $row+2));
            $sheet->getStyle('D1'.':L'.$row)
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

            $row++;
            $sheet->getStyle('A'.$row.':L'.$row)->applyFromArray($style_entete);
            $sheet->mergeCells('C'.$row.':E'.$row);
            $sheet->mergeCells('F'.$row.':H'.$row);
            $sheet->mergeCells('I'.$row.':J'.$row);
            $sheet->mergeCells('K'.$row.':L'.$row);
            $sheet->setCellValue('A'.$row, 'N°');
            $sheet->setCellValue('B'.$row, 'CODE');
            $sheet->setCellValue('C'.$row, 'LIBELLE');
            $sheet->setCellValue('F'.$row, 'TITRE');
            $sheet->setCellValue('I'.$row, 'CHAPITRE');
            $sheet->setCellValue('K'.$row, 'DATE EFFET');
            $ligne = 1;
            foreach ($sections as $section) {
                $row++;
                $sheet->getStyle('A'.$row.':L'.$row)->applyFromArray($style_tableau);
                $sheet->mergeCells('C'.$row.':E'.$row);
                $sheet->mergeCells('F'.$row.':H'.$row);
                $sheet->mergeCells('I'.$row.':J'.$row);
                $sheet->mergeCells('K'.$row.':L'.$row);
                $sheet->setCellValue('A'.$row, $ligne);
                $sheet->setCellValue('B'.$row, $section['code']);
                $sheet->setCellValue('C'.$row, $section['libelle']);
                $sheet->setCellValue('F'.$row, $section['titre_code']);
                $sheet->setCellValue('I'.$row, $section['code_chapitre']);
                $spreadsheet->getActiveSheet()->getStyle('K'.$row)
                    ->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                $sheet->setCellValue('K'.$row, date('d/m/Y',strtotime($section['date_debut'])));
                $ligne++;
            }


            $writer = new Xlsx($spreadsheet);
            $writer->save("php://output");
        }
    }

    //PATHOLOGIES
    elseif ($data == 'pat_chap') {
        $file_name = "EXPORT_PHATOLOGIES_SOUS_CHAPITRES_".date('dmYhis',time()).".xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="'.$file_name.'"');

        require "../_CONFIGS/Classes/PATHOLOGIES.php";
        $PATHOLOGIES = new PATHOLOGIES();
        $sous_chapitres = $PATHOLOGIES->lister_sous_chapitres(null);
        $nb_sous_chapitres = count($sous_chapitres);
        if($nb_sous_chapitres != 0) {

            $row = 1;
            $sheet->getStyle('D'.$row.':N'.$row)->applyFromArray($style_titre);
            $sheet->setCellValue('D'.$row, 'REFERENTIEL : PATHOLOGIES SOUS-CHAPITRES');
            $sheet->mergeCells('D'.$row.':N'.($row = $row+2));
            $sheet->getStyle('D1'.':N'.$row)
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

            $row++;
            $sheet->getStyle('A'.$row.':N'.$row)->applyFromArray($style_entete);
            $sheet->mergeCells('D'.$row.':L'.$row);
            $sheet->mergeCells('M'.$row.':N'.$row);
            $sheet->setCellValue('A'.$row, 'N°');
            $sheet->setCellValue('B'.$row, 'CODE');
            $sheet->setCellValue('C'.$row, 'CHAPITRE');
            $sheet->setCellValue('D'.$row, 'LIBELLE');
            $sheet->setCellValue('M'.$row, 'DATE EFFET');
            $ligne = 1;
            foreach ($sous_chapitres as $sous_chapitre) {
                $row++;
                $sheet->getStyle('A'.$row.':N'.$row)->applyFromArray($style_tableau);
                $sheet->mergeCells('D'.$row.':L'.$row);
                $sheet->mergeCells('M'.$row.':N'.$row);
                $sheet->setCellValue('A'.$row, $ligne);
                $sheet->setCellValue('B'.$row, $sous_chapitre['code']);
                $sheet->setCellValue('C'.$row, $sous_chapitre['code_chapitre']);
                $sheet->setCellValue('D'.$row, $sous_chapitre['libelle']);
                $spreadsheet->getActiveSheet()->getStyle('M'.$row)
                    ->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                $sheet->setCellValue('M'.$row, date('d/m/Y',strtotime($sous_chapitre['date_debut'])));
                $ligne++;
            }

            $writer = new Xlsx($spreadsheet);
            $writer->save("php://output");
        }
    }
    elseif ($data == 'pat') {
        $file_name = "EXPORT_PATHOLOGIES_".date('dmYhis',time()).".xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="'.$file_name.'"');

        require "../_CONFIGS/Classes/PATHOLOGIES.php";
        $PATHOLOGIES = new PATHOLOGIES();
        $pathologies = $PATHOLOGIES->lister_pathologies(null);
        $nb_pathologies = count($pathologies);
        if($nb_pathologies != 0) {

            $row = 1;
            $sheet->getStyle('D'.$row.':L'.$row)->applyFromArray($style_titre);
            $sheet->setCellValue('D'.$row, 'REFERENTIEL : PATHOLOGIES');
            $sheet->mergeCells('D'.$row.':L'.($row = $row+2));
            $sheet->getStyle('D1'.':L'.$row)
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

            $row++;
            $sheet->getStyle('A'.$row.':L'.$row)->applyFromArray($style_entete);
            $sheet->mergeCells('C'.$row.':E'.$row);
            $sheet->mergeCells('F'.$row.':H'.$row);
            $sheet->mergeCells('I'.$row.':J'.$row);
            $sheet->mergeCells('K'.$row.':L'.$row);
            $sheet->setCellValue('A'.$row, 'N°');
            $sheet->setCellValue('B'.$row, 'CODE');
            $sheet->setCellValue('C'.$row, 'CHAPITRE');
            $sheet->setCellValue('F'.$row, 'SOUS_CHAPITRE');
            $sheet->setCellValue('I'.$row, 'LIBELLE');
            $sheet->setCellValue('K'.$row, 'DATE EFFET');
            $ligne = 1;
            foreach ($pathologies as $pathologie) {
                $row++;
                $sheet->getStyle('A'.$row.':L'.$row)->applyFromArray($style_tableau);
                $sheet->mergeCells('C'.$row.':E'.$row);
                $sheet->mergeCells('F'.$row.':H'.$row);
                $sheet->mergeCells('I'.$row.':J'.$row);
                $sheet->mergeCells('K'.$row.':L'.$row);
                $sheet->setCellValue('A'.$row, $ligne);
                $sheet->setCellValue('B'.$row, $pathologie['code_chapitre']);
                $sheet->setCellValue('C'.$row, $pathologie['code_chapitre']);
                $sheet->setCellValue('F'.$row, $pathologie['code_sous_chapitre']);
                $sheet->setCellValue('I'.$row, $pathologie['libelle']);
                $spreadsheet->getActiveSheet()->getStyle('K'.$row)
                    ->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                $sheet->setCellValue('K'.$row, date('d/m/Y',strtotime($pathologie['date_debut'])));
                $ligne++;
            }

            $writer = new Xlsx($spreadsheet);
            $writer->save("php://output");
        }
    }
    elseif ($data == 'pat_sch') {
        $file_name = "EXPORT_PHATOLOGIES_SOUS_CHAPITRES_".date('dmYhis',time()).".xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="'.$file_name.'"');

        require "../_CONFIGS/Classes/PATHOLOGIES.php";
        $PATHOLOGIES = new PATHOLOGIES();
        $sous_chapitres = $PATHOLOGIES->lister_sous_chapitres(null);
        $nb_sous_chapitres = count($sous_chapitres);
        if($nb_sous_chapitres != 0) {

            $row = 1;
            $sheet->getStyle('D'.$row.':L'.$row)->applyFromArray($style_titre);
            $sheet->setCellValue('D'.$row, 'PATHOLOGIES :  SOUS CHAPITRES');
            $sheet->mergeCells('D'.$row.':L'.($row = $row+2));
            $sheet->getStyle('D1'.':L'.$row)
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

            $row++;
            $sheet->getStyle('A'.$row.':L'.$row)->applyFromArray($style_entete);
            $sheet->mergeCells('C'.$row.':G'.$row);
            $sheet->mergeCells('H'.$row.':J'.$row);
            $sheet->mergeCells('K'.$row.':L'.$row);
            $sheet->setCellValue('A'.$row, 'N°');
            $sheet->setCellValue('B'.$row, 'CODE');
            $sheet->setCellValue('C'.$row, 'CHAPITRE');
            $sheet->setCellValue('H'.$row, 'LIBELLE');
            $sheet->setCellValue('K'.$row, 'DATE EFFET');
            $ligne = 1;
            foreach ($sous_chapitres as $sous_chapitre ) {
                $row++;
                $sheet->getStyle('A'.$row.':L'.$row)->applyFromArray($style_tableau);
                $sheet->mergeCells('C'.$row.':G'.$row);
                $sheet->mergeCells('H'.$row.':J'.$row);
                $sheet->mergeCells('K'.$row.':L'.$row);
                $sheet->setCellValue('A'.$row, $ligne);
                $sheet->setCellValue('B'.$row, $sous_chapitre['code']);
                $sheet->setCellValue('C'.$row, $sous_chapitre['code_chapitre']);
                $sheet->setCellValue('H'.$row, $sous_chapitre['libelle']);
                $spreadsheet->getActiveSheet()->getStyle('K'.$row)
                    ->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                $sheet->setCellValue('K'.$row, date('d/m/Y',strtotime($sous_chapitre['date_debut'])));
                $ligne++;
            }

            $writer = new Xlsx($spreadsheet);
            $writer->save("php://output");
        }
    }

    //ETABLISSEMENTS

    elseif ($data == 'etab_niveau') {
        $file_name = "EXPORT_ETABLISSEMENTS_NIVEAUX_SANITAIRES_".date('dmYhis',time()).".xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="'.$file_name.'"');

        require "../_CONFIGS/Classes/ETABLISSEMENTS.php";
        $ETABLISSEMENTS = new ACTESMEDICAUX();
        $niveaux = $ETABLISSEMENTS->lister_lettres_cles();
        $nb_niveaux = count($niveaux);
        if($nb_niveaux != 0) {

            $row = 1;
            $sheet->getStyle('D'.$row.':O'.$row)->applyFromArray($style_titre);
            $sheet->setCellValue('D'.$row, 'ETABLISSEMENTS : NIVEAUX SANITAIRES');
            $sheet->mergeCells('D'.$row.':O'.($row = $row+2));
            $sheet->getStyle('D1'.':O'.$row)
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

            $row++;
            $sheet->getStyle('A'.$row.':O'.$row)->applyFromArray($style_entete);
            $sheet->mergeCells('C'.$row.':J'.$row);
            $sheet->mergeCells('K'.$row.':M'.$row);
            $sheet->mergeCells('N'.$row.':O'.$row);
            $sheet->setCellValue('A'.$row, 'N°');
            $sheet->setCellValue('B'.$row, 'CODE');
            $sheet->setCellValue('C'.$row, 'LIBELLE');
            $sheet->setCellValue('k'.$row, 'NIVEAU');
            $sheet->setCellValue('N'.$row, 'DATE EFFET');
            $ligne = 1;
            foreach ($niveaux as $niveau) {
                $row++;
                $sheet->getStyle('A'.$row.':O'.$row)->applyFromArray($style_tableau);
                $sheet->mergeCells('C'.$row.':J'.$row);
                $sheet->mergeCells('K'.$row.':M'.$row);
                $sheet->mergeCells('N'.$row.':O'.$row);
                $sheet->setCellValue('A'.$row, $ligne);
                $sheet->setCellValue('B'.$row, $niveau['code']);
                $sheet->setCellValue('C'.$row, $niveau['libelle']);
                $sheet->setCellValue('K'.$row, $niveau['niveau']);
                $spreadsheet->getActiveSheet()->getStyle('N'.$row)
                    ->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                $sheet->setCellValue('N'.$row, date('d/m/Y',strtotime($niveau['date_debut'])));
                $ligne++;
            }

            $writer = new Xlsx($spreadsheet);
            $writer->save("php://output");
        }
    }

    else {
        echo '<p align="center">Cette donnée n\'est pas prise en charge pour l\'export.</p>';
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


    //PATHOLOGIES
    if ($data == 'pat_chap') {
            $file_name = "EXPORT_PATHOLOGIES_CHAPITRES_".date('dmYhis',time()).".pdf";
        $pdf->SetTitle($file_name);

        require "../_CONFIGS/Classes/PATHOLOGIES.php";
        $PATHOLOGIES = new PATHOLOGIES();
        $chapitres = $PATHOLOGIES->lister_chapitres();
        $nb_chapitres = count($chapitres);
        if($nb_chapitres != 0) {
            $pdf->AddPage('L');
            $pdf->Image(IMAGES.'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);

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
                $pdf->MultiCell(20, 5, date('d/m/Y',strtotime($chapitre['date_debut'])), 1, 'C', 1, 1, '', '', true);
                $ligne++;
            }

        }
            $pdf->Output($file_name, 'I');
        }
    elseif ($data == 'pat_sch') {
        $file_name = "EXPORT_PATHOLOGIES_SOUS_CHAPITRES_".date('dmYhis',time()).".pdf";
        $pdf->SetTitle($file_name);

        require "../_CONFIGS/Classes/PATHOLOGIES.php";
        $PATHOLOGIES = new PATHOLOGIES();
        $sous_chapitres = $PATHOLOGIES->lister_sous_chapitres(null);
        $nb_sous_chapitres = count($sous_chapitres);
        if($nb_sous_chapitres != 0) {
            $pdf->AddPage('L');
            $pdf->Image(IMAGES.'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);

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
                $pdf->MultiCell(20, 5, date('d/m/Y',strtotime($sous_chapitre['date_debut'])), 1, 'C', 1, 1, '', '', true);
                $ligne++;
            }

        }
        $pdf->Output($file_name, 'I');
    }
    elseif ($data == 'pat') {
        $file_name = "EXPORT_PATHOLOGIES_".date('dmYhis',time()).".pdf";
        $pdf->SetTitle($file_name);

        require "../_CONFIGS/Classes/PATHOLOGIES.php";
        $PATHOLOGIES = new PATHOLOGIES();
        $pathologies = $PATHOLOGIES->lister_pathologies(null);
        $nb_pathologies = count($pathologies);
        if($nb_pathologies != 0) {
            $pdf->AddPage('L');
            $pdf->Image(IMAGES.'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);

            $pdf->writeHTMLCell(0, 0, 50, 15, '<h1>REFERENTIEL :<br />PATHOLOGIES</h1>', 0, 1, 0, true, 'C', true);
            $pdf->setCellPaddings(1, 1, 1, 1);
            $pdf->MultiCell(10, 15, NULL, 0, 'L', 1, 1, '', '', true);


            $pdf->SetFillColor(128, 128, 128);
            $pdf->SetFont('helvetica', 'B', 8, '', true);
            $pdf->MultiCell(10, 5, 'N°', 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(50, 5, 'CODE', 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(100, 5, 'LIBELLE', 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(50, 5, 'CHAPITRE', 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(50, 5, 'SOUS CHAPITRE', 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(20, 5, 'DATE EFFET', 1, 'L', 1, 1, '', '', true);
            $pdf->SetFont('helvetica', '', 8, '', true);
            $pdf->SetFillColor(255, 255, 255);
            $ligne = 1;
            foreach ($pathologies as $pathologie) {
                $pdf->SetFont('helvetica', 'B', 8, '', true);
                $pdf->MultiCell(10, 5, $ligne, 1, 'R', 1, 0, '', '', true);
                $pdf->MultiCell(50, 5, $pathologie['code'], 1, 'L', 1, 0, '', '', true);
                $pdf->MultiCell(100, 5, $pathologie['libelle'], 1, 'L', 1, 0, '', '', true);
                $pdf->MultiCell(50, 5, $pathologie['code_chapitre'], 1, 'L', 1, 0, '', '', true);
                $pdf->MultiCell(50, 5, $pathologie['code_sous_chapitre'], 1, 'L', 1, 0, '', '', true);
                $pdf->MultiCell(20, 5, date('d/m/Y',strtotime($pathologie['date_debut'])), 1, 'C', 1, 1, '', '', true);
                $ligne++;
            }

        }
        $pdf->Output($file_name, 'I');
    }

    //ACTES MEDICAUX

    elseif ($data == 'act_med') {
        $pdf->AddPage('L');
        $pdf->Image(IMAGES.'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);

        $file_name = "EXPORT_ACTES_MEDICAUX".date('dmYhis',time()).".pdf";
        $pdf->SetTitle($file_name);
        require "../_CONFIGS/Classes/ACTESMEDICAUX.php";
        $ACTESMEDICAUX = new ACTESMEDICAUX();
        $actesmedicaux = $ACTESMEDICAUX->lister_actes_medicaux(null);
        $nb_communes = count($actesmedicaux);
        if($nb_communes != 0) {
            $pdf->writeHTMLCell(0, 0, 50, 15, '<h1>TABLE DE VALEUR:<br />ACTES MEDICAUX</h1>', 0, 1, 0, true, 'C', true);
            $pdf->setCellPaddings(1, 1, 1, 1);
            $pdf->MultiCell(10, 15, NULL, 0, 'L', 1, 1, '', '', true);

            $pdf->SetFillColor(128, 128, 128);
            $pdf->SetFont('helvetica', 'B', 8, '', true);
            $pdf->MultiCell(10, 5, 'N°', 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(15, 5, 'CODE', 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(40, 5, 'NOM', 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(50, 5, 'TITRE', 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(50, 5, 'CHAPITRE', 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(50, 5, 'SECTION', 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(40, 5, 'ARTICLE', 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(20, 5, 'DATE EFFET', 1, 'L', 1, 1, '', '', true);
            $pdf->SetFont('helvetica', '', 8, '', true);
            $pdf->SetFillColor(255, 255, 255);
            $ligne = 1;
            foreach ($actesmedicaux as $actemedical) {
                $pdf->SetFont('helvetica', 'B', 8, '', true);
                $pdf->MultiCell(10, 5, $ligne, 1, 'R', 1, 0, '', '', true);
                $pdf->MultiCell(15, 5, $actemedical['code'], 1, 'L', 1, 0, '', '', true);
                $pdf->MultiCell(40, 5, $actemedical['libelle'], 1, 'L', 1, 0, '', '', true);
                $pdf->MultiCell(50, 5, $actemedical['titre_code'], 1, 'L', 1, 0, '', '', true);
                $pdf->MultiCell(50, 5, $actemedical['chapitre_code'], 1, 'L', 1, 0, '', '', true);
                $pdf->MultiCell(50, 5, $actemedical['section_code'], 1, 'L', 1, 0, '', '', true);
                $pdf->MultiCell(40, 5, $actemedical['article_code'], 1, 'L', 1, 0, '', '', true);
                $pdf->MultiCell(20, 5, date('d/m/Y',strtotime($actemedical['date_debut'])), 1, 'C', 1, 1, '', '', true);
                $ligne++;
            }

        }
        $pdf->Output($file_name, 'I');
    }
    elseif ($data == 'act_art') {
        $pdf->AddPage('L');
        $pdf->Image(IMAGES.'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);

        $file_name = "EXPORT_ACTES_MEDICAUX_ARTICLES_".date('dmYhis',time()).".pdf";
        $pdf->SetTitle($file_name);
        require "../_CONFIGS/Classes/ACTESMEDICAUX.php";
        $ACTESMEDICAUX = new ACTESMEDICAUX();
        $articles = $ACTESMEDICAUX->lister_articles(null);
        $nb_articles = count($articles);
        if($nb_articles != 0) {
            $pdf->writeHTMLCell(0, 0, 50, 15, '<h1>TABLE DE VALEUR:<br />ARTICLES</h1>', 0, 1, 0, true, 'C', true);
            $pdf->setCellPaddings(1, 1, 1, 1);
            $pdf->MultiCell(10, 15, NULL, 0, 'L', 1, 1, '', '', true);

            $pdf->SetFillColor(128, 128, 128);
            $pdf->SetFont('helvetica', 'B', 8, '', true);
            $pdf->MultiCell(10, 5, 'N°', 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(20, 5, 'CODE', 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(50, 5, 'TITRE', 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(60, 5, 'CHAPITRE', 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(60, 5, 'SECTIONS', 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(45, 5, 'NOM', 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(30, 5, 'DATE EFFET', 1, 'L', 1, 1, '', '', true);
            $pdf->SetFont('helvetica', '', 8, '', true);
            $pdf->SetFillColor(255, 255, 255);
            $ligne = 1;
            foreach ($articles as $article) {
                $pdf->SetFont('helvetica', 'B', 8, '', true);
                $pdf->MultiCell(10, 5, $ligne, 1, 'R', 1, 0, '', '', true);
                $pdf->MultiCell(20, 5, $article['code'], 1, 'L', 1, 0, '', '', true);
                $pdf->MultiCell(50, 5, $article['titre_libelle'], 1, 'L', 1, 0, '', '', true);
                $pdf->MultiCell(60, 5, $article['chapitre_libelle'], 1, 'L', 1, 0, '', '', true);
                $pdf->MultiCell(60, 5, $article['section_libelle'], 1, 'L', 1, 0, '', '', true);
                $pdf->MultiCell(45, 5,$article['libelle'], 1, 'L', 1, 0, '', '', true);
                $pdf->MultiCell(30, 5, date('d/m/Y',strtotime($article['date_debut'])), 1, 'C', 1, 1, '', '', true);
                $ligne++;
            }

        }
        $pdf->Output($file_name, 'I');
    }
    elseif ($data == 'act_cha') {
        $file_name = "EXPORT_ACTES_MEDICAUX_CHAPITRES_".date('dmYhis',time()).".pdf";
        $pdf->SetTitle($file_name);

        require "../_CONFIGS/Classes/ACTESMEDICAUX.php";
        $ACTESMEDICAUX = new ACTESMEDICAUX();
        $actesmedicaux = $ACTESMEDICAUX->lister_chapitres(null);
        $nb_pathologies = count($actesmedicaux);
        if($nb_pathologies != 0) {
            $pdf->AddPage('L');
            $pdf->Image(IMAGES.'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);

            $pdf->writeHTMLCell(0, 0, 50, 15, '<h1>REFERENTIEL :<br />  CHAPITRES</h1>', 0, 1, 0, true, 'C', true);
            $pdf->setCellPaddings(1, 1, 1, 1);
            $pdf->MultiCell(10, 15, NULL, 0, 'L', 1, 1, '', '', true);


            $pdf->SetFillColor(128, 128, 128);
            $pdf->SetFont('helvetica', 'B', 8, '', true);
            $pdf->MultiCell(10, 5, 'N°', 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(30, 5, 'CODE', 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(220, 5, 'LIBELLE', 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(20, 5, 'DATE EFFET', 1, 'L', 1, 1, '', '', true);
            $pdf->SetFont('helvetica', '', 8, '', true);
            $pdf->SetFillColor(255, 255, 255);
            $ligne = 1;
            foreach ($actesmedicaux as $actemedical) {
                $pdf->SetFont('helvetica', 'B', 8, '', true);
                $pdf->MultiCell(10, 5, $ligne, 1, 'R', 1, 0, '', '', true);
                $pdf->MultiCell(30, 5, $actemedical['code'], 1, 'L', 1, 0, '', '', true);
                $pdf->MultiCell(220, 5, $actemedical['libelle'], 1, 'L', 1, 0, '', '', true);
                $pdf->MultiCell(20, 5, date('d/m/Y',strtotime($actemedical['date_debut'])), 1, 'C', 1, 1, '', '', true);
                $ligne++;
            }

        }
        $pdf->Output($file_name, 'I');
    }
    elseif ($data == 'act_sec') {
        $file_name = "EXPORT_ACTES_MEDICAUX_SECTIONS_".date('dmYhis',time()).".csv";
        $pdf->SetTitle($file_name);

        require "../_CONFIGS/Classes/ACTESMEDICAUX.php";
        $ACTESMEDICAUX = new ACTESMEDICAUX();
        $sections = $ACTESMEDICAUX->lister_sections(null);
        $nb_sections = count($sections);
        if($nb_sections != 0) {
            $pdf->AddPage('L');
            $pdf->Image(IMAGES.'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);

            $pdf->writeHTMLCell(0, 0, 50, 15, '<h1>REFERENTIEL :<br />SECTIONS</h1>', 0, 1, 0, true, 'C', true);
            $pdf->setCellPaddings(1, 1, 1, 1);
            $pdf->MultiCell(10, 15, NULL, 0, 'L', 1, 1, '', '', true);


            $pdf->SetFillColor(128, 128, 128);
            $pdf->SetFont('helvetica', 'B', 8, '', true);
            $pdf->MultiCell(10, 5, 'N°', 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(50, 5, 'CODE', 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(100, 5, 'LIBELLE', 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(50, 5, 'TITRE', 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(50, 5, 'CHAPITRE', 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(20, 5, 'DATE EFFET', 1, 'L', 1, 1, '', '', true);
            $pdf->SetFont('helvetica', '', 8, '', true);
            $pdf->SetFillColor(255, 255, 255);
            $ligne = 1;
            foreach ($sections as $section) {
                $pdf->SetFont('helvetica', 'B', 8, '', true);
                $pdf->MultiCell(10, 5, $ligne, 1, 'R', 1, 0, '', '', true);
                $pdf->MultiCell(50, 5, $section['code'], 1, 'L', 1, 0, '', '', true);
                $pdf->MultiCell(100, 5, $section['libelle'], 1, 'L', 1, 0, '', '', true);
                $pdf->MultiCell(50, 5, $section['titre_code'], 1, 'L', 1, 0, '', '', true);
                $pdf->MultiCell(50, 5, $section['code_chapitre'], 1, 'L', 1, 0, '', '', true);
                $pdf->MultiCell(20, 5, date('d/m/Y',strtotime($section['date_debut'])), 1, 'C', 1, 1, '', '', true);
                $ligne++;
            }
        }
        $pdf->Output($file_name, 'I');
    }
    elseif ($data == 'let_cle') {
            $file_name = "EXPORT_ACTES_MEDICAUX_LETTRES_CLES_".date('dmYhis',time()).".pdf";
        $pdf->SetTitle($file_name);

        require "../_CONFIGS/Classes/ACTESMEDICAUX.php";
        $ACTESMEDICAUX = new ACTESMEDICAUX();
        $actesmedicaux = $ACTESMEDICAUX->lister_lettres_cles();
        $nb_pathologies = count($actesmedicaux);
        if($nb_pathologies != 0) {
            $pdf->AddPage('L');
            $pdf->Image(IMAGES.'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);

            $pdf->writeHTMLCell(0, 0, 50, 15, '<h1>REFERENTIEL :<br />LETTRES CLES</h1>', 0, 1, 0, true, 'C', true);
            $pdf->setCellPaddings(1, 1, 1, 1);
            $pdf->MultiCell(10, 15, NULL, 0, 'L', 1, 1, '', '', true);


            $pdf->SetFillColor(128, 128, 128);
            $pdf->SetFont('helvetica', 'B', 8, '', true);
            $pdf->MultiCell(10, 5, 'N°', 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(100, 5, 'CODE', 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(100, 5, 'LIBELLE', 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(50, 5, 'PRIX UNITAIRE', 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(20, 5, 'DATE EFFET', 1, 'L', 1, 1, '', '', true);
            $pdf->SetFont('helvetica', '', 8, '', true);
            $pdf->SetFillColor(255, 255, 255);
            $ligne = 1;
            foreach ($actesmedicaux as $actemedical) {
                $pdf->SetFont('helvetica', 'B', 8, '', true);
                $pdf->MultiCell(10, 5, $ligne, 1, 'R', 1, 0, '', '', true);
                $pdf->MultiCell(100, 5, $actemedical['code'], 1, 'L', 1, 0, '', '', true);
                $pdf->MultiCell(100, 5, $actemedical['libelle'], 1, 'L', 1, 0, '', '', true);
                $pdf->MultiCell(50, 5, $actemedical['prix_unitaire'].' FCFA', 1, 'L', 1, 0, '', '', true);
                $pdf->MultiCell(20, 5, date('d/m/Y',strtotime($actemedical['date_debut'])), 1, 'C', 1, 1, '', '', true);
                $ligne++;
            }

        }
            $pdf->Output($file_name, 'I');
        }
    elseif ($data == 'act_tit') {
            $file_name = "EXPORT_ACTES_MEDICAUX_TITRES_".date('dmYhis',time()).".pdf";
        $pdf->SetTitle($file_name);

        require "../_CONFIGS/Classes/ACTESMEDICAUX.php";
        $ACTESMEDICAUX = new ACTESMEDICAUX();
        $actesmedicaux = $ACTESMEDICAUX->lister_titres();
        $nb_pathologies = count($actesmedicaux);
        if($nb_pathologies != 0) {
            $pdf->AddPage('L');
            $pdf->Image(IMAGES.'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);

            $pdf->writeHTMLCell(0, 0, 50, 15, '<h1>REFERENTIEL :<br />TITRES</h1>', 0, 1, 0, true, 'C', true);
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
            foreach ($actesmedicaux as $actemedical) {
                $pdf->SetFont('helvetica', 'B', 8, '', true);
                $pdf->MultiCell(10, 5, $ligne, 1, 'R', 1, 0, '', '', true);
                $pdf->MultiCell(100, 5, $actemedical['code_titre'], 1, 'L', 1, 0, '', '', true);
                $pdf->MultiCell(150, 5, $actemedical['libelle'], 1, 'L', 1, 0, '', '', true);
                $pdf->MultiCell(20, 5, date('d/m/Y',strtotime($actemedical['date_debut'])), 1, 'C', 1, 1, '', '', true);
                $ligne++;
            }

        }
            $pdf->Output($file_name, 'I');
        }


    //MEDICAMENTS
    elseif ($data == 'med_lab') {
            $file_name = "EXPORT_MEDICAMENTS_LABORATOIRES_PHARMACEUTIQUES_".date('dmYhis',time()).".pdf";
        $pdf->SetTitle($file_name);

        require "../_CONFIGS/Classes/MEDICAMENTS.php";
        $LABORATOIRES = new MEDICAMENTS();
        $laboratoires = $LABORATOIRES->lister_laboratoires_pharmaceutiques();
        $nb_laboratoires = count($laboratoires);
        if($nb_laboratoires != 0) {
            $pdf->AddPage('L');
            $pdf->Image(IMAGES.'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);

            $pdf->writeHTMLCell(0, 0, 50, 15, '<h1>REFERENTIEL :<br />LABORATOIRES PHARMACEUTIQUES</h1>', 0, 1, 0, true, 'C', true);
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
            foreach ($laboratoires as $laboratoire) {
                $pdf->SetFont('helvetica', 'B', 8, '', true);
                $pdf->MultiCell(10, 5, $ligne, 1, 'R', 1, 0, '', '', true);
                $pdf->MultiCell(100, 5, $laboratoire['code'], 1, 'L', 1, 0, '', '', true);
                $pdf->MultiCell(150, 5, $laboratoire['libelle'], 1, 'L', 1, 0, '', '', true);
                $pdf->MultiCell(20, 5, date('d/m/Y',strtotime($laboratoire['date_debut'])), 1, 'C', 1, 1, '', '', true);
                $ligne++;
            }

        }
            $pdf->Output($file_name, 'I');
        }
    elseif ($data == 'med') {
        $pdf->AddPage('L');
        $pdf->Image(IMAGES.'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);

        $file_name = "EXPORT_MEDICAMENTS_".date('dmYhis',time()).".pdf";
        $pdf->SetTitle($file_name);
        require "../_CONFIGS/Classes/MEDICAMENTS.php";
        $MEDICAMENTS = new MEDICAMENTS();
        $medicaments = $MEDICAMENTS->lister_medicaments();
        $nb_medicaments = count($medicaments);
        if($nb_medicaments != 0) {
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
                $pdf->MultiCell(40, 5, $medicament['dosage'].' '.$medicament['code_unite_dosage'], 1, 'L', 1, 0, '', '', true);
                $pdf->MultiCell(40, 5, date('d/m/Y',strtotime($medicament['date_debut'])), 1, 'C', 1, 1, '', '', true);
                $ligne++;
            }

        }
        $pdf->Output($file_name, 'I');
    }

    elseif ($data == 'med_pre') {
            $file_name = "EXPORT_MEDICAMENTS_PRESENTATIONS_".date('dmYhis',time()).".pdf";
        $pdf->SetTitle($file_name);

        require "../_CONFIGS/Classes/MEDICAMENTS.php";
        $PRESENTAIONS = new MEDICAMENTS();
        $presentations = $PRESENTAIONS->lister_presentations();
        $nb_presentations = count($presentations);
        if($nb_presentations != 0) {
            $pdf->AddPage('L');
            $pdf->Image(IMAGES.'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);

            $pdf->writeHTMLCell(0, 0, 50, 15, '<h1>REFERENTIEL :<br />PRESENTATIONS</h1>', 0, 1, 0, true, 'C', true);
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
            foreach ($presentations as $presentation) {
                $pdf->SetFont('helvetica', 'B', 8, '', true);
                $pdf->MultiCell(10, 5, $ligne, 1, 'R', 1, 0, '', '', true);
                $pdf->MultiCell(100, 5, $presentation['code'], 1, 'L', 1, 0, '', '', true);
                $pdf->MultiCell(150, 5, $presentation['libelle'], 1, 'L', 1, 0, '', '', true);
                $pdf->MultiCell(20, 5, date('d/m/Y',strtotime($presentation['date_debut'])), 1, 'C', 1, 1, '', '', true);
                $ligne++;
            }

        }
            $pdf->Output($file_name, 'I');
        }
    elseif ($data == 'med_ffm') {
            $file_name = "EXPORT_MEDICAMENTS_FAMILLES_DE_FORMES_".date('dmYhis',time()).".pdf";
        $pdf->SetTitle($file_name);

        require "../_CONFIGS/Classes/MEDICAMENTS.php";
        $FAMILLESFORMES = new MEDICAMENTS();
        $famillesformes = $FAMILLESFORMES->lister_familles_formes();
        $nb_famillesformes = count($famillesformes);
        if($nb_famillesformes != 0) {
            $pdf->AddPage('L');
            $pdf->Image(IMAGES.'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);

            $pdf->writeHTMLCell(0, 0, 50, 15, '<h1>REFERENTIEL :<br />FAMILLES DE FORMES</h1>', 0, 1, 0, true, 'C', true);
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
            foreach ($famillesformes as $familleforme) {
                $pdf->SetFont('helvetica', 'B', 8, '', true);
                $pdf->MultiCell(10, 5, $ligne, 1, 'R', 1, 0, '', '', true);
                $pdf->MultiCell(100, 5, $familleforme['code'], 1, 'L', 1, 0, '', '', true);
                $pdf->MultiCell(150, 5, $familleforme['libelle'], 1, 'L', 1, 0, '', '', true);
                $pdf->MultiCell(20, 5, date('d/m/Y',strtotime($familleforme['date_debut'])), 1, 'C', 1, 1, '', '', true);
                $ligne++;
            }

        }
            $pdf->Output($file_name, 'I');
        }
    elseif ($data == 'med_frm') {
            $file_name = "EXPORT_MEDICAMENTS__FORMES_".date('dmYhis',time()).".pdf";
        $pdf->SetTitle($file_name);

        require "../_CONFIGS/Classes/MEDICAMENTS.php";
        $FORMES = new MEDICAMENTS();
        $formes = $FORMES->lister_formes();
        $nb_formes = count($formes);
        if($nb_formes != 0) {
            $pdf->AddPage('L');
            $pdf->Image(IMAGES.'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);

            $pdf->writeHTMLCell(0, 0, 50, 15, '<h1>REFERENTIEL :<br /> FORMES</h1>', 0, 1, 0, true, 'C', true);
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
            foreach ($formes as $forme) {
                $pdf->SetFont('helvetica', 'B', 8, '', true);
                $pdf->MultiCell(10, 5, $ligne, 1, 'R', 1, 0, '', '', true);
                $pdf->MultiCell(100, 5, $forme['code'], 1, 'L', 1, 0, '', '', true);
                $pdf->MultiCell(150, 5, $forme['libelle'], 1, 'L', 1, 0, '', '', true);
                $pdf->MultiCell(20, 5, date('d/m/Y',strtotime($forme['date_debut'])), 1, 'C', 1, 1, '', '', true);
                $ligne++;
            }

        }
            $pdf->Output($file_name, 'I');
        }
    elseif ($data == 'med_typ') {
            $file_name = "EXPORT_MEDICAMENTS_TYPES_DE_MEDICAMENTS_".date('dmYhis',time()).".pdf";
        $pdf->SetTitle($file_name);

        require "../_CONFIGS/Classes/MEDICAMENTS.php";
        $TYPESMEDICAMENTS = new MEDICAMENTS();
        $typesmedicaments = $TYPESMEDICAMENTS->lister_types_medicaments();
        $nb_typesmedicaments = count($typesmedicaments);
        if($nb_typesmedicaments != 0) {
            $pdf->AddPage('L');
            $pdf->Image(IMAGES.'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);

            $pdf->writeHTMLCell(0, 0, 50, 15, '<h1>REFERENTIEL :<br />TYPES DE MEDICAMENTS</h1>', 0, 1, 0, true, 'C', true);
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
            foreach ($typesmedicaments as $typemedicament) {
                $pdf->SetFont('helvetica', 'B', 8, '', true);
                $pdf->MultiCell(10, 5, $ligne, 1, 'R', 1, 0, '', '', true);
                $pdf->MultiCell(100, 5, $typemedicament['code'], 1, 'L', 1, 0, '', '', true);
                $pdf->MultiCell(150, 5, $typemedicament['libelle'], 1, 'L', 1, 0, '', '', true);
                $pdf->MultiCell(20, 5, date('d/m/Y',strtotime($typemedicament['date_debut'])), 1, 'C', 1, 1, '', '', true);
                $ligne++;
            }

        }
            $pdf->Output($file_name, 'I');
        }
    elseif ($data == 'med_cth') {
            $file_name = "EXPORT_MEDICAMENTS_CLASSES_THERAPEUTHIQUES_".date('dmYhis',time()).".pdf";
        $pdf->SetTitle($file_name);

        require "../_CONFIGS/Classes/MEDICAMENTS.php";
        $CLASSESTHERAPEUTHIUE = new MEDICAMENTS();
        $classestherapeuthiques = $CLASSESTHERAPEUTHIUE->lister_classes_therapeutiques();
        $nb_classestherapeutiques = count($classestherapeuthiques);
        if($nb_classestherapeutiques != 0) {
            $pdf->AddPage('L');
            $pdf->Image(IMAGES.'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);

            $pdf->writeHTMLCell(0, 0, 50, 15, '<h1>REFERENTIEL :<br />CLASSES THERAPEUTHIQUES</h1>', 0, 1, 0, true, 'C', true);
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
            foreach ($classestherapeuthiques as $classetherapeuthique) {
                $pdf->SetFont('helvetica', 'B', 8, '', true);
                $pdf->MultiCell(10, 5, $ligne, 1, 'R', 1, 0, '', '', true);
                $pdf->MultiCell(100, 5, $classetherapeuthique['code'], 1, 'L', 1, 0, '', '', true);
                $pdf->MultiCell(150, 5, $classetherapeuthique['libelle'], 1, 'L', 1, 0, '', '', true);
                $pdf->MultiCell(20, 5, date('d/m/Y',strtotime($classetherapeuthique['date_debut'])), 1, 'C', 1, 1, '', '', true);
                $ligne++;
            }

        }
            $pdf->Output($file_name, 'I');
        }
    elseif ($data == 'med_fra') {
            $file_name = "EXPORT_MEDICAMENTS_FORMES_ADMINISTRATIONS_".date('dmYhis',time()).".pdf";
        $pdf->SetTitle($file_name);

        require "../_CONFIGS/Classes/MEDICAMENTS.php";
        $FORMESADMINISTRATIONS = new MEDICAMENTS();
        $formesadministrations = $FORMESADMINISTRATIONS->lister_formes_administrations();
        $nb_formesadministrations = count($formesadministrations);
        if($nb_formesadministrations != 0) {
            $pdf->AddPage('L');
            $pdf->Image(IMAGES.'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);

            $pdf->writeHTMLCell(0, 0, 50, 15, '<h1>REFERENTIEL :<br />FORMES D\'ADMINISTRATIONS</h1>', 0, 1, 0, true, 'C', true);
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
            foreach ($formesadministrations as $formeadministration) {
                $pdf->SetFont('helvetica', 'B', 8, '', true);
                $pdf->MultiCell(10, 5, $ligne, 1, 'R', 1, 0, '', '', true);
                $pdf->MultiCell(100, 5, $formeadministration['code'], 1, 'L', 1, 0, '', '', true);
                $pdf->MultiCell(150, 5, $formeadministration['libelle'], 1, 'L', 1, 0, '', '', true);
                $pdf->MultiCell(20, 5, date('d/m/Y',strtotime($formeadministration['date_debut'])), 1, 'C', 1, 1, '', '', true);
                $ligne++;
            }

        }
            $pdf->Output($file_name, 'I');
        }
    elseif ($data == 'med_unt') {
            $file_name = "EXPORT_MEDICAMENTS_UNITES_DE_DOSAGES_".date('dmYhis',time()).".pdf";
        $pdf->SetTitle($file_name);

        require "../_CONFIGS/Classes/MEDICAMENTS.php";
        $UNITESDOSAGES = new MEDICAMENTS();
         $unitesdosages= $UNITESDOSAGES->lister_unites_dosages();
        $nb_unitesdosages = count($unitesdosages);
        if($nb_unitesdosages != 0) {
            $pdf->AddPage('L');
            $pdf->Image(IMAGES.'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);

            $pdf->writeHTMLCell(0, 0, 50, 15, '<h1>REFERENTIEL :<br />UNITES DE DOSGAES</h1>', 0, 1, 0, true, 'C', true);
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
            foreach ($unitesdosages as $unitedosage) {
                $pdf->SetFont('helvetica', 'B', 8, '', true);
                $pdf->MultiCell(10, 5, $ligne, 1, 'R', 1, 0, '', '', true);
                $pdf->MultiCell(100, 5, $unitedosage['code'], 1, 'L', 1, 0, '', '', true);
                $pdf->MultiCell(150, 5, $unitedosage['libelle'], 1, 'L', 1, 0, '', '', true);
                $pdf->MultiCell(20, 5, date('d/m/Y',strtotime($unitedosage['date_debut'])), 1, 'C', 1, 1, '', '', true);
                $ligne++;
            }

        }
            $pdf->Output($file_name, 'I');
        }
    elseif ($data == 'med_dci') {
        $file_name = "EXPORT_MEDICAMENTS_DCI_".date('dmYhis',time()).".pdf";
        $pdf->SetTitle($file_name);

        require "../_CONFIGS/Classes/MEDICAMENTS.php";
        $DCI = new MEDICAMENTS();
        $denominations_communes_internationales= $DCI->lister_dci();
        $nb_dci = count($denominations_communes_internationales);
        if($nb_dci != 0) {
            $pdf->AddPage('L');
            $pdf->Image(IMAGES.'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);

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
            foreach ($denominations_communes_internationales as $denomination_commune_internationale) {
                $pdf->SetFont('helvetica', 'B', 8, '', true);
                $pdf->MultiCell(10, 5, $ligne, 1, 'R', 1, 0, '', '', true);
                $pdf->MultiCell(50, 5, $denomination_commune_internationale['code'], 1, 'L', 1, 0, '', '', true);
                $pdf->MultiCell(50, 5, $denomination_commune_internationale['dosage'].$denomination_commune_internationale['code_unite'], 1, 'L', 1, 0, '', '', true);
                $pdf->MultiCell(50, 5, $denomination_commune_internationale['code_forme'], 1, 'L', 1, 0, '', '', true);
                $pdf->MultiCell(100, 5, $denomination_commune_internationale['libelle'], 1, 'L', 1, 0, '', '', true);
                $pdf->MultiCell(20, 5, date('d/m/Y',strtotime($denomination_commune_internationale['date_debut'])), 1, 'C', 1, 1, '', '', true);
                $ligne++;
            }

        }
        $pdf->Output($file_name, 'I');
    }

    //ETABLISSEMENTS

    elseif ($data == 'etab_niveau') {
        $file_name = "EXPORT_ETABLISSEMENTS_NIVEAUX_SANITAIRES_".date('dmYhis',time()).".pdf";
        $pdf->SetTitle($file_name);

        require "../_CONFIGS/Classes/ETABLISSEMENTS.php";
        $ETABLISSEMENTS = new ETABLISSEMENTS();
        $niveaux = $ETABLISSEMENTS->lister_lettres_cles();
        $nb_niveaux = count($niveaux);
        if($nb_niveaux != 0) {
            $pdf->AddPage('L');
            $pdf->Image(IMAGES.'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);

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
                $pdf->MultiCell(20, 5, date('d/m/Y',strtotime($niveau['date_debut'])), 1, 'C', 1, 1, '', '', true);
                $ligne++;
            }

        }
        $pdf->Output($file_name, 'I');
    }

    else {
        echo '<p align="center">Cette donnée n\'est pas prise en charge pour l\'export.</p>';
    }
}
elseif($type == 'txt') {

    //PATHOLOGIES
    if($data == 'pat_chap') {
        require "../_CONFIGS/Classes/PATHOLOGIES.php";
        $PATHOLOGIES = new PATHOLOGIES();
        $chapitres = $PATHOLOGIES->lister_chapitres();
        $nb_chapitres = count($chapitres);
        if($nb_chapitres != 0) {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="EXPORT_PATHOLOGIES_CHAPITRES_'.date('dmYhis',time()).'.txt"');

            $fp = fopen('php://output', 'wb');
            fwrite($fp, str_pad("CODE",7,' ',STR_PAD_RIGHT)."\t\t\t".str_pad("LIBELLE",100,' ',STR_PAD_RIGHT)."\t\t\t".str_pad("DATE EFFET",10,' ',STR_PAD_RIGHT)."\n");
            foreach ($chapitres as $chapitre) {
                fwrite($fp, str_pad($chapitre['code'],7,' ',STR_PAD_RIGHT)."\t\t\t".str_pad($chapitre['libelle'],100,' ',STR_PAD_RIGHT)."\t\t\t".str_pad(date('d/m/Y',strtotime($chapitre['date_debut'])),10,' ',STR_PAD_RIGHT)."\n");
            }
            fclose($fp);
        }
    }
    elseif($data == 'pat_sch') {
        require "../_CONFIGS/Classes/PATHOLOGIES.php";
        $PATHOLOGIES = new PATHOLOGIES();
        $sous_chapitres = $PATHOLOGIES->lister_sous_chapitres(null);
        $nb_sous_chapitres = count($sous_chapitres);
        if($nb_sous_chapitres != 0) {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="EXPORT_PATHOLOGIES_SOUS_CHAPITRES_'.date('dmYhis',time()).'.txt"');

            $fp = fopen('php://output', 'wb');
            fwrite($fp, str_pad("CODE",7,' ',STR_PAD_RIGHT)."\t\t\t".str_pad("CHAPITRE",7,' ',STR_PAD_RIGHT)."\t\t\t".str_pad("LIBELLE",100,' ',STR_PAD_RIGHT)."\t\t\t".str_pad("DATE EFFET",10,' ',STR_PAD_RIGHT)."\n");
            foreach ($sous_chapitres as $sous_chapitre) {
                fwrite($fp, str_pad($sous_chapitre['code'],7,' ',STR_PAD_RIGHT)."\t\t\t".str_pad($sous_chapitre['code_chapitre'],7,' ',STR_PAD_RIGHT)."\t\t\t".str_pad($sous_chapitre['libelle'],100,' ',STR_PAD_RIGHT)."\t\t\t".str_pad(date('d/m/Y',strtotime($sous_chapitre['date_debut'])),10,' ',STR_PAD_RIGHT)."\n");
            }
            fclose($fp);
        }
    }
    elseif($data == 'pat') {
        require "../_CONFIGS/Classes/PATHOLOGIES.php";
        $PATHOLOGIES = new PATHOLOGIES();
        $pathologies = $PATHOLOGIES->lister_pathologies(null);
        $nb_pathologies = count($pathologies);
        if($nb_pathologies != 0) {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="EXPORT_PATHOLOGIES_'.date('dmYhis',time()).'.txt"');

            $fp = fopen('php://output', 'wb');
            fwrite($fp, str_pad("CODE",3,' ',STR_PAD_RIGHT)."\t\t\t".str_pad("LIBELLE",100,' ',STR_PAD_RIGHT)."\t\t\t".str_pad(" CHAPITRE",50,' ',STR_PAD_RIGHT)."\t\t\t".str_pad("SOUS CHAPITRE",100,' ',STR_PAD_RIGHT)."\t\t\t".str_pad("DATE EFFET",10,' ',STR_PAD_RIGHT)."\n");
            foreach ($pathologies as $pathologie) {
                fwrite($fp, str_pad($pathologie['code'],3,' ',STR_PAD_RIGHT)."\t\t\t".str_pad($pathologie['libelle'],100,' ',STR_PAD_RIGHT)."\t\t\t".str_pad($pathologie['code_chapitre'],50,' ',STR_PAD_RIGHT)."\t\t\t".str_pad($pathologie['code_sous_chapitre'],100,' ',STR_PAD_RIGHT)."\t\t\t".str_pad(date('d/m/Y',strtotime($pathologie['date_debut'])),10,' ',STR_PAD_RIGHT)."\n");
            }
            fclose($fp);
        }
    }

    //ACTES MEDICAUX
    elseif($data == 'act_cha') {
        require "../_CONFIGS/Classes/ACTESMEDICAUX.php";
        $ACTESMEDICAUX = new ACTESMEDICAUX();
        $actesmedicaux = $ACTESMEDICAUX->lister_chapitres(null);
        $nb_pathologies = count($actesmedicaux);
        if($nb_pathologies != 0) {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="EXPORT_ACTES_MEDICAUX_CHAPITRES_'.date('dmYhis',time()).'.txt"');

            $fp = fopen('php://output', 'wb');
            fwrite($fp, str_pad("CODE",7,' ',STR_PAD_RIGHT)."\t\t\t".str_pad("LIBELLE",100,' ',STR_PAD_RIGHT)."\t\t\t".str_pad("DATE EFFET",10,' ',STR_PAD_RIGHT)."\n");
            foreach ($actesmedicaux as $actemedical) {
                fwrite($fp, str_pad($actemedical['code'],7,' ',STR_PAD_RIGHT)."\t\t\t".str_pad($actemedical['libelle'],100,' ',STR_PAD_RIGHT)."\t\t\t".str_pad(date('d/m/Y',strtotime($actemedical['date_debut'])),10,' ',STR_PAD_RIGHT)."\n");
            }
            fclose($fp);
        }
    }
    elseif($data == 'act_med') {
        require "../_CONFIGS/Classes/ACTESMEDICAUX.php";
        $ACTESMEDICAUX = new ACTESMEDICAUX();
        $actesmedicaux = $ACTESMEDICAUX->lister_actes_medicaux(null);
        $nb_departemements = count($actesmedicaux);
        if ($nb_departemements != 0) {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="EXPORT_ACTES_MEDICAUX_' . date('dmYhis', time()) . '.txt"');

            $fp = fopen('php://output', 'wb');
            fwrite($fp, str_pad("CODE", 7, ' ', STR_PAD_RIGHT) . "\t\t\t" . str_pad("LIBELLE", 45, ' ', STR_PAD_RIGHT) . "\t\t\t" . str_pad("TITRE", 100, ' ', STR_PAD_RIGHT) . "\t\t\t" . str_pad("CHAPITRES", 45, ' ', STR_PAD_RIGHT). "\t\t\t" . str_pad("SECTION", 45, ' ', STR_PAD_RIGHT). "\t\t\t" . str_pad("ARTICLES", 15, ' ', STR_PAD_RIGHT) . "\t\t\t" . str_pad("DATE EFFET", 10, ' ', STR_PAD_RIGHT) . "\n");
            foreach ($actesmedicaux as $actemedical) {
                fwrite($fp, str_pad($actemedical['code'], 7, ' ', STR_PAD_RIGHT). "\t\t\t" . str_pad($actemedical['libelle'], 45, ' ', STR_PAD_RIGHT) . "\t\t\t" . str_pad($actemedical['titre_code'], 100, ' ', STR_PAD_RIGHT). "\t\t\t" . str_pad($actemedical['chapitre_code'], 45, ' ', STR_PAD_RIGHT). "\t\t\t" . str_pad($actemedical['section_code'], 45, ' ', STR_PAD_RIGHT). "\t\t\t" . str_pad($actemedical['article_code'], 15, ' ', STR_PAD_RIGHT). "\t\t\t" . str_pad(date('d/m/Y', strtotime($actemedical['date_debut'])), 10, ' ', STR_PAD_RIGHT) . "\n");
            }
            fclose($fp);
        }
    }
    elseif($data == 'act_art') {
        require "../_CONFIGS/Classes/ACTESMEDICAUX.php";
        $ACTESMEDICAUX = new ACTESMEDICAUX();
        $articles = $ACTESMEDICAUX->lister_articles(null);
        $nb_articles = count($articles);
        if ($nb_articles != 0) {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="EXPORT_ARTICLES_' . date('dmYhis', time()) . '.txt"');

            $fp = fopen('php://output', 'wb');
            fwrite($fp, str_pad("CODE", 7, ' ', STR_PAD_RIGHT) . "\t\t\t" . str_pad("TITRES", 100, ' ', STR_PAD_RIGHT) . "\t\t\t" . str_pad("CHAPITRES", 45, ' ', STR_PAD_RIGHT). "\t\t\t" . str_pad("SECTIONS", 45, ' ', STR_PAD_RIGHT) . "\t\t\t" . str_pad("LIBELLE", 45, ' ', STR_PAD_RIGHT). "\t\t\t" . str_pad("DATE EFFET", 10, ' ', STR_PAD_RIGHT) . "\n");
            foreach ($articles as $article) {
                fwrite($fp, str_pad($article['code'], 7, ' ', STR_PAD_RIGHT) . "\t\t\t" . str_pad($article['titre_libelle'], 100, ' ', STR_PAD_RIGHT). "\t\t\t" . str_pad($article['chapitre_libelle'], 45, ' ', STR_PAD_RIGHT). "\t\t\t" . str_pad($article['section_libelle'], 45, ' ', STR_PAD_RIGHT). "\t\t\t" . str_pad($article['libelle'], 45, ' ', STR_PAD_RIGHT) . "\t\t\t" . str_pad(date('d/m/Y', strtotime($article['date_debut'])), 10, ' ', STR_PAD_RIGHT) . "\n");
            }
            fclose($fp);
        }
    }
    elseif($data == 'act_sec') {
        require "../_CONFIGS/Classes/ACTESMEDICAUX.php";
        $ACTESMEDICAUX = new ACTESMEDICAUX();
        $sections = $ACTESMEDICAUX->lister_sections(null);
        $nb_sections = count($sections);
        if($nb_sections != 0) {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="EXPORT_ACTES_MEDICAUX_SECTION_'.date('dmYhis',time()).'.txt"');

            $fp = fopen('php://output', 'wb');
            fwrite($fp, str_pad("CODE",3,' ',STR_PAD_RIGHT)."\t\t\t".str_pad("LIBELLE",50,' ',STR_PAD_RIGHT)."\t\t\t".str_pad(" TITRE",50,' ',STR_PAD_RIGHT)."\t\t\t".str_pad("CHAPITRE",50,' ',STR_PAD_RIGHT)."\t\t\t".str_pad("DATE EFFET",10,' ',STR_PAD_RIGHT)."\n");
            foreach ($sections as $section) {
                fwrite($fp, str_pad($section['code'],3,' ',STR_PAD_RIGHT)."\t\t\t".str_pad($section['libelle'],50,' ',STR_PAD_RIGHT)."\t\t\t".str_pad($section['titre_code'],50,' ',STR_PAD_RIGHT)."\t\t\t".str_pad($section['code_chapitre'],50,' ',STR_PAD_RIGHT)."\t\t\t".str_pad(date('d/m/Y',strtotime($section['date_debut'])),10,' ',STR_PAD_RIGHT)."\n");
            }
            fclose($fp);
        }
    }
    elseif($data == 'let_cle') {
        require "../_CONFIGS/Classes/ACTESMEDICAUX.php";
        $ACTESMEDICAUX = new ACTESMEDICAUX();
        $lettres_cles = $ACTESMEDICAUX->lister_lettres_cles();
        $nb_sexes = count($lettres_cles);
        if ($nb_sexes != 0) {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="EXPORT_ACTES_MEDICAUX_LETTRES_CLES_' . date('dmYhis', time()) . '.txt"');

            $fp = fopen('php://output', 'wb');
            fwrite($fp, str_pad("CODE", 5, ' ', STR_PAD_RIGHT) . "\t\t\t" . str_pad("LIBELLE", 100, ' ', STR_PAD_RIGHT) . "\t\t\t" . str_pad("PRIX UNITAIRE", 100, ' ', STR_PAD_RIGHT) . "\t\t\t" . str_pad("DATE EFFET", 10, ' ', STR_PAD_RIGHT) . "\n");
            foreach ($lettres_cles as $lettre_cle) {
                fwrite($fp, str_pad($lettre_cle['code'], 5, ' ', STR_PAD_RIGHT) . "\t\t\t" . str_pad($lettre_cle['libelle'], 100, ' ', STR_PAD_RIGHT) . "\t\t\t" . str_pad($lettre_cle['prix_unitaire'], 100, ' ', STR_PAD_RIGHT) . "\t\t\t" . str_pad(date('d/m/Y', strtotime($lettre_cle['date_debut'])), 10, ' ', STR_PAD_RIGHT) . "\n");
            }
            fclose($fp);
        }
    }
    elseif($data == 'act_tit') {
        require "../_CONFIGS/Classes/ACTESMEDICAUX.php";
        $ACTESMEDICAUX = new ACTESMEDICAUX();
        $actesmedicaux = $ACTESMEDICAUX->lister_titres();
        $nb_sexes = count($actesmedicaux);
        if ($nb_sexes != 0) {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="EXPORT_ACTES_MEDICAUX_TITRES_' . date('dmYhis', time()) . '.txt"');

            $fp = fopen('php://output', 'wb');
            fwrite($fp, str_pad("CODE", 7, ' ', STR_PAD_RIGHT) . "\t\t\t" . str_pad("LIBELLE", 100, ' ', STR_PAD_RIGHT) . "\t\t\t" . str_pad("DATE EFFET", 10, ' ', STR_PAD_RIGHT) . "\n");
            foreach ($actesmedicaux as $actemedical) {
                fwrite($fp, str_pad($actemedical['code_titre'], 7, ' ', STR_PAD_RIGHT) . "\t\t\t" . str_pad($actemedical['libelle'], 100, ' ', STR_PAD_RIGHT) . "\t\t\t" . str_pad(date('d/m/Y', strtotime($actemedical['date_debut'])), 10, ' ', STR_PAD_RIGHT) . "\n");
            }
            fclose($fp);
        }
    }


    //MEDICAMENTS
    elseif($data == 'med') {
        require "../_CONFIGS/Classes/MEDICAMENTS.php";
        $MEDICAMENTS = new MEDICAMENTS();
        $medicaments = $MEDICAMENTS->lister_medicaments();
        $nb_medicaments = count($medicaments);
        if ($nb_medicaments != 0) {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="EXPORT_MEDICAMENTS_' . date('dmYhis', time()) . '.txt"');

            $fp = fopen('php://output', 'wb');
            fwrite($fp, str_pad("CODE", 7, ' ', STR_PAD_RIGHT) . "\t\t\t" . str_pad("LIBELLE", 45, ' ', STR_PAD_RIGHT) . "\t\t\t" . str_pad("FORME", 100, ' ', STR_PAD_RIGHT) . "\t\t\t" . str_pad("DCI", 45, ' ', STR_PAD_RIGHT). "\t\t\t" . str_pad("EAN13", 45, ' ', STR_PAD_RIGHT). "\t\t\t" . str_pad("DOSAGE", 15, ' ', STR_PAD_RIGHT) . "\t\t\t" . str_pad("DATE EFFET", 10, ' ', STR_PAD_RIGHT) . "\n");
            foreach ($medicaments as $medicament) {
                fwrite($fp, str_pad($medicament['code'], 7, ' ', STR_PAD_RIGHT). "\t\t\t" . str_pad($medicament['libelle'], 45, ' ', STR_PAD_RIGHT) . "\t\t\t" . str_pad($medicament['code_forme'], 100, ' ', STR_PAD_RIGHT). "\t\t\t" . str_pad($medicament['code_dci'], 45, ' ', STR_PAD_RIGHT). "\t\t\t" . str_pad($medicament['code_ean13'], 45, ' ', STR_PAD_RIGHT). "\t\t\t" . str_pad($medicament['dosage'].$medicament['code_unite_dosage'], 15, ' ', STR_PAD_RIGHT). "\t\t\t" . str_pad(date('d/m/Y', strtotime($medicament['date_debut'])), 10, ' ', STR_PAD_RIGHT) . "\n");
            }
            fclose($fp);
        }
    }
    elseif($data == 'med_lab') {
        require "../_CONFIGS/Classes/MEDICAMENTS.php";
        $LABORATOIRES = new MEDICAMENTS();
        $laboratoires = $LABORATOIRES->lister_laboratoires_pharmaceutiques();
        $nb_laboratoires = count($laboratoires);
        if($nb_laboratoires != 0) {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="EXPORT_MEDICAMENTS_LABORATOIRES_PHARMACEUTIQUE_'.date('dmYhis',time()).'.txt"');

            $fp = fopen('php://output', 'wb');
            fwrite($fp, str_pad("CODE",7,' ',STR_PAD_RIGHT)."\t\t\t".str_pad("LIBELLE",100,' ',STR_PAD_RIGHT)."\t\t\t".str_pad("DATE EFFET",10,' ',STR_PAD_RIGHT)."\n");
            foreach ($laboratoires as $laboratoire) {
                fwrite($fp, str_pad($laboratoire['code'],7,' ',STR_PAD_RIGHT)."\t\t\t".str_pad($laboratoire['libelle'],100,' ',STR_PAD_RIGHT)."\t\t\t".str_pad(date('d/m/Y',strtotime($laboratoire['date_debut'])),10,' ',STR_PAD_RIGHT)."\n");
            }
            fclose($fp);
        }
    }
    elseif($data == 'med_pre') {
        require "../_CONFIGS/Classes/MEDICAMENTS.php";
        $PRESENTAIONS = new MEDICAMENTS();
        $presentations = $PRESENTAIONS->lister_presentations();
        $nb_presentations = count($presentations);
        if($nb_presentations != 0) {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="EXPORT_MEDICAMENTS_PRESENTATIONS_'.date('dmYhis',time()).'.txt"');

            $fp = fopen('php://output', 'wb');
            fwrite($fp, str_pad("CODE",7,' ',STR_PAD_RIGHT)."\t\t\t".str_pad("LIBELLE",100,' ',STR_PAD_RIGHT)."\t\t\t".str_pad("DATE EFFET",10,' ',STR_PAD_RIGHT)."\n");
            foreach ($presentations as $presentation) {
                fwrite($fp, str_pad($presentation['code'],7,' ',STR_PAD_RIGHT)."\t\t\t".str_pad($presentation['libelle'],100,' ',STR_PAD_RIGHT)."\t\t\t".str_pad(date('d/m/Y',strtotime($presentation['date_debut'])),10,' ',STR_PAD_RIGHT)."\n");
            }
            fclose($fp);
        }
    }
    elseif($data == 'med_ffm') {
        require "../_CONFIGS/Classes/MEDICAMENTS.php";
        $FAMILLESFORMES = new MEDICAMENTS();
        $famillesformes = $FAMILLESFORMES->lister_familles_formes();
        $nb_famillesformes = count($famillesformes);
        if($nb_famillesformes != 0) {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="EXPORT_FAMILLES_DE_FORMES_'.date('dmYhis',time()).'.txt"');

            $fp = fopen('php://output', 'wb');
            fwrite($fp, str_pad("CODE",7,' ',STR_PAD_RIGHT)."\t\t\t".str_pad("LIBELLE",100,' ',STR_PAD_RIGHT)."\t\t\t".str_pad("DATE EFFET",10,' ',STR_PAD_RIGHT)."\n");
            foreach ($famillesformes as $familleforme) {
                fwrite($fp, str_pad($familleforme['code'],7,' ',STR_PAD_RIGHT)."\t\t\t".str_pad($familleforme['libelle'],100,' ',STR_PAD_RIGHT)."\t\t\t".str_pad(date('d/m/Y',strtotime($familleforme['date_debut'])),10,' ',STR_PAD_RIGHT)."\n");
            }
            fclose($fp);
        }
    }
    elseif($data == 'med_frm') {
        require "../_CONFIGS/Classes/MEDICAMENTS.php";
        $FORMES = new MEDICAMENTS();
        $formes = $FORMES->lister_familles_formes();
        $nb_formes = count($formes);
        if($nb_formes != 0) {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="EXPORT_FORMES_'.date('dmYhis',time()).'.txt"');

            $fp = fopen('php://output', 'wb');
            fwrite($fp, str_pad("CODE",7,' ',STR_PAD_RIGHT)."\t\t\t".str_pad("LIBELLE",100,' ',STR_PAD_RIGHT)."\t\t\t".str_pad("DATE EFFET",10,' ',STR_PAD_RIGHT)."\n");
            foreach ($formes as $forme) {
                fwrite($fp, str_pad($forme['code'],7,' ',STR_PAD_RIGHT)."\t\t\t".str_pad($forme['libelle'],100,' ',STR_PAD_RIGHT)."\t\t\t".str_pad(date('d/m/Y',strtotime($forme['date_debut'])),10,' ',STR_PAD_RIGHT)."\n");
            }
            fclose($fp);
        }
    }
    elseif($data == 'med_typ') {
        require "../_CONFIGS/Classes/MEDICAMENTS.php";
        $TYPESMEDICAMENTS = new MEDICAMENTS();
        $typesmedicaments = $TYPESMEDICAMENTS->lister_types_medicaments();
        $nb_typesmedicaments = count($typesmedicaments);
        if($nb_typesmedicaments != 0) {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="EXPORT_TYPES_DE_MEDICAMENTS_'.date('dmYhis',time()).'.txt"');

            $fp = fopen('php://output', 'wb');
            fwrite($fp, str_pad("CODE",7,' ',STR_PAD_RIGHT)."\t\t\t".str_pad("LIBELLE",100,' ',STR_PAD_RIGHT)."\t\t\t".str_pad("DATE EFFET",10,' ',STR_PAD_RIGHT)."\n");
            foreach ($typesmedicaments as $typemedicament) {
                fwrite($fp, str_pad($typemedicament['code'],7,' ',STR_PAD_RIGHT)."\t\t\t".str_pad($typemedicament['libelle'],100,' ',STR_PAD_RIGHT)."\t\t\t".str_pad(date('d/m/Y',strtotime($typemedicament['date_debut'])),10,' ',STR_PAD_RIGHT)."\n");
            }
            fclose($fp);
        }
    }
    elseif($data == 'med_cth') {
        require "../_CONFIGS/Classes/MEDICAMENTS.php";
        $CLASSESTHERAPEUTHIUE = new MEDICAMENTS();
        $classestherapeuthiques = $CLASSESTHERAPEUTHIUE->lister_classes_therapeutiques();
        $nb_classestherapeutiques = count($classestherapeuthiques);
        if($nb_classestherapeutiques != 0) {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="EXPORT_CLASSES_THERAPEUTIQUES_'.date('dmYhis',time()).'.txt"');

            $fp = fopen('php://output', 'wb');
            fwrite($fp, str_pad("CODE",7,' ',STR_PAD_RIGHT)."\t\t\t".str_pad("LIBELLE",100,' ',STR_PAD_RIGHT)."\t\t\t".str_pad("DATE EFFET",10,' ',STR_PAD_RIGHT)."\n");
            foreach ($classestherapeuthiques as $classetherapeuthique) {
                fwrite($fp, str_pad($classetherapeuthique['code'],7,' ',STR_PAD_RIGHT)."\t\t\t".str_pad($classetherapeuthique['libelle'],100,' ',STR_PAD_RIGHT)."\t\t\t".str_pad(date('d/m/Y',strtotime($classetherapeuthique['date_debut'])),10,' ',STR_PAD_RIGHT)."\n");
            }
            fclose($fp);
        }
    }
    elseif($data == 'med_fra') {
        require "../_CONFIGS/Classes/MEDICAMENTS.php";
        $FORMESADMINISTRATIONS = new MEDICAMENTS();
        $formesadministrations = $FORMESADMINISTRATIONS->lister_formes_administrations();
        $nb_formesadministrations = count($formesadministrations);
        if($nb_formesadministrations != 0) {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="EXPORT_FORMES_ADMINISTRATIONS'.date('dmYhis',time()).'.txt"');

            $fp = fopen('php://output', 'wb');
            fwrite($fp, str_pad("CODE",7,' ',STR_PAD_RIGHT)."\t\t\t".str_pad("LIBELLE",100,' ',STR_PAD_RIGHT)."\t\t\t".str_pad("DATE EFFET",10,' ',STR_PAD_RIGHT)."\n");
            foreach ($formesadministrations as $formeadministration) {
                fwrite($fp, str_pad($formeadministration['code'],7,' ',STR_PAD_RIGHT)."\t\t\t".str_pad($formeadministration['libelle'],100,' ',STR_PAD_RIGHT)."\t\t\t".str_pad(date('d/m/Y',strtotime($formeadministration['date_debut'])),10,' ',STR_PAD_RIGHT)."\n");
            }
            fclose($fp);
        }
    }
    elseif($data == 'med_unt') {
        require "../_CONFIGS/Classes/MEDICAMENTS.php";
        $UNITESDOSAGES = new MEDICAMENTS();
        $unitesdosages = $UNITESDOSAGES->lister_unites_dosages();
        $nb_unitesdosages = count($unitesdosages);
        if($nb_unitesdosages != 0) {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="EXPORT_UNITES_DE_DOSAGES_'.date('dmYhis',time()).'.txt"');

            $fp = fopen('php://output', 'wb');
            fwrite($fp, str_pad("CODE",7,' ',STR_PAD_RIGHT)."\t\t\t".str_pad("LIBELLE",100,' ',STR_PAD_RIGHT)."\t\t\t".str_pad("DATE EFFET",10,' ',STR_PAD_RIGHT)."\n");
            foreach ($unitesdosages as $unitedosage) {
                fwrite($fp, str_pad($unitedosage['code'],7,' ',STR_PAD_RIGHT)."\t\t\t".str_pad($unitedosage['libelle'],100,' ',STR_PAD_RIGHT)."\t\t\t".str_pad(date('d/m/Y',strtotime($unitedosage['date_debut'])),10,' ',STR_PAD_RIGHT)."\n");
            }
            fclose($fp);
        }
    }
    elseif($data == 'med_dci') {
        require "../_CONFIGS/Classes/MEDICAMENTS.php";
        $DCI = new MEDICAMENTS();
        $denominations_communes_internationales = $DCI->lister_dci();
        $nb_dci = count($denominations_communes_internationales);
        if($nb_dci != 0) {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="EXPORT_DCI_'.date('dmYhis',time()).'.txt"');

            $fp = fopen('php://output', 'wb');
            fwrite($fp, str_pad("CODE",7,' ',STR_PAD_RIGHT)."\t\t\t".str_pad("UNITE DE DOSAGE",15,' ',STR_PAD_RIGHT)."\t\t\t".str_pad("FORME",7,' ',STR_PAD_RIGHT)."\t\t\t".str_pad("LIBELLE",100,' ',STR_PAD_RIGHT)."\t\t\t".str_pad("DATE EFFET",10,' ',STR_PAD_RIGHT)."\n");
            foreach ($denominations_communes_internationales as $denomination_commune_internationale) {
                fwrite($fp, str_pad($denomination_commune_internationale['code'],7,' ',STR_PAD_RIGHT)."\t\t\t".str_pad($denomination_commune_internationale['dosage'].$denomination_commune_internationale['code_unite'],15,' ',STR_PAD_RIGHT)."\t\t\t".str_pad($denomination_commune_internationale['code_forme'],7,' ',STR_PAD_RIGHT)."\t\t\t".str_pad($denomination_commune_internationale['libelle'],100,' ',STR_PAD_RIGHT)."\t\t\t".str_pad(date('d/m/Y',strtotime($denomination_commune_internationale['date_debut'])),10,' ',STR_PAD_RIGHT)."\n");
            }
            fclose($fp);
        }
    }

    //ETABLISSEMENTS
    elseif($data == 'etab_niveau') {
        require "../_CONFIGS/Classes/ETABLISSEMENTS.php";
        $ETABLISSEMENTS = new ETABLISSEMENTS();
        $niveaux = $ETABLISSEMENTS->lister_niveau_sanitaire();
        $nb_niveaux = count($niveaux);
        if ($nb_niveaux != 0) {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="EXPORT_ETABLISSEMENTS_NIVEAUX_SANITAIRES_' . date('dmYhis', time()) . '.txt"');

            $fp = fopen('php://output', 'wb');
            fwrite($fp, str_pad("CODE", 5, ' ', STR_PAD_RIGHT) . "\t\t\t" . str_pad("LIBELLE", 100, ' ', STR_PAD_RIGHT) . "\t\t\t" . str_pad("PRIX UNITAIRE", 100, ' ', STR_PAD_RIGHT) . "\t\t\t" . str_pad("DATE EFFET", 10, ' ', STR_PAD_RIGHT) . "\n");
            foreach ($niveaux as $niveau) {
                fwrite($fp, str_pad($niveau['code'], 5, ' ', STR_PAD_RIGHT) . "\t\t\t" . str_pad($niveau['libelle'], 100, ' ', STR_PAD_RIGHT) . "\t\t\t" . str_pad($niveau['niveau'], 100, ' ', STR_PAD_RIGHT) . "\t\t\t" . str_pad(date('d/m/Y', strtotime($niveau['date_debut'])), 10, ' ', STR_PAD_RIGHT) . "\n");
            }
            fclose($fp);
        }
    }

}
else{
    echo '<p align="center">Ce format n\'est pas pris en charge pour l\'export de données.</p>';
}