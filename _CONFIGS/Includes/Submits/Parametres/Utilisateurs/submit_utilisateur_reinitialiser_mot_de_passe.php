<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header('Content-Type: application/json');
if (isset($_POST)) {
    require_once "../../../../Classes/UTILISATEURS.php";
    require_once "../../../../Classes/ETABLISSEMENTS.php";
    require_once "../../../../Classes/ORGANISMES.php";
    require_once "../../../../Functions/Functions.php";
    $parametres = array(
        'id_user' => clean_data($_POST['id_user'])
    );
    if (isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $ETABLISSEMENTS = new ETABLISSEMENTS();
        $ORGANISMES = new ORGANISMES();
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if ($session) {
            $utilisateur = $UTILISATEURS->trouver($session['id_user'], null);
            if ($utilisateur) {
                $concerne = $UTILISATEURS->trouver($parametres['id_user'], null, null);
                if ($concerne) {
                    $edition = $UTILISATEURS->reset_mot_de_passe($concerne['id_user'], $utilisateur['id_user']);
                    if ($edition['success'] == true) {
                        $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, 'RESET MOT DE PASSE UTILISATEUR', json_encode($parametres));
                        if ($audit['success'] == true) {
                            $sujet = "[Ouagolo]: Mise à jour mot de passe.";
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
                            $message .= 'Pour te connecter, <b><a href="'.URL.'" target="_blank">clique ici</a></b> et utilise tes identifiants.<br />';
                            $message .= 'NOUVEAU MOT DE PASSE: <b>'.$edition['pass'].'<br /><b/>EMAIL: <b>'.$concerne['email'].'<b/><br />';
                            $message .= 'Cordialement <b>L\'équipe '.$expediteur['nom_prenoms'].'</b>';
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
