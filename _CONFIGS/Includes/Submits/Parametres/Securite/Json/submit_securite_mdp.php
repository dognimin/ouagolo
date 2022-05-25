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
        'longueur_minimale' => clean_data($_POST['longueur_minimale']),
        'caracteres_speciaux' => clean_data($_POST['caracteres_speciaux']),
        'majuscules' => clean_data($_POST['majuscules']),
        'minuscules' => clean_data($_POST['minuscules']),
        'chiffres' => clean_data($_POST['chiffres'])
    );
    if (isset($_SESSION['nouvelle_session'])) {
        $autorisation = verifier_utilisateur_acces('../../../../../../', $Links['ACTIVE_URL'], $_SESSION['nouvelle_session']);
        if($autorisation['success']) {
            $UTILISATEURS = new UTILISATEURS();
            $profil = $UTILISATEURS->trouver_profil($autorisation['id_user']);
            if ($profil) {
                $SECURITE = new SECURITE();
                $edition = $SECURITE->editer_securite_mdp($parametres['longueur_minimale'], $parametres['caracteres_speciaux'], $parametres['majuscules'], $parametres['minuscules'], $parametres['chiffres'], $autorisation['id_user']);
                if ($edition['success']) {
                    $audit = $UTILISATEURS->editer_piste_audit($autorisation['code_session'], $Links['ACTIVE_URL'], 'MISE A JOUR DE LA SECURITE DU MOT DE PASSE', json_encode($parametres));
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