<?php
require_once '../../_CONFIGS/Classes/UTILISATEURS.php';
require_once '../../_CONFIGS/Functions/Functions.php';
if (isset($_GET['code']) && clean_data($_GET['code'])) {
    $parametres = array(
        'code_dossier' => clean_data($_GET['code'])
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

                                    $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, 'IMPRESSION DOSSIER PATIENT', json_encode($parametres));
                                    if ($audit['success'] === true) {
                                        $qr_code = array(
                                            'num_patient' => $dossier['num_population'],
                                            'nom_prenoms' => $dossier['nom'].' '.$dossier['prenom'],
                                            'age' => $age,
                                            'sexe' => $dossier['code_sexe'],
                                            'num_dossier' => $dossier['code_dossier'],
                                            'date_dossier' => date('d-m-Y', strtotime($dossier['date_debut']))
                                        );
                                        require_once "../../vendor/autoload.php";

                                        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
                                        $pdf->SetCreator(PDF_CREATOR);
                                        $pdf->SetAuthor(AUTHOR);
                                        $pdf->SetSubject('DOSSIER N° '.$dossier['code_dossier']);

                                        // set default header data
                                        $pdf->setPrintHeader(false);
                                        $pdf->setPrintFooter(true);


                                        // set text shadow effect
                                        $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

                                        // Set some content to print
                                        $file_name = "DOSSIER_".$dossier['code_dossier'].".pdf";
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
                                        $pdf->writeHTMLCell(100, 0, 50, 25, "DOSSIER MEDICAL N° ".$dossier['code_dossier'], 1, 1, 0, true, 'C', true);


                                        $pdf->write2DBarcode(json_encode($qr_code), 'QRCODE,H', 172, 15, 25, 25, null, null, true);

                                        $pdf->SetFont('helvetica', '', 10, '', true);
                                        $pdf->SetFillColor(200, 220, 255);
                                        $pdf->writeHTMLCell(0, 0, 10, 45, 'Etab. payeur / Sociétaire', 0, 1, 0, true, 'L', true);
                                        $pdf->SetFont('helvetica', 'B', 10, '', true);
                                        $pdf->writeHTMLCell(0, 0, 60, 45, '', 0, 1, 1, true, 'L', true);

                                        $pdf->SetFont('helvetica', '', 10, '', true);
                                        $pdf->writeHTMLCell(0, 0, 10, 50, "Numéro d'Identifiaction Pers.", 0, 1, 0, true, 'L', true);
                                        $pdf->SetFont('helvetica', 'B', 10, '', true);
                                        $pdf->writeHTMLCell(0, 0, 60, 50, $dossier['num_population'], 0, 1, 1, true, 'L', true);

                                        $pdf->SetFont('helvetica', '', 10, '', true);
                                        $pdf->writeHTMLCell(0, 0, 10, 55, 'Numéro de sécurité sociale', 0, 1, 0, true, 'L', true);
                                        $pdf->SetFont('helvetica', 'B', 10, '', true);
                                        $pdf->writeHTMLCell(0, 0, 60, 55, $dossier['num_rgb'], 0, 1, 1, true, 'L', true);

                                        $pdf->SetFont('helvetica', '', 10, '', true);
                                        $pdf->writeHTMLCell(0, 0, 10, 60, 'Nom & prénom(s) patient(e)', 0, 1, 0, true, 'L', true);
                                        $pdf->SetFont('helvetica', 'B', 10, '', true);
                                        $pdf->writeHTMLCell(0, 0, 60, 60, $dossier['code_civilite'].'. '.$dossier['nom'].' '.$dossier['prenom'].' ('.$dossier['code_sexe'].')', 0, 1, 1, true, 'L', true);

                                        $pdf->SetFont('helvetica', '', 10, '', true);
                                        $pdf->writeHTMLCell(0, 0, 10, 65, 'Date de naissance / Age', 0, 1, 0, true, 'L', true);
                                        $pdf->SetFont('helvetica', 'B', 10, '', true);
                                        $pdf->writeHTMLCell(0, 0, 60, 65, date('d/m/Y', strtotime($dossier['date_naissance'])).' ('.$age.' ans)', 0, 1, 1, true, 'L', true);

                                        if ($dossier['date_fin']) {
                                            $date_fin = '- <b>Date fin:</b> '.date('d/m/Y', strtotime($dossier['date_fin']));
                                        } else {
                                            $date_fin = null;
                                        }

                                        $pdf->SetFont('helvetica', '', 8, '', true);
                                        $pdf->writeHTMLCell(0, 0, 10, 70, '<b>Date début:</b> '.date('d/m/Y', strtotime($dossier['date_debut'])).' '.$date_fin, 0, 1, 0, true, 'R', true);



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
}
