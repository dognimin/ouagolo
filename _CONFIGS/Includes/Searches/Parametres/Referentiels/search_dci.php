<?php

if(isset($_POST)) {
    $parametres = $_POST;
    require_once "../../../../Classes/UTILISATEURS.php";
    if(isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $utilisateur = $UTILISATEURS->trouver($_SESSION['nouvelle_session'],null,null);
        if($utilisateur) {
            $nb_parametres = count($parametres);
            if($nb_parametres == 1) {
                require_once "../../../../Classes/MEDICAMENTS.php";
                $MEDICAMENTS = new MEDICAMENTS();
                $medicaments = $MEDICAMENTS->lister_dci($parametres['code_forme']);
                foreach ($medicaments as $medicament) {
                    $json[$medicament['code']] = $medicament['libelle'];
                }

            }else{
                $json = $nb_parametres;
            }
    }else {
        $json = array(
            'success' => false,
            'message' => "Aucune session active pour vérifier cette action."
        );
    }
}else{
        $json = count($parametres);
    }
}else {
    $json = array(
        'success' => false,
        'message' => "Aucun paramètre n'a été défini pour cette action."
    );
}
echo json_encode($json);