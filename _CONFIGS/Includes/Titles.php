<?php
if (ACTIVE_URL == URL) {
    define('TITLE', 'Ouagolo');
}
elseif (ACTIVE_URL == URL . 'connexion') {
    define('TITLE', ' Connexion Ouagolo');
}
elseif (ACTIVE_URL == URL . 'profil') {
    $UTILISATEURS = new UTILISATEURS();
    if (isset($_SESSION['nouvelle_session'])) {
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        $user = $UTILISATEURS->trouver($session['id_user'], null);
    }
    define('TITLE', $user['prenoms']);
}
elseif (ACTIVE_URL == URL . 'mot-de-passe') {
    define('TITLE', 'MAJ du mot de passe');
}
elseif (ACTIVE_URL == URL . 'page-introuvable') {
    define('TITLE', 'Page introuvable');
}

/**
 * Début Administration
 */
elseif (ACTIVE_URL == URL . 'etablissements/') {
    define('TITLE', 'Etablissements');
}
elseif ((isset($_GET['code']) && ACTIVE_URL == URL . 'etablissements/?code=' . $_GET['code'])) {
    require_once '../_CONFIGS/Classes/ETABLISSEMENTS.php';
    $ETABLISSEMENTS = new ETABLISSEMENTS();
    $ets = $ETABLISSEMENTS->trouver($_GET['code'], null);
    define('TITLE', $ets['raison_sociale']);
}

elseif (ACTIVE_URL == URL . 'organismes/') {
    define('TITLE', 'Organismes');
}
elseif (isset($_GET['code']) && ACTIVE_URL == URL . 'organismes/?code='.$_GET['code']) {
    require_once '../_CONFIGS/Classes/ORGANISMES.php';
    $ORGANISMES = new ORGANISMES();
    $organisme = $ORGANISMES->trouver($_GET['code']);
    define('TITLE', $organisme['libelle']);
}
elseif (ACTIVE_URL == URL . 'organismes/baremes') {
    define('TITLE', 'Barèmes');
}
elseif (isset($_GET['code']) && ACTIVE_URL == URL . 'organismes/baremes?code='.$_GET['code']) {
    define('TITLE', 'Test');
}
elseif (isset($_GET['code-organisme']) && ACTIVE_URL == URL . 'organismes/utilisateurs?code-organisme='.$_GET['code-organisme']) {
    define('TITLE', 'Utilisateurs');
}

elseif (ACTIVE_URL == URL . 'factures/') {
    define('TITLE', 'Factures');
}
elseif (ACTIVE_URL == URL . 'comptabilite/') {
    define('TITLE', 'Comptabilité');
}
elseif (ACTIVE_URL == URL . 'support/') {
    define('TITLE', 'Support');
}
elseif (ACTIVE_URL == URL . 'dashboard/') {
    define('TITLE', 'Dashboard');
}

