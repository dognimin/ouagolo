<?php

if (isset($_POST)) {
    require_once "../../../../Classes/UTILISATEURS.php";
    require_once "../../../../Functions/Functions.php";
    $parametres = array(
        'code_chapitre' => clean_data($_POST['code_chapitre'])
    );
    if (isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if ($session) {
            $utilisateur = $UTILISATEURS->trouver($session['id_user'], null);
            if ($utilisateur) {
                $nb_parametres = count($parametres);
                if ($nb_parametres == 1) {
                    require_once "../../../../Classes/PATHOLOGIES.php";
                    $PATHOLOGIES = new PATHOLOGIES();
                    $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, 'RECHERCHE PATHOLOGIE SOUS-CHAPITRE', json_encode($parametres));
                    if ($audit['success'] == true) {
                        $sous_chapitres = $PATHOLOGIES->lister_sous_chapitres($parametres['code_chapitre']);
                        foreach ($sous_chapitres as $sous_chapitre) {
                            $json[$sous_chapitre['code']] = $sous_chapitre['libelle'];
                        }
                    } else {
                        $json = $audit;
                    }
                } else {
                    $json = $nb_parametres;
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