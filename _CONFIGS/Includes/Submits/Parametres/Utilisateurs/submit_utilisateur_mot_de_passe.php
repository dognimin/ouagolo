<?php
header('Content-Type: application/json');
require_once "../../../../Classes/UTILISATEURS.php";
require_once "../../../../Functions/Functions.php";
if (isset($_POST)) {
    $parametres = array(
        'actuel_mot_de_passe' => clean_data($_POST['actuel_mot_de_passe']),
        'nouveau_mot_de_passe' => clean_data($_POST['nouveau_mot_de_passe'])
    );

    if (isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if ($session) {
            $utilisateur = $UTILISATEURS->trouver($session['id_user'], null, null);
            if ($utilisateur) {
                $edition = $UTILISATEURS->editer_mot_de_passe($utilisateur['id_user'], $parametres['actuel_mot_de_passe'], $parametres['nouveau_mot_de_passe']);
                if ($edition['success'] == true) {
                    $options = ['cost' => 11];
                    $actuel_mot_de_passe = password_hash($parametres['actuel_mot_de_passe'], PASSWORD_BCRYPT, $options);
                    $nouveau_mot_de_passe = password_hash($parametres['nouveau_mot_de_passe'], PASSWORD_BCRYPT, $options);
                    $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, 'MISE A JOUR MDP', json_encode(str_replace($parametres['actuel_mot_de_passe'], $actuel_mot_de_passe, str_replace($parametres['nouveau_mot_de_passe'], $nouveau_mot_de_passe, $parametres))));
                    if ($audit['success'] == true) {
                        $json = array(
                            'success' => true,
                            'message' => "Mot de passe modifié avec succès"
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