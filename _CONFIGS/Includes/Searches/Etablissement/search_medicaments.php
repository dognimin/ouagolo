<?php
header('Content-Type: application/json');
require_once '../../../Functions/Functions.php';
require_once '../../../Classes/UTILISATEURS.php';
require_once '../../../Classes/MEDICAMENTS.php';
$MEDICAMENTS = new MEDICAMENTS();

if (isset($_POST['code'])) {
    $parametres = array(
        'code' => clean_data($_POST['code'])
    );
    $medicament = $MEDICAMENTS->trouver($parametres['code']);
    if ($medicament) {
        $json = array(
            'success' => true,
            'code' => $medicament['code'],
            'libelle' => $medicament['libelle']
        );
    } else {
        $json = array(
            'success' => false,
            'message' => "Aucun médicament ne correspond à votre recherche."
        );
    }
} elseif (isset($_GET['libelle'])) {
    $parametres = array(
        'libelle' => clean_data($_GET['libelle'])
    );
    $medicaments = $MEDICAMENTS->lister(null, strtoupper(conversion_caracteres_speciaux($parametres['libelle'])));
    foreach ($medicaments as $medicament) {
        $json[] = array(
            'success' => true,
            'value' => $medicament['code'],
            'label' => $medicament['libelle']
        );
    }
    flush();
}
echo json_encode($json);
