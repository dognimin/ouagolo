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
                require_once "../../../../Classes/ACTESMEDICAUX.php";
                $PATHOLOGIES = new ACTESMEDICAUX();
                $souschapitres = $PATHOLOGIES->lister_chapitres($parametres['code_titre']);
                foreach ($souschapitres as $souschapitre) {
                    $json[$souschapitre['code']] = $souschapitre['libelle'];
                }

            }
            if($nb_parametres == 2) {
                require_once "../../../../Classes/ACTESMEDICAUX.php";
                $PATHOLOGIES = new ACTESMEDICAUX();
                $souschapitres = $PATHOLOGIES->lister_sections($parametres['chapitre_code']);
                foreach ($souschapitres as $souschapitre) {
                    $json[$souschapitre['code']] = $souschapitre['libelle'];
                }
            }
                if($nb_parametres == 3) {
                require_once "../../../../Classes/ACTESMEDICAUX.php";
                $PATHOLOGIES = new ACTESMEDICAUX();
                $souschapitres = $PATHOLOGIES->lister_articles($parametres['section_code']);
                foreach ($souschapitres as $souschapitre) {
                    $json[$souschapitre['code']] = $souschapitre['libelle'];
                }

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