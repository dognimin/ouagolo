<?php

if(isset($_POST)) {
    require_once "../../../../Classes/UTILISATEURS.php";
    require_once "../../../../Functions/Functions.php";
    if(count($_POST) == 1) {
        $parametres = array(
            'code_titre' => clean_data($_POST['code_titre'])
        );
    }elseif (count($_POST) == 2) {
        $parametres = array(
            'code_titre' => clean_data($_POST['code_titre']),
            'code_chapitre' => clean_data($_POST['code_chapitre'])
        );
    }elseif (count($_POST) == 3) {
        $parametres = array(
            'code_titre' => clean_data($_POST['code_titre']),
            'code_chapitre' => clean_data($_POST['code_chapitre']),
            'code_section' => clean_data($_POST['code_section'])
        );
    }

    if(isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if ($session) {
            $utilisateur = $UTILISATEURS->trouver($session['id_user'],null);
            if($utilisateur) {
                require_once "../../../../Classes/ACTESMEDICAUX.php";
                $ACTESMEDICAUX = new ACTESMEDICAUX();
                $nb_parametres = count($parametres);
                if($nb_parametres == 1) {
                    $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, 'RECHERCHE ACTE MEDICAL CHAPITRES', json_encode($parametres));
                    if ($audit['success'] == true) {
                        $chapitres = $ACTESMEDICAUX->lister_chapitres($parametres['code_titre']);
                        foreach ($chapitres as $chapitre) {
                            $json[$chapitre['code']] = $chapitre['libelle'];
                        }
                    }else {
                        $json = $audit;
                    }
                }
                if($nb_parametres == 2) {
                    $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, 'RECHERCHE ACTE MEDICAL SECTIONS', json_encode($parametres));
                    if ($audit['success'] == true) {
                        $sections = $ACTESMEDICAUX->lister_sections($parametres['code_chapitre']);
                        foreach ($sections as $section) {
                            $json[$section['code']] = $section['libelle'];
                        }
                    }else {
                        $json = $audit;
                    }
                }
                if($nb_parametres == 3) {
                    $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, 'RECHERCHE ACTE MEDICAL ARTICLES', json_encode($parametres));
                    if ($audit['success'] == true) {
                        $articles = $ACTESMEDICAUX->lister_articles($parametres['code_section']);
                        foreach ($articles as $article) {
                            $json[$article['code']] = $article['libelle'];
                        }
                    }else {
                        $json = $audit;
                    }
                }
            }else {
                $json = array(
                    'success' => false,
                    'message' => "Aucune session active pour vérifier cette action."
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