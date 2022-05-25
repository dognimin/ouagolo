<?php
header('Content-Type: application/json');
if(isset($_POST)) {
    $parametres = $_POST;
    require_once "../../../../Classes/UTILISATEURS.php";
    require_once "../../../../Functions/Functions.php";
    $UTILISATEURS = new UTILISATEURS();
    $utilisateur = $UTILISATEURS->trouver(null,$parametres['email']);
    if($utilisateur) {
        $edition = $UTILISATEURS->reset_mot_de_passe($utilisateur['id_user'], $utilisateur['id_user']);
        if($edition['success'] == true) {
            $audit = $UTILISATEURS->editer_piste_audit(CLIENT_ADRESSE_IP,ACTIVE_URL, "REINITIALISATION MDP", json_encode($parametres),$utilisateur['id_user']);
            if($audit['success'] == true) {
                $sujet = "[Ouagolo]: Réinitialisation du mot de passe.";
                $expediteur = array(
                    'email' => "support-ouagolo@techouse.io",
                    'nom_prenoms' => "Support Ouagolo"
                );
                $destinataires[] = array(
                    'email' => $utilisateur['email'],
                    'nom_prenoms' => $utilisateur['prenoms']." ".$utilisateur['nom']
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
                $message .= '<p class="text-danger">'.salutations().' <b>'.ucfirst(strtolower($utilisateur['prenoms'])).'</b></p>';
                $message .= '<p>Tu as initié une demande de réinitialisation du mot de passe sur <b><i>Ouagolo</i></b>.<br />';
                $message .= 'Pour te connecter, <b><a href="'.URL.'" target="_blank">cliques ici</a></b> et utilises les nouveaux identifiants ci-après:<br />';
                $message .= 'Email: <b>'.$utilisateur['email'].'</b><br />';
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
                        'message' => "Le nouveau mot de passe a été envoyé à ".$parametres['email'].". Consultes ta boîte de réception. N'hésites pas à regarder dans la rubrique SPAM si tu n'as pas récu le mail."
                    );
                }else {
                    $json = $envoi;
                }
            }else {
                $json = $audit;
            }
        }else {
            $json = $edition;
        }
    }else {
        $json = array(
            'success' => false,
            'message' => "L'adresse mail {$parametres['email']} n'est pas reconnu par le système."
        );
    }
}else {
    $json = array(
        'success' => false,
        'message' => "Aucun paramètre n'a été défini pour cette action."
    );
}
echo json_encode($json);