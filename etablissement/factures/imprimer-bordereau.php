<?php
require_once '../../_CONFIGS/Classes/UTILISATEURS.php';
require_once '../../_CONFIGS/Functions/Functions.php';
if (isset($_GET['num']) && clean_data($_GET['num'])) {
    $parametres = array(
        'num_bordereau' => clean_data($_GET['num'])
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
                            $bordereau = $ETABLISSEMENTS->trouver_bordereau($ets['code'], $parametres['num_bordereau']);
                            if ($bordereau) {
                                $factures = $ETABLISSEMENTS->lister_bordereau_factures($bordereau['num_bordereau']);
                                $nb_factures = count($factures);
                                if ($nb_factures != 0) {
                                    $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, 'IMPRESSION BORDEREAU', json_encode($parametres));
                                    if ($audit['success'] == true) {
                                        require_once "../../vendor/autoload.php";
                                        require_once "../../vendor/tecnick.com/tcpdf/tcpdf.php";

                                        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
                                        $pdf->SetCreator(PDF_CREATOR);
                                        $pdf->SetAuthor(AUTHOR);
                                        $pdf->SetSubject('BORDEREAU N° '.$bordereau['num_bordereau']);

                                        // set default header data
                                        $pdf->setPrintHeader(false);
                                        $pdf->setPrintFooter(true);


                                        // set text shadow effect
                                        $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

                                        // Set some content to print
                                        //$pdf->Image(IMAGES.'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'P', true, 150, '', false, false, 0, false, false, false);
                                        $file_name = "BORDEREAU_".$bordereau['num_bordereau'].".pdf";
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
                                        $pdf->writeHTMLCell(100, 0, 50, 25, 'BORDEREAU DE TRANSMISSION <br/>N° '.str_pad($bordereau['num_bordereau'], 20, '*', STR_PAD_LEFT), 1, 1, 0, true, 'C', true);
                                        $pdf->SetFont('helvetica', '', 8, '', true);
                                        $pdf->writeHTMLCell(0, 0, 10, 32, '<b>Date:</b> '.date('d/m/Y H:i', strtotime($bordereau['date_creation'])), 0, 1, 0, true, 'R', true);
                                        $pdf->SetFont('helvetica', '', 10, '', true);
                                        $pdf->writeHTMLCell(0, 0, 10, 40, 'Organisme', 0, 1, null, false, 'L', false);
                                        $pdf->SetFont('helvetica', 'B', 10, '', true);
                                        $pdf->writeHTMLCell(0, 0, 45, 40, $bordereau['libelle_organisme'], 0, 1, null, false, 'L', false);

                                        $pdf->SetFont('helvetica', '', 10, '', true);
                                        $pdf->writeHTMLCell(0, 0, 130, 40, 'Période', 0, 1, null, false, 'L', false);
                                        $pdf->SetFont('helvetica', 'B', 10, '', true);
                                        $pdf->writeHTMLCell(0, 0, 140, 40, 'Du '.date('d/m/Y', strtotime($bordereau['date_debut'])).' au '.date('d/m/Y', strtotime($bordereau['date_fin'])), 0, 1, null, false, 'R', false);

                                        $pdf->SetFont('helvetica', '', 10, '', true);
                                        $pdf->writeHTMLCell(0, 0, 10, 45, 'Type', 0, 1, null, false, 'L', false);
                                        $pdf->SetFont('helvetica', 'B', 10, '', true);
                                        $pdf->writeHTMLCell(0, 0, 45, 45, $bordereau['libelle_type_facture'], 0, 1, null, false, 'L', false);

                                        $pdf->SetFont('helvetica', '', 10, '', true);
                                        $pdf->writeHTMLCell(0, 0, 10, 50, 'Nombre de factures', 0, 1, null, false, 'L', false);
                                        $pdf->SetFont('helvetica', 'B', 10, '', true);
                                        $pdf->writeHTMLCell(0, 0, 45, 50, number_format($bordereau['nombre_factures'], '0', '', ' '), 0, 1, null, false, 'L', false);

                                        $pdf->SetFont('helvetica', '', 10, '', true);
                                        $pdf->writeHTMLCell(0, 0, 80, 50, 'Nombre d\'actes', 0, 1, null, false, 'L', false);
                                        $pdf->SetFont('helvetica', 'B', 10, '', true);
                                        $pdf->writeHTMLCell(0, 0, 110, 50, number_format($bordereau['nombre_actes'], '0', '', ' '), 0, 1, null, false, 'L', false);


                                        $pdf->Ln();
                                        $pdf->SetFillColor(204, 204, 204);
                                        $pdf->SetFont('helvetica', 'B', 6, '', true);

                                        $pdf->cell(10, 0, '#', 1, null, null, 1, null, null, null, null, null);
                                        $pdf->cell(25, 0, 'N° SECU', 1, null, null, 1, null, null, null, null, null);
                                        $pdf->cell(27, 0, 'N° FACTURE', 1, null, null, 1, null, null, null, null, null);
                                        $pdf->cell(27, 0, 'N° FS. INIT.', 1, null, null, 1, null, null, null, null, null);
                                        $pdf->cell(20, 0, 'DATE SOINS', 1, null, null, 1, null, null, null, null, null);
                                        $pdf->cell(20, 0, 'DEPENSE', 1, null, null, 1, null, null, null, null, null);
                                        $pdf->cell(20, 0, 'PART CMU', 1, null, null, 1, null, null, null, null, null);
                                        $pdf->cell(20, 0, 'PART RC', 1, null, null, 1, null, null, null, null, null);
                                        $pdf->cell(20, 0, 'PART PATIENT', 1, 1, null, 1, null, null, null, null, null);

                                        $pdf->SetFont('helvetica', '', 6, '', true);
                                        $ligne = 1;
                                        $montant_depense = 0;
                                        $montant_rgb = 0;
                                        $montant_rc = 0;
                                        $montant_patient = 0;
                                        foreach ($factures as $facture) {
                                            $pdf->cell(10, 0, $ligne, 1, null, 'R', 1, null, null, null, null, null);
                                            $pdf->cell(25, 0, $facture['num_population'], 1, null, 'R', null, null, null, null, null, null);
                                            $pdf->cell(27, 0, $facture['num_bon'], 1, null, 'R', null, null, null, null, null, null);
                                            $pdf->cell(27, 0, '', 1, null, 'R', null, null, null, null, null, null);
                                            $pdf->cell(20, 0, date('d/m/Y', strtotime($facture['date_soins'])), 1, null, 'C', null, null, null, null, null, null);
                                            $pdf->cell(20, 0, number_format($facture['montant_depense'], '0', '', ' '), 1, null, 'R', null, null, null, null, null, null);
                                            $pdf->cell(20, 0, number_format($facture['montant_rgb'], '0', '', ' '), 1, null, 'R', null, null, null, null, null, null);
                                            $pdf->cell(20, 0, number_format($facture['montant_rc'], '0', '', ' '), 1, null, 'R', null, null, null, null, null, null);
                                            $pdf->cell(20, 0, number_format($facture['montant_patient'], '0', '', ' '), 1, 1, 'R', null, null, null, null, null, null);
                                            $ligne++;
                                            $montant_depense += $facture['montant_depense'];
                                            $montant_rgb += $facture['montant_rgb'];
                                            $montant_rc += $facture['montant_rc'];
                                            $montant_patient += $facture['montant_patient'];
                                        }
                                        $pdf->SetFont('helvetica', 'B', 6, '', true);
                                        $pdf->cell(109, 0, 'TOTAL', 1, null, 'L', 1, null, null, null, null, null);
                                        $pdf->cell(20, 0, number_format($montant_depense, '0', '', ' '), 1, null, 'R', 1, null, null, null, null, null);
                                        $pdf->cell(20, 0, number_format($montant_rgb, '0', '', ' '), 1, null, 'R', 1, null, null, null, null, null);
                                        $pdf->cell(20, 0, number_format($montant_rc, '0', '', ' '), 1, null, 'R', 1, null, null, null, null, null);
                                        $pdf->cell(20, 0, number_format($montant_patient, '0', '', ' '), 1, 1, 'R', 1, null, null, null, null, null);

                                        $pdf->Ln();
                                        $pdf->Ln();
                                        $pdf->SetFont('helvetica', 'B', 8, '', true);
                                        $pdf->cell(63, 0, 'MONTANT CMU', 1, null, 'C', 1, null, null, null, null, null);
                                        $pdf->cell(63, 0, 'MONTANT ORGANISME', 1, null, 'C', 1, null, null, null, null, null);
                                        $pdf->cell(63, 0, 'MONTANT TOTAL', 1, 1, 'C', 1, null, null, null, null, null);

                                        $pdf->cell(63, 0, number_format($montant_rgb, '0', '', ' ').' '.$ets['libelle_monnaie'], 1, null, 'R', null, null, null, null, null, null);
                                        $pdf->cell(63, 0, number_format($montant_rc, '0', '', ' ').' '.$ets['libelle_monnaie'], 1, null, 'R', null, null, null, null, null, null);
                                        $pdf->cell(63, 0, number_format(($montant_rc + $montant_rgb), '0', '', ' ').' '.$ets['libelle_monnaie'], 1, 1, 'R', null, null, null, null, null, null);

                                        $pdf->SetFont('helvetica', 'BI', 8, '', true);
                                        $pdf->cell(189, 10, 'arrêté la présente facture la somme de: '.strtoupper(str_replace('zero', '', chiffres_en_lettres((int)($montant_rc + $montant_rgb)))).' '.$ets['libelle_monnaie'], null, 1, 'C', null, null, null, null, null, null);


                                        $pdf->SetFont('helvetica', 'BU', 8, '', true);
                                        $pdf->cell(189, 10, 'SIGNATURE', null, 1, 'R', null, null, null, null, null, null);

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
