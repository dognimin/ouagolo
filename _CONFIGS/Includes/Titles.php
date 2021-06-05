<?php
if(ACTIVE_URL == URL) {
    define('TITLE', 'Ouagolo');
}elseif (ACTIVE_URL == URL.'connexion') {
    define('TITLE', ' Connexion Ouagolo');
}elseif (ACTIVE_URL == URL.'mot-de-passe') {
    define('TITLE', 'MAJ du mot de passe');
}elseif (ACTIVE_URL == URL.'parametres/') {
    define('TITLE', 'Paramètres');
}elseif (ACTIVE_URL == URL.'parametres/etablissements/') {
    define('TITLE', 'Paramètres établissements');
}elseif ((isset($_GET['code']) && ACTIVE_URL == URL.'parametres/etablissements/details?code='.$_GET['code'])) {
    require_once '../../_CONFIGS/Classes/ETABLISSEMENTS.php';
    $ETABLISSEMENTS = new ETABLISSEMENTS();
    $ets = $ETABLISSEMENTS->trouver_etablissement($_GET['code']);
    define('TITLE', $ets['raison_sociale']);
}elseif (ACTIVE_URL == URL.'parametres/utilisateurs/') {
    define('TITLE', 'Paramètres utilisateurs');
}elseif ((isset($_GET['uid']) && ACTIVE_URL == URL.'parametres/utilisateurs/details?uid='.$_GET['uid'])) {
    $UTILISATEURS = new UTILISATEURS();
    $user = $UTILISATEURS->trouver($_GET['uid'],null,null);
    define('TITLE', $user['nom'].' '.$user['prenoms']);
}elseif (ACTIVE_URL == URL.'parametres/referentiels/') {
    define('TITLE', 'Paramètres Référentiels');
}elseif (ACTIVE_URL == URL.'parametres/referentiels/pathologies') {
    define('TITLE', 'Param. ref Pathologies');
}elseif (ACTIVE_URL == URL.'parametres/referentiels/actes-medicaux') {
    define('TITLE', 'Param. ref Actes médicaux');
}elseif (ACTIVE_URL == URL.'parametres/referentiels/medicaments') {
    define('TITLE', 'Param. ref Médicaments');
}elseif (ACTIVE_URL == URL.'parametres/tables-de-valeurs') {
    define('TITLE', 'Tables de valeurs');
}elseif (ACTIVE_URL == URL.'parametres/securite/') {
    define('TITLE', 'Sécurité');
}elseif (ACTIVE_URL == URL.'parametres/securite/compte') {
    define('TITLE', 'Sécurité du compte');
}elseif (ACTIVE_URL == URL.'parametres/securite/mot-de-passe') {
    define('TITLE', 'Sécurité du mot de passe');
}