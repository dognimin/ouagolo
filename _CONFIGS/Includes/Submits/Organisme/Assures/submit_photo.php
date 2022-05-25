<?php
header('Content-Type: application/json');
if (isset($_POST)) {
    require_once "../../../../Classes/UTILISATEURS.php";
    require_once "../../../../Functions/Functions.php";
    $parametres = array(
        'num_population' => clean_data($_POST['photo_num_patient_input']),
        'filename' => clean_data($_FILES['photo_input']['name']),
        'filetemp' => clean_data($_FILES['photo_input']['tmp_name']),
        'filetype' => clean_data($_FILES['photo_input']['type']),
        'filesize' => (int)(clean_data($_FILES['photo_input']['size']) / 1024),
        'fileextension' => strtolower(clean_data(strrchr($_FILES['photo_input']['name'], '.'))),
        'server_user' => 'apache',
        'extensions_autorisees' => array('.png', '.jpeg', '.jpg', '.webp')
    );
    if (isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if ($session) {
            $user = $UTILISATEURS->trouver($session['id_user'], null);
            if ($user) {
                require_once "../../../../Classes/ORGANISMES.php";
                $ORGANISMES = new ORGANISMES();
                $user_profil = $UTILISATEURS->trouver_utilisateur_organisme($user['id_user']);
                if($user_profil) {
                    $organisme = $ORGANISMES->trouver($user_profil['code_organisme']);
                    if($organisme) {
                        if (in_array($parametres['fileextension'], $parametres['extensions_autorisees'], true)) {
                            if ($parametres['filesize'] <= 500) {
                                $path = DIR.'_PUBLICS/images/photos_profil/populations/'.$parametres['num_population'].'/';
                                if (!file_exists($path)) {
                                    if (!mkdir($path, 0777, true) && !is_dir($path)) {
                                        throw new \RuntimeException(sprintf('Directory "%s" was not created', $path));
                                    }
                                }
                                $nouveau_nom = sha1(date('dmYHis', time()).$parametres['num_population']).$parametres['fileextension'];
                                if (move_uploaded_file($parametres['filetemp'], $path.$nouveau_nom)) {
                                    require_once "../../../../Classes/POPULATIONS.php";
                                    $POPULATIONS = new POPULATIONS();
                                    $edition = $POPULATIONS->editer_photo($parametres['num_population'], $nouveau_nom, $user['id_user']);
                                    if ($edition['success'] == true) {
                                        $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, 'EDITION PHOTO ASSURE', json_encode($parametres));
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
                                } else {
                                    $json = array(
                                        'success' => false,
                                        'message' => "Une erreur est survenue lors du chargement de la photo de profil."
                                    );
                                }
                            } else {
                                $json = array(
                                    'success' => false,
                                    'message' => "L'image sélectionnée est trop lourde <b>({$parametres['filesize']}Ko)</b> pour être chargée, prière sélectionner une image de taille inférieure ou égale à 500Ko."
                                );
                            }
                        } else {
                            $json = array(
                                'success' => false,
                                'message' => "L'extension <b>{$parametres['fileextension']}</b> n'est pas autorisé pour ce chargement."
                            );
                        }
                    }else {
                        $json = array(
                            'success' => false,
                            'message' => "Aucun organisme correspondant à votre profil n\'a été identifié, veuillez SVP contacter votre administrateur."
                        );
                    }
                }else {
                    $json = array(
                        'success' => false,
                        'message' => "Aucun profil utilisateur n\'a été définit pour cet utilisateur, veuillez SVP contacter votre administrateur."
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
}else {
    $json = array(
        'success' => false,
        'message' => "Aucun paramètre n'a été défini pour cette action."
    );
}
echo json_encode($json);