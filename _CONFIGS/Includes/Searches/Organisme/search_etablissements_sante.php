<?php
header('Content-Type: application/json');
require_once '../../../Functions/Functions.php';
require_once '../../../Classes/UTILISATEURS.php';
require_once '../../../Classes/ETABLISSEMENTS.php';
$ETABLISSEMENTS = new ETABLISSEMENTS();

if(isset($_POST['code'])) {
    $parametres = array(
        'code' => clean_data($_POST['code'])
    );
    $etablissement = $ETABLISSEMENTS->trouver($parametres['code'],null);
    if($etablissement) {
        $json = array(
            'success' => true,
            'code' => $etablissement['code'],
            'raison_sociale' => $etablissement['raison_sociale'],
            'date_debut' => date('d/m/Y',time())
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
    $etablissements = $ETABLISSEMENTS->lister(null, strtoupper(conversion_caracteres_speciaux($parametres['raison_sociale'])));
    $json = array();
    foreach ($etablissements as $etablissement) {
        $json[] = array(
            'success' => true,
            'value' => $etablissement['raison_sociale'],
            'label' => $etablissement['raison_sociale'],
            'code' => $etablissement['code'],
            'date_debut' => date('d/m/Y',time())
        );
    }
    flush();
}
echo json_encode($json);