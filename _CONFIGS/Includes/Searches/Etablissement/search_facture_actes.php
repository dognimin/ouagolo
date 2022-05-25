<?php
header('Content-Type: application/json');
if(isset($_POST)) {
    require_once "../../../Classes/UTILISATEURS.php";
    require_once "../../../Functions/Functions.php";
    $parametres = array(
        'code_assurance' => clean_data($_GET['code_assurance']),
        'num_assure' => clean_data($_GET['num_assure']),
        'libelle' => clean_data($_GET['libelle']),
        'date_soins' => date('Y-m-d', strtotime(str_replace('/', '-', clean_data($_GET['date_soins'])))),
        'type_facture' => clean_data($_GET['type_facture']),
        'code_ets' => clean_data($_GET['code_ets'])
    );
    if(isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if ($session) {
            $utilisateur = $UTILISATEURS->trouver($session['id_user'],null);
            if($utilisateur) {
                require_once "../../../Classes/ETABLISSEMENTS.php";
                require_once "../../../Classes/RESEAUXDESOINS.php";
                require_once "../../../Classes/ORGANISMES.php";
                require_once "../../../Classes/PATIENTS.php";
                $ETABLISSEMENTS = new ETABLISSEMENTS();
                $RESEAUXDESOINS = new RESEAUXDESOINS();
                $ORGANISMES = new ORGANISMES();
                $PATIENTS = new PATIENTS();
                $profil = $UTILISATEURS->trouver_profil($utilisateur['id_user']);
                if ($profil) {
                    $user_profil = $UTILISATEURS->trouver_utilisateur_ets($utilisateur['id_user']);
                    if($user_profil) {
                        $ets = $ETABLISSEMENTS->trouver($user_profil['code_etablissement'], null);
                        if($ets) {
                            $audit = $UTILISATEURS->editer_piste_audit($session['code_session'],ACTIVE_URL,'RECHERCHE FACTURE ACTES',json_encode($parametres));
                            if($audit['success'] == true) {
                                $actes = $ETABLISSEMENTS->lister_facture_acte($parametres['code_ets'], $parametres['libelle'], $parametres['type_facture'], $parametres['date_soins']);
                                foreach ($actes as $acte) {
                                    $organisme = $PATIENTS->trouver_organisme($parametres['code_assurance'], $parametres['num_assure'], $parametres['date_soins']);
                                    if($organisme) {
                                        $reseau = $RESEAUXDESOINS->trouver_reseau_etablissement($organisme['code_reseau_soins'], $ets['code']);
                                        if($reseau) {
                                            $organisme_acte = $ORGANISMES->trouver_acte($organisme['code_organisme'], $organisme['code_produit'], $ets['code'], $acte['code'], $parametres['date_soins']);
                                            if($organisme_acte) {
                                                $json[] = array(
                                                    'success' => true,
                                                    'value' => $acte['code'],
                                                    'label' => $acte['libelle'],
                                                    'tarif' => $organisme_acte['tarif']
                                                );
                                            }else {
                                                $json[] = array(
                                                    'success' => true,
                                                    'value' => $acte['code'],
                                                    'label' => $acte['libelle'],
                                                    'tarif' => $acte['tarif']
                                                );
                                            }
                                        }else {
                                            $json[] = array(
                                                'success' => true,
                                                'value' => $acte['code'],
                                                'label' => $acte['libelle'],
                                                'tarif' => $acte['tarif']
                                            );
                                        }
                                    }else {
                                        $json[] = array(
                                            'success' => true,
                                            'value' => $acte['code'],
                                            'label' => $acte['libelle'],
                                            'tarif' => $acte['tarif']
                                        );
                                    }
                                }
                                flush();
                            }else {
                                $json = $audit;
                            }
                        }else {
                            $json = array(
                                'success' => false,
                                'message' => "Aucun établissement correspondant à votre profil n'a été identifié, veuillez SVP contacter votre administrateur."
                            );
                        }
                    }else {
                        $json = array(
                            'success' => false,
                            'message' => "Aucun utilisateur identifié pour effectué cette action."
                        );
                    }
                }else {
                    $json = array(
                        'success' => false,
                        'message' => "Aucun utilisateur identifié pour effectué cette action."
                    );
                }
            }else {
                $json = array(
                    'success' => false,
                    'message' => "Aucun utilisateur identifié pour effectué cette action."
                );
            }
        }else {
            $json = array(
                'success' => false,
                'message' => "Aucune session active pour vérifier cette action."
            );
        }
    }else {
        $json = array(
            'success' => false,
            'message' => "Aucune session active pour vérifier cette action."
        );
    }
}else {
    $json = array(
        'success' => false,
        'message' => "Aucun paramètre n'a été défini pour cette action."
    );
}
echo json_encode($json);
