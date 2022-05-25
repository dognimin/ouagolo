<?php
header('Content-Type: application/json');
require_once '../../../Functions/Functions.php';
require_once '../../../Classes/UTILISATEURS.php';
require_once '../../../Classes/MEDICAMENTS.php';
$MEDICAMENTS = new MEDICAMENTS();

if(isset($_POST['code'])) {
    $parametres = array(
        'code' => clean_data($_POST['code'])
    );
    $medicament = $MEDICAMENTS->trouver($parametres['code']);
    if($medicament) {
        $json = array(
            'success' => true,
            'code' => $medicament['code'],
            'libelle' => $medicament['libelle'],
            'tarif' => null,
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
    $medicaments = $MEDICAMENTS->lister(null, strtoupper(conversion_caracteres_speciaux($parametres['libelle'])));
    $json = array();
    foreach ($medicaments as $medicament) {
        $json[] = array(
            'success' => true,
            'value' => $medicament['libelle'],
            'label' => $medicament['libelle'],
            'code' => $medicament['code'],
            'tarif' => null,
            'date_debut' => date('d/m/Y',time())
        );
    }
    flush();
}
echo json_encode($json);