<?php
header('Content-Type: application/json');
if(isset($_POST)) {
    require_once "../../../../Classes/UTILISATEURS.php";
    require_once "../../../../Functions/Functions.php";
    $parametres = array(
        'id_user' => clean_data($_POST['photo_num_utilisateur_input']),
        'filename' => clean_data($_FILES['photo_input']['name']),
        'filetemp' => clean_data($_FILES['photo_input']['tmp_name']),
        'filetype' => clean_data($_FILES['photo_input']['type']),
        'filesize' => intval(clean_data($_FILES['photo_input']['size']) / 1024),
        'fileextension' => strtolower(clean_data(strrchr($_FILES['photo_input']['name'], '.'))),
        'server_user' => 'apache',
        'extensions_autorisees' => array('.png', '.jpeg', '.jpg')
    );
    if(isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if ($session) {
            $utilisateur = $UTILISATEURS->trouver($session['id_user'],null);
            if($utilisateur) {
                $concerne = $UTILISATEURS->trouver($parametres['id_user'], null);
                if($concerne) {
                    if(in_array($parametres['fileextension'], $parametres['extensions_autorisees'])) {
                        if($parametres['filesize'] <= 500) {
                            $path = DIR.'_PUBLICS/images/photos_profil/utilisateurs/'.$concerne['id_user'].'/';
                            if(!file_exists($path)) {
                                mkdir($path,0777, true);
                            }
                            $nouveau_nom = sha1(date('dmYHis',time()).$concerne['id_user']).$parametres['fileextension'];
                            if(move_uploaded_file($parametres['filetemp'],$path.$nouveau_nom)) {
                                $edition = $UTILISATEURS->editer_photo($concerne['id_user'], $nouveau_nom, $utilisateur['id_user']);
                                if($edition['success'] == true) {
                                    $audit = $UTILISATEURS->editer_piste_audit($session['code_session'],ACTIVE_URL,'EDITION PHOTO UTILISATEUR',json_encode($parametres));
                                    if($audit['success'] == true) {
                                        $json = array(
                                            'success' => true,
                                            'message' => $edition['message']
                                        );
                                    }else {
                                        $json = $audit;
                                    }
                                }else {
                                    $json = $edition;
                                }
                            }else {
                                $json = array(
                                    'success' => false,
                                    'message' => "Une erreur est survenue lors du chargement de la photo de profil."
                                );
                            }
                        }else {
                            $json = array(
                                'success' => false,
                                'message' => "L'image sélectionnée est trop lourde <b>({$parametres['filesize']}Ko)</b> pour être chargée, prière sélectionner une image de taille inférieure ou égale à 300Ko."
                            );
                        }
                    }else {
                        $json = array(
                            'success' => false,
                            'message' => "L'extension <b>{$parametres['fileextension']}</b> n'est pas autorisé pour ce chargement."
                        );
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