elseif (ACTIVE_URL == URL . 'parametres/') {
    define('TITLE', 'Paramètres');
}
elseif (ACTIVE_URL == URL . 'parametres/reseaux-de-soins/') {
    define('TITLE', 'Paramètres réseaux de soins');
}
elseif (isset($_GET['code']) && ACTIVE_URL == URL . 'parametres/reseaux-de-soins/?code=' . $_GET['code']) {
    require_once '../../_CONFIGS/Classes/RESEAUXDESOINS.php';
    $RESEAUXDESOINS = new RESEAUXDESOINS();
    $reseau = $RESEAUXDESOINS->trouver(null, $_GET['code']);
    define('TITLE', 'Réseau ' . ucfirst(strtolower($reseau['libelle'])));
}
elseif (isset($_GET['code']) && ACTIVE_URL == URL . 'parametres/reseaux-de-soins/etablissements?code=' . $_GET['code']) {
    require_once '../../_CONFIGS/Classes/RESEAUXDESOINS.php';
    $RESEAUXDESOINS = new RESEAUXDESOINS();
    $reseau = $RESEAUXDESOINS->trouver(null, $_GET['code']);
    define('TITLE', ucfirst(strtolower($reseau['libelle'])) . ' établissements');
}
elseif (isset($_GET['code']) && ACTIVE_URL == URL . 'parametres/reseaux-de-soins/actes-medicaux?code=' . $_GET['code']) {
    require_once '../../_CONFIGS/Classes/RESEAUXDESOINS.php';
    $RESEAUXDESOINS = new RESEAUXDESOINS();
    $reseau = $RESEAUXDESOINS->trouver(null, $_GET['code']);
    define('TITLE', ucfirst(strtolower($reseau['libelle'])) . ' actes médicaux');
}
elseif (isset($_GET['code']) && ACTIVE_URL == URL . 'parametres/reseaux-de-soins/medicaments?code=' . $_GET['code']) {
    require_once '../../_CONFIGS/Classes/RESEAUXDESOINS.php';
    $RESEAUXDESOINS = new RESEAUXDESOINS();
    $reseau = $RESEAUXDESOINS->trouver(null, $_GET['code']);
    define('TITLE', ucfirst(strtolower($reseau['libelle'])) . ' medicaments');
}
elseif (ACTIVE_URL == URL . 'parametres/etablissements/') {
    define('TITLE', 'Paramètres établissements');
}
elseif (ACTIVE_URL == URL . 'parametres/utilisateurs/') {
    define('TITLE', 'Paramètres utilisateurs');
}
elseif ((isset($_GET['uid']) && ACTIVE_URL == URL . 'parametres/utilisateurs/?uid=' . $_GET['uid'])) {
    $UTILISATEURS = new UTILISATEURS();
    $user = $UTILISATEURS->trouver($_GET['uid'], null);
    define('TITLE', $user['nom'] . ' ' . $user['prenoms']);
}
elseif (ACTIVE_URL == URL . 'parametres/support/') {
    define('TITLE', 'Paramètres Support');
}
elseif (ACTIVE_URL == URL . 'parametres/referentiels/') {
    define('TITLE', 'Paramètres Référentiels');
}
elseif (ACTIVE_URL == URL . 'parametres/referentiels/pathologies') {
    define('TITLE', 'Param. ref Pathologies');
}
elseif (ACTIVE_URL == URL . 'parametres/referentiels/actes-medicaux') {
    define('TITLE', 'Param. ref Actes médicaux');
}
elseif (ACTIVE_URL == URL . 'parametres/referentiels/medicaments') {
    define('TITLE', 'Param. ref Médicaments');
}
elseif (isset($_GET['code']) && ACTIVE_URL == URL . 'parametres/referentiels/medicaments?code=' . $_GET['code']) {
    require_once '../../_CONFIGS/Classes/MEDICAMENTS.php';
    $MEDICAMENTS = new MEDICAMENTS();
    $medicament = $MEDICAMENTS->trouver($_GET['code']);
    define('TITLE', ucfirst(strtolower($medicament['libelle'])) . ' actes médicaux');
}
elseif (ACTIVE_URL == URL . 'parametres/referentiels/collectivites') {
    define('TITLE', 'Param. ref Collectivités');
}
elseif (ACTIVE_URL == URL . 'parametres/tables-de-valeurs') {
    define('TITLE', 'Tables de valeurs');
}
elseif (ACTIVE_URL == URL . 'parametres/securite/') {
    define('TITLE', 'Sécurité');
}
elseif (ACTIVE_URL == URL . 'parametres/securite/compte') {
    define('TITLE', 'Sécurité du compte');
}
elseif (ACTIVE_URL == URL . 'parametres/securite/mot-de-passe') {
    define('TITLE', 'Sécurité du mot de passe');
}
/**
 * Fin Administration
 */

/**
 * Début Organisme
 */

