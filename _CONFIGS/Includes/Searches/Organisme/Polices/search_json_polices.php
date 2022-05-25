<?php
header('Content-Type: application/json');
require_once "../../../../Classes/UTILISATEURS.php";
require_once "../../../../Functions/Functions.php";
if (isset($_SESSION['nouvelle_session'])) {
    $UTILISATEURS = new UTILISATEURS();
    $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
    if ($session){
        $user = $UTILISATEURS->trouver($session['id_user'], null);
        if ($user){
            require_once "../../../../Classes/ORGANISMES.php";
            $ORGANISMES = new ORGANISMES();
            $user_profil = $UTILISATEURS->trouver_utilisateur_organisme($user['id_user']);
            if($user_profil) {
                $organisme = $ORGANISMES->trouver($user_profil['code_organisme']);
                if($organisme){
                    require_once "../../../../Classes/POLICES.php";
                    $POLICES = new POLICES();
                    if (isset($_POST['id_police'])) {
                        $parametres = array(
                            'id_police' => clean_data($_POST['id_police'])
                        );
                        $police = $POLICES->trouver($organisme['code'], $parametres['id_police']);
                        if($police) {
                            $json = array(
                                'success' => true,
                                'id_police' => $police['id_police'],
                                'nom_police' => $police['nom']
                            );
                        }else {
                            $json = array(
                                'success' => false,
                                'message' => "Aucune collectivité ne correspond à votre recherche."
                            );
                        }
                    }
                    if (isset($_GET['raison_sociale'])) {
                        $parametres = array(
                            'nom_police' => clean_data($_GET['raison_sociale'])
                        );
                        $polices = $POLICES->lister($organisme['code'], strtoupper(conversion_caracteres_speciaux($parametres['nom_police'])));
                        $nb_polices = count($polices);
                        if($nb_polices !== 0) {
                            foreach ($polices as $police) {
                                $json[] = array(
                                    'success' => true,
                                    'value' => $police['id_police'],
                                    'label' => $police['nom']
                                );
                            }
                        }else {
                            $json = $parametres['nom_police'];
                        }
                    }
                }else {
                    $json = array(
                        'success' => false,
                        'message' => "Aucun organisme correspondant à votre profil n\'a été identifié, veuillez SVP contacter votre administrateur."
                    );
                }
            }else {
                $json = array(
                    'success' => false,
                    'message' => "Aucun profil utilisateur n\'a été définit pour cet utilisateur, veuillez SVP contacter votre administrateur."
                );
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
}else{
    $json = array(
        'success' => false,
        'message' => "Aucune session active pour vérifier cette action."
    );
}
flush();
echo json_encode($json);