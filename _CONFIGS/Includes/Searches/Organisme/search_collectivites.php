<?php
header('Content-Type: application/json');
require_once '../../../Functions/Functions.php';
require_once '../../../Classes/UTILISATEURS.php';
require_once '../../../Classes/COLLECTIVITES.php';
$COLLECTIVITES = new COLLECTIVITES();

if(isset($_POST['code'])) {
    $parametres = array(
        'code' => clean_data($_POST['code'])
    );
    $collectivite = $COLLECTIVITES->trouver($parametres['code']);
    if($collectivite) {
        $json = array(
            'success' => true,
            'code' => $collectivite['code'],
            'raison_sociale' => $collectivite['raison_sociale']
        );
    }else {
        $json = array(
            'success' => false,
            'message' => "Aucune collectivité ne correspond à votre recherche."
        );
    }
}elseif (isset($_GET['raison_sociale'])) {
    $parametres = array(
        'raison_sociale' => clean_data($_GET['raison_sociale'])
    );
    $collectivites = $COLLECTIVITES->lister(null, strtoupper(conversion_caracteres_speciaux($parametres['raison_sociale'])));
    foreach ($collectivites as $collectivite) {
        $json[] = array(
            'success' => true,
            'value' => $collectivite['code'],
            'label' => $collectivite['raison_sociale']
        );
    }
    flush();
}
echo json_encode($json);