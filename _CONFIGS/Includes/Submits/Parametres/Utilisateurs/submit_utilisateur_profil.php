<?php
header('Content-Type: application/json');
if (isset($_POST)) {
    require_once "../../../../Classes/UTILISATEURS.php";
    require_once "../../../../Classes/ETABLISSEMENTS.php";
    require_once "../../../../Classes/ORGANISMES.php";
    require_once "../../../../Functions/Functions.php";
    $parametres = array(
        'id_user' => clean_data($_POST['id_user']),
        'code_etablissement' => strtoupper(clean_data($_POST['code_etablissement'])),
        'code_organisme' => strtoupper(clean_data($_POST['code_organisme'])),
        'code_profil' => strtoupper(clean_data($_POST['code_profil']))
    );
    if (isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $ETABLISSEMENTS = new ETABLISSEMENTS();
        $ORGANISMES = new ORGANISMES();
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if ($session) {
            $utilisateur = $UTILISATEURS->trouver($session['id_user'], null);
            if ($utilisateur) {
                $concerne = $UTILISATEURS->trouver($parametres['id_user'], null);
                if ($concerne) {
                    if ($concerne['code_profil'] === 'ETABLI') {
                        $ets_utilisateur = $UTILISATEURS->trouver_utilisateur_ets($concerne['id_user']);
                        if ($ets_utilisateur) {
                            if ($parametres['code_profil'] == $concerne['code_profil']) {
                                if ($parametres['code_etablissement'] != $ets_utilisateur['code_etablissement']) {
                                    $edition_profil = $ETABLISSEMENTS->ajouter_utilisateur($concerne['id_user'], $parametres['code_etablissement'], $utilisateur['id_user']);
                                } else {
                                    $edition_profil = array(
                                        'success' => false,
                                        'message' => "L'utilisateur possède déjà ce profil. Il ne peut donc être mis à jour."
                                    );
                                }
                            } else {
                                $fermer_ets = $ETABLISSEMENTS->fermer_utilisateur($concerne['id_user'], $ets_utilisateur['code_etablissement'], date('Y-m-d H:i:s', time()), $utilisateur['id_user']);
                                if ($fermer_ets['success'] == true) {
                                    if ($parametres['code_profil'] === 'ORGANI') {
                                        $organisme_utilisateur = $UTILISATEURS->trouver_utilisateur_organisme($concerne['id_user']);
                                        $json = $organisme_utilisateur;
                                        if (!$organisme_utilisateur) {
                                            $edition_profil = $ORGANISMES->ajouter_utilisateur($concerne['id_user'], $parametres['code_organisme'], $utilisateur['id_user']);
                                        } else {
                                            $edition_profil = array(
                                                'success' => false,
                                                'message' => "Cet utilisateur appartient déjà un autre organisme. Prière contacter votre administrateur."
                                            );
                                        }

                                    } else {
                                        $edition_profil = array(
                                            'success' => true
                                        );
                                    }
                                } else {
                                    $edition_profil = array(
                                        'success' => false,
                                        'message' => $fermer_ets['message']
                                    );
                                }
                            }
                        } else {
                            if($parametres['code_profil'] === 'ETABLI') {
                                $edition_profil = $ETABLISSEMENTS->ajouter_utilisateur($concerne['id_user'], $parametres['code_etablissement'], $utilisateur['id_user']);
                            }elseif($parametres['code_profil'] === 'ORGANI') {
                                $edition_profil = $ORGANISMES->ajouter_utilisateur($concerne['id_user'], $parametres['code_organisme'], $utilisateur['id_user']);
                            }else {
                                $edition_profil = array(
                                    'success' => false,
                                    'message' => "Aucun utilisateur correspondant à ce profil n'a été trouvé."
                                );
                            }
                        }

                    }
                    elseif ($concerne['code_profil'] === 'ORGANI') {
                        $organisme_utilisateur = $UTILISATEURS->trouver_utilisateur_organisme($concerne['id_user']);
                        if ($organisme_utilisateur) {
                            if ($parametres['code_profil'] == $concerne['code_profil']) {
                                if ($parametres['code_organisme'] != $organisme_utilisateur['code_organisme']) {
                                    $fermer_profil = $ORGANISMES->fermer_utilisateur($concerne['id_user'], $organisme_utilisateur['code_organisme'], date('Y-m-d H:i:s', time()), $utilisateur['id_user']);
                                    if($fermer_profil['success'] === true) {
                                        $edition_profil = $ORGANISMES->ajouter_utilisateur($concerne['id_user'], $parametres['code_organisme'], $utilisateur['id_user']);
                                    }else {
                                        $edition_profil = $fermer_profil;
                                    }
                                } else {
                                    $edition_profil = array(
                                        'success' => false,
                                        'message' => "L'utilisateur possède déjà ce profil. Il ne peut donc être mis à jour."
                                    );
                                }
                            } else {
                                $fermer_organisme = $ORGANISMES->fermer_utilisateur($concerne['id_user'], $organisme_utilisateur['code_organisme'], date('Y-m-d H:i:s', time()), $utilisateur['id_user']);
                                if ($fermer_organisme['success'] == true) {
                                    if ($parametres['code_profil'] === 'ETABLI') {
                                        $ets_utilisateur = $UTILISATEURS->trouver_utilisateur_ets($concerne['id_user']);
                                        if (!$ets_utilisateur) {
                                            $edition_profil = $ETABLISSEMENTS->editer_utilisateur($concerne['id_user'], $parametres['code_etablissement'], $utilisateur['id_user']);
                                        } else {
                                            $edition_profil = array(
                                                'success' => false,
                                                'message' => "Cet utilisateur appartient déjà un autre établissement. Prière contacter votre administrateur."
                                            );
                                        }
                                    } else {
                                        $edition_profil = array(
                                            'success' => true
                                        );
                                    }
                                } else {
                                    $edition_profil = array(
                                        'success' => false,
                                        'message' => $fermer_organisme['message']
                                    );
                                }
                            }
                        } else {
                            if($parametres['code_profil'] === 'ETABLI') {
                                $edition_profil = $ETABLISSEMENTS->ajouter_utilisateur($concerne['id_user'], $parametres['code_etablissement'], $utilisateur['id_user']);
                            }elseif($parametres['code_profil'] === 'ORGANI') {
                                $edition_profil = $ORGANISMES->ajouter_utilisateur($concerne['id_user'], $parametres['code_organisme'], $utilisateur['id_user']);
                            }else {
                                $edition_profil = array(
                                    'success' => false,
                                    'message' => "Aucun utilisateur correspondant à ce profil n'a été trouvé."
                                );
                            }
                        }
                    }
                    elseif ($concerne['code_profil'] === 'PS') {
                        $edition_profil = array(
                            'success' => false,
                            'message' => "Ce profil n'a pas encore été mis à jour."
                        );
                    }
                    elseif ($concerne['code_profil'] === 'ADMN') {
                        if($parametres['code_profil'] === 'ETABLI') {
                            $ets_utilisateur = $UTILISATEURS->trouver_utilisateur_ets($concerne['id_user']);
                            if($ets_utilisateur) {
                                $fermer_ets = $ETABLISSEMENTS->editer_utilisateur($concerne['id_user'], $ets_utilisateur['code_etablissement'], $utilisateur['id_user']);
                                if ($fermer_ets['success'] == true) {
                                    $edition_profil = $ETABLISSEMENTS->editer_utilisateur($concerne['id_user'], $parametres['code_etablissement'], $utilisateur['id_user']);
                                }else {
                                    $edition_profil = $fermer_ets;
                                }
                            } else {
                                $edition_profil = $ETABLISSEMENTS->editer_utilisateur($concerne['id_user'], $parametres['code_etablissement'], $utilisateur['id_user']);
                            }
                        }
                        if($parametres['code_profil'] === 'ORGANI') {
                            $organisme_utilisateur = $UTILISATEURS->trouver_utilisateur_organisme($concerne['id_user']);
                            if ($organisme_utilisateur) {
                                $fermer_organisme = $ORGANISMES->editer_utilisateur($concerne['id_user'], $organisme_utilisateur['code_organisme'], $utilisateur['id_user']);
                                if ($fermer_organisme['success'] == true) {
                                    $edition_profil = $ORGANISMES->editer_utilisateur($concerne['id_user'], $parametres['code_organisme'], $utilisateur['id_user']);
                                }else {
                                    $edition_profil = $fermer_organisme;
                                }
                            } else {
                                $edition_profil = $ORGANISMES->editer_utilisateur($concerne['id_user'], $parametres['code_organisme'], $utilisateur['id_user']);
                            }
                        }
                    } else {
                        $edition_profil = array(
                            'success' => false,
                            'message' => "Le profil sélectionné n'est pas géré par ce système."
                        );
                    }
                    if ($edition_profil['success'] == true) {
                        $edition = $UTILISATEURS->editer_profil($concerne['id_user'], $parametres['code_profil'], $utilisateur['id_user']);
                        if ($edition['success'] == true) {
                            $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, 'EDITION DU PROFIL UTILISATEUR', json_encode($parametres));
                            if ($audit['success'] == true) {
                                $json = array(
                                    'success' => true,
                                    'message' => "Enregistrement effectué avec succès."
                                );
                            } else {
                                $json = $audit;
                            }
                        } else {
                            $json = $edition;
                        }
                    } else {
                        $json = $edition_profil;
                    }
                } else {
                    $json = array(
                        'success' => false,
                        'message' => "Cet utilisateur est inconnu."
                    );
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
