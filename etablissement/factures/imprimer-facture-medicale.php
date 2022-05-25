<?php
require_once '../../_CONFIGS/Classes/UTILISATEURS.php';
require_once '../../_CONFIGS/Functions/Functions.php';
if (isset($_GET['num']) && clean_data($_GET['num'])) {
    $parametres = array(
        'num_facture' => clean_data($_GET['num'])
    );
    if (isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if ($session) {
            $utilisateur = $UTILISATEURS->trouver($session['id_user'], null);
            if ($utilisateur) {
                require_once "../../_CONFIGS/Classes/ETABLISSEMENTS.php";
                require_once "../../_CONFIGS/Classes/FACTURESMEDICALES.php";
                require_once "../../_CONFIGS/Classes/PATIENTS.php";
                require_once "../../_CONFIGS/Classes/DOSSIERS.php";
                $FACTURESMEDICALES = new FACTURESMEDICALES();
                $ETABLISSEMENTS = new ETABLISSEMENTS();
                $PATIENTS = new PATIENTS();
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
                            $facture = $ETABLISSEMENTS->trouver_facture($ets['code'], $parametres['num_facture']);
                            if ($facture) {
                                $dossier = $DOSSIERS->trouver($facture['code_dossier']);
                                $organisme = $PATIENTS->trouver_organisme($facture['code_organisme'], $facture['num_population'], $facture['date_soins']);
                                if($organisme) {
                                    $collectivite = array(
                                        'code' => $organisme['code_collectivite'],
                                        'raison_sociale' => $organisme['raison_sociale']
                                    );
                                }else {
                                    $collectivite = array(
                                        'code' => null,
                                        'raison_sociale' => 'N/A'
                                    );
                                }
                                if ($dossier) {
                                    $actes = $FACTURESMEDICALES->lister_actes($facture['num_facture']);
                                    $nb_actes = count($actes);
                                    if ($nb_actes != 0) {
                                        $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, 'IMPRESSION FACTURE', json_encode($parametres));
                                        if ($audit['success'] == true) {
                                            require_once "../../vendor/autoload.php";
                                            require_once "../../vendor/tecnick.com/tcpdf/tcpdf.php";

                                            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
                                            $pdf->SetCreator(PDF_CREATOR);
                                            $pdf->SetAuthor(AUTHOR);
                                            $pdf->SetSubject('FACTURE N° '.$facture['num_facture']);

                                            // set default header data
                                            $pdf->setPrintHeader(false);
                                            $pdf->setPrintFooter(true);


                                            // set text shadow effect
                                            $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

                                            // Set some content to print
                                            //$pdf->Image(IMAGES.'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'P', true, 150, '', false, false, 0, false, false, false);
                                            $file_name = "FACTURE_".$facture['num_facture'].".pdf";
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
                                            $pdf->writeHTMLCell(100, 0, 50, 25, 'FACTURE N° '.$facture['num_facture'], 1, 1, 0, true, 'C', true);
                                            $pdf->SetFont('helvetica', '', 8, '', true);
                                            $pdf->writeHTMLCell(0, 0, 10, 32, '<b>Date:</b> '.date('d/m/Y H:i', strtotime($facture['date_creation'])), 0, 1, 0, true, 'R', true);
                                            $pdf->SetFont('helvetica', '', 10, '', true);
                                            $pdf->SetFillColor(200, 220, 255);
                                            $pdf->writeHTMLCell(0, 0, 10, 37, 'Etab. payeur / Sociétaire', 0, 1, 0, true, 'L', true);
                                            $pdf->SetFont('helvetica', 'B', 10, '', true);
                                            $pdf->writeHTMLCell(0, 0, 60, 37, $collectivite['raison_sociale'], 0, 1, 1, true, 'L', true);
                                            $pdf->SetFont('helvetica', '', 10, '', true);
                                            $pdf->writeHTMLCell(0, 0, 10, 42, 'Nom & prénom(s) patient(e)', 0, 1, 0, true, 'L', true);
                                            $pdf->SetFont('helvetica', 'B', 10, '', true);
                                            $pdf->writeHTMLCell(0, 0, 60, 42, $dossier['code_civilite'].'. '.$dossier['nom'].' '.$dossier['prenom'], 0, 1, 1, true, 'L', true);
                                            $pdf->SetFont('helvetica', '', 8, '', true);
                                            $pdf->writeHTMLCell(0, 0, 10, 50, 'N° BON', 0, 1, 0, true, 'L', true);
                                            $pdf->writeHTMLCell(0, 0, 60, 50, $facture['num_bon'], 0, 1, 0, true, 'L', true);
                                            $pdf->writeHTMLCell(0, 0, 120, 50, 'Service ', 0, 1, 0, true, 'L', true);

                                            $pdf->writeHTMLCell(0, 0, 10, 54, 'N.I.P', 0, 1, 0, true, 'L', true);
                                            $pdf->writeHTMLCell(0, 0, 60, 54, $facture['num_population'], 0, 1, 0, true, 'L', true);
                                            $pdf->writeHTMLCell(0, 0, 90, 54, 'N° SECU: '.$facture['num_rgb'], 0, 1, 0, true, 'L', true);
                                            $pdf->writeHTMLCell(0, 0, 147, 54, 'N° DOSSIER: '.$facture['code_dossier'], 0, 1, 0, true, 'L', true);

                                            $pdf->Ln();
                                            $pdf->SetFont('helvetica', 'B', 6, '', true);
                                            $pdf->cell(15, 0, 'Date', 1, null, null, 1, null, null, null, null, null);
                                            $pdf->cell(15, 0, 'Code acte', 1, null, null, 1, null, null, null, null, null);
                                            $pdf->cell(85, 0, 'Libellé acte', 1, null, null, 1, null, null, null, null, null);
                                            $pdf->cell(10, 0, 'Qté', 1, null, null, 1, null, null, null, null, null);
                                            $pdf->cell(10, 0, 'P.U.', 1, 0, null, 1, null, null, null, null, null);
                                            $pdf->cell(14, 0, 'Mt. Total', 1, 0, null, 1, null, null, null, null, null);
                                            $pdf->cell(14, 0, 'Mt. RGB', 1, 0, null, 1, null, null, null, null, null);
                                            $pdf->cell(14, 0, 'Mt. Assu.', 1, 0, null, 1, null, null, null, null, null);
                                            $pdf->cell(14, 0, 'Mt. Pat.', 1, 1, null, 1, null, null, null, null, null);

                                            $montant_depense = 0;
                                            $montant_rgb = 0;
                                            $montant_rc = 0;
                                            $montant_patient = 0;
                                            foreach ($actes as $acte) {
                                                $pdf->SetFont('helvetica', '', 6, '', true);
                                                $pdf->cell(15, 4, date('d/m/Y', strtotime($acte['date_debut'])), null, null, null, 0, null, null, null, null, null);
                                                $pdf->cell(15, 4, $acte['code'], null, null, null, 0, null, null, null, null, null);
                                                $pdf->cell(85, 4, strlen($acte['libelle']) > 70 ? substr(strtolower($acte['libelle']), 0, 70)."..." : strtolower($acte['libelle']), null, null, null, 0, null, null, null, null, null);
                                                $pdf->cell(10, 4, number_format($acte['quantite'], '0', '', ' '), null, null, 'R', 0, null, null, null, null, null);
                                                $pdf->cell(10, 4, number_format($acte['prix_unitaire'], '0', '', ' '), null, 0, 'R', 0, null, null, null, null, null);
                                                $pdf->cell(14, 4, number_format($acte['montant_depense'], '0', '', ' '), null, 0, 'R', 0, null, null, null, null, null);
                                                $pdf->cell(14, 4, number_format($acte['montant_rgb'], '0', '', ' '), null, 0, 'R', 0, null, null, null, null, null);
                                                $pdf->cell(14, 4, number_format($acte['montant_rc'], '0', '', ' '), null, 0, 'R', 0, null, null, null, null, null);
                                                $pdf->cell(14, 4, number_format($acte['montant_patient'], '0', '', ' '), null, 1, 'R', 0, null, null, null, null, null);

                                                $montant_depense += $acte['montant_depense'];
                                                $montant_rgb += $acte['montant_rgb'];
                                                $montant_rc += $acte['montant_rc'];
                                                $montant_patient += $acte['montant_patient'];
                                            }

                                            $pdf->SetFont('helvetica', 'B', 6, '', true);
                                            $pdf->cell(135, 0, 'TOTAL', 1, null, null, 1, null, null, null, null, null);
                                            $pdf->cell(14, 0, number_format($montant_depense, '0', '', ' '), 1, 0, 'R', 1, null, null, null, null, null);
                                            $pdf->cell(14, 0, number_format($montant_rgb, '0', '', ' '), 1, 0, 'R', 1, null, null, null, null, null);
                                            $pdf->cell(14, 0, number_format($montant_rc, '0', '', ' '), 1, 0, 'R', 1, null, null, null, null, null);
                                            $pdf->cell(14, 0, number_format($montant_patient, '0', '', ' '), 1, 1, 'R', 1, null, null, null, null, null);

                                            $montant_remise = (int)($montant_patient * (int)$facture['taux_remise'] / 100);
                                            $montant_net = (int)($montant_patient - $montant_remise);

                                            $pdf->Ln();
                                            $pdf->SetFont('helvetica', '', 6, '', true);
                                            $pdf->cell(177, 4, 'Total', null, null, 'R', null, null, null, null, null, null);
                                            $pdf->cell(14, 4, number_format($montant_patient, '0', '', ' '), 1, 1, 'R', 0, null, null, null, null, null);

                                            $pdf->cell(177, 4, 'Remise '.(int)($facture['taux_remise']).'%', null, null, 'R', null, null, null, null, null, null);
                                            $pdf->cell(14, 4, number_format($montant_remise, '0', '', ' '), 1, 1, 'R', 0, null, null, null, null, null);

                                            $pdf->SetFont('helvetica', 'B', 6, '', true);
                                            $pdf->cell(177, 4, 'Montant net à payer', null, null, 'R', null, null, null, null, null, null);
                                            $pdf->cell(14, 4, number_format($montant_net, '0', '', ' '), 1, 1, 'R', 0, null, null, null, null, null);


                                            if ($montant_net != 0) {
                                                $pdf->Ln();
                                                $pdf->SetFont('helvetica', 'I', 10, '', true);
                                                $pdf->cell(191, 4, '* Montant en lettres: '.strtoupper(str_replace('zero', '', chiffres_en_lettres($montant_net))).' '.$ets['libelle_monnaie'], null, null, 'L', null, null, 1, null, null, null);
                                            }

                                            $pdf->Ln();
                                            $pdf->Ln();
                                            $pdf->SetFont('helvetica', 'U', 10, '', true);
                                            $pdf->cell(177, 9, 'RECEPTION', null, 1, 'C', null, null, null, null, null, null);

                                            $pdf->SetFont('helvetica', 'BI', 10, '', true);
                                            $pdf->cell(177, 4, $facture['nom_utilisateur'].' '.$facture['prenoms_utilisateur'], null, 1, 'C', null, null, null, null, null, null);
                                            $pdf->SetFont('helvetica', 'I', 10, '', true);
                                            $pdf->cell(177, 4, '------------------------------------------------------------------------------------------------------------------------------------------------', null, 1, 'C', null, null, null, null, null, null);

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
}
