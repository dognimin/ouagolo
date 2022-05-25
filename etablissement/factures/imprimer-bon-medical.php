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
                require_once "../../_CONFIGS/Classes/ORGANISMES.php";
                require_once "../../_CONFIGS/Classes/DOSSIERS.php";
                $FACTURESMEDICALES = new FACTURESMEDICALES();
                $ETABLISSEMENTS = new ETABLISSEMENTS();
                $ORGANISMES = new ORGANISMES();
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
                                $dossier = $ETABLISSEMENTS->trouver_dossier($ets['code'], $facture['code_dossier']);
                                if ($dossier) {
                                    $actes = $FACTURESMEDICALES->lister_actes($facture['num_facture']);
                                    $nb_actes = count($actes);
                                    if ($nb_actes != 0) {
                                        $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, 'IMPRESSION FACTURE', json_encode($parametres));
                                        if ($audit['success'] == true) {
                                            $organisme = $ORGANISMES->trouver($facture['code_organisme']);
                                            $ps = $ETABLISSEMENTS->trouver_professionnel_de_sante($ets['code'], $dossier['code_professionnel']);

                                            require "../../vendor/autoload.php";
                                            require "../../vendor/tecnick.com/tcpdf/tcpdf.php";

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
                                            $file_name = "FACTURE_".$facture['num_facture'].".pdf";
                                            $pdf->SetTitle($file_name);
                                            $pdf->AddPage('P');

                                            $pdf->SetFont('helvetica', '', 3, '', true);
                                            $pdf->writeHTMLCell(0, 0, 0, 0, 'Ouagolo', 0, 1, 0, true, 'R', false);
                                            $pdf->SetFont('courier', '', 10, '', true);

                                            $pdf->writeHTMLCell(48, 0, 7, 32, date('d/m/Y', strtotime($facture['date_soins'])), null, 0, 0, true, 'C', true);
                                            $pdf->writeHTMLCell(48, 0, 49, 32, $facture['code_organisme'], null, 0, 0, true, 'C', true);
                                            $pdf->writeHTMLCell(96, 0, 98, 32, $facture['nom'].' '.$facture['prenom'], null, 1, 0, true, 'C', true);

                                            $pdf->writeHTMLCell(48, 0, 7, 42, 'xxxxxx', null, 0, 0, true, 'C', true);
                                            $pdf->writeHTMLCell(48, 0, 49, 42, $facture['num_bon'], null, 0, 0, true, 'C', true);
                                            $pdf->writeHTMLCell(40, 0, 102, 42, $facture['num_population'], null, 0, 0, true, 'C', true);
                                            $pdf->writeHTMLCell(40, 0, 140, 42, date('d/m/Y', strtotime($facture['date_naissance'])), null, 0, 0, true, 'C', true);
                                            $pdf->writeHTMLCell(15, 0, 180, 42, 'X', null, 1, 0, true, str_replace('M', 'L', str_replace('F', 'R', $facture['code_sexe'])), true);

                                            $pdf->writeHTMLCell(48, 0, 7, 52, $facture['num_rgb_entente_prealable'], null, 0, 0, true, 'C', true);
                                            $pdf->writeHTMLCell(48, 0, 49, 52, $facture['num_organisme_entente_prealable'], null, 0, 0, true, 'C', true);
                                            $pdf->writeHTMLCell(40, 0, 102, 52, 'xxx', null, 0, 0, true, 'C', true);
                                            $pdf->writeHTMLCell(20, 0, 140, 52, $organisme['code'], null, 0, 0, true, 'C', true);
                                            $pdf->writeHTMLCell(60, 0, 160, 52, $organisme['libelle'], null, 1, 0, true, 'L', true);

                                            $pdf->writeHTMLCell(48, 0, 7, 67, $ets['code'], null, 0, 0, true, 'C', true);
                                            $pdf->writeHTMLCell(162, 0, 49, 67, $ets['raison_sociale'], null, 0, 0, true, 'L', true);

                                            if ($ps) {
                                                $pdf->writeHTMLCell(48, 0, 7, 82, $ps['code_professionnel'], null, 0, 0, true, 'C', true);
                                                $pdf->writeHTMLCell(112, 0, 49, 82, $ps['nom'].' '.$ps['prenom'], null, 0, 0, true, 'L', true);
                                                $pdf->writeHTMLCell(100, 0, 150, 82, $ps['libelle_specialite_medicale'], null, 0, 0, true, 'L', true);
                                            }
                                            $pdf->Ln();
                                            $pdf->Ln();
                                            $pdf->Ln();
                                            $pdf->Ln();
                                            $pdf->Ln();
                                            $pdf->Ln();
                                            $pdf->Ln();
                                            $pdf->Ln();
                                            $pdf->Ln();
                                            $pdf->Ln();
                                            $pdf->Ln();
                                            $pdf->Ln();
                                            $ligne_y = 110;

                                            foreach ($actes as $acte) {
                                                $pdf->cell(20, 10, $acte['code'], null, null, 'L', null, null, null, null, null, null);
                                                $pdf->cell(55, 10, $acte['libelle'], null, null, 'L', null, null, 1, null, null, null);
                                                $pdf->cell(15, 10, date('d/m/Y', strtotime($dossier['date_debut'])), null, null, 'L', null, null, 1, null, null, null);
                                                $pdf->cell(15, 10, date('d/m/Y', strtotime($dossier['date_debut'])), null, null, 'L', null, null, 1, null, null, null);
                                                $pdf->cell(5, 10, $acte['quantite'], null, null, 'C', null, null, 1, null, null, null);
                                                $pdf->cell(20, 10, number_format($acte['montant_depense'], '0', '', ' '), null, null, 'R', null, null, 1, null, null, null);
                                                $pdf->cell(20, 10, number_format($acte['montant_rgb'], '0', '', ' '), null, null, 'R', null, null, 1, null, null, null);
                                                $pdf->cell(20, 10, number_format($acte['montant_rc'], '0', '', ' '), null, null, 'R', null, null, 1, null, null, null);
                                                $pdf->cell(20, 10, number_format($acte['montant_patient'], '0', '', ' '), null, 1, 'R', null, null, 1, null, null, null);

                                            }

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
