<?php
header('Content-Type: application/json');
require_once '../../../Functions/Functions.php';
require_once '../../../Classes/UTILISATEURS.php';

if (isset($_SESSION['nouvelle_session'])) {
    $UTILISATEURS = new UTILISATEURS();
    $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
    if ($session) {
        $utilisateur = $UTILISATEURS->trouver($session['id_user'], null);
        if ($utilisateur) {
            require_once '../../../Classes/ETABLISSEMENTS.php';
            $ETABLISSEMENTS = new ETABLISSEMENTS();
            $profil = $UTILISATEURS->trouver_profil($utilisateur['id_user']);
            if ($profil) {
                $user_profil = $UTILISATEURS->trouver_utilisateur_ets($utilisateur['id_user']);
                if ($user_profil) {
                    $ets = $ETABLISSEMENTS->trouver($user_profil['code_etablissement'], null);
                    if ($ets) {
                        if (isset($_POST['nip'])) {
                            $parametres = array(
                                'nip' => clean_data($_POST['nip'])
                            );
                            $patient = $ETABLISSEMENTS->trouver_patient($ets['code'], $parametres['nip']);
                            if ($patient) {
                                $json = array(
                                    'success' => true,
                                    'num_population' => $patient['num_population'],
                                    'num_rgb' => $patient['num_rgb'],
                                    'nom_prenom' => $patient['nom'].' '.$patient['prenom']
                                );
                            } else {
                                $json = array(
                                    'success' => false,
                                    'message' => "Aucun patient ne correspond à votre recherche."
                                );
                            }
                        } elseif (isset($_GET['nom_prenom'])) {
                            $parametres = array(
                                'nom_prenom' => clean_data($_GET['nom_prenom'])
                            );
                            $patients = $ETABLISSEMENTS->moteur_recherche_patient($ets['code'], null, null, null, $parametres['nom_prenom']);
                            foreach ($patients as $patient) {
                                $json[] = array(
                                    'success' => true,
                                    'value' => $patient['num_population'],
                                    'num_rgb' => $patient['num_rgb'],
                                    'label' => $patient['nom'].' '.$patient['prenom']
                                );
                            }
                            flush();
                        }
                    }
                }
            }
        }
    }
}
echo json_encode($json);
