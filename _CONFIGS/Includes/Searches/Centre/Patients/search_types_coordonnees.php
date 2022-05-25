<?php

if(isset($_POST)) {
    $parametres = $_POST;
    require_once "../../../../Classes/UTILISATEURS.php";
    if(isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $utilisateur = $UTILISATEURS->trouver($_SESSION['nouvelle_session'],null,null);
        if($utilisateur) {
            $nb_parametres = count($parametres);

            require_once "../../../../Classes/TYPESCOORDONNEES.php";
            $TYPESCOORDONNEES = new TYPESCOORDONNEES();
            $types_coordonnees = $TYPESCOORDONNEES->lister();
            foreach ($types_coordonnees as $type_coordonnee) {
                $json[$type_coordonnee['code']] = $type_coordonnee['libelle'];
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