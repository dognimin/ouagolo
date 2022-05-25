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
            $utilisateur = $UTILISATEURS->trouver($session['id_user'],null);
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
                    if ($user_profil){
                        $ets = $ETABLISSEMENTS->trouver($user_profil['code_etablissement'], null);
                        if ($ets){
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
                                if ($dossier) {
                                    $paiement = $ETABLISSEMENTS->trouver_facture_paiement($facture['num_facture']);
                                    if ($paiement) {
                                        $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, 'IMPRESSION RECU PAIEMENT', json_encode($parametres));
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
                                            $pdf->writeHTMLCell(100, 0, 50, 25, 'RECU N° '.$paiement['num_paiement'], 1, 1, 0, true, 'C', true);
                                            $pdf->SetFont('helvetica', '', 8, '', true);
                                            $pdf->writeHTMLCell(0, 0, 10, 32, '<b>Date:</b> '.date('d/m/Y H:i', strtotime($paiement['date_creation'])), 0, 1, 0, true, 'R', true);
                                            $pdf->SetFont('helvetica', '', 10, '', true);
                                            $pdf->writeHTMLCell(0, 0, 10, 37, 'Patient(e)', 0, 1, 0, true, 'L', true);
                                            $pdf->SetFont('helvetica', 'B', 10, '', true);
                                            $pdf->writeHTMLCell(0, 0, 60, 37, $dossier['code_civilite'].'. '.$facture['nom'].' '.$facture['prenom'], 0, 1, 0, true, 'L', true);

                                            $pdf->SetFont('helvetica', '', 10, '', true);
                                            $pdf->writeHTMLCell(0, 0, 10, 42, 'Mode règlement', 0, 1, 0, true, 'L', true);
                                            $pdf->SetFont('helvetica', 'B', 10, '', true);
                                            $pdf->writeHTMLCell(0, 0, 60, 42, $paiement['libelle_type_reglement'], 0, 1, 0, true, 'L', true);

                                            $pdf->SetFont('helvetica', '', 10, '', true);
                                            $pdf->writeHTMLCell(0, 0, 10, 47, 'N.I.P', 0, 1, 0, true, 'L', true);
                                            $pdf->SetFont('helvetica', 'B', 10, '', true);
                                            $pdf->writeHTMLCell(0, 0, 60, 47, $facture['num_population'], 0, 1, 0, true, 'L', true);

                                            $pdf->SetFont('helvetica', '', 10, '', true);
                                            $pdf->writeHTMLCell(0, 0, 120, 47, 'N° Facture', 0, 1, 0, true, 'L', true);
                                            $pdf->SetFont('helvetica', 'B', 10, '', true);
                                            $pdf->writeHTMLCell(0, 0, 140, 47, $facture['num_facture'], 0, 1, 0, true, 'L', true);

                                            $pdf->Ln();
                                            $pdf->SetFont('helvetica', 'B', 12, '', true);
                                            $pdf->cell(150,0,'MONTANT',null,null,'R',null,null,null,null,null,null);
                                            $pdf->cell(40,0,number_format($paiement['montant_net'], '0', '', ' '),1,1,'R',1,null,null,null,null,null);
                                            $pdf->SetFont('helvetica', 'B', 10, '', true);

                                            if($paiement['montant_net'] != 0) {
                                                $pdf->Ln();
                                                $pdf->SetFont('helvetica', 'I', 10, '', true);
                                                $pdf->cell(191,4,'* Montant en lettres: '.strtoupper(str_replace('zero', '', chiffres_en_lettres($paiement['montant_net']))).' '.$ets['libelle_monnaie'],null,null,'L',null,null,1,null,null,null);
                                            }

                                            $pdf->Ln();
                                            $pdf->SetFont('helvetica', 'BU', 10, '', true);
                                            $pdf->cell(300,0,'CAISSIER(E)',null,1,'C',null,null,null,null,null,null);
                                            $pdf->SetFont('helvetica', '', 10, '', true);
                                            $pdf->cell(300,0,$paiement['nom_utilisateur'].' '.$paiement['prenoms_utilisateur'],null,1,'C',null,null,null,null,null,null);

                                            $pdf->Ln();
                                            $pdf->Ln();
                                            $pdf->SetFont('helvetica', 'I', 8, '', true);
                                            $pdf->cell(191,4,'RECU VALABLE 15 JOURS UNIQUEMENT POUR LES CONSULTATIONS DE LA MEME PATHOLOGIE.',null,null,'C',null,null,1,null,null,null);
                                            $pdf->Ln();
                                            $pdf->SetFont('helvetica', 'BI', 8, '', true);
                                            $pdf->cell(191,4,'PROMPT RETABLISSEMENT!',null,null,'C',null,null,1,null,null,null);
                                            $pdf->Ln();
                                            $pdf->SetFont('helvetica', 'I', 10, '', true);
                                            $pdf->cell(177,4,'------------------------------------------------------------------------------------------------------------------------------------------------',null,1,'C',null,null,null,null,null,null);


                                            $pdf->Ln();
                                            $pdf->Ln();
                                            $pdf->Output($file_name, 'I');
                                        }
                                    } else {
                                        //echo "<script>window.close();</script>";
                                    }
                                } else {
                                    //echo "<script>window.close();</script>";
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
