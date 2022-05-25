<?php
header('Content-Type: application/json');
require_once '../../../../Classes/UTILISATEURS.php';
require_once '../../../../Classes/ACTESMEDICAUX.php';
require_once '../../../../Classes/RESEAUXDESOINS.php';
$ACTES = new ACTESMEDICAUX();
$RESEAUXDESOINS = new RESEAUXDESOINS();
if(isset($_POST['code'])) {
    $code = $_POST['code'];
    $code_reseau = $_POST['code_reseau'];
    $acte = $ACTES->trouver_acte_medical($code);
    if($acte) {
        $reseau = $RESEAUXDESOINS->trouver_reseau_acte_medicale(null, $acte['code']);
        if($reseau) {
            $json = array(
                'success' => false,
                'message' => "Cet acte médicale appartient déjà au réseau {$reseau['code_reseau']}. Prière le retirer de ce réseau avant de l'ajouter à celui-ci."
            );
        }else {
            $json = array(
                'success' => true,
                'code' => $acte['code'],
                'libelle' => $acte['libelle'],
                'date_debut' => date('d/m/Y',time())
            );
        }
    }else {
        $json = array(
            'success' => false,
            'message' => "Aucun acte médicale ne correspond à votre recherche."
        );
    }
}elseif (isset($_GET['libelle'])) {
    $libelle = $_GET['libelle'];
    $actes = $ACTES->lister_actes_medicaux(null,$libelle);
    foreach ($actes as $acte) {
        $reseau = $RESEAUXDESOINS->trouver_reseau_acte_medicale(null, $acte['code']);
        if(!$reseau) {
            $json[] = array(
                'success' => true,
                'value' => $acte['code'],
                'label' => $acte['libelle'],
                'date_debut' => date('d/m/Y',time())
            );
        }
    }
    flush();
}
echo json_encode($json);