elseif (ACTIVE_URL == URL . 'organisme/') {
    require_once '../_CONFIGS/Classes/ORGANISMES.php';
    $UTILISATEURS = new UTILISATEURS();
    $ORGANISMES = new ORGANISMES();
    if (isset($_SESSION['nouvelle_session'])) {
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        $user = $UTILISATEURS->trouver($session['id_user'], null);
        $user_profil = $UTILISATEURS->trouver_utilisateur_organisme($user['id_user']);
        if($user_profil) {
            $organisme = $ORGANISMES->trouver($user_profil['code_organisme']);
            define('TITLE', $organisme['libelle']);
        }
    } else {
        echo '<script>window.location.href="'.URL.'connexion"</script>';
    }
}
elseif (ACTIVE_URL == URL . 'organisme/polices/') {
    define('TITLE', 'Polices');
}
elseif (isset($_GET['id']) && ACTIVE_URL == URL . 'organisme/polices/?id='.$_GET['id']) {
    define('TITLE', 'Police n° '.$_GET['id']);
}
elseif (ACTIVE_URL == URL . 'organisme/colleges/') {
    define('TITLE', 'Collège');
}
elseif (isset($_GET['id-police']) && isset($_GET['code']) && ACTIVE_URL == URL . 'organisme/colleges/?id-police='.$_GET['id-police'].'&code='.$_GET['code']) {
    define('TITLE', 'Collège n° '.$_GET['code']);
}
elseif (ACTIVE_URL == URL . 'organisme/assures/') {
    define('TITLE', 'Assurés');
}
elseif (isset($_GET['num']) && ACTIVE_URL == URL . 'organisme/assures/?num='.$_GET['num']) {
    define('TITLE', 'Assuré n° '.$_GET['num']);
}
elseif (ACTIVE_URL == URL . 'organisme/prestations/') {
    define('TITLE', 'Prestatons');
}
elseif (ACTIVE_URL == URL . 'organisme/prestations/factures') {
    define('TITLE', 'Factures');
}
elseif (isset($_GET['r']) && ACTIVE_URL == URL . 'organisme/prestations/factures?r='.$_GET['r']) {
    define('TITLE', strtoupper($_GET['r']));
}
elseif (isset($_GET['r']) && isset($_GET['num']) && ACTIVE_URL == URL . 'organisme/prestations/factures?r='.$_GET['r'].'&num='.$_GET['num']) {
    define('TITLE', 'Facture n° '.$_GET['num']);
}
elseif (ACTIVE_URL == URL . 'organisme/prestations/demandes') {
    define('TITLE', 'Demandes');
}
elseif (ACTIVE_URL == URL . 'organisme/parametres/produits') {
    define('TITLE', 'Produits');
}
elseif (isset($_GET['code']) && ACTIVE_URL == URL . 'organisme/parametres/produits?code='.$_GET['code']) {
    require_once '../../_CONFIGS/Classes/PRODUITS.php';
    require_once '../../_CONFIGS/Classes/ORGANISMES.php';
    $PRODUITS = new \App\PRODUITS();
    $UTILISATEURS = new UTILISATEURS();
    $ORGANISMES = new ORGANISMES();
    if (isset($_SESSION['nouvelle_session'])) {
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        $user = $UTILISATEURS->trouver($session['id_user'], null);
        $user_profil = $UTILISATEURS->trouver_utilisateur_organisme($user['id_user']);
        $organisme = $ORGANISMES->trouver($user_profil['code_organisme']);
        $produit = $PRODUITS->trouver($organisme['code'], $_GET['code']);
        define('TITLE', $produit['libelle']);
    } else {
        echo '<script>window.location.href="'.URL.'organisme/parametres/produits"</script>';
    }
}
elseif (ACTIVE_URL == URL . 'organisme/parametres/reseaux-de-soins') {
    define('TITLE', 'Réseaux de soins');
}
elseif (isset($_GET['code']) && ACTIVE_URL == URL . 'organisme/parametres/reseaux-de-soins?code='.$_GET['code']) {
    require_once '../../_CONFIGS/Classes/RESEAUXDESOINS.php';
    require_once '../../_CONFIGS/Classes/ORGANISMES.php';
    $RESEAUXDESOINS = new RESEAUXDESOINS();
    $UTILISATEURS = new UTILISATEURS();
    $ORGANISMES = new ORGANISMES();
    if (isset($_SESSION['nouvelle_session'])) {
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        $user = $UTILISATEURS->trouver($session['id_user'], null);
        $user_profil = $UTILISATEURS->trouver_utilisateur_organisme($user['id_user']);
        $organisme = $ORGANISMES->trouver($user_profil['code_organisme']);
        $reseau = $RESEAUXDESOINS->trouver($organisme['code'], $_GET['code']);
        define('TITLE', $reseau['libelle']);
    } else {
        echo '<script>window.location.href="'.URL.'organisme/parametres/reseaux-de-soins"</script>';
    }
}
elseif (ACTIVE_URL == URL . 'organisme/parametres/paniers-de-soins') {
    define('TITLE', 'Paniers de soins');
}
elseif (isset($_GET['code']) && ACTIVE_URL == URL . 'organisme/parametres/paniers-de-soins?code='.$_GET['code']) {
    require_once '../../_CONFIGS/Classes/PANIERSDESOINS.php';
    require_once '../../_CONFIGS/Classes/ORGANISMES.php';
    $PANIERSDESOINS = new PANIERSDESOINS();
    $UTILISATEURS = new UTILISATEURS();
    $ORGANISMES = new ORGANISMES();
    if (isset($_SESSION['nouvelle_session'])) {
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        $user = $UTILISATEURS->trouver($session['id_user'], null);
        $user_profil = $UTILISATEURS->trouver_utilisateur_organisme($user['id_user']);
        $organisme = $ORGANISMES->trouver($user_profil['code_organisme']);
        $reseau = $PANIERSDESOINS->trouver($organisme['code'], $_GET['code']);
        define('TITLE', $reseau['libelle']);
    } else {
        echo '<script>window.location.href="'.URL.'organisme/parametres/paniers-de-soins"</script>';
    }
}
elseif (ACTIVE_URL == URL . 'organisme/remboursements/') {
    define('TITLE', 'Remboursements');
}
elseif (ACTIVE_URL == URL . 'organisme/dashboard/') {
    define('TITLE', 'Dashboard');
}
elseif (ACTIVE_URL == URL . 'organisme/support/') {
    define('TITLE', 'Support');
}
elseif (ACTIVE_URL == URL . 'organisme/parametres/') {
    define('TITLE', 'Paramètres');
}
elseif (ACTIVE_URL == URL . 'organisme/parametres/utilisateurs') {
    define('TITLE', 'Utilisateurs');
}
elseif (isset($_GET['uid']) && ACTIVE_URL == URL . 'organisme/parametres/utilisateurs?uid='.$_GET['uid']) {
    require_once '../../_CONFIGS/Classes/UTILISATEURS.php';
    $UTILISATEURS = new UTILISATEURS();
    $utilisateur = $UTILISATEURS->trouver($_GET['uid'], null);
    define('TITLE', $utilisateur['nom'].' '.$utilisateur['prenoms']);
}
/**
 * Fin Organisme
 */

