<?php
header('Content-Type: application/json');
require_once '../../../../Functions/Functions.php';
require_once '../../../../Classes/UTILISATEURS.php';
require_once '../../../../Classes/MEDICAMENTS.php';
$MEDICAMENTS = new MEDICAMENTS();

if (isset($_GET['libelle'])) {
    $parametres = array(
        'libelle' => strtoupper(conversion_caracteres_speciaux(clean_data($_GET['libelle'])))
    );
    $medicaments = $MEDICAMENTS->lister(null, $parametres['libelle']);
    foreach ($medicaments as $medicament) {
        $json[] = array(
            'success' => true,
            'value' => $medicament['code'],
            'label' => $medicament['libelle']
        );
    }
} else {
    $json = null;
}
echo json_encode($json);
