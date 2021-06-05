<?php
header('Content-Type: application/json');
if(isset($_POST)) {
    $parametres = $_POST;
    require_once "../../../../Classes/UTILISATEURS.php";
    require_once "../../../../Functions/Functions.php";
    if(isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $utilisateur = $UTILISATEURS->trouver($_SESSION['nouvelle_session'],null,null);
        if($utilisateur) {
            $concerne = $UTILISATEURS->trouver($parametres['id_user'],null,null);
            if($concerne) {

                $edition = $UTILISATEURS->reset_mot_de_passe($concerne['id_user'], $utilisateur['id_user']);
                if($edition['success'] == true) {
                    $audit = $UTILISATEURS->editer_piste_audit(CLIENT_ADRESSE_IP,ACTIVE_URL,'MISE A JOUR DU PROFIL','********',$utilisateur['id_user']);
                    if($audit['success'] == true) {
                        $json= array(
                            'success' => true,
                            'message' =>$edition['message']
                        );
                    }
                      /*  $sujet = "[Ouagolo]: Mise à jour mote de passe.";
                        $expediteur = array(
                            'email' => "support-ouagolo@techouse.io",
                            'nom_prenoms' => "Support Ouagolo"
                        );
                        $destinataires[] = array(
                            'email' => $concerne['email'],
                            'nom_prenoms' => $concerne['prenoms']." ".$concerne['nom']
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
                        $message .= '<p class="text-danger">'.salutations().' <b>'.ucfirst(strtolower($concerne['prenoms'])).'</b></p>';
                        $message .= '<p>Nous venons par la présente t\'informer de la mise a jour de ton mot de passe  sur <b><i>Ouagolo</i></b>.<br />';
                        $message .= 'Pour te connecter, <b><a href="'.URL.'" target="_blank">cliques ici</a></b> et utilises tes identifiants.<br />';
                        $message .= 'NOUVEAU MOT DE PASSE: <b>'.$edition['pass'].'<b/> EMAIL: <b>'.$concerne['email'].'<b/>';
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
                            );*/
                     /*   }else {
                            $json = $envoi;
                        }
                    }else {
                        $json = $audit;
                    }*/
                }else {
                    $json = $edition;
                }
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
        'message' => "Aucun paramètre n'a été défini pour cette action."
    );
}
echo json_encode($json);