/**
 * Début Etablissement
 */

elseif (ACTIVE_URL == URL . 'etablissement/') {
    define('TITLE', 'Etablissement');
}

elseif (ACTIVE_URL == URL . 'etablissement/fournisseurs') {
    define('TITLE', 'Fournisseurs');
}
elseif (isset($_GET['code']) && ACTIVE_URL == URL . 'etablissement/fournisseurs?code='.$_GET['code']) {
    define('TITLE', 'Fournisseur n° '.strtoupper($_GET['code']));
}

elseif (ACTIVE_URL == URL . 'etablissement/patients/') {
    define('TITLE', 'Patients');
}
elseif (isset($_GET['nip']) && ACTIVE_URL == URL . 'etablissement/patients/?nip='.$_GET['nip']) {
    require_once '../../_CONFIGS/Classes/POPULATIONS.php';
    $POPULATIONS = new POPULATIONS();
    $patient = $POPULATIONS->trouver($_GET['nip'], null);
    define('TITLE', $patient['nom'].' '.$patient['prenoms']);
}

elseif (ACTIVE_URL == URL . 'etablissement/dossiers/') {
    define('TITLE', 'Dossiers');
}
elseif ((isset($_GET['num'])) && ACTIVE_URL == URL . 'etablissement/dossiers/?num=' . $_GET['num']) {
    define('TITLE', 'Dossier n° '.$_GET['num']);
}

elseif (ACTIVE_URL == URL . 'etablissement/pharmacie/') {
    define('TITLE', 'Pharmacie');
}

elseif (ACTIVE_URL == URL . 'etablissement/pharmacie/ventes') {
    define('TITLE', 'Ventes');
}

elseif (ACTIVE_URL == URL . 'etablissement/pharmacie/stock') {
    define('TITLE', 'Stock');
}

elseif (ACTIVE_URL == URL . 'etablissement/pharmacie/produits') {
    define('TITLE', 'Produits');
}
elseif (isset($_GET['code']) && ACTIVE_URL == URL . 'etablissement/pharmacie/produits?code='.$_GET['code']) {
    define('TITLE', 'Produit n° '.$_GET['code']);
}

elseif (ACTIVE_URL == URL . 'etablissement/pharmacie/commandes') {
    define('TITLE', 'Commandes');
}
elseif (isset($_GET['num']) && ACTIVE_URL == URL . 'etablissement/pharmacie/commandes?num='.$_GET['num']) {
    define('TITLE', 'Commande n° '.$_GET['num']);
}

