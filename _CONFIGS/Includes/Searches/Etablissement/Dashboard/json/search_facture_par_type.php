<?php
if(isset($_POST)) {
    require_once "../../../../../Classes/UTILISATEURS.php";
    require_once "../../../../../Functions/Functions.php";
    $parametres = array(
        'date_debut' => date('Y-m-d 00:00:00', strtotime(str_replace('/', '-', clean_data($_POST['date_debut'])))),
        'date_fin' => date('Y-m-d 23:59:59', strtotime(str_replace('/', '-', clean_data($_POST['date_fin']))))
    );
    if (isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if ($session) {
            $utilisateur = $UTILISATEURS->trouver($session['id_user'], null);
            if ($utilisateur) {
                require_once "../../../../../Classes/ETABLISSEMENTS.php";
                require_once "../../../../../Classes/DASHBOARD.php";
                $ETABLISSEMENTS = new ETABLISSEMENTS();
                $DASHBOARD = new DASHBOARD();
                $profil = $UTILISATEURS->trouver_profil($utilisateur['id_user']);
                if ($profil) {
                    $user_profil = $ETABLISSEMENTS->trouver_utilisateur($utilisateur['id_user']);
                    if ($user_profil) {
                        $ets = $ETABLISSEMENTS->trouver($user_profil['code_etablissement'], null);
                        if ($ets) {
                            $factures = $DASHBOARD->etablissement_nombre_factures_par_type($ets['code'], $parametres['date_debut'], $parametres['date_fin']);
                            foreach ($factures as $facture) {
                                $json[] = array(
                                    'code' => $facture['code'],
                                    'libelle' => $facture['libelle'],
                                    'effectif' => $facture['effectif'],
                                    'couleur' => '#'.random_int(100000, 999999)
                                );
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
echo json_encode($json, JSON_THROW_ON_ERROR);
