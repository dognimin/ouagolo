<?php
if (isset($_POST)) {
    require_once "../../../../../Classes/UTILISATEURS.php";
    require_once "../../../../../Functions/Functions.php";
    $parametres = array(
        'code_article' => clean_data($_POST['code_article']),
        'code' => clean_data($_POST['code']),
        'libelle' => clean_data($_POST['libelle']),
        'lettres_cles' => $_POST['code_lettre'],
        'valeur' => $_POST['valeur']
    );
    if (isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if ($session) {
            $utilisateur = $UTILISATEURS->trouver($session['id_user'], null);
            if ($utilisateur) {
                require_once "../../../../../Classes/ACTESMEDICAUX.php";
                $ACTESMEDICUAX = new ACTESMEDICAUX();
                $coefficients_lettre = $parametres['valeur'];
                $nb_lettres_cles = count($coefficients_lettre);
                $code_lettres = $parametres['lettres_cles'];

                $edition_acte = $ACTESMEDICUAX->editer_acte_medical($parametres['code_article'], strtoupper(conversion_caracteres_speciaux($parametres['code'])), strtoupper(conversion_caracteres_speciaux($parametres['libelle'])), $utilisateur['id_user']);
                if ($edition_acte['success'] == true) {
                    for ($i = 0; $i < $nb_lettres_cles; $i++) {
                        $edition_coefficient = $ACTESMEDICUAX->editer_acte_coefficient($code_lettres[$i], strtoupper(conversion_caracteres_speciaux($edition_acte['code'])), conversion_caracteres_speciaux($coefficients_lettre[$i]), $utilisateur['id_user']);
                    }
                    if ($edition_coefficient['success'] == true) {
                        $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, 'EDITION ACTE MEDICAL', json_encode($parametres));
                        if ($audit['success'] == true) {
                            $json = array(
                                'success' => true,
                                'message' => $edition_coefficient['message']
                            );
                        }else{
                            $json = $audit;
                        }
                    } else {
                        $json = $edition_coefficient;
                    }
                } else {
                    $json = $edition_acte;
                }
            } else {
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