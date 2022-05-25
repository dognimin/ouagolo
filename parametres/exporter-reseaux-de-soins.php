<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

define('AUTHOR','TECHOUSE');
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
                if($data == 'res_etab') {
                    require "../_CONFIGS/Classes/RESEAUXDESOINS.php";
                    $RESEAUXDESOINS = new RESEAUXDESOINS();
                    $reseaux_etablissements = $RESEAUXDESOINS->lister_reseau_etablissements(null);
                    $nb_reseaux_etablissements = count($reseaux_etablissements);
                    if($nb_reseaux_etablissements != 0) {
                        $file_name = "EXPORT_RESEAUX_DE_SOINS_ETABLISSEMENTS_" . date('dmYhis', time()) . ".csv";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename=' . $file_name);

                        $fp = fopen('php://output', 'wb');
                        fputcsv($fp, array('CODE', 'LIBELLE', 'DATE EFFET'), ';');
                        foreach ($reseaux_etablissements as $reseau_etablissement) {
                            fputcsv($fp, array($reseau_etablissement['code'], $reseau_etablissement['code_etablissement'], date('d/m/Y', strtotime($reseau_etablissement['date_debut']))), ';');
                        }
                        fclose($fp);
                    }
                }
                elseif($data == 'res') {
                    require "../_CONFIGS/Classes/RESEAUXDESOINS.php";
                    $RESEAUXDESOINS = new RESEAUXDESOINS();
                    $reseaux = $RESEAUXDESOINS->lister();
                    $nb_reseaux = count($reseaux);
                    if($nb_reseaux != 0) {
                        $file_name = "EXPORT_RESEAUX_DE_SOINS_" . date('dmYhis', time()) . ".csv";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename=' . $file_name);

                        $fp = fopen('php://output', 'wb');
                        fputcsv($fp, array('CODE', 'LIBELLE', 'DATE EFFET'), ';');
                        foreach ($reseaux as $reseau) {
                            fputcsv($fp, array($reseau['code'], $reseau['libelle'], date('d/m/Y', strtotime($reseau['date_debut']))), ';');
                        }
                        fclose($fp);
                    }
                }
                elseif($data == 'res_acte') {
                    require "../_CONFIGS/Classes/RESEAUXDESOINS.php";
                    $RESEAUXDESOINS = new RESEAUXDESOINS();
                    $reseaux_actes = $RESEAUXDESOINS->lister_reseau_actes_medicaux(NULL);
                    $nb_reseaux_actes = count($reseaux_actes);
                    if($nb_reseaux_actes != 0) {
                        $file_name = "EXPORT_RESEAUX_DE_SOINS_ACTES_" . date('dmYhis', time()) . ".csv";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename=' . $file_name);

                        $fp = fopen('php://output', 'wb');
                        fputcsv($fp, array('CODE RESEAU', 'CODE ACTE', 'DATE EFFET'), ';');
                        foreach ($reseaux_actes as $reseau_acte) {
                            fputcsv($fp, array($reseau_acte['code_reseau'], $reseau_acte['code_acte'], date('d/m/Y', strtotime($reseau_acte['date_debut']))), ';');
                        }
                        fclose($fp);
                    }
                }
                elseif($data == 'res_med') {
                    require "../_CONFIGS/Classes/RESEAUXDESOINS.php";
                    $RESEAUXDESOINS = new RESEAUXDESOINS();
                    $reseaux_medicaments = $RESEAUXDESOINS->lister_reseau_medicaments(null);
                    $nb_reseaux_medicaments = count($reseaux_medicaments);
                    if($nb_reseaux_medicaments != 0) {
                        $file_name = "EXPORT_RESEAUX_DE_SOINS_MEDICAMENTS_" . date('dmYhis', time()) . ".csv";
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename=' . $file_name);

                        $fp = fopen('php://output', 'wb');
                        fputcsv($fp, array('CODE RESEAU', 'CODE MEDICAMENT', 'TARIF', 'DATE EFFET'),';');
                        foreach ($reseaux_medicaments as $reseau_medicament) {
                            fputcsv($fp, array($reseau_medicament['code_reseau'], $reseau_medicament['code_medicament'], $reseau_medicament['tarif'], date('d/m/Y',strtotime($reseau_medicament['date_debut']))),';');
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
                if ($data == 'res') {
                    $file_name = "EXPORT_RESEAUX_DE_SOINS_".date('dmYhis',time()).".xls";
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment; filename="'.$file_name.'"');

                    require "../_CONFIGS/Classes/RESEAUXDESOINS.php";
                    $RESEAUXDESOINS = new RESEAUXDESOINS();
                    $reseaux = $RESEAUXDESOINS->lister();
                    $nb_reseaux = count($reseaux);
                    if($nb_reseaux != 0) {

                        $row = 1;
                        $sheet->getStyle('D'.$row.':L'.$row)->applyFromArray($style_titre);
                        $sheet->setCellValue('D'.$row, 'RESEAUX DE SOINS: RESEAUX DE SOINS');
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
                        foreach ($reseaux as $reseau) {
                            $row++;
                            $sheet->getStyle('A'.$row.':L'.$row)->applyFromArray($style_tableau);
                            $sheet->mergeCells('C'.$row.':J'.$row);
                            $sheet->mergeCells('K'.$row.':L'.$row);
                            $sheet->setCellValue('A'.$row, $ligne);
                            $sheet->setCellValue('B'.$row, $reseau['code']);
                            $sheet->setCellValue('C'.$row, $reseau['libelle']);
                            $spreadsheet->getActiveSheet()->getStyle('K'.$row)
                                ->getNumberFormat()
                                ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                            $sheet->setCellValue('K'.$row, date('d/m/Y',strtotime($reseau['date_debut'])));
                            $ligne++;
                        }

                        $writer = new Xlsx($spreadsheet);
                        $writer->save("php://output");
                    }
                }
                elseif ($data == 'res_etab') {
                    $file_name = "EXPORT_RESEAUX_DE_SOINS_ETABLISSEMENTS_".date('dmYhis',time()).".xls";
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment; filename="'.$file_name.'"');

                    require "../_CONFIGS/Classes/RESEAUXDESOINS.php";
                    $RESEAUXDESOINS = new RESEAUXDESOINS();
                    $reseaux_etablissements = $RESEAUXDESOINS->lister_reseau_etablissements(null);
                    $nb_reseaux_etablissements = count($reseaux_etablissements);
                    if($nb_reseaux_etablissements != 0) {

                        $row = 1;
                        $sheet->getStyle('D'.$row.':L'.$row)->applyFromArray($style_titre);
                        $sheet->setCellValue('D'.$row, 'RESEAUX DE SOINS: ETABLISSEMENTS');
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
                        $sheet->setCellValue('B'.$row, 'CODE_RESEAU');
                        $sheet->setCellValue('C'.$row, 'CODE_ETABLISSEMENT');
                        $sheet->setCellValue('K'.$row, 'DATE EFFET');
                        $ligne = 1;
                        foreach ($reseaux_etablissements as $reseau_etablissement) {
                            $row++;
                            $sheet->getStyle('A'.$row.':L'.$row)->applyFromArray($style_tableau);
                            $sheet->mergeCells('C'.$row.':J'.$row);
                            $sheet->mergeCells('K'.$row.':L'.$row);
                            $sheet->setCellValue('A'.$row, $ligne);
                            $sheet->setCellValue('B'.$row, $reseau_etablissement['code_reseau']);
                            $sheet->setCellValue('C'.$row, $reseau_etablissement['code_etablissement']);
                            $spreadsheet->getActiveSheet()->getStyle('K'.$row)
                                ->getNumberFormat()
                                ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                            $sheet->setCellValue('K'.$row, date('d/m/Y',strtotime($reseau_etablissement['date_debut'])));
                            $ligne++;
                        }

                        $writer = new Xlsx($spreadsheet);
                        $writer->save("php://output");
                    }
                }
                elseif ($data == 'res_acte') {
                    $file_name = "EXPORT_RESEAUX_DE_SOINS_ACTES_MEDICAUX".date('dmYhis',time()).".xls";
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment; filename="'.$file_name.'"');

                    require "../_CONFIGS/Classes/RESEAUXDESOINS.php";
                    $RESEAUXDESOINS = new RESEAUXDESOINS();
                    $reseaux_actes = $RESEAUXDESOINS->lister_reseau_actes_medicaux(null);
                    $nb_reseaux_actes= count($reseaux_actes);
                    if($nb_reseaux_actes != 0) {

                        $row = 1;
                        $sheet->getStyle('D'.$row.':L'.$row)->applyFromArray($style_titre);
                        $sheet->setCellValue('D'.$row, 'RESEAUX DE SOINS: ACTES MEDICAUX');
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
                        $sheet->setCellValue('B'.$row, 'CODE_RESEAU');
                        $sheet->setCellValue('C'.$row, 'CODE_ACTE');
                        $sheet->setCellValue('K'.$row, 'DATE EFFET');
                        $ligne = 1;
                        foreach ($reseaux_actes as $reseau_acte) {
                            $row++;
                            $sheet->getStyle('A'.$row.':L'.$row)->applyFromArray($style_tableau);
                            $sheet->mergeCells('C'.$row.':J'.$row);
                            $sheet->mergeCells('K'.$row.':L'.$row);
                            $sheet->setCellValue('A'.$row, $ligne);
                            $sheet->setCellValue('B'.$row, $reseau_acte['code_reseau']);
                            $sheet->setCellValue('C'.$row, $reseau_acte['code_etablissement']);
                            $spreadsheet->getActiveSheet()->getStyle('K'.$row)
                                ->getNumberFormat()
                                ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                            $sheet->setCellValue('K'.$row, date('d/m/Y',strtotime($reseau_acte['date_debut'])));
                            $ligne++;
                        }

                        $writer = new Xlsx($spreadsheet);
                        $writer->save("php://output");
                    }
                }
                elseif ($data == 'res_med') {
                    $file_name = "EXPORT_RESEAUX_DE_SOINS_MEDICAMENTS_".date('dmYhis',time()).".xls";
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment; filename="'.$file_name.'"');

                    require "../_CONFIGS/Classes/RESEAUXDESOINS.php";
                    $RESEAUXDESOINS = new RESEAUXDESOINS();
                    $reseaux_medicaments = $RESEAUXDESOINS->lister_reseau_medicaments(null);
                    $nb_reseaux_medicaments = count($reseaux_medicaments);
                    if($nb_reseaux_medicaments != 0) {

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
                        $sheet->setCellValue('B'.$row, 'CODE RESEAU');
                        $sheet->setCellValue('C'.$row, 'CODE MEDICAMENT');
                        $sheet->setCellValue('H'.$row, 'TARIF');
                        $sheet->setCellValue('K'.$row, 'DATE EFFET');
                        $ligne = 1;
                        foreach ($reseaux_medicaments as $reseau_medicament ) {
                            $row++;
                            $sheet->getStyle('A'.$row.':L'.$row)->applyFromArray($style_tableau);
                            $sheet->mergeCells('C'.$row.':G'.$row);
                            $sheet->mergeCells('H'.$row.':J'.$row);
                            $sheet->mergeCells('K'.$row.':L'.$row);
                            $sheet->setCellValue('A'.$row, $ligne);
                            $sheet->setCellValue('B'.$row, $reseau_medicament['code_reseau']);
                            $sheet->setCellValue('C'.$row, $reseau_medicament['code_medicament']);
                            $sheet->setCellValue('H'.$row, $reseau_medicament['tarif']);
                            $spreadsheet->getActiveSheet()->getStyle('K'.$row)
                                ->getNumberFormat()
                                ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                            $sheet->setCellValue('K'.$row, date('d/m/Y',strtotime($reseau_medicament['date_debut'])));
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
                if ($data == 'res') {
                    $file_name = "EXPORT_TABLE_RESEAUX_DE_SOINS_".date('dmYhis',time()).".csv";
                    $pdf->SetTitle($file_name);
                    require "../_CONFIGS/Classes/RESEAUXDESOINS.php";
                    $RESEAUXDESOINS= new RESEAUXDESOINS();
                    $reseaux = $RESEAUXDESOINS->lister();
                    $nb_reseaux = count($reseaux);
                    if($nb_reseaux != 0) {
                        $pdf->AddPage('L');
                        $pdf->Image(IMAGES.'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);

                        $pdf->writeHTMLCell(0, 0, 50, 15, '<h1>RESEAUX DE SOINS</h1>', 0, 1, 0, true, 'C', true);
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
                        foreach ($reseaux as $reseau) {
                            $pdf->SetFont('helvetica', 'B', 8, '', true);
                            $pdf->MultiCell(10, 5, $ligne, 1, 'R', 1, 0, '', '', true);
                            $pdf->MultiCell(15, 5, $reseau['code'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(230, 5, $reseau['libelle'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(20, 5, date('d/m/Y',strtotime($reseau['date_debut'])), 1, 'C', 1, 1, '', '', true);
                            $ligne++;
                        }

                    }


                    $pdf->Output($file_name, 'I');
                }
                elseif ($data == 'res_acte') {
                    $file_name = "EXPORT_TABLE_RESEAUX_DE_SOINS_ACTES".date('dmYhis',time()).".csv";
                    $pdf->SetTitle($file_name);
                    require "../_CONFIGS/Classes/RESEAUXDESOINS.php";
                    $RESEAUXDESOINS= new RESEAUXDESOINS();
                    $reseaux_actes = $RESEAUXDESOINS->lister_reseau_actes_medicaux(null);
                    $nb_actes = count($reseaux_actes);
                    if($nb_actes != 0) {
                        $pdf->AddPage('L');
                        $pdf->Image(IMAGES.'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);

                        $pdf->writeHTMLCell(0, 0, 50, 15, '<h1>RESEAUX DE SOINS:<br />ACTES MEDICAUX</h1>', 0, 1, 0, true, 'C', true);
                        $pdf->setCellPaddings(1, 1, 1, 1);
                        $pdf->MultiCell(10, 15, NULL, 0, 'L', 1, 1, '', '', true);

                        $pdf->SetFillColor(128, 128, 128);
                        $pdf->SetFont('helvetica', 'B', 8, '', true);
                        $pdf->MultiCell(10, 5, 'N°', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(15, 5, 'CODE RESEAU', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(230, 5, 'CODE ACTE', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(20, 5, 'DATE EFFET', 1, 'L', 1, 1, '', '', true);
                        $pdf->SetFont('helvetica', '', 8, '', true);
                        $pdf->SetFillColor(255, 255, 255);
                        $ligne = 1;
                        foreach ($reseaux_actes as $reseau_acte) {
                            $pdf->SetFont('helvetica', 'B', 8, '', true);
                            $pdf->MultiCell(10, 5, $ligne, 1, 'R', 1, 0, '', '', true);
                            $pdf->MultiCell(15, 5, $reseau_acte['code_reseau'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(230, 5, $reseau_acte['code_acte'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(20, 5, date('d/m/Y',strtotime($reseau_acte['date_debut'])), 1, 'C', 1, 1, '', '', true);
                            $ligne++;
                        }

                    }


                    $pdf->Output($file_name, 'I');
                }
                elseif ($data == 'res_etab') {
                    $file_name = "EXPORT_TABLE_RESEAUX_DE_ETABLISSEMENTS_".date('dmYhis',time()).".csv";
                    $pdf->SetTitle($file_name);
                    require "../_CONFIGS/Classes/RESEAUXDESOINS.php";
                    $RESEAUXDESOINS= new RESEAUXDESOINS();
                    $reseaux_etablissements = $RESEAUXDESOINS->lister_reseau_etablissements(null);
                    $nb_reseaux_etablissements = count($reseaux_etablissements);
                    if($nb_reseaux_etablissements != 0) {
                        $pdf->AddPage('L');
                        $pdf->Image(IMAGES.'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'L', true, 150, '', false, false, 0, false, false, false);

                        $pdf->writeHTMLCell(0, 0, 50, 15, '<h1>RESEAUX DE SOINS:<br />ETABLISSEMENTS</h1>', 0, 1, 0, true, 'C', true);
                        $pdf->setCellPaddings(1, 1, 1, 1);
                        $pdf->MultiCell(10, 15, NULL, 0, 'L', 1, 1, '', '', true);

                        $pdf->SetFillColor(128, 128, 128);
                        $pdf->SetFont('helvetica', 'B', 8, '', true);
                        $pdf->MultiCell(10, 5, 'N°', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(100, 5, 'CODE RESEAU', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(150, 5, 'CODE ETABLISSEMENT', 1, 'L', 1, 0, '', '', true);
                        $pdf->MultiCell(20, 5, 'DATE EFFET', 1, 'L', 1, 1, '', '', true);
                        $pdf->SetFont('helvetica', '', 8, '', true);
                        $pdf->SetFillColor(255, 255, 255);
                        $ligne = 1;
                        foreach ($reseaux_etablissements as $reseau_etablissement) {
                            $pdf->SetFont('helvetica', 'B', 8, '', true);
                            $pdf->MultiCell(10, 5, $ligne, 1, 'R', 1, 0, '', '', true);
                            $pdf->MultiCell(100, 5, $reseau_etablissement['code_reseau'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(150, 5, $reseau_etablissement['code_etablissement'], 1, 'L', 1, 0, '', '', true);
                            $pdf->MultiCell(20, 5, date('d/m/Y',strtotime($reseau_etablissement['date_debut'])), 1, 'C', 1, 1, '', '', true);
                            $ligne++;
                        }

                    }


                    $pdf->Output($file_name, 'I');
                }
                elseif($data == 'res_med') {
                    require "../_CONFIGS/Classes/RESEAUXDESOINS.php";
                    $RESEAUXDESOINS = new RESEAUXDESOINS();
                    $reseaux_medicaments = $RESEAUXDESOINS->lister_reseau_medicaments(null);
                    $nb_reseaux_medicaments = count($reseaux_medicaments);
                    if($nb_reseaux_medicaments != 0) {
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename="EXPORT_RESEAUX_DE_SOINS_MEDICAMENTS_'.date('dmYhis',time()).'.csv"');

                        $fp = fopen('php://output', 'wb');
                        fputcsv($fp, array('CODE RESEAU', 'CODE MEDICAMENT', 'TARIF', 'DATE EFFET'),';');
                        foreach ($reseaux_medicaments as $reseau_medicament) {
                            fputcsv($fp, array($reseau_medicament['code_reseau'], $reseau_medicament['code_medicament'], $reseau_medicament['tarif'], date('d/m/Y',strtotime($reseau_medicament['date_debut']))),';');
                        }
                        fclose($fp);
                    }
                }

                else {
                    echo '<p align="center">Cette donnée n\'est pas prise en charge pour l\'export.</p>';
                }
            }
            elseif($type == 'txt') {

                if($data == 'res') {
                    require "../_CONFIGS/Classes/RESEAUXDESOINS.php";
                    $RESEAUXDESOINS = new RESEAUXDESOINS();
                    $reseaux = $RESEAUXDESOINS->lister();
                    $nb_reseaux = count($reseaux);
                    if ($nb_reseaux != 0) {
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename="EXPORT_RESEAUX_DE_SOINS_' . date('dmYhis', time()) . '.txt"');

                        $fp = fopen('php://output', 'wb');
                        fwrite($fp, str_pad("CODE", 1, ' ', STR_PAD_RIGHT) . "\t\t\t" . str_pad("LIBELLE", 45, ' ', STR_PAD_RIGHT) . "\t\t\t" . str_pad("DATE EFFET", 10, ' ', STR_PAD_RIGHT) . "\n");
                        foreach ($reseaux as $reseau) {
                            fwrite($fp, str_pad($reseau['code'], 1, ' ', STR_PAD_RIGHT) . "\t\t\t" . str_pad($reseau['libelle'], 45, ' ', STR_PAD_RIGHT) . "\t\t\t" . str_pad(date('d/m/Y', strtotime($reseau['date_debut'])), 10, ' ', STR_PAD_RIGHT) . "\n");
                        }
                        fclose($fp);
                    }
                }
                elseif($data == 'res_etab') {
                    require "../_CONFIGS/Classes/RESEAUXDESOINS.php";
                    $RESEAUXDESOINS = new RESEAUXDESOINS();
                    $reseaux = $RESEAUXDESOINS->lister_reseau_etablissements(null);
                    $nb_reseaux = count($reseaux);
                    if ($nb_reseaux != 0) {
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename="EXPORT_RESEAUX_DE_SOINS_ETABLISSEMENTS_' . date('dmYhis', time()) . '.txt"');

                        $fp = fopen('php://output', 'wb');
                        fwrite($fp, str_pad("CODE RESEAU", 1, ' ', STR_PAD_RIGHT) . "\t\t\t" . str_pad("CODE ETABLISSEMENT", 45, ' ', STR_PAD_RIGHT) . "\t\t\t" . str_pad("DATE EFFET", 10, ' ', STR_PAD_RIGHT) . "\n");
                        foreach ($reseaux as $reseau) {
                            fwrite($fp, str_pad($reseau['code_reseau'], 1, ' ', STR_PAD_RIGHT) . "\t\t\t" . str_pad($reseau['code_etablissement'], 45, ' ', STR_PAD_RIGHT) . "\t\t\t" . str_pad(date('d/m/Y', strtotime($reseau['date_debut'])), 10, ' ', STR_PAD_RIGHT) . "\n");
                        }
                        fclose($fp);
                    }
                }
                elseif($data == 'res_acte') {
                    require "../_CONFIGS/Classes/RESEAUXDESOINS.php";
                    $RESEAUXDESOINS = new RESEAUXDESOINS();
                    $reseaux = $RESEAUXDESOINS->lister_reseau_actes_medicaux(null);
                    $nb_reseaux = count($reseaux);
                    if ($nb_reseaux != 0) {
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename="EXPORT_RESEAUX_DE_SOINS_ACTES_MEDICAUX_' . date('dmYhis', time()) . '.txt"');

                        $fp = fopen('php://output', 'wb');
                        fwrite($fp, str_pad("CODE RESEAU", 1, ' ', STR_PAD_RIGHT) . "\t\t\t" . str_pad("CODE ETABLISSEMENT", 45, ' ', STR_PAD_RIGHT) . "\t\t\t" . str_pad("DATE EFFET", 10, ' ', STR_PAD_RIGHT) . "\n");
                        foreach ($reseaux as $reseau) {
                            fwrite($fp, str_pad($reseau['code_reseau'], 1, ' ', STR_PAD_RIGHT) . "\t\t\t" . str_pad($reseau['code_acte'], 45, ' ', STR_PAD_RIGHT) . "\t\t\t" . str_pad(date('d/m/Y', strtotime($reseau['date_debut'])), 10, ' ', STR_PAD_RIGHT) . "\n");
                        }
                        fclose($fp);
                    }
                }
                elseif($data == 'res_med') {
                    require "../_CONFIGS/Classes/RESEAUXDESOINS.php";
                    $RESEAUXDESOINS = new RESEAUXDESOINS();
                    $reseaux_medicaments = $RESEAUXDESOINS->lister_reseau_medicaments(null);
                    $nb_reseaux_medicaments = count($reseaux_medicaments);
                    if($nb_reseaux_medicaments != 0) {
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename="EXPORT_RESEAUX_DE_SOINS_MEDICAMENTS_'.date('dmYhis',time()).'.txt"');

                        $fp = fopen('php://output', 'wb');
                        fwrite($fp, str_pad("CODE",7,' ',STR_PAD_RIGHT)."\t\t\t".str_pad("CODE MEDICAMENT",7,' ',STR_PAD_RIGHT)."\t\t\t".str_pad("TARIF",100,' ',STR_PAD_RIGHT)."\t\t\t".str_pad("DATE EFFET",10,' ',STR_PAD_RIGHT)."\n");
                        foreach ($reseaux_medicaments as $reseau_medicament) {
                            fwrite($fp, str_pad($reseau_medicament['code_reseau'],7,' ',STR_PAD_RIGHT)."\t\t\t".str_pad($reseau_medicament['code_medicament'],7,' ',STR_PAD_RIGHT)."\t\t\t".str_pad($reseau_medicament['tarif'],100,' ',STR_PAD_RIGHT)."\t\t\t".str_pad(date('d/m/Y',strtotime($reseau_medicament['date_debut'])),10,' ',STR_PAD_RIGHT)."\n");
                        }
                        fclose($fp);
                    }
                }
            }
            else {
                echo "<script>window.close();</script>";
            }
            $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, "EXPORT DU RESEAU DE SOINS AU FORMAT " . strtoupper($type), $file_name);
        } else {
            echo "<script>window.close();</script>";
        }
    } else {
        echo "<script>window.close();</script>";
    }
} else {
    echo "<script>window.close();</script>";
}