<?php
if (isset($_POST)) {
    $parametres = $_POST;
    require_once "../../../../Classes/UTILISATEURS.php";
    if (isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $utilisateur = $UTILISATEURS->trouver($_SESSION['nouvelle_session'], null, null);
        if ($utilisateur) {
            require_once "../../../../Classes/ETABLISSEMENTS.php";
            $ETABLISSEMENTS = new ETABLISSEMENTS();
            $etablissement = $ETABLISSEMENTS->trouver($parametres['code'], null);
            if (!$etablissement) {
                $json = array(
                    'success' => false,
                    'message' => "Aucun résultat correspondant à votre recherche n'a été trouvé."
                );
            } else {
                $json = array(
                    'success' => true,
                    'code' => $etablissement['code'],
                    'raison_sociale' => $etablissement['raison_sociale']
                );
            }
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
