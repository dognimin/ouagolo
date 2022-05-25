<?php
if (isset($_POST)) {
    require_once "../../../../Classes/UTILISATEURS.php";
    require_once "../../../../Functions/Functions.php";
    if (isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if ($session) {
            $utilisateur = $UTILISATEURS->trouver($session['id_user'], null);
            if ($utilisateur) {
                require_once "../../../../Classes/ETABLISSEMENTS.php";
                $ETABLISSEMENTS = new ETABLISSEMENTS();
                $profil = $UTILISATEURS->trouver_profil($utilisateur['id_user']);
                if ($profil) {
                    $user_profil = $UTILISATEURS->trouver_utilisateur_ets($utilisateur['id_user']);
                    if ($user_profil) {
                        $ets = $ETABLISSEMENTS->trouver($user_profil['code_etablissement'], null);
                        if ($ets) {
                            if (isset($_GET['libelle'])) {
                                $parametres = array(
                                    'libelle' => strtoupper(conversion_caracteres_speciaux(clean_data($_GET['libelle'])))
                                );
                                $produits = $ETABLISSEMENTS->lister_produits_a_commander($ets['code'], null, $parametres['libelle']);
                                foreach ($produits as $produit) {
                                    $tarif = $ETABLISSEMENTS->trouver_produit_tarif($ets['code'], $produit['code_produit']);

                                    $stock = $ETABLISSEMENTS->trouver_produit_stock_quantite($ets['code'], $produit['code_produit']);
                                    if (!$stock) {
                                        $stock = array(
                                            'code' => $produit['code_produit'],
                                            'quantite_restante' => 0
                                        );
                                    }
                                    if (!$tarif) {
                                        $tarif = array(
                                            'prix_vente' => 0
                                        );
                                    }
                                    $json[] = array(
                                        'success' => true,
                                        'value' => $produit['code_produit'],
                                        'label' => $produit['libelle'],
                                        'quantite_stock' => $stock['quantite_restante'],
                                        'prix_unitaire' => $tarif['prix_achat'],
                                        'quantite' => 1,
                                        'remise' => 0,
                                        'montant_ht' => $tarif['prix_achat']
                                    );
                                }
                            } else {
                                $json = null;
                            }
                        } else {
                            $json = array(
                                'success' => false,
                                'message' => "Aucun établissement correspondant à votre profil n'a été identifié, veuillez SVP contacter votre administrateur."
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
}
echo json_encode($json);
