<?php
header('Content-Type: application/json');
require_once '../../../Functions/Functions.php';
require_once '../../../Classes/UTILISATEURS.php';
require_once '../../../Classes/PATHOLOGIES.php';
$PATHOLOGIES = new PATHOLOGIES();

if(isset($_POST['code'])) {
    $parametres = array(
        'code' => clean_data($_POST['code'])
    );
    $pathologie = $PATHOLOGIES->trouver_pathologie($parametres['code']);
    if($pathologie) {
        $json = array(
            'success' => true,
            'code' => $pathologie['code'],
            'libelle' => $pathologie['libelle'],
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
    $pathologies = $PATHOLOGIES->lister_pathologies(null, strtoupper(conversion_caracteres_speciaux($parametres['libelle'])));
    $json = array();
    foreach ($pathologies as $pathologie) {
        $json[] = array(
            'success' => true,
            'value' => $pathologie['libelle'],
            'label' => $pathologie['libelle'],
            'code' => $pathologie['code'],
            'date_debut' => date('d/m/Y',time())
        );
    }
    flush();
}
echo json_encode($json);