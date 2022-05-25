<?php
header('Content-Type: application/json');
require_once '../../../../Classes/UTILISATEURS.php';
require_once '../../../../Classes/ETABLISSEMENTS.php';
require_once '../../../../Classes/LOCALISATIONSGEOGRAPHIQUES.php';
$LOCALISATIONSGEOGRAPHIQUES = new LOCALISATIONSGEOGRAPHIQUES();
if (isset($_GET['nationnalite'])) {
    $nationnalite = $_GET['nationnalite'];
    $pays = $LOCALISATIONSGEOGRAPHIQUES->lister_pays($nationnalite);
    foreach ($pays as $Pays) {
        if($pays) {
            $json[] = array(
                'value' => $Pays['code'],
                'label' => $Pays['gentile'],
                'date_debut' => date('d/m/Y',time())
            );
        }
    }
    flush();
}
echo json_encode($json);