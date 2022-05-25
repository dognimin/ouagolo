<?php
header('Content-Type: application/json');
require_once '../../../Functions/Functions.php';
require_once '../../../Classes/UTILISATEURS.php';
require_once '../../../Classes/ACTESMEDICAUX.php';
$ACTESMEDICAUX = new ACTESMEDICAUX();

if(isset($_POST['code'])) {
    $parametres = array(
        'code' => clean_data($_POST['code'])
    );
    $acte = $ACTESMEDICAUX->trouver_acte_medical($parametres['code']);
    if($acte) {
        $json = array(
            'success' => true,
            'code' => $acte['code'],
            'libelle' => $acte['libelle'],
            'tarif' => $acte['tarif'],
            'date_debut' => date('d/m/Y',time())
        );
    }else {
        $json = array(
            'success' => false,
            'message' => "Aucune collectivité ne correspond à votre recherche."
        );
    }
}elseif (isset($_GET['libelle'])) {
    $parametres = array(
        'libelle' => clean_data($_GET['libelle'])
    );
    $actes = $ACTESMEDICAUX->lister_actes_medicaux(strtoupper(conversion_caracteres_speciaux($parametres['libelle'])));
    $json = array();
    foreach ($actes as $acte) {
        $json[] = array(
            'success' => true,
            'value' => $acte['libelle'],
            'label' => $acte['libelle'],
            'code' => $acte['code'],
            'tarif' => $acte['tarif'],
            'date_debut' => date('d/m/Y',time())
        );
    }
    flush();
}
echo json_encode($json);