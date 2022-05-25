<?php
header('Content-Type: application/json');
if (isset($_POST)) {
    require_once "../../../../Classes/UTILISATEURS.php";
    require_once "../../../../Classes/PROFESSIONNELSDESANTE.php";
    require_once "../../../../Functions/Functions.php";
    $parametres = array(
        'id_user' => clean_data($_POST['id_user']),
        'code_etablissement' => clean_data($_POST['code_etablissement']),
        'code_profil' => clean_data($_POST['code_profil']),
        'code_specialite' => clean_data($_POST['code_specialite']),
        'code_ps_rgb' => clean_data($_POST['code_ps_rgb']),
        'code_ps' => clean_data($_POST['code_ps']),
        'num_secu' => clean_data($_POST['num_secu']),
        'email' => clean_data($_POST['email']),
        'civilite' => clean_data($_POST['civilite']),
        'nom' => clean_data($_POST['nom']),
        'nom_patronymique' => clean_data($_POST['nom_patronymique']),
        'prenoms' => clean_data($_POST['prenoms']),
        'date_naissance' => date('Y-m-d', strtotime(str_replace('/', '-', clean_data($_POST['date_naissance'])))),
        'sexe' => clean_data($_POST['sexe'])
    );

    if (isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if ($session) {
            $user = $UTILISATEURS->trouver($session['id_user'], null);
            if ($user) {
                require_once "../../../../Classes/ETABLISSEMENTS.php";
                $ETABLISSEMENTS = new ETABLISSEMENTS();
                $profil = $UTILISATEURS->trouver_profil($user['id_user']);
                if ($profil) {
                    $user_profil = $UTILISATEURS->trouver_utilisateur_ets($user['id_user']);
                    if ($user_profil) {
                        $ets = $ETABLISSEMENTS->trouver($user_profil['code_etablissement'], null);
                        if ($ets) {
                            $habilitations = $ETABLISSEMENTS->trouver_habilitations($user['id_user']);
                            $modules = preg_split('/;/', $habilitations['modules'], -1, PREG_SPLIT_NO_EMPTY);
                            $nb_modules = count($modules);
                            if ($nb_modules !== 0) {
                                $sous_modules = preg_split('/;/', $habilitations['sous_modules'], -1, PREG_SPLIT_NO_EMPTY);
                                if (in_array('AFF_PFSS', $modules, true) && in_array('EDT_PFS', $sous_modules, true)) {
                                    require_once "../../../../Classes/PROFESSIONNELSDESANTE.php";
                                    $PROFESSIONNELSDESANTE = new PROFESSIONNELSDESANTE();
                                    $edition = $UTILISATEURS->editer($parametres['id_user'], $parametres['code_profil'], $parametres['num_secu'], $parametres['email'], $parametres['civilite'], $parametres['nom'], $parametres['nom_patronymique'], $parametres['prenoms'], $parametres['date_naissance'], $parametres['sexe'], null, $user['id_user']);
                                    if ($edition['success'] === true) {
                                        $concerne = $UTILISATEURS->trouver($parametres['id_user'], null);
                                        if ($concerne) {
                                            $ps = $PROFESSIONNELSDESANTE->trouver(null, $concerne['id_user']);
                                            if ($ps) {
                                                $ps_ets = $ETABLISSEMENTS->trouver_professionnel_de_sante($ets['code'], $ps['code']);
                                                if ($ps_ets) {
                                                    $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, 'EDITION COMPTE PROFESSIONNEL DE SANTE', json_encode($parametres));
                                                    if ($audit['success'] === true) {
                                                        $sujet = "[Ouagolo]: Edition de compte.";
                                                        $expediteur = array(
                                                            'email' => "support-ouagolo@techouse.io",
                                                            'nom_prenoms' => "Support Ouagolo"
                                                        );
                                                        $destinataires[] = array(
                                                            'email' => $parametres['email'],
                                                            'nom_prenoms' => $parametres['prenoms'] . " " . $parametres['nom']
                                                        );
                                                        $message = '<!doctype html>';
                                                        $message .= '<html>';
                                                        $message .= '<head>';
                                                        $message .= '<meta charset="utf-8">';
                                                        $message .= '<meta name="viewport" content="width=device-width, initial-scale=1">';
                                                        $message .= '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">';
                                                        $message .= '<title>' . $sujet . '</title>';
                                                        $message .= '</head>';
                                                        $message .= '<body>';
                                                        $message .= '<p class="text-danger">' . salutations() . ' <b>' . ucfirst(strtolower($parametres['prenoms'])) . '</b></p>';
                                                        $message .= '<p>Nous venons par la présente t\'informer qu\'une et/ou plusieurs de tes informations personnelles ont été mises à jour sur <b><i>Ouagolo</i></b>.<br />';
                                                        $message .= 'Pour te connecter, <b><a href="' . URL . '" target="_blank">cliques ici</a></b> et utilises tes identifiants.<br />';
                                                        $message .= '<hr /><p>Pour toute information complémentaire, n\'hésites pas à nous contacter à ' . $expediteur['email'] . '</p>';
                                                        $message .= 'Cordialement <b>L\'équipe ' . $expediteur['nom_prenoms'] . '</b>';
                                                        $message .= '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>';
                                                        $message .= '</body>';
                                                        $message .= '<footer style="text-align: center">';
                                                        $message .= '<a href="https://techouse.io" target="_blank">TecHouse SARL</a>';
                                                        $message .= '</footer>';
                                                        $message .= '</html>';

                                                        $envoi = envoi_mail('../../../../../', SMTP_HOST, SMTP_USERNAME, SMTP_PASSWORD, SMTP_PORT, $sujet, $message, $expediteur, $destinataires);
                                                        if ($envoi['success'] == true) {
                                                            $json = array(
                                                                'success' => true,
                                                                'message' => $edition['message']
                                                            );
                                                        } else {
                                                            $json = $envoi;
                                                        }
                                                    } else {
                                                        $json = $audit;
                                                    }
                                                } else {
                                                    $edition_ps_ets = $ETABLISSEMENTS->ajouter_professionnel_de_sante($ets['code'], $ps['code'], $user['id_user']);
                                                    if ($edition_ps_ets['success'] === true) {
                                                        $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, 'EDITION COMPTE PROFESSIONNEL DE SANTE', json_encode($parametres));
                                                        if ($audit['success'] === true) {
                                                            $sujet = "[Ouagolo]: Edition de compte.";
                                                            $expediteur = array(
                                                                'email' => "support-ouagolo@techouse.io",
                                                                'nom_prenoms' => "Support Ouagolo"
                                                            );
                                                            $destinataires[] = array(
                                                                'email' => $parametres['email'],
                                                                'nom_prenoms' => $parametres['prenoms'] . " " . $parametres['nom']
                                                            );
                                                            $message = '<!doctype html>';
                                                            $message .= '<html>';
                                                            $message .= '<head>';
                                                            $message .= '<meta charset="utf-8">';
                                                            $message .= '<meta name="viewport" content="width=device-width, initial-scale=1">';
                                                            $message .= '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">';
                                                            $message .= '<title>' . $sujet . '</title>';
                                                            $message .= '</head>';
                                                            $message .= '<body>';
                                                            $message .= '<p class="text-danger">' . salutations() . ' <b>' . ucfirst(strtolower($parametres['prenoms'])) . '</b></p>';
                                                            $message .= '<p>Nous venons par la présente t\'informer qu\'une et/ou plusieurs de tes informations personnelles ont été mises à jour sur <b><i>Ouagolo</i></b>.<br />';
                                                            $message .= 'Pour te connecter, <b><a href="' . URL . '" target="_blank">cliques ici</a></b> et utilises tes identifiants.<br />';
                                                            $message .= '<hr /><p>Pour toute information complémentaire, n\'hésites pas à nous contacter à ' . $expediteur['email'] . '</p>';
                                                            $message .= 'Cordialement <b>L\'équipe ' . $expediteur['nom_prenoms'] . '</b>';
                                                            $message .= '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>';
                                                            $message .= '</body>';
                                                            $message .= '<footer style="text-align: center">';
                                                            $message .= '<a href="https://techouse.io" target="_blank">TecHouse SARL</a>';
                                                            $message .= '</footer>';
                                                            $message .= '</html>';

                                                            $envoi = envoi_mail('../../../../../', SMTP_HOST, SMTP_USERNAME, SMTP_PASSWORD, SMTP_PORT, $sujet, $message, $expediteur, $destinataires);
                                                            if ($envoi['success'] == true) {
                                                                $json = array(
                                                                    'success' => true,
                                                                    'message' => $edition['message']
                                                                );
                                                            } else {
                                                                $json = $envoi;
                                                            }
                                                        } else {
                                                            $json = $audit;
                                                        }
                                                    }
                                                }
                                            } else {
                                                $edition_ps = $PROFESSIONNELSDESANTE->editer($edition['id_user'], $parametres['code_ps'], $parametres['code_ps_rgb'], $parametres['code_specialite'], $user['id_user']);
                                                if ($edition_ps['success'] === true) {
                                                    $edition_ps_ets = $ETABLISSEMENTS->ajouter_professionnel_de_sante($ets['code'], $edition_ps['code'], $user['id_user']);
                                                    if ($edition_ps_ets['success'] === true) {
                                                        $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, 'CREATION DE NOUVEL UTILISATEUR PROFESSIONNEL DE SANTE', json_encode($parametres));
                                                        if ($audit['success'] === true) {
                                                            $sujet = "[Ouagolo]: Edition de compte.";
                                                            $expediteur = array(
                                                                'email' => "support-ouagolo@techouse.io",
                                                                'nom_prenoms' => "Support Ouagolo"
                                                            );
                                                            $destinataires[] = array(
                                                                'email' => $parametres['email'],
                                                                'nom_prenoms' => $parametres['prenoms'] . " " . $parametres['nom']
                                                            );
                                                            $message = '<!doctype html>';
                                                            $message .= '<html>';
                                                            $message .= '<head>';
                                                            $message .= '<meta charset="utf-8">';
                                                            $message .= '<meta name="viewport" content="width=device-width, initial-scale=1">';
                                                            $message .= '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">';
                                                            $message .= '<title>' . $sujet . '</title>';
                                                            $message .= '</head>';
                                                            $message .= '<body>';
                                                            $message .= '<p class="text-danger">' . salutations() . ' <b>' . ucfirst(strtolower($parametres['prenoms'])) . '</b></p>';
                                                            $message .= '<p>Nous venons par la présente t\'informer qu\'une et/ou plusieurs de tes informations personnelles ont été mises à jour sur <b><i>Ouagolo</i></b>.<br />';
                                                            $message .= 'Pour te connecter, <b><a href="' . URL . '" target="_blank">cliques ici</a></b> et utilises tes identifiants.<br />';
                                                            $message .= '<hr /><p>Pour toute information complémentaire, n\'hésites pas à nous contacter à ' . $expediteur['email'] . '</p>';
                                                            $message .= 'Cordialement <b>L\'équipe ' . $expediteur['nom_prenoms'] . '</b>';
                                                            $message .= '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>';
                                                            $message .= '</body>';
                                                            $message .= '<footer style="text-align: center">';
                                                            $message .= '<a href="https://techouse.io" target="_blank">TecHouse SARL</a>';
                                                            $message .= '</footer>';
                                                            $message .= '</html>';

                                                            $envoi = envoi_mail('../../../../../', SMTP_HOST, SMTP_USERNAME, SMTP_PASSWORD, SMTP_PORT, $sujet, $message, $expediteur, $destinataires);
                                                            if ($envoi['success'] === true) {
                                                                $json = array(
                                                                    'success' => true,
                                                                    'message' => $edition['message']
                                                                );
                                                            } else {
                                                                $json = $envoi;
                                                            }
                                                        } else {
                                                            $json = $audit;
                                                        }
                                                    }
                                                }
                                            }
                                        } else {
                                            $edition_ps = $PROFESSIONNELSDESANTE->editer($edition['id_user'], $parametres['code_ps'], $parametres['code_ps_rgb'], $parametres['code_specialite'], $user['id_user']);
                                            if ($edition_ps['success'] === true) {
                                                $edition_ps_ets = $ETABLISSEMENTS->ajouter_professionnel_de_sante($ets['code'], $edition_ps['code'], $user['id_user']);
                                                if ($edition_ps_ets['success'] === true) {
                                                    $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, 'CREATION DE NOUVEL UTILISATEUR PROFESSIONNEL DE SANTE', json_encode($parametres));
                                                    if ($audit['success'] === true) {
                                                        $sujet = "[Ouagolo]: Création de compte.";
                                                        $expediteur = array(
                                                            'email' => "support-ouagolo@techouse.io",
                                                            'nom_prenoms' => "Support Ouagolo"
                                                        );
                                                        $destinataires[] = array(
                                                            'email' => $parametres['email'],
                                                            'nom_prenoms' => $parametres['prenoms'] . " " . $parametres['nom']
                                                        );
                                                        $message = '<!doctype html>';
                                                        $message .= '<html>';
                                                        $message .= '<head>';
                                                        $message .= '<meta charset="utf-8">';
                                                        $message .= '<meta name="viewport" content="width=device-width, initial-scale=1">';
                                                        $message .= '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">';
                                                        $message .= '<title>' . $sujet . '</title>';
                                                        $message .= '</head>';
                                                        $message .= '<body>';
                                                        $message .= '<p class="text-danger">' . salutations() . ' <b>' . ucfirst(strtolower($parametres['prenoms'])) . '</b></p>';
                                                        $message .= '<p>Nous venons par la présente t\'informer que ton compte a été créé sur <b><i>Ouagolo</i></b>.<br />';
                                                        $message .= 'Pour te connecter, <b><a href="' . URL . '" target="_blank">cliques ici</a></b> et utilises les identifiants ci-après:<br />';
                                                        $message .= 'Email: <b>' . $parametres['email'] . '</b><br />';
                                                        $message .= 'Mot de passe: <b>' . $edition['pass'] . '</b><br /><br />';
                                                        $message .= 'Code PS: <b>' . $edition_ps['code'] . '</b><br />';
                                                        $message .= 'Centre de santé: <b>' . $ets['raison_sociale'] . '</b><br /></p>';
                                                        $message .= '<hr /><p style="color: #ff0000; font-style: italic">Ces informations sont strictement confidentielles. Elles ne doivent en aucun cas être divulguées, même à un proche car elles donnent accès à des informations médicales donc à caractères personnelles.</p>';
                                                        $message .= '<hr /><p>Pour toute information complémentaire, n\'hésites pas à nous contacter à ' . $expediteur['email'] . '</p>';
                                                        $message .= 'Cordialement <b>L\'équipe ' . $expediteur['nom_prenoms'] . '</b>';
                                                        $message .= '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>';
                                                        $message .= '</body>';
                                                        $message .= '<footer style="text-align: center">';
                                                        $message .= '<a href="https://techouse.io" target="_blank">TecHouse SARL</a>';
                                                        $message .= '</footer>';
                                                        $message .= '</html>';

                                                        $envoi = envoi_mail('../../../../../', SMTP_HOST, SMTP_USERNAME, SMTP_PASSWORD, SMTP_PORT, $sujet, $message, $expediteur, $destinataires);
                                                        if ($envoi['success'] === true) {
                                                            $json = array(
                                                                'success' => true,
                                                                'message' => "Le compte de l'utilisateur a été créé avec succès. Un email a été envoyé à l'adresse " . $parametres['email']
                                                            );
                                                        } else {
                                                            $json = $envoi;
                                                        }
                                                    } else {
                                                        $json = $audit;
                                                    }
                                                }
                                            }
                                        }
                                    } else {
                                        $json = $edition;
                                    }
                                } else {
                                    $json = array(
                                        'success' => false,
                                        'message' => "Vous n'êtes pas habilité à effectuer cette action, veuillez SVP contacter votre administrateur."
                                    );
                                }
                            } else {
                                $json = array(
                                    'success' => false,
                                    'message' => "Vous n'êtes pas habilité à effectuer cette action, veuillez SVP contacter votre administrateur."
                                );
                            }
                        } else {
                            $json = array(
                                'success' => false,
                                'message' => "Aucun établissement correspondant à votre profil n'a été identifié, veuillez SVP contacter votre administrateur.."
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
                        'message' => "Aucun utilisateur identifié pour effectué cette action."
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
    }
} else {
    $json = array(
        'success' => false,
        'message' => "Aucun paramètre n'a été défini pour cette action."
    );
}
echo json_encode($json);
