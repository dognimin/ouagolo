<?php
header('Content-Type: application/json');
require_once '../../../../Classes/UTILISATEURS.php';
require_once '../../../../Classes/ETABLISSEMENTS.php';
require_once '../../../../Classes/RESEAUXDESOINS.php';
$ETABLISSEMENTS = new ETABLISSEMENTS();
$RESEAUXDESOINS = new RESEAUXDESOINS();
if(isset($_POST['code'])) {
    $code = $_POST['code'];
    $code_reseau = $_POST['code_reseau'];
    $etablissement = $ETABLISSEMENTS->trouver($code,null);
    if($etablissement) {
        $reseau = $RESEAUXDESOINS->trouver_reseau_etablissement(null, $etablissement['code_etablissement']);
        if($reseau) {
            $json = array(
                'success' => false,
                'message' => "Cet établissement appartient déjà au réseau {$reseau['code_reseau']}. Prière le retirer de ce réseau avant de l'ajouter à celui-ci."
            );
        }else {
            $json = array(
                'success' => true,
                'code' => $etablissement['code'],
                'raison_sociale' => $etablissement['raison_sociale'],
                'date_debut' => date('d/m/Y',time())
            );
        }
    }else {
        $json = array(
            'success' => false,
            'message' => "Aucun établissement ne correspond à votre recherche."
        );
    }
}elseif (isset($_GET['raison_sociale'])) {
    $raison_sociale = $_GET['raison_sociale'];
    $etablissements = $ETABLISSEMENTS->lister(null,$raison_sociale);
    foreach ($etablissements as $etablissement) {
        $reseau = $RESEAUXDESOINS->trouver_reseau_etablissement(null, $etablissement['code_etablissement']);
        if(!$reseau) {
            $json[] = array(
                'success' => true,
                'value' => $etablissement['code_etablissement'],
                'label' => $etablissement['raison_sociale'],
                'date_debut' => date('d/m/Y',time())
            );
        }
    }
    flush();
}
echo json_encode($json);