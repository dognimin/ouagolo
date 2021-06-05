<?php
header('Content-Type: application/json');
if (isset($_POST)) {
    $parametres = $_POST;
    require_once "../../../../Classes/UTILISATEURS.php";
    require_once "../../../../Classes/ETABLISSEMENTS.php";
    if (isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $ETABLISSEMENTAGENTS = new ETABLISSEMENTS();
        $utilisateur = $UTILISATEURS->trouver($_SESSION['nouvelle_session'], null, null);
        if ($utilisateur) {
            $concerne = $UTILISATEURS->trouver_statut($parametres['id_user']);
            $trouver_responsable = $ETABLISSEMENTAGENTS->trouver_responsable($parametres['code_etablissement'], $parametres['id_user']);
            $trouver_agent = $ETABLISSEMENTAGENTS->trouver_agent($parametres['code_etablissement'], $parametres['id_user']);
            if ($concerne) {
                if ($parametres['code_profil'] == "CSAGNT") {
                    if ($trouver_responsable) {
                        $edition = $ETABLISSEMENTAGENTS->editer_responsable($parametres['id_user'], $parametres['code_etablissement'], $utilisateur['id_user']);
                        if ($edition['success'] == true) {
                            if ($trouver_agent) {
                                $edition = array(
                                    'success' => false,
                                    'message' => 'Désolé' . ' ' . $trouver_agent['nom'] . '' . $trouver_agent['prenoms'] . ' est déjà dans une agence!'
                                );
                            } else {
                                $edition = $ETABLISSEMENTAGENTS->editer_agent($parametres['id_user'], $parametres['code_etablissement'], $utilisateur['id_user']);
                                if ($edition['success'] == true) {
                                    $edition = $UTILISATEURS->editer_profil($concerne['id_user'], $parametres['code_profil'], $utilisateur['id_user']);

                                }
                            }
                        } else {
                            $edition = array(
                                'success' => false,
                                'message' => $edition['message']
                            );
                            if ($edition['success'] == true) {
                                $edition = $UTILISATEURS->editer_profil($concerne['id_user'], $parametres['code_profil'], $utilisateur['id_user']);

                            }
                        }
                    } else {
                        if ($trouver_agent) {
                            $json = array(
                                'success' => false,
                                'message' => 'Désolé' . ' ' . $trouver_agent['nom'] . '' . $trouver_agent['prenoms'] . ' est déjà dans une agence!'
                            );
                        } else {
                            $edition = $ETABLISSEMENTAGENTS->editer_agent($parametres['id_user'], $parametres['code_etablissement'], $utilisateur['id_user']);
                            if ($edition['success'] == true) {
                                $edition = $UTILISATEURS->editer_profil($concerne['id_user'], $parametres['code_profil'], $utilisateur['id_user']);

                            }
                        }
                    }
                }
                 if ($parametres['code_profil'] == "CSRESP") {
                    if ($trouver_agent) {
                        $edition = $ETABLISSEMENTAGENTS->editer_agent($parametres['id_user'], $parametres['code_etablissement'], $utilisateur['id_user']);
                        if ($edition['success'] == true) {
                            if ($trouver_responsable) {
                                $edition = array(
                                    'success' => false,
                                    'message' => 'Désolé' . ' ' . $trouver_responsable['nom'] . '' . $trouver_responsable['prenoms'] . ' est déjà Responsable de cette agence!'
                                );
                            } else {
                                $edition = $ETABLISSEMENTAGENTS->editer_responsable($parametres['id_user'], $parametres['code_etablissement'], $utilisateur['id_user']);
                                if ($edition['success'] == true) {
                                    $edition = $UTILISATEURS->editer_profil($concerne['id_user'], $parametres['code_profil'], $utilisateur['id_user']);

                                }

                            }
                        }
                    } else {
                        if ($trouver_responsable) {
                            $json = array(
                                'success' => false,
                                'message' => 'Désolé' . ' ' . $trouver_responsable['nom'] . '' . $trouver_responsable['prenoms'] . ' est déjà Responsable de cette agence!'
                            );
                        } else {
                            $edition = $ETABLISSEMENTAGENTS->editer_responsable($parametres['id_user'], $parametres['code_etablissement'], $utilisateur['id_user']);
                            if ($edition['success'] == true) {
                                $edition = $UTILISATEURS->editer_profil($concerne['id_user'], $parametres['code_profil'], $utilisateur['id_user']);

                            }
                        }
                    }


                }
                if ($parametres['code_profil'] =! "CSAGNT" && $parametres['code_profil'] =! "CSRESP"){
                    if ($trouver_responsable){
                        $edition = $ETABLISSEMENTAGENTS->editer_responsable($parametres['id_user'], $parametres['code_etablissement'], $utilisateur['id_user']);
                        $edition = $UTILISATEURS->editer_profil($concerne['id_user'], $parametres['code_profil'], $utilisateur['id_user']);

                    }elseif ($trouver_agent){
                        $edition = $ETABLISSEMENTAGENTS->editer_responsable($parametres['id_user'], $parametres['code_etablissement'], $utilisateur['id_user']);
                        $edition = $UTILISATEURS->editer_profil($concerne['id_user'], $parametres['code_profil'], $utilisateur['id_user']);

                    }else{
                        $edition = $UTILISATEURS->editer_profil($concerne['id_user'], $parametres['code_profil'], $utilisateur['id_user']);

                    }

                }


                if ($edition['success'] == true) {
                    $audit = $UTILISATEURS->editer_piste_audit(CLIENT_ADRESSE_IP, ACTIVE_URL, 'MISE A JOUR DU PROFIL', '********', $utilisateur['id_user']);
                    if ($audit['success'] == true) {
                        $json = array(
                            'success' => true,
                            'message' => $edition['message']
                        );
                    } else {
                        $json = $audit;
                    }
                } else {
                    $json = $edition;
                }
            }

        } else {
            $json = array(
                'success' => false,
                'message' => "Aucun utilisateur identifié pour effectué cette action."
            );
        }
    } else {
        $json = array(
            'success' => false,
            'message' => "Aucune session active pour vérifier cette action."
        );
    }
} else {
    $json = array(
        'success' => false,
        'message' => "Aucun paramètre n'a été défini pour cette action."
    );
}
echo json_encode($json);
