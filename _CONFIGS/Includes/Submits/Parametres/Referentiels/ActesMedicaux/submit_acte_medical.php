<?php
if (isset($_POST)) {
    $parametres = $_POST;
    require_once "../../../../../Classes/UTILISATEURS.php";
    if (isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $utilisateur = $UTILISATEURS->trouver($_SESSION['nouvelle_session'], null, null);
        if ($utilisateur) {
            require_once "../../../../../Functions/Functions.php";
            require_once "../../../../../Classes/ACTESMEDICAUX.php";
            $ACTESMEDICUAX = new ACTESMEDICAUX();
            $nb_lettre = count($parametres['valeur']);
            $coefficients_lettre = $parametres['valeur'];
            $code_lettres = $parametres['code_lettre'];

            $edition_acte = $ACTESMEDICUAX->editer_acte_medical($parametres['code_article'], conversion_caracteres_speciaux($parametres['code']), strtoupper(conversion_caracteres_speciaux($parametres['libelle'])), $utilisateur['id_user']);

            if ($edition_acte['success'] == true) {
                for ($i = 0; $i < $nb_lettre; $i++) {
                    $edition_coefficient = $ACTESMEDICUAX->editer_acte_coefficient($code_lettres[$i], $parametres['code'], conversion_caracteres_speciaux($coefficients_lettre[$i]), $utilisateur['id_user']);
                }
                if ($edition_coefficient['success'] == true) {
                    $audit = $UTILISATEURS->editer_piste_audit(CLIENT_ADRESSE_IP, ACTIVE_URL, 'EDITION', json_encode($parametres), $utilisateur['id_user']);
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