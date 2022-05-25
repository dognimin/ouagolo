<?php
header('Content-Type: application/json');
if(isset($_POST)) {
    require_once "../../../../Classes/UTILISATEURS.php";
    require_once "../../../../Functions/Functions.php";
    $parametres = array(
        'code_rdv' => clean_data($_POST['code_rdv']),
        'date' => date('Y-m-d', strtotime(str_replace('/', '-', clean_data($_POST['date'])))),
        'heure_debut' => clean_data($_POST['heure_debut']),
        'heure_fin' => clean_data($_POST['heure_fin']),
        'num_patient' => clean_data($_POST['num_patient']),
        'code_ps' => clean_data($_POST['code_ps']),
        'motif' => clean_data($_POST['motif'])
    );
    if (isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if ($session) {
            $utilisateur = $UTILISATEURS->trouver($session['id_user'], null);
            if ($utilisateur) {
                require_once "../../../../Classes/ETABLISSEMENTS.php";
                $ETABLISSEMENTS = new ETABLISSEMENTS();
                $profil = $UTILISATEURS->trouver_profil($utilisateur['id_user']);
                if ($profil) {
                    $user_profil = $UTILISATEURS->trouver_utilisateur_ets($utilisateur['id_user']);
                    if ($user_profil) {
                        $ets = $ETABLISSEMENTS->trouver($user_profil['code_etablissement'], null);
                        if ($ets) {
                            $edition = $ETABLISSEMENTS->editer_rendez_vous($ets['code'], $parametres['code_rdv'], $parametres['date'], $parametres['heure_debut'], $parametres['heure_fin'], $parametres['num_patient'], $parametres['code_ps'], strtoupper(conversion_caracteres_speciaux($parametres['motif'])), $utilisateur['id_user']);
                            if ($edition['success'] == true) {
                                $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, 'EDITION ETABLISSEMENT RENDEZ-VOUS', json_encode($parametres));
                                if ($audit['success'] == true) {
                                    $json = array(
                                        'success' => true,
                                        'message' => $edition['message']
                                    );
                                } else {
                                    $json = $audit;
                                }

                            } else {
                                $json = $edition;
                            }
                        } else {
                            $json = array(
                                'success' => false,
                                'message' => "Aucun établissement correspondant à votre profil n'a été identifié, veuillez SVP contacter votre administrateur.."
                            );
                        }
                    } else {
                        $json = array(
                            'success' => false,
                            'message' => "Aucun utilisateur identifié pour effectué cette action."
                        );
                    }
                } else {
                    $json = array(
                        'success' => false,
                        'message' => "Aucun utilisateur identifié pour effectué cette action."
                    );
                }
            } else {
                $json = array(
                    'success' => false,
                    'message' => "Aucun utilisateur identifié pour effectué cette action."
                );
            }
        } else {
            $json = array(
                'success' => false,
                'message' => "Aucune session active pour vérifier cette action."
            );
        }
    } else {
        $json = array(
            'success' => false,
            'message' => "Aucune session active pour vérifier cette action."
        );
    }
} else {
    $json = array(
        'success' => false,
        'message' => "Aucun paramètre n'a été défini pour cette action."
    );
}
echo json_encode($json);
