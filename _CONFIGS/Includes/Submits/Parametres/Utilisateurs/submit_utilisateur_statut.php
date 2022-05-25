<?php
header('Content-Type: application/json');
if (isset($_POST)) {
    require_once "../../../../Classes/UTILISATEURS.php";
    require_once "../../../../Classes/ETABLISSEMENTS.php";
    require_once "../../../../Classes/ORGANISMES.php";
    require_once "../../../../Functions/Functions.php";
    $parametres = array(
        'id_user' => clean_data($_POST['id_user'])
    );
    if(isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $ETABLISSEMENTS = new ETABLISSEMENTS();
        $ORGANISMES = new ORGANISMES();
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if($session) {
            $utilisateur = $UTILISATEURS->trouver($session['id_user'], null);
            if ($utilisateur) {
                $concerne = $UTILISATEURS->trouver_statut($parametres['id_user']);
                if($concerne) {
                    if($concerne['statut'] == 1) {
                        $statut = 0;
                    }else {
                        $statut = 1;
                    }
                    $edition = $UTILISATEURS->editer_statut($concerne['id_user'], $statut, $utilisateur['id_user']);
                    if($edition['success'] == true) {
                        $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, 'EDITION STATUT UTILISATEUR', json_encode($parametres));
                        if($audit['success'] == true) {
                            $json = array(
                                'success' => true,
                                'message' => "Statut modifié avec succès"
                            );
                        }else {
                            $json = $audit;
                        }
                    }else {
                        $json = $edition;
                    }
                }
            } else {
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

} else {
    $json = array(
        'success' => false,
        'message' => "Aucun paramètre n'a été défini pour cette action."
    );
}
echo json_encode($json);
