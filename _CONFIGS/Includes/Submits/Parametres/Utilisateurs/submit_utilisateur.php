<?php
header('Content-Type: application/json');
if(isset($_POST)) {
    $parametres = $_POST;
    require_once "../../../../Classes/UTILISATEURS.php";
    require_once "../../../../Functions/Functions.php";
    $UTILISATEURS = new UTILISATEURS();
    $utilisateurs = $UTILISATEURS->lister();
    $nb_utilisateurs = count($utilisateurs);
    if($nb_utilisateurs != 0) {
        $utilisateur = $UTILISATEURS->trouver($_SESSION['nouvelle_session'],null,null);
        if ($utilisateur){
            $concerne = $UTILISATEURS->trouver($parametres['id_user'],null,null);
            if($concerne) {
                $edition = $UTILISATEURS->editer($parametres['id_user'],null,$parametres['num_secu'],$parametres['num_matricule'],$parametres['nom_utilisateur'],$parametres['email'],str_replace('',null,$parametres['civilite']),$parametres['nom'],$parametres['nom_patronymique'],$parametres['prenoms'],date('Y-m-d',strtotime(str_replace('/','-',$parametres['date_naissance']))),str_replace('',null,$parametres['sexe']),null,null,$parametres['pays'],$parametres['region'],$parametres['departement'],$parametres['commune'],$parametres['adresse_geographique'],$parametres['adresse_postale'],null,null,null,null,$utilisateur['id_user']);
                if($edition['success'] == true) {
                    $audit = $UTILISATEURS->editer_piste_audit(CLIENT_ADRESSE_IP,ACTIVE_URL,'EDITION',json_encode($parametres),$utilisateur['id_user']);
                    if($audit['success'] == true) {
                        $sujet = "[Ouagolo]: Edition de compte.";
                        $expediteur = array(
                            'email' => "support-ouagolo@techouse.io",
                            'nom_prenoms' => "Support Ouagolo"
                        );
                        $destinataires[] = array(
                            'email' => $parametres['email'],
                            'nom_prenoms' => $parametres['prenoms']." ".$parametres['nom']
                        );
                        $message = '<!doctype html>';
                        $message .= '<html>';
                        $message .= '<head>';
                        $message .= '<meta charset="utf-8">';
                        $message .= '<meta name="viewport" content="width=device-width, initial-scale=1">';
                        $message .= '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">';
                        $message .= '<title>'.$sujet.'</title>';
                        $message .= '</head>';
                        $message .= '<body>';
                        $message .= '<p class="text-danger">'.salutations().' <b>'.ucfirst(strtolower($parametres['prenoms'])).'</b></p>';
                        $message .= '<p>Nous venons par la présente t\'informer qu\'une et/ou plusieurs de tes informations personnelles ont été mises à jour sur <b><i>Ouagolo</i></b>.<br />';
                        $message .= 'Pour te connecter, <b><a href="'.URL.'" target="_blank">cliques ici</a></b> et utilises tes identifiants.<br />';
                        $message .= '<hr /><p>Pour toute information complémentaire, n\'hésites pas à nous contacter à '.$expediteur['email'].'</p>';
                        $message .= 'Cordialement <b>L\'équipe '.$expediteur['nom_prenoms'].'</b>';
                        $message .= '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>';
                        $message .= '</body>';
                        $message .= '<footer style="text-align: center">';
                        $message .= '<a href="https://techouse.io" target="_blank">TecHouse SARL</a>';
                        $message .= '</footer>';
                        $message .= '</html>';

                        $envoi = envoi_mail('../../../../../',SMTP_HOST,SMTP_USERNAME,SMTP_PASSWORD,SMTP_PORT, $sujet,$message,$expediteur,$destinataires);
                        if($envoi['success'] == true) {
                            $json = array(
                                'success' => true,
                                'message' => $edition['message']
                            );
                        }else {
                            $json = $envoi;
                        }
                    }else {
                        $json = $audit;
                    }
                }
                else {
                    $json = $edition;
                }
            }
            else {
                $edition = $UTILISATEURS->editer($parametres['id_user'],null,$parametres['num_secu'],$parametres['num_matricule'],$parametres['nom_utilisateur'],$parametres['email'],str_replace('',null,$parametres['civilite']),$parametres['nom'],$parametres['nom_patronymique'],$parametres['prenoms'],date('Y-m-d',strtotime(str_replace('/','-',$parametres['date_naissance']))),str_replace('',null,$parametres['sexe']),null,null,$parametres['pays'],$parametres['region'],$parametres['departement'],$parametres['commune'],$parametres['adresse_geographique'],$parametres['adresse_postale'],null,null,null,null,$utilisateur['id_user']);
                if($edition['success'] == true) {
                    $audit = $UTILISATEURS->editer_piste_audit(CLIENT_ADRESSE_IP,ACTIVE_URL,'EDITION',json_encode($parametres),$utilisateur['id_user']);
                    if($audit['success'] == true) {
                        $sujet = "[Ouagolo]: Création de compte.";
                        $expediteur = array(
                            'email' => "support-ouagolo@techouse.io",
                            'nom_prenoms' => "Support Ouagolo"
                        );
                        $destinataires[] = array(
                            'email' => $parametres['email'],
                            'nom_prenoms' => $parametres['prenoms']." ".$parametres['nom']
                        );
                        $message = '<!doctype html>';
                        $message .= '<html>';
                        $message .= '<head>';
                        $message .= '<meta charset="utf-8">';
                        $message .= '<meta name="viewport" content="width=device-width, initial-scale=1">';
                        $message .= '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">';
                        $message .= '<title>'.$sujet.'</title>';
                        $message .= '</head>';
                        $message .= '<body>';
                        $message .= '<p class="text-danger">'.salutations().' <b>'.ucfirst(strtolower($parametres['prenoms'])).'</b></p>';
                        $message .= '<p>Nous venons par la présente t\'informer que ton compte a été créé sur <b><i>Ouagolo</i></b>.<br />';
                        $message .= 'Pour te connecter, <b><a href="'.URL.'" target="_blank">cliques ici</a></b> et utilises les identifiants ci-après:<br />';
                        $message .= 'Email: <b>'.$parametres['email'].'</b><br />';
                        $message .= 'Mot de passe: <b>'.$edition['pass'].'</b><br /></p>';
                        $message .= '<hr /><p style="color: #ff0000; font-style: italic">Ces informations sont strictement confidentielles. Elles ne doivent en aucun cas être divulguées, même à un proche car elles donnent accès à des informations médicales donc à caractères personnelles.</p>';
                        $message .= '<hr /><p>Pour toute information complémentaire, n\'hésites pas à nous contacter à '.$expediteur['email'].'</p>';
                        $message .= 'Cordialement <b>L\'équipe '.$expediteur['nom_prenoms'].'</b>';
                        $message .= '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>';
                        $message .= '</body>';
                        $message .= '<footer style="text-align: center">';
                        $message .= '<a href="https://techouse.io" target="_blank">TecHouse SARL</a>';
                        $message .= '</footer>';
                        $message .= '</html>';

                        $envoi = envoi_mail('../../../../../',SMTP_HOST,SMTP_USERNAME,SMTP_PASSWORD,SMTP_PORT, $sujet,$message,$expediteur,$destinataires);
                        if($envoi['success'] == true) {
                            $json = array(
                                'success' => true,
                                'message' => "Le compte de l'utilisateur a été créé avec succès. Un email a été envoyé à l'adresse ".$parametres['email']
                            );
                        }else {
                            $json = $envoi;
                        }
                    }else {
                        $json = $audit;
                    }
                }
                else {
                    $json = $edition;
                }
            }
        }else{
            $json = array(
                'success' => false,
                'message' => "Aucun utilisateur identifié pour effectué cette action."
            );
        }

    }
    else {
        $edition = $UTILISATEURS->editer($parametres['id_user'],null,$parametres['num_secu'],$parametres['num_matricule'],$parametres['nom_utilisateur'],$parametres['email'],null,$parametres['nom'],$parametres['nom_patronymique'],$parametres['prenoms'],date('Y-m-d',strtotime(str_replace('/','-',$parametres['date_naissance']))),null,null,null,null,null,1);
        if($edition['success'] == true) {
            $audit = $UTILISATEURS->editer_piste_audit(CLIENT_ADRESSE_IP,ACTIVE_URL, "CREATION", json_encode($parametres),1);
            if($audit['success'] == true) {
                $sujet = "[Ouagolo]: Création de compte.";
                $expediteur = array(
                    'email' => "support-ouagolo@techouse.io",
                    'nom_prenoms' => "Support Ouagolo"
                );
                $destinataires[] = array(
                    'email' => $parametres['email'],
                    'nom_prenoms' => $parametres['prenoms']." ".$parametres['nom']
                );
                $message = '<!doctype html>';
                $message .= '<html>';
                    $message .= '<head>';
                        $message .= '<meta charset="utf-8">';
                        $message .= '<meta name="viewport" content="width=device-width, initial-scale=1">';
                        $message .= '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">';
                        $message .= '<title>'.$sujet.'</title>';
                    $message .= '</head>';
                    $message .= '<body>';
                        $message .= '<p class="text-danger">'.salutations().' <b>'.ucfirst(strtolower($parametres['prenoms'])).'</b></p>';
                        $message .= '<p>Nous venons par la présente t\'informer que ton compte a bien été créé sur <b><i>Ouagolo</i></b>.<br />';
                        $message .= 'Pour te connecter, <b><a href="'.URL.'" target="_blank">cliques ici</a></b> et utilises les identifiants ci-après:<br />';
                        $message .= 'Email: <b>'.$parametres['email'].'</b><br />';
                        $message .= 'Mot de passe: <b>'.$edition['pass'].'</b><br /></p>';
                        $message .= '<hr /><p style="color: #ff0000; font-style: italic">Ces informations sont strictement confidentielles. Elles ne doivent en aucun cas être divulguées, même à un proche car elles donnent accès à des informations médicales donc à caractères personnelles.</p>';
                        $message .= '<hr /><p>Pour toute information complémentaire, n\'hésites pas à nous contacter à '.$expediteur['email'].'</p>';
                        $message .= 'Cordialement <b>L\'équipe '.$expediteur['nom_prenoms'].'</b>';
                        $message .= '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>';
                    $message .= '</body>';
                    $message .= '<footer style="text-align: center">';
                        $message .= '<a href="https://techouse.io" target="_blank">TecHouse SARL</a>';
                    $message .= '</footer>';
                $message .= '</html>';

                $envoi = envoi_mail('../../../../../',SMTP_HOST,SMTP_USERNAME,SMTP_PASSWORD,SMTP_PORT, $sujet,$message,$expediteur,$destinataires);
                if($envoi['success'] == true) {
                    $json = array(
                        'success' => true,
                        'message' => "Le compte de l'utilisateur a été créé avec succès. Un email a été envoyé à l'adresse ".$parametres['email']
                    );
                }else {
                    $json = $envoi;
                }
            }
        }else {
            $json = $edition;
        }
    }
}else {
    $json = array(
        'success' => false,
        'message' => "Aucun paramètre n'a été défini pour cette action."
    );
}
echo json_encode($json);