<?php
require_once '../../_CONFIGS/Classes/UTILISATEURS.php';
require_once '../../_CONFIGS/Functions/Functions.php';
if (isset($_GET['num']) && clean_data($_GET['num'])) {
    $parametres = array(
        'num' => clean_data($_GET['num'])
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
                            $vente = $ETABLISSEMENTS->trouver_vente($ets['code'], $parametres['num']);
                            if ($vente) {
                                $produits = $ETABLISSEMENTS->lister_vente_produits($vente['num_ticket']);
                                $nb_produits = count($produits);
                                if ($nb_produits != 0) {
                                    $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, 'IMPRESSION TICKET VENTE', json_encode($parametres));
                                    if ($audit['success'] == true) {
                                        require_once "../../vendor/autoload.php";
                                        require_once "../../vendor/tecnick.com/tcpdf/tcpdf.php";

                                        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A7', true, 'UTF-8', false);
                                        $pdf->SetCreator(PDF_CREATOR);
                                        $pdf->SetAuthor(AUTHOR);
                                        $pdf->SetSubject('RECU N° '.$vente['num_ticket']);

                                        // set default header data
                                        $pdf->setPrintHeader(false);
                                        $pdf->setPrintFooter(false);


                                        // Set some content to print
                                        //$pdf->Image(IMAGES.'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'P', true, 150, '', false, false, 0, false, false, false);
                                        $file_name = "RECU_".$vente['num_ticket'].".pdf";
                                        $pdf->SetTitle($file_name);
                                        $pdf->AddPage('P');

                                        $pdf->write2DBarcode($vente['code_etablissement'].' | '.$vente['num_ticket'], 'QRCODE,Q', 33, 1, 10, 10, null, null, true);


                                        $pdf->SetFont('helvetica', 'B', 5, '', true);
                                        $pdf->Cell(0, 0, '', null, 1, 'C', '', '', true, '', '', '');

                                        $pdf->SetFont('helvetica', 'B', 7, '', true);
                                        $pdf->Cell(0, 0, $ets['raison_sociale'], null, 1, 'C', '', '', true, '', '', '');
                                        $pdf->SetFont('helvetica', '', 3, '', true);
                                        $pdf->Cell(0, 0, $ets['adresse_postale'], null, 1, 'C', '', '', true, '', '', '');
                                        $pdf->Cell(0, 0, $ets['region'].', '.$ets['commune'], null, 1, 'C', '', '', true, '', '', '');
                                        $pdf->Cell(0, 0, $ets['adresse_geographique'], null, 1, 'C', '', '', true, '', '', '');
                                        $pdf->Cell(0, 0, $telpro.str_replace('http://', '', str_replace('https://', '', $siteweb)), null, 1, 'C', '', '', true, '', '', '');

                                        $pdf->Ln();
                                        $pdf->SetFont('helvetica', 'B', 5, '', true);
                                        $pdf->Cell(0, 0, 'Reçu n° '.$vente['num_ticket'], null, 1, 'C', '', '', true, '', '', '');
                                        $pdf->SetFont('helvetica', '', 5, '', true);
                                        $pdf->Cell(0, 0, '-------------------------------------------------------------------', null, 1, 'C', '', '', true, '', '', '');
                                        $pdf->Ln();
                                        foreach ($produits as $produit) {
                                            $pdf->Cell(35, 0, $produit['libelle'], null, 0, 'L', '', '', false, '', '', '');
                                            $pdf->Cell(10, 0, $produit['quantite'], null, 0, 'L', '', '', false, '', '', '');
                                            $pdf->Cell(10, 0, number_format((int)($produit['prix_unitaire'] * $produit['quantite']), ' 0', '', ' ').' '.$ets['libelle_monnaie'], null, 1, 'R', '', '', false, '', '', '');
                                        }
                                        $pdf->Ln();
                                        $pdf->Ln();
                                        $pdf->Cell(0, 0, '-------------------------------------------------------------------', null, 1, 'C', '', '', true, '', '', '');
                                        $pdf->Cell(45, 0, 'TOTAL', null, 0, 'L', '', '', true, '', '', '');
                                        $pdf->Cell(10, 0, number_format((int)($vente['montant_brut']), ' 0', '', ' ').' '.$ets['libelle_monnaie'], null, 1, 'R', '', '', false, '', '', '');

                                        $pdf->Cell(45, 0, 'MONTANT RGB', null, 0, 'L', '', '', true, '', '', '');
                                        $pdf->Cell(10, 0, number_format((int)($vente['montant_rgb']), ' 0', '', ' ').' '.$ets['libelle_monnaie'], null, 1, 'R', '', '', false, '', '', '');

                                        $pdf->Cell(45, 0, 'MONTANT ORGANISME', null, 0, 'L', '', '', true, '', '', '');
                                        $pdf->Cell(10, 0, number_format((int)($vente['montant_organisme']), ' 0', '', ' ').' '.$ets['libelle_monnaie'], null, 1, 'R', '', '', false, '', '', '');

                                        $pdf->Cell(45, 0, 'REMISE', null, 0, 'L', '', '', true, '', '', '');
                                        $pdf->Cell(10, 0, number_format((int)($vente['taux_remise']), ' 0', '', ' ').' %', null, 1, 'R', '', '', false, '', '', '');

                                        $pdf->SetFont('helvetica', 'B', 5, '', true);
                                        $pdf->Cell(45, 0, 'NET A PAYER', null, 0, 'L', '', '', true, '', '', '');
                                        $pdf->Cell(10, 0, number_format((int)($vente['montant_net']), ' 0', '', ' ').' '.$ets['libelle_monnaie'], null, 1, 'R', '', '', false, '', '', '');


                                        $pdf->Ln();
                                        $pdf->Ln();
                                        $pdf->Cell(0, 0, 'Date: '.date('d/m/Y H:i', strtotime($vente['date_creation'])), null, 1, 'R', '', '', true, '', '', '');
                                        $pdf->Cell(0, 0, 'Caissier(e): '.$vente['prenoms_caissier'], null, 1, 'R', '', '', true, '', '', '');

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
