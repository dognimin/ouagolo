<?php
require_once '../../../../Classes/UTILISATEURS.php';
$UTILISATEURS = new UTILISATEURS();
$session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
if($session) {
    $date_debut = new DateTime($session['date_derniere_edition']);
    $date_fin = new DateTime(date('Y-m-d H:i:s',time()));

    $periode = $date_debut->diff($date_fin);
    $annees = $periode->y;
    $mois = $periode->m;
    $jours = $periode->d;
    $heures = $periode->h;
    $minutes = $periode->i;
    $secondes = $periode->s;
    if($annees > 0) {
        $statut = 1;
    }
    else {
        if($mois > 0) {
            $statut = 1;
        }
        else {
            if($jours > 0) {
                $statut = 1;
            }
            else {
                if($heures > 0) {
                    $statut = 1;
                }
                else {
                    if($minutes >= 15) {
                        $statut = 1;
                    }
                    else {
                        $statut = 0;
                    }
                }
            }
        }
    }
    if($statut == 1) {
        $utilisateur = $UTILISATEURS->trouver($session['id_user'], null);
        if($utilisateur) {
            $edition = $UTILISATEURS->editer_session(null, $session['code_session'], null, null, null, null, null, null);
            if($edition['success'] == true) {
                $audit = $UTILISATEURS->editer_piste_audit($session['code_session'],ACTIVE_URL,'DECONNEXION',null);
                if($audit['success'] == true) {
                    session_unset();
                    session_destroy();
                    $json = array(
                        'success' => true
                    );
                }else {
                    $json = array(
                        'success' => false
                    );
                }
            }else {
                $json = array(
                    'success' => false
                );
            }
        }else {
            $json = array(
                'success' => false
            );
        }
    }else {
        $json = array(
            'success' => false,
            'message' => "Cet utilisateur ne peut être deconnecté par le système."
        );
    }
}else {
    $json = array(
        'success' => false,
        'message' => "Aucune session active pour vérifier cette action."
    );
}
echo json_encode($json);
