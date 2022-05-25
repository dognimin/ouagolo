<?php
use App\GLOBALS;
use App\UTILISATEURS;
header('Content-Type: application/json');
if (isset($_POST)) {
    require_once "../../../../../../vendor/autoload.php";
    require_once "../../../../../Functions/Functions.php";

    $GLOBALS = new GLOBALS();
    $Headers = $GLOBALS->headers(0);
    $Links = $GLOBALS->links();

    $parametres = array(
        'email' => clean_data($_POST['email']),
        'mot_de_passe' => clean_data($_POST['mot_de_passe'])
    );

    $UTILISATEURS = new UTILISATEURS();
    $connexion = $UTILISATEURS->connexion($parametres['email'], $parametres['mot_de_passe']);
    if ($connexion['success']) {
        $navigateur = navigateur();
        $session = $UTILISATEURS->editer_session($connexion['id_user'], null, $Links['CLIENT_ADRESSE_IP'], $navigateur['platform'], $navigateur['browser'], $navigateur['version'], $navigateur['user_agent'], $navigateur['pattern']);
        if ($session['success']) {
            $options = ['cost' => 11];
            $password = password_hash($parametres['mot_de_passe'], PASSWORD_BCRYPT, $options);
            $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], $Links['ACTIVE_URL'], 'CONNEXION AU SYSTEME', json_encode(str_replace($parametres['mot_de_passe'], $password, $parametres)));
            if ($audit['success']) {
                $_SESSION['nouvelle_session'] = $session['code_session'];
                $json = array(
                    'success' => true,
                    'message' => "Connexion établie."
                );
            }
        } else {
            $json = $session;
        }
    } else {
        $json = $connexion;
    }
} else {
    $json = array(
        'success' => false,
        'message' => "Aucun paramètre n'a été défini pour cette action."
    );
}
echo json_encode($json);