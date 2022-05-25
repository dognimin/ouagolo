<?php
header('Content-Type: application/json');
if(isset($_POST)) {
    require_once "../../../../Classes/UTILISATEURS.php";
    require_once "../../../../Functions/Functions.php";
    $parametres = array(
        'code_dossier' => clean_data($_POST['code_dossier']),
        'code_ps' => clean_data($_POST['code_ps'])
    );
    if(isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if ($session) {
            $utilisateur = $UTILISATEURS->trouver($session['id_user'],null);
            if($utilisateur) {
                require_once "../../../../Classes/ETABLISSEMENTS.php";
                require_once "../../../../Classes/DOSSIERS.php";
                $ETABLISSEMENTS = new ETABLISSEMENTS();
                $DOSSIERS = new DOSSIERS();
                $profil = $UTILISATEURS->trouver_profil($utilisateur['id_user']);
                if ($profil) {
                    $user_profil = $UTILISATEURS->trouver_utilisateur_ets($utilisateur['id_user']);
                    if($user_profil) {
                        $ets = $ETABLISSEMENTS->trouver($user_profil['code_etablissement'], null);
                        if($ets) {
                            $ps = $ETABLISSEMENTS->trouver_professionnel_de_sante($ets['code'], $parametres['code_ps']);
                            if ($ps) {
                                $edition = $DOSSIERS->editer_professionnel_sante($parametres['code_dossier'], $ps['code_professionnel'], $ps['code_specialite_medicale'], $utilisateur['id_user']);
                                if ($edition['success'] == true) {
                                    $audit = $UTILISATEURS->editer_piste_audit($session['code_session'],ACTIVE_URL,'EDITION PROFESSIONNEL SANTE DOSSIER',json_encode($parametres));
                                    if ($audit['success'] == true) {
                                        $json = array(
                                            'success' => true,
                                            'message' => $edition['message']
                                        );
                                    }else {
                                        $json = $audit;
                                    }
                                }
                                else {
                                    $json = $edition;
                                }
                            } else {

                            }
                        }
                        else {
                            $json = array(
                                'success' => false,
                                'message' => "Aucun établissement correspondant à votre profil n'a été identifié, veuillez SVP contacter votre administrateur.."
                            );
                        }
                    }
                    else {
                        $json = array(
                            'success' => false,
                            'message' => "Aucun utilisateur identifié pour effectué cette action."
                        );
                    }
                }
                else {
                    $json = array(
                        'success' => false,
                        'message' => "Aucun utilisateur identifié pour effectué cette action."
                    );
                }
            }
            else {
                $json = array(
                    'success' => false,
                    'message' => "Aucun utilisateur identifié pour effectué cette action."
                );
            }
        }
        else {
            $json = array(
                'success' => false,
                'message' => "Aucune session active pour vérifier cette action."
            );
        }
    }
    else {
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
