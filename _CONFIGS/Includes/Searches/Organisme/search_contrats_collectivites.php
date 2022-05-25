<?php
header('Content-Type: application/json');
require_once '../../../Functions/Functions.php';
require_once '../../../Classes/UTILISATEURS.php';
if (isset($_SESSION['nouvelle_session'])) {
    $UTILISATEURS = new UTILISATEURS();
    $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
    if ($session) {
        $user = $UTILISATEURS->trouver($session['id_user'], null);
        if ($user) {
            require_once "../../../Classes/ORGANISMES.php";
            $ORGANISMES = new ORGANISMES();
            $user_profil = $UTILISATEURS->trouver_utilisateur_organisme($user['id_user']);
            if($user_profil) {
                $organisme = $ORGANISMES->trouver($user_profil['code_organisme']);
                if($organisme) {
                    require_once "../../../Classes/COLLEGES.php";
                    $CONTRATS = new COLLEGES();

                    if(isset($_POST['code'])) {
                        $parametres = array(
                            'code' => clean_data($_POST['code'])
                        );
                        $collectivite = $CONTRATS->lister_collectivites($organisme['code'], null, $parametres['code']);
                        if($collectivite) {
                            $json = array(
                                'success' => true,
                                'code' => $collectivite['code'],
                                'raison_sociale' => $collectivite['raison_sociale']
                            );
                        }else {
                            $json = array(
                                'success' => false,
                                'message' => "Aucune collectivité ne correspond à votre recherche."
                            );
                        }
                    }
                    elseif (isset($_GET['raison_sociale'])) {
                        $parametres = array(
                            'raison_sociale' => clean_data($_GET['raison_sociale'])
                        );
                        $collectivites = $CONTRATS->lister_collectivites($organisme['code'], null, $parametres['raison_sociale']);
                        foreach ($collectivites as $collectivite) {
                            $json[] = array(
                                'success' => true,
                                'value' => $collectivite['code'],
                                'label' => $collectivite['raison_sociale']
                            );
                        }
                        flush();
                    }
                }
            }
        }
    }
}
echo json_encode($json);