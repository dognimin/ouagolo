<?php
header('Content-Type: application/json');
if(isset($_POST)) {
    require_once "../../../Classes/UTILISATEURS.php";
    require_once "../../../Functions/Functions.php";
    $parametres = array(
        'code' => clean_data($_POST['code']),
        'type_etablissement' => clean_data($_POST['type_etablissement']),
        'raison_sociale' => clean_data($_POST['raison_sociale']),
        'secteur' => clean_data($_POST['secteur']),
        'adresse_geo' => clean_data($_POST['adresse_geo']),
        'adresse_post' => clean_data($_POST['adresse_post']),
        'longitude' => clean_data($_POST['longitude']),
        'latitude' => clean_data($_POST['latitude']),
        'pays' => clean_data($_POST['pays']),
        'region' => clean_data($_POST['region']),
        'departement' => clean_data($_POST['departement']),
        'commune' => clean_data($_POST['commune'])
    );
    if(isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if ($session) {
            $utilisateur = $UTILISATEURS->trouver($session['id_user'],null);
            if($utilisateur) {
                require_once "../../../Classes/ETABLISSEMENTS.php";
                $ETABLISSEMENTS = new ETABLISSEMENTS();
                $edition = $ETABLISSEMENTS->editer(strtoupper(conversion_caracteres_speciaux($parametres['code'])),$parametres['type_etablissement'],strtoupper(conversion_caracteres_speciaux($parametres['raison_sociale'])),$parametres['pays'],$parametres['region'],$parametres['departement'],$parametres['commune'],$parametres['latitude'],$parametres['longitude'],$parametres['secteur'],strtoupper(conversion_caracteres_speciaux($parametres['adresse_geo'])),strtoupper(conversion_caracteres_speciaux($parametres['adresse_post'])),$utilisateur['id_user']);
                if($edition['success'] == true) {
                    $audit = $UTILISATEURS->editer_piste_audit($session['code_session'],ACTIVE_URL,'EDITION',json_encode($parametres));
                    if($audit['success'] == true) {
                        $json = array(
                            'success' => true,
                            'code' => $edition['code'],
                            'message' => $edition['message']
                        );
                    }else {
                        $json = $audit;
                    }
                }else {
                    $json = $edition;
                }
            }else {
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
    }else {
        $json = array(
            'success' => false,
            'message' => "Aucune session active pour vérifier cette action."
        );
    }
}else {
    $json = array(
        'success' => false,
        'message' => "Aucun paramètre n'a été défini pour cette action."
    );
}
echo json_encode($json);