elseif (ACTIVE_URL == URL . 'etablissement/factures/') {
    define('TITLE', 'Factures');
}
elseif (ACTIVE_URL == URL . 'etablissement/factures/bordereaux') {
    define('TITLE', 'Bordereaux');
}
elseif ((isset($_GET['num'])) && ACTIVE_URL == URL . 'etablissement/factures/bordereaux?num=' . $_GET['num']) {
    define('TITLE', 'Bordereau n° '.$_GET['num']);
}
elseif (isset($_GET['nip']) && ACTIVE_URL == URL . 'etablissement/factures/edition?nip='.$_GET['nip']) {
    define('TITLE', 'Nouvelle facture');
}
elseif ((isset($_GET['num'])) && ACTIVE_URL == URL . 'etablissement/factures/?num=' . $_GET['num']) {
    define('TITLE', 'Facture n° '.$_GET['num']);
}

elseif (ACTIVE_URL == URL . 'etablissement/comptabilite/') {
    define('TITLE', 'Comptabilité');
}

elseif (ACTIVE_URL == URL . 'etablissement/services/') {
    define('TITLE', 'Services');
}

elseif (ACTIVE_URL == URL . 'etablissement/professionnels-de-sante/') {
    define('TITLE', 'Professionnels de santé');
}
elseif (isset($_GET['code']) && ACTIVE_URL == URL . 'etablissement/professionnels-de-sante/?code='.$_GET['code']) {
    require_once '../../_CONFIGS/Classes/PROFESSIONNELSDESANTE.php';
    $PROFESSIONNELSDESANTE = new PROFESSIONNELSDESANTE();
    $professionnel = $PROFESSIONNELSDESANTE->trouver(strtoupper($_GET['code']), null);
    define('TITLE', $professionnel['nom'].' '.$professionnel['prenom']);
}

elseif (ACTIVE_URL == URL . 'etablissement/rendez-vous/') {
    define('TITLE', 'Rendez-vous du jour');
}
elseif (isset($_GET['a']) && isset($_GET['m']) && ACTIVE_URL == URL . 'etablissement/rendez-vous/?a='.$_GET['a'].'&m='.$_GET['m']) {
    define('TITLE', 'Rendez-vous du '.$_GET['m'].'/'.$_GET['a']);
}

elseif (ACTIVE_URL == URL . 'etablissement/laboratoire/') {
    define('TITLE', 'Laboratoire');
}

elseif (ACTIVE_URL == URL . 'etablissement/support/') {
    define('TITLE', 'Support');
}

elseif (ACTIVE_URL == URL . 'etablissement/dashboard/') {
    define('TITLE', 'Dashboard');
}

elseif (ACTIVE_URL == URL . 'etablissement/a-propos/') {
    define('TITLE', 'A propos');
}

elseif (ACTIVE_URL == URL . 'etablissement/parametres/') {
    define('TITLE', 'Paramètres');
}
elseif (ACTIVE_URL == URL . 'etablissement/parametres/panier-de-soins') {
    define('TITLE', 'Panier de soins');
}
elseif (ACTIVE_URL == URL . 'etablissement/parametres/profils-utilisateurs') {
    define('TITLE', 'Profils utilisateurs');
}
elseif (isset($_GET['pid']) && ACTIVE_URL == URL . 'etablissement/parametres/profils-utilisateurs?pid='.$_GET['pid']) {
    define('TITLE', 'Profil');
}
elseif (ACTIVE_URL == URL . 'etablissement/parametres/utilisateurs') {
    define('TITLE', 'Utilisateurs');
}
elseif (isset($_GET['uid']) && ACTIVE_URL == URL . 'etablissement/parametres/utilisateurs?uid='.$_GET['uid']) {
    require_once '../../_CONFIGS/Classes/UTILISATEURS.php';
    $UTILISATEURS = new UTILISATEURS();
    $utilisateur = $UTILISATEURS->trouver($_GET['uid'], null);
    define('TITLE', $utilisateur['nom'].' '.$utilisateur['prenoms']);
}
elseif (ACTIVE_URL == URL . 'etablissement/parametres/chambres') {
    define('TITLE', 'Chambres');
}
elseif (isset($_GET['code']) && ACTIVE_URL == URL . 'etablissement/parametres/chambres?code='.$_GET['code']) {
    define('TITLE', 'Chambre '.$_GET['code']);
}
/**
 * Fin Etablissement
 */

else {
    echo '<script>window.location.href="'.URL.'page-introuvable"</script>';
}
