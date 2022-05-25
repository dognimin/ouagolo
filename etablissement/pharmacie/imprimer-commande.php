<?php
require_once '../../_CONFIGS/Classes/UTILISATEURS.php';
require_once '../../_CONFIGS/Functions/Functions.php';
if (isset($_GET['num']) && clean_data($_GET['num'])) {
    $parametres = array(
        'code' => clean_data($_GET['num'])
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
                            $commande = $ETABLISSEMENTS->trouver_commande($ets['code'], $parametres['code']);

                            if ($commande) {
                                $produits = $ETABLISSEMENTS->lister_commande_produits($commande['code']);
                                $nb_produits = count($produits);
                                if ($nb_produits != 0) {
                                    $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, 'IMPRESSION COMMANDE PRODUITS', json_encode($parametres));
                                    if ($audit['success'] == true) {
                                        require_once "../../vendor/autoload.php";
                                        require_once "../../vendor/tecnick.com/tcpdf/tcpdf.php";

                                        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
                                        $pdf->SetCreator(PDF_CREATOR);
                                        $pdf->SetAuthor(AUTHOR);
                                        $pdf->SetSubject('COMMANDE N° '.$commande['code']);

                                        // set default header data
                                        $pdf->setPrintHeader(false);
                                        $pdf->setPrintFooter(true);


                                        // set text shadow effect
                                        $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

                                        // Set some content to print
                                        //$pdf->Image(IMAGES.'logos/logo-ouagolo.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'P', true, 150, '', false, false, 0, false, false, false);
                                        $file_name = "COMMANDE_".$commande['code'].".pdf";
                                        $pdf->SetTitle($file_name);
                                        $pdf->AddPage('P');



                                        $pdf->SetFont('helvetica', '', 3, '', true);
                                        $pdf->writeHTMLCell(0, 0, 0, 0, 'Ouagolo', 0, 1, 0, true, 'R', false);

                                        $pdf->SetFont('helvetica', '', 13, '', true);
                                        $pdf->Image(IMAGES.'logos/etablissements/avatar.png', 9, 10, 50, 30, 'PNG', 'https://techouse.io', 'P', true, 150, '', false, false, 1, false, false, false);
                                        $pdf->writeHTMLCell(0, 0, 0, 5, '<h4>'.$ets['raison_sociale'].'</h4>', 0, 1, 0, true, 'C', true);
                                        $pdf->SetFont('helvetica', '', 8, '', true);
                                        $pdf->writeHTMLCell(0, 0, 0, 10, $ets['adresse_postale'], 0, 1, 0, true, 'C', true);
                                        $pdf->writeHTMLCell(0, 0, 0, 13, $ets['region'].', '.$ets['commune'], 0, 1, 0, true, 'C', true);
                                        $pdf->writeHTMLCell(0, 0, 0, 16, $ets['adresse_geographique'], 0, 1, 0, true, 'C', true);
                                        $pdf->writeHTMLCell(0, 0, 0, 19, $telpro.str_replace('http://', '', str_replace('https://', '', $siteweb)), 0, 1, 0, true, 'C', true);
                                        $pdf->SetFont('helvetica', 'B', 13, '', true);
                                        $pdf->writeHTMLCell(100, 0, 50, 25, 'BON DE COMMANDE', 1, 1, 0, true, 'C', true);
                                        $pdf->SetFont('helvetica', '', 8, '', true);
                                        $pdf->writeHTMLCell(0, 0, 10, 32, '<b>Date:</b> '.date('d/m/Y', strtotime($commande['date_commande'])), 0, 1, 0, true, 'R', true);
                                        $pdf->writeHTMLCell(0, 0, 10, 37, '<b>N° commande:</b> '.$commande['code'], 0, 1, 0, true, 'L', true);
                                        $pdf->writeHTMLCell(0, 0, 10, 42, '<b>Fournisseur:</b> '.$commande['libelle_fournisseur'], 0, 1, 0, true, 'L', true);
                                        $pdf->writeHTMLCell(0, 0, 10, 47, '<b>Email:</b> '.$commande['email_fournisseur'], 0, 1, 0, true, 'L', true);
                                        $pdf->writeHTMLCell(0, 0, 10, 52, '<b>Contact:</b> '.$commande['numero_telephone'], 0, 1, 0, true, 'L', true);
                                        $pdf->SetFont('helvetica', '', 10, '', true);

                                        $pdf->Ln();
                                        $pdf->SetFillColor(200, 220, 255);
                                        $pdf->SetFont('helvetica', 'B', 7, '', true);
                                        $pdf->cell(30, 0, 'Code', 1, null, null, 1, null, null, null, null, null);
                                        $pdf->cell(100, 0, 'Désignation', 1, null, null, 1, null, null, null, null, null);
                                        $pdf->cell(20, 0, 'Prix unitaire', 1, null, null, 1, null, null, null, null, null);
                                        $pdf->cell(15, 0, 'Quantité', 1, null, null, 1, null, null, null, null, null);
                                        $pdf->cell(25, 0, 'Montant Total', 1, 1, null, 1, null, null, null, null, null);

                                        $pdf->SetFont('helvetica', '', 7, '', true);
                                        $pdf->SetFillColor(255, 255, 255);
                                        $montant_total = 0;
                                        foreach ($produits as $produit) {
                                            $pdf->cell(30, 0, $produit['code'], 1, null, null, 1, null, null, null, null, null);
                                            $pdf->cell(100, 0, $produit['libelle'], 1, null, null, 1, null, null, null, null, null);
                                            $pdf->cell(20, 0, number_format($produit['prix_unitaire'], '0', '', ' ').' '.$ets['libelle_monnaie'], 1, null, 'R', 1, null, null, null, null, null);
                                            $pdf->cell(15, 0, number_format($produit['quantite'], '0', '', ' '), 1, null, 'R', 1, null, null, null, null, null);
                                            $pdf->cell(25, 0, number_format((int)($produit['prix_unitaire'] * $produit['quantite']), '0', '', ' ').' '.$ets['libelle_monnaie'], 1, 1, 'R', 1, null, null, null, null, null);
                                            $montant_total += (int)($produit['prix_unitaire'] * $produit['quantite']);
                                        }
                                        $pdf->SetFillColor(200, 220, 255);
                                        $pdf->SetFont('helvetica', 'b', 7, '', true);
                                        $pdf->cell(165, 0, 'TOTAL', 1, null, null, 1, null, null, null, null, null);
                                        $pdf->cell(25, 0, number_format($montant_total, '0', '', ' ').' '.$ets['libelle_monnaie'], 1, 1, 'R', 1, null, null, null, null, null);
                                        $pdf->Ln();
                                        $pdf->Ln();

                                        if($commande['statut'] === '2') {
                                            // Get the page width/height
                                            $myPageWidth = $pdf->getPageWidth();
                                            $myPageHeight = $pdf->getPageHeight();

                                            // Find the middle of the page and adjust.
                                            $myX = ( $myPageWidth / 2 ) - 85;
                                            $myY = ( $myPageHeight / 2 ) + 55;

                                            $pdf->StartTransform();
                                            $pdf->Rotate(45, $myX, $myY);
                                            $pdf->SetFont("courier", "", 50);
                                            $pdf->Text($myX, $myY, "COMMANDE RECEPTIONNEE");
                                            $pdf->StopTransform();
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
}
