<?php
header('Content-Type: application/json');
if (isset($_POST)) {
    require_once "../../../../Classes/UTILISATEURS.php";
    require_once "../../../../Functions/Functions.php";
    $parametres = array(
        'id_user' => clean_data($_POST['id_user']),
        'code_etablissement' => clean_data($_POST['code_etablissement']),
        'code_organisme' => clean_data($_POST['code_organisme']),
        'code_profil' => clean_data($_POST['code_profil']),
        'num_secu' => clean_data($_POST['num_secu']),
        'email' => clean_data($_POST['email']),
        'civilite' => clean_data($_POST['civilite']),
        'nom' => clean_data($_POST['nom']),
        'nom_patronymique' => clean_data($_POST['nom_patronymique']),
        'prenoms' => clean_data($_POST['prenoms']),
        'date_naissance' => date('Y-m-d', strtotime(str_replace('/', '-', clean_data($_POST['date_naissance'])))),
        'sexe' => clean_data($_POST['sexe'])
    );

    $UTILISATEURS = new UTILISATEURS();
    $utilisateurs = $UTILISATEURS->lister();
    $nb_utilisateurs = count($utilisateurs);
    if ($nb_utilisateurs != 0) {
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if ($session) {
            $utilisateur = $UTILISATEURS->trouver($session['id_user'], null);
            if ($utilisateur) {
                $edition = $UTILISATEURS->editer($parametres['id_user'], $parametres['code_profil'], $parametres['num_secu'], $parametres['email'], $parametres['civilite'], $parametres['nom'], $parametres['nom_patronymique'], $parametres['prenoms'], date('Y-m-d', strtotime(str_replace('/', '-', $parametres['date_naissance']))), $parametres['sexe'], null, $utilisateur['id_user']);
                if ($edition['success'] == true) {
                    $concerne = $UTILISATEURS->trouver($parametres['id_user'], null);
                    if ($concerne) {
                        $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, 'EDITION DE COMPTE UTILISATEUR', json_encode($parametres));
                        if ($audit['success'] == true) {
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
                        if ($parametres['code_profil'] == 'ORGANI') {
                            require_once "../../../../Classes/ORGANISMES.php";
                            $ORGANISMES = new ORGANISMES();
                            $edition_profil = $ORGANISMES->editer_utilisateur($edition['id_user'], $parametres['code_organisme'], $utilisateur['id_user']);
                            if ($edition_profil['success'] == true) {
                                $sortie = true;
                            } else {
                                $sortie = false;
                            }
                        } elseif ($parametres['code_profil'] === 'ETABLI') {
                            require_once "../../../../Classes/ETABLISSEMENTS.php";
                            $ETABLISSEMENTS = new ETABLISSEMENTS();
                            $edition_profil = $ETABLISSEMENTS->editer_utilisateur($edition['id_user'], $parametres['code_etablissement'], $utilisateur['id_user']);
                            if ($edition_profil['success'] == true) {
                                $sortie = true;
                            } else {
                                $sortie = false;
                            }
                        } else {
                            $sortie = true;
                        }

                        if ($sortie == true) {
                            $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, 'CREATION DE NOUVEL UTILISATEUR ', json_encode($parametres));
                            if ($audit['success'] == true) {
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
                                $message .= 'Mot de passe: <b>' . $edition['pass'] . '</b><br /></p>';
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
                                if ($envoi['success'] == true) {
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
                } else {
                    $json = $edition;
                }
            } else {
                $json = array(
                    'success' => false,
                    'message' => "Aucun utilisateur identifié pour effectué cette action."
                );
            }
        } else {
        }
    } else {
        $edition = $UTILISATEURS->editer($parametres['id_user'], 'ADMN', $parametres['num_secu'], $parametres['email'], null, $parametres['nom'], $parametres['nom_patronymique'], $parametres['prenoms'], date('Y-m-d', strtotime(str_replace('/', '-', $parametres['date_naissance']))), null, null, 1);
        if ($edition['success'] == true) {
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
            $message .= '<p>Nous venons par la présente t\'informer que ton compte a bien été créé sur <b><i>Ouagolo</i></b>.<br />';
            $message .= 'Pour te connecter, <b><a href="' . URL . '" target="_blank">cliques ici</a></b> et utilises les identifiants ci-après:<br />';
            $message .= 'Email: <b>' . $parametres['email'] . '</b><br />';
            $message .= 'Mot de passe: <b>' . $edition['pass'] . '</b><br /></p>';
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
            if ($envoi['success'] == true) {
                $json = array(
                    'success' => true,
                    'message' => "Le compte de l'utilisateur a été créé avec succès. Un email a été envoyé à l'adresse " . $parametres['email']
                );
            } else {
                $json = $envoi;
            }
        } else {
            $json = $edition;
        }
    }
} else {
    $json = array(
        'success' => false,
        'message' => "Aucun paramètre n'a été défini pour cette action."
    );
}
echo json_encode($json);
