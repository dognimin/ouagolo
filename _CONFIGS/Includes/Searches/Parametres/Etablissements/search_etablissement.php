<?php

if(isset($_POST)) {
    $parametres = $_POST;
    require_once "../../../../Classes/UTILISATEURS.php";
    if(isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $utilisateur = $UTILISATEURS->trouver($_SESSION['nouvelle_session'],null,null);
        if($utilisateur) {

                require_once "../../../../Classes/ETABLISSEMENTS.php";
                $ETABLISSEMENTS = new ETABLISSEMENTS();
                $etablissement = $ETABLISSEMENTS->trouver_etablissement($parametres['code']);
                $nb_etablissements = count($etablissement);
                if ($nb_etablissements == 0){
                    echo '<p class="alert alert-info align_center">Aucun résultat correspondant à votre recherche n\'a été trouvé</p>';
                }else{
                    $json = array(
                        'success' => true,
                        'code' => $etablissement['code'],
                        'raison_sociale' => $etablissement['raison_sociale']
                    );


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
