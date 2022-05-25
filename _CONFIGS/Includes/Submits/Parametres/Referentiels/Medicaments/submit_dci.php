<?php
if(isset($_POST)) {
    require_once "../../../../../Classes/UTILISATEURS.php";
    require_once "../../../../../Functions/Functions.php";
    $parametres = array(
        'code_sous_groupe' => clean_data($_POST['code_sous_groupe']),
        'code_sous_classe' => clean_data($_POST['code_sous_classe']),
        'code_forme' => clean_data($_POST['code_forme']),
        'code' => clean_data($_POST['code']),
        'libelle' => clean_data($_POST['libelle']),
        'dosages' => $_POST['dosage'],
        'unites' => $_POST['unite']
    );
    if(isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if ($session) {
            $utilisateur = $UTILISATEURS->trouver($session['id_user'],null);
            if($utilisateur) {
                require_once "../../../../../Classes/MEDICAMENTS.php";
                $MEDICAMENTS = new MEDICAMENTS();
                $dosages = $parametres['dosages'];
                $nb_dosages = count($dosages);

                $unites = $parametres['unites'];
                $nb_unites = count($unites);
                if($nb_dosages == $nb_unites) {
                    $valeurs = array();
                    for ($nb = 0; $nb < $nb_dosages; $nb++) {
                        $valeurs[] = array(
                            'dosage' => $dosages[$nb],
                            'unite' => $unites[$nb]
                        );
                    }
                    $edition = $MEDICAMENTS->editer_dci($parametres['code_sous_groupe'], $parametres['code_sous_classe'], $parametres['code'], strtoupper(conversion_caracteres_speciaux($parametres['libelle'])), $parametres['code_forme'], $utilisateur['id_user']);
                    if($edition['success'] == true) {
                        $nb_edition_dosage = 0;
                        foreach ($valeurs as $valeur) {
                            $edition_dosage = $MEDICAMENTS->editer_dci_dosage($edition['code'], $valeur['dosage'], $valeur['unite'], $utilisateur['id_user']);
                            if($edition_dosage['success'] == true) {
                                $nb_edition_dosage++;
                            }
                        }
                        if($nb_edition_dosage == count($valeurs)) {
                            $audit = $UTILISATEURS->editer_piste_audit($session['code_session'],ACTIVE_URL,'EDITION MEDICAMENT DCI',json_encode($parametres));
                            if($audit['success'] == true) {
                                $json = array(
                                    'success' => true,
                                    'message' => $edition['message']
                                );
                            }else {
                                $json = $audit;
                            }
                        }else {
                            $json = array(
                                'success' => false,
                                'message' => "Une erreur est survenue lors de l'enregistrement de la DCI."
                            );
                        }
                    }else {
                        $json = $edition;
                    }

                }else {
                    $json = array(
                        'success' => false,
                        'message' => "Veuillez vérifier les dosages saisis SVP."
                    );
                }
            }else {
                $json = array(
                    'success' => false,
                    'message' => "Aucun utilisateur identifié pour effectué cette action."
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