<?php

if(isset($_POST)) {
    require_once "../../../../Classes/UTILISATEURS.php";
    require_once "../../../../Functions/Functions.php";
    $parametres = array(
        'code_dci' => clean_data($_POST['code_dci'])
    );

    if(isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if ($session) {
            $utilisateur = $UTILISATEURS->trouver($session['id_user'],null,null);
            if($utilisateur) {
                require_once "../../../../Classes/MEDICAMENTS.php";
                $MEDICAMENTS = new MEDICAMENTS();
                $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, 'RECHERCHE MEDICAMENT DCI', null);
                if ($audit['success'] == true) {
                    $dci = $MEDICAMENTS->trouver_dci($parametres['code_dci']);
                    if($dci) {
                        $dosages = $MEDICAMENTS->lister_dci_dosages($dci['code']);
                        foreach ($dosages as $dosage) {
                            $unites[] = array(
                                'dosage' => $dosage['dosage'].''.$dosage['unite']
                            );
                        }
                        if(count($unites) != 0) {
                            $json = array(
                                'success' => true,
                                'code' => $dci['code'],
                                'code_groupe' => $dci['code_groupe'],
                                'libelle_groupe' => $dci['libelle_groupe'],
                                'code_sous_groupe' => $dci['code_sous_groupe'],
                                'libelle_sous_groupe' => $dci['libelle_sous_groupe'],
                                'code_classe' => $dci['code_classe'],
                                'libelle_classe' => $dci['libelle_classe'],
                                'code_sous_classe' => $dci['code_sous_classe'],
                                'libelle_sous_classe' => $dci['libelle_sous_classe'],
                                'code_forme' => $dci['code_forme'],
                                'libelle_forme' => $dci['libelle_forme'],
                                'dosages' => $unites
                            );
                        }
                    }
                }else {
                    $json = $audit;
                }
            }
        }else {
            $json = array(
                'success' => false,
                'message' => "Aucune session active pour vérifier cette action."
            );
        }
    }else {
        $json = array(
            'success' => false,
            'message' => "Aucune session active pour vérifier cette action."
        );
    }
}else {
    $json = array(
        'success' => false,
        'message' => "Aucun paramètre n'a été défini pour cette action."
    );
}
echo json_encode($json);