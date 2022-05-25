<?php
header('Content-Type: application/json');
if (isset($_POST)) {
    require_once "../../../../Classes/UTILISATEURS.php";
    require_once "../../../../Functions/Functions.php";
    $parametres = array(
        'num_facture_initiale' => clean_data($_POST['num_facture_initiale']),
        'num_population' => clean_data($_POST['num_ip']),
        'code_organisme' => clean_data($_POST['code_organisme']),
        'taux_organisme' => clean_data($_POST['taux_organisme']),
        'code_collectivite' => clean_data($_POST['code_collectivite']),
        'montant_brut' => clean_data($_POST['montant_brut']),
        'montant_rgb' => clean_data($_POST['montant_rgb']),
        'montant_organisme' => clean_data($_POST['montant_organisme']),
        'remise_facture' => clean_data($_POST['remise_facture']),
        'montant_net' => clean_data($_POST['montant_net']),
        'mode_paiement' => clean_data($_POST['mode_paiement']),
        'montant_recu' => clean_data($_POST['montant_recu']),
        'monnaie_rendue' => (int)(str_replace(' ', '', clean_data($_POST['monnaie_rendue'])))
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
                                if (in_array('AFF_PHCIE', $modules, true) && in_array('EDT_PHCIE_VNTS', $sous_modules, true)) {
                                    $nb_produits = count($_POST['code_produit']);
                                    $nb_produits_enregistres = 0;
                                    if ($nb_produits !== 0) {
                                        $edition = $ETABLISSEMENTS->editer_vente($ets['code'], null, null, $parametres['montant_brut'], $parametres['montant_rgb'], $parametres['taux_organisme'], $parametres['remise_facture'], $parametres['montant_net'], $parametres['mode_paiement'], $parametres['montant_recu'], $parametres['monnaie_rendue'], $user['id_user']);
                                        if ($edition['success'] === true) {
                                            for ($i = 0; $i < $nb_produits; $i++) {
                                                $code_produit = $_POST['code_produit'][$i];
                                                $prix_unitaire = $_POST['prix_unitaire'][$i];
                                                $quantite = $_POST['quantite'][$i];
                                                $taux_rgb_produit = $_POST['taux_rgb_produit'][$i];
                                                $taux_organisme_produit = $_POST['taux_organisme_produit'][$i];
                                                $taux_remise_produit = $_POST['taux_remise_produit'][$i];

                                                $produit = $ETABLISSEMENTS->editer_vente_produits($ets['code'], $edition['code'], $code_produit, $prix_unitaire, $quantite, $taux_rgb_produit, $taux_organisme_produit, $taux_remise_produit, $user['id_user']);
                                                if ($produit['success'] === true) {
                                                    $nb_produits_enregistres++;
                                                }
                                            }
                                            if ($nb_produits_enregistres == $nb_produits) {
                                                $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, 'EDITION PHARMACIE VENTE', json_encode($parametres));
                                                if ($audit['success'] === true) {
                                                    $json = array(
                                                        'success' => true,
                                                        'code' => $edition['code'],
                                                        'message' => $edition['message']
                                                    );
                                                } else {
                                                    $json = $audit;
                                                }
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
