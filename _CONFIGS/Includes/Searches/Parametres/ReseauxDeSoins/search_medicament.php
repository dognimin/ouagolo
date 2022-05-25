<?php
header('Content-Type: application/json');
require_once '../../../../Classes/UTILISATEURS.php';
require_once '../../../../Classes/MEDICAMENTS.php';
require_once '../../../../Classes/RESEAUXDESOINS.php';
$MEDICAMENTS = new MEDICAMENTS();
$RESEAUXDESOINS = new RESEAUXDESOINS();
if(isset($_POST['code'])) {
    $code = $_POST['code'];
    $code_reseau = $_POST['code_reseau'];
    $medicament = $MEDICAMENTS->trouver_mediacment($code);
    if($medicament) {
        $reseau = $RESEAUXDESOINS->trouver_reseau_medicament(null, $medicament['code']);
        if($reseau) {
            $json = array(
                'success' => false,
                'message' => "Cet médicament appartient déjà au réseau {$reseau['code_reseau']}. Prière le retirer de ce réseau avant de l'ajouter à celui-ci."
            );
        }else {
            $json = array(
                'success' => true,
                'code' => $medicament['code'],
                'libelle' => $medicament['libelle'],
                'date_debut' => date('d/m/Y',time())
            );
        }
    }else {
        $json = array(
            'success' => false,
            'message' => "Aucun médicament ne correspond à votre recherche."
        );
    }
}elseif (isset($_GET['libelle'])) {
    $libelle = $_GET['libelle'];
    $medicaments = $MEDICAMENTS->lister_medicaments($libelle,null);
    foreach ($medicaments as $medicament) {
        $medicaments = $RESEAUXDESOINS->trouver_reseau_medicament(null, $medicament['code']);
        if(!$medicaments) {
            $json[] = array(
                'success' => true,
                'value' => $medicament['code'],
                'label' => $medicament['libelle'],
                'date_debut' => date('d/m/Y',time())
            );
        }
    }
    flush();
}
echo json_encode($json);