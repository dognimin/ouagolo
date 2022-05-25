<?php
require_once '../../_CONFIGS/Classes/UTILISATEURS.php';
require_once '../../_CONFIGS/Functions/Functions.php';
if (isset($_GET['num']) && clean_data($_GET['num'])) {
    $parametres = array(
        'code_dossier' => clean_data($_GET['code-dossier']),
        'num_ordonnance' => clean_data($_GET['num'])
    );
    if (isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if ($session) {
            $utilisateur = $UTILISATEURS->trouver($session['id_user'], null);
            if ($utilisateur) {
                require_once "../../_CONFIGS/Classes/ETABLISSEMENTS.php";
                require_once "../../_CONFIGS/Classes/FACTURESMEDICALES.php";
                require_once "../../_CONFIGS/Classes/DOSSIERS.php";
                $FACTURESMEDICALES = new FACTURESMEDICALES();
                $ETABLISSEMENTS = new ETABLISSEMENTS();
                $DOSSIERS = new DOSSIERS();
                $profil = $UTILISATEURS->trouver_profil($utilisateur['id_user']);
                if ($profil) {
                    $user_profil = $UTILISATEURS->trouver_utilisateur_ets($utilisateur['id_user']);
                    if ($user_profil) {
                        $ets = $ETABLISSEMENTS->trouver($user_profil['code_etablissement'], null);
                        if ($ets) {
                            $coordonnees = $ETABLISSEMENTS->lister_coordonnees($ets['code']);
                            $siteweb = null;
                            $telpro = null;
                            $emailpro = null;
                            foreach ($coordonnees as $coordonnee) {
                                if ($coordonnee['code_type'] == 'TELPRO') {
                                    $telpro = '(+'.$ets['indicatif_telephonique'].') '.$coordonnee['valeur'].' / ';
                                }
                                if ($coordonnee['code_type'] == 'SITWEB') {
                                    $siteweb = $coordonnee['valeur'];
                                }
                                if ($coordonnee['code_type'] == 'MELPRO') {
                                    $emailpro = $coordonnee['valeur'].' / ';
                                }
                            }
                            $dossier_patient = $ETABLISSEMENTS->trouver_dossier($ets['code'], $parametres['code_dossier']);
                            if ($dossier_patient) {
                                $dossier = $DOSSIERS->trouver($dossier_patient['code_dossier']);
                                if ($dossier) {
                                    $ps = $ETABLISSEMENTS->trouver_professionnel_de_sante($ets['code'], $dossier_patient['code_professionnel']);
                                    $tz  = new DateTimeZone('Africa/Abidjan');
                                    $age = DateTime::createFromFormat('Y-m-d', $dossier['date_naissance'], $tz)
                                        ->diff(new DateTime('now', $tz))
                                        ->y;
                                    $ordonnance = $DOSSIERS->trouver_ordonnance($dossier['code_dossier'], $parametres['num_ordonnance']);
                                    if ($ordonnance) {
                                        $medicaments = $DOSSIERS->lister_ordonnance_medicaments($ordonnance['code']);
                                        $nb_medicaments = count($medicaments);
                                        if ($nb_medicaments != 0) {
                                            $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, 'IMPRESSION ORDONNANCE', json_encode($parametres));
                                            if ($audit['success'] == true) {

                                                $qr_code = array(
                                                    'num_patient' => $dossier['num_population'],
                                                    'nom_prenoms' => $dossier['nom'].' '.$dossier['prenom'],
                                                    'age' => $age,
                                                    'sexe' => $dossier['code_sexe'],
                                                    'num_ordonnance' => $ordonnance['code'],
                                                    'date_ordonnance' => date('d-m-Y', strtotime($ordonnance['date_creation']))
                                                );
                                                require_once "../../vendor/autoload.php";
                                                require_once "../../vendor/tecnick.com/tcpdf/tcpdf.php";

                                                $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
                                                $pdf->SetCreator(PDF_CREATOR);
                                                $pdf->SetAuthor(AUTHOR);
                                                $pdf->SetSubject('ORDONNANCE N° '.$ordonnance['code']);

                                                // set default header data
                                                $pdf->setPrintHeader(false);
                                                $pdf->setPrintFooter(true);


                                                // set text shadow effect
                                                $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

                                                // Set some content to print
                                                $file_name = "ORDONNANCE_".$ordonnance['code'].".pdf";
                                                $pdf->SetTitle($file_name);
                                                $pdf->AddPage('P');

                                                $pdf->SetFont('helvetica', '', 3, '', true);
                                                $pdf->writeHTMLCell(0, 0, 0, 0, 'Ouagolo', 0, 1, 0, true, 'R', false);

                                                $pdf->SetFont('helvetica', '', 13, '', true);
                                                $pdf->Image('../../_PUBLICS/images/logos/etablissements/'.$ets['code'].'/'.$ets['logo'], 10, 2, null, 30, strtoupper(str_replace('.', '', pathinfo($ets['logo'], PATHINFO_EXTENSION))), '', 'T', false, 300, '', false, false, 0, false, false, false);
                                                $pdf->writeHTMLCell(0, 0, 0, 5, '<h4>'.$ets['raison_sociale'].'</h4>', 0, 1, 0, true, 'C', true);
                                                $pdf->SetFont('helvetica', '', 8, '', true);
                                                $pdf->writeHTMLCell(0, 0, 0, 10, $ets['adresse_postale'], 0, 1, 0, true, 'C', true);
                                                $pdf->writeHTMLCell(0, 0, 0, 13, $ets['region'].', '.$ets['commune'], 0, 1, 0, true, 'C', true);
                                                $pdf->writeHTMLCell(0, 0, 0, 16, $ets['adresse_geographique'], 0, 1, 0, true, 'C', true);
                                                $pdf->writeHTMLCell(0, 0, 0, 19, $telpro.str_replace('http://', '', str_replace('https://', '', $siteweb)), 0, 1, 0, true, 'C', true);
                                                $pdf->SetFont('helvetica', 'B', 13, '', true);
                                                $pdf->writeHTMLCell(100, 0, 50, 25, "ORDONNANCE MEDICALE", 1, 1, 0, true, 'C', true);

                                                $pdf->write2DBarcode(json_encode($qr_code), 'QRCODE,H', 172, 15, 25, 25, null, null, true);

                                                $pdf->SetFont('helvetica', '', 10, '', true);
                                                $pdf->writeHTMLCell(0, 0, 10, 40, '<b>N° I.P :</b> '.$dossier['num_population'], 0, 1, 0, true, 'L', true);
                                                $pdf->writeHTMLCell(0, 0, 10, 40, '<b>N° sécu :</b> '.$dossier['num_rgb'], 0, 1, 0, true, 'C', true);
                                                $pdf->writeHTMLCell(0, 0, 10, 46, '<b>N° Ordonnance:</b> '.$ordonnance['code'], 0, 1, 0, true, 'L', true);

                                                $pdf->writeHTMLCell(0, 0, 10, 52, '<b>Nom & Prénom(s) :</b> '.$dossier['code_civilite'].'. '.$dossier['nom'].' '.$dossier['prenom'], 0, 1, 0, true, 'L', true);
                                                $pdf->writeHTMLCell(0, 0, 10, 58, '<b>Age:</b> '.$age.' ans', 0, 1, 0, true, 'L', true);
                                                $pdf->writeHTMLCell(0, 0, 10, 58, '<b>Sexe:</b> '.$dossier['code_sexe'], 0, 1, 0, true, 'C', true);
                                                $pdf->writeHTMLCell(0, 0, 10, 58, '<b>Date:</b> '.date('d/m/Y H:i', strtotime($ordonnance['date_creation'])), 0, 1, 0, true, 'R', true);
                                                $pdf->SetFont('helvetica', 'B', 10, '', true);
                                                $pdf->SetFillColor(200, 220, 255);

                                                $pdf->Ln();
                                                $pdf->cell(48, 0, 'Code', 1, null, null, 1, null, null, null, null, null);
                                                $pdf->cell(140, 0, 'Nature', 1, 1, null, 1, null, null, null, null, null);

                                                $pdf->SetFont('helvetica', '', 10, '', true);
                                                $pdf->SetFillColor(255, 255, 255);
                                                foreach ($medicaments as $medicament) {
                                                    $pdf->cell(48, 9.2, $medicament['code'], 1, null, null, 1, null, null, null, null, null);
                                                    $pdf->cell(140, 0, $medicament['libelle'], 1, 1, null, 1, null, null, null, null, null);

                                                    $pdf->cell(48, 0, "", null, null, null, null, null, null, null, null, null);
                                                    $pdf->cell(140, 0, $medicament['posologie'].' '.$medicament['duree'].' '.$medicament['unite_duree'], 1, 1, null, 1, null, null, null, null, null);
                                                }

                                                $pdf->cell(188, 10, '', null, 1, null, null, null, null, null, null, null);


                                                $pdf->SetFont('helvetica', 'BU', 10, '', true);
                                                $pdf->cell(100, 0, "", 0, null, 'C', null, null, null, null, null, null);
                                                $pdf->cell(88, 0, "LE MEDECIN", 0, 1, 'C', null, null, null, null, null, null);

                                                $pdf->SetFont('helvetica', '', 10, '', true);
                                                $pdf->cell(100, 0, "", 0, null, 'C', null, null, null, null, null, null);
                                                $pdf->cell(88, 0, $ps['nom'].' '.$ps['prenom'], 0, 1, 'C', null, null, null, null, null, null);

                                                $pdf->Ln();
                                                $pdf->Ln();
                                                $pdf->Output($file_name, 'I');
                                            }
                                        } else {
                                            echo "<script>window.close();</script>";
                                        }
                                    } else {
                                        echo "<script>window.close();</script>";
                                    }
                                } else {
                                    echo "<script>window.close();</script>";
                                }
                            } else {
                                echo "<script>window.close();</script>";
                            }
                        } else {
                            echo "<script>window.close();</script>";
                        }
                    } else {
                        echo "<script>window.close();</script>";
                    }
                } else {
                    echo "<script>window.close();</script>";
                }
            } else {
                echo "<script>window.close();</script>";
            }
        } else {
            echo "<script>window.close();</script>";
        }
    } else {
        echo "<script>window.close();</script>";
    }
}
