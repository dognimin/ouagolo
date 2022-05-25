<?php
header('Content-Type: application/json');
if (isset($_POST)) {
    require_once "../../../../Classes/UTILISATEURS.php";
    require_once "../../../../Functions/Functions.php";
    $parametres = array(
        'code' => clean_data($_POST['code']),
        'code_fournisseur' => clean_data($_POST['code_fournisseur'])
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
                                if (in_array('AFF_PHCIE', $modules, true) && in_array('EDT_PHCIE_CMDS', $sous_modules, true)) {
                                    $nb_produits = count($_POST['code_produit']);
                                    $nb_produits_enregistres = 0;
                                    if ($nb_produits !== 0) {
                                        $edition = $ETABLISSEMENTS->ajouter_commande($ets['code'], $parametres['code'], $parametres['code_fournisseur'], $user['id_user']);
                                        if ($edition['success'] === true) {
                                            for ($i = 0; $i < $nb_produits; $i++) {
                                                $produit = $ETABLISSEMENTS->ajouter_commande_produit($edition['code'], $_POST['code_produit'][$i], $_POST['quantite'][$i], $_POST['prix_unitaire'][$i], str_replace('%', '', $_POST['remise'][$i]), $user['id_user']);
                                                if ($produit['success'] === true) {
                                                    $nb_produits_enregistres++;
                                                }
                                            }
                                            if ($nb_produits === $nb_produits_enregistres) {
                                                $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, 'EDITION ETABLISSEMENT COMMANDE', json_encode($parametres));
                                                if ($audit['success'] === true) {
                                                    $json = array(
                                                        'success' => true,
                                                        'code' => $edition['code'],
                                                        'message' => $edition['message']
                                                    );
                                                } else {
                                                    $json = $audit;
                                                }
                                            } else {
                                                $json = $produit;
                                            }
                                        } else {
                                            $json = $edition;
                                        }
                                    } else {
                                        $json = array(
                                            'success' => false,
                                            'message' => "Veuillez renseigner au moins un produit."
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
