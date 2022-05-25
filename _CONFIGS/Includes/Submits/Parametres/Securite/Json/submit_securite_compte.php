<?php
header('Content-Type: application/json');
use App\GLOBALS;
use App\SECURITE;
use App\UTILISATEURS;
require_once "../../../../../../vendor/autoload.php";
require_once "../../../../../Functions/Functions.php";
if (isset($_POST)) {


    $GLOBALS = new GLOBALS();
    $Links = $GLOBALS->links();

    $parametres = array(
        'nombre_essais' => clean_data($_POST['nombre_essais']),
        'duree_mot_de_passe' => clean_data($_POST['duree_mot_de_passe']),
        'double_authentification' => clean_data($_POST['double_authentification']),
        'autoriser_sms' => clean_data($_POST['autoriser_sms']),
        'autoriser_email' => clean_data($_POST['autoriser_email'])
    );
    if (isset($_SESSION['nouvelle_session'])) {
        $autorisation = verifier_utilisateur_acces('../../../../../../', $Links['ACTIVE_URL'], $_SESSION['nouvelle_session']);
        if($autorisation['success']) {
            $UTILISATEURS = new UTILISATEURS();
            $profil = $UTILISATEURS->trouver_profil($autorisation['id_user']);
            if ($profil) {
                $SECURITE = new SECURITE();
                $edition = $SECURITE->editer_securite_compte($parametres['nombre_essais'], $parametres['duree_mot_de_passe'], $parametres['double_authentification'], $parametres['autoriser_sms'], $parametres['autoriser_email'], $autorisation['id_user']);
                if ($edition['success']) {
                    $audit = $UTILISATEURS->editer_piste_audit($autorisation['code_session'], $Links['ACTIVE_URL'], 'MISE A JOUR DE LA SECURITE DU COMPTE', json_encode($parametres));
                    if ($audit['success']) {
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
            }else {
                $json = array(
                    'success' => false,
                    'message' => "Aucun profil utilisateur n'a été défini pour cet utilisateur, veuillez SVP contacter votre administrateur."
                );
            }
        }else {
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