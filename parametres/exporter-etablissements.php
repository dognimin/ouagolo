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

    //ETABLISSEMENTS
    if($data == 'etab_niveau') {
        require "../_CONFIGS/Classes/ETABLISSEMENTS.php";
        $ETABLISSEMENTS = new ETABLISSEMENTS();
        $niveaux = $ETABLISSEMENTS->lister_niveaux_sanitaires();
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


    //TYPES ETABLISSEMENTS

    elseif($data == 'Typ_etab') {
        require "../_CONFIGS/Classes/ETABLISSEMENTS.php";
        $ETABLISSEMENTS = new ETABLISSEMENTS();
        $typesetablissements = $ETABLISSEMENTS->lister_types_ets();
        $nb_types_etablissements = count($typesetablissements);
        if($nb_types_etablissements != 0) {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="EXPORT_TABLE_VALEURS_TYPES_ETABLISSEMENTS_' . date('dmYhis', time()) . '.csv"');
            //$donnees = array('CODE', 'LIBELLE', 'DATE EFFET');

            $fp = fopen('php://output', 'wb');
            fputcsv($fp, array('CODE', 'LIBELLE', 'DATE EFFET'), ';');
            foreach ($typesetablissements as $typetablissement) {
                fputcsv($fp, array($typetablissement['code'], $typetablissement['libelle'], date('d/m/Y', strtotime($typetablissement['date_debut']))), ';');
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

    //ETABLISSEMENTS

    if ($data == 'etab_niveau') {
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


    //TYPES ETABLISSEMENTS
    elseif ($data == 'Typ_etab') {
        $file_name = "EXPORT_TABLE_VALEURS_TYPES_ETABLISSEMENTS_".date('dmYhis',time()).".xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="'.$file_name.'"');

        require "../_CONFIGS/Classes/ETABLISSEMENTS.php";
        $ETABLISSEMENTS = new ETABLISSEMENTS();
        $typesetablissements = $ETABLISSEMENTS->lister_types_ets();
        $nb_types_etablissements = count($typesetablissements);
        if($nb_types_etablissements != 0) {

            $row = 1;
            $sheet->getStyle('D'.$row.':L'.$row)->applyFromArray($style_titre);
            $sheet->setCellValue('D'.$row, 'TABLE DE VALEURS: TYPES ETABLISSEMENTS');
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
            foreach ($typesetablissements as $typetablissement) {
                $row++;
                $sheet->getStyle('A'.$row.':L'.$row)->applyFromArray($style_tableau);
                $sheet->mergeCells('C'.$row.':J'.$row);
                $sheet->mergeCells('K'.$row.':L'.$row);
                $sheet->setCellValue('A'.$row, $ligne);
                $sheet->setCellValue('B'.$row, $typetablissement['code']);
                $sheet->setCellValue('C'.$row, $typetablissement['libelle']);
                $spreadsheet->getActiveSheet()->getStyle('K'.$row)
                    ->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                $sheet->setCellValue('K'.$row, date('d/m/Y',strtotime($typetablissement['date_debut'])));
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

    //ETABLISSEMENTS
    if ($data == 'etab_niveau') {
        $file_name = "EXPORT_ETABLISSEMENTS_NIVEAUX_SANITAIRES_".date('dmYhis',time()).".pdf";
        $pdf->SetTitle($file_name);

        require "../_CONFIGS/Classes/ETABLISSEMENTS.php";
        $ETABLISSEMENTS = new ETABLISSEMENTS();
        $niveaux = $ETABLISSEMENTS->lister_niveaux_sanitaires();
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


    //TYPES ETABLISSEMENTS

    elseif ($data == 'Typ_etab') {
        $file_name = "EXPORT_TABLE_VALEUR_TYPES_ETABLISSEMENTS_".date('dmYhis',time()).".csv";
        $pdf->SetTitle($file_name);
        require "../_CONFIGS/Classes/ETABLISSEMENTS.php";
        $ETABLISSEMENTS = new ETABLISSEMENTS();
        $typesetablissements = $ETABLISSEMENTS->lister_types_ets();
        $nb_types_etablissements = count($typesetablissements);
        if($nb_types_etablissements != 0) {
            $pdf->AddPage('L');
            $pdf->Image(IMAGES.'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);

            $pdf->writeHTMLCell(0, 0, 50, 15, '<h1>TABLE DE VALEUR:<br />TYPES ETABLISSEMENTS</h1>', 0, 1, 0, true, 'C', true);
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
            foreach ($typesetablissements as $typtablissement) {
                $pdf->SetFont('helvetica', 'B', 8, '', true);
                $pdf->MultiCell(10, 5, $ligne, 1, 'R', 1, 0, '', '', true);
                $pdf->MultiCell(100, 5, $typtablissement['code'], 1, 'L', 1, 0, '', '', true);
                $pdf->MultiCell(150, 5, $typtablissement['libelle'], 1, 'L', 1, 0, '', '', true);
                $pdf->MultiCell(20, 5, date('d/m/Y',strtotime($typtablissement['date_debut'])), 1, 'C', 1, 1, '', '', true);
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

    //ETABLISSEMENTS
    if($data == 'etab_niveau') {
        require "../_CONFIGS/Classes/ETABLISSEMENTS.php";
        $ETABLISSEMENTS = new ETABLISSEMENTS();
        $niveaux = $ETABLISSEMENTS->lister_niveaux_sanitaires();
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


    //TYPES ETABLISSEMENTS
    elseif($data == 'Typ_etab') {
        require "../_CONFIGS/Classes/ETABLISSEMENTS.php";
        $ETABLISSEMENTS = new ETABLISSEMENTS();
        $typesetablissements = $ETABLISSEMENTS->lister_types_ets();
        $nb_types_etablissements = count($typesetablissements);
        if ($nb_types_etablissements != 0) {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="EXPORT_TABLE_VALEUR_TYPES_ETABLISSEMENTS_' . date('dmYhis', time()) . '.txt"');

            $fp = fopen('php://output', 'wb');
            fwrite($fp, str_pad("CODE", 1, ' ', STR_PAD_RIGHT) . "\t\t\t" . str_pad("LIBELLE", 45, ' ', STR_PAD_RIGHT) . "\t\t\t" . str_pad("DATE EFFET", 10, ' ', STR_PAD_RIGHT) . "\n");
            foreach ($typesetablissements as $typetablissement) {
                fwrite($fp, str_pad($typetablissement['code'], 1, ' ', STR_PAD_RIGHT) . "\t\t\t" . str_pad($typetablissement['libelle'], 45, ' ', STR_PAD_RIGHT) . "\t\t\t" . str_pad(date('d/m/Y', strtotime($typetablissement['date_debut'])), 10, ' ', STR_PAD_RIGHT) . "\n");
            }
            fclose($fp);
        }
    }


}
else{
    echo '<p align="center">Ce format n\'est pas pris en charge pour l\'export de données.</p>';
}