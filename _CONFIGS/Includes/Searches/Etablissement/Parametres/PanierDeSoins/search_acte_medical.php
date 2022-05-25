<?php
header('Content-Type: application/json');
if(isset($_POST)) {
    require_once "../../../../../Classes/UTILISATEURS.php";
    require_once "../../../../../Functions/Functions.php";
    $parametres = array(
        'code_acte' => clean_data($_POST['code_acte'])
    );
    if(isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if ($session) {
            $utilisateur = $UTILISATEURS->trouver($session['id_user'],null);
            if($utilisateur) {
                require_once "../../../../../Classes/ETABLISSEMENTS.php";
                require_once "../../../../../Classes/ACTESMEDICAUX.php";
                $ETABLISSEMENTS = new ETABLISSEMENTS();
                $ACTESMEDICAUX = new ACTESMEDICAUX();
                $profil = $UTILISATEURS->trouver_profil($utilisateur['id_user']);
                if ($profil) {
                    $user_profil = $UTILISATEURS->trouver_utilisateur_ets($utilisateur['id_user']);
                    if($user_profil) {
                        $ets = $ETABLISSEMENTS->trouver($user_profil['code_etablissement'], null);
                        if($ets) {
                            $audit = $UTILISATEURS->editer_piste_audit($session['code_session'],ACTIVE_URL,'RECHERCHE ETS ACTE MEDICAL',json_encode($parametres));
                            if($audit['success'] == true) {
                                $acte = $ETABLISSEMENTS->trouver_panier_acte($ets['code'], $parametres['code_acte']);
                                if(!$acte) {
                                    $acte_medical = $ACTESMEDICAUX->trouver_acte_medical($parametres['code_acte']);
                                    if($acte_medical) {
                                        $json = array(
                                            'success' => true,
                                            'code' => $acte_medical['code'],
                                            'libelle' => $acte_medical['libelle'],
                                            'type_facture' => null,
                                            'tarif' => null,
                                            'date_debut' => date('d/m/Y',time())
                                        );
                                    }
                                }else {
                                    $json = array(
                                        'success' => true,
                                        'code' => $acte['code'],
                                        'libelle' => $acte['libelle'],
                                        'type_facture' => $acte['code_type_facture'],
                                        'tarif' => $acte['tarif'],
                                        'date_debut' => date('d/m/Y',time()),
                                    );
                                }

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
