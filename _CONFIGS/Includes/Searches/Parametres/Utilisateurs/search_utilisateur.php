<?php
header('Content-Type: application/json');
require_once '../../../../Functions/Functions.php';
require_once '../../../../Classes/UTILISATEURS.php';
$parametres = array(
    'email' => clean_data($_POST['email']),
    'type' => strtoupper(clean_data($_POST['type'])),
);
if (isset($_SESSION['nouvelle_session'])) {
    $UTILISATEURS = new UTILISATEURS();
    $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
    if ($session) {
        $user = $UTILISATEURS->trouver($session['id_user'], null);
        if ($user) {
            require_once '../../../../Classes/ETABLISSEMENTS.php';
            $ETABLISSEMENTS = new ETABLISSEMENTS();
            $profil = $UTILISATEURS->trouver_profil($user['id_user']);
            if ($profil) {
                $user_profil = $UTILISATEURS->trouver_utilisateur_ets($user['id_user']);
                if ($user_profil) {
                    $ets = $ETABLISSEMENTS->trouver($user_profil['code_etablissement'], null);
                    if ($ets) {
                        $utilisateur = $UTILISATEURS->trouver(null, $parametres['email']);
                        if($utilisateur) {
                            if($parametres['type'] === 'PS') {
                                require_once '../../../../Classes/PROFESSIONNELSDESANTE.php';
                                $PROFESSIONNELSDESANTE = new PROFESSIONNELSDESANTE();
                                $ps = $PROFESSIONNELSDESANTE->trouver(null, $utilisateur['id_user']);
                                if($ps) {
                                    $infos_ps = array(
                                        'code' => $ps['code'],
                                        'code_specialite' => $ps['code_specialite_medicale']
                                    );
                                }else {
                                    $infos_ps = $ps;
                                }
                            }
                            $json = array(
                                'success' => true,
                                'id_user' => $utilisateur['id_user'],
                                'nip' => $utilisateur['nip'],
                                'email' => $utilisateur['email'],
                                'num_secu' => $utilisateur['num_secu'],
                                'code_civilite' => $utilisateur['code_civilite'],
                                'prenoms' => $utilisateur['prenoms'],
                                'nom' => $utilisateur['nom'],
                                'nom_patronymique' => $utilisateur['nom_patronymique'],
                                'date_naissance' => date('d/m/Y', strtotime($utilisateur['date_naissance'])),
                                'photo' => $utilisateur['photo'],
                                'code_sexe' => $utilisateur['code_sexe'],
                                'code_situation_familiale' => $utilisateur['code_situation_familiale'],
                                'infos_ps' => $infos_ps
                            );
                        }else {
                            $json = array(
                                'success' => false,
                                'message' => "Adresse Email inconnue.",
                            );
                        }
                    }
                }
            }
        }
    }
}
echo json_encode($json);
