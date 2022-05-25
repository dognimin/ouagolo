<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-with");
$footer = array(
    'nom' => "Ouagolo Webservices",
    'description' => "Interface de gestion des API du système Ouagolo.",
    'licence' => "Propriétaire",
    'auteurs' => array(
        'nom' => "TecHouse SARL",
        'email' => "support-ouagolo@techouse.io"
    ),
    'version' => "1.0",
    'date' => "01/01/2022"
);
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../../_CONFIGS/Functions/Functions.php';
    require_once '../../_CONFIGS/Classes/UTILISATEURS.php';
    $UTILISATEURS = new UTILISATEURS();
    if (isset($_POST)) {
        if (isset($_POST['username'], $_POST['password'])) {
            $options = ['cost' => 11];
            $log_entree = $UTILISATEURS->editer_api_logs(null, CLIENT_ADRESSE_IP, SERVEUR_ADRESSE_IP, json_encode(str_replace($_POST['password'], password_hash($_POST['password'], PASSWORD_BCRYPT, $options), $_POST)));
            if ($log_entree['success'] === true) {
                $username = clean_data($_POST['username']);
                $mot_de_passe = clean_data($_POST['password']);

                $connexion = $UTILISATEURS->connexion($username, $mot_de_passe);
                if ($connexion) {
                    if ($connexion['success'] === true) {
                        $user = $UTILISATEURS->trouver($connexion['id_user'], null);
                        if ($user) {
                            if (isset($_POST['module'])) {
                                $module = clean_data($_POST['module']);
                                if ($module === 'connexion') {
                                    if (isset($_POST['event'])) {
                                        $event = clean_data($_POST['event']);
                                        if ($event === 'lecture') {
                                            if ($user['code_profil'] === 'ETABLI') {
                                                require_once "../../_CONFIGS/Classes/ETABLISSEMENTS.php";
                                                $ETABLISSEMENTS = new ETABLISSEMENTS();
                                                $user_profil = $UTILISATEURS->trouver_utilisateur_ets($user['id_user']);
                                                if ($user_profil) {
                                                    $ets = $ETABLISSEMENTS->trouver($user_profil['code_etablissement'], null);
                                                    if ($ets) {
                                                        $code_erreur = 200;
                                                        http_response_code($code_erreur);
                                                        $message = "La recherche s'est correctement déroulée.";
                                                        $json = array(
                                                            'success' => true,
                                                            'code_erreur' => $code_erreur,
                                                            'message' => $message,
                                                            'utilisateur' => array(
                                                                'id_user' => $user['id_user'],
                                                                'email' => $user['email'],
                                                                'code_civilite' => $user['code_civilite'],
                                                                'prenoms' => $user['prenoms'],
                                                                'nom' => $user['nom'],
                                                                'nom_patronymique' => $user['nom_patronymique'],
                                                                'code_sexe' => $user['code_sexe'],
                                                                'url_photo' => URL.'_PUBLICS/images/photos_profil/utilisateurs/'.$user['id_user'].'/'.$user['photo'],
                                                            ),
                                                            'etablissement' => array(
                                                                'code' => $ets['code'],
                                                                'raison_sociale' => $ets['raison_sociale'],
                                                                'url_logo' => URL.'_PUBLICS/images/logos/etablissements/'.$ets['code'].'/'.$ets['logo'],
                                                                'type' => array(
                                                                    'code' => $ets['type'],
                                                                    'libelle' => $ets['libelle']
                                                                ),
                                                                'situation_geographique' => array(
                                                                    'pays' => array(
                                                                        'code' => $ets['code_pays'],
                                                                        'nom' => $ets['pays'],
                                                                    ),
                                                                    'region' => array(
                                                                        'code' => $ets['code_region'],
                                                                        'nom' => $ets['region'],
                                                                    ),
                                                                    'departement' => array(
                                                                        'code' => $ets['code_departement'],
                                                                        'nom' => $ets['departement'],
                                                                    ),
                                                                    'commune' => array(
                                                                        'code' => $ets['code_commune'],
                                                                        'nom' => $ets['commune'],
                                                                    ),
                                                                    'adresse_postale' => $ets['adresse_postale'],
                                                                    'adresse_geographique' => $ets['adresse_geographique'],
                                                                ),
                                                                'monnaie' => array(
                                                                    'code' => $ets['code_monnaie'],
                                                                    'libelle' => $ets['libelle_monnaie'],
                                                                ),
                                                                'indicatif_telephonique' => $ets['indicatif_telephonique']
                                                            )
                                                        );
                                                    } else {
                                                        $code_erreur = 406;
                                                        http_response_code($code_erreur);
                                                        $message = "Aucun établissement correspondant à votre profil n'a été identifié, veuillez SVP contacter votre administrateur.";
                                                        $json = array(
                                                            'success' => false,
                                                            'code_erreur' => $code_erreur,
                                                            'message' => $message,
                                                            'footer' => $footer
                                                        );
                                                    }
                                                } else {
                                                    $code_erreur = 406;
                                                    http_response_code($code_erreur);
                                                    $message = "Aucun profil utilisateur n\'a été définit pour cet utilisateur, veuillez SVP contacter votre administrateur.";
                                                    $json = array(
                                                        'success' => false,
                                                        'code_erreur' => $code_erreur,
                                                        'message' => $message,
                                                        'footer' => $footer
                                                    );
                                                }
                                            } else {
                                                $code_erreur = 406;
                                                http_response_code($code_erreur);
                                                $message = "Le profil sélectionné n'est autorisé à utiliser cette ressource.";
                                                $json = array(
                                                    'success' => false,
                                                    'code_erreur' => $code_erreur,
                                                    'message' => $message,
                                                    'footer' => $footer
                                                );
                                            }
                                        } else {
                                            $code_erreur = 406;
                                            http_response_code($code_erreur);
                                            $message = "L'évenement demandé n'est pas répertorié.";
                                            $json = array(
                                                'success' => false,
                                                'code_erreur' => $code_erreur,
                                                'message' => $message,
                                                'footer' => $footer
                                            );
                                        }
                                    } else {
                                        $code_erreur = 406;
                                        http_response_code($code_erreur);
                                        $message = "Aucun événement n'a été sélectionné.";
                                        $json = array(
                                            'success' => false,
                                            'code_erreur' => $code_erreur,
                                            'message' => $message,
                                            'footer' => $footer
                                        );
                                    }
                                } else {
                                    $code_erreur = 406;
                                    http_response_code($code_erreur);
                                    $message = "Le module demandé n'est pas répertorié.";
                                    $json = array(
                                        'success' => false,
                                        'code_erreur' => $code_erreur,
                                        'message' => $message,
                                        'footer' => $footer
                                    );
                                }
                            } else {
                                $code_erreur = 200;
                                http_response_code($code_erreur);
                                $message = $connexion['message'];
                                $json = array(
                                    'success' => true,
                                    'code_erreur' => $code_erreur,
                                    'message' => $connexion,
                                    'footer' => $footer
                                );
                            }
                        } else {
                            $code_erreur = 406;
                            http_response_code($code_erreur);
                            $message = "Cet utilisateur est inconnu par le système.";
                            $json = array(
                                'success' => false,
                                'code_erreur' => $code_erreur,
                                'message' => $message,
                                'footer' => $footer
                            );
                        }
                    } else {
                        $code_erreur = 409;
                        http_response_code($code_erreur);
                        $message = $connexion['message'];
                        $json = array(
                            'success' => false,
                            'code_erreur' => $code_erreur,
                            'message' => $message,
                            'footer' => $footer
                        );
                    }
                } else {
                    $code_erreur = 409;
                    http_response_code($code_erreur);
                    $message = "Une erreur est survenue lors de la tentative de connexion au service demandé. Veuillez rééssayer plus tard. Si le problème persiste, contacter le service support.";
                    $json = array(
                        'success' => false,
                        'code_erreur' => $code_erreur,
                        'message' => $message,
                        'footer' => $footer
                    );
                }
            } else {
                $code_erreur = 409;
                http_response_code($code_erreur);
                $message = "Une erreur est survenue lors de l'enregistrement du log.";
                $json = array(
                    'success' => false,
                    'code_erreur' => $code_erreur,
                    'message' => $message,
                    'footer' => $footer
                );
            }
            $log_sortie = $UTILISATEURS->editer_api_logs($log_entree['id_log'], CLIENT_ADRESSE_IP, SERVEUR_ADRESSE_IP, json_encode($json));
        } else {
            $code_erreur = 406;
            http_response_code($code_erreur);
            $message = "Les paramètres définis sont incorrects.";
            $json = array(
                'success' => false,
                'code_erreur' => $code_erreur,
                'message' => $message,
                'footer' => $footer
            );
        }
    } else {
        $code_erreur = 400;
        http_response_code($code_erreur);
        $message = "Aucun paramètre conforme n'a été reçu.";
        $json = array(
            'success' => false,
            'code_erreur' => $code_erreur,
            'message' => $message,
            'footer' => $footer
        );
    }
}else {
    $code_erreur = 405;
    http_response_code($code_erreur);
    $message = "La méthode {$_SERVER['REQUEST_METHOD']} n'est pas autorisée pour ce service.";
    $json = array(
        'success' => false,
        'code_erreur' => $code_erreur,
        'message' => $message,
        'footer' => $footer
    );
}
echo json_encode($json);
